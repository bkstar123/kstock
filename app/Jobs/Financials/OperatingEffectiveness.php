<?php
/**
 * OperatingEffectiveness trait
 *
 * @author: tuanha
 * @date: 14-Aug-2022
 */
namespace App\Jobs\Financials;

trait OperatingEffectiveness
{
    /**
     * Calculate Receivable Turn-over Ratio
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateReceivableTurnoverRatio($financialStatement)
    {
        if (!empty($financialStatement->income_statement) && !empty($financialStatement->balance_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $revenue = $financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            $averageCurrentCustomerReceivables = array_sum($financialStatement->balance_statement->getItem('1010301')->getValues())/2; 
            if ($averageCurrentCustomerReceivables != 0) {
                array_push($this->content, [
                    'name' => 'Vòng quay các khoản phải thu khách hàng',
                    'alias' => 'Receivable turnover ratio',
                    'group' => 'Chỉ số hiệu quả hoạt động',
                    'unit' => 'cycles',
                    'description' => 'Vòng quay các khoản phải thu khách hàng (Receivable turnover ratio) = Doanh thu thuần / Phải thu ngắn hạn khách hàng bình quân',
                    'value' => round($revenue / $averageCurrentCustomerReceivables, 4)
                ]);
                array_push($this->content, [
                    'name' => 'Thời gian thu tiền khách hàng bình quân',
                    'alias' => 'Average Collection Period',
                    'group' => 'Chỉ số hiệu quả hoạt động',
                    'unit' => 'days',
                    'description' => 'Thời gian thu tiền khách hàng bình quân = 365 / Vòng quay phải thu khách hàng',
                    'value' => round(365 * $averageCurrentCustomerReceivables/$revenue, 0)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate Inventory Turn-over Ratio
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateInventoryTurnoverRatio($financialStatement)
    {
        if (!empty($financialStatement->income_statement) && !empty($financialStatement->balance_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $cogs = $financialStatement->income_statement->getItem('4')->getValue($selectedYear, $selectedQuarter);
            $averageInventories = array_sum($financialStatement->balance_statement->getItem('10104')->getValues())/2; 
            if ($averageInventories != 0) {
                array_push($this->content, [
                    'name' => 'Vòng quay hàng tồn kho',
                    'alias' => 'Inventory turnover ratio',
                    'group' => 'Chỉ số hiệu quả hoạt động',
                    'unit' => 'cycles',
                    'description' => 'Vòng quay hàng tồn kho (Inventory turnover ratio) = Giá vốn bán hàng / Tổng hàng tồn kho bình quân',
                    'value' => round($cogs / $averageInventories, 4)
                ]);
                array_push($this->content, [
                    'name' => 'Thời gian tồn kho bình quân',
                    'alias' => 'Average Age of Inventory',
                    'group' => 'Chỉ số hiệu quả hoạt động',
                    'unit' => 'days',
                    'description' => 'Thời gian tồn kho bình quân = 365 / Vòng quay hàng tồn kho',
                    'value' => round(365 * $averageInventories/$cogs, 0)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate Accounts Payable Turnover Ratio
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateAccountsPayableTurnoverRatio($financialStatement)
    {
        if (!empty($financialStatement->income_statement) && !empty($financialStatement->balance_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $cogs = $financialStatement->income_statement->getItem('4')->getValue($selectedYear, $selectedQuarter);
            $averageCurrentAccountPayables = array_sum($financialStatement->balance_statement->getItem('3010103')->getValues())/2; 
            if ($averageCurrentAccountPayables != 0) {
                array_push($this->content, [
                    'name' => 'Vòng quay phải trả nhà cung cấp',
                    'alias' => 'Accounts payable turnover',
                    'group' => 'Chỉ số hiệu quả hoạt động',
                    'unit' => 'cycles',
                    'description' => 'Chỉ số này cho biết doanh nghiệp đã sử dụng chính sách tín dụng của nhà cung cấp như thế nào. Chỉ số này quá thấp có nghĩa là doanh nghiệp đang tận dụng tín dụng của nhà cung cấp nhiều hơn. Ở khía cạnh tích cực, điều này cho thấy doanh nghiệp đang tận dụng nguồn vốn của nhà cung cấp và giảm áp lực thanh toán trong ngắn hạn. Ở khía cạnh tiêu cực, đây có thể là dấu hiệu của việc thiếu hụt dòng tiền và mất nhiều thời gian hơn để thanh toán cho nhà cung cấp; và điều này có thể ảnh hưởng không tốt đến xếp hạng tín dụng của doanh nghiệp. Vòng quay phải trả nhà cung cấp (Accounts payable turnover) = Giá vốn hàng bán/Phải trả người bán ngắn hạn bình quân',
                    'value' => round($cogs / $averageCurrentAccountPayables, 4)
                ]);
                array_push($this->content, [
                    'name' => 'Thời gian trả tiền nhà cung cấp bình quân',
                    'alias' => 'Average Account Payable Duration',
                    'group' => 'Chỉ số hiệu quả hoạt động',
                    'unit' => 'days',
                    'description' => 'Thời gian trả tiền nhà cung cấp bình quân = 365 / Vòng quay phải trả nhà cung cấp',
                    'value' => round(365 * $averageCurrentAccountPayables/$cogs, 0)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate Cash Conversion Cycle
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateCashConversionCycle($financialStatement)
    {
        if (!empty($financialStatement->income_statement) && !empty($financialStatement->balance_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $revenue = $financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            $averageCurrentCustomerReceivables = array_sum($financialStatement->balance_statement->getItem('1010301')->getValues())/2;
            $cogs = $financialStatement->income_statement->getItem('4')->getValue($selectedYear, $selectedQuarter);
            $averageInventories = array_sum($financialStatement->balance_statement->getItem('10104')->getValues())/2;
            $averageCurrentAccountPayables = array_sum($financialStatement->balance_statement->getItem('3010103')->getValues())/2; 
            $dso = round(365 * $averageCurrentCustomerReceivables/$revenue, 0);
            $dpo = round(365 * $averageCurrentAccountPayables/$cogs, 0);
            $dio = round(365 * $averageInventories/$cogs, 0);
            if ($averageCurrentAccountPayables != 0) {
                array_push($this->content, [
                    'name' => 'Chu kỳ chuyển đổi tiền mặt',
                    'alias' => 'Cash Conversion Cycle',
                    'group' => 'Chỉ số hiệu quả hoạt động',
                    'unit' => 'days',
                    'description' => 'Chỉ số này cho biết mất bao lâu kể từ khi doanh nghiệp trả tiền mua các nguyên liệu thô tới khi nhận được tiền mặt trong bán hàng, Casg conversion cycle (CCC) = thời gian tồn kho + thời gian phải thu khách hàng - thời gian trả tiền nhà cung cấp',
                    'value' => $dso + $dio - $dpo
                ]);
            }
        }
        return $this;
    }
}