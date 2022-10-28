<?php
/**
 * DupontWriter trait
 *
 * @author: tuanha
 * @date: 14-Aug-2022
 */
namespace App\Jobs\Financials\Writers;

use App\Jobs\Financials\Calculators\ZScoreCalculator;

trait ZScoreWriter
{
    /**
     * Write Z-Score for manufactoring enterprises
     *
     * @param \App\Jobs\Financials\Calculators\ZScoreCalculator $calculator
     * @param  int $year
     * @param  int $quarter
     * @return $this
     */
    protected function writeZScore(ZScoreCalculator $calculator, $year, $quarter)
    {
        $values1 = [];
        $values2 = [];
        $values3 = [];
        $values4 = [];
        $values5 = [];
        $values6 = [];
        $values7 = [];
        for ($i = 1; $i <= config('settings.limits'); $i++) {
            array_push($values1, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => round($calculator->calculateZScores($year, $quarter)->x1, 4)
            ]);
            array_push($values2, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => round($calculator->x2, 4)
            ]);
            array_push($values3, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => round($calculator->x3, 4)
            ]);
            array_push($values4, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => round($calculator->x4, 4)
            ]);
            array_push($values5, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => round($calculator->x5, 4)
            ]);
            array_push($values6, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => round($calculator->zScore, 4)
            ]);
            array_push($values7, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => round($calculator->z2Score, 4)
            ]);
            $previous = getPreviousPeriod($year, $quarter);
            $year = $previous['year'];
            $quarter = $previous['quarter'];
        }
        array_push($this->content, [
            'name' => 'Vốn lưu động bình quân / Tổng tài sản bình quân',
            'alias' => 'Average Net Working Capitals / Average Assets',
            'group' => "Phân tích mô hình Altman Z-Score",
            'unit' => 'scalar',
            'description' => 'Đo lường tài sản lưu động ròng của doanh nghiệp so với tổng nguồn vốn',
            'values' => $values1
        ]);
        array_push($this->content, [
            'name' => 'Tổng lợi nhuận giữa lại 4 quý gần nhất / Tổng tài sản bình quân',
            'alias' => 'Retained Earnings / Average Assets',
            'group' => "Phân tích mô hình Altman Z-Score",
            'unit' => 'scalar',
            'description' => 'Đo lường mức độ đòn bẩy của một doanh nghiệp. Doanh nghiệp với tỉ số lợi nhuận giữ lại trên tổng tài sản cao tài trợ cho tài sản bằng cách giữ lại lợi nhuận mà không vay nợ nhiều',
            'values' => $values2
        ]);
        array_push($this->content, [
            'name' => 'Tổng lợi nhuận trước thuế và lãi vay 4 quý gần nhất / tổng tài sản bình quân',
            'alias' => 'EBIT / Average Assets',
            'group' => "Phân tích mô hình Altman Z-Score",
            'unit' => 'scalar',
            'description' => 'Đo lường hiệu quả thực tế của việc sử dụng tài sản của doanh nghiệp khi không xét đến yếu tố ảnh hưởng của chính sách lãi suất và cấu trúc nguồn vốn',
            'values' => $values3
        ]);
        array_push($this->content, [
            'name' => 'VCSH bình quân / Tổng nợ bình quân',
            'alias' => 'Average Equities / Average Liabilities',
            'group' => "Phân tích mô hình Altman Z-Score",
            'unit' => 'scalar',
            'description' => 'So sánh tài sản ròng của doanh nghiệp với các khoản nợ từ đó đánh giá mức độ phụ thuộc của doanh nghiệp vào vay nợ',
            'values' => $values4
        ]);
        array_push($this->content, [
            'name' => 'Tổng doanh thu 4 quý gần nhất / Tổng tài sản bình quân',
            'alias' => 'Revenues / Average Assets',
            'group' => "Phân tích mô hình Altman Z-Score",
            'unit' => 'scalar',
            'description' => 'Vòng quay tổng tài sản, đánh giá hiệu quả tạo ra doanh thu từ tài sản doanh nghiệp',
            'values' => $values5
        ]);
        array_push($this->content, [
            'name' => '==> Z-Score (dành cho doanh nghiệp sản xuất)',
            'alias' => 'Z-Score',
            'group' => "Phân tích mô hình Altman Z-Score",
            'unit' => 'scalar',
            'description' => 'Chỉ số đánh giá nguy cơ phá sản của doanh nghiệp sản xuất trong vòng 2 năm tới được đưa ra bởi <strong>Altman </strong>. Nếu <span style="color:rgb(230,76,76);"><strong>Z-Score &lt;= 1.81</strong></span> thì doanh nghiệp nằm trong vùng nguy hiểm có nguy cơ phá sản cao, nếu <span style="color:hsl(60,75%,60%);">1.81 &gt; Z-Score &lt; 2.99</span> thì doanh nghiệp nằm trong vùng cảnh báo về mức độ căng thẳng tài chính, nếu <span style="color:hsl(150,75%,60%);"><strong>Z-Score &gt;= 2.99</strong></span> thì doanh nghiệp nằm trong vùng an toàn chưa có nguy cơ phá sản. Chỉ số này được tính toán dựa trên số liệu của báo cáo tài chính 4 quý gần nhất bao gồm quý đang xét hoặc dựa trên báo cáo tài chính của cả năm',
            'values' => $values6
        ]);
        array_push($this->content, [
            'name' => '==> Z2-Score (dành cho doanh nghiệp phi sản xuất)',
            'alias' => 'Z2-Score',
            'group' => "Phân tích mô hình Altman Z-Score",
            'unit' => 'scalar',
            'description' => 'Chỉ số đánh giá nguy cơ phá sản của doanh nghiệp sản xuất trong vòng 2 năm tới được đưa ra bởi <strong>Altman </strong>. Nếu <span style="color:rgb(230,76,76);"><strong>Z2-Score &lt;= 1.1</strong></span> thì doanh nghiệp nằm trong vùng nguy hiểm có nguy cơ phá sản cao, nếu <span style="color:hsl(60,75%,60%);">1.1 &gt; Z2-Score &lt; 2.6</span> thì doanh nghiệp nằm trong vùng cảnh báo về mức độ căng thẳng tài chính, nếu <span style="color:hsl(150,75%,60%);"><strong>Z2-Score &gt;= 2.6</strong></span> thì doanh nghiệp nằm trong vùng an toàn chưa có nguy cơ phá sản. Chỉ số này được tính toán dựa trên số liệu của báo cáo tài chính 4 quý gần nhất bao gồm quý đang xét hoặc dựa trên báo cáo tài chính của cả năm',
            'values' => $values7
        ]);
        return $this;
    }
}
