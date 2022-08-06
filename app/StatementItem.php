<?php
/**
 * StatementItem class
 *
 * @author: tuanha
 * @date: 03-Aug-2022
 */
namespace App;

class StatementItem
{
    public $id;

    public $name;

    public $parent_id;

    public $expanded;

    public $level;

    public $field;

    public $values;

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

    public function parent()
    {
        //
    }

    public function children()
    {
        //
    }

    public function ancestors()
    {
        //
    }

    public function descendants()
    {
        //
    }
}
