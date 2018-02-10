<?php
/**
 * Created by PhpStorm.
 * User: senalw
 * Date: 2/8/2018
 * Time: 7:01 PM
 */

namespace pages;

use PHPUnit\Framework\Assert;

class TrivagoHomePage extends \AcceptanceTester
{

    protected $logger;

    /**
     * Executes before a test starts.
     */
    public function __construct($scenario)
    {
        parent::__construct($scenario);
        $this->logger = new \Codeception\Lib\Console\Output([]);
    }


    /**
     * <@see <a href="https://www.trivago.com/">Trivago Home Page</a>>
     * Here "trivago" has been used to make sure that  the loaded page is trivago home page
     */
    public function goto_Trivago_Home_Page()
    {
        $URL = '/';
        $this->amOnPage($URL);
        $this->see("trivago"); //trivago text can be found in home page
    }


    public function search_for($search_for)
    {
        $xPath_of_text_filed = "//*[@id='horus-querytext']";
        $this->fillField($xPath_of_text_filed, "$search_for");
        $this->waitForElement('//*[@id="ssg-suggestions"]', 20);

        // to select the exact text from suggestions and select it
        $suggestions = $this->grabMultiple("//*[@id='ssg-suggestions']/li/div/span[1]");
        $childPos = 1;
        $is_found = false;
        foreach ($suggestions as $country) {
            if (trim($country) == $search_for) {
                $this->click("//*[@id='ssg-suggestions']/li[" . $childPos . "]");
                $is_found = true;
                break;
            }
            $childPos++;
        }
        Assert::assertEquals($is_found, true, "Unable to find best match from suggestions [" . $search_for . "]");
        $this->logger->writeln("found best match from suggestions [" . $search_for . "]");
        $this->wait(5);
        $this->waitForElement('//*[@id="js_item_list_section"]', 30);
    }

    /**
     * @param $search_country : search country
     * @throws \Exception : If the search results contain wrong country the exception will be thrown
     */
    public function verifySearchHotelLocation($search_country)
    {
        $hotel_loc = $this->grabMultiple('//*[@id="js_itemlist"]/li//div[1]/div[3]/div/div[2]');
        foreach ($hotel_loc as $loc) {
            $country = explode(",", $loc);
            Assert::assertEquals($search_country, trim($country[2]),
                "Search result returns wrong country[" . $loc . "]");
        }
    }


    /**
     * @param $list_item_number : List item number that you need to click on "ViewDeal" Button
     *                            E.g. If you need to click "View Deal" button on second hotel in trivago home page you
     *                                 need to pass 2.
     * @return mixed            : OTA name that would return if the "View Deal "
     * @throws \Exception
     * @throws \_generated\ModuleException
     */
    public function goToOTA($list_item_number)
    {
        $this->waitForElement('//*[@id="js_item_list_section"]', 20); //wait until load the hotels
        $xpath = '//*[@id="js_itemlist"]/li[' . $list_item_number . ']/article/div[1]/div[3]/section[2]';
        $OTA_name = $this->grabTextFrom('//*[@id="js_itemlist"]/li[' . $list_item_number . ']
        /article/div[1]/div[3]/section[2]/div/div/div/em');
        $this->click($xpath); //click on "View Deal" button
        $this->wait(10);
        $this->switchToNextTab(1);
        $this->waitForJS('return !!window.jQuery && window.jQuery.active == 0;', 30);
        $this->logger->writeln("Go to OTA [" . $OTA_name . "] successfully");
        return $OTA_name;
    }


    /**
     * @uses  to change the currency as the user preference
     * @param $expected_currency_code : E.g. USD
     * @throws \Exception
     */
    public function changeCurrency($expected_currency_code)
    {
        $this->waitForElement('//*[@id="select-currency"]');
        $available_currencies = $this->grabMultiple('//*[@id="select-currency"]/optgroup[2]/option');

        $is_found = false;
        foreach ($available_currencies as $currency) {
            //get the short code of currency : E.g USD
            $currency_short_code = str_split(preg_replace('/[ ]{2,}/', '',
                str_replace("\n", "", $currency)), 3)[0];

            if ($expected_currency_code == $currency_short_code) {
                $this->selectOption("//*[@id=\"select-currency\"]", $currency);
                $this->logger->writeln("Selected the currency to [" . $expected_currency_code . "]");
                $is_found = true;
                break;
            }
        }
        if ($is_found) {
            $this->waitForElement('//*[@id="js_item_list_section"]', 30);
            $this->logger->writeln("Currency has been changed to [" . $expected_currency_code . "]");
        } else {
            Assert::assertEquals($expected_currency_code, $currency_short_code,
                "Unable to find currency code like [" . $expected_currency_code . "]");
        }
        $this->wait(2);
    }


    /**
     * @param $expected_currency_symbol : E.g. C$, $
     */
    public function validate_currency_change($expected_currency_symbol)
    {
        $this->wait(2);
        $currencies = $this->grabMultiple('//*[@id="js_itemlist"]/li//div[1]/div[3]/section[2]/div/div[1]/div/strong');
        foreach ($currencies as $currency_symbol) {
//            $currency_symbol = preg_replace('/[0-9]+/', '', $currency_symbol);
            $currency_symbol = preg_replace('/[;\\/:,*?\"<>|&\'0-9+]/', '', $currency_symbol);
            Assert::assertEquals($expected_currency_symbol, $currency_symbol,
                "Currency change has not been applied [expected : " .
                $expected_currency_symbol . "] [found : " . $currency_symbol . "]");
        }
        $this->logger->writeln("Currency change has been successfully applied!");
        $this->wait(2);
    }

    public function click_on_MyProfile()
    {
        $this->click('//*[@id="js_navigation"]/div/div[3]/button');
        $this->logger->writeln("Click on MyProfile");
        $this->wait(5);
    }

    public function go_to_login_page()
    {
        $this->click('Log in');
        $this->logger->writeln("Click logging button");
        $this->wait(2);
    }

    public function changePriceFilter($price)
    {
        //*[@id="js_filterlist"]/div/div[2]/section[1]/div/div/div[1]/div[2]
        $this->click('//*[@id="js_filterlist"]/div/div[2]/section[1]/div/div/div[1]/div[3]');
        $this->wait(2);
        $this->fillField('//*[@id="max-price"]', $price);
        $this->click("//*[@id=\"js_filterlist\"]/div/div[2]/section[1]");
        $this->wait(10);
    }

    /**
     * @param $page_number : Page number that should go to.
     * @throws \Exception
     */
    public function go_through_pages($page_number)
    {
        $un_selected_pages = $this->grabMultiple('//*[@id="js_item_list_section"]/div[1]/div/button');
        $is_found = false;
        foreach ($un_selected_pages as $pages) {
            if ($page_number == $pages) {
                $is_found = true;
            }
        }
        if ($is_found) {
            $page_number -= 1;
            $this->click('//*[@id="js_item_list_section"]/div[1]/div/button[' . $page_number . ']');
            $this->logger->writeln("Selected page number [" . $page_number . "]");
        } else {
            $this->logger->writeln("Page [" . $page_number . "] was already selected or it's not found in the list");
        }

        $this->waitForElement('//*[@id="js_item_list_section"]', 30);
    }

    /**
     * @param $page_number : Selected Page Number is validated by the checking for highlighted one from number list.
     */
    public function validate_pagination($page_number)
    {
        $this->wait(2);
        $actual_number = $this->grabTextFrom('//*[@id="js_item_list_section"]/div[1]/div/strong');
        Assert::assertEquals($page_number, $actual_number, "Expected Page Number[ " . $page_number . "], 
        Actual Page Number[" . $actual_number . "]");
    }
}