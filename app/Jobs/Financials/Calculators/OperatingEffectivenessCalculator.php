<?php
/**
 * OperatingEffectivenessCalculator
 *
 * @author: tuanha
 * @date: 18-Aug-2022
 */
namespace App\Jobs\Financials\Calculators;

use App\Jobs\Financials\Calculators\BaseCalculator;

class OperatingEffectivenessCalculator extends BaseCalculator
{
    public $receivableTurnoverRatio = null; //Vòng quay các khoản phải thu khách hàng

    public $averageCollectionPeriod = null; //Thời gian thu tiền khách hàng bình quân

    public $inventoryTurnoverRatio = null; //Vòng quay hàng tồn kho

    public $averageAgeOfInventory = null;  //Thời gian tồn kho bình quân

    public $accountsPayableTurnoverRatio = null; //Vòng quay phải trả nhà cung cấp

    public $averageAccountPayableDuration = null; //Thời gian trả tiền nhà cung cấp bình quân

    public $cashConversionCycle = null; //Chu kỳ chuyển đổi tiền mặt

    public $fixedAssetTurnoverRatio = null; //Vòng quay tài sản cố định

    public $totalAssetTurnoverRatio = null; //Vòng quay tổng tài sản

    public $equityTurnoverRatio = null; //Vòng quay VCSH

    /**
      * Calculate Receivable Turn-over Ratio
      *
      * @return \App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator $this
      */
    public function calculateReceivableTurnoverRatio()
    {
        if (!empty($this->financialStatement->income_statement) && !empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            $averageCurrentCustomerReceivables = $this->financialStatement->balance_statement->getItem('1010301')->getAverageValue($selectedYear, $selectedQuarter);
            if ($averageCurrentCustomerReceivables != 0) {
                $this->receivableTurnoverRatio = round($revenue / $averageCurrentCustomerReceivables, 4);
                $this->averageCollectionPeriod = round(365 * $averageCurrentCustomerReceivables/$revenue, 0);
            }
        }
        return $this;
    }

    /**
     * Calculate Inventory Turn-over Ratio
     *
     * @return \App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator $this
     */
    public function calculateInventoryTurnoverRatio()
    {
        if (!empty($this->financialStatement->income_statement) && !empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $cogs = $this->financialStatement->income_statement->getItem('4')->getValue($selectedYear, $selectedQuarter);
            $averageInventories = $this->financialStatement->balance_statement->getItem('10104')->getAverageValue($selectedYear, $selectedQuarter);
            if ($averageInventories != 0) {
                $this->inventoryTurnoverRatio = round($cogs / $averageInventories, 4);
                $this->averageAgeOfInventory = round(365 * $averageInventories/$cogs, 0);
            }
        }
        return $this;
    }

    /**
     * Calculate Accounts Payable Turnover Ratio
     *
     * @return \App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator $this
     */
    public function calculateAccountsPayableTurnoverRatio()
    {
        if (!empty($this->financialStatement->income_statement) && !empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $cogs = $this->financialStatement->income_statement->getItem('4')->getValue($selectedYear, $selectedQuarter);
            $averageCurrentAccountPayables = $this->financialStatement->balance_statement->getItem('3010103')->getAverageValue($selectedYear, $selectedQuarter);
            if ($averageCurrentAccountPayables != 0) {
                $this->accountsPayableTurnoverRatio = round($cogs / $averageCurrentAccountPayables, 4);
                $this->averageAccountPayableDuration = round(365 * $averageCurrentAccountPayables/$cogs, 0);
            }
        }
        return $this;
    }

    /**
     * Calculate Cash Conversion Cycle
     *
     * @return \App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator $this
     */
    public function calculateCashConversionCycle()
    {
        if (!empty($this->financialStatement->income_statement) && !empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            $averageCurrentCustomerReceivables = $this->financialStatement->balance_statement->getItem('1010301')->getAverageValue($selectedYear, $selectedQuarter);
            $cogs = $this->financialStatement->income_statement->getItem('4')->getValue($selectedYear, $selectedQuarter);
            $averageInventories = $this->financialStatement->balance_statement->getItem('10104')->getAverageValue($selectedYear, $selectedQuarter);
            $averageCurrentAccountPayables = $this->financialStatement->balance_statement->getItem('3010103')->getAverageValue($selectedYear, $selectedQuarter);
            $dso = round(365 * $averageCurrentCustomerReceivables/$revenue, 0);
            $dpo = round(365 * $averageCurrentAccountPayables/$cogs, 0);
            $dio = round(365 * $averageInventories/$cogs, 0);
            if ($averageCurrentAccountPayables != 0) {
                $this->cashConversionCycle = $dso + $dio - $dpo;
            }
        }
        return $this;
    }

    /**
     * Calculate Fixed Asset Turnover Ratio
     *
     * @return \App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator $this
     */
    public function calculateFixedAssetTurnoverRatio()
    {
        if (!empty($this->financialStatement->income_statement) && !empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            $averageFixedAssets = $this->financialStatement->balance_statement->getItem('10202')->getAverageValue($selectedYear, $selectedQuarter);
            if ($averageFixedAssets != 0) {
                $this->fixedAssetTurnoverRatio = round($revenue/$averageFixedAssets, 4);
            }
        }
        return $this;
    }

    /**
     * Calculate Total Asset Turnover Ratio
     *
     * @return \App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator $this
     */
    public function calculateTotalAssetTurnoverRatio()
    {
        if (!empty($this->financialStatement->income_statement) && !empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            $averageTotalAssets = $this->financialStatement->balance_statement->getItem('2')->getAverageValue($selectedYear, $selectedQuarter);
            if ($averageTotalAssets != 0) {
                $this->totalAssetTurnoverRatio = round($revenue/$averageTotalAssets, 4);
            }
        }
        return $this;
    }

    /**
     * Calculate Total Asset Turnover Ratio
     *
     * @return \App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator $this
     */
    public function calculateEquityTurnoverRatio()
    {
        if (!empty($this->financialStatement->income_statement) && !empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            $averageEquity = $this->financialStatement->balance_statement->getItem('302')->getAverageValue($selectedYear, $selectedQuarter);
            if ($averageEquity != 0) {
                $this->equityTurnoverRatio = round($revenue/$averageEquity, 4);
            }
        }
        return $this;
    }
}
