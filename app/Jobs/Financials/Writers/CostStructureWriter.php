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
            'alias' => 'Cogs/Revenue',
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
            'alias' => 'Selling Expense/Revenue',
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
            'alias' => 'Administration Expense/Revenue',
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
            'alias' => 'Interest cost/Revenue',
            'group' => 'Chỉ số Cơ cấu chi phí',
            'unit' => '%',
            'description' => 'Chỉ số này cho biết chi phí lãi vay chiếm tỉ trọng bao nhiêu trong doanh thu thuần',
            'value' => $calculator->interestCostToRevenueRatio
        ]);
        return $this;
    }

    /**
     * Write Selling & Enterprise Management Expenses To Gross Profit Ratio
     *
     * @param \App\Jobs\Financials\Calculators\CostStructureCalculator $calculator
     * @return $this
     */
    public function writeSellingAndEnperpriseManagementToGrossProfitRatio(CostStructureCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Chi phí bán hàng & Chi phí QLDN / Lợi nhuận gộp',
            'alias' => 'Selling and Enterprise Management Expenses/Gross Profit',
            'group' => 'Chỉ số Cơ cấu chi phí',
            'unit' => '%',
            'description' => 'Chỉ số này cho biết chi phí lãi vay chiếm tỉ trọng bao nhiêu trong doanh thu thuần. Chỉ số này cho biết chi phí bán hàng và quản lý doanh nghiệp chiếm tỷ trọng bao nhiêu trong lợi nhuận gộp. <strong style="color:#d2691e;">Theo Buffet nếu chỉ số này dưới 30% thì là tuyệt vời, một số công ty có lợi thế cạnh tranh bền vững cũng có thể có chỉ số này nằm trong khoảng 30%-80%. Nhưng nếu doanh nghiệp duy trì chi phí này ở mức gần 100% hoặc cao hơn trong nhiều năm thì đó có thể là một doanh nghiệp trong ngành có sự cạnh tranh gay gắt. Kể cả khi hệ số này thấp thì cũng cần đánh giá thêm khả năng kinh tế dài hạn của doanh nghiệp dựa trên chi phí R&D, chi phí đầu tư TSCĐ (CAPEX) và chi phí lãi vay</strong>',
            'value' => $calculator->sellingAndEnperpriseManagementToGrossProfitRatio
        ]);
        return $this;
    }
}
