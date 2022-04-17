<?php

namespace App\Helpers;

use Carbon\Carbon;

class Generators
{
    public static function generateRegisteredNumber()
    {
        return Carbon::now()->format('ymdHis');
    }

    public static function getDynamicValidator($attributes)
    {
        $rules = [];

        if (!empty($attributes)) {
            foreach ($attributes as $attr) {
                $codeRules = [];

                if ($attr->is_required) {
                    array_push($codeRules, 'required');
                }

                if ($attr->type == 'text') {
                    if ($attr->max_length > 0) {
                        array_push($codeRules, 'min:' . $attr->minLength);
                        array_push($codeRules, 'max:' . $attr->maxLength);
                    }
                } else if ($attr->type == 'number') {
                    array_push($codeRules, 'numeric');
                    if ($attr->max_length > 0) {
                        array_push($codeRules, 'digits_between:' . $attr->min_length . ',' . $attr->max_length);
                    }

                    if ($attr->max_value > 0) {
                        array_push($codeRules, 'min:' . $attr->min_value);
                        array_push($codeRules, 'max:' . $attr->max_value);
                    }
                } else if ($attr->type == 'date') {
                    array_push($codeRules, 'date_format:d-m-Y');
                } else if ($attr->type == 'datetime') {
                    array_push($codeRules, 'date_format:d-m-Y H:i:s');
                }

                if ($attr->employee_attribute_category->is_multiple) {
                    $rules[$attr->employee_attribute_category->category_code . ".*." . $attr->code] = $codeRules;
                } else {
                    $rules[$attr->code] = $codeRules;
                }
            }

            return $rules;
        }

        return $rules;
    }
}
