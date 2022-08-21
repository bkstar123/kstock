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
use App\Models\AnalysisReport;
use App\Models\FinancialStatement;
use App\Services\Contracts\Symbols;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\Financials\Writers\CapexWriter;
use App\Jobs\Financials\Writers\CashFlowWriter;
use App\Jobs\Financials\Writers\LiquidityWriter;
use App\Events\AnalyzeFinancialStatementCompleted;
use App\Jobs\Financials\Calculators\CapexCalculator;
use App\Jobs\Financials\Writers\ProfitabilityWriter;
use App\Jobs\Financials\Calculators\CashFlowCalculator;
use App\Jobs\Financials\Calculators\LiquidityCalculator;
use App\Jobs\Financials\Writers\FinancialLeverageWriter;
use App\Jobs\Financials\Calculators\ProfitabilityCalculator;
use App\Jobs\Financials\Writers\OperatingEffectivenessWriter;
use App\Jobs\Financials\Calculators\FinancialLeverageCalculator;
use App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator;

class AnalyzeFinancialStatement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, ProfitabilityWriter, LiquidityWriter, CashFlowWriter, CapexWriter, OperatingEffectivenessWriter, FinancialLeverageWriter;

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
            $cashFlowCalculator = (new CashFlowCalculator($financialStatement))->execute();
            $this->writeLiabilityCoverageRatioByCFO($cashFlowCalculator)
                 ->writeCurrentLiabilityCoverageRatioByCFO($cashFlowCalculator)
                 ->writeLongTermLiabilityCoverageRatioByCFO($cashFlowCalculator)
                 ->writeCFOToRevenue($cashFlowCalculator)
                 ->writeFCFToRevenue($cashFlowCalculator)
                 ->writeLiabilityCoverageRatioByFCF($cashFlowCalculator)
                 ->writeCurrentLiabilityCoverageRatioByFCF($cashFlowCalculator)
                 ->writeLongTermLiabilityCoverageRatioByFCF($cashFlowCalculator)
                 ->writeInterestCoverageRatioByFCF($cashFlowCalculator)
                 ->writeAssetEfficencyForFCFRatio($cashFlowCalculator)
                 ->writeCashGeneratingPowerRatio($cashFlowCalculator)
                 ->writeExternalFinancingRatio($cashFlowCalculator);
            // CAPEX
            $capexCalculator = (new CapexCalculator($financialStatement))->execute();
            $this->writeCfoToCapexRatio($capexCalculator)
                 ->writeCapexToNetProfitRatio($capexCalculator);
            // Operating effectiveness
            $operatingEffectivenessCalculator = (new OperatingEffectivenessCalculator($financialStatement))->execute();
            $this->writeReceivableTurnoverRatio($operatingEffectivenessCalculator)
                 ->writeInventoryTurnoverRatio($operatingEffectivenessCalculator)
                 ->writeAccountsPayableTurnoverRatio($operatingEffectivenessCalculator)
                 ->writeCashConversionCycle($operatingEffectivenessCalculator)
                 ->writeFixedAssetTurnoverRatio($operatingEffectivenessCalculator)
                 ->writeTotalAssetTurnoverRatio($operatingEffectivenessCalculator)
                 ->writeEquityTurnoverRatio($operatingEffectivenessCalculator);
            // Financial Leverage
            $financialLeverageCalculator = (new FinancialLeverageCalculator($financialStatement))->execute();
            $this->writeShortTermToTotalLiabilitiesRatio($financialLeverageCalculator)
                 ->writeTotalDebtToTotalAssetRatio($financialLeverageCalculator)
                 ->writeTotalLiabilityToTotalAssetRatio($financialLeverageCalculator)
                 ->writeTotalAssetToEquityRatio($financialLeverageCalculator)
                 ->writeTotalDebtToTotalLiabilityRatio($financialLeverageCalculator)
                 ->writeCurrentDebtToTotalDebtRatio($financialLeverageCalculator);
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
