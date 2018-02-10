<?php
/**
 * Created by PhpStorm.
 * User: senalw
 * Date: 2/9/2018
 * Time: 11:57 PM
 */

namespace pages;


class OTA_Page extends \AcceptanceTester
{

    protected $logger;

    public function __construct($scenario)
    {
        parent::__construct($scenario);
        $this->logger = new \Codeception\Lib\Console\Output([]);
    }

    public function validateOTA($expected_OTA)
    {
//        $OTA_URL = $this->executeJS("return location.href");
//        $name_of_OTA = explode(".", explode("/", $OTA_URL)[2])[1];
        $expected_OTA = explode(".", $expected_OTA)[0];
//        if ($name_of_OTA == $expected_OTA) {
//            echo "OTA validation passed! " . "\n";
//        } else {
//            echo "OTA validation failed! " . "\n";
//        }
        $this->logger->writeln("See for ".$expected_OTA." to validate OTA name");
        $this->see("$expected_OTA");

    }
}