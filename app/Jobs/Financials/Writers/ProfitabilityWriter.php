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
            'name' => 'Tỷ suất lợi nhuận trên tổng tài sản bình quân (ROAA)',
            'alias' => 'ROAA',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => 'Tỷ suất lợi nhuận trên tổng tài sản bình quân (Return on Average Assets). Chỉ số này cho biết tài sản của một doanh nghiệp đang được sử dụng tốt như thế nào để tạo ra lợi nhuận. ROAA = 100% * Lợi nhuận sau thuế của cổ đông của công ty mẹ / Tổng tài sản trung bình. Với tổng tài sản trung bình = (tài sản đầu kỳ + tài sản cuối kì)/2',
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
            'name' => 'Tỷ suất lợi nhuận trên tổng tài sản trong kỳ (ROA)',
            'alias' => 'ROA',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => 'Tỷ suất lợi nhuận trên tổng tài sản trong kỳ (Return on Assets). ROA = 100% * Lợi nhuận sau thuế của cổ đông của công ty mẹ / Tổng tài sản',
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
            'name' => 'Tỷ suất lợi nhuận trên vốn dài hạn bình quân (ROCE)',
            'alias' => 'ROCE',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => 'Tỷ suất lợi nhuận trên vốn dài hạn bình quân (Return on Capital Employed), đo lường khả năng sinh lời và hiệu quả sử dụng vốn của doanh nghiệp, nó cho biết mức độ sinh lời của doanh nghiệp từ số vốn đầu tư ban đầu. Chỉ số ROCE có thể đặc biệt hữu ích khi so sánh hiệu quả hoạt động của các công ty trong các lĩnh vực sử dụng nhiều vốn. Chẳng hạn như các dịch vụ tiện ích và viễn thông. Điều này là do không giống như các nguyên tắc cơ bản khác như  lợi nhuận trên vốn chủ sở hữu  (ROE), vốn chỉ phân tích khả năng sinh lời liên quan đến vốn chủ sở hữu của cổ đông công ty, ROCE xem xét nợ và vốn chủ sở hữu . Điều này có thể giúp phân tích hiệu quả tài chính đối với các công ty có nợ đáng kể. ROCE = EBIT x 100% / (Tổng tài sản bình quân - nợ ngắn hạn bình quân). (Bình quân: tính trung bình con số đầu kì và cuối kì).',
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
            'name' => 'Tỷ suất lợi nhuận trên vốn chủ sở hữu bình quân (ROEA)',
            'alias' => 'ROEA',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => 'Tỷ suất lợi nhuận trên vốn chủ sở hữu bình quân (Return on Equity Average), đo lường mức độ hiệu quả trong việc sử dụng vốn chủ sở hữu của doanh nghiệp, ROEA được dùng kết hợp với chỉ số ROE khi phân tích một doanh nghiệp có hiện tượng biến động vốn chủ sở hữu quá lớn trong kỳ phân tích. Chỉ số ROE được tính bằng tỷ lệ giữa lợi nhuận ròng và vốn chủ sở hữu. Lợi nhuận ròng khá dễ để xác định và ít bị ảnh hưởng từ bên ngoài. Tuy nhiên vốn chủ sở hữu thường chịu ảnh hưởng bởi các yếu tố: lợi nhuận giữ lại, sáp nhập; phát hành riêng lẻ để tăng vốn… Vì vậy xét trong 1 năm tài chính, nếu doanh nghiệp có sự biến động về vốn chủ sở hữu thì ROE sẽ không phản ánh chính xác khả năng sinh lời của việc sử dụng vốn của doanh nghiệp. ROEA đo lường chính xác hơn về hiệu quả sử dụng vốn của doanh nghiệp trong trường hợp  vốn chủ sở hữu đã có sự biến động trong năm tài chính nhờ việc tính bình quân vốn chủ sở hữu trong kỳ. ROEA = 100% x Lợi nhuận sau thuế của cổ đông công ty mẹ / Vốn chủ sở hữu bình quân. (Bình quân: tính trung bình con số đầu kì và cuối kì).',
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
            'name' => 'Tỷ suất lợi nhuận trên vốn chủ sở trong kỳ (ROE)',
            'alias' => 'ROE',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => 'Tỷ suất lợi nhuận trên vốn chủ sở hữu trong kỳ (Return on Equity). ROE = 100% x Lợi nhuận sau thuế của cổ đông công ty mẹ / Vốn chủ sở trong kỳ. ',
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
            'name' => 'Tỉ suất lợi nhuận ròng (ROS) - theo LNST',
            'alias' => 'ROS',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => 'Tỉ suất lợi nhuận ròng trên doanh thu thuần (Return On Sales – ROS) là tỉ lệ thể hiện mối tương quan giữa lợi nhuận được tạo ra dựa trên mỗi đồng doanh số. Chỉ tiêu này cho biết với một đồng doanh thu thuần từ bán hàng và cung cấp dịch vụ sẽ tạo ra bao nhiêu đồng lợi nhuận. Tỷ suất này càng lớn thì hiệu quả hoạt động của doanh nghiệp càng cao. ROS = 100 * Lợi nhuận sau thuế/ Doanh thu thuần',
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
            'name' => 'Tỉ suất lợi nhuận ròng (ROS) - theo LNST của cổ đông công ty mẹ',
            'alias' => 'ROS2',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => 'Tỉ suất lợi nhuận ròng trên doanh thu thuần (Return On Sales – ROS), ROS = 100 * Lợi nhuận sau thuế của cổ đông công ty mẹ / Doanh thu thuần',
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
            'name' => 'Biên lợi nhuận trước thuế lãi vay và khấu hao trên doanh thu thuần (EBITDA margin)',
            'alias' => 'EBITDA margin',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => 'Hệ số EBITDA/Doanh thu (EBITDA/Sales) là một thước đo tài chính được sử dụng để đánh giá lợi nhuận của công ty bằng cách so sánh doanh thu của công ty với thu nhập. Cụ thể hơn, số liệu này cho biết tỉ lệ phần trăm thu nhập của công ty còn lại sau chi phí hoạt động. Chi phí hoạt động bao gồm giá vốn hàng bán và chi phí bán hàng, chi phí quản lí chung, chi phí hành chính. Tỉ lệ này tập trung vào chi phí hoạt động trực tiếp khi loại trừ ảnh hưởng của cấu trúc vốn của công ty bằng cách bỏ lãi, chi phí khấu hao, khấu hao không dùng tiền mặt và thuế thu nhập. EBITDA/Sales = 100% * EBITDA / doanh thu thuần',
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
            'name' => 'Biên lợi nhuận trước thuế và lãi vay trên doanh thu thuần (EBIT margin)',
            'alias' => 'EBIT margin',
            'group' => 'Chỉ số sinh lời',
            'unit' => '%',
            'description' => 'EBIT là một chỉ số dùng để đánh giá khả năng thu được lợi nhuận của công ty, bằng thu nhập trừ đi các chi phí, nhưng chưa trừ tiền (trả) lãi và thuế thu nhập. Vai trò của chỉ số EBIT là loại bỏ sự khác nhau giữa cấu trúc vốn và tỷ suất thuế giữa các công ty khác nhau. Đánh giá thu nhập của các doanh nghiệp khi quy đồng về mức thuế về 0, và đều không có vay nợ. EBIT/Sales thể hiện hiệu quả quản lý tất cả chi phí hoạt động, bao gồm giá vốn và chi phí bán hàng, chi phí quản lý của doanh nghiệp. EBIT/Sales = 100% * EBIT / doanh thu thuần',
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
            'description' => 'Biên lợi nhuận gộp (Gross Profit Margin) hay còn gọi là tỷ suất lợi nhuận gộp, là một chỉ tiêu quan trọng đánh giá khả năng sinh lời của doanh nghiệp. Chỉ tiêu này được tính theo tỷ lệ phần trăm và cho biết với mỗi đồng doanh thu tạo ra thì doanh nghiệp thu về được bao nhiêu đồng lợi nhuận gộp. GPM = 100% * Lợi nhuận gộp / Doanh thu thuần',
            'value' => $calculator->grossProfitMargin
        ]);
        return $this;
    }
}
