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
    public $shortTermToTotalLiabilitiesRatio = null; //Chỉ số nợ ngắn hạn / tổng nợ phải trả

    public $totalDebtToTotalAssetRatio = null; //Chỉ số Nợ vay / Tổng tài sản

    public $totalLiabilityToTotalAssetRatio = null;  //Chỉ số Tổng nợ / Tổng tài sản

    public $totalAssetToEquityRatio = null;  //Chỉ số Tổng tài sản / Vốn chủ sở hữu

    public $totalDebtToTotalLiabilityRatio = null; //Chỉ số tổng nợ vay / tổng nợ

    public $currentDebtToTotalDebtRatio = null; //Chỉ số nợ vay ngắn hạn / tổng nợ vay

    public $averageTotalAssetToAverageEquityRatio = null; //Chỉ số Tổng tài sản bình quân / Vốn chủ sở hữu bình quân

    /**
     * Calculate short-term to total liabilities ratio - Tỷ số nợ ngắn hạn trên tổng nợ phải trả
     *
     * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
     */
    public function calculateShortTermToTotalLiabilitiesRatio()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
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
     * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
     */
    public function calculateTotalDebtToTotalAssetRatio()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
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
     * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
     */
    public function calculateTotalLiabilityToTotalAssetRatio()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
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
     * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
     */
    public function calculateTotalAssetToEquityRatio()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
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
     * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
     */
    public function calculateAverageTotalAssetToAverageEquityRatio()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
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
     * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
     */
    public function calculateTotalDebtToTotalLiabilityRatio()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
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
    * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
    */
    public function calculateCurrentDebtToTotalDebtRatio()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $current_debt = $this->financialStatement->balance_statement->getItem('3010101')->getValue($selectedYear, $selectedQuarter);
            $total_debt = $this->financialStatement->balance_statement->getItem('3010101')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->balance_statement->getItem('3010206')->getValue($selectedYear, $selectedQuarter);
            if ($total_debt != 0) {
                $this->currentDebtToTotalDebtRatio = round(100 * $current_debt / $total_debt, 2);
            }
        }
        return $this;
    }
}
