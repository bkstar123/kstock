<?php
/**
 * GrowthWriter trait
 *
 * @author: tuanha
 * @date: 24-Aug-2022
 */
namespace App\Jobs\Financials\Writers;

use App\Jobs\Financials\Calculators\GrowthCalculator;

trait GrowthWriter
{
    /**
     * Write Revenue Growth
     *
     * @param \App\Jobs\Financials\Calculators\GrowthCalculator $calculator
     * @return $this
     */
    protected function writeRevenueGrowth(GrowthCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tăng trưởng doanh thu thuần QoQ',
            'alias' => 'Revenue Growth QoQ',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng doanh thu thuần so với quý trước trong cùng năm tài chính',
            'value' => $calculator->revenueGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng doanh thu thuần YoY',
            'alias' => 'Revenue Growth YoY',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng doanh thu thuần so với cùng kỳ năm tài chính trước',
            'value' => $calculator->revenueGrowthYoY
        ]);
        return $this;
    }

    /**
     * Write Gross Profit Growth
     *
     * @param \App\Jobs\Financials\Calculators\GrowthCalculator $calculator
     * @return $this
     */
    protected function writeGrossProfitGrowth(GrowthCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tăng trưởng lợi nhuận gộp QoQ',
            'alias' => 'Gross Profit Growth QoQ',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng lợi nhuận gộp so với quý trước trong cùng năm tài chính',
            'value' => $calculator->grossProfitGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng lợi nhuận gộp YoY',
            'alias' => 'Gross Profit Growth YoY',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng lợi nhuận gộp so với cùng kỳ năm tài chính trước',
            'value' => $calculator->grossProfitGrowthYoY
        ]);
        return $this;
    }

    /**
    * Write Earning Before Tax (EBT) Growth
    *
    * @param \App\Jobs\Financials\Calculators\GrowthCalculator $calculator
    * @return $this
    */
    protected function writeEBTGrowth(GrowthCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tăng trưởng lợi nhuận trước thuế QoQ',
            'alias' => 'Earnings Before Tax Growth QoQ',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng lợi nhuận trước thuế so với quý trước trong cùng năm tài chính',
            'value' => $calculator->eBTGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng lợi nhuận trước thuế YoY',
            'alias' => 'Earnings Before Tax Growth YoY',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng lợi nhuận trước thuế so với cùng kỳ năm tài chính trước',
            'value' => $calculator->eBTGrowthYoY
        ]);
        return $this;
    }

    /**
     * Write Net Profit Of Parent Shareholders Growth
     *
     * @param \App\Jobs\Financials\Calculators\GrowthCalculator $calculator
     * @return $this
     */
    public function writeNetProfitOfParentShareHolderGrowth(GrowthCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tăng trưởng lợi nhuận sau thuế của cổ đông công ty mẹ QoQ',
            'alias' => 'Net Profit Of Parent ShareHolder Growth QoQ',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng lợi nhuận sau thuế của cổ đông công ty mẹ so với quý trước trong cùng năm tài chính',
            'value' => $calculator->netProfitOfParentShareHolderGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng lợi nhuận sau thuế của cổ đông công ty mẹ YoY',
            'alias' => 'Net Profit Of Parent ShareHolder Growth YoY',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng lợi nhuận sau thuế của cổ đông công ty mẹ so với cùng kỳ năm tài chính trước',
            'value' => $calculator->netProfitOfParentShareHolderGrowthYoY
        ]);
        return $this;
    }

    /**
     * Write Total Asset Growth
     *
     * @param \App\Jobs\Financials\Calculators\GrowthCalculator $calculator
     * @return $this
     */
    public function writeTotalAssetGrowth(GrowthCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tăng trưởng tổng tài sản QoQ',
            'alias' => 'Total Asset Growth QoQ',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng tổng tài sản so với quý trước trong cùng năm tài chính',
            'value' => $calculator->totalAssetGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng tổng tài sản YoY',
            'alias' => 'Total Asset Growth YoY',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng tổng tài sản so với cùng kỳ năm tài chính trước',
            'value' => $calculator->totalAssetGrowthYoY
        ]);
        return $this;
    }

    /**
     * Write Long Term Liability Growth
     *
     * @param \App\Jobs\Financials\Calculators\GrowthCalculator $calculator
     * @return $this
     */
    public function writeLongTermLiabilityGrowth(GrowthCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tăng trưởng nợ dài hạn QoQ',
            'alias' => 'Long Term Liability Growth QoQ',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng nợ dài hạn so với quý trước trong cùng năm tài chính',
            'value' => $calculator->longTermLiabilityGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng nợ dài hạn YoY',
            'alias' => 'Long Term Liability Growth YoY',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng nợ dài hạn so với cùng kỳ năm tài chính trước',
            'value' => $calculator->longTermLiabilityGrowthYoY
        ]);
        return $this;
    }

    /**
     * Write Liability Growth
     *
     * @param \App\Jobs\Financials\Calculators\GrowthCalculator $calculator
     * @return $this
     */
    public function writeLiabilityGrowth(GrowthCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tăng trưởng nợ phải trả QoQ',
            'alias' => 'Liability Growth QoQ',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng nợ phải trả so với quý trước trong cùng năm tài chính',
            'value' => $calculator->liabilityGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng nợ phải trả YoY',
            'alias' => 'Liability Growth YoY',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng nợ phải trả so với cùng kỳ năm tài chính trước',
            'value' => $calculator->liabilityGrowthYoY
        ]);
        return $this;
    }

    /**
     * Write Debt Growth
     *
     * @param \App\Jobs\Financials\Calculators\GrowthCalculator $calculator
     * @return $this
     */
    public function writeDebtGrowth(GrowthCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tăng trưởng nợ vay QoQ',
            'alias' => 'Debt Growth QoQ',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng nợ vay so với quý trước trong cùng năm tài chính',
            'value' => $calculator->debtGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng nợ vay YoY',
            'alias' => 'Debt Growth YoY',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng nợ vay so với cùng kỳ năm tài chính trước',
            'value' => $calculator->debtGrowthYoY
        ]);
        return $this;
    }

    /**
     * Write Equity Growth
     *
     * @param \App\Jobs\Financials\Calculators\GrowthCalculator $calculator
     * @return $this
     */
    public function writeEquityGrowth(GrowthCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tăng trưởng VCSH QoQ',
            'alias' => 'Equity Growth QoQ',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng VCSH so với quý trước trong cùng năm tài chính',
            'value' => $calculator->equityGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng VCSH YoY',
            'alias' => 'Equity Growth YoY',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng VCSH so với cùng kỳ năm tài chính trước',
            'value' => $calculator->equityGrowthYoY
        ]);
        return $this;
    }

    /**
     * Write Charter Capital Growth
     *
     * @param \App\Jobs\Financials\Calculators\GrowthCalculator $calculator
     * @return $this
     */
    public function writeCharterCapitalGrowth(GrowthCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tăng trưởng vốn điều lệ QoQ',
            'alias' => 'Charter Capital Growth QoQ',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng vốn điều lệ so với quý trước trong cùng năm tài chính',
            'value' => $calculator->charterCapitalGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng vốn điều lệ YoY',
            'alias' => 'Charter Capital Growth YoY',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng vốn điều lệ so với cùng kỳ năm tài chính trước',
            'value' => $calculator->charterCapitalGrowthYoY
        ]);
        return $this;
    }

    /**
     * Write Inventory Growth
     *
     * @param \App\Jobs\Financials\Calculators\GrowthCalculator $calculator
     * @return $this
     */
    public function writeInventoryGrowth(GrowthCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tăng trưởng hàng tồn kho QoQ',
            'alias' => 'Inventory Growth QoQ',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng hàng tồn kho so với quý trước trong cùng năm tài chính. <strong style="color:#d2691e;">Theo Buffet thì ở các doanh nghiệp có lợi thế cạnh tranh bền vững tăng trưởng hàng tồn kho phải nhất quán với tăng trưởng doanh thu</strong>',
            'value' => $calculator->inventoryGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng hàng tồn kho YoY',
            'alias' => 'Inventory Growth YoY',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng hàng tồn kho so với cùng kỳ năm tài chính trước. <strong style="color:#d2691e;">Theo Buffet thì ở các doanh nghiệp có lợi thế cạnh tranh bền vững tăng trưởng hàng tồn kho phải nhất quán với tăng trưởng doanh thu</strong>',
            'value' => $calculator->inventoryGrowthYoY
        ]);
        return $this;
    }

    /**
     * Write FCF Growth
     *
     * @param \App\Jobs\Financials\Calculators\GrowthCalculator $calculator
     * @return $this
     */
    public function writeFcfGrowth(GrowthCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tăng trưởng dòng tiền tự do (FCF) QoQ',
            'alias' => 'FCF Growth QoQ',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng dòng tiền tự do so với quý trước trong cùng năm tài chính',
            'value' => $calculator->fcfGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng dòng tiền tự do (FCF) YoY',
            'alias' => 'FCF Growth YoY',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng dòng tiền tự do so với cùng kỳ năm tài chính trước',
            'value' => $calculator->fcfGrowthYoY
        ]);
        return $this;
    }

    /**
     * Write COGS Growth
     *
     * @param \App\Jobs\Financials\Calculators\GrowthCalculator $calculator
     * @return $this
     */
    public function writeCogsGrowth(GrowthCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tăng trưởng giá vốn bán hàng QoQ',
            'alias' => 'COGS Growth QoQ',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng giá vốn bán hàng so với quý trước trong cùng năm tài chính',
            'value' => $calculator->cogsGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng giá vốn bán hàng YoY',
            'alias' => 'COGS Growth YoY',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng giá vốn bán hàng so với cùng kỳ năm tài chính trước',
            'value' => $calculator->cogsGrowthYoY
        ]);
        return $this;
    }

    /**
     * Write Operation Expense Growth
     *
     * @param \App\Jobs\Financials\Calculators\GrowthCalculator $calculator
     * @return $this
     */
    public function writeOperationExpenseGrowth(GrowthCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tăng trưởng chi phí hoạt động QoQ',
            'alias' => 'Operation Expense Growth QoQ',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng chi phí hoạt động so với quý trước trong cùng năm tài chính',
            'value' => $calculator->operationExpenseGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng chi phí hoạt động YoY',
            'alias' => 'Operation Expense Growth YoY',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng chi phí hoạt động so với cùng kỳ năm tài chính trước',
            'value' => $calculator->operationExpenseGrowthYoY
        ]);
        return $this;
    }

    /**
     * Write Interest Expense Growth
     *
     * @param \App\Jobs\Financials\Calculators\GrowthCalculator $calculator
     * @return $this
     */
    public function writeInterestExpenseGrowth(GrowthCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tăng trưởng chi phí lãi vay QoQ',
            'alias' => 'Interest Expense Growth QoQ',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng chi phí lãi vay so với quý trước trong cùng năm tài chính',
            'value' => $calculator->interestExpenseGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng chi phí lãi vay YoY',
            'alias' => 'Interest Expense Growth YoY',
            'group' => 'Chỉ số tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng chi phí lãi vay so với cùng kỳ năm tài chính trước',
            'value' => $calculator->interestExpenseGrowthYoY
        ]);
        return $this;
    }
}
