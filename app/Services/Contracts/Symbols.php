<?php
/**
 * Symbols interface
 *
 * @author: tuanha
 * @date: 27-July-2022
 */
namespace App\Services\Contracts;

interface Symbols
{
    /**
     * Get full financial statement of a symbol
     *
     * @param string $symbol
     * @param int $type
     * @param string $year
     * @param int $quarter
     * @param int $limit
     *
     * @return string | false | null
     */
    public function getFullFinancialStatement(string $symbol, int $type, string $year, int $quarter, int $limit = 1);
}
