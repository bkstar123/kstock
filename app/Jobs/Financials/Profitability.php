<?php
/**
 * Profitability trait
 *
 * @author: tuanha
 * @date: 14-Aug-2022
 */
namespace App\Jobs\Financials;

use App\Jobs\Financials\Calculators\ProfitabilityCalculator;

trait Profitability
{
	/**
     * Calculate ROAA - Ty suat loi nhuan tren tong tai san binh quan
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return $this
     */
    protected function calculateROAA(ProfitabilityCalculator $calculator)
    {
        
        if (!empty($financialStatement->balance_statement) &&
            !empty($financialStatement->income_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $average_assets = array_sum($financialStatement->balance_statement->getItem('2')->getValues())/2;
            if ($average_assets != 0) {
                array_push($this->content, [
                    'name' => 'Tỷ suất lợi nhuận trên tài sản bình quân (ROAA)',
                    'alias' => 'ROAA',
                    'group' => 'Chỉ số sinh lời',
                    'unit' => '%',
                    'description' => 'Tỷ suất lợi nhuận trên tài sản bình quân (Return on Average Assets). Chỉ số này cho biết tài sản của một doanh nghiệp đang được sử dụng tốt như thế nào để tạo ra lợi nhuận. ROAA = 100% * Lợi nhuận sau thuế của cổ đông của công ty mẹ cùng kì với tài sản / Tổng tài sản trung bình. Với tổng tài sản trung bình = (tài sản đầu kỳ + tài sản cuối kì)/2',
                    'value' => round(100 * $financialStatement->income_statement->getItem('21')->getValue($selectedYear, $selectedQuarter) / $average_assets, 2)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate ROCE - Ty suat loi nhuan tren von dai han binh quan
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return array
     */
    protected function calculateROCE($financialStatement)
    {
        if (!empty($financialStatement->balance_statement) &&
            !empty($financialStatement->income_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $average_assets = array_sum($financialStatement->balance_statement->getItem('2')->getValues())/2;
            $average_current_liabilities = array_sum($financialStatement->balance_statement->getItem('30101')->getValues())/2;
            $eBIT = $financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter) + $financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
            if ($average_assets != $average_current_liabilities) {
                array_push($this->content, [
                    'name' => 'Tỷ suất lợi nhuận trên vốn dài hạn bình quân (ROCE)',
                    'alias' => 'ROCE',
                    'group' => 'Chỉ số sinh lời',
                    'unit' => '%',
                    'description' => 'Tỷ suất lợi nhuận trên vốn dài hạn bình quân (Return on Capital Employed), đo lường khả năng sinh lời và hiệu quả sử dụng vốn của doanh nghiệp, nó cho biết mức độ sinh lời của doanh nghiệp từ số vốn đầu tư ban đầu. Chỉ số ROCE có thể đặc biệt hữu ích khi so sánh hiệu quả hoạt động của các công ty trong các lĩnh vực sử dụng nhiều vốn. Chẳng hạn như các dịch vụ tiện ích và viễn thông. Điều này là do không giống như các nguyên tắc cơ bản khác như  lợi nhuận trên vốn chủ sở hữu  (ROE), vốn chỉ phân tích khả năng sinh lời liên quan đến vốn chủ sở hữu của cổ đông công ty, ROCE xem xét nợ và vốn chủ sở hữu . Điều này có thể giúp phân tích hiệu quả tài chính đối với các công ty có nợ đáng kể. ROCE = EBIT x 100% / (Tổng tài sản bình quân - nợ ngắn hạn bình quân). (Bình quân: tính trung bình con số đầu kì và cuối kì).',
                    'value' => round(100 * $eBIT / ($average_assets - $average_current_liabilities), 2)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate ROEA - Ty suat loi nhuan tren VCSH binh quan
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return array
     */
    protected function calculateROEA($financialStatement)
    {
        if (!empty($financialStatement->balance_statement) &&
            !empty($financialStatement->income_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $parent_company_net_profit = $financialStatement->income_statement->getItem('21')->getValue($selectedYear, $selectedQuarter);
            $average_equities = array_sum($financialStatement->balance_statement->getItem('302')->getValues())/2;
            if ($average_equities != 0) {
                array_push($this->content, [
                    'name' => 'Tỷ suất lợi nhuận trên vốn chủ sở hữu bình quân (ROEA0',
                    'alias' => 'ROEA',
                    'group' => 'Chỉ số sinh lời',
                    'unit' => '%',
                    'description' => 'Tỷ suất lợi nhuận trên vốn chủ sở hữu bình quân (Return on Equity Average), đo lường mức độ hiệu quả trong việc sử dụng vốn chủ sở hữu của doanh nghiệp, ROEA được dùng kết hợp với chỉ số ROE khi phân tích một doanh nghiệp có hiện tượng biến động vốn chủ sở hữu quá lớn trong kỳ phân tích. Chỉ số ROE được tính bằng tỷ lệ giữa lợi nhuận ròng và vốn chủ sở hữu. Lợi nhuận ròng khá dễ để xác định và ít bị ảnh hưởng từ bên ngoài. Tuy nhiên vốn chủ sở hữu thường chịu ảnh hưởng bởi các yếu tố: lợi nhuận giữ lại, sáp nhập; phát hành riêng lẻ để tăng vốn… Vì vậy xét trong 1 năm tài chính, nếu doanh nghiệp có sự biến động về vốn chủ sở hữu thì ROE sẽ không phản ánh chính xác khả năng sinh lời của việc sử dụng vốn của doanh nghiệp. ROEA đo lường chính xác hơn về hiệu quả sử dụng vốn của doanh nghiệp trong trường hợp  vốn chủ sở hữu đã có sự biến động trong năm tài chính nhờ việc tính bình quân vốn chủ sở hữu trong kỳ. ROEA = 100% x Lợi nhuận sau thuế của cổ đông công ty mẹ / Vốn chủ sở hữu bình quân. (Bình quân: tính trung bình con số đầu kì và cuối kì).',
                    'value' => round(100 * $parent_company_net_profit / $average_equities, 2)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate ROS - Ty suat loi nhuan rong
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return array
     */
    protected function calculateROS($financialStatement)
    {
        if (!empty($financialStatement->income_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $net_profit = $financialStatement->income_statement->getItem('19')->getValue($selectedYear, $selectedQuarter);
            $net_revenue = $financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            if ($net_revenue != 0) {
                array_push($this->content, [
                    'name' => 'Tỉ suất lợi nhuận ròng (ROS)',
                    'alias' => 'ROS',
                    'group' => 'Chỉ số sinh lời',
                    'unit' => '%',
                    'description' => 'Tỉ suất lợi nhuận ròng trên doanh thu thuần (Return On Sales – ROS) là tỉ lệ thể hiện mối tương quan giữa lợi nhuận được tạo ra dựa trên mỗi đồng doanh số. Chỉ tiêu này cho biết với một đồng doanh thu thuần từ bán hàng và cung cấp dịch vụ sẽ tạo ra bao nhiêu đồng lợi nhuận. Tỷ suất này càng lớn thì hiệu quả hoạt động của doanh nghiệp càng cao. ROS = 100 * Lợi nhuận sau thuế/ Doanh thu thuần',
                    'value' => round(100 * $net_profit / $net_revenue, 2)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate EBITDA/Sales
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return array
     */
    protected function calculateEBITDAPerSales($financialStatement)
    {
        if (!empty($financialStatement->balance_statement) &&
            !empty($financialStatement->income_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $eBit = $financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter) + $financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
            $tangibleStaticAssets = $financialStatement->balance_statement->getItem("102020102")->getValues();
            $financialLendingStaticAssets = $financialStatement->balance_statement->getItem("102020202")->getValues();
            $intangibleStaticAssets = $financialStatement->balance_statement->getItem("102020302")->getValues();
            $investRealEstate = $financialStatement->balance_statement->getItem("1020302")->getValues();
            $deprecation = abs($tangibleStaticAssets[1]) - abs($tangibleStaticAssets[0]) + abs($financialLendingStaticAssets[1]) - abs($financialLendingStaticAssets[0]) + abs($intangibleStaticAssets[1]) - abs($intangibleStaticAssets[0]) + abs($investRealEstate[1]) - abs($investRealEstate[0]);
            $eBITDA = $eBit + $deprecation;
            $net_revenue = $financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            if ($net_revenue != 0) {
                array_push($this->content, [
                    'name' => 'Biên lợi nhuận trước thuế lãi vay và khấu hao trên doanh thu thuần (EBITDA margin)',
                    'alias' => 'EBITDA margin',
                    'group' => 'Chỉ số sinh lời',
                    'unit' => '%',
                    'description' => 'Hệ số EBITDA/Doanh thu (EBITDA/Sales) là một thước đo tài chính được sử dụng để đánh giá lợi nhuận của công ty bằng cách so sánh doanh thu của công ty với thu nhập. Cụ thể hơn, số liệu này cho biết tỉ lệ phần trăm thu nhập của công ty còn lại sau chi phí hoạt động. Chi phí hoạt động bao gồm giá vốn hàng bán và chi phí bán hàng, chi phí quản lí chung, chi phí hành chính. Tỉ lệ này tập trung vào chi phí hoạt động trực tiếp khi loại trừ ảnh hưởng của cấu trúc vốn của công ty bằng cách bỏ lãi, chi phí khấu hao, khấu hao không dùng tiền mặt và thuế thu nhập. EBITDA/Sales = 100% * EBITDA / doanh thu thuần',
                    'value' => round(100 * $eBITDA / $net_revenue, 2)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate EBIT/sales
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return array
     */
    protected function calculateEBITPerSales($financialStatement)
    {
        if (!empty($financialStatement->income_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $eBit = $financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter) + $financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
            $net_revenue = $financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            if ($net_revenue != 0) {
                array_push($this->content, [
                    'name' => 'Biên lợi nhuận trước thuế và lãi vay trên doanh thu thuần (EBIT margin)',
                    'alias' => 'EBIT margin',
                    'group' => 'Chỉ số sinh lời',
                    'unit' => '%',
                    'description' => 'EBIT là một chỉ số dùng để đánh giá khả năng thu được lợi nhuận của công ty, bằng thu nhập trừ đi các chi phí, nhưng chưa trừ tiền (trả) lãi và thuế thu nhập. Vai trò của chỉ số EBIT là loại bỏ sự khác nhau giữa cấu trúc vốn và tỷ suất thuế giữa các công ty khác nhau. Đánh giá thu nhập của các doanh nghiệp khi quy đồng về mức thuế về 0, và đều không có vay nợ. EBIT/Sales thể hiện hiệu quả quản lý tất cả chi phí hoạt động, bao gồm giá vốn và chi phí bán hàng, chi phí quản lý của doanh nghiệp. EBIT/Sales = 100% * EBIT / doanh thu thuần',
                    'value' => round(100 * $eBit / $net_revenue, 2)
                ]);
            }
        }
        return $this;
    }

    /**
     * Calculate Gross profit margin - Bien loi nhuan gop
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return array
     */
    protected function calculateGrossProfitMargin($financialStatement)
    {
        if (!empty($financialStatement->income_statement)) {
            $selectedYear = $financialStatement->year;
            $selectedQuarter = $financialStatement->quarter;
            $grossProfit = $financialStatement->income_statement->getItem('5')->getValue($selectedYear, $selectedQuarter);
            $net_revenue = $financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
            if ($net_revenue != 0) {
                array_push($this->content, [
                    'name' => 'Biên lợi nhuận gộp',
                    'alias' => 'Gross profit margin',
                    'group' => 'Chỉ số sinh lời',
                    'unit' => '%',
                    'description' => 'Biên lợi nhuận gộp (Gross Profit Margin) hay còn gọi là tỷ suất lợi nhuận gộp, là một chỉ tiêu quan trọng đánh giá khả năng sinh lời của doanh nghiệp. Chỉ tiêu này được tính theo tỷ lệ phần trăm và cho biết với mỗi đồng doanh thu tạo ra thì doanh nghiệp thu về được bao nhiêu đồng lợi nhuận gộp. GPM = 100% * Lợi nhuận gộp / Doanh thu thuần',
                    'value' => round(100 * $grossProfit / $net_revenue, 2)
                ]);
            }
        }
        return $this;
    }
}