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
            // 1. ROAA
            $this->calculateROAA($financialStatement);
            $this->calculateROCE($financialStatement);
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
            'description' => 'Tỷ suất lợi nhuận trên tài sản bình quân. Chỉ số này cho biết tài sản của một doanh nghiệp đang được sử dụng tốt như thế nào để tạo ra lợi nhuận. ROAA được tính bằng Thu nhập ròng cùng kì với tài sản / Tổng tài sản trung bình. Với tổng tài sản trung bình được tính bằng (tài sản đầu kỳ + tài sản cuối kì)/2',
            'value' => round(100 * $financialStatement->income_statement->getItem(19)->getValue($selectedYear, $selectedQuarter) / $average_assets, 2)
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
            'description' => 'Tỷ suất lợi nhuận trên vốn sử dụng bình quân (Return on Capital Employed), đo lường khả năng sinh lời và hiệu quả sử dụng vốn của doanh nghiệp, nó cho biết mức độ sinh lời của doanh nghiệp ừ số vốn đầu tư ban đầu. ROCE = EBIT x 100% (Tổng tài sản bình quân - nợ ngắn hạn bình quân)',
            'value' => round(100 * $eBIT / ($average_assets - $average_short_liabilities), 2)
        ]);
    }
}
