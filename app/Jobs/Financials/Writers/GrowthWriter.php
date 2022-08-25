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
            'group' => 'Chỉ số Tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng doanh thu thuần so với quý trước trong cùng năm tài chính',
            'value' => $calculator->revenueGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng doanh thu thuần YoY',
            'alias' => 'Revenue Growth YoY',
            'group' => 'Chỉ số Tăng trưởng',
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
            'group' => 'Chỉ số Tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng lợi nhuận gộp so với quý trước trong cùng năm tài chính',
            'value' => $calculator->grossProfitGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng lợi nhuận gộp YoY',
            'alias' => 'Gross Profit Growth YoY',
            'group' => 'Chỉ số Tăng trưởng',
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
            'name' => 'Tăng trưởng lợi nhuận gộp trước thuế QoQ',
            'alias' => 'Earnings Before Tax Growth QoQ',
            'group' => 'Chỉ số Tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng lợi nhuận trước thuế so với quý trước trong cùng năm tài chính',
            'value' => $calculator->eBTGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng lợi nhuận trước thuế YoY',
            'alias' => 'Earnings Before Tax Growth YoY',
            'group' => 'Chỉ số Tăng trưởng',
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
            'group' => 'Chỉ số Tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng lợi nhuận sau thuế của cổ đông công ty mẹ so với quý trước trong cùng năm tài chính',
            'value' => $calculator->netProfitOfParentShareHolderGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng lợi nhuận sau thuế của cổ đông công ty mẹ YoY',
            'alias' => 'Net Profit Of Parent ShareHolder Growth YoY',
            'group' => 'Chỉ số Tăng trưởng',
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
            'alias' => 'NTotal Asset Growth QoQ',
            'group' => 'Chỉ số Tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng tổng tài sản so với quý trước trong cùng năm tài chính',
            'value' => $calculator->totalAssetGrowthQoQ
        ]);
        array_push($this->content, [
            'name' => 'Tăng trưởng tổng tài sản YoY',
            'alias' => 'Total Asset Growth YoY',
            'group' => 'Chỉ số Tăng trưởng',
            'unit' => '%',
            'description' => 'Tăng trưởng tổng tài sản so với cùng kỳ năm tài chính trước',
            'value' => $calculator->totalAssetGrowthYoY
        ]);
        return $this;
    }
}
