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
}
