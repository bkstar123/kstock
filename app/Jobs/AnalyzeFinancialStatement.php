<?php

namespace App\Jobs;

use App\AnalysisReport;
use App\FinancialStatement;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
        if (!empty($financialStatement->balance_statement) && !empty($financialStatement->income_statement)) {
            $content = [];
            // 1. ROAA
            $average_assets = array_sum(array_pluck($financialStatement->balance_statement->getItem('2')->values,'value'))/2;
            array_push($content, [
                'name' => 'ROAA',
                'group' => 'Hiệu quả hoạt động',
                'description' => 'Tỷ suất lợi nhuận trên tài sản bình quân. Chỉ số này cho biết tài sản của một doanh nghiệp đang được sử dụng tốt như thế nào để tạo ra lợi nhuận. ROAA được tính bằng Thu nhập ròng cùng kì với tài sản / Tổng tài sản trung bình. Với tổng tài sản trung bình được tính bằng (tài sản đầu kỳ + tài sản cuối kì)/2.',
                'value' => round(100 * $financialStatement->income_statement->getItem(19)->getValue($financialStatement->year, $financialStatement->quarter) / $average_assets, 2)
            ]);
            AnalysisReport::create([
                'content' => json_encode($content),
                'financial_statement_id' => $this->financialStatementID
            ]);
        }
    }
}
