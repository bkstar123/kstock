<?php

namespace App\Traits\Statements;

use App\StatementItem;

trait StatementIterator
{
	/**
     * Render the statement content
     *
     * @return \Illuminate\Support\Collection
     */
    public function getItems()
    {
        $items = collect(json_decode($this->attributes['content'], true));
        $items = $items->map(function($item) {
            return new StatementItem(
            	$item['id'], 
            	str_pad($item['name'], strlen($item['name']) + ($item['level'] - 1) * 2, '-', STR_PAD_LEFT), 
            	$item['parentID'], 
            	$item['expanded'], 
            	$item['level'], 
            	$item['field'], 
            	$item['values']
            );
        });
        return $items;
    }
}