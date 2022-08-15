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
        if (!empty($financialStatement->balance_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $assets = $financialStatement->balance_statement->getItem('2')->getValue($selectedYear, $selectedQuarter);
            $liabilities = $financialStatement->balance_statement->getItem('301')->getValue($selectedYear, $selectedQuarter);
            if ($liabilities != 0) {
                array_push($this->content, [
                    'name' => 'Hệ số khả năng thanh toán tổng quát',
                    'group' => 'Chỉ số thanh khoản/thanh toán',
                    'unit' => 'scalar',
                    'description' => 'Hệ số khả năng thanh toán tổng quát phản ánh tổng quát nhất năng lực thanh toán của doanh nghiệp trong ngắn và dài hạn. Hệ số khả năng thanh toán tổng quát = Tổng tài sản/Nợ phải trả. Nếu tỉ lệ > 2 phản ánh khả năng thanh toán của doanh nghiệp rất tốt, tuy nhiên hiệu quả sử dụng vốn có thể không cao và đòn bẩy tài chính thấp. Doanh nghiệp sẽ khó có bước tăng trưởng vượt bậc. Nếu 1 < tỉ lệ < 2 phản ánh về cơ bản, với lượng tổng tài sản hiện có, doanh nghiệp hoàn toàn đáp ứng được các khoản nợ tới hạn. Tỉ lệ < 1 thể hiện khả năng thanh toán của doanh nghiệp thấp, khi chỉ số càng tiến dần về 0, doanh nghiệp sẽ mất dần khả năng thanh toán, việc phá sản có thể xảy ra nếu doanh nghiệp không có giải pháp thực sự phù hợp',
                    'value' => round($assets / $liabilities, 2)
                ]);
            }
        }
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
        if (!empty($financialStatement->balance_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $currentAssets = $financialStatement->balance_statement->getItem('101')->getValue($selectedYear, $selectedQuarter);
            $currentLiabilities = $financialStatement->balance_statement->getItem('30101')->getValue($selectedYear, $selectedQuarter);
            if ($currentLiabilities != 0) {
                array_push($this->content, [
                    'name' => 'Current Ratio',
                    'group' => 'Chỉ số thanh khoản/thanh toán',
                    'unit' => 'scalar',
                    'description' => 'Hệ số khả năng thanh toán hiện hành thể hiện khă năng doanh nghiệp thanh toán các khoản nợ ngắn hạn bằng nguồn tài sản ngắn hạn. Nếu hệ số này < 1 phản ánh khả năng trả nợ của doanh nghiệp yếu, là dấu hiệu báo trước những khó khăn tiềm ẩn về tài chính mà doanh nghiệp có thể gặp phải trong việc trả các khoản nợ ngắn hạn. Khi hệ số càng dần về 0, doanh nghiệp càng mất khả năng chi trả, gia tăng nguy cơ phá sản. Nếu hệ số > 1 cho thấy doanh nghiệp có khả năng cao trong việc sẵn sàng thanh toán các khoản nợ đến hạn. Tỷ số càng cao càng đảm bảo khả năng chi trả của doanh nghiệp, tính thanh khoản ở mức cao. Tuy nhiên, trong một số trường hợp, tỷ số quá cao chưa chắc phản ánh khả năng thanh khoản của doanh nghiệp là tốt. Bởi có thể nguồn tài chính không được sử dụng hợp lý, hay hàng tồn kho quá lớn dẫn đến việc khi có biến động trên thị trường, lượng hàng tồn kho không thể bán ra để chuyển hoá thành tiền. Hệ số khả năng thanh toán hiện hành = Tài sản ngắn hạn / Nợ ngắn hạn',
                    'value' => round($currentAssets / $currentLiabilities, 2)
                ]);
            }
        }
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
        if (!empty($financialStatement->balance_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $currentAssets = $financialStatement->balance_statement->getItem('101')->getValue($selectedYear, $selectedQuarter);
            $inventories = $financialStatement->balance_statement->getItem('10104')->getValue($selectedYear, $selectedQuarter);
            $currentLiabilities = $financialStatement->balance_statement->getItem('30101')->getValue($selectedYear, $selectedQuarter);
            if ($currentLiabilities != 0) {
                array_push($this->content, [
                    'name' => 'Quick Ratio',
                    'group' => 'Chỉ số thanh khoản/thanh toán',
                    'unit' => 'scalar',
                    'description' => 'Hệ số khả năng thanh toán nhanh (Quick Ratio), thể hiện khả năng thanh toán của doanh nghiệp mà không cần thực hiện thanh lý gấp hàng tồn kho, bộ phận có tính thanh khoản thấp nhất trong tài sản ngắn hạn. Hệ số khả năng thanh toán nhanh = (Tài sản ngắn hạn - hàng tồn kho) / Nợ ngắn hạn. Quick Ratio < 0.5 phản ánh doanh nghiệp đang gặp khó khăn trong việc chi trả nợ ngắn hạn, tính thanh khoản thấp, quick ratio > 0.5 phản ánh doanh nghiệp có khả năng thanh toán tốt, tính thanh khoản cao.',
                    'value' => round(($currentAssets - $inventories) / $currentLiabilities, 2)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate Quick Ratio 2 - He so kha nang thanh toan nhanh 2 (giam hang ton kho va phai thu ngan han)
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateQuickRatio2($financialStatement)
    {
        if (!empty($financialStatement->balance_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $currentAssets = $financialStatement->balance_statement->getItem('101')->getValue($selectedYear, $selectedQuarter);
            $inventories = $financialStatement->balance_statement->getItem('10104')->getValue($selectedYear, $selectedQuarter);
            $currentReceivableAccounts = $financialStatement->balance_statement->getItem('10103')->getValue($selectedYear, $selectedQuarter);
            $currentLiabilities = $financialStatement->balance_statement->getItem('30101')->getValue($selectedYear, $selectedQuarter);
            if ($currentLiabilities != 0) {
                array_push($this->content, [
                    'name' => 'Quick Ratio 2',
                    'group' => 'Chỉ số thanh khoản/thanh toán',
                    'unit' => 'scalar',
                    'description' => 'Tương tự như quick ratio (hệ số khả năng thanh toán nhanh), nhưng loại trừ thêm các khoản phải thu ngắn hạn',
                    'value' => round(($currentAssets - $inventories - $currentReceivableAccounts) / $currentLiabilities, 2)
                ]);
            }
        }
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
        if (!empty($financialStatement->balance_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $cashAndEquivalents = $financialStatement->balance_statement->getItem('10101')->getValue($selectedYear, $selectedQuarter);
            $currentLiabilities = $financialStatement->balance_statement->getItem('30101')->getValue($selectedYear, $selectedQuarter);
            if ($currentLiabilities != 0) {
                array_push($this->content, [
                    'name' => 'Cash Ratio',
                    'group' => 'Chỉ số thanh khoản/thanh toán',
                    'unit' => 'scalar',
                    'description' => 'Hệ số khả năng thanh toán bằng tiền mặt (Cash Ratio), hay còn gọi là hệ số khả năng thanh toán tức thời, cho biết doanh nghiệp có bao nhiêu đồng vốn bằng tiền để sẵn sàng thanh toán cho một đồng nợ ngắn hạn, đây là thước đo khả năng thanh khoản của công ty. Hệ số này tính toán khả năng trả nợ ngắn hạn bằng tiền mặt hoặc tương đương tiền mặt. Hệ số thanh khoản bằng tiền mặt nhỏ hơn 0.5 thường được xem là rủi ro. Hệ số thanh toán tức thời = Tiền & tương đương tiền / Nợ ngắn hạn. Hệ số này đặc biệt hữu ích khi đánh giá tính thanh khoản của một doanh nghiệp trong giai đoạn nền kinh tế đang gặp khủng hoảng (khi mà hàng tồn kho không tiêu thụ được, các khoản phải thu khó thu hồi). Tuy nhiên, trong nền kinh tế ổn định, dùng tỷ số khả năng thanh toán tức thời đánh giá tính thanh khoản của một doanh nghiệp có thể xảy ra sai sót. Bởi lẽ, một doanh nghiệp có một lượng lớn nguồn tài chính không được sử dụng đồng nghĩa do doanh nghiệp đó sử dụng không hiệu quả nguồn vốn.',
                    'value' => round($cashAndEquivalents / $currentLiabilities, 2)
                ]);
            }
        }
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
        if (!empty($financialStatement->income_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $eBIT = $financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter) + $financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
            $interest = $financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
            if ($interest != 0) {
                array_push($this->content, [
                    'name' => 'Interest Coverage Ratio',
                    'group' => 'Chỉ số thanh khoản/thanh toán',
                    'unit' => 'scalar',
                    'description' => 'Hệ số khả năng thanh toán lãi vay còn được gọi là hệ số thanh toán lãi nợ vay. Đây là chỉ số cho biết khả năng đảm bảo trả lãi nợ vay của doanh nghiệp. Ngoài ra, thông qua chỉ số tài chính này, có thấy được khả năng tài chính của doanh nghiệp tạo ra để trang trải cho chi phí vay vốn cho các hoạt động kinh doanh sản xuất. Tỷ lệ thanh toán lãi vay được tính trên tỷ lệ nợ và tỷ suất sinh lời nhằm giúp xác định khả năng tài chính của một công ty có thể trả lãi cho các khoản nợ tồn đọng của mình hay không. Hệ số thanh toán lãi nợ vay = EBIT / Lãi nợ vay. Các nhà kinh tế học chọn mức hệ số 2 là mốc để đánh giá khả năng đó. Nếu hệ số thanh toán lãi vay càng xa hệ số 2 thì doanh nghiệp đó đang gặp vấn đề tài chính và khả năng có thể tự chi trả khoản lãi vay là rất thấp',
                    'value' => round($eBIT / $interest, 2)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate Liabilities Coverage Cash Flow Ratio - He so kha nang thanh toan no cua dong tien kinh doanh
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateLiabilitiesCoverageCashFlowRatio($financialStatement)
    {
        if (!empty($financialStatement->cash_flow_statement) && !empty($financialStatement->balance_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $operation_cash_flow = $financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter);
            $average_liabilities = array_sum($financialStatement->balance_statement->getItem('301')->getValues())/2;
            if ($average_liabilities != 0) {
                array_push($this->content, [
                    'name' => 'Hệ số khả năng thanh toán nợ của dòng tiền HĐKD',
                    'group' => 'Chỉ số thanh khoản/thanh toán',
                    'unit' => 'scalar',
                    'description' => 'Hệ số khả năng thanh toán nợ của dòng tiền thuần từ hoạt động kinh doanh = Lưu chuyển tiền thuần từ HĐKD trong kỳ / Nợ phải trả bình quân trong kỳ. Hệ số này cho biết với dòng tiền thuần từ  HĐKD trong kỳ, DN có đảm bảo khả năng đáp ứng được nợ phải trả hay không. Nói cách khác, một đồng nợ phải trả bình quân trong kỳ được đảm bảo bởi mấy đồng tiền và tương đương tiền lưu chuyển thuàn từ HĐKD. Khi trị số của chỉ tiêu này lớn hơn hoặc bằng một(>= 1), dòng tiefn lưu chuyển thuần từ HĐKD trong kỳ bảo đảm đáp ứng đủ và thừa khả năng thanh toán nợ phải trả trong kỳ và ngược lại',
                    'value' => round($operation_cash_flow / $average_liabilities, 2)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate Current Liabilities Coverage Cash Flow Ratio - He so kha nang thanh toan no ngan han cua dong tien kinh doanh
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateCurrentLiabilitiesCoverageCashFlowRatio($financialStatement)
    {
        if (!empty($financialStatement->cash_flow_statement) && !empty($financialStatement->balance_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $operation_cash_flow = $financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter);
            $average_current_liabilities = array_sum($financialStatement->balance_statement->getItem('30101')->getValues())/2;
            if ($average_current_liabilities != 0) {
                array_push($this->content, [
                    'name' => 'Hệ số khả năng thanh toán nợ ngắn hạn của dòng tiền HĐKD',
                    'group' => 'Chỉ số thanh khoản/thanh toán',
                    'unit' => 'scalar',
                    'description' => 'Hệ số khả năng thanh toán nợ ngắn hạn của dòng tiền thuần từ hoạt động kinh doanh = Lưu chuyển tiền thuần từ HĐKD trong kỳ / Nợ ngắn hạn bình quân trong kỳ. Hệ số này cho biết dòng tiền lưu chuyển thuần từ hoạt động kinh doanh (HĐKD) trong kỳ có đảm bảo trang trải được các khoản nợ ngắn hạn (Kể cả nợ dài hạn đến hạn trả) hay không. Do dòng tiền lưu chuyển thuần tạo ra từ HĐKD là dòng tiền an ninh tài chính của doanh nghiệp nên khi trị số của chỉ tiêu này lớn hơn hoặc bằng một (>=1), Doanh nghiệp có đủ khả năng thanh toán nợ ngắn hạn và ngược lại, số tiền lưu chuyển thuần tạo ra từ HĐKD không đủ để trả nợ ngắn hạn',
                    'value' => round($operation_cash_flow / $average_current_liabilities, 2)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate Long Liabilities Coverage Cash Flow Ratio - He so kha nang thanh toan no dai han cua dong tien kinh doanh
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateLongLiabilitiesCoverageCashFlowRatio($financialStatement)
    {
        if (!empty($financialStatement->cash_flow_statement) && !empty($financialStatement->balance_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $operation_cash_flow = $financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter);
            $average_long_liabilities = array_sum($financialStatement->balance_statement->getItem('30102')->getValues())/2;
            if ($average_long_liabilities != 0) {
                array_push($this->content, [
                    'name' => 'Hệ số khả năng thanh toán nợ dài hạn của dòng tiền HĐKD',
                    'group' => 'Chỉ số thanh khoản/thanh toán',
                    'unit' => 'scalar',
                    'description' => 'Hệ số khả năng thanh toán nợ dài hạn của dòng tiền thuần từ hoạt động kinh doanh = Lưu chuyển tiền thuần từ HĐKD trong kỳ / Nợ dài hạn bình quân trong kỳ. Hệ số này cho biết mức độ bảo đảm nợ dài hạn bằng dòng tiền lưu chuyển thuần từ HĐKD. Hay nói cách khác, cứ một đồng nợ dài hạn bình quân trong kỳ phải trả của DN được đảm bảo bởi mấy đồng tiền lưu chuyển thuần từ HĐKD. Khi trị số của chỉ tiêu lớn hơn hoặc bằng 1 (>=1), DN bảo đảm đủ và thừa khả năng thanh toán nợ dài hạn và ngược lại',
                    'value' => round($operation_cash_flow / $average_long_liabilities, 2)
                ]);
            }
        }
        return $this;
    }
}