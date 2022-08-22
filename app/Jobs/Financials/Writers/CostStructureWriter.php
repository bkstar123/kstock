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
            'unit' => 'scalar',
            'description' => 'Chỉ số này cho biết giá vốn bán hàng chiếm tỉ trọng bao nhiêu trong doanh thu',
            'value' => $calculator->cOGSToRevenueRatio
        ]);
        return $this;
    }
}
