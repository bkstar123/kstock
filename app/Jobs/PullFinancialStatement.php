<?php
/**
 * PullFinancialStatement Job
 *
 * @author: tuanha
 * @date: 28-July-2022
 */
namespace App\Jobs;

use Exception;
use App\Events\JobFailing;
use Illuminate\Bus\Queueable;
use App\Models\IncomeStatement;
use App\Models\BalanceStatement;
use App\Models\CashFlowStatement;
use App\Services\Contracts\Symbols;
use Illuminate\Queue\SerializesModels;
use App\Jobs\AnalyzeFinancialStatement;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Events\PullFinancialStatementCompleted;

class PullFinancialStatement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    public $symbol;
    
    /**
     * @var integer
     */
    public $year;
    
    /**
     * @var integer
     */
    public $quarter;
    
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
    public function __construct($data, $financialStatementID, $user)
    {
        $this->symbol = trim($data['symbol']);
        $this->year = trim($data['year']);
        $this->quarter = trim($data['quarter']);
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
        $symbols = resolve(Symbols::class);
        $balanceStatement = $symbols->getFullFinancialStatement($this->symbol, 1, $this->year, $this->quarter, 2);
        if (!empty($balanceStatement) && $balanceStatement != 'null' && $this->validateStatement($balanceStatement)) {
            BalanceStatement::create([
                'content' => $balanceStatement,
                'financial_statement_id' => $this->financialStatementID
            ]);
        }
        $incomeStatement = $symbols->getFullFinancialStatement($this->symbol, 2, $this->year, $this->quarter, 2);
        if (!empty($incomeStatement) && $incomeStatement != 'null' && $this->validateStatement($incomeStatement)) {
            IncomeStatement::create([
                'content' => $incomeStatement,
                'financial_statement_id' => $this->financialStatementID
            ]);
        }
        $cashFlowStatement = $symbols->getFullFinancialStatement($this->symbol, 3, $this->year, $this->quarter, 2);
        if (empty($cashFlowStatement) || $cashFlowStatement == 'null' || !$this->validateStatement($cashFlowStatement)) {
            $cashFlowStatement = $symbols->getFullFinancialStatement($this->symbol, 4, $this->year, $this->quarter, 2);
        }
        if (!empty($cashFlowStatement) && $cashFlowStatement != 'null' && $this->validateStatement($cashFlowStatement)) {
            CashFlowStatement::create([
                'content' => $cashFlowStatement,
                'financial_statement_id' => $this->financialStatementID
            ]);
        }
        AnalyzeFinancialStatement::dispatch($this->financialStatementID, $this->user); // Temporary dispatch here
        PullFinancialStatementCompleted::dispatch($this->user);
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        JobFailing::dispatch($this->user, $exception->getMessage());
    }
    
    /**
     * Validate whether or not the pulled contents are of the desired financial statement
     *
     * @param string $content
     * @return boolean
     */
    protected function validateStatement($content)
    {
        $firstItem = array_first(json_decode($content, true));
        $data = \Arr::where($firstItem['values'], function ($value) {
            return $value['year'] == $this->year && $value['quarter'] == $this->quarter;
        });
        return !empty($data);
    }
}
