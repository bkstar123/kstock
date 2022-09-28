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
use App\Jobs\Financials\Writers\MScoreWriter;
use App\Jobs\Financials\Writers\ZScoreWriter;
use App\Jobs\Financials\Writers\CashFlowWriter;
use App\Jobs\Financials\Writers\LiquidityWriter;
use App\Events\AnalyzeFinancialStatementCompleted;
use App\Jobs\Financials\Calculators\CapexCalculator;
use App\Jobs\Financials\Writers\CostStructureWriter;
use App\Jobs\Financials\Writers\ProfitabilityWriter;
use App\Jobs\Financials\Calculators\DupontCalculator;
use App\Jobs\Financials\Calculators\GrowthCalculator;
use App\Jobs\Financials\Calculators\MScoreCalculator;
use App\Jobs\Financials\Calculators\ZScoreCalculator;
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
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, ProfitabilityWriter, LiquidityWriter, CashFlowWriter, CapexWriter, OperatingEffectivenessWriter, FinancialLeverageWriter, CostStructureWriter, CurrentAssetStructureWriter, LongTermAssetStructureWriter, GrowthWriter, DupontWriter, ProfitStructureWriter, ZScoreWriter, MScoreWriter;

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
            // Z-Score
            $zScoreCalculator = new ZScoreCalculator($financialStatement);
            $this->writeZScore($zScoreCalculator, $financialStatement->year, $financialStatement->quarter);
            //M M-Score
            $mScoreCalculator = new MScoreCalculator($financialStatement);
            $this->writeMScore($mScoreCalculator, $financialStatement->year, $financialStatement->quarter);
            // Profitability Ratios
            $profitabilityCalculator = new ProfitabilityCalculator($financialStatement);
            $this->writeROAA($profitabilityCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeROA($profitabilityCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeROTA($profitabilityCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeROCE($profitabilityCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeROEA($profitabilityCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeROE($profitabilityCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeROS($profitabilityCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeROS2($profitabilityCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeEBITDAMargin1($profitabilityCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeEBITDAMargin2($profitabilityCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeEBITMargin($profitabilityCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeGrossProfitMargin($profitabilityCalculator, $financialStatement->year, $financialStatement->quarter);
            // Liquidity/Solvency Ratios
            $liquidityCalculator = new LiquidityCalculator($financialStatement);
            $this->writeOverallSolvencyRatio($liquidityCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeCurrentRatio($liquidityCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeQuickRatio($liquidityCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeQuickRatio2($liquidityCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeCashRatio($liquidityCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeInterestCoverageRatio($liquidityCalculator, $financialStatement->year, $financialStatement->quarter);
            // Cash Flow Ratios
            $cashFlowCalculator = new CashFlowCalculator($financialStatement);
            $this->writeLiabilityCoverageRatioByCFO($cashFlowCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeCurrentLiabilityCoverageRatioByCFO($cashFlowCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeLongTermLiabilityCoverageRatioByCFO($cashFlowCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeCFOToRevenue($cashFlowCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeFCFToRevenue($cashFlowCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeFCFToCFO($cashFlowCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeLiabilityCoverageRatioByFCF($cashFlowCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeCurrentLiabilityCoverageRatioByFCF($cashFlowCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeLongTermLiabilityCoverageRatioByFCF($cashFlowCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeInterestCoverageRatioByFCF($cashFlowCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeAssetEfficencyForFCFRatio($cashFlowCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeCashGeneratingPowerRatio($cashFlowCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeExternalFinancingRatio($cashFlowCalculator, $financialStatement->year, $financialStatement->quarter);
            // CAPEX
            $capexCalculator = new CapexCalculator($financialStatement);
            $this->writeCfoToCapexRatio($capexCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeCapexToNetProfitRatio($capexCalculator, $financialStatement->year, $financialStatement->quarter);
            // Operating effectiveness
            $operatingEffectivenessCalculator = new OperatingEffectivenessCalculator($financialStatement);
            $this->writeReceivableTurnoverRatio($operatingEffectivenessCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeInventoryTurnoverRatio($operatingEffectivenessCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeAccountsPayableTurnoverRatio($operatingEffectivenessCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeCashConversionCycle($operatingEffectivenessCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeFixedAssetTurnoverRatio($operatingEffectivenessCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeTotalAssetTurnoverRatio($operatingEffectivenessCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeEquityTurnoverRatio($operatingEffectivenessCalculator, $financialStatement->year, $financialStatement->quarter);
            // Financial Leverage
            $financialLeverageCalculator = new FinancialLeverageCalculator($financialStatement);
            $this->writeTotalLiabilityToTotalAssetRatio($financialLeverageCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeTotalDebtToTotalAssetRatio($financialLeverageCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeShortTermToTotalLiabilitiesRatio($financialLeverageCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeTotalDebtToTotalLiabilityRatio($financialLeverageCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeCurrentDebtToTotalDebtRatio($financialLeverageCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeLongTermDebtToLongTermLiabilityRatio($financialLeverageCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeCurrentDebtToCurrentLiabilityRatio($financialLeverageCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeInterestExpenseToAverageDebtRatio($financialLeverageCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeDebtToEquityRatio($financialLeverageCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeNetDebtToEquityRatio($financialLeverageCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeLongTermDebtToEquityRatio($financialLeverageCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeTotalAssetToEquityRatio($financialLeverageCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeAverageTotalAssetToAverageEquityRatio($financialLeverageCalculator, $financialStatement->year, $financialStatement->quarter);
            // Cost Structure
            $costStructureCalculator = new CostStructureCalculator($financialStatement);
            $this->writeCOGSToRevenueRatio($costStructureCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeSellingExpenseToRevenueRatio($costStructureCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeAdministrationExpenseToRevenueRatio($costStructureCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeInterestCostToRevenueRatio($costStructureCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeSellingAndEnperpriseManagementToGrossProfitRatio($costStructureCalculator, $financialStatement->year, $financialStatement->quarter);
            // Current Asset Structure
            $currentAssetStructureCalculator = new CurrentAssetStructureCalculator($financialStatement);
            $this->writeCurrentAssetToTotalAssetRatio($currentAssetStructureCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeCashToCurrentAssetRatio($currentAssetStructureCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeCurrentFinancialInvestingToCurrentAssetRatio($currentAssetStructureCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeCurrentReceivableAccountToCurrentAssetRatio($currentAssetStructureCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeInventoryToCurrentAssetRatio($currentAssetStructureCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->calculateOtherCurrentAssetToCurrentAssetRatio($currentAssetStructureCalculator, $financialStatement->year, $financialStatement->quarter);
            // Long Term Asset Structure
            $longTermAssetStructureCalculator = new LongTermAssetStructureCalculator($financialStatement);
            $this->writeLongTermAssetToTotalAssetRatio($longTermAssetStructureCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeLongTermReceivableToLongTermAssetRatio($longTermAssetStructureCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeFixedAssetToLongTermAssetRatio($longTermAssetStructureCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeTangibleFixedAssetToFixedAssetRatio($longTermAssetStructureCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeFinancialLendingAssetToFixedAssetRatio($longTermAssetStructureCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeIntangibleAssetToFixedAssetRatio($longTermAssetStructureCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeInvestingRealEstateToLongTermAssetRatio($longTermAssetStructureCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeConstructionInProgressToLongTermAssetRatio($longTermAssetStructureCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeLongTermFinancialInvestingToLongTermRatio($longTermAssetStructureCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeOtherLongTermAssetToLongTermRatio($longTermAssetStructureCalculator, $financialStatement->year, $financialStatement->quarter);
            // Profit Structure
            $profitStructureCalculator = new ProfitStructureCalculator($financialStatement);
            $this->writeOperatingProfitToEBTRatio($profitStructureCalculator, $financialStatement->year, $financialStatement->quarter);
            // Growth
            $growthCalculator = new GrowthCalculator($financialStatement);
            $this->writeRevenueGrowth($growthCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeInventoryGrowth($growthCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeCogsGrowth($growthCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeGrossProfitGrowth($growthCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeOperationExpenseGrowth($growthCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeInterestExpenseGrowth($growthCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeEBTGrowth($growthCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeNetProfitOfParentShareHolderGrowth($growthCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeTotalAssetGrowth($growthCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeLongTermLiabilityGrowth($growthCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeLiabilityGrowth($growthCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeDebtGrowth($growthCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeEquityGrowth($growthCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeCharterCapitalGrowth($growthCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeFcfGrowth($growthCalculator, $financialStatement->year, $financialStatement->quarter);
            //Dupont Analysis
            $dupontCalculator = new DupontCalculator($financialStatement);
            $this->writeDupontLevel2Components($dupontCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeDupontLevel3Components($dupontCalculator, $financialStatement->year, $financialStatement->quarter)
                 ->writeDupontLevel5Components($dupontCalculator, $financialStatement->year, $financialStatement->quarter);
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
