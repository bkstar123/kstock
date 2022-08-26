<?php
/**
 * GrowthCalculator
 *
 * @author: tuanha
 * @date: 24-Aug-2022
 */
namespace App\Jobs\Financials\Calculators;

use App\Jobs\Financials\Calculators\BaseCalculator;

class GrowthCalculator extends BaseCalculator
{
    public $revenueGrowthQoQ = null; //Tăng trưởng doanh thu thuần so với quý trước trong cùng năm tài chính

    public $revenueGrowthYoY = null; //Tăng trưởng doanh thu thuần so với cùng kỳ năm tài chính trước

    public $grossProfitGrowthQoQ = null; //Tăng trưởng lợi nhuận gộp so với quý trước trong cùng năm tài chính

    public $grossProfitGrowthYoY = null; //Tăng trưởng lợi nhuận gộp so với cùng kỳ năm tài chính trước

    public $eBTGrowthQoQ = null; //Tăng trưởng lợi nhuận trước thuế so với quý trước trong cùng năm tài chính

    public $eBTGrowthYoY = null; //Tăng trưởng lợi nhuận trước thuế so với cùng kỳ năm tài chính trước

    public $netProfitOfParentShareHolderGrowthQoQ = null; //Tăng trưởng lợi nhuận sau thuế của cổ đông công ty mẹ so với quý trước trong cùng năm tài chính

    public $netProfitOfParentShareHolderGrowthYoY = null; //Tăng trưởng lợi nhuận sau thuế của cổ đông công ty mẹ so với cùng kỳ năm tài chính trước

    public $totalAssetGrowthQoQ = null; //Tăng trưởng tổng tài sản so với quý trước trong cùng năm tài chính

    public $totalAssetGrowthYoY = null; //Tăng trưởng tổng tài sản so với cùng kỳ năm tài chính trước

    public $longTermLiabilityGrowthQoQ = null; //Tăng trưởng nợ dài hạn so với quý trước trong cùng năm tài chính

    public $longTermLiabilityGrowthYoY = null; //Tăng trưởng nợ dài hạn so với cùng kỳ năm tài chính trước

    public $liabilityGrowthQoQ = null; //Tăng trưởng nợ phải trả so với quý trước trong cùng năm tài chính

    public $liabilityGrowthYoY = null; //Tăng trưởng nợ phải trả so với cùng kỳ năm tài chính trước

    public $equityGrowthQoQ = null; //Tăng trưởng VCSH so với quý trước trong cùng năm tài chính

    public $equityGrowthYoY = null; //Tăng trưởng VCSH so với cùng kỳ năm tài chính trước

    public $charterCapitalGrowthQoQ = null; //Tăng trưởng vốn điều lệ so với quý trước trong cùng năm tài chính

    public $charterCapitalGrowthYoY = null; //Tăng trưởng vốn điều lệ so với cùng kỳ năm tài chính trước

    /**
     * Calculate Revenue Growth
     *
     * @return \App\Jobs\Financials\Calculators\GrowthCalculator $this
     */
    public function calculateRevenueGrowth()
    {
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $selectedPeriodRevenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            $revenueYoY = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear-1, $selectedQuarter);
            if ($revenueYoY != 0) {
                $this->revenueGrowthYoY = round(100 * ($selectedPeriodRevenue - $revenueYoY) / abs($revenueYoY), 2);
            }
            if ($selectedQuarter > 1) {
                $revenueQoQ = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter-1);
                if ($revenueQoQ != 0) {
                    $this->revenueGrowthQoQ = round(100 * ($selectedPeriodRevenue - $revenueQoQ) / abs($revenueQoQ), 2);
                }
            }
        }
        return $this;
    }

    /**
     * Calculate Gross Profit Growth
     *
     * @return \App\Jobs\Financials\Calculators\GrowthCalculator $this
     */
    public function calculateGrossProfitGrowth()
    {
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $selectedPeriodGrossProfit = $this->financialStatement->income_statement->getItem('5')->getValue($selectedYear, $selectedQuarter);
            $grossProfitYoY = $this->financialStatement->income_statement->getItem('5')->getValue($selectedYear-1, $selectedQuarter);
            if ($grossProfitYoY != 0) {
                $this->grossProfitGrowthYoY = round(100 * ($selectedPeriodGrossProfit - $grossProfitYoY) / abs($grossProfitYoY), 2);
            }
            if ($selectedQuarter > 1) {
                $grossProfitQoQ = $this->financialStatement->income_statement->getItem('5')->getValue($selectedYear, $selectedQuarter-1);
                if ($grossProfitQoQ != 0) {
                    $this->grossProfitGrowthQoQ= round(100 * ($selectedPeriodGrossProfit - $grossProfitQoQ) / abs($grossProfitQoQ), 2);
                }
            }
        }
        return $this;
    }

    /**
     * Calculate Earning Before Tax (EBT) Growth
     *
     * @return \App\Jobs\Financials\Calculators\GrowthCalculator $this
     */
    public function calculateEBTGrowth()
    {
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $selectedPeriodEBT = $this->financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter);
            $eBTYoY = $this->financialStatement->income_statement->getItem('15')->getValue($selectedYear-1, $selectedQuarter);
            if ($eBTYoY != 0) {
                $this->eBTGrowthYoY = round(100 * ($selectedPeriodEBT - $eBTYoY) / abs($eBTYoY), 2);
            }
            if ($selectedQuarter > 1) {
                $eBTQoQ = $this->financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter-1);
                if ($eBTQoQ != 0) {
                    $this->eBTGrowthQoQ = round(100 * ($selectedPeriodEBT - $eBTQoQ) / abs($eBTQoQ), 2);
                }
            }
        }
        return $this;
    }

    /**
     * Calculate Net Profit Of Parent Shareholders Growth
     *
     * @return \App\Jobs\Financials\Calculators\GrowthCalculator $this
     */
    public function calculateNetProfitOfParentShareHolderGrowth()
    {
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $selectedPeriodNetProfitOfParentShareHolder = $this->financialStatement->income_statement->getItem('21')->getValue($selectedYear, $selectedQuarter);
            $netProfitOfParentShareHolderYoY = $this->financialStatement->income_statement->getItem('21')->getValue($selectedYear-1, $selectedQuarter);
            if ($netProfitOfParentShareHolderYoY != 0) {
                $this->netProfitOfParentShareHolderGrowthYoY = round(100 * ($selectedPeriodNetProfitOfParentShareHolder - $netProfitOfParentShareHolderYoY) / abs($netProfitOfParentShareHolderYoY), 2);
            }
            if ($selectedQuarter > 1) {
                $netProfitOfParentShareHolderQoQ = $this->financialStatement->income_statement->getItem('21')->getValue($selectedYear, $selectedQuarter-1);
                if ($netProfitOfParentShareHolderQoQ != 0) {
                    $this->netProfitOfParentShareHolderGrowthQoQ = round(100 * ($selectedPeriodNetProfitOfParentShareHolder - $netProfitOfParentShareHolderQoQ) / abs($netProfitOfParentShareHolderQoQ), 2);
                }
            }
        }
        return $this;
    }

    /**
     * Calculate Total Asset Growth
     *
     * @return \App\Jobs\Financials\Calculators\GrowthCalculator $this
     */
    public function calculateTotalAssetGrowth()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $selectedPeriodTotalAssets = $this->financialStatement->balance_statement->getItem('2')->getValue($selectedYear, $selectedQuarter);
            $totalAssetsYoY = $this->financialStatement->balance_statement->getItem('2')->getValue($selectedYear-1, $selectedQuarter);
            if ($totalAssetsYoY != 0) {
                $this->totalAssetGrowthYoY = round(100 * ($selectedPeriodTotalAssets - $totalAssetsYoY) / abs($totalAssetsYoY), 2);
            }
            if ($selectedQuarter > 1) {
                $totalAssetsQoQ = $this->financialStatement->balance_statement->getItem('2')->getValue($selectedYear, $selectedQuarter-1);
                if ($totalAssetsQoQ != 0) {
                    $this->totalAssetGrowthQoQ = round(100 * ($selectedPeriodTotalAssets - $totalAssetsQoQ) / abs($totalAssetsQoQ), 2);
                }
            }
        }
        return $this;
    }

    /**
     * Calculate Long Term Liability Growth
     *
     * @return \App\Jobs\Financials\Calculators\GrowthCalculator $this
     */
    public function calculateLongTermLiabilityGrowth()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $selectedPeriodLongTermLiability = $this->financialStatement->balance_statement->getItem('30102')->getValue($selectedYear, $selectedQuarter);
            $longTermLiabilityYoY = $this->financialStatement->balance_statement->getItem('30102')->getValue($selectedYear-1, $selectedQuarter);
            if ($longTermLiabilityYoY != 0) {
                $this->longTermLiabilityGrowthYoY = round(100 * ($selectedPeriodLongTermLiability - $longTermLiabilityYoY) / abs($longTermLiabilityYoY), 2);
            }
            if ($selectedQuarter > 1) {
                $longTermLiabilityQoQ = $this->financialStatement->balance_statement->getItem('30102')->getValue($selectedYear, $selectedQuarter-1);
                if ($longTermLiabilityQoQ != 0) {
                    $this->longTermLiabilityGrowthQoQ = round(100 * ($selectedPeriodLongTermLiability - $longTermLiabilityQoQ) / abs($longTermLiabilityQoQ), 2);
                }
            }
        }
        return $this;
    }

    /**
     * Calculate Liability Growth
     *
     * @return \App\Jobs\Financials\Calculators\GrowthCalculator $this
     */
    public function calculateLiabilityGrowth()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $selectedPeriodLiability = $this->financialStatement->balance_statement->getItem('301')->getValue($selectedYear, $selectedQuarter);
            $liabilityYoY = $this->financialStatement->balance_statement->getItem('301')->getValue($selectedYear-1, $selectedQuarter);
            if ($liabilityYoY != 0) {
                $this->liabilityGrowthYoY = round(100 * ($selectedPeriodLiability - $liabilityYoY) / abs($liabilityYoY), 2);
            }
            if ($selectedQuarter > 1) {
                $liabilityQoQ = $this->financialStatement->balance_statement->getItem('301')->getValue($selectedYear, $selectedQuarter-1);
                if ($liabilityQoQ != 0) {
                    $this->liabilityGrowthQoQ = round(100 * ($selectedPeriodLiability - $liabilityQoQ) / abs($liabilityQoQ), 2);
                }
            }
        }
        return $this;
    }

    /**
     * Calculate Equity Growth
     *
     * @return \App\Jobs\Financials\Calculators\GrowthCalculator $this
     */
    public function calculateEquityGrowth()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $selectedPeriodEquity = $this->financialStatement->balance_statement->getItem('302')->getValue($selectedYear, $selectedQuarter);
            $equityYoY = $this->financialStatement->balance_statement->getItem('302')->getValue($selectedYear-1, $selectedQuarter);
            if ($equityYoY != 0) {
                $this->equityGrowthYoY = round(100 * ($selectedPeriodEquity - $equityYoY) / abs($equityYoY), 2);
            }
            if ($selectedQuarter > 1) {
                $equityQoQ = $this->financialStatement->balance_statement->getItem('302')->getValue($selectedYear, $selectedQuarter-1);
                if ($equityQoQ != 0) {
                    $this->equityGrowthQoQ = round(100 * ($selectedPeriodEquity - $equityQoQ) / abs($equityQoQ), 2);
                }
            }
        }
        return $this;
    }

    /**
     * Calculate Charter Capital Growth
     *
     * @return \App\Jobs\Financials\Calculators\GrowthCalculator $this
     */
    public function calculateCharterCapitalGrowth()
    {
        if (!empty($this->financialStatement->balance_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $selectedPeriodCharterCapital = $this->financialStatement->balance_statement->getItem('3020101')->getValue($selectedYear, $selectedQuarter);
            $charterCapitalYoY = $this->financialStatement->balance_statement->getItem('3020101')->getValue($selectedYear-1, $selectedQuarter);
            if ($charterCapitalYoY != 0) {
                $this->charterCapitalGrowthYoY = round(100 * ($selectedPeriodCharterCapital - $charterCapitalYoY) / abs($charterCapitalYoY), 2);
            }
            if ($selectedQuarter > 1) {
                $charterCapitalQoQ = $this->financialStatement->balance_statement->getItem('3020101')->getValue($selectedYear, $selectedQuarter-1);
                if ($charterCapitalQoQ != 0) {
                    $this->charterCapitalGrowthQoQ = round(100 * ($selectedPeriodCharterCapital - $charterCapitalQoQ) / abs($charterCapitalQoQ), 2);
                }
            }
        }
        return $this;
    }
}
