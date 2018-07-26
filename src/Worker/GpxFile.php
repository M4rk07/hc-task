<?php
/**
 * Created by PhpStorm.
 * User: M4rk0
 * Date: 7/25/2018
 * Time: 9:55 PM
 */

namespace App\Worker;

use App\Entity\Point;
use App\Entity\Track;
use App\Entity\TrackWaypoint;
use Doctrine\Common\Persistence\ObjectManager;
use phpGPX\phpGPX;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Validator\Constraints as Assert;

class GpxFile
{
    private $file;

    function __construct($file)
    {
        $this->file = $file;
    }

    function checkFile() {
        $gpx = new phpGPX();
        $gpx->load($this->file->getRealPath());

    }


}