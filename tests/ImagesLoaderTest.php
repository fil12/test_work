<?php
/**
 * Created by PhpStorm.
 * User: dev-alexf
 * Date: 15.02.19
 * Time: 16:19
 */

namespace App\Test;


use App\ImagesLoader;
use PHPUnit\Framework\TestCase;

final class ImagesLoaderTest extends TestCase
{
    private $urls = [
        'http://bm.img.com.ua/nxs/img/prikol/images/large/0/0/307600.jpg',
        'http://pngimg.com/uploads/mario/mario_PNG55.png',
        'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2c/Rotating_earth_%28large%29.gif/267px-Rotating_earth_%28large%29.gif'
    ];

    public function testLoadAndSave()
    {
        foreach ($this->urls as $url) {

            $path_parts = \pathinfo(\parse_url($url)['path']);

            $image = new ImagesLoader($url, 'uploads', ['jpg', 'png', 'gif']);

            $image->loadAndSave();

            self::assertFileExists('uploads/' . $path_parts['basename']);
        }
    }


}