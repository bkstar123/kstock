<?php

namespace App;

use App\FinancialStatement;
use Illuminate\Database\Eloquent\Model;

class AnalysisReport extends Model
{
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
    
    /**
     * Returns the analysis report content items
     *
     * @return array
     */
    public function getItems()
    {
        return json_decode($this->attributes['content'], true);
    }
}
