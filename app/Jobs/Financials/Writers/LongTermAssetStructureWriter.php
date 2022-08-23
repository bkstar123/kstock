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
     * @return $this
     */
    public function writeLongTermAssetToTotalAssetRatio(LongTermAssetStructureCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tài sản dài hạn/Tổng tài sản',
            'alias' => 'Long Term Assets/Total Assets',
            'group' => 'Chỉ số Cơ cấu tài sản dài hạn',
            'unit' => '%',
            'description' => 'Phản ánh tỉ trọng tài sản dài hạn trên tổng tài sản của doanh nghiệp',
            'value' => $calculator->longTermAssetToTotalAssetRatio
        ]);
        return $this;
    }

    /**
     * Write Fixed Asset / Total Asset Ratio
     *
     * @param \App\Jobs\Financials\Calculators\LongTermAssetStructureCalculator 
     * @return $this
     */
    public function writeFixedAssetToTotalAssetRatio(LongTermAssetStructureCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tài sản cố định/Tổng tài sản',
            'alias' => 'Fixed Assets/Total Assets',
            'group' => 'Chỉ số Cơ cấu tài sản dài hạn',
            'unit' => '%',
            'description' => 'Phản ánh tỉ trọng tài sản cố định trên tổng tài sản của doanh nghiệp',
            'value' => $calculator->fixedAssetToTotalAssetRatio
        ]);
        return $this;
    }

    /**
     * Write Tangible Fixed Asset / Fixed Asset Ratio
     *
     * @return \App\Jobs\Financials\Calculators\LongTermAssetStructureCalculator $this
     */
    public function writeTangibleFixedAssetToFixedAssetRatio(LongTermAssetStructureCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tài sản cố định hữu hình/Tài sản cố định',
            'alias' => 'Tangible Fixed Assets/Fixed Assets',
            'group' => 'Chỉ số Cơ cấu tài sản dài hạn',
            'unit' => '%',
            'description' => 'Phản ánh tỉ trọng tài sản cố định hữu hình trên tổng tài sản của doanh nghiệp',
            'value' => $calculator->tangibleFixedAssetToFixedAssetRatio
        ]);
        return $this;
    }

    /**
     * Write Financial Lending Asset / Fixed Asset Ratio
     *
     * @return \App\Jobs\Financials\Calculators\LongTermAssetStructureCalculator $this
     */
    public function writeFinancialLendingAssetToFixedAssetRatio(LongTermAssetStructureCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tài sản cố định cho thuê tài chính/Tài sản cố định',
            'alias' => 'Financial Lending Fixed Assets/Fixed Assets',
            'group' => 'Chỉ số Cơ cấu tài sản dài hạn',
            'unit' => '%',
            'description' => 'Phản ánh tỉ trọng tài sản cố định cho thuê tài chính trên tổng tài sản cố định của doanh nghiệp',
            'value' => $calculator->financialLendingAssetToFixedAssetRatio
        ]);
        return $this;
    }
}
