<?php

namespace App;

use App\FinancialStatement;
use Illuminate\Database\Eloquent\Model;

class BalanceStatement extends Model
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
     * Render the statement content
     *
     * @return string
     */
    public function getItems()
    {
        $items = collect(json_decode($this->attributes['content'], true));
        $items = $items->map(function($item) {
            return new StatementItem($item['id'], $item['name'], $item['parentID'], $item['expanded'], $item['level'], $item['field'], $item['values']);
        });
        return $items;
    }
}
