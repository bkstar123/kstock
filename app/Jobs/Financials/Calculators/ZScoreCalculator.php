<?php
/**
 * ZScoreCalculator
 *
 * @author: tuanha
 * @date: 24-Sept-2022
 */
namespace App\Jobs\Financials\Calculators;

use App\Jobs\Financials\Calculators\BaseCalculator;

class ZScoreCalculator extends BaseCalculator
{
    public $zScore;

    public $z2Score; //Z''-score

    public $x1; //Ti suat von luu dong tren tong tai san

    public $x2; //Ti suat loi nhuan giu lai tren tong tai san

    public $x3; //Ti suat LNTT va lai vay tren tong tai san

    public $x4; //VCSH/Tong no

    public $x5; //Vong quay tong tai san

    /**
     * Calculate Z-Scores for manufactoring enterprises
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\ZScoreCalculator $this
     */
    public function calculateZScores($year = null, $quarter = null)
    {
        $this->zScore = null;
        $this->z2Score = null;
        $this->x1 = null;
        $this->x2 = null;
        $this->x3 = null;
        $this->x4 = null;
        $this->x5 = null;
        if (!empty($this->financialStatement->balance_statement) &&
            !empty($this->financialStatement->income_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            if ($selectedQuarter == 0) {
                $average_assets = $this->financialStatement->balance_statement->getItem('2')->getAverageValue($selectedYear, $selectedQuarter);
                $average_net_working_capital = $this->financialStatement->balance_statement->getItem('101')->getAverageValue($selectedYear, $selectedQuarter) - $this->financialStatement->balance_statement->getItem('30101')->getAverageValue($selectedYear, $selectedQuarter);
                $retained_earnings = $this->financialStatement->balance_statement->getItem('3020111')->getDifferentialValueFromPastPeriod($selectedYear, $selectedQuarter);
                $ebit = $this->financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
                $average_liabilities = $this->financialStatement->balance_statement->getItem('301')->getAverageValue($selectedYear, $selectedQuarter);
                $revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
                $average_equity = $this->financialStatement->balance_statement->getItem('302')->getAverageValue($selectedYear, $selectedQuarter);
            } else {
                // Calculate in the course of 04 consecutive period until the given period
                $average_assets = $this->financialStatement->balance_statement->getItem('2')->getAverageValue($selectedYear, $selectedQuarter, 4);
                $average_net_working_capital = $this->financialStatement->balance_statement->getItem('101')->getAverageValue($selectedYear, $selectedQuarter, 4) - $this->financialStatement->balance_statement->getItem('30101')->getAverageValue($selectedYear, $selectedQuarter, 4);
                $retained_earnings = $this->financialStatement->balance_statement->getItem('3020111')->getDifferentialValueFromPastPeriod($selectedYear, $selectedQuarter, 4);
                $average_equity = $this->financialStatement->balance_statement->getItem('302')->getAverageValue($selectedYear, $selectedQuarter, 4);
                $average_liabilities = $this->financialStatement->balance_statement->getItem('301')->getAverageValue($selectedYear, $selectedQuarter, 4);
                $ebit = $this->financialStatement->income_statement->getItem('15')->getAccumulatedValueFromPastPeriod($selectedYear, $selectedQuarter, 3) + $this->financialStatement->income_statement->getItem('701')->getAccumulatedValueFromPastPeriod($selectedYear, $selectedQuarter, 3);
                $revenue = $this->financialStatement->income_statement->getItem('3')->getAccumulatedValueFromPastPeriod($selectedYear, $selectedQuarter, 3);
            }
            if ($average_assets != 0) {
                $this->x1 = $average_net_working_capital / $average_assets;
                $this->x2 = $retained_earnings / $average_assets;
                $this->x3 = $ebit / $average_assets;
                $this->x5 = $revenue / $average_assets;
            }
            if ($average_liabilities != 0) {
                $this->x4 = $average_equity / $average_liabilities;
            }
            if (!is_null($this->x1) && !is_null($this->x2) && !is_null($this->x3) && !is_null($this->x4)) {
                $this->z2Score = 6.56 * $this->x1 + 3.26 * $this->x2 + 6.72 * $this->x3 + 1.05 * $this->x4;
                if (!is_null($this->x5)) {
                    $this->zScore = 1.2 * $this->x1 + 1.4 *$this->x2 + 3.3 * $this->x3 + 0.64 * $this->x4 + 0.999 * $this->x5;
                }
            }
        }
        return $this;
    }
}
