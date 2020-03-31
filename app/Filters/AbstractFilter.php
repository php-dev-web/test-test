<?php

namespace App\Filters;

class AbstractFilter
{
    protected $request;
    protected $builder;

    public function __construct($builder, $request)
    {
        $this->builder = $builder;
        $this->request = $request;
    }

    public function apply()
    {
        foreach ($this->filters() as $filter => $value) {
            if ($value) {
                if (is_array($value)) {
                    if (count(array_filter($value)) != 0) {
                        if (method_exists($this, $filter)) {
                            $this->$filter($value);
                        }
                    }
                } else {
                    if (method_exists($this, $filter)) {
                        $this->$filter($value);
                    }
                }

            }
        }

        return $this->builder;
    }

    public function filters()
    {
        return $this->request->all();
    }
}