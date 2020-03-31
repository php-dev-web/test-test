<?php

namespace App\Filters;

use Illuminate\Support\Facades\DB;

class TasksFilter extends AbstractFilter
{
	public function orderBy($value)
	{
		if (strstr($value, '-')) {
            $param = "DESC";
        } else {
            $param = "ASC";
        }

		$value = str_replace("-", "", $value);

		$this->builder->orderBy($value, $param);
	}
}