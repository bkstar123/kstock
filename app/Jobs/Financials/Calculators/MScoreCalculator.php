<?php
/**
 * MScoreCalculator
 *
 * @author: tuanha
 * @date: 26-Sept-2022
 */
namespace App\Jobs\Financials\Calculators;

use App\Jobs\Financials\Calculators\BaseCalculator;

class MScoreCalculator extends BaseCalculator
{
    public $mScore; // Do luong kha nang quan tri loi nhuan

    public $dsri; // Chi so phai thu khach hang so voi doanh thu

    public $gmi; // Chi so ti le lai gop

    public $aqi; // Chi so chat luong tai san

    public $sgi; // Chi so tang truong doanh thu ban hang

    public $depi; // Chi so ti le khau hao

    public $sgai; // Chi so chi phi ban hang va quan ly doanh nghiep

    public $tata; // Chi so bien don tich so voi tong tai san

    public $lvgi; // Chi so don bay tai chinh

    /**
     * Calculate Z-Scores for manufactoring enterprises
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\MScoreCalculator $this
     */
    public function calculateMScores($year = null, $quarter = null)
    {
        $this->mScore = null;
        $this->dsri = null;
        $this->gmi = null;
        $this->aqi = null;
        $this->sgi = null;
        $this->depi = null;
        $this->sgai = null;
        $this->tata = null;
        $this->lvgi = null;
        if (!empty($this->financialStatement->balance_statement) &&
            !empty($this->financialStatement->income_statement) &&
            !empty($this->financialStatement->cash_flow_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $yearT_1 = $selectedYear - 1;
            $quarterT_1 = $selectedQuarter;
            $ppeT = $this->financialStatement->balance_statement->getItem('1020201')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->balance_statement->getItem('1020202')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->balance_statement->getItem('1020402')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->balance_statement->getItem('10203')->getValue($selectedYear, $selectedQuarter);
            $ppeT_1 = $this->financialStatement->balance_statement->getItem('1020201')->getValue($yearT_1, $quarterT_1) + $this->financialStatement->balance_statement->getItem('1020202')->getValue($yearT_1, $quarterT_1) + $this->financialStatement->balance_statement->getItem('1020402')->getValue($yearT_1, $quarterT_1) + $this->financialStatement->balance_statement->getItem('10203')->getValue($yearT_1, $quarterT_1);
            $current_receivablesT = $this->financialStatement->balance_statement->getItem('1010301')->getValue($selectedYear, $selectedQuarter);
            $current_receivablesT_1 = $this->financialStatement->balance_statement->getItem('1010301')->getValue($yearT_1, $quarterT_1);
            $current_assetsT = $this->financialStatement->balance_statement->getItem('101')->getValue($selectedYear, $selectedQuarter);
            $current_assetsT_1 = $this->financialStatement->balance_statement->getItem('101')->getValue($yearT_1, $quarterT_1);
            $total_assetsT = $this->financialStatement->balance_statement->getItem('2')->getValue($selectedYear, $selectedQuarter);
            $total_assetsT_1 = $this->financialStatement->balance_statement->getItem('2')->getValue($yearT_1, $quarterT_1);
            if ($selectedQuarter == 0) {

            } else {
                $revenueT = $this->financialStatement->income_statement->getItem('3')->getAccumulatedValueFromPastPeriod($selectedYear, $selectedQuarter, 3);
                $revenueT_1 = $this->financialStatement->income_statement->getItem('3')->getAccumulatedValueFromPastPeriod($yearT_1, $quarterT_1, 3);
                $gross_profitT = $this->financialStatement->income_statement->getItem('5')->getAccumulatedValueFromPastPeriod($selectedYear, $selectedQuarter, 3);
                $gross_profitT_1 =  $this->financialStatement->income_statement->getItem('5')->getAccumulatedValueFromPastPeriod($yearT_1, $quarterT_1, 3);
            }
            if ($revenueT != 0 && $revenueT_1 != 0) {
                $dsriT = $current_receivablesT / $revenueT;
                $dsriT_1 = $current_receivablesT_1 / $revenueT_1;
                $gmiT = $gross_profitT / $revenueT;
                $gmiT_1 = $gross_profitT_1 / $revenueT_1;
                if ($dsriT_1 != 0) {
                    $this->dsri = $dsriT / $dsriT_1;
                }
                if ($gmiT != 0) {
                    $this->gmi = $gmiT_1 / $gmiT;
                }
            }
            if ($total_assetsT != 0 && $total_assetsT_1 != 0) {
                $aqiT = 1 - ($current_assetsT + $ppeT) / $total_assetsT;
                $aqiT_1 = 1 - ($current_assetsT_1 + $ppeT_1) / $total_assetsT_1;
                if ($aqiT_1 != 0) {
                    $this->aqi = $aqiT / $aqiT_1;
                }
            }         
        }
        return $this;
    }
}
