<?php
/**
 * LongTermAssetStructureCalculator
 *
 * @author: tuanha
 * @date: 23-Aug-2022
 */
namespace App\Jobs\Financials\Calculators;

use App\Jobs\Financials\Calculators\BaseCalculator;

class LongTermAssetStructureCalculator extends BaseCalculator
{
    public $longTermAssetToTotalAssetRatio = null; //Tài sản dài hạn/Tổng tài sản

    public $fixedAssetToTotalAssetRatio = null; //Tài sản cố định/Tổng tài sản

    public $tangibleFixedAssetToFixedAssetRatio = null; //Tài sản cố định hữu hình/Tài sản cố định

    public $financialLendingAssetToFixedAssetRatio = null; //Tài sản thuê tài chính/Tài sản cố định

    public $intangibleAssetToFixedAssetRatio = null; //Tài sản vô hình/Tài sản cố định

    public $constructionInProgressToFixedAssetRatio = null; //Chi phí xây dựng cơ bản dở dang dài hạn / Tài sản cố định

    /**
     * Calculate Long Term Asset / Total Asset Ratio
     *
     * @return \App\Jobs\Financials\Calculators\LongTermAssetStructureCalculator $this
     */
    public function calculateLongTermAssetToTotalAssetRatio()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $long_term_assets = $this->financialStatement->balance_statement->getItem('102')->getValue($selectedYear, $selectedQuarter);
            $total_assets = $this->financialStatement->balance_statement->getItem('2')->getValue($selectedYear, $selectedQuarter);
            if ($total_assets != 0) {
                $this->longTermAssetToTotalAssetRatio = round(100 * $long_term_assets / $total_assets, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate Fixed Asset / Total Asset Ratio
     *
     * @return \App\Jobs\Financials\Calculators\LongTermAssetStructureCalculator $this
     */
    public function calculateFixedAssetToTotalAssetRatio()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $total_assets = $this->financialStatement->balance_statement->getItem('2')->getValue($selectedYear, $selectedQuarter);
            $fixed_assets = $this->financialStatement->balance_statement->getItem('10202')->getValue($selectedYear, $selectedQuarter);
            if ($total_assets != 0) {
                $this->fixedAssetToTotalAssetRatio = round(100 * $fixed_assets / $total_assets, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate Tangible Fixed Asset / Fixed Asset Ratio
     *
     * @return \App\Jobs\Financials\Calculators\LongTermAssetStructureCalculator $this
     */
    public function calculateTangibleFixedAssetToFixedAssetRatio()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $fixed_assets = $this->financialStatement->balance_statement->getItem('10202')->getValue($selectedYear, $selectedQuarter);
            $tangible_fixed_assets = $this->financialStatement->balance_statement->getItem('1020201')->getValue($selectedYear, $selectedQuarter);
            if ($fixed_assets != 0) {
                $this->tangibleFixedAssetToFixedAssetRatio = round(100 * $tangible_fixed_assets / $fixed_assets, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate Financial Lending Asset / Fixed Asset Ratio
     *
     * @return \App\Jobs\Financials\Calculators\LongTermAssetStructureCalculator $this
     */
    public function calculateFinancialLendingAssetToFixedAssetRatio()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $fixed_assets = $this->financialStatement->balance_statement->getItem('10202')->getValue($selectedYear, $selectedQuarter);
            $financial_lending_assets = $this->financialStatement->balance_statement->getItem('1020202')->getValue($selectedYear, $selectedQuarter);
            if ($fixed_assets != 0) {
                $this->financialLendingAssetToFixedAssetRatio = round(100 * $financial_lending_assets / $fixed_assets, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate Intangible Asset / Fixed Asset Ratio
     *
     * @return \App\Jobs\Financials\Calculators\LongTermAssetStructureCalculator $this
     */
    public function calculateIntangibleAssetToFixedAssetRatio()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $fixed_assets = $this->financialStatement->balance_statement->getItem('10202')->getValue($selectedYear, $selectedQuarter);
            $intangible_assets = $this->financialStatement->balance_statement->getItem('1020203')->getValue($selectedYear, $selectedQuarter);
            ;
            if ($fixed_assets != 0) {
                $this->intangibleAssetToFixedAssetRatio = round(100 * $intangible_assets / $fixed_assets, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate Construction In Progress / Fixed Asset Ratio
     *
     * @return \App\Jobs\Financials\Calculators\LongTermAssetStructureCalculator $this
     */
    public function calculateConstructionInProgressToFixedAssetRatio()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $fixed_assets = $this->financialStatement->balance_statement->getItem('10202')->getValue($selectedYear, $selectedQuarter);
            $constructionInProgress = $this->financialStatement->balance_statement->getItem('1020402')->getValue($selectedYear, $selectedQuarter);
            if ($fixed_assets != 0) {
                $this->constructionInProgressToFixedAssetRatio = round(100 * $constructionInProgress / $fixed_assets, 2);
            }
        }
        return $this;
    }
}
