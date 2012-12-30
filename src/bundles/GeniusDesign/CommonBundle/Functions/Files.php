<?php

namespace GeniusDesign\CommonBundle\Functions;

/**
 * Methods for files (only static functions)
 */
class Files {

    /**
     * Returns file name without extension
     *
     * @param string $fileName
     * @return string
     */
    public static function getFileNameWithoutExtension($fileName) {
        $effect = '';
        $matches = array();

        if (preg_match('|(.+)\.(.+)|', $fileName, $matches)) {
            $effect = $matches[1];
        }

        return $effect;
    }

    /**
     * Returns file extension
     *
     * @param string $fileName File name
     * @param boolean $asLowerCase if true extension is returned as lowercase string
     * @return string
     */
    public static function getFileExtension($fileName, $asLowerCase = false) {
        $effect = '';
        $matches = array();

        if (preg_match('|(.+)\.(.+)|', $fileName, $matches)) {
            $effect = end($matches);
        }

        if ($asLowerCase) {
            $effect = strtolower($effect);
        }

        return $effect;
    }
}