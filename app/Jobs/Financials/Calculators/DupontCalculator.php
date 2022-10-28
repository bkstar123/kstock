<?php
/**
 * DupontCalculator
 *
 * @author: tuanha
 * @date: 27-Aug-2022
 */
namespace App\Jobs\Financials\Calculators;

use App\Jobs\Financials\Calculators\BaseCalculator;
use App\Jobs\Financials\Calculators\ProfitabilityCalculator;
use App\Jobs\Financials\Calculators\FinancialLeverageCalculator;
use App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator;

class DupontCalculator extends BaseCalculator
{
    public $roaa = null; // Ti suat sinh loi cua tong tai san binh quan

    public $averageFinancialLeverage = null; // He so don bay tai chinh binh quan

    public $ros2 = null; // Ti suat loi nhuan rong co dong cong ty me

    public $averageTotalAssetTurnOver = null; // Vong quay tong tai san binh quan

    public $earningAfterTaxParentCompanyToEarningBeforeTax = null; // LNST co dong cong ty me / LNTT

    public $earningAfterTaxToEarningBeforeTax = null; // LNST / LNTT

    public $earningBeforeTaxToEBIT = null; // Loi nhuan truoc thue / EBIT

    public $ebitMargin = null; // Ti suat EBIT tren doanh thu thuan

    public $roea = null; //Ti suat sinh loi tren VCSH binh quan

    /**
     * Calculate Dupont components
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\DupontCalculator $this
     */
    public function calculateDupontComponents($year = null, $quarter = null)
    {
        if (!empty($this->financialStatement->balance_statement) && !empty($this->financialStatement->income_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $profitabilityCalculator = new ProfitabilityCalculator($this->financialStatement);
            $financialLeverageCalculator = new FinancialLeverageCalculator($this->financialStatement);
            $operatingEffectivenessCalculator = new OperatingEffectivenessCalculator($this->financialStatement);
            $this->roaa = $profitabilityCalculator->calculateROAA($selectedYear, $selectedQuarter)->roaa;
            $this->averageFinancialLeverage = $financialLeverageCalculator->calculateAverageTotalAssetToAverageEquityRatio($selectedYear, $selectedQuarter)->averageTotalAssetToAverageEquityRatio;
            $this->ros2 = $profitabilityCalculator->calculateROS2($selectedYear, $selectedQuarter)->ros2;
            $this->ebitMargin = $profitabilityCalculator->calculateEBITMargin($selectedYear, $selectedQuarter)->ebitMargin;
            $this->averageTotalAssetTurnOver = $operatingEffectivenessCalculator->calculateTotalAssetTurnoverRatio($selectedYear, $selectedQuarter)->totalAssetTurnoverRatio;
            $earningBeforeTax = $this->financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter);
            $earningAfterTaxParentCompany = $this->financialStatement->income_statement->getItem('21')->getValue($selectedYear, $selectedQuarter);
            $earningAfterTax = $this->financialStatement->income_statement->getItem('19')->getValue($selectedYear, $selectedQuarter);
            if ($earningBeforeTax != 0) {
                $this->earningAfterTaxParentCompanyToEarningBeforeTax = round($earningAfterTaxParentCompany / $earningBeforeTax, 4);
                $this->earningAfterTaxToEarningBeforeTax = round($earningAfterTax / $earningBeforeTax, 4);
            }
            $eBIT = $this->financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
            if ($eBIT != 0) {
                $this->earningBeforeTaxToEBIT = round($earningBeforeTax / $eBIT, 4);
            }
            $this->roea = round($this->roaa * $this->averageFinancialLeverage, 2);
        }
        return $this;
    }
}
