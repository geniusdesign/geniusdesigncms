<?php

namespace GeniusDesign\CommonBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface;
use GeniusDesign\CommonBundle\Functions\Files;
use GeniusDesign\CommonBundle\Functions\Strings;
use GeniusDesign\CommonBundle\Functions\Arrays;

/**
 * Helper for the uploaded files
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class UploadHelper {

    /**
     * The container
     * @var ContainerInterface
     */
    private $container = null;

    /**
     * Class constructor
     * 
     * @param ContainerInterface $container The container
     * @return void
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    /**
     * Returns container
     * @return ContainerInterface
     */
    public function getContainer() {
        return $this->container;
    }

    /**
     * Returns unique name for an uploaded file / image
     * 
     * @param string $originalFileName Original name of the file
     * @param [integer $entityId = 0] Entity ID, the ID of database's row
     * @return string
     */
    public function getUniqueFileName($originalFileName, $entityId = 0) {
        $name = '';

        $withoutExtension = Files::getFileNameWithoutExtension($originalFileName);
        $extension = Files::getFileExtension($originalFileName, true);

        $unique = uniqid();
        $template = '%s-%s';

        if ($entityId > 0) {
            $template .= '-%s';
        }

        $template .= '.%s';

        if ($entityId > 0) {
            $name = sprintf($template, $withoutExtension, $unique, $entityId, $extension);
        } else {
            $name = sprintf($template, $withoutExtension, $unique, $extension);
        }

        return $name;
    }

    /**
     * Prepare upload settings and uploads given file
     * If it's an image, generates thumbnails also
     * 
     * @return void
     */
    public function upload($entityConfigName, $uploadedFile, $fileName, $itsImage = false) {
        $pathBase = $this->getPathBase($entityConfigName, false);

        if ($itsImage) {
            $sizes = $this->getThumbnailsSizes($entityConfigName, '', true);
            $imageRealPath = $uploadedFile->getRealPath();

            if (!empty($sizes)) {
                $imagine = null;
                $image = null;

                try {
                    $imagine = new \Imagine\Gd\Imagine();
                    $image = $imagine->open($imageRealPath);

                    $originalSize = $image->getSize();
                    $originalWidth = $originalSize->getWidth();
                    $originalHeight = $originalSize->getHeight();
                } catch (RuntimeException $exception) {
                    
                }

                if ($originalWidth === 0 || $originalHeight === 0) {
                    list($originalWidth, $originalHeight) = getimagesize($imageRealPath);
                }

                foreach ($sizes as $size) {
                    if (is_array($size) && count($size) == 2) {
                        $width = $size[0];
                        $height = $size[1];

                        $thumbnailPath = $this->getPath($fileName, $width, $height);
                        $thumbnailDirectoryPath = $this->getDirectoryPath($width, $height);

                        if (!file_exists($pathBase . $thumbnailDirectoryPath)) {
                            mkdir($pathBase . $thumbnailDirectoryPath, 0777, true);
                        }

                        $thumbnailFullPath = $pathBase . $thumbnailPath;

                        if ($originalHeight > $height || $originalWidth > $width) {
                            if ($image !== null) {

                                $imageDimension = $this->prepareImageDimension($originalWidth, $originalHeight, $width, $height);
                                $thumbnail = $image->thumbnail(new \Imagine\Image\Box($imageDimension[0], $imageDimension[1]));
                                $thumbnail->save($thumbnailFullPath);
                                unset($thumbnail);
                            }
                        } else {
                            if ($image === null) {
                                copy($imageRealPath, $thumbnailFullPath);
                            } else {
                                $image->save($thumbnailFullPath);
                            }
                        }
                    }
                }

                unset($imagine);
                unset($image);
            }
        } else {
            $directoryPath = $this->getDirectoryPath();
            $uploadedFile->move($pathBase . $directoryPath, $fileName);
        }
    }

    /**
     * Returns image dimension
     *
     * @param integer $originalWidth
     * @param integer $originalHeight
     * @param integer $intentionalWidth
     * @param integer $intentionalHeight
     * @return array 
     */
    public function prepareImageDimension($originalWidth, $originalHeight, $intentionalWidth, $intentionalHeight) {
        $ratio = 1;

        if ($originalWidth > 0 && $originalHeight > 0) {
            if ($originalWidth > $intentionalWidth && $originalHeight < $intentionalHeight) {
                $ratio = $intentionalWidth / $originalWidth;
            } elseif ($originalWidth < $intentionalWidth && $originalHeight > $intentionalHeight) {
                $ratio = $intentionalHeight / $originalHeight;
            } elseif ($originalWidth > $intentionalWidth && $originalHeight > $intentionalHeight) {
                $ratio = $intentionalWidth / $originalWidth;

                if ($originalHeight * $ratio > $intentionalHeight) {
                    $ratio = $intentionalHeight / $originalHeight;
                }
            }
        }

        $newWidth = (int) ceil($originalWidth * $ratio);
        $newHeight = (int) ceil($originalHeight * $ratio);

        return array($newWidth, $newHeight);
    }

    /**
     * Deletes files
     * Removes also directories if are empty.
     * 
     * @param string $entityConfigName
     * @param string $fileName The file name to delete
     * @param [boolean $deleteOriginal = false] If is set to true, original file will be deleted too. Otherwise - not.
     * @param [boolean $moveInsteadRemove = true] If is set to true, file will be moved in another place instead of removing. Otherwise - file will be permanently removed.
     * @return boolean 
     */
    public function removeFile($entityConfigName, $fileName, $itsImage = false, $moveInsteadRemove = false) {
        $removed = false;

        $pathBase = $this->getPathBase($entityConfigName, false);
        $pathBaseDeletedFiles = $this->getPathToDeletedFiles();

        $kernel = $this->getContainer()->get('kernel');
        $publicDirPathBase = $kernel->getRootDir() . '/../web/';
        $moduleShortDirectory = str_replace($publicDirPathBase, '', $pathBase);
        $thumbnailDirectoryPath = $this->getDirectoryPath();

        /*
         * Create new directory if not exists
         */
        if ($moveInsteadRemove) {
            if (!file_exists($pathBaseDeletedFiles)) {
                throw new DirectoryDeletedFilesNotExistsException($pathBaseDeletedFiles);
            }

            if (!file_exists($pathBaseDeletedFiles . $moduleShortDirectory . $thumbnailDirectoryPath)) {
                mkdir($pathBaseDeletedFiles . $moduleShortDirectory . $thumbnailDirectoryPath, 0777, true);
            }
        }

        if ($itsImage) {
            $sizes = $this->getThumbnailsSizes($entityConfigName, '', true);

            if (!empty($sizes)) {
                foreach ($sizes as $size) {
                    if (is_array($size) && count($size) == 2) {
                        $width = (int) $size[0];
                        $height = (int) $size[1];

                        $thumbnailPath = $this->getPath($fileName, $width, $height);
                        $file = $pathBase . $thumbnailPath;

                        /*
                         * Creating new directory if not exists
                         */
                        if ($moveInsteadRemove && file_exists($file)) {
                            $direcotryPathWithSize = $this->getDirectoryPath($fileName, $width, $height);

                            if (!file_exists($pathBaseDeletedFiles . $moduleShortDirectory . $direcotryPathWithSize)) {
                                mkdir($pathBaseDeletedFiles . $moduleShortDirectory . $direcotryPathWithSize, 0777, true);
                            }
                        }

                        /*
                         * Removing the file
                         */
                        if (file_exists($file)) {
                            if ($moveInsteadRemove) {
                                $removed = rename($file, $pathBaseDeletedFiles . $moduleShortDirectory . $thumbnailPath);
                            } else {
                                $removed = unlink($file);
                            }
                        }

                        if (!$removed) {
                            break;
                        }

                        /*
                         * Removing directory that contains removed file.
                         * It's directory with size as name, e.g. "200x120".
                         */
                        $directoryPath = $this->getDirectoryPath($fileName, $width, $height);
                        $directoryContent = array(1); //Miscellaneous::getDirectoryContent($pathBase . $directoryPath, true);

                        if (empty($directoryContent)) {
                            rmdir($pathBase . $directoryPath);
                        }
                    }
                }
            }
        }

        return $removed;
    }

    /**
     * Returns the base of path
     * @return string
     */
    public function getPathBase($entityConfigName, $relative = true) {
        $path = '';

        if (!empty($entityConfigName)) {
            $subName = 'paths.';

            if ($relative) {
                $subName .= 'relative';
            } else {
                $subName .= 'absolute';
            }

            $path = $this->getContainerParameterValue($entityConfigName, $subName);

            if (!empty($path) && !Strings::isLastSignTheSameAsGiven($path, '/')) {
                $path .= '/';
            }
        }

        return $path;
    }

    /**
     * Returns the thumbnail sizes
     * @return string
     */
    public function getThumbnailsSizes($entityConfigName, $sizeName = '', $asIntegers = false) {
        $temp = $sizes = array();

        if (!empty($entityConfigName)) {
            $subName = 'sizes';

            if (!empty($sizeName)) {
                $subName = sprintf('size.%s', $sizeName);
            }

            $temp = $this->getContainerParameterValue($entityConfigName, $subName);
        }

        if (!empty($sizeName)) {
            return ($asIntegers) ? Arrays::makeArrayFromString($temp, 'x') : str_replace(' ', '', $temp);
        } else {
            if (!empty($temp)) {
                foreach ($temp as $item) {
                    $sizes[] = ($asIntegers) ? Arrays::makeArrayFromString($item, 'x') : str_replace(' ', '', $item);
                }
            }
        }

        return $sizes;
    }

    /**
     * Returns value of the container's parameter
     * 
     * @param string
     * @param string $subName This is the appropriate parameter which is needed. It's a part of long name of parameter.
     * @return mixed
     */
    private function getContainerParameterValue($entityConfigName, $subName) {
        $value = null;
        $name = $this->getContainerParameterName($entityConfigName, $subName);

        if (!empty($name)) {
            try {
                $value = $this->getContainer()
                        ->getParameter($name);
            } catch (\InvalidArgumentException $exception) {
                
            }
        }

        return $value;
    }

    /**
     * Returns proper name of the container's parameter.
     * Looks for parameter without or with name of entity's class.
     * 
     * @param string 
     * @param string $subName This is the appropriate parameter which is needed. It's a part of long name of parameter
     * @return string
     */
    private function getContainerParameterName($entityConfigName, $subName) {
        $template = '%s.upload.%s';
        return sprintf($template, $entityConfigName, $subName);
    }

    /**
     * Returns path for the given file
     * 
     * @param string $fileName Name of the file
     * @param [integer $width = 0] Width of the image
     * @param [integer $height = 0] Height of the image
     * @return string
     */
    public function getPath($fileName, $width = 0, $height = 0) {
        return $this->getDirectoryPath($width, $height) . $fileName;
    }

    /**
     * Returns path for the directory of given file and another parameters e.g. path prefix length
     * 
     * @param string $fileName Name of the image / file
     * @param [integer $width = 0] Width of the image
     * @param [integer $height = 0] Height of the image
     * @return string
     */
    public function getDirectoryPath($width = 0, $height = 0) {
        $path = '';

        if ($width > 0 && $height > 0) {
            $path .= sprintf('%dx%d%s', $width, $height, '/');
        }

        return $path;
    }

    /**
     * Returns path for the deleted / moved files
     * @return string
     */
    public function getPathToDeletedFiles() {
        return $this->getContainer()->getParameter('genius_design_common.deleted_files_path');
    }

    /**
     *
     * @param type $entityConfigName
     * @param type $fileName
     * @param type $size
     * @param type $withPathBase
     * @param type $insertNoPicture
     * @return type 
     */
    public function getFilePath($entityConfigName, $fileName, $size, $withPathBase = true, $relative = false, $insertNoPicture = false, $noPictureSize = 'small') {
        $pathBase = '';

        $width = 0;
        $height = 0;

        if ($withPathBase) {
            $pathBase = $this->getPathBase($entityConfigName, $relative);
        }

        if (is_string($size)) {
            $size = $this->getThumbnailsSizes($entityConfigName, $size, true);
        }

        if (is_array($size)) {
            if (count($size) == 2) {
                $width = $size[0];
                $height = $size[1];
            }
        }

        $filePath = $this->getPath($fileName, $width, $height);
        $fullFilePath = $pathBase . $filePath;

        if ($insertNoPicture) {
            $checkPath = $this->getPathBase($entityConfigName, false) . $filePath;
            $fileExists = file_exists($checkPath);

            if (!$fileExists) {
                return $this->getNoPicturePath($noPictureSize);
            }
        }

        return $fullFilePath;
    }

    /**
     * Returns no picture path
     * 
     * @param string $noPictureSize
     * @return string 
     */
    public function getNoPicturePath($noPictureSize) {
        $noPicturePath = '';

        if (!empty($noPictureSize)) {
            $commonHelper = $this->getContainer()->get('genius_design_common.helper');
            $sizes = $commonHelper->getNoPictureSizes();
            $template = $commonHelper->getNoPictureTemplatePath();

            if (in_array($noPictureSize, $sizes) && !empty($template)) {
                $noPicturePath = sprintf($template, $noPictureSize);
            }
        }

        return $noPicturePath;
    }

}
