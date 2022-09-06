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
    public $roaa = null; //Ty suat loi nhuan tren tong tai san binh quan

    public $roce = null; //Ty suat loi nhuan tren von su dung dai han binh quan

    public $roa = null; //Ty suat loi nhuan tren tong tai san trong ki

    public $roe = null; //Ty suat loi nhuan tren VCSH trong ky

    public $roea = null; //Ty suat loi nhuan tren VCSH binh quan

    public $ros = null; //Ty suat loi nhuan rong (theo LNST)

    public $ros2 = null; //Ty suat loi nhuan rong (theo LNST co dong cong ty me)

    public $ebitdaMargin1 = null; //Bien loi nhuan truoc thue, lai vay va khau hao tinh theo CDKT va bao cao ket qua HDKD

    public $ebitdaMargin2 = null; //Bien loi nhuan truoc thue, lai vay va khau hao tinh theo LCTT

    public $ebitMargin = null; //Bien loi nhuan truoc thue va lai vay

    public $grossProfitMargin = null; //Bien loi nhuan gop

    public $rota = null; //Ti suat loi nhuan truoc thue va lai vay tren tong tai san binh quan

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
            $average_total_assets = $this->financialStatement->balance_statement->getItem('2')->getAverageValue($selectedYear, $selectedQuarter);
            $parent_company_net_profit = $this->financialStatement->income_statement->getItem('21')->getValue($selectedYear, $selectedQuarter);
            if ($average_total_assets != 0) {
                $this->roaa = round(100 * $parent_company_net_profit / $average_total_assets, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate ROTA - Ty suat loi nhuan truoc thue va lai vay tren tong tai san binh quan
     *
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateROTA()
    {
        if (!empty($this->financialStatement->balance_statement) &&
            !empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $average_total_assets = $this->financialStatement->balance_statement->getItem('2')->getAverageValue($selectedYear, $selectedQuarter);
            $eBit = $this->financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
            if ($average_total_assets != 0) {
                $this->rota = round(100 * $eBit / $average_total_assets, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate ROA - Ty suat loi nhuan tren tong tai san trong ky
     *
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateROA()
    {
        if (!empty($this->financialStatement->balance_statement) &&
            !empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $total_assets = $this->financialStatement->balance_statement->getItem('2')->getValue($selectedYear, $selectedQuarter);
            $parent_company_net_profit = $this->financialStatement->income_statement->getItem('21')->getValue($selectedYear, $selectedQuarter);
            if ($total_assets != 0) {
                $this->roa = round(100 * $parent_company_net_profit / $total_assets, 2);
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
            $average_total_assets = $this->financialStatement->balance_statement->getItem('2')->getAverageValue($selectedYear, $selectedQuarter);
            $average_current_liabilities = $this->financialStatement->balance_statement->getItem('30101')->getAverageValue($selectedYear, $selectedQuarter);
            $eBIT = $this->financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
            if ($average_total_assets != $average_current_liabilities) {
                $this->roce = round(100 * $eBIT / ($average_total_assets - $average_current_liabilities), 2);
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
            $average_equities = $this->financialStatement->balance_statement->getItem('302')->getAverageValue($selectedYear, $selectedQuarter);
            if ($average_equities != 0) {
                $this->roea = round(100 * $parent_company_net_profit / $average_equities, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate ROE - Ty suat loi nhuan tren VCSH
     *
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateROE()
    {
        if (!empty($this->financialStatement->balance_statement) &&
            !empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $parent_company_net_profit = $this->financialStatement->income_statement->getItem('21')->getValue($selectedYear, $selectedQuarter);
            $equities = $this->financialStatement->balance_statement->getItem('302')->getValue($selectedYear, $selectedQuarter);
            if ($equities != 0) {
                $this->roe = round(100 * $parent_company_net_profit / $equities, 2);
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
     * Calculate ROS2 - Ty suat loi nhuan rong
     *
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateROS2()
    {
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $parent_company_net_profit = $this->financialStatement->income_statement->getItem('21')->getValue($selectedYear, $selectedQuarter);
            $net_revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            if ($net_revenue != 0) {
                $this->ros2 = round(100 * $parent_company_net_profit / $net_revenue, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate EBITDA Mergin based on balance & income statements
     *
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateEBITDAMargin1()
    {
        if (!empty($this->financialStatement->balance_statement) &&
            !empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $previousPeriod = getPreviousPeriod($selectedYear, $selectedQuarter);
            $eBit = $this->financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
            $tangibleFixedAssets = $this->financialStatement->balance_statement->getItem("102020102");
            $financialLendingStaticAssets = $this->financialStatement->balance_statement->getItem("102020202");
            $intangibleFixedAssets = $this->financialStatement->balance_statement->getItem("102020302");
            $investRealEstate = $this->financialStatement->balance_statement->getItem("1020302");
            $deprecation = abs($tangibleFixedAssets->getValue($selectedYear, $selectedQuarter)) - abs($tangibleFixedAssets->getValue($previousPeriod['year'], $previousPeriod['quarter'])) + abs($financialLendingStaticAssets->getValue($selectedYear, $selectedQuarter)) - abs($financialLendingStaticAssets->getValue($previousPeriod['year'], $previousPeriod['quarter'])) + abs($intangibleFixedAssets->getValue($selectedYear, $selectedQuarter)) - abs($intangibleFixedAssets->getValue($previousPeriod['year'], $previousPeriod['quarter'])) + abs($investRealEstate->getValue($selectedYear, $selectedQuarter)) - abs($investRealEstate->getValue($previousPeriod['year'], $previousPeriod['quarter']));
            $eBITDA = $eBit + $deprecation;
            $net_revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            if ($net_revenue != 0) {
                $this->ebitdaMargin1 = round(100 * $eBITDA / $net_revenue, 2);
            }
        }
        return $this;
    }

    /**
    * Calculate EBITDA Mergin based on the cash flow statement
    *
    * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
    */
    public function calculateEBITDAMargin2()
    {
        if (!empty($this->financialStatement->cash_flow_statement) &&
            !empty($this->financialStatement->income_statement)) {
            $selectedYear = $this->financialStatement->year;
            $selectedQuarter = $this->financialStatement->quarter;
            $eBITDA = $this->financialStatement->cash_flow_statement->getItem('101')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->cash_flow_statement->getItem('10210')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->cash_flow_statement->getItem('10201')->getValue($selectedYear, $selectedQuarter);
            $net_revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            if ($net_revenue != 0) {
                $this->ebitdaMargin2 = round(100 * $eBITDA / $net_revenue, 2);
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
