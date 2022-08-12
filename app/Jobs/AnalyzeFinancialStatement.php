<?php
/**
 * AnalyzeFinancialStatement job
 *
 * @author: tuanha
 * @date: 10-Aug-2022
 */
namespace App\Jobs;

use Exception;
use App\Events\JobFailing;
use Illuminate\Bus\Queueable;
use App\Models\AnalysisReport;
use App\Models\FinancialStatement;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Events\AnalyzeFinancialStatementCompleted;

class AnalyzeFinancialStatement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \Bkstar123\BksCMS\AdminPanel\Admin
     */
    public $user;

    /**
     * @var integer
     */
    public $financialStatementID;

    /**
     * @var array
     */
    protected $content = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($financialStatementID, $user)
    {
        $this->financialStatementID = $financialStatementID;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $financialStatement = FinancialStatement::find($this->financialStatementID);
        if (!empty($financialStatement) &&
            !empty($financialStatement->balance_statement) &&
            !empty($financialStatement->income_statement)) {
            // Profitability Indices
            $this->calculateROAA($financialStatement);
            $this->calculateROCE($financialStatement);
            $this->calculateROEA($financialStatement);
            $this->calculateROS($financialStatement);
            AnalysisReport::create([
                'content' => json_encode($this->content),
                'financial_statement_id' => $this->financialStatementID
            ]);
            AnalyzeFinancialStatementCompleted::dispatch($this->user);
        }
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        JobFailing::dispatch($this->user);
    }

    /**
     * Calculate ROAA
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return array
     */
    protected function calculateROAA($financialStatement)
    {
        $selectedYear = $financialStatement->year;
        $selectedQuarter = $financialStatement->quarter;
        $average_assets = array_sum($financialStatement->balance_statement->getItem('2')->getValues())/2;
        array_push($this->content, [
            'name' => 'ROAA',
            'group' => 'Chỉ số sinh lời',
            'description' => 'Tỷ suất lợi nhuận trên tài sản bình quân (Return on Average Assets). Chỉ số này cho biết tài sản của một doanh nghiệp đang được sử dụng tốt như thế nào để tạo ra lợi nhuận. ROAA được tính bằng Thu nhập ròng cùng kì với tài sản / Tổng tài sản trung bình. Với tổng tài sản trung bình được tính bằng (tài sản đầu kỳ + tài sản cuối kì)/2',
            'value' => round(100 * $financialStatement->income_statement->getItem('19')->getValue($selectedYear, $selectedQuarter) / $average_assets, 2)
        ]);
    }

    /**
     * Calculate ROCE
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return array
     */
    protected function calculateROCE($financialStatement)
    {
        $selectedYear = $financialStatement->year;
        $selectedQuarter = $financialStatement->quarter;
        $average_assets = array_sum($financialStatement->balance_statement->getItem('2')->getValues())/2;
        $average_short_liabilities = array_sum($financialStatement->balance_statement->getItem('30101')->getValues())/2;
        $eBIT = $financialStatement->income_statement->getItem('15')->getValue($selectedYear, $selectedQuarter) + $financialStatement->income_statement->getItem('701')->getValue($selectedYear, $selectedQuarter);
        array_push($this->content, [
            'name' => 'ROCE',
            'group' => 'Chỉ số sinh lời',
            'description' => 'Tỷ suất lợi nhuận trên vốn dài hạn bình quân (Return on Capital Employed), đo lường khả năng sinh lời và hiệu quả sử dụng vốn của doanh nghiệp, nó cho biết mức độ sinh lời của doanh nghiệp từ số vốn đầu tư ban đầu. ROCE = EBIT x 100% (Tổng tài sản bình quân - nợ ngắn hạn bình quân). (Bình quân: tính trung bình con số đầu kì và cuối kì). Chỉ số ROCE có thể đặc biệt hữu ích khi so sánh hiệu quả hoạt động của các công ty trong các lĩnh vực sử dụng nhiều vốn. Chẳng hạn như các dịch vụ tiện ích và viễn thông. Điều này là do không giống như các nguyên tắc cơ bản khác như  lợi nhuận trên vốn chủ sở hữu  (ROE), vốn chỉ phân tích khả năng sinh lời liên quan đến vốn chủ sở hữu của cổ đông công ty, ROCE xem xét nợ và vốn chủ sở hữu . Điều này có thể giúp phân tích hiệu quả tài chính đối với các công ty có nợ đáng kể.',
            'value' => round(100 * $eBIT / ($average_assets - $average_short_liabilities), 2)
        ]);
    }

    /**
     * Calculate ROEA
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return array
     */
    protected function calculateROEA($financialStatement)
    {
        $selectedYear = $financialStatement->year;
        $selectedQuarter = $financialStatement->quarter;
        $parent_company_net_profit = $financialStatement->income_statement->getItem('21')->getValue($selectedYear, $selectedQuarter);
        $equities = $financialStatement->balance_statement->getItem('30201')->getValues();
        $uncontrolled_shareolders_benefits = $financialStatement->balance_statement->getItem('3020114')->getValues();
        array_push($this->content, [
            'name' => 'ROEA',
            'group' => 'Chỉ số sinh lời',
            'description' => 'Tỷ suất lợi nhuận trên vốn chủ sở hữu bình quân (Return on Equity Average), đo lường mức độ hiệu quả trong việc sử dụng vốn chủ sở hữu của doanh nghiệp, ROEA được dùng kết hợp với chỉ số ROE khi phân tích một doanh nghiệp có hiện tượng biến động vốn chủ sở hữu quá lớn trong kỳ phân tích. ROEA = [Lợi nhuận sau thuế của cổ đông công ty mẹ / Vốn chủ sở hữu bình quân không bao gồm lợi ích cổ đông thiểu số] x 100% (Bình quân: tính trung bình con số đầu kì và cuối kì). Chỉ số ROE được tính bằng tỷ lệ giữa lợi nhuận ròng và vốn chủ sở hữu. Lợi nhuận ròng khá dễ để xác định và ít bị ảnh hưởng từ bên ngoài. Tuy nhiên vốn chủ sở hữu thường chịu ảnh hưởng bởi các yếu tố: lợi nhuận giữ lại, sáp nhập; phát hành riêng lẻ để tăng vốn… Vì vậy xét trong 1 năm tài chính, nếu doanh nghiệp có sự biến động về vốn chủ sở hữu thì ROE sẽ không phản ánh chính xác khả năng sinh lời của việc sử dụng vốn của doanh nghiệp. ROEA đo lường chính xác hơn về hiệu quả sử dụng vốn của doanh nghiệp trong trường hợp  vốn chủ sở hữu đã có sự biến động trong năm tài chính nhờ việc tính bình quân vốn chủ sở hữu trong kỳ.',
            'value' => round(2* 100 * $parent_company_net_profit / (($equities[0] - $uncontrolled_shareolders_benefits[0]) + ($equities[1] - $uncontrolled_shareolders_benefits[1])), 2)
        ]);
    }

    /**
     * Calculate ROS
     *
     * @param  \App\FinancialStatement $financialStatement
     * @return array
     */
    protected function calculateROS($financialStatement)
    {
        $selectedYear = $financialStatement->year;
        $selectedQuarter = $financialStatement->quarter;
        $net_profit = $financialStatement->income_statement->getItem('19')->getValue($selectedYear, $selectedQuarter);
        $net_revenue = $financialStatement->income_statement->getItem('3')->getValue($selectedYear, $selectedQuarter);
        array_push($this->content, [
            'name' => 'ROS',
            'group' => 'Chỉ số sinh lời',
            'description' => 'Tỉ lệ lợi nhuận ròng trên doanh thu thuần (Return On Sales – ROS) là tỉ lệ thể hiện mối tương quan giữa lợi nhuận được tạo ra dựa trên mỗi đồng doanh số. Chỉ tiêu này cho biết với một đồng doanh thu thuần từ bán hàng và cung cấp dịch vụ sẽ tạo ra bao nhiêu đồng lợi nhuận. Tỷ suất này càng lớn thì hiệu quả hoạt động của doanh nghiệp càng cao. ROS = 100 * Lợi nhuận sau thuế/ Doanh thu thuần',
            'value' => round(100 * $net_profit / $net_revenue, 2)
        ]);
    }
}
