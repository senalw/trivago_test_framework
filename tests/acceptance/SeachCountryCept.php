<?php

include_once("src/acceptance/pages/TrivagoHomePage.php");

$country = "Sri Lanka";

/**
 * Scenario : Go to trivago and search for country and validate the returned results
 */
$trivago_home_page = new pages\TrivagoHomePage($scenario);
$trivago_home_page->goto_Trivago_Home_Page();
$trivago_home_page->search_for($country); //type country name and click search button.
$trivago_home_page->verifySearchHotelLocation($country); //verify the returned result by the country name of it.
$trivago_home_page->makeScreenshot("SearchCountryCept");