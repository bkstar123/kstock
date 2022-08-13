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
     * @var float
     */
    public $value;

    /**
     * Initialize StatementItem instance
     *
     * @param string $name,
     * @param string $group
     * @param string $unit
     * @param string $description
     * @param float $value
     */
    public function __construct($name, $group, $unit, $description, $value)
    {
        $this->name = $name;
        $this->group = $group;
        $this->unit = $unit;
        $this->description = $description;
        $this->value = $value;
    }
}
