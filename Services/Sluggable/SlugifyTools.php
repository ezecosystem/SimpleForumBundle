<?php

namespace Jb\SimpleForumBundle\Services\Sluggable;

class SlugifyTools 
{
    public function slugify($string) 
    {
        // replace non letter or digits by -
        $string = preg_replace('~[^\\pL\d]+~u', '-', $string);

        // trim
        $string = trim($string, '-');

        // transliterate
        if (function_exists('iconv')) {
            $string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);
        }

        // lowercase
        $string = strtolower($string);

        // remove unwanted characters
        $string = preg_replace('~[^-\w]+~', '', $string);

        if (empty($string)) {
            return 'n-a';
        }

        return $string;
    }
}

?>
