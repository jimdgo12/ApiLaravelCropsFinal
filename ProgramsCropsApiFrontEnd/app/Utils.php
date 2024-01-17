<?php
namespace App;

class Utils
{
    public static function isAssociativeArray($array)
    {
        return is_array($array) && count(array_filter(array_keys($array), 'is_string')) > 0;
    }
}
