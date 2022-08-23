<?php
/**
 * CostStructureWriter trait
 *
 * @author: tuanha
 * @date: 14-Aug-2022
 */
namespace App\Jobs\Financials\Writers;

use App\Jobs\Financials\Calculators\CostStructureCalculator;

trait CostStructureWriter
{
    /**
     * Write CFO/CAPEX Ratio
     *
     * @param \App\Jobs\Financials\Calculators\CostStructureCalculator $calculator
     * @return $this
     */
    protected function writeCOGSToRevenueRatio(CostStructureCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Giá vốn bán hàng / Doanh thu thuần',
            'alias' => 'cogs/revenue',
            'group' => 'Chỉ số Cơ cấu chi phí',
            'unit' => '%',
            'description' => 'Chỉ số này cho biết giá vốn bán hàng chiếm tỉ trọng bao nhiêu trong doanh thu thuần',
            'value' => $calculator->cOGSToRevenueRatio
        ]);
        return $this;
    }

    /**
     * Write Selling Expense / Revenue Ratio
     *
     * @param \App\Jobs\Financials\Calculators\CostStructureCalculator $calculator
     * @return $this
     */
    public function writeSellingExpenseToRevenueRatio(CostStructureCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Chi phí bán hàng / Doanh thu thuần',
            'alias' => 'selling expense/revenue',
            'group' => 'Chỉ số Cơ cấu chi phí',
            'unit' => '%',
            'description' => 'Chỉ số này cho biết chi phí bán hàng chiếm tỉ trọng bao nhiêu trong doanh thu thuần',
            'value' => $calculator->sellingExpenseToRevenueRatio
        ]);
        return $this;
    }

    /**
     * Write Administration Expense / Revenue Ratio
     *
     * @param \App\Jobs\Financials\Calculators\CostStructureCalculator $calculator
     * @return $this
     */
    public function writeAdministrationExpenseToRevenueRatio(CostStructureCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Chi phí quản lý doanh nghiệp / doanh thu thuần',
            'alias' => 'administration expense/revenue',
            'group' => 'Chỉ số Cơ cấu chi phí',
            'unit' => '%',
            'description' => 'Chỉ số này cho biết chi phí quản lý doanh nghiệp chiếm tỉ trọng bao nhiêu trong doanh thu thuần',
            'value' => $calculator->administrationExpenseToRevenueRatio
        ]);
        return $this;
    }

    /**
     * Write Interest Cost / Revenue Ratio
     *
     * @param \App\Jobs\Financials\Calculators\CostStructureCalculator $calculator
     * @return $this
     */
    public function writeInterestCostToRevenueRatio(CostStructureCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Chi phí lãi vay / doanh thu thuần',
            'alias' => 'Interest cost/revenue',
            'group' => 'Chỉ số Cơ cấu chi phí',
            'unit' => '%',
            'description' => 'Chỉ số này cho biết chi phí lãi vay chiếm tỉ trọng bao nhiêu trong doanh thu thuần',
            'value' => $calculator->interestCostToRevenueRatio
        ]);
        return $this;
    }
}
