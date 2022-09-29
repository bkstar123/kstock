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
        for ($i = 1; $i <= config('settings.limits'); $i++) {
            $calculator->calculateMScores($year, $quarter);
            array_push($values1, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => !is_null($calculator->m8Score) ? round($calculator->m8Score, 4) : ''
            ]);
            array_push($values2, [
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
            'name' => 'M-Score (Mô hình 8 biến)',
            'alias' => 'M8-Score',
            'group' => "Phân tích mô hình Beneish M-Score",
            'unit' => 'scalar',
            'description' => 'Chỉ số đánh giá khả năng doanh nghiệp gian lận báo cáo tài chính bằng các thủ thuật kế toán, được đề xuất bới <strong>Beneish </strong>. Nếu <span style="color:rgb(230,76,76);"><strong>M-Score &gt; -1.78</strong></span> thì doanh nghiệp có khả năng gian lận báo cáo tài chính, nếu <span style="color:hsl(150,75%,60%);"><strong>M-Score &lt;= -1.78</strong></span> thì doanh nghiệp nhiều khả năng không gian lận báo cáo taif chính. Chỉ số này được tính toán dựa trên số liệu của báo cáo tài chính 4 quý gần nhất bao gồm quý đang xét hoặc dựa trên báo cáo tài chính của cả năm',
            'values' => $values1
        ]);
        array_push($this->content, [
            'name' => 'M-Score (Mô hình 5 biến)',
            'alias' => 'M5-Score',
            'group' => "Phân tích mô hình Beneish M-Score",
            'unit' => 'scalar',
            'description' => 'Chỉ số đánh giá khả năng doanh nghiệp gian lận báo cáo tài chính bằng các thủ thuật kế toán, được đề xuất bới <strong>Beneish </strong>. Nếu <span style="color:rgb(230,76,76);"><strong>M-Score &gt; -2.22</strong></span> thì doanh nghiệp có khả năng gian lận báo cáo tài chính, nếu <span style="color:hsl(150,75%,60%);"><strong>M-Score &lt;= -2.22</strong></span> thì doanh nghiệp nhiều khả năng không gian lận báo cáo taif chính. Chỉ số này được tính toán dựa trên số liệu của báo cáo tài chính 4 quý gần nhất bao gồm quý đang xét hoặc dựa trên báo cáo tài chính của cả năm',
            'values' => $values2
        ]);
        return $this;
    }
}
