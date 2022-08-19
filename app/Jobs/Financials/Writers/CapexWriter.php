<?php
/**
 * CapexWriter trait
 *
 * @author: tuanha
 * @date: 14-Aug-2022
 */
namespace App\Jobs\Financials\Writers;

use App\Jobs\Financials\Calculators\CapexCalculator;

trait CapexWriter
{
    /**
     * Write CFO/CAPEX Ratio
     *
     * @param \App\Jobs\Financials\Calculators\CapexCalculator $calculator
     * @return $this
     */
    protected function writeCfoToCapexRatio(CapexCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'CFO/CAPEX',
            'alias' => 'CFO/CAPEX',
            'group' => 'Chỉ số CAPEX',
            'unit' => 'scalar',
            'description' => 'Đánh giá xem hoạt động kinh doanh của doanh nghiệp có tạo ra đủ lượng tiền mặt để tài trợ cho hoạt động mua sắm sửa chữa tài sản cố định của doanh nghiệp hay không. Nếu chỉ số này < 1 điều đó đồng nghĩa với việc doanh nghiệp có thể cần phải vay thêm tiền để tài trợ cho hoạt động mua sắm TSCĐ của mình. Hệ số này được tính nếu như có phát sinh chi phí CAPEX và sẽ mang dấu của dòng tiền HĐKD CFO',
            'value' => $calculator->cfoToCapexRatio
        ]);
        return $this;
    }

    /**
     * Write Capex/Net Profit Ratio
     *
     * @param \App\Jobs\Financials\Calculators\CapexCalculator $calculator
     * @return $this
     */
    protected function writeCapexToNetProfitRatio(CapexCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'CAPEX/Lợi nhuận ròng',
            'alias' => 'CAPEX/NetProfit',
            'group' => 'Chỉ số CAPEX',
            'unit' => '%',
            'description' => 'Đánh giá mức độ tỉ lệ đầu tư vào tài sản cố định của doanh nghiệp trên lợi nhuận ròng (LNST) mà doanh nghiệp tạo ra. Nếu chỉ số < 50% ổn định trong nhiều năm, khả năng doanh nghiệp có lợi thế cạnh tranh, nếu chỉ số < 25% đó có thể là một doanh nghiệp có lợi thế cạnh tranh bền vững. Hệ số này được tính nếu như có phát sinh chi phí CAPEX',
            'value' => $calculator->capexToNetProfitRatio
        ]);
        return $this;
    }
}
