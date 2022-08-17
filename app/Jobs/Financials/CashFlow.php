<?php
/**
 * CashFlow trait
 *
 * @author: tuanha
 * @date: 14-Aug-2022
 */
namespace App\Jobs\Financials;

trait CashFlow
{
    /**
     * Calculate Liability Coverage Ratio By CFO - He so kha nang thanh toan no cua dong tien kinh doanh
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateLiabilityCoverageRatioByCFO($financialStatement)
    {
        if (!empty($financialStatement->cash_flow_statement) && !empty($financialStatement->balance_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $cfo = $financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter);
            $average_liabilities = array_sum($financialStatement->balance_statement->getItem('301')->getValues())/2;
            if ($average_liabilities != 0) {
                array_push($this->content, [
                    'name' => 'Liability Coverage Ratio By CFO',
                    'group' => 'Chỉ số dòng tiền',
                    'unit' => 'scalar',
                    'description' => 'Hệ số khả năng thanh toán nợ của dòng tiền kinh doanh, Liability Coverage Ratio by CFO = CFO / Average Liabilities. Hệ số này cho biết với dòng tiền thuần từ  HĐKD trong kỳ, DN có đảm bảo khả năng đáp ứng được nợ phải trả hay không. Nói cách khác, một đồng nợ phải trả bình quân trong kỳ được đảm bảo bởi mấy đồng tiền và tương đương tiền lưu chuyển thuàn từ HĐKD. Khi trị số của chỉ tiêu này lớn hơn hoặc bằng một(>= 1), dòng tiền lưu chuyển thuần từ HĐKD trong kỳ bảo đảm đáp ứng đủ và thừa khả năng thanh toán nợ phải trả trong kỳ và ngược lại',
                    'value' => round($cfo / $average_liabilities, 4)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate Current Liabilities Coverage Ratio By CFO - He so kha nang thanh toan no ngan han cua dong tien kinh doanh
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateCurrentLiabilityCoverageRatioByCFO($financialStatement)
    {
        if (!empty($financialStatement->cash_flow_statement) && !empty($financialStatement->balance_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $cfo = $financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter);
            $average_current_liabilities = array_sum($financialStatement->balance_statement->getItem('30101')->getValues())/2;
            if ($average_current_liabilities != 0) {
                array_push($this->content, [
                    'name' => 'Current Liability Coverage Ratio By CFO',
                    'group' => 'Chỉ số dòng tiền',
                    'unit' => 'scalar',
                    'description' => 'Hệ số khả năng thanh toán nợ ngắn hạn của dòng tiền kinh doanh, Current Liability Coverage Ratio By CFO = CFO / Average Current Liabilities. Hệ số này cho biết dòng tiền lưu chuyển thuần từ hoạt động kinh doanh (HĐKD) trong kỳ có đảm bảo trang trải được các khoản nợ ngắn hạn (Kể cả nợ dài hạn đến hạn trả) hay không. Do dòng tiền lưu chuyển thuần tạo ra từ HĐKD là dòng tiền an ninh tài chính của doanh nghiệp nên khi chỉ số này lớn hơn hoặc bằng một (>=1), Doanh nghiệp có đủ khả năng thanh toán nợ ngắn hạn bằng dòng tiền hoạt động kinh doanh và ngược lại, dòng tiền HĐKD tạo ra không đủ để trả nợ ngắn hạn',
                    'value' => round($cfo / $average_current_liabilities, 4)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate Long-term Liability Coverage Ratio By CFO - He so kha nang thanh toan no dai han cua dong tien kinh doanh
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateLongTermLiabilityCoverageRatioByCFO($financialStatement)
    {
        if (!empty($financialStatement->cash_flow_statement) && !empty($financialStatement->balance_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $cfo = $financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter);
            $average_long_term_liabilitiess = array_sum($financialStatement->balance_statement->getItem('30102')->getValues())/2;
            if ($average_long_term_liabilitiess != 0) {
                array_push($this->content, [
                    'name' => 'Long-term Liability Coverage Ratio By CFO',
                    'group' => 'Chỉ số dòng tiền',
                    'unit' => 'scalar',
                    'description' => 'Hệ số khả năng thanh toán nợ dài hạn của dòng tiền kinh doanh, Long-term Liability Coverage Ratio By CFO = CFO / Average Long-term Liability. Hệ số này cho biết mức độ bảo đảm nợ dài hạn bằng dòng tiền lưu chuyển thuần từ HĐKD. Hay nói cách khác, cứ một đồng nợ dài hạn bình quân trong kỳ phải trả của DN được đảm bảo bởi mấy đồng tiền lưu chuyển thuần từ HĐKD. Khi trị số của chỉ tiêu lớn hơn hoặc bằng 1 (>=1), DN bảo đảm đủ và thừa khả năng thanh toán nợ dài hạn bằng dòng tiền HĐKD và ngược lại',
                    'value' => round($cfo / $average_long_term_liabilitiess, 4)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate CFO/Revenue
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateCFOPerRevenue($financialStatement)
    {
        if (!empty($financialStatement->cash_flow_statement) && !empty($financialStatement->income_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $cfo = $financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter);
            $net_revenue = $financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            if ($net_revenue != 0) {
                array_push($this->content, [
                    'name' => 'CFO/Revenue',
                    'group' => 'Chỉ số dòng tiền',
                    'unit' => '%',
                    'description' => 'Chỉ số này cho biết tỉ lệ chuyển đổi từ một đồng doanh thu thuần sang dòng tiền hoạt động kinh doanh',
                    'value' => round(100 * $cfo / $net_revenue, 2)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate FCF/Revenue
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateFCFPerRevenue($financialStatement)
    {
        if (!empty($financialStatement->cash_flow_statement) && !empty($financialStatement->income_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $fcf = $financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter) - abs($financialStatement->cash_flow_statement->getItem('201')->getValue($selectedYear, $selectedQuarter)) + $financialStatement->cash_flow_statement->getItem('202')->getValue($selectedYear, $selectedQuarter);
            $net_revenue = $financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            if ($net_revenue != 0) {
                array_push($this->content, [
                    'name' => 'FCF/Revenue',
                    'group' => 'Chỉ số dòng tiền',
                    'unit' => '%',
                    'description' => 'Chỉ số này cho biết tỉ lệ chuyển đổi từ một đồng doanh thu thuần sang dòng tiền tự do, FCF = CFO - CAPEX',
                    'value' => round(100 * $fcf / $net_revenue, 2)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate Liability Coverage Ratio By FCF - He so kha nang thanh toan no cua dong tien tu do
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateLiabilityCoverageRatioByFCF($financialStatement)
    {
        if (!empty($financialStatement->cash_flow_statement) && !empty($financialStatement->balance_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $fcf = $financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter) - abs($financialStatement->cash_flow_statement->getItem('201')->getValue($selectedYear, $selectedQuarter)) + $financialStatement->cash_flow_statement->getItem('202')->getValue($selectedYear, $selectedQuarter);
            $average_liabilities = array_sum($financialStatement->balance_statement->getItem('301')->getValues())/2;
            if ($average_liabilities != 0) {
                array_push($this->content, [
                    'name' => 'Liability Coverage Ratio By FCF',
                    'group' => 'Chỉ số dòng tiền',
                    'unit' => 'scalar',
                    'description' => 'Hệ số khả năng thanh toán nợ của dòng tiền tự do, Liability Coverage Ratio by FCF = FCF / Average Liabilities. Hệ số này cho biết với dòng tiền tự do trong kỳ, DN có đảm bảo khả năng đáp ứng được nợ phải trả hay không. Nói cách khác, một đồng nợ phải trả bình quân trong kỳ được đảm bảo bởi mấy đồng tiền tự do. Khi trị số của chỉ tiêu này lớn hơn hoặc bằng một(>= 1), dòng tiền tự do trong kỳ bảo đảm đáp ứng đủ và thừa khả năng thanh toán nợ phải trả trong kỳ và ngược lại',
                    'value' => round($fcf / $average_liabilities, 4)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate Current Liabilities Coverage Ratio By FCF - He so kha nang thanh toan no ngan han cua dong tien tu do
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateCurrentLiabilityCoverageRatioByFCF($financialStatement)
    {
        if (!empty($financialStatement->cash_flow_statement) && !empty($financialStatement->balance_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $fcf = $financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter) - abs($financialStatement->cash_flow_statement->getItem('201')->getValue($selectedYear, $selectedQuarter)) + $financialStatement->cash_flow_statement->getItem('202')->getValue($selectedYear, $selectedQuarter);
            $average_current_liabilities = array_sum($financialStatement->balance_statement->getItem('30101')->getValues())/2;
            if ($average_current_liabilities != 0) {
                array_push($this->content, [
                    'name' => 'Current Liability Coverage Ratio By FCF',
                    'group' => 'Chỉ số dòng tiền',
                    'unit' => 'scalar',
                    'description' => 'Hệ số khả năng thanh toán nợ ngắn hạn của dòng tiền tự do, Current Liability Coverage Ratio By FCF = FCF / Average Current Liabilities. Hệ số này cho biết dòng tiền tự do trong kỳ có đảm bảo trang trải được các khoản nợ ngắn hạn (Kể cả nợ dài hạn đến hạn trả) hay không, khi chỉ số này lớn hơn hoặc bằng một (>=1), Doanh nghiệp có đủ dòng tiền tự do để thanh toán nợ ngắn hạn và ngược lại, sdòng tiền tư do tạo ra không đủ để trả nợ ngắn hạn',
                    'value' => round($fcf / $average_current_liabilities, 4)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate Long-term Liability Coverage Ratio By FCF - He so kha nang thanh toan no dai han cua dong tien tu do
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateLongTermLiabilityCoverageRatioByFCF($financialStatement)
    {
        if (!empty($financialStatement->cash_flow_statement) && !empty($financialStatement->balance_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $fcf = $financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter) - abs($financialStatement->cash_flow_statement->getItem('201')->getValue($selectedYear, $selectedQuarter)) + $financialStatement->cash_flow_statement->getItem('202')->getValue($selectedYear, $selectedQuarter);
            $average_long_term_liabilities = array_sum($financialStatement->balance_statement->getItem('30102')->getValues())/2;
            if ($average_long_term_liabilities != 0) {
                array_push($this->content, [
                    'name' => 'Long-term Liability Coverage Ratio By FCF',
                    'group' => 'Chỉ số dòng tiền',
                    'unit' => 'scalar',
                    'description' => 'Hệ số khả năng thanh toán nợ dài hạn của dòng tiền tự do, Long-term Liability Coverage Ratio By FCF = FCF / Average Long-term Liability. Hệ số này cho biết mức độ bảo đảm nợ dài hạn bằng dòng tiền tự do tạo ra. Hay nói cách khác, cứ một đồng nợ dài hạn bình quân trong kỳ phải trả của DN được đảm bảo bởi mấy đồng dòng tiền tự do. Khi trị số của chỉ tiêu lớn hơn hoặc bằng 1 (>=1), DN bảo đảm đủ và thừa khả năng thanh toán nợ dài hạn bằng dòng tiền tự do và ngược lại',
                    'value' => round($fcf / $average_long_term_liabilities, 4)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate Interest Coverage Ratio By FCF - He so kha nang thanh toan lai vay cua dong tien tu do
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateInterestCoverageRatioByFCF($financialStatement)
    {
        if (!empty($financialStatement->cash_flow_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $fcf = $financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter) - abs($financialStatement->cash_flow_statement->getItem('201')->getValue($selectedYear, $selectedQuarter)) + $financialStatement->cash_flow_statement->getItem('202')->getValue($selectedYear, $selectedQuarter);
            $paidInterests = abs($financialStatement->cash_flow_statement->getItem('10306')->getValue($selectedYear, $selectedQuarter));
            $paidTaxes = abs($financialStatement->cash_flow_statement->getItem('10307')->getValue($selectedYear, $selectedQuarter));
            if ($paidInterests != 0) {
                array_push($this->content, [
                    'name' => 'Interest Coverage Ratio By FCF',
                    'group' => 'Chỉ số dòng tiền',
                    'unit' => 'scalar',
                    'description' => 'Hệ số khả năng thanh toán lãi vay của dòng tiền tự do, Interest Coverage Ratio By FCF = (FCF + Interest Paid + Taxes Paid)/ Interest Paid. Hệ số này đánh giá khả năng doanh nghiệp có thể hoàn trả lãi vay của các khoản vay nợ từ dòng tiền FCF trong kỳ của mình hay không. Doanh nghiệp sử dụng đòn bẩy càng cao thì tỷ lệ này càng thấp, doanh nghiệp có 1 bảng cân đối lành mạnh sẽ có tỷ lệ này rất cao. Đối với những doanh nghiệp sử dụng quá nhiều nợ vay (đòn bẩy cao), tỷ lệ này nhỏ hơn 1, khi đó doanh nghiệp sẽ có nhiều khả năng vỡ nợ',
                    'value' => round(($fcf + $paidInterests + $paidTaxes) / $paidInterests, 4)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate Asset Efficency For FCF Ratio - He so hieu qua tao dong tien tu do cua tai san
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateAssetEfficencyForFCFRatio($financialStatement)
    {
        if (!empty($financialStatement->cash_flow_statement) && !empty($financialStatement->balance_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $fcf = $financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter) - abs($financialStatement->cash_flow_statement->getItem('201')->getValue($selectedYear, $selectedQuarter)) + $financialStatement->cash_flow_statement->getItem('202')->getValue($selectedYear, $selectedQuarter);
            $average_assets = array_sum($financialStatement->balance_statement->getItem('2')->getValues())/2;
            if ($average_assets != 0) {
                array_push($this->content, [
                    'name' => 'Asset Efficency For FCF Ratio',
                    'group' => 'Chỉ số dòng tiền',
                    'unit' => '%',
                    'description' => 'Hệ số hiệu quả tạo dòng tiền tự do từ tài sản đánh giá hiệu quả chuyển đổi từ tài sản thành dòng tiền tự do cho doanh nghiệp. Asset Efficiency For FCF Ratio = FCF / Average Assets',
                    'value' => round(100 * $fcf / $average_assets, 2)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate Cash Generating Power Ratio - He so suc manh tao tien
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateCashGeneratingPowerRatio($financialStatement)
    {
        if (!empty($financialStatement->cash_flow_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $cfo = $financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter);
            $investingInflows = $financialStatement->cash_flow_statement->getItem('202')->getValue($selectedYear, $selectedQuarter) + $financialStatement->cash_flow_statement->getItem('204')->getValue($selectedYear, $selectedQuarter) + $financialStatement->cash_flow_statement->getItem('208')->getValue($selectedYear, $selectedQuarter) + $financialStatement->cash_flow_statement->getItem('209')->getValue($selectedYear, $selectedQuarter) + $financialStatement->cash_flow_statement->getItem('210')->getValue($selectedYear, $selectedQuarter);
            $financingInflows = $financialStatement->cash_flow_statement->getItem('301')->getValue($selectedYear, $selectedQuarter) + $financialStatement->cash_flow_statement->getItem('303')->getValue($selectedYear, $selectedQuarter);
            if ($cfo > 0) {
                array_push($this->content, [
                    'name' => 'Cash Generating Power Ratio',
                    'group' => 'Chỉ số dòng tiền',
                    'unit' => '%',
                    'description' => 'Hệ số đánh giá khả năng tạo ra tiền mặt của doanh nghiệp hoàn toàn dựa trên hoạt động kinh doanh, so sánh trên tổng dòng tiền vào của doanh nghiệp, Cash Generating Power Ratio = CFO / (CFO + Cash from Investing Inflows + Cash from Financing Inflows)',
                    'value' => round(100 * $cfo / ($cfo + $investingInflows + $financingInflows), 2)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate External Financing Ratio - He so phu thuoc tai chinh ngoai
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateExternalFinancingRatio($financialStatement)
    {
        if (!empty($financialStatement->cash_flow_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $cfo = $financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter);
            $cff = $financialStatement->cash_flow_statement->getItem('311')->getValue($selectedYear, $selectedQuarter);
            if ($cfo != 0) {
                array_push($this->content, [
                    'name' => 'External Financing Ratio',
                    'group' => 'Chỉ số dòng tiền',
                    'unit' => 'scalar',
                    'description' => 'Hệ số phụ thuộc tài chính bên ngoài, External Financing Ratio = Cash flows from financing / CFO. Hệ số này so sánh giữa dòng tiền thuần từ hoạt động tài chính với dòng tiền thuần từ hoạt động kinh doanh để đánh giá sự phụ thuộc của doanh nghiệp vào hoạt động tài chính. Hệ số này càng cao chứng tỏ doanh nghiệp phụ thuộc nhiều vào dòng tiền, dòng vốn đến từ bên ngoài (nợ vay hoặc phát hành thêm cổ phiếu). Thông thường, những doanh nghiệp có tài chính ổn định và hoạt động kinh doanh tốt thường có tỷ lệ External Finacing Ratio âm (nhỏ hơn 0) & CFO > 0',
                    'value' => round($cff/$cfo, 2)
                ]);
            }
        }
        return $this;
    }
}