<!-- Name: Venkatesh
Created:2/12/2016
Description: This file contains MyParser ckass which contains all the functions required for parsing the webpage.  -->

<!-- Start of PHP code -->
<?php
//Some functions may creates some errors when some tags misses in the given article, so it is adivisable to set the error reporting off
error_reporting(0);
//All the required webpage parser functions are written in this class
class MyParser
{
  //$html variable holds the raw html data loaded from the webpage.
  //This variable isset as global to make it accessible by various parsing functions
  var $html;
  //This is the constructor of the MyParser class which takes webpage url as input, loads the data from the website and copies it to the $html variable
  function MyParser($pageurl)
  {
    //global is used to refer global $htmlvariable
    global $html;
    //file_get_contents function is used to get the contents from the webpage
    $html=file_get_contents($pageurl);
  }

  //This function returns the title of the webpage
  function getTitle()
  {
    global $html;
    //The following regular expression extracts contents from the $html which is enclosed between the tags <title>..</title> and copies it to the $matches variable
    preg_match_all('/<title>.*?<\/title>/is', $html, $matches);
    $temptitle=htmlentities($matches[0][0]);
    //The following string replace functions removes the title tag from the extracted text
    $temptitle=str_replace("&lt;title&gt;","",$temptitle);
    $title=str_replace("&lt;/title&gt;","",$temptitle);
    //Returns the title
    return $title;
  }
  //This function returns all the images found on the given webpage
  function getImages()
  {
    global $html;
    //The following regular expression extracts contents from the $html which is enclosed between the tags <img>..</img> and copies it to the $imagetags variable
    preg_match_all('/<img[^>]+>/i',$html, $imagetags);
    //The following loop parses through the each image and extracts source information
    for ($i = 0; $i < count($imagetags[0]); $i++) {
      //From the extracted image tag, the following regular expression match helps in extracting the contents in the src attribute of the img tag
      preg_match('/src="([^"]+)/i',$imagetags[0][$i], $imagetags2);
      //Finally the "src=" needs to be removed from the extracted source
      $images[] = str_ireplace( 'src="', '',  $imagetags2[0]);
    }
    //Returns the images array
    return $images;
  }
  //This function returns the story in the given article
  //For CNN.com website, It is observed that the complete story is enclosed between the paragraph tags of class-name "zn-body__paragraph"
  //This function extracts content from each tag, combines them and returns it as a single string
  function getStory()
  {
    global $html;
    //The following regular expression extracts contents from the $html which is enclosed between the tags <p class="zn-body__paragraph">..</p> and copies it to the $matches variable
    preg_match_all('/<p class="zn-body__paragraph">.*?<\/p>/is', $html, $matches);
    //$story variable is declared and it is ready to be concatenated
    $story="";
    for($i=0; $i<count($matches[0]); $i++)
    {
        //Each paragrah content is temporarily coped to the variable for further processing
        $m=$matches[0][$i];
        //The following regular expression help in find and replacing the anchor tags
        $m= preg_replace('/<\/?a[^>]*>/','',$m);
        //The following two string replace functions help in find and replacing the h3 tags
        $m=str_replace("<h3>","",$m);
        $m=str_replace("</h3>","",$m);
        //The following two string replace functions help in find and replacing the strong tags
        $m=str_replace("<strong>","",$m);
        $m=str_replace("</strong>","",$m);
        //The following two string replace functions help in find and replacing the paragraph tags
        $m=str_replace('<p class="zn-body__paragraph">','',$m);
        $m=str_replace("</p>","",$m);
        //The following two string replace functions help in find and replacing the cite tags
        $m=str_replace('<cite class="el-editorial-source">','',$m);
        $m=str_replace("</cite>","",$m);
        //Concatenates each para to the story variable
        $story.=$m;
    }
    //returns the resultant $story variable
    return $story;
  }
  //This function returns all the h1 headings found on the given webpage
  function getH1()
  {
    global $html;
    //The following regular expression extracts contents from the $html which is enclosed between the tags <h1 class="pg-headline">..</h1> and copies it to the $matches variable
    preg_match_all('/<h1 class="pg-headline">.*?<\/h1>/is', $html, $matches);
    //The following loop parses through each extracted h1 tag
    for($i=0; $i<count($matches[0]); $i++)
    {
      //The following statements removes h1 tags from the extracted text
      $matches[0][$i]=str_replace('<h1 class="pg-headline">','',$matches[0][$i]);
      $matches[0][$i]=str_replace('</h1>','',$matches[0][$i]);
    }
    //Returns the array of processed h1 tags text
    return $matches[0];
  }
  //This function returns all the h2 headings found on the given webpage
  function getH2()
  {
    global $html;
    //The following regular expression extracts contents from the $html which is enclosed between the tags <h2 class="cd__headline">..</h2> and copies it to the $matches variable
    preg_match_all('/<h2 class="cd__headline">.*?<\/h2>/is', $html, $matches);
    for($i=0; $i<count($matches[0]); $i++)
    {
      //The following statements removes h2 tags from the extracted text
      $matches[0][$i]=str_replace('<h2 class="cd__headline">','',$matches[0][$i]);
      $matches[0][$i]=str_replace('</h2>','',$matches[0][$i]);
    }
    //Returns the array of processed h2 tags text
    return $matches[0];
  }
  //This function returns all the h3 headings found on the given webpage
  function getH3()
  {
    global $html;
    //The following regular expression extracts contents from the $html which is enclosed between the tags <h3>..</h3> and copies it to the $matches variable
    preg_match_all('/<h3>.*?<\/h3>/is', $html, $matches);
    for($i=0; $i<count($matches[0]); $i++)
    {
      //The following statements removes h3 tags from the extracted text
       $matches[0][$i]=str_replace('<h3>','',$matches[0][$i]);
       $matches[0][$i]=str_replace('</h3>','',$matches[0][$i]);
    }
    //Returns the array of processed h3 tags text
    return $matches[0];
  }
  //This function returns the content text in the meta tag, most of the search engines uses this content while indexing
  function getMetaContent()
  {
    global $html;
    //The following regular expression extracts contents from the $html which is enclosed between the tags <meta>..</meta> and copies it to the $metacontents variable
    preg_match_all('/<meta[^>]+>/i',$html, $metacontents);
    //This loop iterates through each extracted meta tag text
    for ($i = 0; $i < count($metacontents[0]); $i++) {
      //The following regular expression extracts content in the content attribute and copies it in the $metacontents2 array
      preg_match('/content="([^"]+)/i',$metacontents[0][$i], $metacontents2);
      $metacontents3[] = str_ireplace( 'content="', '',  $metacontents2[0]);
    }
    //The following loop iterates thorugh each extracted meta content text in order to find out the right one
    foreach($metacontents3 as $mc)
    {
      //This condition helps in finding the appropriate text as the right one text length would be more compared to the others
      if(strlen($mc)>140)
      //Returns the final text after removing the attribute "content=" from the text
        //return str_replace('content="','',$mc);
        return $mc;
    }
    //Returns NA when it doesn't find the appropriate content
    return "NA";
  }
  //This function returns all the hyperlinks found on the given webpage
  function getLinks()
  {
    global $html;
    //The following regular expression extracts contents from the $html which is enclosed between the tags <a>..</a> and copies it to the $linkslist variable
    preg_match_all('/<a[^>]+>/i',$html, $linkslist);
    //The following loop iterates through each hyperlink to find out it's hypertext reference (href attribute)
    for ($i = 0; $i < count($linkslist[0]); $i++) {
      //The following regular expression finds out the href attribute and copies that to the $linkslist2 variable
      preg_match('/href="([^"]+)/i',$linkslist[0][$i], $linkslist2);
      $links[] = str_ireplace( 'href="', '',  $linkslist2[0]);
    }
    $j=0;
    for($i=0; $i<count($links); $i++)
    {
      //$links[$i]=str_replace('href="','',$links[$i]);
      //The following condition checks the structure of hyperlink
      if(stripos($links[$i],"ttp://")||stripos($links[$i],"ttps://"))
      {
        //IF the hyperlink already contains "http://" or "https://", it copies the link without any modification
        $links2[$j]=$links[$i];
        $j++;
      }
      else {
        //If the hyperlink doesnot contain "http://", it adds that to the link and copies to the array $links2
        $links2[$j]="http://cnn.com".$links[$i];
        $j++;
      }
    }
    //Some duplicae links are observed, so array_unique function is used to remove any duplicate entries and the resultant array is returned
    return array_unique($links2);
  }
  //This function returns all the articles
  function getArticles($links)
  {
    //This function takes $links as it's input parameter
    //$j variable is initialized with value 0
    $j=0;
    //The following loop iterates through each hyperlink and finds out classifies articles from the other hyperlinks
    for($i=0; $i<count($links); $i++)
    {
      //Based on the length of the hyperlink, we can easily distinguis articles from the other links
      if(stripos($links[$i],"ttp://cnn.com")&&strlen($links[$i])>60)
      {
        $links2[$j]=$links[$i];
        $j++;
      }
    }
    //Finally the array of articles are returned
    return $links2;
  }
}
 ?>
