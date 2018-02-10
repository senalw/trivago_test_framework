<?php
/**
 * Created by PhpStorm.
 * User: senalw
 * Date: 2/8/2018
 * Time: 8:55 PM
 */

namespace tests\codeception\common\_support\Helper;

use Codeception\Exception\ModuleException;
use Codeception\Lib\ModuleContainer;

class AcceptanceHelper extends \Codeception\Module
{
    private $webDriver = null;
    private $webDriverModule = null;

    public function __construct(ModuleContainer $moduleContainer, $config = null)
    {
        $this->config = array_merge(
            array(
                'cleanup' => true,
                'bootstrap' => 'bootstrap' . DIRECTORY_SEPARATOR . 'app.php',
                'root' => '',
                'packages' => 'workbench',
            ),
            (array)$config
        );
        parent::__construct($moduleContainer);
    }

    /**
     * Executes before a test starts.
     * @param \Codeception\TestCase $test
     * @throws \Exception
     */
    public function _before(\Codeception\TestCase $test)
    {
        if (!$this->hasModule('WebDriver') && !$this->hasModule('Selenium2')) {
            throw new \Exception('PageWait uses the WebDriver. Please be sure that this module is activated.');
        }
        // Use WebDriver
        if ($this->hasModule('WebDriver')) {
            $this->webDriverModule = $this->getModule('WebDriver');
            $this->webDriver = $this->webDriverModule->webDriver;
        }
    }

    /**
     * @param int $timeout : timeout period
     * @throws ModuleException
     */
    public function waitAjaxLoad($timeout = 10)
    {
        $this->webDriverModule->waitForJS('return !!window.jQuery && window.jQuery.active == 0;', $timeout);
        $this->webDriverModule->wait(1);
        $this->dontSeeJsError();
    }

    /**
     * @param int $timeout : timeout period
     * @throws ModuleException
     */
    public function waitPageLoad($timeout = 10)
    {
        $this->webDriverModule->waitForJs('return document.readyState == "complete"', $timeout);
        $this->waitAjaxLoad($timeout);
        $this->dontSeeJsError();
    }


    /**
     * @param $link : Link that need to navigate
     * @param int $timeout : timeout
     * @throws ModuleException
     */
    public function amOnPage($link, $timeout = 10)
    {
        $this->webDriverModule->amOnPage($link);
        $this->waitPageLoad($timeout);
    }

    /**
     * @param $identifier
     * @param null $elementID
     * @param null $excludeElements
     * @param bool $element
     * @throws ModuleException
     */
    public function dontSeeVisualChanges($identifier, $elementID = null, $excludeElements = null, $element = false)
    {
        if ($element !== false) {
            $this->webDriverModule->moveMouseOver($element);
        }
        $this->getModule('VisualCeption')->dontSeeVisualChanges($identifier, $elementID, $excludeElements);
        $this->dontSeeJsError();
    }

    /**
     * @throws ModuleException : throws exceptions if an error detects in JS
     */
    public function dontSeeJsError()
    {
        $logs = $this->webDriver->manage()->getLog('browser');
        foreach ($logs as $log) {
            if ($log['level'] == 'SEVERE') {
                throw new ModuleException($this, 'Some error in JavaScript: ' . json_encode($log));
            }
        }
    }

    /**
     * Get current url from WebDriver
     * @return mixed
     * @throws \Codeception\Exception\ModuleException
     */
    public function getCurrentUrl()
    {
        return $this->getModule('WebDriver')->_getCurrentUri();
    }
}