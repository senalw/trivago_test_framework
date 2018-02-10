<?php
/**
 * Created by PhpStorm.
 * User: senalw
 * Date: 2/8/2018
 * Time: 11:34 PM
 */

namespace pages;

use PHPUnit\Framework\Assert;

class TrivagoLoginPage extends \AcceptanceTester
{

    protected $logger;

    public function __construct($scenario)
    {
        parent::__construct($scenario);
        $this->logger = new \Codeception\Lib\Console\Output([]);
    }

    public function typeUserCredentials($email, $password)
    {
        $this->wait(5);
        $this->fillField('//*[@id="emailLogin"]', $email);
        $this->fillField('//*[@id="login-pass"]', $password);
        $this->logger->writeln("Username and password are typed");
    }

    public function click_on_login_button()
    {
        $this->click('//*[@id="authentication-login"]/div/section[1]/div[1]/div/div[4]/button');
        $this->wait(5);
    }

    function validate_user_login()
    {
        $this->wait("4");
        //Error message should not come if the username & password are correct.
        // So here I wait for the error message element not to be visible.
        $this->dontSeeElement('//*[@id="authentication-login"]/div/section[1]/div[1]/div/div[2]');
//        $this->waitForElementNotVisible('//*[@id="authentication-login"]/div/section[1]/div[1]/div/div[2]', 4);
        $this->wait(3);
        $this->logger->writeln("Successfully logged in");
    }


}