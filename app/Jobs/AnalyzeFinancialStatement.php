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
use App\Jobs\Financials\Writers\DupontWriter;
use App\Jobs\Financials\Writers\GrowthWriter;
use App\Jobs\Financials\Writers\CashFlowWriter;
use App\Jobs\Financials\Writers\LiquidityWriter;
use App\Events\AnalyzeFinancialStatementCompleted;
use App\Jobs\Financials\Calculators\CapexCalculator;
use App\Jobs\Financials\Writers\CostStructureWriter;
use App\Jobs\Financials\Writers\ProfitabilityWriter;
use App\Jobs\Financials\Calculators\DupontCalculator;
use App\Jobs\Financials\Calculators\GrowthCalculator;
use App\Jobs\Financials\Writers\ProfitStructureWriter;
use App\Jobs\Financials\Calculators\CashFlowCalculator;
use App\Jobs\Financials\Calculators\LiquidityCalculator;
use App\Jobs\Financials\Writers\FinancialLeverageWriter;
use App\Jobs\Financials\Calculators\CostStructureCalculator;
use App\Jobs\Financials\Calculators\ProfitabilityCalculator;
use App\Jobs\Financials\Writers\CurrentAssetStructureWriter;
use App\Jobs\Financials\Writers\LongTermAssetStructureWriter;
use App\Jobs\Financials\Writers\OperatingEffectivenessWriter;
use App\Jobs\Financials\Calculators\ProfitStructureCalculator;
use App\Jobs\Financials\Calculators\FinancialLeverageCalculator;
use App\Jobs\Financials\Calculators\CurrentAssetStructureCalculator;
use App\Jobs\Financials\Calculators\LongTermAssetStructureCalculator;
use App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator;

class AnalyzeFinancialStatement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, ProfitabilityWriter, LiquidityWriter, CashFlowWriter, CapexWriter, OperatingEffectivenessWriter, FinancialLeverageWriter, CostStructureWriter, CurrentAssetStructureWriter, LongTermAssetStructureWriter, GrowthWriter, DupontWriter, ProfitStructureWriter;

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
                 ->writeROA($profitabilityCalculator)
                 ->writeROCE($profitabilityCalculator)
                 ->writeROEA($profitabilityCalculator)
                 ->writeROE($profitabilityCalculator)
                 ->writeROS($profitabilityCalculator)
                 ->writeROS2($profitabilityCalculator)
                 ->writeEBITDAMargin1($profitabilityCalculator)
                 ->writeEBITDAMargin2($profitabilityCalculator)
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
            $this->writeTotalLiabilityToTotalAssetRatio($financialLeverageCalculator)
                 ->writeTotalDebtToTotalAssetRatio($financialLeverageCalculator)
                 ->writeShortTermToTotalLiabilitiesRatio($financialLeverageCalculator)
                 ->writeTotalDebtToTotalLiabilityRatio($financialLeverageCalculator)
                 ->writeCurrentDebtToTotalDebtRatio($financialLeverageCalculator)
                 ->writeLongTermDebtToLongTermLiabilityRatio($financialLeverageCalculator)
                 ->writeCurrentDebtToCurrentLiabilityRatio($financialLeverageCalculator)
                 ->writeInterestExpenseToAverageDebtRatio($financialLeverageCalculator)
                 ->writeDebtToEquityRatio($financialLeverageCalculator)
                 ->writeLongTermDebtToEquityRatio($financialLeverageCalculator)
                 ->writeTotalAssetToEquityRatio($financialLeverageCalculator)
                 ->writeAverageTotalAssetToAverageEquityRatio($financialLeverageCalculator);
            // Cost Structure
            $costStructureCalculator = (new CostStructureCalculator($financialStatement))->execute();
            $this->writeCOGSToRevenueRatio($costStructureCalculator)
                 ->writeSellingExpenseToRevenueRatio($costStructureCalculator)
                 ->writeAdministrationExpenseToRevenueRatio($costStructureCalculator)
                 ->writeInterestCostToRevenueRatio($costStructureCalculator)
                 ->writeSellingAndEnperpriseManagementToGrossProfitRatio($costStructureCalculator);
            // Current Asset Structure
            $currentAssetStructureCalculator = (new CurrentAssetStructureCalculator($financialStatement))->execute();
            $this->writeCurrentAssetToTotalAssetRatio($currentAssetStructureCalculator)
                 ->writeCashToCurrentAssetRatio($currentAssetStructureCalculator)
                 ->writeCurrentFinancialInvestingToCurrentAssetRatio($currentAssetStructureCalculator)
                 ->writeCurrentReceivableAccountToCurrentAssetRatio($currentAssetStructureCalculator)
                 ->writeInventoryToCurrentAssetRatio($currentAssetStructureCalculator)
                 ->calculateOtherCurrentAssetToCurrentAssetRatio($currentAssetStructureCalculator);
            // Long Term Asset Structure
            $longTermAssetStructureCalculator = (new LongTermAssetStructureCalculator($financialStatement))->execute();
            $this->writeLongTermAssetToTotalAssetRatio($longTermAssetStructureCalculator)
                 ->writeFixedAssetToTotalAssetRatio($longTermAssetStructureCalculator)
                 ->writeTangibleFixedAssetToFixedAssetRatio($longTermAssetStructureCalculator)
                 ->writeFinancialLendingAssetToFixedAssetRatio($longTermAssetStructureCalculator)
                 ->writeIntangibleAssetToFixedAssetRatio($longTermAssetStructureCalculator)
                 ->writeConstructionInProgressToFixedAssetRatio($longTermAssetStructureCalculator);
            // Profit Structure
            $profitStructureCalculator = (new ProfitStructureCalculator($financialStatement))->execute();
            $this->writeOperatingProfitToEBTRatio($profitStructureCalculator);
            // Growth
            $growthCalculator = (new GrowthCalculator($financialStatement))->execute();
            $this->writeRevenueGrowth($growthCalculator)
                 ->writeInventoryGrowth($growthCalculator)
                 ->writeGrossProfitGrowth($growthCalculator)
                 ->writeEBTGrowth($growthCalculator)
                 ->writeNetProfitOfParentShareHolderGrowth($growthCalculator)
                 ->writeTotalAssetGrowth($growthCalculator)
                 ->writeLongTermLiabilityGrowth($growthCalculator)
                 ->writeLiabilityGrowth($growthCalculator)
                 ->writeEquityGrowth($growthCalculator)
                 ->writeCharterCapitalGrowth($growthCalculator);
            //Dupont Analysis
            $dupontCalculator = (new DupontCalculator($financialStatement))->execute();
            $this->writeDupontLevel2Components($dupontCalculator)
                 ->writeDupontLevel3Components($dupontCalculator)
                 ->writeDupontLevel5Components($dupontCalculator);
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
