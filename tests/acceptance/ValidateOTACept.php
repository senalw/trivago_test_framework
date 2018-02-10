<?php

include_once("src/acceptance/pages/TrivagoHomePage.php");
include_once("src/acceptance/pages/OTA_Page.php");

$country = "Sri Lanka";

/**
 * Scenario : validate redirected OTA
 */
$I = new AcceptanceTester($scenario);
$trivago_home_page = new pages\TrivagoHomePage($scenario);
$OTA_page = new pages\OTA_Page($scenario);

$trivago_home_page->goto_Trivago_Home_Page();
$trivago_home_page->search_for($country); //type country name and click search button.
$expected_OTA = $trivago_home_page->goToOTA(3);
$OTA_page->validateOTA($expected_OTA);
$OTA_page->makeScreenshot("ValidateOTACept");
