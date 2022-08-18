<?php
/**
 * AnalyzeFinancialStatement job
 *
 * @author: tuanha
 * @date: 10-Aug-2022
 */
namespace App\Jobs;

use Exception;
use App\Events\JobFailing;
use Illuminate\Bus\Queueable;
use App\Jobs\Financials\Capex;
use App\Models\AnalysisReport;
use App\Jobs\Financials\CashFlow;
use App\Models\FinancialStatement;
use App\Services\Contracts\Symbols;
use Illuminate\Queue\SerializesModels;
use App\Jobs\Financials\LiquidityWriter;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\Financials\ProfitabilityWriter;
use App\Jobs\Financials\OperatingEffectiveness;
use App\Events\AnalyzeFinancialStatementCompleted;
use App\Jobs\Financials\Calculators\LiquidityCalculator;
use App\Jobs\Financials\Calculators\ProfitabilityCalculator;

class AnalyzeFinancialStatement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, ProfitabilityWriter, LiquidityWriter, CashFlow, Capex, OperatingEffectiveness;

    /**
     * @var \Bkstar123\BksCMS\AdminPanel\Admin
     */
    protected $user;

    /**
     * @var integer
     */
    protected $financialStatementID;

    /**
     * @var array
     */
    protected $content = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($financialStatementID, $user)
    {
        $this->financialStatementID = $financialStatementID;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Symbols $symbols)
    {
        $financialStatement = FinancialStatement::find($this->financialStatementID);
        if (!empty($financialStatement)) {
            $fundamentals = $symbols->getFundamentals($financialStatement->symbol);
            if (!empty($fundamentals)) {
                $companyType = (int) json_decode($fundamentals, true)['companyType'];
                switch ($companyType) {
                    case 1:
                        throw new Exception('Kstock does not support analyzing financial statements of banking institutions');
                        break;
                    case 2:
                        throw new Exception('Kstock does not support analyzing financial statements of securities companies');
                        break;
                    case 3:
                        throw new Exception('Kstock does not support analyzing financial statements of Fundings');
                        break;
                    case 4:
                        throw new Exception('Kstock does not support analyzing financial statements of Insurance companies');
                        break;
                    default:
                        # code...
                        break;
                }
            }  
            // Profitability Ratios
            $profitabilityCalculator = (new ProfitabilityCalculator($financialStatement))->execute();
            $this->writeROAA($profitabilityCalculator)
                 ->writeROCE($profitabilityCalculator)
                 ->writeROEA($profitabilityCalculator)
                 ->writeROS($profitabilityCalculator)
                 ->writeEBITDAMargin($profitabilityCalculator)
                 ->writeEBITMargin($profitabilityCalculator)
                 ->writeGrossProfitMargin($profitabilityCalculator);
            // Liquidity/Solvency Ratios
            $liquidityCalculator = (new LiquidityCalculator($financialStatement))->execute();     
            $this->writeOverallSolvencyRatio($liquidityCalculator)
                 ->writeCurrentRatio($liquidityCalculator)
                 ->writeQuickRatio($liquidityCalculator)
                 ->writeQuickRatio2($liquidityCalculator)
                 ->writeCashRatio($liquidityCalculator)
                 ->writeInterestCoverageRatio($liquidityCalculator);
            // Cash Flow Ratios
            $this->calculateLiabilityCoverageRatioByCFO($financialStatement)
                 ->calculateCurrentLiabilityCoverageRatioByCFO($financialStatement)
                 ->calculateLongTermLiabilityCoverageRatioByCFO($financialStatement)
                 ->calculateCFOPerRevenue($financialStatement)
                 ->calculateFCFPerRevenue($financialStatement)
                 ->calculateLiabilityCoverageRatioByFCF($financialStatement)
                 ->calculateCurrentLiabilityCoverageRatioByFCF($financialStatement)
                 ->calculateLongTermLiabilityCoverageRatioByFCF($financialStatement)
                 ->calculateInterestCoverageRatioByFCF($financialStatement)
                 ->calculateAssetEfficencyForFCFRatio($financialStatement)
                 ->calculateCashGeneratingPowerRatio($financialStatement)
                 ->calculateExternalFinancingRatio($financialStatement);
            // CAPEX
            $this->calculateCfoToCapexRatio($financialStatement)
                 ->calculateCapexToNetProfitRatio($financialStatement);
            // Operating effectiveness
            $this->calculateReceivableTurnoverRatio($financialStatement)
                 ->calculateInventoryTurnoverRatio($financialStatement)
                 ->calculateAccountsPayableTurnoverRatio($financialStatement)
                 ->calculateCashConversionCycle($financialStatement);
            AnalysisReport::create([
                'content' => json_encode($this->content),
                'financial_statement_id' => $this->financialStatementID
            ]);
            AnalyzeFinancialStatementCompleted::dispatch($this->user);
        }
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        JobFailing::dispatch($this->user, $exception->getMessage());
    }
}
