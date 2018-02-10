<?php
include_once("src/acceptance/pages/TrivagoHomePage.php");

$country = "Sri Lanka";
$page_number = 2;

/**
 * Scenario : Go to trivago, search for country and the go through pages
 */
$trivago_home_page = new pages\TrivagoHomePage($scenario);
$trivago_home_page->goto_Trivago_Home_Page();
$trivago_home_page->search_for($country); //type country name and click search button.
$trivago_home_page->go_through_pages($page_number); // go to the page
$trivago_home_page->validate_pagination($page_number); // validate the page
$trivago_home_page->scrollTo("//*[@id=\"js_item_list_section\"]/div[1]/div");// scroll down to the page numbers
$trivago_home_page->makeScreenshot("PaginationTestCept");

