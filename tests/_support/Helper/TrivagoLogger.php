<?php
/**
 * Created by PhpStorm.
 * User: senalw
 * Date: 2/9/2018
 * Time: 11:27 AM
 */

namespace Helper;


class TrivagoLogger extends \Codeception\Extension\Logger
{

    public function __construct($config, $options)
    {
        parent::__construct($config, $options);
    }
}