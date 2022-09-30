<?php
/**
 * MScoreWriter trait
 *
 * @author: tuanha
 * @date: 29-Sept-2022
 */
namespace App\Jobs\Financials\Writers;

use App\Jobs\Financials\Calculators\MScoreCalculator;

trait MScoreWriter
{
    /**
     * Write M-Score
     *
     * @param \App\Jobs\Financials\Calculators\MScoreCalculator $calculator
     * @param  int $year
     * @param  int $quarter
     * @return $this
     */
    protected function writeMScore(MScoreCalculator $calculator, $year, $quarter)
    {
        $values1 = [];
        $values2 = [];
        $values3 = [];
        $values4 = [];
        $values5 = [];
        $values6 = [];
        $values7 = [];
        $values8 = [];
        $values9 = [];
        $values10 = [];
        for ($i = 1; $i <= config('settings.limits'); $i++) {
            $calculator->calculateMScores($year, $quarter);
            array_push($values1, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => !is_null($calculator->dsri) ? round($calculator->dsri, 4) : ''
            ]);
            array_push($values2, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => !is_null($calculator->gmi) ? round($calculator->gmi, 4) : ''
            ]);
            array_push($values3, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => !is_null($calculator->aqi) ? round($calculator->aqi, 4) : ''
            ]);
            array_push($values4, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => !is_null($calculator->sgi) ? round($calculator->sgi, 4) : ''
            ]);
            array_push($values5, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => !is_null($calculator->depi) ? round($calculator->depi, 4) : ''
            ]);
            array_push($values6, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => !is_null($calculator->sgai) ? round($calculator->sgai, 4) : ''
            ]);
            array_push($values7, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => !is_null($calculator->tata) ? round($calculator->tata, 4) : ''
            ]);
            array_push($values8, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => !is_null($calculator->lvgi) ? round($calculator->lvgi, 4) : ''
            ]);
            array_push($values9, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => !is_null($calculator->m8Score) ? round($calculator->m8Score, 4) : ''
            ]);
            array_push($values10, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => !is_null($calculator->m5Score) ? round($calculator->m5Score, 4) : ''
            ]);
            $previous = getPreviousPeriod($year, $quarter);
            $year = $previous['year'];
            $quarter = $previous['quarter'];
        }
        array_push($this->content, [
            'name' => 'Chỉ số phải thu khách hàng so với doanh thu (DSRI)',
            'alias' => 'DSRI',
            'group' => "Phân tích mô hình Beneish M-Score",
            'unit' => 'scalar',
            'description' => 'Chỉ số này so sánh tỷ lệ phải thu trên tổng doanh thu của một năm so với năm trước đó, nếu chỉ số này lớn hơn 1, tỷ lệ phải thu trên tổng doanh thu của một năm lớn hơn năm trước đó, một khoản tăng bất thường trong số ngày phải thu sẽ có thể là dấu hiệu cho việc thao túng doanh thu',
            'values' => $values1
        ]);
        array_push($this->content, [
            'name' => 'Chỉ số tỷ lệ lãi gộp (GMI)',
            'alias' => 'GMI',
            'group' => "Phân tích mô hình Beneish M-Score",
            'unit' => 'scalar',
            'description' => 'Đây là chỉ số đo lường tỷ lệ lãi gộp của năm trước so với năm nay. Lãi gộp sẽ bị giảm khi tỷ lệ này lớn hơn 1, tăng khi tỷ lệ này nhỏ hơn 1. Kỳ vọng của chỉ số này là một công ty với mức lợi nhuận thấp hơn năm trước thì có nhiều động cơ để thao túng lợi nhuận hơn',
            'values' => $values2
        ]);
        array_push($this->content, [
            'name' => 'Chỉ số chất lượng tài sản (AQI)',
            'alias' => 'AQI',
            'group' => "Phân tích mô hình Beneish M-Score",
            'unit' => 'scalar',
            'description' => 'Chỉ số này phanr ánh chất lượng tài sản của doanh nghiệp, tài sản chất lượng nhất của doanh nghiệp là tài sản cố định (PPE), đây là loại tài sản dài hạn mang lại lợi ích kinh tế trong tương lai một cách chắc chắn. Các thành phần khác của tài sản dài hạn như phải thu dài hạn của khách hàng, đầu tư tàu chính, chi phí trả trước đều không mang lại lợi ích cốt lõi cho hoạt động kinh doanh của doanh nghiệp. AQI > 1 là dấu hiệu cho thấy nền tảng cốt lõi của doanh nghiệp giảm sút hoặc công ty đang sử dụng phương pháp trì hoãn chi phí như ghi nhận tăng chi phí trả trước hoặc đánh giá quá cao vào các khoản đầu tư dài hạn',
            'values' => $values3
        ]);
        array_push($this->content, [
            'name' => 'Chỉ số tăng trưởng doanh thu bán hàng (SGI)',
            'alias' => 'SGI',
            'group' => "Phân tích mô hình Beneish M-Score",
            'unit' => 'scalar',
            'description' => 'Chỉ số thể hiện sự so sánh giữa doanh thu năm nay và doanh thu năm trước. Nếu lớn hơn 1, chỉ số thể hiện sự tăng trưởng dương trong doanh thu của doanh nghiệp. Thực chất tăng trưởng doanh thu không phải là chỉ số đo lường sự thao túng lợi nhuận, tuy nhiên những công ty có tăng trưởng doanh thu càng lớn, áp lực đặt lên ban lãnh đạo càng nhiều trong việc duy trì hiệu quả hoạt động của công ty và đạt được mục tiêu mới. Vì vậy những công ty này sẽ có nhiều động cơ để thao túng lợi nhuận hơn',
            'values' => $values4
        ]);
        array_push($this->content, [
            'name' => 'Chỉ số tỷ lệ khấu hao (DEPI)',
            'alias' => 'DEPI',
            'group' => "Phân tích mô hình Beneish M-Score",
            'unit' => 'scalar',
            'description' => 'Đo lường tỷ lệ khấu hao năm trước so với năm sau. Nếu tỷ lệ này lớn hơn 1 có nghĩa rằng tài sản đang bị khấu hao ở mức độ chậm hơn. Điều này chỉ ra rằng công ty có thể nâng giả định về số năm của tài sản lên, hoặc áp dụng một phương pháp mới có thể giúp tăng lợi nhuận',
            'values' => $values5
        ]);
        array_push($this->content, [
            'name' => 'Chỉ số chi phí bán hàng và quản lý doanh nghiệp (SGAI)',
            'alias' => 'SGAI',
            'group' => "Phân tích mô hình Beneish M-Score",
            'unit' => 'scalar',
            'description' => 'Chỉ số SG&A của năm sau so với năm trước. Nếu chỉ số này lớn hơn 1, tỷ lệ SGA/Sale của năm sau tăng so với năm trước, đây có thể là 1 dấu hiệu thao túng lợi nhuận',
            'values' => $values6
        ]);
        array_push($this->content, [
            'name' => 'Chỉ số đòn bẩy tài chính (LVGI)',
            'alias' => 'LVGI',
            'group' => "Phân tích mô hình Beneish M-Score",
            'unit' => 'scalar',
            'description' => 'LVGI đo lường đòn bẩy tài chính trong năm so với năm trước. Nếu LVGI lớn hơn 1, chỉ số thể hiện sự tăng lên trong đòn bẩy tài chính và đây là 1 động lực để thao túng lợi nhuận',
            'values' => $values7
        ]);
        array_push($this->content, [
            'name' => 'Chỉ số biến dồn tích so với tổng tài sản (TATA)',
            'alias' => 'TATA',
            'group' => "Phân tích mô hình Beneish M-Score",
            'unit' => 'scalar',
            'description' => 'TATA đo lường chỉ số biến dồn tích so với tổng tài sản, đo lường sự khác biệt giữa lợi nhuận kế toán sau thuế và dòng tiền thực chất tạo ra từ hoạt động kinh doanh của doanh nghiệp, việc chia cho tổng tài sản là để so sánh giữa các doanh nghiệp có quy mô khác nhau. Doanh nghiệp nào chủ yếu phát sinh lựi nhuận ké toán mà không phát sinh dòng tiền từ HĐKD sẽ có rủi ro thao túng lợi nhuận cao hơn',
            'values' => $values8
        ]);
        array_push($this->content, [
            'name' => 'M-Score (Mô hình 8 biến)',
            'alias' => 'M8-Score',
            'group' => "Phân tích mô hình Beneish M-Score",
            'unit' => 'scalar',
            'description' => 'Chỉ số đánh giá khả năng doanh nghiệp gian lận báo cáo tài chính bằng các thủ thuật kế toán, được đề xuất bới <strong>Beneish </strong>. Nếu <span style="color:rgb(230,76,76);"><strong>M-Score &gt; -1.78</strong></span> thì doanh nghiệp có khả năng gian lận báo cáo tài chính, nếu <span style="color:hsl(150,75%,60%);"><strong>M-Score &lt;= -1.78</strong></span> thì doanh nghiệp nhiều khả năng không gian lận báo cáo taif chính. Chỉ số này được tính toán dựa trên số liệu của báo cáo tài chính 4 quý gần nhất bao gồm quý đang xét hoặc dựa trên báo cáo tài chính của cả năm',
            'values' => $values9
        ]);
        array_push($this->content, [
            'name' => 'M-Score (Mô hình 5 biến)',
            'alias' => 'M5-Score',
            'group' => "Phân tích mô hình Beneish M-Score",
            'unit' => 'scalar',
            'description' => 'Chỉ số đánh giá khả năng doanh nghiệp gian lận báo cáo tài chính bằng các thủ thuật kế toán, được đề xuất bới <strong>Beneish </strong>. Nếu <span style="color:rgb(230,76,76);"><strong>M-Score &gt; -2.22</strong></span> thì doanh nghiệp có khả năng gian lận báo cáo tài chính, nếu <span style="color:hsl(150,75%,60%);"><strong>M-Score &lt;= -2.22</strong></span> thì doanh nghiệp nhiều khả năng không gian lận báo cáo taif chính. Chỉ số này được tính toán dựa trên số liệu của báo cáo tài chính 4 quý gần nhất bao gồm quý đang xét hoặc dựa trên báo cáo tài chính của cả năm',
            'values' => $values10
        ]);
        return $this;
    }
}
