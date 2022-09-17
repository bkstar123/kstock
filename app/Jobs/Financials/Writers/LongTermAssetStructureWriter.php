<?php
/**
 * LongTermAssetStructureWriter trait
 *
 * @author: tuanha
 * @date: 14-Aug-2022
 */
namespace App\Jobs\Financials\Writers;

use App\Jobs\Financials\Calculators\LongTermAssetStructureCalculator;

trait LongTermAssetStructureWriter
{
    /**
     * Write Long Term Asset / Total Asset Ratio
     *
     * @param \App\Jobs\Financials\Calculators\LongTermAssetStructureCalculator
     * @param  int $year
     * @param  int $quarter
     * @return $this
     */
    public function writeLongTermAssetToTotalAssetRatio(LongTermAssetStructureCalculator $calculator, $year, $quarter)
    {
        $values = [];
        for ($i = 1; $i < 6; $i++) {
            array_push($values, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => $calculator->calculateLongTermAssetToTotalAssetRatio($year, $quarter)->longTermAssetToTotalAssetRatio
            ]);
            $previous = getPreviousPeriod($year, $quarter);
            $year = $previous['year'];
            $quarter = $previous['quarter'];
        }
        array_push($this->content, [
            'name' => 'Tài sản dài hạn/Tổng tài sản',
            'alias' => 'Long Term Assets/Total Assets',
            'group' => 'Chỉ số Cơ cấu tài sản dài hạn',
            'unit' => '%',
            'description' => 'Phản ánh tỉ trọng tài sản dài hạn trên tổng tài sản của doanh nghiệp',
            'values' => $values
        ]);
        return $this;
    }

    /**
     * Write Fixed Asset / Total Asset Ratio
     *
     * @param \App\Jobs\Financials\Calculators\LongTermAssetStructureCalculator
     * @param  int $year
     * @param  int $quarter
     * @return $this
     */
    public function writeFixedAssetToTotalAssetRatio(LongTermAssetStructureCalculator $calculator, $year, $quarter)
    {
        $values = [];
        for ($i = 1; $i < 6; $i++) {
            array_push($values, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => $calculator->calculateFixedAssetToTotalAssetRatio($year, $quarter)->fixedAssetToTotalAssetRatio
            ]);
            $previous = getPreviousPeriod($year, $quarter);
            $year = $previous['year'];
            $quarter = $previous['quarter'];
        }
        array_push($this->content, [
            'name' => 'Tài sản cố định/Tổng tài sản',
            'alias' => 'Fixed Assets/Total Assets',
            'group' => 'Chỉ số Cơ cấu tài sản dài hạn',
            'unit' => '%',
            'description' => 'Phản ánh tỉ trọng tài sản cố định trên tổng tài sản của doanh nghiệp',
            'values' => $values
        ]);
        return $this;
    }

    /**
     * Write Tangible Fixed Asset / Fixed Asset Ratio
     *
     * @param \App\Jobs\Financials\Calculators\LongTermAssetStructureCalculator
     * @param  int $year
     * @param  int $quarter
     * @return $this
     */
    public function writeTangibleFixedAssetToFixedAssetRatio(LongTermAssetStructureCalculator $calculator, $year, $quarter)
    {
        $values = [];
        for ($i = 1; $i < 6; $i++) {
            array_push($values, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => $calculator->calculateTangibleFixedAssetToFixedAssetRatio($year, $quarter)->tangibleFixedAssetToFixedAssetRatio
            ]);
            $previous = getPreviousPeriod($year, $quarter);
            $year = $previous['year'];
            $quarter = $previous['quarter'];
        }
        array_push($this->content, [
            'name' => 'Tài sản cố định hữu hình/Tài sản cố định',
            'alias' => 'Tangible Fixed Assets/Fixed Assets',
            'group' => 'Chỉ số Cơ cấu tài sản dài hạn',
            'unit' => '%',
            'description' => 'Phản ánh tỉ trọng tài sản cố định hữu hình trên tổng tài sản của doanh nghiệp',
            'values' => $values
        ]);
        return $this;
    }

    /**
     * Write Financial Lending Asset / Fixed Asset Ratio
     *
     * @param \App\Jobs\Financials\Calculators\LongTermAssetStructureCalculator
     * @param  int $year
     * @param  int $quarter
     * @return $this
     */
    public function writeFinancialLendingAssetToFixedAssetRatio(LongTermAssetStructureCalculator $calculator, $year, $quarter)
    {
        $values = [];
        for ($i = 1; $i < 6; $i++) {
            array_push($values, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => $calculator->calculateFinancialLendingAssetToFixedAssetRatio($year, $quarter)->financialLendingAssetToFixedAssetRatio
            ]);
            $previous = getPreviousPeriod($year, $quarter);
            $year = $previous['year'];
            $quarter = $previous['quarter'];
        }
        array_push($this->content, [
            'name' => 'Tài sản cố định cho thuê tài chính/Tài sản cố định',
            'alias' => 'Financial Lending Fixed Assets/Fixed Assets',
            'group' => 'Chỉ số Cơ cấu tài sản dài hạn',
            'unit' => '%',
            'description' => 'Phản ánh tỉ trọng tài sản cố định cho thuê tài chính trên tổng tài sản cố định của doanh nghiệp',
            'values' => $values
        ]);
        return $this;
    }

    /**
     * Write Intangible Asset / Fixed Asset Ratio
     *
     * @param \App\Jobs\Financials\Calculators\LongTermAssetStructureCalculator
     * @param  int $year
     * @param  int $quarter
     * @return $this
     */
    public function writeIntangibleAssetToFixedAssetRatio(LongTermAssetStructureCalculator $calculator, $year, $quarter)
    {
        $values = [];
        for ($i = 1; $i < 6; $i++) {
            array_push($values, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => $calculator->calculateIntangibleAssetToFixedAssetRatio($year, $quarter)->intangibleAssetToFixedAssetRatio
            ]);
            $previous = getPreviousPeriod($year, $quarter);
            $year = $previous['year'];
            $quarter = $previous['quarter'];
        }
        array_push($this->content, [
            'name' => 'Tài sản cố định vô hình/Tài sản cố định',
            'alias' => 'Intangible Fixed Assets/Fixed Assets',
            'group' => 'Chỉ số Cơ cấu tài sản dài hạn',
            'unit' => '%',
            'description' => 'Phản ánh tỉ trọng tài sản cố định vô hình trên tổng tài sản cố định của doanh nghiệp',
            'values' => $values
        ]);
        return $this;
    }

    /**
     * Write Construction In Progress / Fixed Asset Ratio
     *
     * @param \App\Jobs\Financials\Calculators\LongTermAssetStructureCalculator
     * @param  int $year
     * @param  int $quarter
     * @return $this
     */
    public function writeConstructionInProgressToFixedAssetRatio(LongTermAssetStructureCalculator $calculator, $year, $quarter)
    {
        $values = [];
        for ($i = 1; $i < 6; $i++) {
            array_push($values, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => $calculator->calculateConstructionInProgressToFixedAssetRatio($year, $quarter)->constructionInProgressToFixedAssetRatio
            ]);
            $previous = getPreviousPeriod($year, $quarter);
            $year = $previous['year'];
            $quarter = $previous['quarter'];
        }
        array_push($this->content, [
            'name' => 'Chi phí xây dựng cơ bản dở dang/Tài sản cố định',
            'alias' => 'Construction in Progress/Fixed Assets',
            'group' => 'Chỉ số Cơ cấu tài sản dài hạn',
            'unit' => '%',
            'description' => 'Phản ánh tỉ trọng chi phí xây dựng cơ bản dở dang trên tổng tài sản cố định của doanh nghiệp',
            'values' => $values
        ]);
        return $this;
    }
}
