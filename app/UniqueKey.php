<?php


namespace App;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UniqueKey
{
    public static function for(string $schema)
    {
        $table = Str::before($schema, ":");
        $column = Str::after($schema, ":");

        $key = Str::random(6);

        while(DB::table($table)->where($column, $key)->count($column) > 0) {
            $key = Str::random(6);
        }

        return $key;
    }
}
