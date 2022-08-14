<?php
/**
 * Liquidity trait
 *
 * @author: tuanha
 * @date: 14-Aug-2022
 */
namespace App\Jobs\Financials;

trait Liquidity
{
	/**
     * Calculate ROAA
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateLiquidityByCash($financialStatement)
    {
        $selectedYear = $financialStatement->year;
        $selectedQuarter = $financialStatement->quarter;
        $cashAndEquivalents = $financialStatement->balance_statement->getItem('10101')->getValue($selectedYear, $selectedQuarter);
        $shortLiabilities = $financialStatement->balance_statement->getItem('30101')->getValue($selectedYear, $selectedQuarter);
        array_push($this->content, [
            'name' => 'Cash Ratio',
            'group' => 'Chỉ số thanh khoản',
            'unit' => 'scalar',
            'description' => 'Hệ số thanh khoản bằng tiền mặt (Cash Ratio), cho biết doanh nghiệp có bao nhiêu đồng vốn bằng tiền để sẵn sàng thanh toán cho một đồng nợ ngắn hạn, đây là thước đo khả năng thanh khoản của công ty. Hệ số này tính toán khả năng trả nợ ngắn hạn bằng tiền mặt hoặc tương đương tiền mặt. Hệ số thanh khoản bằng tiền mặt nhỏ hơn 0.5 thường được xem là rủi ro. Cash ratio = Tiền & tương đương tiền / Nợ ngắn hạn.',
            'value' => round($cashAndEquivalents / $shortLiabilities, 2)
        ]);
        return $this;
    }

    /**
     * Calculate Quick Ratio
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateQuickRatio($financialStatement)
    {
        $selectedYear = $financialStatement->year;
        $selectedQuarter = $financialStatement->quarter;
        $currentAssets = $financialStatement->balance_statement->getItem('101')->getValue($selectedYear, $selectedQuarter);
        $inventory = $financialStatement->balance_statement->getItem('10104')->getValue($selectedYear, $selectedQuarter);
        $shortLiabilities = $financialStatement->balance_statement->getItem('30101')->getValue($selectedYear, $selectedQuarter);
        array_push($this->content, [
            'name' => 'Qyick Ratio',
            'group' => 'Chỉ số thanh khoản',
            'unit' => 'scalar',
            'description' => 'Hệ số thanh khoản nhanh (Quick Ratio), thể hiện khả năng thanh toán của doanh nghiệp mà không cần thực hiện thanh lý gấp hàng tồn kho. Quick Ratio = (Tài sản ngắn hạn - hàng tồn kho) / Nợ ngắn hạn. Quick Ratio < 0.5 phản ánh doanh nghiệp đang gặp khó khăn trong việc chi trả nợ ngắn hạn, tính thanh khoản thấp, quick ratio > 0.5 phản ánh doanh nghiệp có khả năng thanh toán tốt, tính thanh khoản cao.',
            'value' => round(($currentAssets - $inventory) / $shortLiabilities, 2)
        ]);
        return $this;
    }
}