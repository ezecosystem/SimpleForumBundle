<?php

/*
 * This file is part of the SimpleForumBundle
 *
 * (c) Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jb\SimpleForumBundle\Services\Sluggable;

/**
 * SlugifyTools is a service which provide slugify tools
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class SlugifyTools 
{
    /**
     * Slugify a string
     * 
     * @param type $string the string to slugify
     * @return string
     */
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
