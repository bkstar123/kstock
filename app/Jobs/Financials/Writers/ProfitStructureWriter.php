<?php
/**
 * ProfitStructureWriter trait
 *
 * @author: tuanha
 * @date: 14-Aug-2022
 */
namespace App\Jobs\Financials\Writers;

use App\Jobs\Financials\Calculators\ProfitStructureCalculator;

trait ProfitStructureWriter
{
    /**
     * Write Operating Profit / Earning Before Tax (EBT) Ratio
     *
     * @param \App\Jobs\Financials\Calculators\ProfitStructureCalculator $calculator
     * @param  int $year
     * @param  int $quarter
     * @return $this
     */
    protected function writeOperatingProfitToEBTRatio(ProfitStructureCalculator $calculator, $year, $quarter)
    {
        $values = [];
        for ($i = 1; $i < 6; $i++) {
            array_push($values, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => $calculator->calculateOperatingProfitToEBTRatio($year, $quarter)->operatingProfitToEBT
            ]);
            $previous = getPreviousPeriod($year, $quarter);
            $year = $previous['year'];
            $quarter = $previous['quarter'];
        }
        array_push($this->content, [
            'name' => 'Lợi nhuận thuần từ hoạt động kinh doanh / Lợi nhuận trước thuế',
            'alias' => 'Operating Profit/EBT',
            'group' => 'Chỉ số cơ cấu lợi nhuận',
            'unit' => '%',
            'description' => 'Đánh giá xem lợi nhuận của doanh nghiệp có chủ yếu đến từ các hoạt động kinh doanh cốt lõi hay không, nếu chỉ số này thấp nghĩa là có thể doanh nghiệp có nguồn thu nhập bất thường nào đó và thường sẽ không lặp lại trong các giai đoạn tiếp theo. <strong style="color:#FF00FF;">Lợi nhuận thuần từ hoạt đông kinh doanh = Lợi nhật gộp + lợi nhuận tài chính - Chi phí hoạt động. Chi phí hoạt động = Chi phí bán hàng + Chi phí quản lý doanh nghiệp. Lợi nhuận tài chính = Doanh thu tài chính - Chi phí tài chính</strong>',
            'values' => $values
        ]);
        return $this;
    }
}
