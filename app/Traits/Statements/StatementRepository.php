<?php
/**
 * StatementRepository trait
 * 
 * Supposed to be used with Statement models
 * 
 * @author: tuanha
 * @date: 09-Aug-2022
 */
namespace App\Traits\Statements;

use App\StatementItem;

trait StatementRepository
{
    /**
     * Returns the statement content items
     *
     * @return \Illuminate\Support\Collection || null
     */
    public function getItems()
    {
        $items = collect(json_decode($this->attributes['content'], true));
        if (!empty($items)) {
            $items = $items->map(function ($item) {
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
        } else {
            return null;
        }
    }

    /**
     * Return the statement specific content item
     *
     * @return \App\StatementItem || null
     */
    public function getItem($itemID)
    {
        $items = collect(json_decode($this->attributes['content'], true));
        $item = array_first($items->filter(function ($item) use ($itemID) {
            return $item['id'] == $itemID;
        }));
        if (!empty($item)) {
            return new StatementItem(
                $item['id'],
                $item['name'],
                $item['parentID'],
                $item['expanded'],
                $item['level'],
                $item['field'],
                $item['values']
            );
        } else {
            return null;
        }
    }
}
