<?php

namespace GeniusDesign\CommonBundle\Functions;

/**
 * Methods for arrays (only static functions)
 */
class Arrays {

    /**
     * Returns array by given string
     * 
     * @param string $string
     * @param string $separator
     * @return string
     */
    public static function makeArrayFromString($string, $separator) {
        $result = array();

        if (!empty($string)) {
            $temp = explode($separator, $string);

            foreach ($temp as $item) {
                $result[] = trim($item);
            }
        }

        return $result;
    }

}