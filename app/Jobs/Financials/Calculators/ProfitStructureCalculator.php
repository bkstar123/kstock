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
     * @return \App\Jobs\Financials\Calculators\CapexCalculator $this
     */
    public function calculateOperatingProfitToEBTRatio()
    {
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $operatingProfit = $this->financialStatement->income_statement->getItem('11')->getValue($selectedYear, $selectedQuarter);
            $eBT = $this->financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter);
            if ($eBT != 0) {
                $this->operatingProfitToEBT = round(100 * $operatingProfit / $eBT, 2);
            }
        }
        return $this;
    }
}
