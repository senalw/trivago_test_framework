<?php
include_once("src/acceptance/pages/TrivagoHomePage.php");
include_once("src/acceptance/pages/TrivagoLoginPage.php");

//change as the user preference
///////////////////////////////////
$email = "senaldulanjala@yahoo.com";
$password = "1234";
///////////////////////////////////

/**
 * Scenario : Go to trivago and user login to the system
 */
$trivago_home_page = new pages\TrivagoHomePage($scenario);
$trivago_login_page = new pages\TrivagoLoginPage($scenario);

$trivago_home_page->goto_Trivago_Home_Page();
$trivago_home_page->click_on_MyProfile();
$trivago_home_page->go_to_login_page();
$trivago_login_page->typeUserCredentials($email, $password);
$trivago_login_page->click_on_login_button();
$trivago_login_page->validate_user_login();
$trivago_home_page->makeScreenshot("UserLoginCept");

