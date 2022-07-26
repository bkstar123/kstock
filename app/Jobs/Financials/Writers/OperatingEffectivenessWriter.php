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
     * @param  int $year
     * @param  int $quarter
     * @return $this
     */
    protected function writeReceivableTurnoverRatio(OperatingEffectivenessCalculator $calculator, $year, $quarter)
    {
        $values1 = [];
        $values2 = [];
        for ($i = 1; $i <= config('settings.limits'); $i++) {
            array_push($values1, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => $calculator->calculateReceivableTurnoverRatio($year, $quarter)->receivableTurnoverRatio
            ]);
            array_push($values2, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => $calculator->averageCollectionPeriod
            ]);
            $previous = getPreviousPeriod($year, $quarter);
            $year = $previous['year'];
            $quarter = $previous['quarter'];
        }
        array_push($this->content, [
            'name' => 'Vòng quay các khoản phải thu khách hàng',
            'alias' => 'Receivable turnover ratio',
            'group' => 'Chỉ số hiệu quả hoạt động',
            'unit' => 'cycles',
            'description' => 'Vòng quay các khoản phải thu khách hàng (<strong>Accounts receivable turnover ratio</strong>) kiểm tra mức độ hiệu quả của một doanh nghiệp khi thực hiện việc thu hồi các khoản phải thu và các khoản nợ của khách hàng, đưa ra đánh giá khách quanh về mức độ hiệu quả của doanh nghiệp khi cấp tín dụng cho khách hàng đồng thời thể hiện khả năng thu hồi các khoản nợ ngắn hạn. <strong style="color:#FF00FF;">Công thức tính = Doanh thu thuần / Phải thu ngắn hạn khách hàng bình quân</strong>',
            'values' => $values1
        ]);
        array_push($this->content, [
            'name' => 'Thời gian thu tiền khách hàng bình quân',
            'alias' => 'Average Collection Period',
            'group' => 'Chỉ số hiệu quả hoạt động',
            'unit' => 'days',
            'description' => 'Thời gian thu tiền khách hàng bình quâ (<strong>Average Collection Period</strong>) là dấu hiệu cho thấy hiệu quả của các hoạt động quản lí khoản phải thu. <strong style="color:#FF00FF;">Công thức tính = 365 / Vòng quay phải thu khách hàng</strong>',
            'values' => $values2
        ]);
        return $this;
    }

    /**
     * Write Inventory Turn-over Ratio
     *
     * @param \App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator $calculator
     * @param  int $year
     * @param  int $quarter
     * @return $this
     */
    protected function writeInventoryTurnoverRatio(OperatingEffectivenessCalculator $calculator, $year, $quarter)
    {
        $values1 = [];
        $values2 = [];
        for ($i = 1; $i <= config('settings.limits'); $i++) {
            array_push($values1, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => $calculator->calculateInventoryTurnoverRatio($year, $quarter)->inventoryTurnoverRatio
            ]);
            array_push($values2, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => $calculator->averageAgeOfInventory
            ]);
            $previous = getPreviousPeriod($year, $quarter);
            $year = $previous['year'];
            $quarter = $previous['quarter'];
        }
        array_push($this->content, [
            'name' => 'Vòng quay hàng tồn kho',
            'alias' => 'Inventory turnover ratio',
            'group' => 'Chỉ số hiệu quả hoạt động',
            'unit' => 'cycles',
            'description' => 'Vòng quay hàng tồn kho (<strong>Inventory turnover ratio</strong>) đo lường khả năng quản trị hàng tồn kho trong toàn bộ hoạt động của một doanh nghiệp. <strong style="color:#FF00FF;">Công thức tính = Giá vốn bán hàng / Tổng hàng tồn kho bình quân</strong>',
            'values' => $values1
        ]);
        array_push($this->content, [
            'name' => 'Thời gian tồn kho bình quân',
            'alias' => 'Average Age of Inventory',
            'group' => 'Chỉ số hiệu quả hoạt động',
            'unit' => 'days',
            'description' => 'Thời gian tồn kho bình quân (<strong>Average Age of Inventory</strong>) là số ngày của một vòng quay hàng tồn kho của một doanh nghiệp . <strong style="color:#FF00FF;">Công thức tính = 365 / Vòng quay hàng tồn kho</strong>',
            'values' => $values2
        ]);
        return $this;
    }

    /**
     * Write Accounts Payable Turnover Ratio
     *
     * @param \App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator $calculator
     * @param  int $year
     * @param  int $quarter
     * @return $this
     */
    protected function writeAccountsPayableTurnoverRatio(OperatingEffectivenessCalculator $calculator, $year, $quarter)
    {
        $values1 = [];
        $values2 = [];
        for ($i = 1; $i <= config('settings.limits'); $i++) {
            array_push($values1, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => $calculator->calculateAccountsPayableTurnoverRatio($year, $quarter)->accountsPayableTurnoverRatio
            ]);
            array_push($values2, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => $calculator->averageAccountPayableDuration
            ]);
            $previous = getPreviousPeriod($year, $quarter);
            $year = $previous['year'];
            $quarter = $previous['quarter'];
        }
        array_push($this->content, [
            'name' => 'Vòng quay phải trả nhà cung cấp',
            'alias' => 'Accounts payable turnover',
            'group' => 'Chỉ số hiệu quả hoạt động',
            'unit' => 'cycles',
            'description' => 'Vòng quay phải trả nhà cung cấp (<strong>Accounts payable turnover</strong>) cho biết doanh nghiệp đã sử dụng chính sách tín dụng của nhà cung cấp như thế nào. Chỉ số này quá thấp có nghĩa là doanh nghiệp đang tận dụng tín dụng của nhà cung cấp nhiều hơn. Ở khía cạnh tích cực, điều này cho thấy doanh nghiệp đang tận dụng nguồn vốn của nhà cung cấp và giảm áp lực thanh toán trong ngắn hạn. Ở khía cạnh tiêu cực, đây có thể là dấu hiệu của việc thiếu hụt dòng tiền và mất nhiều thời gian hơn để thanh toán cho nhà cung cấp và điều này có thể ảnh hưởng không tốt đến xếp hạng tín dụng của doanh nghiệp. <strong style="color:#FF00FF;">Công thức tính = Giá vốn hàng bán/Phải trả người bán ngắn hạn bình quân</strong>',
            'values' => $values1
        ]);
        array_push($this->content, [
            'name' => 'Thời gian trả tiền nhà cung cấp bình quân',
            'alias' => 'Average Account Payable Duration',
            'group' => 'Chỉ số hiệu quả hoạt động',
            'unit' => 'days',
            'description' => 'Thời gian trả tiền nhà cung cấp bình quân (<strong>Average Account Payable Duration</strong>). <strong style="color:#FF00FF;">Công thức tính = 365 / Vòng quay phải trả nhà cung cấp</strong>',
            'values' => $values2
        ]);
        return $this;
    }

    /**
     * Write Cash Conversion Cycle
     *
     * @param \App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator $calculator
     * @param  int $year
     * @param  int $quarter
     * @return $this
     */
    protected function writeCashConversionCycle(OperatingEffectivenessCalculator $calculator, $year, $quarter)
    {
        $values = [];
        for ($i = 1; $i <= config('settings.limits'); $i++) {
            array_push($values, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => $calculator->calculateCashConversionCycle($year, $quarter)->cashConversionCycle
            ]);
            $previous = getPreviousPeriod($year, $quarter);
            $year = $previous['year'];
            $quarter = $previous['quarter'];
        }
        array_push($this->content, [
            'name' => 'Chu kỳ chuyển đổi tiền mặt',
            'alias' => 'Cash Conversion Cycle',
            'group' => 'Chỉ số hiệu quả hoạt động',
            'unit' => 'days',
            'description' => 'Chu kỳ chuyển đổi tiền mặt (<strong>Cash conversion cycle</strong>) cho biết mất bao lâu kể từ khi doanh nghiệp trả tiền mua các nguyên liệu thô tới khi nhận được tiền mặt trong bán hàng. <strong style="color:#FF00FF;">Công thức tính = thời gian tồn kho + thời gian phải thu khách hàng - thời gian trả tiền nhà cung cấp</strong>',
            'values' => $values
        ]);
        return $this;
    }

    /**
     * Write Fixed Asset Turnover Ratio
     *
     * @param \App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator $calculator
     * @param  int $year
     * @param  int $quarter
     * @return $this
     */
    protected function writeFixedAssetTurnoverRatio(OperatingEffectivenessCalculator $calculator, $year, $quarter)
    {
        $values = [];
        for ($i = 1; $i <= config('settings.limits'); $i++) {
            array_push($values, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => $calculator->calculateFixedAssetTurnoverRatio($year, $quarter)->fixedAssetTurnoverRatio
            ]);
            $previous = getPreviousPeriod($year, $quarter);
            $year = $previous['year'];
            $quarter = $previous['quarter'];
        }
        array_push($this->content, [
            'name' => 'Vòng quay tài sản cố định',
            'alias' => 'Fixed Asset Turnover Ratio',
            'group' => 'Chỉ số hiệu quả hoạt động',
            'unit' => 'cycles',
            'description' => 'Vòng quay tài sản cố định (<strong>Fixed Asset Turnover Ratio</strong>) được sử dụng để đo lường hiệu suất hoạt động của công ty, đo lường khả năng của công ty để tạo doanh thu thuần từ các khoản đầu tư tài sản cố định, cụ thể là tài sản, nhà máy và thiết bị. <strong style="color:#FF00FF;">Công thức tính = doanh thu thuần / Tổng tài sản cố định bình quân</strong>',
            'values' => $values
        ]);
        return $this;
    }

    /**
     * Write Total Asset Turnover Ratio
     *
     * @param \App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator $calculator
     * @param  int $year
     * @param  int $quarter
     * @return $this
     */
    protected function writeTotalAssetTurnoverRatio(OperatingEffectivenessCalculator $calculator, $year, $quarter)
    {
        $values = [];
        for ($i = 1; $i <= config('settings.limits'); $i++) {
            array_push($values, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => $calculator->calculateTotalAssetTurnoverRatio($year, $quarter)->totalAssetTurnoverRatio
            ]);
            $previous = getPreviousPeriod($year, $quarter);
            $year = $previous['year'];
            $quarter = $previous['quarter'];
        }
        array_push($this->content, [
            'name' => 'Vòng quay tổng tài sản',
            'alias' => 'Total Asset Turnover Ratio',
            'group' => 'Chỉ số hiệu quả hoạt động',
            'unit' => 'cycles',
            'description' => 'Vòng quay tổng tài sản (<strong>Total Asset Turnover Ratio</strong>) là thước đo thể hiện mức độ hiệu quả trong việc điều hành, phát triển của doanh nghiệp. Khi doanh nghiệp đầu tư tài sản vào các hoạt động sản xuất, kinh doanh thì tỷ số này sẽ cho biết với mỗi dòng tiền doanh nghiệp đầu tư vào sẽ tạo ra bao nhiêu dòng tiền mang lại doanh thu. <strong style="color:#FF00FF;">Công thức tính = Doanh thu thuần / Tông tài sản bình quân</strong>',
            'values' => $values
        ]);
        return $this;
    }

    /**
     * Write Equity Turnover Ratio
     *
     * @param \App\Jobs\Financials\Calculators\OperatingEffectivenessCalculator $calculator
     * @param  int $year
     * @param  int $quarter
     * @return $this
     */
    protected function writeEquityTurnoverRatio(OperatingEffectivenessCalculator $calculator, $year, $quarter)
    {
        $values = [];
        for ($i = 1; $i <= config('settings.limits'); $i++) {
            array_push($values, [
                'period' => $quarter != 0 ? "Q$quarter $year" : "$year",
                'year' => $year,
                'quarter' => $quarter,
                'value' => $calculator->calculateEquityTurnoverRatio($year, $quarter)->equityTurnoverRatio
            ]);
            $previous = getPreviousPeriod($year, $quarter);
            $year = $previous['year'];
            $quarter = $previous['quarter'];
        }
        array_push($this->content, [
            'name' => 'Vòng quay VCSH',
            'alias' => 'Equity Turnover Ratio',
            'group' => 'Chỉ số hiệu quả hoạt động',
            'unit' => 'cycles',
            'description' => 'Vòng quay VCSH (<strong>Equity Turnover Ratio</strong>) đo lường mối quan hệ giữa doanh thu thuần và VCSH bình quân của doanh nghệp, cho biết 1 đồng VCSH tạo ra được bao nhiêu đồng doanh thu. Chỉ số này càng cao cho thấy hiệu quả sử dụng VCSH của doanh nghiệp càng cao và ngược lại. <strong style="color:#FF00FF;">Công thức tính = Doanh thu thuần/Vốn chủ sở hữu bình quân</strong>',
            'values' => $values
        ]);
        return $this;
    }
}
