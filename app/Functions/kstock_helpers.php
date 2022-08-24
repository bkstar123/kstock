<?php
/**
 * kstock helper functions
 *
 * @author: tuanha
 * @date: 04-Aug-2022
 */
if (! function_exists('readVietnameseDongForHuman')) {
    /**
     * Read a Vietnamese Dong value for human
     * For instance, readVietnameseDongForHuman(1000000000) => 1 (Ty VND)
     *
     * @param float
     * @return float | null
     */
    function readVietnameseDongForHuman($value)
    {
        $value = (float) $value;
        return round($value/1000000000, 2) != 0 ? round($value/1000000000, 2) : null;
    }
}

if (! function_exists('getPreviousPeriod')) {
    /**
     * Get the previous period to the current period given by year and quarter
     * For instance, concern year 2022, concern quarter 1, then previous period is 2021 quarter 4
     *
     * @param integer $concernYear
     * @param integer $concernQuarter
     * @return array
     */
    function getPreviousPeriod($concernYear, $concernQuarter)
    {
        $concernYear = (int) $concernYear;
        $concernQuarter = (int) $concernQuarter;
        if ($concernQuarter == 1) {
            return [
                'year' => $concernYear - 1,
                'quarter' => 4
            ];
        } elseif ($concernQuarter == 0) {
            return [
                'year' => $concernYear - 1,
                'quarter' => 0
            ];
        } else {
            return [
                'year' => $concernYear,
                'quarter' => $concernQuarter - 1
            ];
        }
    }
}

if (! function_exists('getLastYearSamePeriod')) {
    /**
     * Get the last year same period to the current period given by year and quarter
     * For instance, concern year 2022, concern quarter 1, then previous period is 2021 quarter 1
     *
     * @param integer $concernYear
     * @param integer $concernQuarter
     * @return array
     */
    function getLastYearSamePeriod($concernYear, $concernQuarter)
    {
        $concernYear = (int) $concernYear;
        $concernQuarter = (int) $concernQuarter;
        return [
            'year' => $concernYear - 1,
            'quarter' => $concernQuarter
        ];
    }
}
