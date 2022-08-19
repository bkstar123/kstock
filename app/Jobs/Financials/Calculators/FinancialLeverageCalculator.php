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
	public $shortTermToTotalLiabilitiesRatio = null; //Chỉ số nợ ngắn hạn trên tổng nợ phải trả

	public $totalDebtToTotalAssetRatio = null; //Chỉ số Nợ vay trên Tổng tài sản

	public $totalLiabilityToTotalAssetRatio = null;  //Chỉ số Tổng nợ / Tổng tài sản

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
}
