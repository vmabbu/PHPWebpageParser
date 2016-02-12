The PHP Webpage Parser is a PHP application which is designed to parse the given webpage. The parser is tested only for the website "CNN.com" as each website follows their own formats. This application parses through the given article and extracts content in <title>, <meta>, <p>, <h1>, <h2>, <h3> and <a> tags. This application not used any PHP native/other libraries for parsing.


This application contains following files

1. index.php: This is the index page for the webpage parser application. User first lands here and he/she enters an URL or selects the existing URLfrom the given list. The list of articles in this page are generated by parsing the cnn.com page. The list will be updated by time as it directly loads from the CNN website
2. MyParser.php: This file contains MyParser ckass which contains all the functions required for parsing the webpage.
3. result.php: This file is executed when user submits an URL/selects an URL from the list. This file helps in displaying the complete results which obtained after parsing the webpage


Instructions
1. Copy "PHPWebpageParser" folder into the htdocs folder.
2. Open browser and type "http://localhost/PHPWebpageParser/"
3. You may paste an article URL or select an article from the given list.
4. The list in the hompage is directly loaded from the CNN website (cnn.com/world/) which changes by time.
5. The application is hosted on "iknow.xyz/PHPWebpageParser/" which gives you a live demo.


