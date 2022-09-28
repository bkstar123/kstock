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
    public $roaa; //Ty suat loi nhuan tren tong tai san binh quan

    public $roce; //Ty suat loi nhuan tren von su dung dai han binh quan

    public $roa; //Ty suat loi nhuan tren tong tai san trong ki

    public $roe; //Ty suat loi nhuan tren VCSH trong ky

    public $roea; //Ty suat loi nhuan tren VCSH binh quan

    public $ros; //Ty suat loi nhuan rong (theo LNST)

    public $ros2; //Ty suat loi nhuan rong (theo LNST co dong cong ty me)

    public $ebitdaMargin1; //Bien loi nhuan truoc thue, lai vay va khau hao tinh theo CDKT va bao cao ket qua HDKD

    public $ebitdaMargin2; //Bien loi nhuan truoc thue, lai vay va khau hao tinh theo LCTT

    public $ebitMargin; //Bien loi nhuan truoc thue va lai vay

    public $grossProfitMargin; //Bien loi nhuan gop

    public $rota; //Ti suat loi nhuan truoc thue va lai vay tren tong tai san binh quan

    /**
     * Calculate ROAA - Ty suat loi nhuan tren tong tai san binh quan
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateROAA($year = null, $quarter = null)
    {
        $this->roaa = null;
        if (!empty($this->financialStatement->balance_statement) &&
            !empty($this->financialStatement->income_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
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
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateROTA($year = null, $quarter = null)
    {
        $this->rota = null;
        if (!empty($this->financialStatement->balance_statement) &&
            !empty($this->financialStatement->income_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
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
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateROA($year = null, $quarter = null)
    {
        $this->roa = null;
        if (!empty($this->financialStatement->balance_statement) &&
            !empty($this->financialStatement->income_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
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
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateROCE($year = null, $quarter = null)
    {
        $this->roce = null;
        if (!empty($this->financialStatement->balance_statement) &&
            !empty($this->financialStatement->income_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
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
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateROEA($year = null, $quarter = null)
    {
        $this->roea = null;
        if (!empty($this->financialStatement->balance_statement) &&
            !empty($this->financialStatement->income_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
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
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateROE($year = null, $quarter = null)
    {
        $this->roe = null;
        if (!empty($this->financialStatement->balance_statement) &&
            !empty($this->financialStatement->income_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
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
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateROS($year = null, $quarter = null)
    {
        $this->ros = null;
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
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
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateROS2($year = null, $quarter = null)
    {
        $this->ros2 = null;
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
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
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateEBITDAMargin1($year = null, $quarter = null)
    {
        $this->ebitdaMargin1 = null;
        if (!empty($this->financialStatement->balance_statement) &&
            !empty($this->financialStatement->income_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $previousPeriod = getPreviousPeriod($selectedYear, $selectedQuarter);
            $eBit = $this->financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
            $tangibleFixedAssets = $this->financialStatement->balance_statement->getItem("102020102");
            $financialLendingStaticAssets = $this->financialStatement->balance_statement->getItem("102020202");
            $intangibleFixedAssets = $this->financialStatement->balance_statement->getItem("102020302");
            $investRealEstate = $this->financialStatement->balance_statement->getItem("1020302");
            $deprecation = abs($tangibleFixedAssets->getDifferentialValueFromPastPeriod($selectedYear, $selectedQuarter)) + abs($financialLendingStaticAssets->getDifferentialValueFromPastPeriod($selectedYear, $selectedQuarter)) + abs($intangibleFixedAssets->getDifferentialValueFromPastPeriod($selectedYear, $selectedQuarter)) + abs($investRealEstate->getDifferentialValueFromPastPeriod($selectedYear, $selectedQuarter));
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
    * @param int $year
    * @param int $quarter
    * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
    */
    public function calculateEBITDAMargin2($year = null, $quarter = null)
    {
        $this->ebitdaMargin2 = null;
        if (!empty($this->financialStatement->cash_flow_statement) &&
            !empty($this->financialStatement->income_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
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
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateEBITMargin($year = null, $quarter = null)
    {
        $this->ebitMargin = null;
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
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
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\ProfitabilityCaculator $this
     */
    public function calculateGrossProfitMargin($year = null, $quarter = null)
    {
        $this->grossProfitMargin = null;
        if (!empty($this->financialStatement->income_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $grossProfit = $this->financialStatement->income_statement->getItem('5')->getValue($selectedYear, $selectedQuarter);
            $net_revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            if ($net_revenue != 0) {
                $this->grossProfitMargin = round(100 * $grossProfit / $net_revenue, 2);
            }
        }
        return $this;
    }
}
