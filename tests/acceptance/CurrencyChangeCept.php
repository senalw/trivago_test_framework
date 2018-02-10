<?php
include_once("src/acceptance/pages/TrivagoHomePage.php");

$country = "Sri Lanka";

/**
 * Scenario : Go to trivago and search for country and change the currency of it
 */
$trivago_home_page = new pages\TrivagoHomePage($scenario);
$trivago_home_page->goto_Trivago_Home_Page();
$trivago_home_page->search_for($country); //type country name and click search button.
$trivago_home_page->changeCurrency("CAD"); // expected currency's short code E.g. USD
$trivago_home_page->validate_currency_change("C$"); //symbol of the currency
$trivago_home_page->makeScreenshot("CurrencyChangeCept");