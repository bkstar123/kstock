<?php
/**
 * FinancialLeverageWriter trait
 *
 * @author: tuanha
 * @date: 14-Aug-2022
 */
namespace App\Jobs\Financials\Writers;

use App\Jobs\Financials\Calculators\FinancialLeverageCalculator;

trait FinancialLeverageWriter
{
    /**
     * Write short-term on total liabilities ratio - Tỷ số nợ ngắn hạn trên tổng nợ phải trả
     *
     * @param \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
     * @return $this
     */
    public function writeShortTermToTotalLiabilitiesRatio(FinancialLeverageCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Nợ ngắn hạn/Tổng nợ phải trả',
            'alias' => 'Short-term liabilities/total liabilities',
            'group' => 'Chỉ số đòn bẩy tài chính',
            'unit' => '%',
            'description' => 'Tỷ số Nợ ngắn hạn trên Tổng nợ phải trả (Short-term/Total liability) = Nợ ngắn hạn/Tổng nợ phải trả. Chỉ số này cho biết cấu trúc của Nợ ngắn hạn trong Tổng nợ phải trả. Một tỷ lệ nợ ngắn hạn cao thường là chỉ dấu cho thấy áp lực trả nợ lớn',
            'value' => $calculator->shortTermToTotalLiabilitiesRatio
        ]);
        return $this;
    }

    /**
     * Write total debt to total asset ratio - Tỷ số Nợ vay trên Tổng tài sản
     *
     * @param \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
     * @return $this
     */
    public function writeTotalDebtToTotalAssetRatio(FinancialLeverageCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tổng nợ vay / Tổng tài sản',
            'alias' => 'Total Debts/Total Assets',
            'group' => 'Chỉ số đòn bẩy tài chính',
            'unit' => '%',
            'description' => 'Tỷ số nợ vay trên tổng tài sản (Total Debts/Total Assets) = (Vay và nợ thuê tài chính ngắn hạn + Vay và nợ thuê tài chính dài hạn) / Tổng tài sản. Chỉ số này phản ánh bao nhiêu % tài sản của doanh nghiệp được tài trợ bởi nợ vay',
            'value' => $calculator->totalDebtToTotalAssetRatio
        ]);
        return $this;
    }

    /**
     * Write total liability to total asset ratio - Chỉ số Tổng nợ / Tổng tài sản
     *
     * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
     */
    public function writeTotalLiabilityToTotalAssetRatio(FinancialLeverageCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tổng nợ  / Tổng tài sản',
            'alias' => 'Total Liabilities/Total Assets',
            'group' => 'Chỉ số đòn bẩy tài chính',
            'unit' => '%',
            'description' => 'Chỉ số tổng nợ tren tổng tài sản (Total liabilities / total assets) = Tổng nợ phải trả / Tông tài sản, cho biết cấu trúc hình thành nguồn vốn của doanh nghiệp, cho biết phần trăm tổng tài sản được tài trợ bởi các chủ nợ thay vì các nhà đầu tư',
            'value' => $calculator->totalLiabilityToTotalAssetRatio
        ]);
        return $this;
    }

    /**
    * Write total asset to equity ratio - Chỉ số Tổng tài sản / Vốn chủ sở hữu
    *
    * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
    */
    public function writeTotalAssetToEquityRatio(FinancialLeverageCalculator $calculator)
    {
        array_push($this->content, [
            'name' => ' Tổng tài sản / Vốn chủ sở hữu (Hệ số đòn bẩy tài chính)',
            'alias' => 'Equitites/Total Assets',
            'group' => 'Chỉ số đòn bẩy tài chính',
            'unit' => 'scalar',
            'description' => 'Hệ số đòn bẩy tài chính cho biết tài sản của công ty được tài trợ chính bởi vốn chủ sở hữu của các cổ đông hay là nguồn nợ bên ngoài. Hệ số đòn bẩy tài chính = Tổng tài sản / VCSH = 1 + Tổng nợ phải trả/VCSH',
            'value' => $calculator->totalAssetToEquityRatio
        ]);
        return $this;
    }

    /**
     * Write total debts to total liabilities - Chỉ số tổng nợ vay / tổng nợ
     *
     * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
     */
    public function writeTotalDebtToTotalLiabilityRatio(FinancialLeverageCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tổng nợ vay / tổng nợ',
            'alias' => 'Total Debts/Total Liabilities',
            'group' => 'Chỉ số đòn bẩy tài chính',
            'unit' => '%',
            'description' => 'Chỉ số này cho biết tỉ lệ nợ vay trong tổng nợ của doanh nghiệp, Total Debts/Total Liabilities = 100% * (Vay và nợ thuê tài chính ngắn hạn + Vay và nợ thuê tài chính dài hạn) / Tổng nợ phải trả',
            'value' => $calculator->totalDebtToTotalLiabilityRatio
        ]);
        return $this;
    }

    /**
    * Write current debts to total debts - Chỉ số nợ vay ngắn hạn / tổng nợ vay
    *
    * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
    */
    public function writeCurrentDebtToTotalDebtRatio(FinancialLeverageCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Nợ vay ngắn hạn / tổng nợ vay',
            'alias' => 'Currrent Debts/Total Debts',
            'group' => 'Chỉ số đòn bẩy tài chính',
            'unit' => '%',
            'description' => 'Chỉ số này cho biết tỉ lệ nợ vay ngắn hạn trong tổng nợ vay của doanh nghiệp, Current Debts / Total Debts = 100% * Vay và nợ thuê tài chính ngắn hạn / (Vay và nợ thuê tài chính ngắn hạn + Vay và nợ thuê tài chính dài hạn)',
            'value' => $calculator->currentDebtToTotalDebtRatio
        ]);
        return $this;
    }
}
