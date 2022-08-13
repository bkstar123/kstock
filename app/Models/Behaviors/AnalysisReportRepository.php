<?php
/**
 * StatementRepository trait
 *
 * Supposed to be used with Statement models
 *
 * @author: tuanha
 * @date: 09-Aug-2022
 */
namespace App\Models\Behaviors;

use App\ContentObjects\AnalysisReportItem;

trait AnalysisReportRepository
{
    /**
     * Returns all items of the report content
     *
     * @return \Illuminate\Support\Collection || null
     */
    public function getItems()
    {
        $items = collect(json_decode($this->attributes['content'], true));
        if (!empty($items)) {
            $items = $items->map(function ($item) {
                return new AnalysisReportItem(
                    $item['name'],
                    $item['group'],
                    $item['unit'],
                    $item['description'],
                    $item['value']
                );
            });
            return $items;
        } else {
            return null;
        }
    }

    /**
     * Return the report specific content item
     *
     * @return App\ContentObjects\AnalysisReportItem || null
     */
    public function getItem($itemName)
    {
        $items = collect(json_decode($this->attributes['content'], true));
        $item = array_first($items->filter(function ($item) use ($itemName) {
            return $item['name'] == $itemName;
        }));
        if (!empty($item)) {
            return new AnalysisReportItem(
                $item['name'],
                $item['group'],
                $item['unit'],
                $item['description'],
                $item['value']
            );
        } else {
            return null;
        }
    }
}
