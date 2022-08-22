<?php
/**
 * CostStructureCalculator
 *
 * @author: tuanha
 * @date: 23-Aug-2022
 */
namespace App\Jobs\Financials\Calculators;

use App\Jobs\Financials\Calculators\BaseCalculator;

class CostStructureCalculator extends BaseCalculator
{
    public $cOGSToRevenueRatio = null; //Hệ số giá vốn bán hàng / doanh thu thuần
    /**
     * Calculate Capex/Net Profit Ratio
     *
     * @return \App\Jobs\Financials\Calculators\CapexCalculator $this
     */
    public function calculateCOGSToRevenueRatio()
    {
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $cogs = $this->financialStatement->income_statement->getItem('4')->getValue($selectedYear, $selectedQuarter);
            $revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);;
            if ($revenue != 0) {
                $this->cOGSToRevenueRatio = round(100 * $cogs / $revenue, 2);
            }
        }
        return $this;
    }
}
