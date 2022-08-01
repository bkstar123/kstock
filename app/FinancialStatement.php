<?php

namespace App;

use Bkstar123\BksCMS\AdminPanel\Admin;
use Illuminate\Database\Eloquent\Model;
use Bkstar123\MySqlSearch\Traits\MySqlSearch;

class FinancialStatement extends Model
{
    use MySqlSearch;

    /**
     * List of columns for search enabling
     *
     * @var array
     */
    public static $mysqlSearchable = ['symbol'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'symbol', 'admin_id', 'year', 'quarter'
    ];

    /**
     * A financial statement belongs to an admin
     *
     * @return @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Standardize the symbol attribute to upper case
     *
     * @param string
     */
    public function setSymbolAttribute($value)
    {
        $this->attributes['symbol'] = strtoupper($value);
    }
}
