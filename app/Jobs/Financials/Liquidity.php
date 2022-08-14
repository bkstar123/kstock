<?php
/**
 * Liquidity trait
 *
 * @author: tuanha
 * @date: 14-Aug-2022
 */
namespace App\Jobs\Financials;

trait Liquidity
{
    /**
     * Calculate AssetsToLiabilities ratio - He so kha nang thanh toan tong quat
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateAssetsToLiabilitiesRatio($financialStatement)
    {
        $selectedYear = $financialStatement->year;
        $selectedQuarter = $financialStatement->quarter;
        $assets = $financialStatement->balance_statement->getItem('2')->getValue($selectedYear, $selectedQuarter);
        $liabilities = $financialStatement->balance_statement->getItem('301')->getValue($selectedYear, $selectedQuarter);
        array_push($this->content, [
            'name' => 'A/D Ratio',
            'group' => 'Chỉ số thanh khoản/thanh toán',
            'unit' => 'scalar',
            'description' => 'Hệ số thanh toán tổng quát,cChỉ số này phản ánh tổng quát nhất năng lực thanh toán của doanh nghiệp trong ngắn và dài hạn. Hệ số khả năng thanh toán tổng quát = Tổng tài sản/Nợ phải trả. Nếu tỉ lệ > 2 P\phản ánh khả năng thanh toán của doanh nghiệp rất tốt, tuy nhiên hiệu quả sử dụng vốn có thể không cao và đòn bẩy tài chính thấp. Doanh nghiệp sẽ khó có bước tăng trưởng vượt bậc. Nếu 1 < tỉ lệ < 2 phản ánh về cơ bản, với lượng tổng tài sản hiện có, doanh nghiệp hoàn toàn đáp ứng được các khoản nợ tới hạn. Tỉ lệ < 1 thể hiện khả năng thanh toán của doanh nghiệp thấp, khi chỉ số càng tiến dần về 0, doanh nghiệp sẽ mất dần khả năng thanh toán, việc phá sản có thể xảy ra nếu doanh nghiệp không có giải pháp thực sự phù hợp',
            'value' => round($assets / $liabilities, 2)
        ]);
        return $this;
    }
    
     /**
     * Calculate Current ratio - He so kha nang thanh toan hien hanh (ngan han)
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateCurrentRatio($financialStatement)
    {
        $selectedYear = $financialStatement->year;
        $selectedQuarter = $financialStatement->quarter;
        $currentAssets = $financialStatement->balance_statement->getItem('101')->getValue($selectedYear, $selectedQuarter);
        $currentLiabilities = $financialStatement->balance_statement->getItem('30101')->getValue($selectedYear, $selectedQuarter);
        array_push($this->content, [
            'name' => 'Current Ratio',
            'group' => 'Chỉ số thanh khoản/thanh toán',
            'unit' => 'scalar',
            'description' => 'Hệ số khả năng thanh toán hiện hành thể hiện khă năng doanh nghiệp thanh toán các khoản nợ ngắn hạn bằng nguồn tài sản ngắn hạn. Nếu hệ số này < 1 phản ánh khả năng trả nợ của doanh nghiệp yếu, là dấu hiệu báo trước những khó khăn tiềm ẩn về tài chính mà doanh nghiệp có thể gặp phải trong việc trả các khoản nợ ngắn hạn. Khi hệ số càng dần về 0, doanh nghiệp càng mất khả năng chi trả, gia tăng nguy cơ phá sản. Nếu hệ số > 1 cho thấy doanh nghiệp có khả năng cao trong việc sẵn sàng thanh toán các khoản nợ đến hạn. Tỷ số càng cao càng đảm bảo khả năng chi trả của doanh nghiệp, tính thanh khoản ở mức cao. Tuy nhiên, trong một số trường hợp, tỷ số quá cao chưa chắc phản ánh khả năng thanh khoản của doanh nghiệp là tốt. Bởi có thể nguồn tài chính không được sử dụng hợp lý, hay hàng tồn kho quá lớn dẫn đến việc khi có biến động trên thị trường, lượng hàng tồn kho không thể bán ra để chuyển hoá thành tiền. Hệ số khả năng thanh toán hiện hành = Tài sản ngắn hạn / Nợ ngắn hạn',
            'value' => round($currentAssets / $currentLiabilities, 2)
        ]);
        return $this;
    }

    /**
     * Calculate Quick Ratio - He so kha nang thanh toan nhanh
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateQuickRatio($financialStatement)
    {
        $selectedYear = $financialStatement->year;
        $selectedQuarter = $financialStatement->quarter;
        $currentAssets = $financialStatement->balance_statement->getItem('101')->getValue($selectedYear, $selectedQuarter);
        $inventories = $financialStatement->balance_statement->getItem('10104')->getValue($selectedYear, $selectedQuarter);
        $currentLiabilities = $financialStatement->balance_statement->getItem('30101')->getValue($selectedYear, $selectedQuarter);
        array_push($this->content, [
            'name' => 'Quick Ratio',
            'group' => 'Chỉ số thanh khoản/thanh toán',
            'unit' => 'scalar',
            'description' => 'Hệ số thanh khoản nhanh (Quick Ratio), thể hiện khả năng thanh toán của doanh nghiệp mà không cần thực hiện thanh lý gấp hàng tồn kho. Hệ số thanh khoản nhanh = (Tài sản ngắn hạn - hàng tồn kho) / Nợ ngắn hạn. Quick Ratio < 0.5 phản ánh doanh nghiệp đang gặp khó khăn trong việc chi trả nợ ngắn hạn, tính thanh khoản thấp, quick ratio > 0.5 phản ánh doanh nghiệp có khả năng thanh toán tốt, tính thanh khoản cao.',
            'value' => round(($currentAssets - $inventories) / $currentLiabilities, 2)
        ]);
        return $this;
    }

	/**
     * Calculate CashRatio - He so kha nang thanh toan tuc thoi
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateCashRatio($financialStatement)
    {
        $selectedYear = $financialStatement->year;
        $selectedQuarter = $financialStatement->quarter;
        $cashAndEquivalents = $financialStatement->balance_statement->getItem('10101')->getValue($selectedYear, $selectedQuarter);
        $currentLiabilities = $financialStatement->balance_statement->getItem('30101')->getValue($selectedYear, $selectedQuarter);
        array_push($this->content, [
            'name' => 'Cash Ratio',
            'group' => 'Chỉ số thanh khoản/thanh toán',
            'unit' => 'scalar',
            'description' => 'Hệ số thanh khoản bằng tiền mặt (Cash Ratio), hay còn gọi là hệ số thanh toán tức thời, cho biết doanh nghiệp có bao nhiêu đồng vốn bằng tiền để sẵn sàng thanh toán cho một đồng nợ ngắn hạn, đây là thước đo khả năng thanh khoản của công ty. Hệ số này tính toán khả năng trả nợ ngắn hạn bằng tiền mặt hoặc tương đương tiền mặt. Hệ số thanh khoản bằng tiền mặt nhỏ hơn 0.5 thường được xem là rủi ro. Hệ số thanh toán tức thời = Tiền & tương đương tiền / Nợ ngắn hạn. Hệ số này đặc biệt hữu ích khi đánh giá tính thanh khoản của một doanh nghiệp trong giai đoạn nền kinh tế đang gặp khủng hoảng (khi mà hàng tồn kho không tiêu thụ được, các khoản phải thu khó thu hồi). Tuy nhiên, trong nền kinh tế ổn định, dùng tỷ số khả năng thanh toán tức thời đánh giá tính thanh khoản của một doanh nghiệp có thể xảy ra sai sót. Bởi lẽ, một doanh nghiệp có một lượng lớn nguồn tài chính không được sử dụng đồng nghĩa do doanh nghiệp đó sử dụng không hiệu quả nguồn vốn.',
            'value' => round($cashAndEquivalents / $currentLiabilities, 2)
        ]);
        return $this;
    }

    /**
     * Calculate Interest Coverage Ratio - He so kha nang chi tra lai vay
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateInterestCoverageRatio($financialStatement)
    {
        $selectedYear = $financialStatement->year;
        $selectedQuarter = $financialStatement->quarter;
        $eBIT = $financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter) + $financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
        $interest = $financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
        array_push($this->content, [
            'name' => 'Interest Coverage Ratio',
            'group' => 'Chỉ số thanh khoản/thanh toán',
            'unit' => 'scalar',
            'description' => 'Tỷ lệ thanh toán lãi vay còn được gọi là hệ số thanh toán lãi nợ vay. Đây là chỉ số cho biết khả năng đảm bảo trả lãi nợ vay của doanh nghiệp. Ngoài ra, thông qua chỉ số tài chính này, có thấy được khả năng tài chính của doanh nghiệp tạo ra để trang trải cho chi phí vay vốn cho các hoạt động kinh doanh sản xuất. Tỷ lệ thanh toán lãi vay được tính trên tỷ lệ nợ và tỷ suất sinh lời nhằm giúp xác định khả năng tài chính của một công ty có thể trả lãi cho các khoản nợ tồn đọng của mình hay không. Hệ số thanh toán lãi nợ vay = (Lợi nhuận trước thuế + Lãi nợ vay)/ Lãi nợ vay. Các nhà kinh tế học chọn mức hệ số 2 là mốc để đánh giá khả năng đó. Nếu hệ số thanh toán lãi vay càng xa hệ số 2 thì doanh nghiệp đó đang gặp vấn đề tài chính và khả năng có thể tự chi trả khoản lãi vay là rất thấp',
            'value' => round($eBIT / $interest, 2)
        ]);
        return $this;
    }
}