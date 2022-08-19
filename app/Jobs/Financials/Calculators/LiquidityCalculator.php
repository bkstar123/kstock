<?php
/**
 * LiquidityCalculator
 *
 * @author: tuanha
 * @date: 18-Aug-2022
 */
namespace App\Jobs\Financials\Calculators;

use App\Jobs\Financials\Calculators\BaseCalculator;

class LiquidityCalculator extends BaseCalculator
{
    public $overallSolvencyRatio = null;

    public $currentRatio = null;

    public $quickRatio = null;

    public $quickRatio2 = null;

    public $cashRatio = null;

    public $interestCoverageRatio = null;

    /**
     * Calculate Overall Solvency ratio - He so kha nang thanh toan tong quat
     *
     * @return \App\Jobs\Financials\Calculators\LiquidityCalculator $this
     */
    public function calculateOverallSolvencyRatio()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $assets = $this->financialStatement->balance_statement->getItem('2')->getValue($selectedYear, $selectedQuarter);
            $liabilities = $this->financialStatement->balance_statement->getItem('301')->getValue($selectedYear, $selectedQuarter);
            if ($liabilities != 0) {
                $this->overallSolvencyRatio = round($assets / $liabilities, 4);
            }
        }
        return $this;
    }
    
    /**
    * Calculate Current ratio - He so kha nang thanh toan hien hanh (ngan han)
    *
    * @return \App\Jobs\Financials\Calculators\LiquidityCalculator $this
    */
    public function calculateCurrentRatio()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $currentAssets = $this->financialStatement->balance_statement->getItem('101')->getValue($selectedYear, $selectedQuarter);
            $currentLiabilities = $this->financialStatement->balance_statement->getItem('30101')->getValue($selectedYear, $selectedQuarter);
            if ($currentLiabilities != 0) {
                $this->currentRatio = round($currentAssets / $currentLiabilities, 4);
            }
        }
        return $this;
    }

    /**
     * Calculate Quick Ratio - He so kha nang thanh toan nhanh
     *
     * @return \App\Jobs\Financials\Calculators\LiquidityCalculator $this
     */
    public function calculateQuickRatio()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $currentAssets = $this->financialStatement->balance_statement->getItem('101')->getValue($selectedYear, $selectedQuarter);
            $inventories = $this->financialStatement->balance_statement->getItem('10104')->getValue($selectedYear, $selectedQuarter);
            $currentLiabilities = $this->financialStatement->balance_statement->getItem('30101')->getValue($selectedYear, $selectedQuarter);
            if ($currentLiabilities != 0) {
                $this->quickRatio = round(($currentAssets - $inventories) / $currentLiabilities, 4);
            }
        }
        return $this;
    }

    /**
     * Calculate Quick Ratio 2 - He so kha nang thanh toan nhanh 2 (loai bo hang ton kho va phai thu ngan han)
     *
     * @return \App\Jobs\Financials\Calculators\LiquidityCalculator $this
     */
    public function calculateQuickRatio2()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $currentAssets = $this->financialStatement->balance_statement->getItem('101')->getValue($selectedYear, $selectedQuarter);
            $inventories = $this->financialStatement->balance_statement->getItem('10104')->getValue($selectedYear, $selectedQuarter);
            $currentReceivableAccounts = $this->financialStatement->balance_statement->getItem('10103')->getValue($selectedYear, $selectedQuarter);
            $currentLiabilities = $this->financialStatement->balance_statement->getItem('30101')->getValue($selectedYear, $selectedQuarter);
            if ($currentLiabilities != 0) {
                $this->quickRatio2 = round(($currentAssets - $inventories - $currentReceivableAccounts) / $currentLiabilities, 4);
            }
        }
        return $this;
    }

    /**
     * Calculate CashRatio - He so kha nang thanh toan tuc thoi
     *
     * @return \App\Jobs\Financials\Calculators\LiquidityCalculator $this
     */
    public function calculateCashRatio()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $cashAndEquivalents = $this->financialStatement->balance_statement->getItem('10101')->getValue($selectedYear, $selectedQuarter);
            $currentLiabilities = $this->financialStatement->balance_statement->getItem('30101')->getValue($selectedYear, $selectedQuarter);
            if ($currentLiabilities != 0) {
                $this->cashRatio = round($cashAndEquivalents / $currentLiabilities, 4);
            }
        }
        return $this;
    }

    /**
     * Calculate Interest Coverage Ratio - He so kha nang chi tra lai vay
     *
     * @return \App\Jobs\Financials\Calculators\LiquidityCalculator $this
     */
    public function calculateInterestCoverageRatio()
    {
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $eBIT = $this->financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
            $interest = $this->financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
            if ($interest != 0) {
                $this->interestCoverageRatio = round($eBIT / $interest, 4);
            }
        }
        return $this;
    }
}
