<?php
/**
 * CurrentAssetStructureWriter trait
 *
 * @author: tuanha
 * @date: 14-Aug-2022
 */
namespace App\Jobs\Financials\Writers;

use App\Jobs\Financials\Calculators\CurrentAssetStructureCalculator;

trait CurrentAssetStructureWriter
{
    /**
     * Write Current Assets / Total Assets Ratio
     *
     * @param \App\Jobs\Financials\Calculators\CurrentAssetStructureCalculator 
     * @return $this
     */
    public function writeCurrentAssetToTotalAssetRatio(CurrentAssetStructureCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tài sản ngắn hạn / Tổng tài sản',
            'alias' => 'Current Assets/Total Assets',
            'group' => 'Chỉ số Cơ cấu tài sản ngắn hạn',
            'unit' => '%',
            'description' => 'Phản ánh tỉ trọng tài sản ngắn hạn trên tổng tài sản của doanh nghiệp',
            'value' => $calculator->currentAssetToTotalAssetRatio
        ]);
        return $this;
    }

     /**
     * write Cash / Current Assets Ratio
     *
     * @param \App\Jobs\Financials\Calculators\CurrentAssetStructureCalculator 
     * @return $this
     */
    public function writeCashToCurrentAssetRatio(CurrentAssetStructureCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tiền/Tài sản ngắn hạn',
            'alias' => 'Cash/Current Assets',
            'group' => 'Chỉ số Cơ cấu tài sản ngắn hạn',
            'unit' => '%',
            'description' => 'Phản ánh tỉ trọng tiền mặt trên tài sản ngắn hạn của doanh nghiệp',
            'value' => $calculator->cashToCurrentAssetRatio
        ]);
        return $this;
    }

    /**
     * Write Current Financial Investing / Current Assets Ratio
     *
     * @param \App\Jobs\Financials\Calculators\CurrentAssetStructureCalculator 
     * @return $this
     */
    public function writeCurrentFinancialInvestingToCurrentAssetRatio(CurrentAssetStructureCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Đầu tư tài chính ngắn hạn/Tài sản ngắn hạn',
            'alias' => 'Current Financial Investing/Current Assets',
            'group' => 'Chỉ số Cơ cấu tài sản ngắn hạn',
            'unit' => '%',
            'description' => 'Phản ánh tỉ trọng đầu tư tài chính ngắn hạn trên tài sản ngắn hạn của doanh nghiệp',
            'value' => $calculator->currentFinancialInvestingToCurrentAssetRatio
        ]);
        return $this;
    }

    /**
     * Write Current Receivable Account / Current Assets Ratio
     *
     * @param \App\Jobs\Financials\Calculators\CurrentAssetStructureCalculator 
     * @return $this
     */
    public function writeCurrentReceivableAccountToCurrentAssetRatio(CurrentAssetStructureCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Phải thu ngắn hạn/Tài sản ngắn hạn',
            'alias' => 'Current Receivable Accounts/Current Assets',
            'group' => 'Chỉ số Cơ cấu tài sản ngắn hạn',
            'unit' => '%',
            'description' => 'Phản ánh tỉ trọng các khoản phải thu khách hàng ngắn hạn trên tài sản ngắn hạn của doanh nghiệp',
            'value' => $calculator->currentReceivableAccountToCurrentAssetRatio
        ]);
        return $this;
    }

    /**
     * Write Inventories / Current Assets Ratio
     *
     * @param \App\Jobs\Financials\Calculators\CurrentAssetStructureCalculator 
     * @return $this
     */
    public function writeInventoryToCurrentAssetRatio(CurrentAssetStructureCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Hàng tồn kho/Tài sản ngắn hạn',
            'alias' => 'Inventories/Current Assets',
            'group' => 'Chỉ số Cơ cấu tài sản ngắn hạn',
            'unit' => '%',
            'description' => 'Phản ánh tỉ trọng hàng tồn kho trên tài sản ngắn hạn của doanh nghiệp',
            'value' => $calculator->inventoryToCurrentAssetRatio
        ]);
        return $this;
    }

    /**
     * Write other Current Assets / Current Assets Ratio
     *
     * @param \App\Jobs\Financials\Calculators\CurrentAssetStructureCalculator 
     * @return $this
     */
    public function calculateOtherCurrentAssetToCurrentAssetRatio(CurrentAssetStructureCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tài sản ngắn hạn khác/Tài sản ngắn hạn',
            'alias' => 'Other Current Assets/Current Assets',
            'group' => 'Chỉ số Cơ cấu tài sản ngắn hạn',
            'unit' => '%',
            'description' => 'Phản ánh tỉ trọng tài sản ngắn hạn khác trên tài sản ngắn hạn của doanh nghiệp',
            'value' => $calculator->otherCurrentAssetToCurrentAssetRatio
        ]);
        return $this;
    }
}
