<?php
/**
 * ProfitabilityWriter trait
 *
 * @author: tuanha
 * @date: 14-Aug-2022
 */
namespace App\Jobs\Financials\Writers;

use App\Jobs\Financials\Calculators\ProfitabilityCalculator;

trait ProfitabilityWriter
{
    /**
     * Write ROAA - Ty suat loi nhuan tren tong tai san binh quan
     *
     * @param  \App\Jobs\Financials\Calculators\ProfitabilityCalculator $calculator
     * @return $this
     */
    protected function writeROAA(ProfitabilityCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tỷ suất lợi nhuận trên tổng tài sản bình quân (<strong>ROAA</strong>)',
            'alias' => 'ROAA',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => 'Tỷ suất lợi nhuận trên tổng tài sản bình quân (<strong>Return on Average Assets</strong>) cho biết tài sản của một doanh nghiệp đang được sử dụng tốt như thế nào để tạo ra lợi nhuận. <strong style="color:#FF00FF;">Công thức tính = 100% * Lợi nhuận sau thuế của cổ đông của công ty mẹ / Tổng tài sản trung bình</strong>.',
            'value' => $calculator->roaa
        ]);
        return $this;
    }

    /**
     * Write ROA - Ty suat loi nhuan tren tong tai san trong ky
     *
     * @param  \App\Jobs\Financials\Calculators\ProfitabilityCalculator $calculator
     * @return $this
     */
    protected function writeROA(ProfitabilityCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tỷ suất lợi nhuận trên tổng tài sản (<strong>ROA</strong>)',
            'alias' => 'ROA',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => 'Tỷ suất lợi nhuận trên tổng tài sản (<strong>Return on Assets</strong>). <strong style="color:#FF00FF;">Công thức tính = 100% * Lợi nhuận sau thuế của cổ đông của công ty mẹ / Tổng tài sản</strong>',
            'value' => $calculator->roa
        ]);
        return $this;
    }

    /**
     * Write ROCE - Ty suat loi nhuan tren von dai han binh quan
     *
     * @param  \App\Jobs\Financials\Calculators\ProfitabilityCalculator $calculator
     * @return array
     */
    protected function writeROCE(ProfitabilityCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tỷ suất lợi nhuận trên vốn dài hạn bình quân (<strong>ROCE</strong>)',
            'alias' => 'ROCE',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => 'Tỷ suất lợi nhuận trên vốn dài hạn bình quân (<strong>Return on Capital Employed</strong>) đo lường khả năng sinh lời và hiệu quả sử dụng vốn của doanh nghiệp. Chỉ số ROCE có thể đặc biệt hữu ích khi so sánh hiệu quả hoạt động của các công ty trong các lĩnh vực sử dụng nhiều vốn, chẳng hạn như các dịch vụ tiện ích và viễn thông, ROCE xem xét nợ và vốn chủ sở hữu . Điều này có thể giúp phân tích hiệu quả tài chính đối với các công ty có nợ đáng kể. <strong style="color:#FF00FF;">Công thức tính = EBIT * 100% / (Tổng tài sản bình quân - nợ ngắn hạn bình quân)</strong>',
            'value' => $calculator->roce
        ]);
        return $this;
    }

    /**
     * Write ROEA - Ty suat loi nhuan tren VCSH binh quan
     *
     * @param  \App\Jobs\Financials\Calculators\ProfitabilityCalculator $calculator
     * @return array
     */
    protected function writeROEA(ProfitabilityCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tỷ suất lợi nhuận trên vốn chủ sở hữu bình quân (<strong>ROEA</strong>)',
            'alias' => 'ROEA',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => 'Tỷ suất lợi nhuận trên vốn chủ sở hữu bình quân (<strong>Return on Equity Average</strong>) đo lường mức độ hiệu quả trong việc sử dụng vốn chủ sở hữu của doanh nghiệp, ROEA được dùng kết hợp với chỉ số ROE khi phân tích một doanh nghiệp có hiện tượng biến động vốn chủ sở hữu quá lớn trong kỳ phân tích. Vốn chủ sở hữu thường chịu ảnh hưởng bởi các yếu tố: lợi nhuận giữ lại, sáp nhập; phát hành riêng lẻ để tăng vốn… Vì vậy xét trong 1 năm tài chính, nếu doanh nghiệp có sự biến động về vốn chủ sở hữu thì ROE sẽ không phản ánh chính xác khả năng sinh lời của việc sử dụng vốn của doanh nghiệp. ROEA đo lường chính xác hơn về hiệu quả sử dụng vốn của doanh nghiệp trong trường hợp  vốn chủ sở hữu đã có sự biến động trong năm tài chính nhờ việc tính bình quân vốn chủ sở hữu trong kỳ. <strong style="color:#FF00FF;">Công thức tính = 100% * Lợi nhuận sau thuế của cổ đông công ty mẹ / Vốn chủ sở hữu bình quân</strong>',
            'value' => $calculator->roea
        ]);
        return $this;
    }

    /**
     * Write ROE - Ty suat loi nhuan tren VCSH trong kỳ
     *
     * @param  \App\Jobs\Financials\Calculators\ProfitabilityCalculator $calculator
     * @return array
     */
    protected function writeROE(ProfitabilityCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tỷ suất lợi nhuận trên vốn chủ sở (<strong>ROE</strong>)',
            'alias' => 'ROE',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => 'Tỷ suất lợi nhuận trên vốn chủ sở hữu (<strong>Return on Equity</strong>). <strong style="color:#FF00FF;">Công thức tính = 100% * Lợi nhuận sau thuế của cổ đông công ty mẹ / Vốn chủ sở hữu</strong>',
            'value' => $calculator->roe
        ]);
        return $this;
    }

    /**
     * Write ROS - Ty suat loi nhuan rong (theo LNST)
     *
     * @param  \App\Jobs\Financials\Calculators\ProfitabilityCalculator $calculator
     * @return array
     */
    protected function writeROS(ProfitabilityCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tỉ suất lợi nhuận ròng (<strong>ROS</strong>)',
            'alias' => 'ROS',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => 'Tỉ suất lợi nhuận ròng trên doanh thu thuần (<strong>Return On Sales</strong>) thể hiện mối tương quan giữa lợi nhuận được tạo ra dựa trên mỗi đồng doanh số cho biết với một đồng doanh thu thuần từ bán hàng và cung cấp dịch vụ sẽ tạo ra bao nhiêu đồng lợi nhuận ròng, tỷ suất này càng lớn thì hiệu quả hoạt động của doanh nghiệp càng cao. <strong style="color:#FF00FF;">Công thức tính = 100% * Lợi nhuận sau thuế/ Doanh thu thuần</strong>',
            'value' => $calculator->ros
        ]);
        return $this;
    }

    /**
     * Write ROS2 - Ty suat loi nhuan rong (theo LNST co dong cong ty me)
     *
     * @param  \App\Jobs\Financials\Calculators\ProfitabilityCalculator $calculator
     * @return array
     */
    protected function writeROS2(ProfitabilityCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tỉ suất lợi nhuận ròng của cổ đông công ty mẹ (<strong>phiên bản chặt chẽ hơn của ROS</strong>)',
            'alias' => 'ROS2',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => 'Tỉ suất lợi nhuận ròng của cổ đông công ty mẹ. <strong style="color:#FF00FF;">Công thức tính = 100% * Lợi nhuận sau thuế của cổ đông công ty mẹ / Doanh thu thuần</strong>',
            'value' => $calculator->ros2
        ]);
        return $this;
    }

    /**
     * Write EBITDA Margin
     *
     * @param  \App\Jobs\Financials\Calculators\ProfitabilityCalculator $calculator
     * @return array
     */
    protected function writeEBITDAMargin(ProfitabilityCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Biên lợi nhuận trước thuế lãi vay và khấu hao trên doanh thu thuần (<strong>EBITDA margin</strong>)',
            'alias' => 'EBITDA margin',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => 'Hệ số EBITDA/Doanh thu thuần cho biết tỉ lệ phần trăm thu nhập của công ty còn lại sau chi phí hoạt động. Chi phí hoạt động bao gồm giá vốn hàng bán và chi phí bán hàng, chi phí quản lí chung, chi phí hành chính. Tỉ lệ này tập trung vào chi phí hoạt động trực tiếp khi loại trừ ảnh hưởng của cấu trúc vốn của công ty bằng cách bỏ chi phí lãi vay, chi phí khấu hao, khấu hao không dùng tiền mặt và thuế thu nhập. <strong style="color:#FF00FF;">Công thức tính = 100% * EBITDA / doanh thu thuần</strong>',
            'value' => $calculator->ebitdaMargin
        ]);
        return $this;
    }

    /**
     * Write EBIT Margin
     *
     * @param  \App\Jobs\Financials\Calculators\ProfitabilityCalculator $calculator
     * @return array
     */
    protected function writeEBITMargin(ProfitabilityCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Biên lợi nhuận trước thuế và lãi vay trên doanh thu thuần (<strong>EBIT margin</strong>)',
            'alias' => 'EBIT margin',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => 'EBIT là một chỉ số dùng để đánh giá khả năng thu được lợi nhuận của công ty, bằng thu nhập trừ đi các chi phí, nhưng chưa trừ tiền (trả) lãi và thuế thu nhập. Vai trò của chỉ số EBIT là loại bỏ sự khác nhau giữa cấu trúc vốn và tỷ suất thuế giữa các công ty khác nhau. Đánh giá thu nhập của các doanh nghiệp khi quy đồng về mức thuế về 0, và đều không có vay nợ. EBIT/Sales thể hiện hiệu quả quản lý tất cả chi phí hoạt động, bao gồm giá vốn và chi phí bán hàng, chi phí quản lý của doanh nghiệp. <strong style="color:#FF00FF;">Công thức tính = 100% * EBIT / doanh thu thuần</strong>',
            'value' => $calculator->ebitMargin
        ]);
        return $this;
    }

    /**
     * Write Gross profit margin - Bien loi nhuan gop
     *
     * @param  \App\Jobs\Financials\Calculators\ProfitabilityCalculator $calculator
     * @return array
     */
    protected function writeGrossProfitMargin(ProfitabilityCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Biên lợi nhuận gộp (<strong>Gross Profit Margin</strong>)',
            'alias' => 'Gross profit margin',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => 'Biên lợi nhuận gộp hay còn gọi là tỷ suất lợi nhuận gộp đánh giá khả năng sinh lời của doanh nghiệp. <strong style="color:#FF00FF;">Công thức tính = 100% * Lợi nhuận gộp / Doanh thu thuần</strong>',
            'value' => $calculator->grossProfitMargin
        ]);
        return $this;
    }
}
