<?php
/**
 * CapexCalculator
 *
 * @author: tuanha
 * @date: 18-Aug-2022
 */
namespace App\Jobs\Financials\Calculators;

use App\Jobs\Financials\Calculators\BaseCalculator;

class CapexCalculator extends BaseCalculator
{
    public $cfoToCapexRatio = null;

    public $capexToNetProfitRatio = null;

    /**
     * Calculate CFO/CAPEX Ratio
     *
     * @return \App\Jobs\Financials\Calculators\CapexCalculator $this
     */
    public function calculateCfoToCapexRatio()
    {
        if (!empty($this->financialStatement->cash_flow_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $cfo = $this->financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter);
            $capex = $this->financialStatement->cash_flow_statement->getItem('201')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->cash_flow_statement->getItem('202')->getValue($selectedYear, $selectedQuarter);
            if ($capex < 0) {
                $this->cfoToCapexRatio = round($cfo / abs($capex), 4);
            }
        }
        return $this;
    }

    /**
     * Calculate Capex/Net Profit Ratio
     *
     * @return \App\Jobs\Financials\Calculators\CapexCalculator $this
     */
    public function calculateCapexToNetProfitRatio()
    {
        if (!empty($this->financialStatement->cash_flow_statement) && !empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $net_profit = $this->financialStatement->income_statement->getItem('19')->getValue($selectedYear, $selectedQuarter);
            $capex = $this->financialStatement->cash_flow_statement->getItem('201')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->cash_flow_statement->getItem('202')->getValue($selectedYear, $selectedQuarter);
            if ($capex < 0) {
                $this->capexToNetProfitRatio = round(100 * abs($capex) / $net_profit, 2);
            }
        }
        return $this;
    }
}
