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
use App\Jobs\Financials\Liquidity;
use App\Models\FinancialStatement;
use App\Services\Contracts\Symbols;
use App\Jobs\Financials\Profitability;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Events\AnalyzeFinancialStatementCompleted;

class AnalyzeFinancialStatement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Profitability, Liquidity, CashFlow, Capex;

    /**
     * @var \Bkstar123\BksCMS\AdminPanel\Admin
     */
    public $user;

    /**
     * @var integer
     */
    public $financialStatementID;

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
            $this->calculateROAA($financialStatement)
                 ->calculateROCE($financialStatement)
                 ->calculateROEA($financialStatement)
                 ->calculateROS($financialStatement)
                 ->calculateEBITDAPerSales($financialStatement)
                 ->calculateEBITPerSales($financialStatement)
                 ->calculateGrossProfitMargin($financialStatement);
            // Liquidity/Solvency Ratios
            $this->calculateAssetsToLiabilitiesRatio($financialStatement)
                 ->calculateCurrentRatio($financialStatement)
                 ->calculateQuickRatio($financialStatement)
                 ->calculateQuickRatio2($financialStatement)
                 ->calculateCashRatio($financialStatement)
                 ->calculateInterestCoverageRatio($financialStatement);
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
