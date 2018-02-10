<?php
/**
 * Created by PhpStorm.
 * User: senalw
 * Date: 2/5/2018
 * Time: 11:16 AM
 */

namespace Codeception\Extension;

use Codeception\Event\SuiteEvent;
use Codeception\Event\TestEvent;
use Codeception\Events;
use Codeception\Extension;
use Codeception\Test\Descriptor;


class TestListener extends Extension
{

    public function _initialize()
    {
        $this->options['silent'] = false; // turn on printing for this extension
        $this->_reconfigure(['settings' => ['silent' => true]]); // turn off printing for everything else
    }

    // we are listening for events
    public static $events = [
        Events::SUITE_BEFORE => 'beforeSuite',
        Events::TEST_BEFORE => 'beforeTest',
        Events::TEST_END => 'after',
        Events::TEST_SUCCESS => 'success',
        Events::TEST_FAIL => 'fail',
        Events::TEST_ERROR => 'error',
        Events::SUITE_AFTER => 'afterSuite',
    ];

    public function beforeSuite()
    {
        $this->writeln("");
    }

    public function beforeTest(TestEvent $e)
    {
        $this->writeln('[Started] ' . Descriptor::getTestSignature($e->getTest()) . ' Test');
    }

    public function success()
    {
        $this->write('[Success] ');
    }

    public function fail()
    {
        $this->write('[Failed] ');
    }

    public function error()
    {
        $this->write('[Error] ');
    }

    public function afterSuite(SuiteEvent $e)
    {
//        die("[Finished] Test Suite");
    }

    public function after(TestEvent $e)
    {
        $seconds_input = $e->getTime();
//      convert-microtime-to-hhmmssuu
        $seconds = (int)($milliseconds = (int)($seconds_input * 1000)) / 1000;
        $time = ($seconds % 60) . (($milliseconds === 0) ? '' : '.' . $milliseconds);
        $this->write(Descriptor::getTestSignature($e->getTest()));
        $this->writeln(' (' . $time . 's)');
    }

}