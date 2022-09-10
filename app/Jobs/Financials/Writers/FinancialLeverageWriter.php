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
            'alias' => 'Short-term liabilities/Total liabilities',
            'group' => 'Chỉ số đòn bẩy tài chính',
            'unit' => '%',
            'description' => 'Chỉ số này cho biết cấu trúc của Nợ ngắn hạn trong Tổng nợ phải trả. Một tỷ lệ nợ ngắn hạn cao thường là chỉ dấu cho thấy áp lực trả nợ lớn',
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
            'description' => 'Chỉ số này phản ánh bao nhiêu % tài sản của doanh nghiệp được tài trợ bởi nợ vay. <strong style="color:#FF00FF;">Tổng nợ vay = Vay và nợ thuê tài chính ngắn hạn + Vay và nợ thuê tài chính dài hạn</strong>',
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
            'name' => 'Tổng nợ phải trả / Tổng tài sản',
            'alias' => 'Total Liabilities/Total Assets',
            'group' => 'Chỉ số đòn bẩy tài chính',
            'unit' => '%',
            'description' => 'Cho biết cấu trúc hình thành nguồn vốn của doanh nghiệp, cho biết phần trăm tổng tài sản được tài trợ bởi các chủ nợ thay vì các nhà đầu tư',
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
            'alias' => 'Total Assets/Equities',
            'group' => 'Chỉ số đòn bẩy tài chính',
            'unit' => 'scalar',
            'description' => 'Hệ số đòn bẩy tài chính cho biết tài sản của công ty được tài trợ chính bởi vốn chủ sở hữu của các cổ đông hay là nguồn nợ bên ngoài. <strong style="color:#FF00FF;">Hệ số đòn bẩy tài chính = 1 + (Tổng nợ phải trả/VCSH)</strong>',
            'value' => $calculator->totalAssetToEquityRatio
        ]);
        return $this;
    }

    /**
    * Write average total asset to average equity ratio - Chỉ số Tổng tài sản bình quân / Vốn chủ sở hữu bình quân
    *
    * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
    */
    public function writeAverageTotalAssetToAverageEquityRatio(FinancialLeverageCalculator $calculator)
    {
        array_push($this->content, [
            'name' => ' Tổng tài sản bình quân / Vốn chủ sở hữu bình quân (Hệ số đòn bẩy tài chính trung bình - phiên bản chặt chẽ hơn của đòn bẩy tài chính)',
            'alias' => 'Average Total Assets/Average Equities',
            'group' => 'Chỉ số đòn bẩy tài chính',
            'unit' => 'scalar',
            'description' => '<strong style="color:#FF00FF;">Hệ số đòn bẩy tài chính trung bình = 1 + (Tổng nợ phải trả bình quân / VCSH bình quân)</strong>',
            'value' => $calculator->averageTotalAssetToAverageEquityRatio
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
            'name' => 'Tổng nợ vay / tổng nợ phải trả',
            'alias' => 'Total Debts/Total Liabilities',
            'group' => 'Chỉ số đòn bẩy tài chính',
            'unit' => '%',
            'description' => 'Chỉ số này cho biết tỉ lệ nợ vay trong tổng nợ của doanh nghiệp, <strong style="color:#FF00FF;">Tổng nợ vay = Vay và nợ thuê tài chính ngắn hạn + Vay và nợ thuê tài chính dài hạn</strong>',
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
            'name' => 'Nợ vay ngắn hạn / Tổng nợ vay',
            'alias' => 'Currrent Debts/Total Debts',
            'group' => 'Chỉ số đòn bẩy tài chính',
            'unit' => '%',
            'description' => 'Chỉ số này cho biết tỉ lệ nợ vay ngắn hạn trong tổng nợ vay của doanh nghiệp, <strong style="color:#FF00FF;">Công thức tính = 100% * Vay và nợ thuê tài chính ngắn hạn / (Vay và nợ thuê tài chính ngắn hạn + Vay và nợ thuê tài chính dài hạn)</strong>',
            'value' => $calculator->currentDebtToTotalDebtRatio
        ]);
        return $this;
    }

    /**
    * Write Debts to Equities Ratio - Chỉ số nợ vay / VCSH
    *
    * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
    */
    public function writeDebtToEquityRatio(FinancialLeverageCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Tổng nợ vay / Vốn chủ sở hữu (Hệ số nợ vay)',
            'alias' => 'Debts/Equities',
            'group' => 'Chỉ số đòn bẩy tài chính',
            'unit' => 'scalar',
            'description' => 'Không phải mọi khoản nợ đều rủi ro như nhau, hệ số này tập trung đánh giá mức độ đòn bẩy tài chính dựa vào nợ vay (nợ phải trả chi phí lãi vay). Hệ số này càng lớn thì rủi ro càng cao. <strong style="color:#FF00FF;">Công thức tính = (Vay và nợ thuê tài chính ngắn hạn + Vay và nợ thuê tài chính dài hạn) / Vốn chủ sở hữu</strong>',
            'value' => $calculator->debtToEquityRatio
        ]);
        return $this;
    }

    /**
    * Write Net Debts to Equities Ratio - Chỉ số nợ vay rong / VCSH
    *
    * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
    */
    public function writeNetDebtToEquityRatio(FinancialLeverageCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Nợ vay ròng / Vốn chủ sở hữu (Hệ số nợ vay ròng)',
            'alias' => 'Net Debts/Equities',
            'group' => 'Chỉ số đòn bẩy tài chính',
            'unit' => 'scalar',
            'description' => 'Tập trung đánh giá mức độ đòn bẩy tài chính dựa vào nợ vay ròng. Hệ số này càng lớn thì rủi ro càng cao. <strong style="color:#FF00FF;">Công thức tính = (Vay và nợ thuê tài chính ngắn hạn + Vay và nợ thuê tài chính dài hạn - Các khoản đầu tư tài chính ngắn hạn - Các khoản đầu tư tài chính dài hạn) / Vốn chủ sở hữu</strong>',
            'value' => $calculator->netDebtToEquityRatio
        ]);
        return $this;
    }

    /**
    * Write Long Term Debts to Equities Ratio - Chỉ số nợ vay dài hạn / VCSH
    *
    * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
    */
    public function writeLongTermDebtToEquityRatio(FinancialLeverageCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Nợ vay dài hạn / Vốn chủ sở hữu (Hệ số nợ vay dài hạn)',
            'alias' => 'Long Term Debts/Equities',
            'group' => 'Chỉ số đòn bẩy tài chính',
            'unit' => 'scalar',
            'description' => 'Đánh giá mức độ đòn bẩy tài chính của doanh nghiệp theo nguồn nợ vay dài hạn (nợ dài hạn phải trả chi phí lãi vay). Nợ vay dài hạn chứa đựng nhiều rủi ro hơn nợ vay ngắn hạn do nhạy cảm với sự thay đổi của lãi suất và những biến động kinh tế vĩ mô cũng như triển vọng kinh doanh dài hạn của doan nghiệp. <strong style="color:#FF00FF;">Công thức tính = Vay và nợ thuê tài chính dài hạn / Vốn chủ sở hữu</strong>',
            'value' => $calculator->longTermDebtToEquityRatio
        ]);
        return $this;
    }

    /**
    * Write Long Term Debts to Long Term Liabilities Ratio - Chỉ số nợ vay dài hạn / nợ dài hạn
    *
    * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
    */
    public function writeLongTermDebtToLongTermLiabilityRatio(FinancialLeverageCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Nợ vay dài hạn / Nợ dài hạn',
            'alias' => 'Long Term Debts/Long Term Liabilities',
            'group' => 'Chỉ số đòn bẩy tài chính',
            'unit' => '%',
            'description' => 'Đo lường tỉ trọng nợ vay dài hạn trong tổng nợ phải trả dài hạn của doanh nghiệp. <strong style="color:#FF00FF;">Công thức tính = Vay và nợ thuê tài chính dài hạn / Nợ dài hạn</strong>',
            'value' => $calculator->longTermDebtToLongTermLiabilityRatio
        ]);
        return $this;
    }

    /**
    * Write Current Debts to Current Liabilities Ratio - Chỉ số nợ vay ngắn hạn / nợ ngắn hạn
    *
    * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
    */
    public function writeCurrentDebtToCurrentLiabilityRatio(FinancialLeverageCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Nợ vay ngắn hạn / Nợ ngắn hạn',
            'alias' => 'Current Debts/Current Liabilities',
            'group' => 'Chỉ số đòn bẩy tài chính',
            'unit' => '%',
            'description' => 'Đo lường tỉ trọng nợ vay ngắn hạn trong tổng nợ phải trả ngắn hạn của doanh nghiệp. <strong style="color:#FF00FF;">Công thức tính = Vay và nợ thuê tài chính ngắn hạn / Nợ ngắn hạn</strong>',
            'value' => $calculator->currentDebtToCurrentLiabilityRatio
        ]);
        return $this;
    }

    /**
    * Write Interest Expense to Average Debt Ratio - Chỉ số chi phí lãi vay / Nợ vay bình quân
    *
    * @return \App\Jobs\Financials\Calculators\FinancialLeverageCalculator $this
    */
    public function writeInterestExpenseToAverageDebtRatio(FinancialLeverageCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Chi phí lãi vay / Nợ vay bình quân',
            'alias' => 'Interest Expenses/Average Debts',
            'group' => 'Chỉ số đòn bẩy tài chính',
            'unit' => '%',
            'description' => 'Đo lường xem doanh nghiệp phải trả bao nhiêu đồng chi phí lãi vay cho một đồng vay nợ, hệ số này phản ánh mức độ tương đối lãi suất đi vay của doanh nghiệp. <strong style="color:#FF00FF;">Công thức tính = Chi phí lãi vay / (Vay và nợ thuê tài chính ngắn hạn bình quân + Vay và nợ thuê tài chính dài hạn bình quân)</strong>',
            'value' => $calculator->interestExpenseToAverageDebtRatio
        ]);
        return $this;
    }
}
