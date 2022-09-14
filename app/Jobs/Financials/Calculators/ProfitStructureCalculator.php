<?php
/**
 * ProfitStructureCalculator
 *
 * @author: tuanha
 * @date: 02-Sept-2022
 */
namespace App\Jobs\Financials\Calculators;

use App\Jobs\Financials\Calculators\BaseCalculator;

class ProfitStructureCalculator extends BaseCalculator
{
    public $operatingProfitToEBT = null; //He so loi nhuan thuan tu HDKD / LNTT

    /**
     * Calculate Operating Profit / Earning Before Tax (EBT) Ratio
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\CapexCalculator $this
     */
    public function calculateOperatingProfitToEBTRatio($year = null, $quarter = null)
    {
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $operatingProfit = $this->financialStatement->income_statement->getItem('11')->getValue($selectedYear, $selectedQuarter);
            $eBT = $this->financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter);
            if ($eBT != 0) {
                $this->operatingProfitToEBT = round(100 * $operatingProfit / $eBT, 2);
            }
        }
        return $this;
    }
}
