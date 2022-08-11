<?php
/**
 * StatementItem class
 *
 * Supposed to be used by StatementRepository
 *
 * @author: tuanha
 * @date: 03-Aug-2022
 */
namespace App\ContentObjects;

class StatementItem
{
    public $id;

    public $name;

    public $parent_id;

    public $expanded;

    public $level;

    public $field;

    public $values;

    /**
     * Initialize StatementItem instance
     *
     * @param integer $id,
     * @param string $name
     * @param integer $parentID
     * @param bool $expanded
     * @param integer $level
     * @param string $field
     * @param array $values
     */
    public function __construct($id, $name, $parent_id, $expanded, $level, $field, $values)
    {
        $this->id = $id;
        $this->name = $name;
        $this->parent_id = $parent_id;
        $this->expanded = $expanded;
        $this->level= $level;
        $this->field = $field;
        $this->values = $values;
    }

    /**
     * Get the value of a statement content item by year and quarter
     * 
     * @param integer $year
     * @param integer $quarter
     * @return float
     */
    public function getValue($year, $quarter)
    {
        $res = array_first(\Arr::where($this->values, 
            function ($value) use ($year, $quarter) {
                return $value['year'] == $year && $value['quarter'] == $quarter;
            }
        ));
        return (float) ($res['value'] ?? '');
    }

    /**
     * Get all values of a statement content item
     *
     * @return array
     */
    public function getValues()
    {
        return array_pluck($this->values,'value');
    }
}
