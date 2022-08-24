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
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $parent_id;

    /**
     * @var bool
     */
    public $expanded;

    /**
     * @var integer
     */
    public $level;

    /**
     * @var string
     */
    public $field;

    /**
     * @var array
     */
    public $values;

    /**
     * Initialize StatementItem instance
     *
     * @param string $id,
     * @param string $name
     * @param string $parentID
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
        $res = array_first(\Arr::where(
            $this->values,
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
        return array_pluck($this->values, 'value');
    }

    /**
     * Get the average value of a statement content item for the given period
     *
     * @param integer $year
     * @param integer $quarter
     * @return float
     */
    public function getAverageValue($year, $quarter)
    {
        $currentValue = $this->getValue($year, $quarter);
        $previousPeriod = getPreviousPeriod($year, $quarter);
        if ($this->checkDataForPeriodExisted($previousPeriod['year'], $previousPeriod['quarter'])) {
            $lastValue = $this->getValue($previousPeriod['year'], $previousPeriod['quarter']);
            return ($currentValue + $lastValue) / 2;
        } else {
            return $currentValue;
        }
    }

    /**
     * Check whether the data for the concern period existed or not
     *
     * @param integer $year
     * @param integer $quarter
     * @return boolean
     */
    private function checkDataForPeriodExisted($year, $quarter)
    {
        $concernPeriodData = \Arr::where(
            $this->values,
            function ($value) use ($year, $quarter) {
                return $value['year'] == $year && $value['quarter'] == $quarter;
            }
        );
        return !empty($concernPeriodData);
    }
}
