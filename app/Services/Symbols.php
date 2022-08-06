<?php
/**
 * Symbols service - Interact with API endpoints that relate to enterprise securities symbols
 *
 * @author: tuanha
 * @date: 27-July-2022
 */
namespace App\Services;

use Exception;
use App\Services\Base;
use App\Services\Contracts\Symbols as SymbolsInterface;

class Symbols extends Base implements SymbolsInterface
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
    public function getFullFinancialStatement(string $symbol, int $type, string $year, int $quarter, int $limit = 1)
    {
        $path = "/symbols/$symbol/full-financial-reports?type=$type&year=$year&quarter=$quarter&limit=$limit";
        try {
            $res = $this->client->request('GET', $path);
            if ($res->getStatusCode() == '200') {
                return $res->getBody()->getContents();
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
