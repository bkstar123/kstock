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

    public $sellingExpenseToRevenueRatio = null; //Hệ số giá vốn bán hàng / doanh thu thuần

    public $administrationExpenseToRevenueRatio = null; //Hệ số chi phí quản lý doanh nghiệp / doanh thu thuần

    public $interestCostToRevenueRatio = null; //Hệ số chi phí chi phí lãi vay / doanh thu thuần

    /**
     * Calculate Cost of goods sale / Revenue Ratio
     *
     * @return \App\Jobs\Financials\Calculators\CostStructureCalculator $this
     */
    public function calculateCOGSToRevenueRatio()
    {
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $cogs = $this->financialStatement->income_statement->getItem('4')->getValue($selectedYear, $selectedQuarter);
            $revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            ;
            if ($revenue != 0) {
                $this->cOGSToRevenueRatio = round(100 * $cogs / $revenue, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate Selling Expense / Revenue Ratio
     *
     * @return \App\Jobs\Financials\Calculators\CostStructureCalculator $this
     */
    public function calculateSellingExpenseToRevenueRatio()
    {
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $selling_expenses = $this->financialStatement->income_statement->getItem('9')->getValue($selectedYear, $selectedQuarter);
            $revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            ;
            if ($revenue != 0) {
                $this->sellingExpenseToRevenueRatio = round(100 * $selling_expenses / $revenue, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate Administration Expense / Revenue Ratio
     *
     * @return \App\Jobs\Financials\Calculators\CostStructureCalculator $this
     */
    public function calculateAdministrationExpenseToRevenueRatio()
    {
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $administration_expenses = $this->financialStatement->income_statement->getItem('10')->getValue($selectedYear, $selectedQuarter);
            $revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            ;
            if ($revenue != 0) {
                $this->administrationExpenseToRevenueRatio = round(100 * $administration_expenses / $revenue, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate Interest Cost / Revenue Ratio
     *
     * @return \App\Jobs\Financials\Calculators\CostStructureCalculator $this
     */
    public function calculateInterestCostToRevenueRatio()
    {
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $interest_cost = $this->financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
            $revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            ;
            if ($revenue != 0) {
                $this->interestCostToRevenueRatio = round(100 * $interest_cost / $revenue, 2);
            }
        }
        return $this;
    }
}
