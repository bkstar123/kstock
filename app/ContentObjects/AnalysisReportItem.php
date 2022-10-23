<?php
/**
 * AnalysisReportItem class
 *
 * Supposed to be used by AnalysisReportRepository
 *
 * @author: tuanha
 * @date: 03-Aug-2022
 */
namespace App\ContentObjects;

class AnalysisReportItem
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $alias;

    /**
     * @var string
     */
    public $group;

    /**
     * @var string
     */
    public $unit;

    /**
     * @var string
     */
    public $description;

    /**
     * @var array
     */
    public $values;

    /**
     * Initialize StatementItem instance
     *
     * @param string $name
     * @param string $alias
     * @param string $group
     * @param string $unit
     * @param string $description
     * @param array $values
     */
    public function __construct($name, $alias, $group, $unit, $description, $values)
    {
        $this->name = $name;
        $this->alias = $alias;
        $this->group = $group;
        $this->unit = $unit;
        $this->description = $description;
        $this->values = $values;
    }

    public function getValues()
    {
        return array_reverse(array_map(function($value) {
            return [
                $value['period'],
                $value['value']
            ];
        }, $this->values));
    }
}
