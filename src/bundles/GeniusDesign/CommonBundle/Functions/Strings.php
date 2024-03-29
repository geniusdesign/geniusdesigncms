<?php

namespace GeniusDesign\CommonBundle\Functions;

/**
 * Methods for strings (only static functions)
 */
class Strings {

    /**
     * Returns whether the latest sign is the same as given
     * 
     * @param string $string
     * @param string $sign
     * @return string
     */
    public static function isLastSignTheSameAsGiven($string, $sign) {
        $result = false;

        if (!empty($string)) {
            $lastSign = substr($string, -1);

            if ($lastSign == $sign) {
                $result = true;
            }
        }

        return $result;
    }

    /**
     * Returns information if string contains another string
     * 
     * @param string $string
     * @param string $findme
     * @return boolean 
     */
    public static function contains($string, $findme) {
        $result = true;
        $position = strpos($string, $findme);

        if ($position === false) {
            $result = false;
        }

        return $result;
    }

}