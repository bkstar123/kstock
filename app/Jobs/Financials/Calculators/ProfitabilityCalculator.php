<?php
/**
 * ProfitabilityCaculator
 *
 * @author: tuanha
 * @date: 18-Aug-2022
 */
namespace App\Jobs\Financials\Calculators;

use App\Jobs\Financials\Calculators\BaseCalculator;

class ProfitabilityCalculator extends BaseCalculator
{
    public $roaa = null;

    public $roce = null;

    public $roea = null;

    public $ros = null;

    public $ebitdaMargin = null;

    public $ebitMargin = null;

    public $grossProfitMargin = null;

    /**
     * Calculate ROAA - Ty suat loi nhuan tren tong tai san binh quan
     *
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateROAA()
    {
        if (!empty($this->financialStatement->balance_statement) &&
            !empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $average_assets = array_sum($this->financialStatement->balance_statement->getItem('2')->getValues())/2;
            $parent_company_net_profit = $this->financialStatement->income_statement->getItem('21')->getValue($selectedYear, $selectedQuarter);
            if ($average_assets != 0) {
                $this->roaa = round(100 * $parent_company_net_profit / $average_assets, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate ROCE - Ty suat loi nhuan tren von dai han binh quan
     *
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateROCE()
    {
        if (!empty($this->financialStatement->balance_statement) &&
            !empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $average_assets = array_sum($this->financialStatement->balance_statement->getItem('2')->getValues())/2;
            $average_current_liabilities = array_sum($this->financialStatement->balance_statement->getItem('30101')->getValues())/2;
            $eBIT = $this->financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
            if ($average_assets != $average_current_liabilities) {
                $this->roce = round(100 * $eBIT / ($average_assets - $average_current_liabilities), 2);
            }
        }
        return $this;
    }

    /**
     * Calculate ROEA - Ty suat loi nhuan tren VCSH binh quan
     *
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateROEA()
    {
        if (!empty($this->financialStatement->balance_statement) &&
            !empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $parent_company_net_profit = $this->financialStatement->income_statement->getItem('21')->getValue($selectedYear, $selectedQuarter);
            $average_equities = array_sum($this->financialStatement->balance_statement->getItem('302')->getValues())/2;
            if ($average_equities != 0) {
                $this->roea = round(100 * $parent_company_net_profit / $average_equities, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate ROS - Ty suat loi nhuan rong
     *
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateROS()
    {
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $net_profit = $this->financialStatement->income_statement->getItem('19')->getValue($selectedYear, $selectedQuarter);
            $net_revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            if ($net_revenue != 0) {
                $this->ros = round(100 * $net_profit / $net_revenue, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate EBITDA Mergin
     *
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateEBITDAMargin()
    {
        if (!empty($this->financialStatement->balance_statement) &&
            !empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $eBit = $this->financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
            $tangibleStaticAssets = $this->financialStatement->balance_statement->getItem("102020102")->getValues();
            $financialLendingStaticAssets = $this->financialStatement->balance_statement->getItem("102020202")->getValues();
            $intangibleStaticAssets = $this->financialStatement->balance_statement->getItem("102020302")->getValues();
            $investRealEstate = $this->financialStatement->balance_statement->getItem("1020302")->getValues();
            $deprecation = abs($tangibleStaticAssets[1]) - abs($tangibleStaticAssets[0]) + abs($financialLendingStaticAssets[1]) - abs($financialLendingStaticAssets[0]) + abs($intangibleStaticAssets[1]) - abs($intangibleStaticAssets[0]) + abs($investRealEstate[1]) - abs($investRealEstate[0]);
            $eBITDA = $eBit + $deprecation;
            $net_revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            if ($net_revenue != 0) {
                $this->ebitdaMargin = round(100 * $eBITDA / $net_revenue, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate EBIT Margin
     *
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateEBITMargin()
    {
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $eBit = $this->financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
            $net_revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            if ($net_revenue != 0) {
                $this->ebitMargin = round(100 * $eBit / $net_revenue, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate Gross profit margin - Bien loi nhuan gop
     *
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateGrossProfitMargin()
    {
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $grossProfit = $this->financialStatement->income_statement->getItem('5')->getValue($selectedYear, $selectedQuarter);
            $net_revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            if ($net_revenue != 0) {
                $this->grossProfitMargin = round(100 * $grossProfit / $net_revenue, 2);
            }
        }
        return $this;
    }
}
