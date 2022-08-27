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
    public $roaa = null;

    public $averageFinancialLeverage = null;

    public $ros = null;

    public $averageTotalAssetTurnOver = null;

    public $earningAfterTaxToEarningBeforeTax = null;

    public $earningBeforeTaxToEBIT = null;

    public $ebitMargin = null;

    /**
     * Calculate Dupont components
     *
     * @return \App\Jobs\Financials\Calculators\DupontCalculator $this
     */
    public function calculateDupontComponents()
    {
        if (!empty($this->financialStatement->balance_statement) && !empty($this->financialStatement->income_statement)) {
            $profitabilityCalculator = new ProfitabilityCalculator($this->financialStatement);
            $financialLeverageCalculator = new FinancialLeverageCalculator($this->financialStatement);
            $operatingEffectivenessCalculator = new OperatingEffectivenessCalculator($this->financialStatement);
            $this->roaa = $profitabilityCalculator->calculateROAA()->roaa;
            $this->averageFinancialLeverage = $financialLeverageCalculator->calculateAverageTotalAssetToAverageEquityRatio()->averageTotalAssetToAverageEquityRatio;
            $this->ros = $profitabilityCalculator->calculateROS2()->ros2;
            $this->ebitMargin = $profitabilityCalculator->calculateEBITMargin()->ebitMargin;
            $this->averageTotalAssetTurnOver = $operatingEffectivenessCalculator->calculateTotalAssetTurnoverRatio()->totalAssetTurnoverRatio;
        }
        return $this;
    }
}
