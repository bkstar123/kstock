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
            'name' => 'Tỷ suất lợi nhuận trên tổng tài sản bình quân',
            'alias' => 'ROAA',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => '<strong>ROAA</strong> - Tỷ suất lợi nhuận trên tổng tài sản bình quân (<strong>Return on Average Assets</strong>) cho biết tài sản của một doanh nghiệp đang được sử dụng tốt như thế nào để tạo ra lợi nhuận. <strong style="color:#FF00FF;">Công thức tính = 100% * Lợi nhuận sau thuế của cổ đông của công ty mẹ / Tổng tài sản trung bình</strong>.',
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
            'name' => 'Tỷ suất lợi nhuận trên tổng tài sản',
            'alias' => 'ROA',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => '<strong>ROA</strong> - Tỷ suất lợi nhuận trên tổng tài sản (<strong>Return on Assets</strong>). <strong style="color:#FF00FF;">Công thức tính = 100% * Lợi nhuận sau thuế của cổ đông của công ty mẹ / Tổng tài sản</strong>',
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
            'name' => 'Tỷ suất lợi nhuận trên vốn dài hạn bình quân',
            'alias' => 'ROCE',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => '<strong>ROCE</strong> - Tỷ suất lợi nhuận trên vốn dài hạn bình quân (<strong>Return on Capital Employed</strong>) đo lường khả năng sinh lời và hiệu quả sử dụng vốn của doanh nghiệp. Chỉ số ROCE có thể đặc biệt hữu ích khi so sánh hiệu quả hoạt động của các công ty trong các lĩnh vực sử dụng nhiều vốn, chẳng hạn như các dịch vụ tiện ích và viễn thông, ROCE xem xét nợ và vốn chủ sở hữu . Điều này có thể giúp phân tích hiệu quả tài chính đối với các công ty có nợ đáng kể. <strong style="color:#FF00FF;">Công thức tính = EBIT * 100% / (Tổng tài sản bình quân - nợ ngắn hạn bình quân)</strong>',
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
            'name' => 'Tỷ suất lợi nhuận trên vốn chủ sở hữu bình quân',
            'alias' => 'ROEA',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => '<strong>ROEA</strong> - Tỷ suất lợi nhuận trên vốn chủ sở hữu bình quân (<strong>Return on Equity Average</strong>) đo lường mức độ hiệu quả trong việc sử dụng vốn chủ sở hữu của doanh nghiệp, ROEA được dùng kết hợp với chỉ số ROE khi phân tích một doanh nghiệp có hiện tượng biến động vốn chủ sở hữu quá lớn trong kỳ phân tích. Vốn chủ sở hữu thường chịu ảnh hưởng bởi các yếu tố: lợi nhuận giữ lại, sáp nhập; phát hành riêng lẻ để tăng vốn… Vì vậy xét trong 1 năm tài chính, nếu doanh nghiệp có sự biến động về vốn chủ sở hữu thì ROE sẽ không phản ánh chính xác khả năng sinh lời của việc sử dụng vốn của doanh nghiệp. ROEA đo lường chính xác hơn về hiệu quả sử dụng vốn của doanh nghiệp trong trường hợp  vốn chủ sở hữu đã có sự biến động trong năm tài chính nhờ việc tính bình quân vốn chủ sở hữu trong kỳ. <strong style="color:#FF00FF;">Công thức tính = 100% * Lợi nhuận sau thuế của cổ đông công ty mẹ / Vốn chủ sở hữu bình quân</strong>',
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
            'name' => 'Tỷ suất lợi nhuận trên vốn chủ sở',
            'alias' => 'ROE',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => '<strong>ROE</strong> - Tỷ suất lợi nhuận trên vốn chủ sở hữu (<strong>Return on Equity</strong>). <strong style="color:#FF00FF;">Công thức tính = 100% * Lợi nhuận sau thuế của cổ đông công ty mẹ / Vốn chủ sở hữu</strong>',
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
            'name' => 'Tỉ suất lợi nhuận ròng',
            'alias' => 'ROS',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => '<strong>ROS</strong> - Tỉ suất lợi nhuận ròng trên doanh thu thuần (<strong>Return On Sales</strong>) thể hiện mối tương quan giữa lợi nhuận được tạo ra dựa trên mỗi đồng doanh số cho biết với một đồng doanh thu thuần từ bán hàng và cung cấp dịch vụ sẽ tạo ra bao nhiêu đồng lợi nhuận ròng, tỷ suất này càng lớn thì hiệu quả hoạt động của doanh nghiệp càng cao. <strong style="color:#d2691e;">Theo Buffet, thì tỉ suất lợi nhuận ròng duy trì đều đặn trên 20% nhiều khả năng là doanh nghiệp có lợi thế cạnh tranh bền vững, nếu thấp hơn 10% thường là dấu hiệu của doanh nghiệp hoạt động trong ngành có sự cạnh tranh gay gắt</strong>. <strong style="color:#FF00FF;">Công thức tính = 100% * Lợi nhuận sau thuế/ Doanh thu thuần</strong>',
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
            'name' => 'Tỉ suất lợi nhuận ròng của cổ đông công ty mẹ',
            'alias' => 'ROS2',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => '<strong>Phiên bản chặt chẽ hơn của ROS</strong> - Tỉ suất lợi nhuận ròng của cổ đông công ty mẹ. <strong style="color:#FF00FF;">Công thức tính = 100% * Lợi nhuận sau thuế của cổ đông công ty mẹ / Doanh thu thuần</strong>',
            'value' => $calculator->ros2
        ]);
        return $this;
    }

    /**
     * Write EBITDA Margin (tinh theo CDKT va Bao cao ket qua HDKD)
     *
     * @param  \App\Jobs\Financials\Calculators\ProfitabilityCalculator $calculator
     * @return array
     */
    protected function writeEBITDAMargin1(ProfitabilityCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Biên lợi nhuận trước thuế lãi vay và khấu hao trên doanh thu thuần (tính theo bảng CĐKT và báo cáo kết quả HĐKD)',
            'alias' => 'EBITDA margin 1',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => '<strong>EBITDA margin</strong> - Hệ số EBITDA/Doanh thu thuần cho biết tỉ lệ phần trăm thu nhập của công ty còn lại sau chi phí hoạt động. Chi phí hoạt động bao gồm giá vốn hàng bán và chi phí bán hàng, chi phí quản lí chung, chi phí hành chính. Tỉ lệ này tập trung vào chi phí hoạt động trực tiếp khi loại trừ ảnh hưởng của cấu trúc vốn của công ty bằng cách bỏ chi phí lãi vay, chi phí khấu hao, khấu hao không dùng tiền mặt và thuế thu nhập. <strong style="color:#FF00FF;">Công thức tính = 100% * EBITDA / doanh thu thuần</strong>',
            'value' => $calculator->ebitdaMargin1
        ]);
        return $this;
    }

    /**
     * Write EBITDA Margin (tinh theo luu chuyen tien te)
     *
     * @param  \App\Jobs\Financials\Calculators\ProfitabilityCalculator $calculator
     * @return array
     */
    protected function writeEBITDAMargin2(ProfitabilityCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Biên lợi nhuận trước thuế lãi vay và khấu hao trên doanh thu thuần (tính theo báo cáo lưu chuyển tiền tệ)',
            'alias' => 'EBITDA margin 2',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => '<strong>EBITDA margin</strong> - Hệ số EBITDA/Doanh thu thuần, trong đó dữ liệu về chi phí lãi vay, khấu hao TSCĐ & BĐS Đầu tư lấy từ báo cáo lưu chuyển tiền tệ để tính EBITDA',
            'value' => $calculator->ebitdaMargin2
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
            'name' => 'Biên lợi nhuận trước thuế và lãi vay trên doanh thu thuần',
            'alias' => 'EBIT margin',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => '<strong>EBIT margin</strong> - EBIT/doanh thu thuần thể hiện hiệu quả quản lý tất cả chi phí hoạt động, bao gồm giá vốn và chi phí bán hàng, chi phí quản lý của doanh nghiệp. EBIT là một chỉ số dùng để đánh giá khả năng thu được lợi nhuận của công ty, bằng thu nhập trừ đi các chi phí hoạt động, nhưng chưa trừ tiền trả lãi vay và thuế thu nhập. Vai trò của chỉ số EBIT là loại bỏ sự khác nhau giữa cấu trúc vốn và tỷ suất thuế giữa các công ty khác nhau, đánh giá thu nhập của các doanh nghiệp khi quy đồng về mức thuế về 0, và đều không có vay nợ. . <strong style="color:#FF00FF;">Công thức tính = 100% * EBIT / doanh thu thuần</strong>',
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
            'name' => 'Biên lợi nhuận gộp',
            'alias' => 'Gross profit margin',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => '<strong>Gross Profit Margin</strong> - Biên lợi nhuận gộp hay còn gọi là tỷ suất lợi nhuận gộp đánh giá khả năng sinh lời của doanh nghiệp. <strong style="color:#d2691e;">Theo quan điểm của Buffet, thì tỉ suất lợi nhuận gộp trên 40% thường là doanh nghiệp có lợi thế cạnh tranh bền vững, nếu thấp hơn 20% thường là dấu hiệu của ngành có sự cạnh tranh gay gắt</strong>. <strong style="color:#FF00FF;">Công thức tính = 100% * Lợi nhuận gộp / Doanh thu thuần</strong>',
            'value' => $calculator->grossProfitMargin
        ]);
        return $this;
    }
}
