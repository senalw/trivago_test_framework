**Question 2**

**a.	Create 5 different automated test cases for the things that you think are important to automate.** 

Here I have chosen codeception framework with the Page Object Model (POM) design pattern to implement automation framework. POM model enhances the usability of code and also it helps to minimize duplication of code. POM model makes tests more readable and robust while improving the maintainability of them. 

**Test case 1:-** User should be able to search hotel by the country name in trivago.

$trivago_home_page = new pages\TrivagoHomePage($scenario);

$trivago_home_page->goToPage();

$trivago_home_page->search_for($country); //type country name and click search button.

$trivago_home_page->verifySearchHotelLocation($country); //verify the returned result by the country name of it.

$trivago_home_page->makeScreenshot("SearchCountryCept");

**Test case 2:-** User should be able to change the currency of trivago as their preference.

$trivago_home_page = new pages\TrivagoHomePage($scenario);

$trivago_home_page->goto_Trivago_Home_Page();

$trivago_home_page->search_for($country); //type country name and click search button.

$trivago_home_page->changeCurrency("CAD"); // expected currency's short code E.g. USD

$trivago_home_page->validate_currency_change("C$"); //symbol of the currency

$trivago_home_page->makeScreenshot("CurrencyChangeCept");


**Test case 3:-** User should be able to login to trivago.

/////////////////////////////////////////////////////////////////

$email = "senaldulanjala@yahoo.com";

$password = "1234";

/////////////////////////////////////////////////////////////////

$trivago_home_page = new pages\TrivagoHomePage($scenario);

$trivago_login_page = new pages\TrivagoLoginPage($scenario);

$trivago_home_page->goto_Trivago_Home_Page();

$trivago_home_page->click_on_MyProfile();

$trivago_home_page->go_to_login_page();

$trivago_login_page->typeUserCredentials($email, $password);

$trivago_login_page->click_on_login_button();

$trivago_login_page->validate_user_login();

$trivago_home_page->makeScreenshot("UserLoginCept");



**Test case 4:-** User should be able to go through the pages

$country = "Sri Lanka";

$page_number = 2;

$trivago_home_page = new pages\TrivagoHomePage($scenario);

$trivago_home_page->goto_Trivago_Home_Page();

$trivago_home_page->search_for($country); //type country name and click search button.

$trivago_home_page->go_through_pages($page_number); // go to the page

$trivago_home_page->validate_pagination($page_number); // validate the page

$trivago_home_page->scrollTo("//*[@id=\"js_item_list_section\"]/div[1]/div");// scroll down to the page numbers

$trivago_home_page->makeScreenshot("PaginationTestCept");


**Test case 5:-** User should redirect to the correct OTA once he clicks on “View Deal” button.

$country = "Sri Lanka";


$I = new AcceptanceTester($scenario);

$trivago_home_page = new pages\TrivagoHomePage($scenario);

$OTA_page = new pages\OTA_Page($scenario);

$trivago_home_page->goto_Trivago_Home_Page();

$trivago_home_page->search_for($country); //type country name and click search button.

$expected_OTA = $trivago_home_page->goToOTA(3);

$OTA_page->validateOTA($expected_OTA);

$OTA_page->makeScreenshot("ValidateOTACept");

**b.	Explanation for above test cases.** 

Test Case 1: Searching hotels by a country name should be a key feature of trivago. User should be able to search hotels in a country by typing the name of the country in the search bar. If the search result shows hotels in incorrect countries, that could lead to a critical issue. So if we have automated this, we can identify the issue at the regression runs. So we don’t need to put an extra effort on testing it time to time due to the code changes of trivago and also this helps to ensure stable deployment during the continuous delivery.

Test Case 2: User should be able to change the currency in trivago and the system should return prices of hotels with the correct currency according to the change. Trivago is being accessed by users in different countries. So the users are more comfortable to see hotel prices with their currency. By automating this, it will ensure the above functionality hasn’t broken during the continuous delivery. 

Test Case 3: Regular users of the trivago need to sign-in to trivago and maintain their booking records and favourites. Providing capability to adding hotels as their favourites may help to increase the usability of the system. So the users of trivago can save hotel as their favourites and they can use them whenever they want to book a hotel. Therefore the user login should be worked properly. If the username or password is wrong, user shouldn’t be able to login to the system and an error message should be visible. By automating this test case, trivago can achieve customer satisfaction and it will lead to growth in their market. 

Test case 4: People tend to choose the best hotel for their requirement by comparing with other hotels. So the trivago users may like to find the best hotel to book by going through number of pages in trivago. Therefore trivago should provide number of hotels for a user query and also trivago has to present them in number of pages to preserve usability of the system. Thus automating pagination test will ensure this feature is working fine in the final build of software. 

Test Case 5: Trivago allows comparing hotel prices. When user clicks “View Deal” button, it will redirected to the relevant OTA. Booking will be carried through the OTA that has been routed by the trivago. In order to get the correct booking, trivago should route user to the relevant OTA as shows in trivago. By automating this, user will be able to fulfil their bookings successfully without any bad user experiences.



**c.	Limitation of these tests.** 

•	UI changes may impact for the automated test cases. In automated test case we are using locators to identify elements in a webpage. So changing UI means the locators are going to change and test scripts need to change accordingly.
 
•	Inability to validate the content of an image in the test scripts.

•	Automated test can only be executed in a way that developer has implemented them. Thus it can’t be self-trained to execute in situations like hardware or software failures.
 
•	Unable to bypass the captcha code entering. For example if you run a test login automated test script for several times with wrong username or password then trivago ask for a captcha. So then test script can’t bypass that even it enters the correct username and password.

**d.	Generate test results for every run.**
 
 •	Test1: Trivago home page should display hotels in Sri Lanka. 
 
 •	Test2: All the currencies should display in trivago according to the currency change the user has done.
 
 •	Test3: User should be able to login to the system.
 
 •	Test4: User should be able to go through the pages and find hotels. 
 
 •	Test5: User should be redirected to the relevant OTA once he/she clicked on “View Deal” button.
 
 
 **e.	Describe why you choose this method technology.**
 
 1.	Above framework has designed by considering the POM (page object model) and all the operations that can be performed in a page are implemented in one class inside /src/acceptance/pages directory. It allows implementing test cases in one class that can be performed in a one page.
 
 2.	POM design pattern minimizes the code duplication. 
 E.g. I have used goto_Trivago_Home_Page()  function in all the test cases to go to the home page. This has minimized the code duplication.
 
 3.	Since the classes are braked-down according to the webpage operations, code is more readable and maintainable. 
 4.	UI changes can be easily adapted to the test cases. 
 
 5.	Users can easily add more test cases to the classes.



**f.	Push project to git.**

1.	Create a git repo name as “trivago_test_framework” in github.
2.	Initialize the repo by “git init” command.
3.	Initialize remote branch by “git remote add master https://github.com/weerasinght/trivago_test_framework.git”
4.	Initially add all the content to the repo by “git add .”
5.	“git status” to make sure all the content is added to the repo.
6.	Commit git by “git commit -m "Added trivago test framework initially"”
7.	Check remote branch by “git remote -v”
8.	Push project to the repository by “git push origine master”
9.	Create new branch in git to maintain versioning by “git checkout -b develop_QA”
10.	Add a new file to git by “git add <filenaname>”
11.	Commit it by “git commit -m "your comment"”
12.	Push them to develop branch by “git push origine develop_QA”
13.	Merge “develop_QA” branch to “master” branch by “git checkout master” and then executes “git merge develop_QA”.


**g.	Attach the link to your test results.**

•	Clone the framework by “git clone https://github.com/weerasinght/trivago_test_framework.git”.

•	Run “php codecept.phar run --steps --xml –html” cmd command to run tests and generate test results.

**h.	Add a small step by step tutorial to execute your automated test.**

1.	Download codeception from https://codeception.com/install
2.	Install codeception by following the guidance in the above link.
3.	Download framework by “git clone https://github.com/weerasinght/trivago_test_framework.git”
4.	Run chrome driver by going to the drivers folder in project home and running the command “chromedriver --url-base=/wd/hub”
5.	Run “php codecept.phar run --steps --xml --html” command to run test scripts with generating test results.




 