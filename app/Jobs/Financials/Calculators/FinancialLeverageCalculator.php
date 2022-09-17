<?php
/**
 * FinancialLeverageCalculator
 *
 * @author: tuanha
 * @date: 19-Aug-2022
 */
namespace App\Jobs\Financials\Calculators;

use App\Jobs\Financials\Calculators\BaseCalculator;

class FinancialLeverageCalculator extends BaseCalculator
{
    public $shortTermToTotalLiabilitiesRatio; //Chỉ số nợ ngắn hạn / tổng nợ phải trả

    public $totalDebtToTotalAssetRatio; //Chỉ số Nợ vay / Tổng tài sản

    public $totalLiabilityToTotalAssetRatio;  //Chỉ số Tổng nợ / Tổng tài sản

    public $totalAssetToEquityRatio;  //Chỉ số Tổng tài sản / Vốn chủ sở hữu

    public $totalDebtToTotalLiabilityRatio; //Chỉ số tổng nợ vay / tổng nợ

    public $currentDebtToTotalDebtRatio; //Chỉ số nợ vay ngắn hạn / tổng nợ vay

    public $averageTotalAssetToAverageEquityRatio; //Chỉ số Tổng tài sản bình quân / Vốn chủ sở hữu bình quân

    public $debtToEquityRatio; //Chi so no vay / VCSH

    public $netDebtToEquityRatio; //Chi so no vay rong / VCSH

    public $longTermDebtToEquityRatio; //Chi so no vay dai han / VCSH

    public $longTermDebtToLongTermLiabilityRatio; //Chi so no vay dai han / no dai han

    public $currentDebtToCurrentLiabilityRatio; //Chi so no vay ngan han / no ngan han

    public $interestExpenseToAverageDebtRatio; //Chi so chi phí lãi vay / Nợ vay bình quân

    /**
     * Calculate short-term to total liabilities ratio - Tỷ số nợ ngắn hạn trên tổng nợ phải trả
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
     */
    public function calculateShortTermToTotalLiabilitiesRatio($year = null, $quarter = null)
    {
        $this->shortTermToTotalLiabilitiesRatio = null;
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $short_term_liabilities = $this->financialStatement->balance_statement->getItem('30101')->getValue($selectedYear, $selectedQuarter);
            $total_liabilities = $this->financialStatement->balance_statement->getItem('301')->getValue($selectedYear, $selectedQuarter);
            if ($total_liabilities != 0) {
                $this->shortTermToTotalLiabilitiesRatio = round(100 * $short_term_liabilities / $total_liabilities, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate total debt to total asset ratio - Chỉ số Nợ vay trên Tổng tài sản
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
     */
    public function calculateTotalDebtToTotalAssetRatio($year = null, $quarter = null)
    {
        $this->totalDebtToTotalAssetRatio = null;
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $total_debt = $this->financialStatement->balance_statement->getItem('3010101')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->balance_statement->getItem('3010206')->getValue($selectedYear, $selectedQuarter);
            $total_assets = $this->financialStatement->balance_statement->getItem('2')->getValue($selectedYear, $selectedQuarter);
            if ($total_assets != 0) {
                $this->totalDebtToTotalAssetRatio = round(100 * $total_debt / $total_assets, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate total liability to total asset ratio - Chỉ số Tổng nợ / Tổng tài sản
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
     */
    public function calculateTotalLiabilityToTotalAssetRatio($year = null, $quarter = null)
    {
        $this->totalLiabilityToTotalAssetRatio = null;
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $total_liability = $this->financialStatement->balance_statement->getItem('301')->getValue($selectedYear, $selectedQuarter);
            $total_assets = $this->financialStatement->balance_statement->getItem('2')->getValue($selectedYear, $selectedQuarter);
            if ($total_assets != 0) {
                $this->totalLiabilityToTotalAssetRatio = round(100 * $total_liability / $total_assets, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate total asset to equity ratio - Chỉ số Tổng tài sản / Vốn chủ sở hữu
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
     */
    public function calculateTotalAssetToEquityRatio($year = null, $quarter = null)
    {
        $this->totalAssetToEquityRatio = null;
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $equity = $this->financialStatement->balance_statement->getItem('302')->getValue($selectedYear, $selectedQuarter);
            $total_assets = $this->financialStatement->balance_statement->getItem('2')->getValue($selectedYear, $selectedQuarter);
            if ($equity != 0) {
                $this->totalAssetToEquityRatio = round($total_assets / $equity, 4);
            }
        }
        return $this;
    }

    /**
     * Calculate average total asset to average equity ratio - Chỉ số Tổng tài sản bình quân / Vốn chủ sở hữu bình quân
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
     */
    public function calculateAverageTotalAssetToAverageEquityRatio($year = null, $quarter = null)
    {
        $this->averageTotalAssetToAverageEquityRatio = null;
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $average_equity = $this->financialStatement->balance_statement->getItem('302')->getAverageValue($selectedYear, $selectedQuarter);
            $average_total_assets = $this->financialStatement->balance_statement->getItem('2')->getAverageValue($selectedYear, $selectedQuarter);
            if ($average_equity != 0) {
                $this->averageTotalAssetToAverageEquityRatio = round($average_total_assets / $average_equity, 4);
            }
        }
        return $this;
    }

    /**
     * Calculate total debts to total liabilities - Chỉ số tổng nợ vay / tổng nợ
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
     */
    public function calculateTotalDebtToTotalLiabilityRatio($year = null, $quarter = null)
    {
        $this->totalDebtToTotalLiabilityRatio = null;
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $total_debt = $this->financialStatement->balance_statement->getItem('3010101')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->balance_statement->getItem('3010206')->getValue($selectedYear, $selectedQuarter);
            $total_liabilities = $this->financialStatement->balance_statement->getItem('301')->getValue($selectedYear, $selectedQuarter);
            if ($total_liabilities != 0) {
                $this->totalDebtToTotalLiabilityRatio = round(100 * $total_debt / $total_liabilities, 2);
            }
        }
        return $this;
    }

    /**
    * Calculate current debts to total debts - Chỉ số nợ vay ngắn hạn / tổng nợ vay
    *
    * @param int $year
    * @param int $quarter
    * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
    */
    public function calculateCurrentDebtToTotalDebtRatio($year = null, $quarter = null)
    {
        $this->currentDebtToTotalDebtRatio = null;
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $current_debt = $this->financialStatement->balance_statement->getItem('3010101')->getValue($selectedYear, $selectedQuarter);
            $total_debt = $this->financialStatement->balance_statement->getItem('3010101')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->balance_statement->getItem('3010206')->getValue($selectedYear, $selectedQuarter);
            if ($total_debt != 0) {
                $this->currentDebtToTotalDebtRatio = round(100 * $current_debt / $total_debt, 2);
            }
        }
        return $this;
    }

    /**
    * Calculate Debts to Equities - Chỉ số nợ vay / VCSH
    *
    * @param int $year
    * @param int $quarter
    * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
    */
    public function calculateDebtToEquityRatio($year = null, $quarter = null)
    {
        $this->debtToEquityRatio = null;
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $equity = $this->financialStatement->balance_statement->getItem('302')->getValue($selectedYear, $selectedQuarter);
            $total_debt = $this->financialStatement->balance_statement->getItem('3010101')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->balance_statement->getItem('3010206')->getValue($selectedYear, $selectedQuarter);
            if ($equity != 0) {
                $this->debtToEquityRatio = round($total_debt / $equity, 4);
            }
        }
        return $this;
    }

    /**
    * Calculate Net Debts to Equities - Chỉ số nợ vay rong / VCSH
    *
    * @param int $year
    * @param int $quarter
    * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
    */
    public function calculateNetDebtToEquityRatio($year = null, $quarter = null)
    {
        $this->netDebtToEquityRatio = null;
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $equity = $this->financialStatement->balance_statement->getItem('302')->getValue($selectedYear, $selectedQuarter);
            $net_debt = $this->financialStatement->balance_statement->getItem('3010101')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->balance_statement->getItem('3010206')->getValue($selectedYear, $selectedQuarter) - $this->financialStatement->balance_statement->getItem('10102')->getValue($selectedYear, $selectedQuarter) - $this->financialStatement->balance_statement->getItem('10205')->getValue($selectedYear, $selectedQuarter);
            if ($equity != 0) {
                $this->netDebtToEquityRatio = round($net_debt / $equity, 4);
            }
        }
        return $this;
    }

    /**
    * Calculate Long Term Debts to Equities - Chỉ số nợ vay dài hạn / VCSH
    *
    * @param int $year
    * @param int $quarter
    * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
    */
    public function calculateLongTermDebtToEquityRatio($year = null, $quarter = null)
    {
        $this->longTermDebtToEquityRatio = null;
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $equity = $this->financialStatement->balance_statement->getItem('302')->getValue($selectedYear, $selectedQuarter);
            $long_term_debt = $this->financialStatement->balance_statement->getItem('3010206')->getValue($selectedYear, $selectedQuarter);
            if ($equity != 0) {
                $this->longTermDebtToEquityRatio = round($long_term_debt / $equity, 4);
            }
        }
        return $this;
    }

    /**
    * Calculate Long Term Debts to Long Term Liabilities - Chỉ số nợ vay dài hạn / nợ dài hạn
    *
    * @param int $year
    * @param int $quarter
    * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
    */
    public function calculateLongTermDebtToLongTermLiabilityRatio($year = null, $quarter = null)
    {
        $this->longTermDebtToLongTermLiabilityRatio = null;
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $long_term_debt = $this->financialStatement->balance_statement->getItem('3010206')->getValue($selectedYear, $selectedQuarter);
            $long_term_liability = $this->financialStatement->balance_statement->getItem('30102')->getValue($selectedYear, $selectedQuarter);
            if ($long_term_liability != 0) {
                $this->longTermDebtToLongTermLiabilityRatio = round(100 * $long_term_debt / $long_term_liability, 2);
            }
        }
        return $this;
    }

    /**
    * Calculate Current Debts to Current Liabilities - Chỉ số nợ ngắn dài hạn / nợ ngắn hạn
    *
    * @param int $year
    * @param int $quarter
    * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
    */
    public function calculateCurrentDebtToCurrentLiabilityRatio($year = null, $quarter = null)
    {
        $this->currentDebtToCurrentLiabilityRatio = null;
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $current_debt = $this->financialStatement->balance_statement->getItem('3010101')->getValue($selectedYear, $selectedQuarter);
            $current_liability = $this->financialStatement->balance_statement->getItem('30101')->getValue($selectedYear, $selectedQuarter);
            if ($current_liability != 0) {
                $this->currentDebtToCurrentLiabilityRatio = round(100 * $current_debt / $current_liability, 2);
            }
        }
        return $this;
    }

    /**
    * Calculate Interest Expense to Average Debt - Chỉ số chi phí lãi vay / Nợ vay bình quân
    *
    * @param int $year
    * @param int $quarter
    * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
    */
    public function calculateInterestExpenseToAverageDebtRatio($year = null, $quarter = null)
    {
        $this->interestExpenseToAverageDebtRatio = null;
        if (!empty($this->financialStatement->balance_statement) &&
            !empty($this->financialStatement->income_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $average_debt = $this->financialStatement->balance_statement->getItem('3010101')->getAverageValue($selectedYear, $selectedQuarter) + $this->financialStatement->balance_statement->getItem('3010206')->getAverageValue($selectedYear, $selectedQuarter);
            $interest_expense = $this->financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
            if ($average_debt != 0) {
                $this->interestExpenseToAverageDebtRatio = round(100 * $interest_expense / $average_debt, 2);
            }
        }
        return $this;
    }
}
