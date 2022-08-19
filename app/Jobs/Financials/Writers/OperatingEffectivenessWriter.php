<?php
/**
 * OperatingEffectivenessWriter trait
 *
 * @author: tuanha
 * @date: 14-Aug-2022
 */
namespace App\Jobs\Financials\Writers;

use App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator;

trait OperatingEffectivenessWriter
{
    /**
     * Write Receivable Turn-over Ratio
     *
     * @param \App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator $calculator
     * @return $this
     */
    protected function writeReceivableTurnoverRatio(OperatingEffectivenessCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Vòng quay các khoản phải thu khách hàng',
            'alias' => 'Receivable turnover ratio',
            'group' => 'Chỉ số hiệu quả hoạt động',
            'unit' => 'cycles',
            'description' => 'Vòng quay các khoản phải thu khách hàng (Receivable turnover ratio) = Doanh thu thuần / Phải thu ngắn hạn khách hàng bình quân',
            'value' => $calculator->receivableTurnoverRatio
        ]);
        array_push($this->content, [
            'name' => 'Thời gian thu tiền khách hàng bình quân',
            'alias' => 'Average Collection Period',
            'group' => 'Chỉ số hiệu quả hoạt động',
            'unit' => 'days',
            'description' => 'Thời gian thu tiền khách hàng bình quân = 365 / Vòng quay phải thu khách hàng',
            'value' => $calculator->averageCollectionPeriod
        ]);
        return $this;
    }

    /**
     * Write Inventory Turn-over Ratio
     *
     * @param \App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator $calculator
     * @return $this
     */
    protected function writeInventoryTurnoverRatio(OperatingEffectivenessCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Vòng quay hàng tồn kho',
            'alias' => 'Inventory turnover ratio',
            'group' => 'Chỉ số hiệu quả hoạt động',
            'unit' => 'cycles',
            'description' => 'Vòng quay hàng tồn kho (Inventory turnover ratio) = Giá vốn bán hàng / Tổng hàng tồn kho bình quân',
            'value' => $calculator->inventoryTurnoverRatio
        ]);
        array_push($this->content, [
            'name' => 'Thời gian tồn kho bình quân',
            'alias' => 'Average Age of Inventory',
            'group' => 'Chỉ số hiệu quả hoạt động',
            'unit' => 'days',
            'description' => 'Thời gian tồn kho bình quân = 365 / Vòng quay hàng tồn kho',
            'value' => $calculator->averageAgeOfInventory
        ]);
        return $this;
    }

    /**
     * Write Accounts Payable Turnover Ratio
     *
     * @param \App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator $calculator
     * @return $this
     */
    protected function writeAccountsPayableTurnoverRatio(OperatingEffectivenessCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Vòng quay phải trả nhà cung cấp',
            'alias' => 'Accounts payable turnover',
            'group' => 'Chỉ số hiệu quả hoạt động',
            'unit' => 'cycles',
            'description' => 'Chỉ số này cho biết doanh nghiệp đã sử dụng chính sách tín dụng của nhà cung cấp như thế nào. Chỉ số này quá thấp có nghĩa là doanh nghiệp đang tận dụng tín dụng của nhà cung cấp nhiều hơn. Ở khía cạnh tích cực, điều này cho thấy doanh nghiệp đang tận dụng nguồn vốn của nhà cung cấp và giảm áp lực thanh toán trong ngắn hạn. Ở khía cạnh tiêu cực, đây có thể là dấu hiệu của việc thiếu hụt dòng tiền và mất nhiều thời gian hơn để thanh toán cho nhà cung cấp; và điều này có thể ảnh hưởng không tốt đến xếp hạng tín dụng của doanh nghiệp. Vòng quay phải trả nhà cung cấp (Accounts payable turnover) = Giá vốn hàng bán/Phải trả người bán ngắn hạn bình quân',
            'value' => $calculator->accountsPayableTurnoverRatio
        ]);
        array_push($this->content, [
            'name' => 'Thời gian trả tiền nhà cung cấp bình quân',
            'alias' => 'Average Account Payable Duration',
            'group' => 'Chỉ số hiệu quả hoạt động',
            'unit' => 'days',
            'description' => 'Thời gian trả tiền nhà cung cấp bình quân = 365 / Vòng quay phải trả nhà cung cấp',
            'value' => $calculator->averageAccountPayableDuration
        ]);
        return $this;
    }

    /**
     * Write Cash Conversion Cycle
     *
     * @param \App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator $calculator
     * @return $this
     */
    protected function writeCashConversionCycle(OperatingEffectivenessCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Chu kỳ chuyển đổi tiền mặt',
            'alias' => 'Cash Conversion Cycle',
            'group' => 'Chỉ số hiệu quả hoạt động',
            'unit' => 'days',
            'description' => 'Chỉ số này cho biết mất bao lâu kể từ khi doanh nghiệp trả tiền mua các nguyên liệu thô tới khi nhận được tiền mặt trong bán hàng, Casg conversion cycle (CCC) = thời gian tồn kho + thời gian phải thu khách hàng - thời gian trả tiền nhà cung cấp',
            'value' => $calculator->cashConversionCycle
        ]);
        return $this;
    }
}
