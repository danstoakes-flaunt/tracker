<?php

namespace App\Traits;

trait SlugGenerationTrait
{
    public static function slugify ($object, $key) 
    {
        $divider = "-";

        $text = $object["$key"];

        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            $text = 'default' . $divider . $key;
        }

        $counter = 0;
        $tmpText = $text;
        while (count($object::where('slug', $text)->get()) != 0) {
            $text = $tmpText;
            if ($counter > 0)
                $text .=  "-" . $counter;
            $counter++;
        }
        unset($tmpText);

        return $text;
    }
}