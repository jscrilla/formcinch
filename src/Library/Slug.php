<?php namespace Ngmedia\FormCinch\Library;

use Illuminate\Support\Facades\DB;

trait Slug {

    /**
     * @param $name
     * @param null $table
     * @param null $column
     * @return null|string|string[]
     */
    static function make($name, $table = null, $column = null)
    {
        $valid = false;
        $i = 0;
        while(!$valid) {
            if($i) {
                $slug = Self::make_slug($name . '-' . $i);
            } else {
                $slug = Self::make_slug($name);
            }

            // Check in the database
            if(!is_null($table) && !is_null($column)) {
                $dbslug = DB::table($table)->where($column, '=', $slug)->get();
                if(!count($dbslug)) {
                    return $slug;
                } else {
                    $i++;
                }
            } else {
                return $slug;
            }
        }
    }

    /**
     * @param $text
     * @return null|string|string[]
     */
    static function make_slug($text)
    {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text); // replace non letter or digits by -
        $text = trim($text, '-'); // trim
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text); // transliterate
        $text = strtolower($text); // lowercase
        $text = preg_replace('~[^-\w]+~', '', $text);  // remove unwanted characters
        $text = preg_replace('/-+/', '-', $text); // Remove duplicates
        if (empty($text)) return 'n-a';
        return $text;
    }
}