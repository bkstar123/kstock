<?php
/**
 * Capex trait
 *
 * @author: tuanha
 * @date: 14-Aug-2022
 */
namespace App\Jobs\Financials;

trait Capex
{
    /**
     * Calculate CFO/CAPEX Ratio
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateCfoToCapexRatio($financialStatement)
    {
        if (!empty($financialStatement->cash_flow_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $cfo = $financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter);
            $capex = $financialStatement->cash_flow_statement->getItem('201')->getValue($selectedYear, $selectedQuarter) + $financialStatement->cash_flow_statement->getItem('202')->getValue($selectedYear, $selectedQuarter);
            if ($capex < 0) {
                array_push($this->content, [
                    'name' => 'CFO/CAPEX',
                    'alias' => 'CFO/CAPEX',
                    'group' => 'Chỉ số CAPEX',
                    'unit' => 'scalar',
                    'description' => 'Đánh giá xem hoạt động kinh doanh của doanh nghiệp có tạo ra đủ lượng tiền mặt để tài trợ cho hoạt động mua sắm sửa chữa tài sản cố định của doanh nghiệp hay không. Nếu chỉ số này < 1 điều đó đồng nghĩa với việc doanh nghiệp có thể cần phải vay thêm tiền để tài trợ cho hoạt động mua sắm TSCĐ của mình',
                    'value' => round($cfo / abs($capex), 4)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate Capex/Net Profit Ratio
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateCapexToNetProfitRatio($financialStatement)
    {
        if (!empty($financialStatement->cash_flow_statement) && !empty($financialStatement->income_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $net_profit = $financialStatement->income_statement->getItem('19')->getValue($selectedYear, $selectedQuarter);
            $capex = $financialStatement->cash_flow_statement->getItem('201')->getValue($selectedYear, $selectedQuarter) + $financialStatement->cash_flow_statement->getItem('202')->getValue($selectedYear, $selectedQuarter);
            if ($capex < 0) {
                array_push($this->content, [
                    'name' => 'CAPEX/Lợi nhuận ròng',
                    'alias' => 'CAPEX/NetProfit',
                    'group' => 'Chỉ số CAPEX',
                    'unit' => '%',
                    'description' => 'Đánh giá mức độ tỉ lệ đầu tư vào tài sản cố định của doanh nghiệp trên lợi nhuận ròng (LNST) mà doanh nghiệp tạo ra. Nếu chỉ số < 50% ổn định trong nhiều năm, khả năng doanh nghiệp có lợi thế cạnh tranh, nếu chỉ số < 25% đó có thể là một doanh nghiệp có lợi thế cạnh tranh bền vững',
                    'value' => round(100 * abs($capex) / $net_profit, 2)
                ]);
            }
        }
        return $this;
    }
}
