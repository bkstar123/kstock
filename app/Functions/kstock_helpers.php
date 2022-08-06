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
     * @param  string $hostname
     * @return string
     */
    function readVietnameseDongForHuman($value)
    {
        return round($value/1000000000, 2) != 0 ? round($value/1000000000, 3) : '';
    }
}
