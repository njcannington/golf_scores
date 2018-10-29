<?php
namespace Lib\Db;

class Sql
{
    //sql helper methods

    // returns columns as string to be used in sql query for INSERT statements
    public static function columns($columns_array = [])
    {
        return implode(",", $columns_array);
    }

    // returns values as string to be used in sql query for INSERT statements
    public static function values($values_array = [])
    {
        $values = [];
        foreach ($values_array as $value) {
            $values[] = '"'.$value.'"';
        }
        return implode(",", $values);
    }

    //returns a string of "column = values" for each column to be used for SELECT statements
    public static function columnToValue($columns_array = [], $values_array = [])
    {
        $sql = [];
        for ($i = 0; $i < count($columns_array); $i++) {
            $sql[] = $columns_array[$i].' = "'.$values_array[$i].'"';
        }
        return implode(" AND ", $sql);
    }
}