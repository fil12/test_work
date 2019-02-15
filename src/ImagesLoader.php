<?php
/**
 * Created by PhpStorm.
 * User: dev-alexf
 * Date: 15.02.19
 * Time: 12:28
 */

namespace App;


use App\Exceptions\FileNotExistsException;
use App\Exceptions\FilePutContentException;
use App\Exceptions\NotSuportedFileFormatException;

/**
 * Class ImagesLoader
 * @package App
 */
class ImagesLoader
{
    /**
     * @var array of supported file formats
     */
    private $suppotedFormats;

    /**
     * @var string - url from downloading image
     */
    private $url;

    /**
     * @var string - path to directory where to save the file
     */
    private $targetDir;

    /**
     * ImagesLoader constructor.
     * @param string $url
     * @param string $targetDir
     * @param array $suppotedFormats
     */
    public function __construct(string $url, string $targetDir = 'uploads', array $suppotedFormats = ['jpg', 'png', 'gif'])
    {
        $this->url = $url;
        $this->targetDir = $targetDir;
        $this->suppotedFormats = $suppotedFormats;
    }

    /**
     * @return true if image was download and save
     */
    public function loadAndSave(): bool
    {
        // file info
        $path_parts = \pathinfo(\parse_url($this->url)['path']);

        // if this not a file, throw exception
        if (!$path_parts['extension']) {
            throw new FileNotExistsException('This`s not a file!');
        }

        // check for allowed file format
        if (\in_array($path_parts['extension'], $this->suppotedFormats)) {

            // if directory not exist, create
            if (!\file_exists($this->targetDir)) {
                \mkdir($this->targetDir, 0755, true);
            }

            //try download image
            try {
                $image = $this->downloadImage();
            } catch (\Exception $e) {
                echo $e->getMessage();
            }

            if (isset($image)) {
                //create full path to file
                $fullPath = $this->targetDir . DIRECTORY_SEPARATOR . $path_parts['basename'];

                //try save image
                try {
                    $pathToFile = $this->saveImage($fullPath, $image);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }

                //clean the memory
                unset($image);

                return $pathToFile;
            }

        } else {
            throw new NotSuportedFileFormatException(\sprintf('"%s" not supported file format!', $path_parts['extension']));
        }
    }

    /**
     * @return false|string
     */
    private function downloadImage(): ?string
    {
        //overriding error handler
        set_error_handler(
            function ($err_severity, $err_msg, $err_file, $err_line) {

                if (error_reporting() === 0) return false;

                throw new FileNotExistsException('File not found!');
            },
            E_WARNING
        );

        //downloadig file from url
        $content = file_get_contents($this->url);

        return $content;
    }


    /**
     * @param string $fullPath - path to save file
     * @param $image
     * @return string|null
     */
    private function saveImage(string $fullPath, $image): ?string
    {
        //overriding error handler
        set_error_handler(
            function ($err_severity, $err_msg, $err_file, $err_line) {

                if (error_reporting() === 0) return false;

                throw new FilePutContentException('Can`t create a file!');
            },
            E_WARNING
        );

        //saving file
        if (\file_put_contents($fullPath, $image)) {
            return $fullPath;
        }
        return false;
    }
}
