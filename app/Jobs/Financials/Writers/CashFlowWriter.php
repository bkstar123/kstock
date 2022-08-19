<?php
/**
 * CashFlowWriter trait
 *
 * @author: tuanha
 * @date: 14-Aug-2022
 */
namespace App\Jobs\Financials\Writers;

use App\Jobs\Financials\Calculators\CashFlowCalculator;

trait CashFlowWriter
{
    /**
     * Write Liability Coverage Ratio By CFO - He so kha nang thanh toan no cua dong tien kinh doanh
     *
     * @param \App\Jobs\Financials\Calculators\CashFlowCalculator $calculator
     * @return $this
     */
    protected function writeLiabilityCoverageRatioByCFO(CashFlowCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Hệ số thanh toán nợ bằng dòng tiền hoạt động kinh doanh',
            'alias' => 'Liability Coverage Ratio By CFO',
            'group' => 'Chỉ số dòng tiền',
            'unit' => 'scalar',
            'description' => 'Hệ số khả năng thanh toán nợ của dòng tiền kinh doanh, Liability Coverage Ratio by CFO = CFO / Average Liabilities. Hệ số này cho biết với dòng tiền thuần từ  HĐKD trong kỳ, DN có đảm bảo khả năng đáp ứng được nợ phải trả hay không. Nói cách khác, một đồng nợ phải trả bình quân trong kỳ được đảm bảo bởi mấy đồng tiền và tương đương tiền lưu chuyển thuàn từ HĐKD. Khi trị số của chỉ tiêu này lớn hơn hoặc bằng một(>= 1), dòng tiền lưu chuyển thuần từ HĐKD trong kỳ bảo đảm đáp ứng đủ và thừa khả năng thanh toán nợ phải trả trong kỳ và ngược lại',
            'value' => $calculator->liabilityCoverageRatioByCFO
        ]);
        return $this;
    }

    /**
     * Write Current Liabilities Coverage Ratio By CFO - He so kha nang thanh toan no ngan han cua dong tien kinh doanh
     *
     * @param \App\Jobs\Financials\Calculators\CashFlowCalculator $calculator
     * @return $this
     */
    protected function writeCurrentLiabilityCoverageRatioByCFO(CashFlowCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Hệ số thanh toán nợ ngắn hạn bằng dòng tiền hoạt động kinh doanh',
            'alias' => 'Current Liability Coverage Ratio By CFO',
            'group' => 'Chỉ số dòng tiền',
            'unit' => 'scalar',
            'description' => 'Hệ số khả năng thanh toán nợ ngắn hạn của dòng tiền kinh doanh, Current Liability Coverage Ratio By CFO = CFO / Average Current Liabilities. Hệ số này cho biết dòng tiền lưu chuyển thuần từ hoạt động kinh doanh (HĐKD) trong kỳ có đảm bảo trang trải được các khoản nợ ngắn hạn (Kể cả nợ dài hạn đến hạn trả) hay không. Do dòng tiền lưu chuyển thuần tạo ra từ HĐKD là dòng tiền an ninh tài chính của doanh nghiệp nên khi chỉ số này lớn hơn hoặc bằng một (>=1), Doanh nghiệp có đủ khả năng thanh toán nợ ngắn hạn bằng dòng tiền hoạt động kinh doanh và ngược lại, dòng tiền HĐKD tạo ra không đủ để trả nợ ngắn hạn',
            'value' => $calculator->currentLiabilityCoverageRatioByCFO
        ]);
        return $this;
    }

    /**
     * Write Long-term Liability Coverage Ratio By CFO - He so kha nang thanh toan no dai han cua dong tien kinh doanh
     *
     * @param \App\Jobs\Financials\Calculators\CashFlowCalculator $calculator
     * @return $this
     */
    protected function writeLongTermLiabilityCoverageRatioByCFO(CashFlowCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Hệ số thanh toán nợ dài hạn bằng dòng tiền hoạt động kinh doanh',
            'alias' => 'Long-term Liability Coverage Ratio By CFO',
            'group' => 'Chỉ số dòng tiền',
            'unit' => 'scalar',
            'description' => 'Hệ số khả năng thanh toán nợ dài hạn của dòng tiền kinh doanh, Long-term Liability Coverage Ratio By CFO = CFO / Average Long-term Liability. Hệ số này cho biết mức độ bảo đảm nợ dài hạn bằng dòng tiền lưu chuyển thuần từ HĐKD. Hay nói cách khác, cứ một đồng nợ dài hạn bình quân trong kỳ phải trả của DN được đảm bảo bởi mấy đồng tiền lưu chuyển thuần từ HĐKD. Khi trị số của chỉ tiêu lớn hơn hoặc bằng 1 (>=1), DN bảo đảm đủ và thừa khả năng thanh toán nợ dài hạn bằng dòng tiền HĐKD và ngược lại',
            'value' => $calculator->longTermLiabilityCoverageRatioByCFO
        ]);
        return $this;
    }

    /**
     * Write CFO/Revenue
     *
     * @param \App\Jobs\Financials\Calculators\CashFlowCalculator $calculator
     * @return $this
     */
    protected function writeCFOToRevenue(CashFlowCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'CFO/Doanh thu thuần',
            'alias' => 'CFO/Revenue',
            'group' => 'Chỉ số dòng tiền',
            'unit' => '%',
            'description' => 'Chỉ số này cho biết tỉ lệ chuyển đổi từ một đồng doanh thu thuần sang dòng tiền hoạt động kinh doanh',
            'value' => $calculator->cFOToRevenue
        ]);
        return $this;
    }

    /**
     * Write FCF/Revenue
     *
     * @param \App\Jobs\Financials\Calculators\CashFlowCalculator $calculator
     * @return $this
     */
    protected function writeFCFToRevenue(CashFlowCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'FCF/Doanh thu thuần',
            'alias' => 'FCF/Revenue',
            'group' => 'Chỉ số dòng tiền',
            'unit' => '%',
            'description' => 'Chỉ số này cho biết tỉ lệ chuyển đổi từ một đồng doanh thu thuần sang dòng tiền tự do, FCF = CFO - CAPEX',
            'value' => $calculator->fCFToRevenue
        ]);
        return $this;
    }

    /**
     * Write Liability Coverage Ratio By FCF - He so kha nang thanh toan no cua dong tien tu do
     *
     * @param \App\Jobs\Financials\Calculators\CashFlowCalculator $calculator
     * @return $this
     */
    protected function writeLiabilityCoverageRatioByFCF(CashFlowCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Hệ số thanh toán nợ bằng dòng tiền tự do',
            'alias' => 'Liability Coverage Ratio By FCF',
            'group' => 'Chỉ số dòng tiền',
            'unit' => 'scalar',
            'description' => 'Hệ số khả năng thanh toán nợ của dòng tiền tự do, Liability Coverage Ratio by FCF = FCF / Average Liabilities. Hệ số này cho biết với dòng tiền tự do trong kỳ, DN có đảm bảo khả năng đáp ứng được nợ phải trả hay không. Nói cách khác, một đồng nợ phải trả bình quân trong kỳ được đảm bảo bởi mấy đồng tiền tự do. Khi trị số của chỉ tiêu này lớn hơn hoặc bằng một(>= 1), dòng tiền tự do trong kỳ bảo đảm đáp ứng đủ và thừa khả năng thanh toán nợ phải trả trong kỳ và ngược lại',
            'value' => $calculator->liabilityCoverageRatioByFCF
        ]);
        return $this;
    }

    /**
     * Write Current Liabilities Coverage Ratio By FCF - He so kha nang thanh toan no ngan han cua dong tien tu do
     *
     * @param \App\Jobs\Financials\Calculators\CashFlowCalculator $calculator
     * @return $this
     */
    protected function writeCurrentLiabilityCoverageRatioByFCF(CashFlowCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Hệ số thanh toán nợ ngắn hạn bằng dòng tiền tự do',
            'alias' => 'Current Liability Coverage Ratio By FCF',
            'group' => 'Chỉ số dòng tiền',
            'unit' => 'scalar',
            'description' => 'Hệ số khả năng thanh toán nợ ngắn hạn của dòng tiền tự do, Current Liability Coverage Ratio By FCF = FCF / Average Current Liabilities. Hệ số này cho biết dòng tiền tự do trong kỳ có đảm bảo trang trải được các khoản nợ ngắn hạn (Kể cả nợ dài hạn đến hạn trả) hay không, khi chỉ số này lớn hơn hoặc bằng một (>=1), Doanh nghiệp có đủ dòng tiền tự do để thanh toán nợ ngắn hạn và ngược lại, sdòng tiền tư do tạo ra không đủ để trả nợ ngắn hạn',
            'value' => $calculator->currentLiabilityCoverageRatioByFCF
        ]);
        return $this;
    }

    /**
     * Write Long-term Liability Coverage Ratio By FCF - He so kha nang thanh toan no dai han cua dong tien tu do
     *
     * @param \App\Jobs\Financials\Calculators\CashFlowCalculator $calculator
     * @return $this
     */
    protected function writeLongTermLiabilityCoverageRatioByFCF(CashFlowCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Hệ số thanh toán nợ dài hạn bằng dòng tiền tự do',
            'alias' => 'Long-term Liability Coverage Ratio By FCF',
            'group' => 'Chỉ số dòng tiền',
            'unit' => 'scalar',
            'description' => 'Hệ số khả năng thanh toán nợ dài hạn của dòng tiền tự do, Long-term Liability Coverage Ratio By FCF = FCF / Average Long-term Liability. Hệ số này cho biết mức độ bảo đảm nợ dài hạn bằng dòng tiền tự do tạo ra. Hay nói cách khác, cứ một đồng nợ dài hạn bình quân trong kỳ phải trả của DN được đảm bảo bởi mấy đồng dòng tiền tự do. Khi trị số của chỉ tiêu lớn hơn hoặc bằng 1 (>=1), DN bảo đảm đủ và thừa khả năng thanh toán nợ dài hạn bằng dòng tiền tự do và ngược lại',
            'value' => $calculator->longTermLiabilityCoverageRatioByFCF
        ]);
        return $this;
    }

    /**
     * Write Interest Coverage Ratio By FCF - He so kha nang thanh toan lai vay cua dong tien tu do
     *
     * @param \App\Jobs\Financials\Calculators\CashFlowCalculator $calculator
     * @return $this
     */
    protected function writeInterestCoverageRatioByFCF(CashFlowCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Hệ số thanh toán lãi vay bằng dòng tiền tự do',
            'alias' => 'Interest Coverage Ratio By FCF',
            'group' => 'Chỉ số dòng tiền',
            'unit' => 'scalar',
            'description' => 'Hệ số khả năng thanh toán lãi vay của dòng tiền tự do, Interest Coverage Ratio By FCF = (FCF + Interest Paid + Taxes Paid)/ Interest Paid. Hệ số này đánh giá khả năng doanh nghiệp có thể hoàn trả lãi vay của các khoản vay nợ từ dòng tiền FCF trong kỳ của mình hay không. Doanh nghiệp sử dụng đòn bẩy càng cao thì tỷ lệ này càng thấp, doanh nghiệp có 1 bảng cân đối lành mạnh sẽ có tỷ lệ này rất cao. Đối với những doanh nghiệp sử dụng quá nhiều nợ vay (đòn bẩy cao), tỷ lệ này nhỏ hơn 1, khi đó doanh nghiệp sẽ có nhiều khả năng vỡ nợ',
            'value' => $calculator->interestCoverageRatioByFCF
        ]);
        return $this;
    }

    /**
     * Write Asset Efficency For FCF Ratio - He so hieu qua tao dong tien tu do cua tai san
     *
     * @param \App\Jobs\Financials\Calculators\CashFlowCalculator $calculator
     * @return $this
     */
    protected function writeAssetEfficencyForFCFRatio(CashFlowCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Hệ số hiệu quả chuyển đổi tài sản thành dòng tiền tự do',
            'alias' => 'Asset Efficency For FCF Ratio',
            'group' => 'Chỉ số dòng tiền',
            'unit' => '%',
            'description' => 'Hệ số hiệu quả tạo dòng tiền tự do từ tài sản đánh giá hiệu quả chuyển đổi từ tài sản thành dòng tiền tự do cho doanh nghiệp. Asset Efficiency For FCF Ratio = FCF / Average Assets',
            'value' => $calculator->assetEfficencyForFCFRatio
        ]);
        return $this;
    }

    /**
     * Write Cash Generating Power Ratio - He so suc manh tao tien
     *
     * @param \App\Jobs\Financials\Calculators\CashFlowCalculator $calculator
     * @return $this
     */
    protected function writeCashGeneratingPowerRatio(CashFlowCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Hệ số hiệu quả tạo tiền từ hoạt động kinh doanh',
            'alias' => 'Cash Generating Power Ratio',
            'group' => 'Chỉ số dòng tiền',
            'unit' => '%',
            'description' => 'Hệ số đánh giá khả năng tạo ra tiền mặt của doanh nghiệp hoàn toàn dựa trên hoạt động kinh doanh, so sánh trên tổng dòng tiền vào của doanh nghiệp, Cash Generating Power Ratio = CFO / (CFO + Cash from Investing Inflows + Cash from Financing Inflows)',
            'value' => $calculator->cashGeneratingPowerRatio
        ]);
        return $this;
    }

    /**
     * Write External Financing Ratio - He so phu thuoc tai chinh ngoai
     *
     * @param \App\Jobs\Financials\Calculators\CashFlowCalculator $calculator
     * @return $this
     */
    protected function writeExternalFinancingRatio(CashFlowCalculator $calculator)
    {
        array_push($this->content, [
            'name' => 'Hệ số phụ thuộc tài chính bên ngoài',
            'alias' => 'External Financing Ratio',
            'group' => 'Chỉ số dòng tiền',
            'unit' => 'scalar',
            'description' => 'Hệ số phụ thuộc tài chính bên ngoài, External Financing Ratio = Cash flows from financing / CFO. Hệ số này so sánh giữa dòng tiền thuần từ hoạt động tài chính với dòng tiền thuần từ hoạt động kinh doanh để đánh giá sự phụ thuộc của doanh nghiệp vào hoạt động tài chính. Hệ số này càng cao chứng tỏ doanh nghiệp phụ thuộc nhiều vào dòng tiền, dòng vốn đến từ bên ngoài (nợ vay hoặc phát hành thêm cổ phiếu). Thông thường, những doanh nghiệp có tài chính ổn định và hoạt động kinh doanh tốt thường có tỷ lệ External Finacing Ratio âm (nhỏ hơn 0) & CFO > 0',
            'value' => $calculator->externalFinancingRatio
        ]);
        return $this;
    }
}