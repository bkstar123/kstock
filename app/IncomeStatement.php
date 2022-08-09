<?php

namespace App;

use App\FinancialStatement;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Statements\StatementRepository;

class IncomeStatement extends Model
{
    use StatementRepository;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'financial_statement_id'
    ];

    /**
     * A balance statement belongs to a financial statement
     *
     * @return @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function financialStatement()
    {
        return $this->belongsTo(FinancialStatement::class);
    }
}
