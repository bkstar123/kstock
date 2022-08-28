<?php
/**
 * DupontWriter trait
 *
 * @author: tuanha
 * @date: 14-Aug-2022
 */
namespace App\Jobs\Financials\Writers;

use App\Jobs\Financials\Calculators\DupontCalculator;

trait DupontWriter
{
    /**
     * Write Dupont Level 2 Components
     *
     * @param \App\Jobs\Financials\Calculators\DupontCalculator $calculator
     * @return $this
     */
    protected function writeDupontLevel2Components(DupontCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'ROAA',
            'alias' => 'Dupont2-ROAA',
            'group' => "Phân tích Dupont Level 2 (ROEA = $calculator->roea %)",
            'unit' => '%',
            'description' => 'Đánh giá hiệu quả sử dụng tài sản của doanh nghiệp',
            'value' => $calculator->roaa
        ]);
        array_push($this->content, [
            'name' => 'Hệ số đòn bẩy tài chính trung bình',
            'alias' => 'Dupont2-FinancialLeverage',
            'group' => "Phân tích Dupont Level 2 (ROEA = $calculator->roea %)",
            'unit' => 'scalar',
            'description' => 'Phản ánh cơ cấu nguồn vốn của doanh nghiệp',
            'value' => $calculator->averageFinancialLeverage
        ]);
        return $this;
    }

    /**
     * Write Dupont Level 3 Components
     *
     * @param \App\Jobs\Financials\Calculators\DupontCalculator $calculator
     * @return $this
     */
    protected function writeDupontLevel3Components(DupontCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tỷ suất lợi nhuận ròng của cổ đông công ty mẹ (phiên bản chặt chẽ hơn của ROS)',
            'alias' => 'Dupont3-ROS2',
            'group' => "Phân tích Dupont Level 3 (ROEA = $calculator->roea %)",
            'unit' => '%',
            'description' => 'Hiệu quả quản lý và hoạt động của doanh nghiệp',
            'value' => $calculator->ros2
        ]);
        array_push($this->content, [
            'name' => 'Vòng quay tổng tài sản bình quân',
            'alias' => 'Dupont3-Average Total Asset Turnover',
            'group' => "Phân tích Dupont Level 3 (ROEA = $calculator->roea %)",
            'unit' => 'cycles',
            'description' => 'Đánh giá hiệu quả sử dụng tài sản của doanh nghiệp',
            'value' => $calculator->averageTotalAssetTurnOver
        ]);
        array_push($this->content, [
            'name' => 'Hệ số đòn bẩy tài chính trung bình',
            'alias' => 'Dupont3-FinancialLeverage',
            'group' => "Phân tích Dupont Level 3 (ROEA = $calculator->roea %)",
            'unit' => 'scalar',
            'description' => 'Phản ánh cơ cấu nguồn vốn của doanh nghiệp',
            'value' => $calculator->averageFinancialLeverage
        ]);
        return $this;
    }

    /**
     * Write Dupont Level 5 Components
     *
     * @param \App\Jobs\Financials\Calculators\DupontCalculator $calculator
     * @return $this
     */
    protected function writeDupontLevel5Components(DupontCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'LNST của cổ đông công ty mẹ / LNTT',
            'alias' => 'Dupont5-Earning After Tax of Parent Company To Earning Before Tax',
            'group' => "Phân tích Dupont Level 5 (ROEA = $calculator->roea %)",
            'unit' => 'scalar',
            'description' => 'Đánh giá sự ảnh hưởng của thuế TNDN và lợi ích của cổ đông không kiểm soát lên lợi nhuận ròng của cổ đông công ty mẹ',
            'value' => $calculator->earningAfterTaxParentCompanyToEarningBeforeTax
        ]);
        array_push($this->content, [
            'name' => '-----Trong đó, LNST/LNTT',
            'alias' => 'Dupont5-Earning After Tax To Earning Before Tax',
            'group' => "Phân tích Dupont Level 5 (ROEA = $calculator->roea %)",
            'unit' => 'scalar',
            'description' => 'Đánh giá sự ảnh hưởng của thuế TNDN lên lợi nhuận ròng của cổ đông công ty mẹ',
            'value' => $calculator->earningAfterTaxToEarningBeforeTax
        ]);
        array_push($this->content, [
            'name' => 'LNTT/EBIT',
            'alias' => 'Dupont5-Earning Before Tax To EBIT',
            'group' => "Phân tích Dupont Level 5 (ROEA = $calculator->roea %)",
            'unit' => 'scalar',
            'description' => 'Đánh giá sự ảnh hưởng của chi phí lãi vay lên lợi nhuận ròng của cổ đông công ty mẹ',
            'value' => $calculator->earningBeforeTaxToEBIT
        ]);
        array_push($this->content, [
            'name' => 'EBIT/Doanh thu thuần',
            'alias' => 'Dupont5-EBIT Margin',
            'group' => "Phân tích Dupont Level 5 (ROEA = $calculator->roea %)",
            'unit' => '%',
            'description' => 'Tỷ suất lợi nhuận trước thuế và lãi vay',
            'value' => $calculator->ebitMargin
        ]);
        array_push($this->content, [
            'name' => 'Vòng quay tổng tài sản bình quân',
            'alias' => 'Dupont5-Average Total Asset Turnover',
            'group' => "Phân tích Dupont Level 5 (ROEA = $calculator->roea %)",
            'unit' => 'cycles',
            'description' => 'Đánh giá hiệu quả sử dụng tài sản của doanh nghiệp',
            'value' => $calculator->averageTotalAssetTurnOver
        ]);
        array_push($this->content, [
            'name' => 'Hệ số đòn bẩy tài chính trung bình',
            'alias' => 'Dupont5-FinancialLeverage',
            'group' => "Phân tích Dupont Level 5 (ROEA = $calculator->roea %)",
            'unit' => 'scalar',
            'description' => 'Phản ánh cơ cấu nguồn vốn của doanh nghiệp',
            'value' => $calculator->averageFinancialLeverage
        ]);
        return $this;
    }
}
