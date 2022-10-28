<?php
/**
 * CashFlowCalculator
 *
 * @author: tuanha
 * @date: 18-Aug-2022
 */
namespace App\Jobs\Financials\Calculators;

use App\Jobs\Financials\Calculators\BaseCalculator;

class CashFlowCalculator extends BaseCalculator
{
    public $liabilityCoverageRatioByCFO = null; //Hệ số thanh toán nợ bằng dòng tiền hoạt động kinh doanh

    public $currentLiabilityCoverageRatioByCFO = null; //Hệ số thanh toán nợ ngắn hạn bằng dòng tiền hoạt động kinh doanh

    public $longTermLiabilityCoverageRatioByCFO = null; //Hệ số thanh toán nợ dài hạn bằng dòng tiền hoạt động kinh doanh

    public $cFOToRevenue = null; //CFO/Doanh thu thuần

    public $fCFToRevenue = null; //FCF/Doanh thu thuần

    public $liabilityCoverageRatioByFCF = null; //Hệ số thanh toán nợ bằng dòng tiền tự do

    public $currentLiabilityCoverageRatioByFCF = null; //Hệ số thanh toán nợ ngắn hạn bằng dòng tiền tự do

    public $longTermLiabilityCoverageRatioByFCF = null; //Hệ số thanh toán nợ dài hạn bằng dòng tiền tự do

    public $interestCoverageRatioByFCF = null; //Hệ số thanh toán lãi vay bằng dòng tiền tự do

    public $assetEfficencyForFCFRatio = null; //Hệ số hiệu quả chuyển đổi tài sản thành dòng tiền tự do

    public $cashGeneratingPowerRatio = null; //Hệ số hiệu quả tạo tiền từ hoạt động kinh doanh

    public $externalFinancingRatio = null; //Hệ số phụ thuộc tài chính bên ngoài

    /**
     * Calculate Liability Coverage Ratio By CFO - He so kha nang thanh toan no cua dong tien kinh doanh
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\CashFlowCalculator $this
     */
    public function calculateLiabilityCoverageRatioByCFO($year = null, $quarter = null)
    {
        if (!empty($this->financialStatement->cash_flow_statement) && !empty($this->financialStatement->balance_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $cfo = $this->financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter);
            $average_liabilities = $this->financialStatement->balance_statement->getItem('301')->getAverageValue($selectedYear, $selectedQuarter);
            if ($average_liabilities != 0) {
                $this->liabilityCoverageRatioByCFO = round($cfo / $average_liabilities, 4);
            }
        }
        return $this;
    }

    /**
     * Calculate Current Liabilities Coverage Ratio By CFO - He so kha nang thanh toan no ngan han cua dong tien kinh doanh
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\CashFlowCalculator $this
     */
    public function calculateCurrentLiabilityCoverageRatioByCFO($year = null, $quarter = null)
    {
        if (!empty($this->financialStatement->cash_flow_statement) && !empty($this->financialStatement->balance_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $cfo = $this->financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter);
            $average_current_liabilities = $this->financialStatement->balance_statement->getItem('30101')->getAverageValue($selectedYear, $selectedQuarter);
            if ($average_current_liabilities != 0) {
                $this->currentLiabilityCoverageRatioByCFO = round($cfo / $average_current_liabilities, 4);
            }
        }
        return $this;
    }

    /**
     * Calculate Long-term Liability Coverage Ratio By CFO - He so kha nang thanh toan no dai han cua dong tien kinh doanh
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\CashFlowCalculator $this
     */
    public function calculateLongTermLiabilityCoverageRatioByCFO($year = null, $quarter = null)
    {
        if (!empty($this->financialStatement->cash_flow_statement) && !empty($this->financialStatement->balance_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $cfo = $this->financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter);
            $average_long_term_liabilitiess = $this->financialStatement->balance_statement->getItem('30102')->getAverageValue($selectedYear, $selectedQuarter);
            if ($average_long_term_liabilitiess != 0) {
                $this->longTermLiabilityCoverageRatioByCFO = round($cfo / $average_long_term_liabilitiess, 4);
            }
        }
        return $this;
    }

    /**
     * Calculate CFO/Revenue
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\CashFlowCalculator $this
     */
    public function calculateCFOToRevenue($year = null, $quarter = null)
    {
        if (!empty($this->financialStatement->cash_flow_statement) && !empty($this->financialStatement->income_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $cfo = $this->financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter);
            $net_revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            if ($net_revenue != 0) {
                $this->cFOToRevenue = round(100 * $cfo / $net_revenue, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate FCF/Revenue
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\CashFlowCalculator $this
     */
    public function calculateFCFToRevenue($year = null, $quarter = null)
    {
        if (!empty($this->financialStatement->cash_flow_statement) && !empty($this->financialStatement->income_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $fcf = $this->financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->cash_flow_statement->getItem('201')->getValue($selectedYear, $selectedQuarter) + $this->financialStatement->cash_flow_statement->getItem('202')->getValue($selectedYear, $selectedQuarter);
            $net_revenue = $this->financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            if ($net_revenue != 0) {
                $this->fCFToRevenue = round(100 * $fcf / $net_revenue, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate Liability Coverage Ratio By FCF - He so kha nang thanh toan no cua dong tien tu do
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\CashFlowCalculator $this
     */
    public function calculateLiabilityCoverageRatioByFCF($year = null, $quarter = null)
    {
        if (!empty($this->financialStatement->cash_flow_statement) && !empty($this->financialStatement->balance_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $fcf = $this->financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter) - abs($this->financialStatement->cash_flow_statement->getItem('201')->getValue($selectedYear, $selectedQuarter)) + $this->financialStatement->cash_flow_statement->getItem('202')->getValue($selectedYear, $selectedQuarter);
            $average_liabilities = $this->financialStatement->balance_statement->getItem('301')->getAverageValue($selectedYear, $selectedQuarter);
            if ($average_liabilities != 0) {
                $this->liabilityCoverageRatioByFCF = round($fcf / $average_liabilities, 4);
            }
        }
        return $this;
    }

    /**
     * Calculate Current Liabilities Coverage Ratio By FCF - He so kha nang thanh toan no ngan han cua dong tien tu do
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\CashFlowCalculator $this
     */
    public function calculateCurrentLiabilityCoverageRatioByFCF($year = null, $quarter = null)
    {
        if (!empty($this->financialStatement->cash_flow_statement) && !empty($this->financialStatement->balance_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $fcf = $this->financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter) - abs($this->financialStatement->cash_flow_statement->getItem('201')->getValue($selectedYear, $selectedQuarter)) + $this->financialStatement->cash_flow_statement->getItem('202')->getValue($selectedYear, $selectedQuarter);
            $average_current_liabilities = $this->financialStatement->balance_statement->getItem('30101')->getAverageValue($selectedYear, $selectedQuarter);
            if ($average_current_liabilities != 0) {
                $this->currentLiabilityCoverageRatioByFCF = round($fcf / $average_current_liabilities, 4);
            }
        }
        return $this;
    }

    /**
     * Calculate Long-term Liability Coverage Ratio By FCF - He so kha nang thanh toan no dai han cua dong tien tu do
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\CashFlowCalculator $this
     */
    public function calculateLongTermLiabilityCoverageRatioByFCF($year = null, $quarter = null)
    {
        if (!empty($this->financialStatement->cash_flow_statement) && !empty($this->financialStatement->balance_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $fcf = $this->financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter) - abs($this->financialStatement->cash_flow_statement->getItem('201')->getValue($selectedYear, $selectedQuarter)) + $this->financialStatement->cash_flow_statement->getItem('202')->getValue($selectedYear, $selectedQuarter);
            $average_long_term_liabilities = $this->financialStatement->balance_statement->getItem('30102')->getAverageValue($selectedYear, $selectedQuarter);
            if ($average_long_term_liabilities != 0) {
                $this->longTermLiabilityCoverageRatioByFCF = round($fcf / $average_long_term_liabilities, 4);
            }
        }
        return $this;
    }

    /**
     * Calculate Interest Coverage Ratio By FCF - He so kha nang thanh toan lai vay cua dong tien tu do
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\CashFlowCalculator $this
     */
    public function calculateInterestCoverageRatioByFCF($year = null, $quarter = null)
    {
        if (!empty($this->financialStatement->cash_flow_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $fcf = $this->financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter) - abs($this->financialStatement->cash_flow_statement->getItem('201')->getValue($selectedYear, $selectedQuarter)) + $this->financialStatement->cash_flow_statement->getItem('202')->getValue($selectedYear, $selectedQuarter);
            $paidInterests = abs($this->financialStatement->cash_flow_statement->getItem('10306')->getValue($selectedYear, $selectedQuarter));
            $paidTaxes = abs($this->financialStatement->cash_flow_statement->getItem('10307')->getValue($selectedYear, $selectedQuarter));
            if ($paidInterests != 0) {
                $this->interestCoverageRatioByFCF = round(($fcf + $paidInterests + $paidTaxes) / $paidInterests, 4);
            }
        }
        return $this;
    }

    /**
     * Calculate Asset Efficency For FCF Ratio - He so hieu qua tao dong tien tu do cua tai san
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\CashFlowCalculator $this
     */
    public function calculateAssetEfficencyForFCFRatio($year = null, $quarter = null)
    {
        if (!empty($this->financialStatement->cash_flow_statement) && !empty($this->financialStatement->balance_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $fcf = $this->financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter) - abs($this->financialStatement->cash_flow_statement->getItem('201')->getValue($selectedYear, $selectedQuarter)) + $this->financialStatement->cash_flow_statement->getItem('202')->getValue($selectedYear, $selectedQuarter);
            $average_assets = $this->financialStatement->balance_statement->getItem('2')->getAverageValue($selectedYear, $selectedQuarter);
            if ($average_assets != 0) {
                $this->assetEfficencyForFCFRatio = round(100 * $fcf / $average_assets, 2);
            }
        }
        return $this;
    }

    /**
     * Calculate Cash Generating Power Ratio - He so suc manh tao tien
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\CashFlowCalculator $this
     */
    public function calculateCashGeneratingPowerRatio($year = null, $quarter = null)
    {
        if (!empty($this->financialStatement->cash_flow_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $cfo = $this->financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter);
            $investingInflows = 0;
            $financingInflows = 0;
            for ($i = 201; $i < 212 ; $i++) {
                if ($this->financialStatement->cash_flow_statement->getItem("$i")->getValue($selectedYear, $selectedQuarter) > 0) {
                    $investingInflows += $this->financialStatement->cash_flow_statement->getItem("$i")->getValue($selectedYear, $selectedQuarter);
                }
            }
            for ($i = 301; $i < 311 ; $i++) {
                if ($this->financialStatement->cash_flow_statement->getItem("$i")->getValue($selectedYear, $selectedQuarter) > 0) {
                    $financingInflows += $this->financialStatement->cash_flow_statement->getItem("$i")->getValue($selectedYear, $selectedQuarter);
                }
            }
            if ($cfo > 0) {
                $this->cashGeneratingPowerRatio = round(100 * $cfo / ($cfo + $investingInflows + $financingInflows), 2);
            }
        }
        return $this;
    }

    /**
     * Calculate External Financing Ratio - He so phu thuoc tai chinh ngoai
     *
     * @param int $year
     * @param int $quarter
     * @return \App\Jobs\Financials\Calculators\CashFlowCalculator $this
     */
    public function calculateExternalFinancingRatio($year = null, $quarter = null)
    {
        if (!empty($this->financialStatement->cash_flow_statement)) {
            $selectedYear = $year ?? $this->financialStatement->year;
            $selectedQuarter = $quarter ?? $this->financialStatement->quarter;
            $cfo = $this->financialStatement->cash_flow_statement->getItem('104')->getValue($selectedYear, $selectedQuarter);
            $cff = $this->financialStatement->cash_flow_statement->getItem('311')->getValue($selectedYear, $selectedQuarter);
            if ($cfo != 0) {
                $this->externalFinancingRatio = round($cff/$cfo, 2);
            }
        }
        return $this;
    }
}
