<?php

namespace GeniusDesign\CommonBundle\Exception;

/**
 * An exception used while directory for deleted files not exists
 */
class DirectoryDeletedFilesNotExistsException extends \Exception {

    /**
     * Class constructor
     * 
     * @param [string $directoryPath = ''] The directory path
     * @return void
     */
    public function __construct($directoryPath = '') {
        $message = sprintf('Directory %s for deleted files not exists!', $directoryPath);
        parent::__construct($message);
    }

}