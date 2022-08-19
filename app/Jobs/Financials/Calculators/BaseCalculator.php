<?php
/**
 * BaseCalculator
 *
 * @author: tuanha
 * @date: 18-Aug-2022
 */
namespace App\Jobs\Financials\Calculators;

class BaseCalculator
{
    /**
     * @var \App\Models\FinancialStatement
     */
    protected $financialStatement;

    /**
     * Create a new instance
     */
    public function __construct($financialStatement)
    {
        $this->financialStatement = $financialStatement;
    }

    /**
     * Execute all calculation methods
     */
    public function execute()
    {
        $methods = array_filter(get_class_methods($this), function ($method) {
            return str_starts_with($method, 'calculate');
        });
        foreach ($methods as $method) {
            call_user_func([$this, $method]);
        }
        return $this;
    }
}
