<!-- Name: Venkatesh
Created:2/12/2016
Description: This file is executed when user submits an URL/selects an URL from the list. This file helps in displaying the complete results which obtained after parsing the webpage -->

<!-- Start of PHP code -->
<?php
//The following statement includes the MyParser file which contains all the required parsing functions
include('MyParser.php');
//The following statement helps in getting the url through get method
$pageurl=$_GET['url'];
//The following condition checks whether $url is not empty, if it is empty the method would be "post"
if(!$pageurl)
  $pageurl=$_POST['url'];
//First we will instantiate the object with the give url
$myobj=new MyParser($pageurl);
//getTitle() function is called and the result is copied to the $title variable
$title=$myobj->getTitle();
//getMetaContent() function is called and the result is copied to the $content variable
$content=$myobj->getMetaContent();
//getStory() function is called and the result is copied to the $story variable
$story=$myobj->getStory();
//getImages() function is called and the result is copied to the $images array
$images=$myobj->getImages();
//array_unique function is used to remove any duplicate images
$images=array_unique($images);
//getStoryImage() function is called and the result is copied to the $storyimage variable variable
$storyimage=getStoryImage($images);
//getJpgs() function is called and the result is copied to the $jpgs variable
$jpgs=getJpgs($images);
//getLinks() function is called and the result is copied to the $links variable
$links=$myobj->getLinks();
//getH1() function is called and the result is copied to the $h1s variable
$h1s=$myobj->getH1();
//getH2() function is called and the result is copied to the $h2s variable
$h2s=$myobj->getH2();
//getH3() function is called and the result is copied to the $h3s variable
$h3s=$myobj->getH3();

//This function takes images as input and returns only JPG's among those images
function getJpgs($images)
{
  $i=0;
  //The following foreach loop iterates through each image
  foreach($images as $image)
  {
    //JPG images contain ".jpg", based on this ondition we will seperate JPG's from the rest of the images
    if(stripos($image,".jpg"))
    {
      //JPGimages are coied to the array $jpgs
      $jpgs[$i]=$image;
      $i++;
    }
  }
  //The $jpgs array will be returned at last
  return $jpgs;
}

//This function returns the main story image by taking the images as input
function getStoryImage($images)
{
  foreach($images as $image)
  {
    //The following condition help in finding the story image
    //It should be ".jpg", first image in the article butnot the background
    if(stripos($image,".jpg")&&!stripos($image,"background"))
    {
      //The loop breaks once the story image is found
      $storyimage=$image;
      break;
    }
  }
  //The story image is finally returned
  return $storyimage;
}
 ?>
<!-- The HTML code starts from here -->
 <html>
 <head>
   <title> PHP - Webpage Parser</title>
   <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Includes bootsstrap styles   -->
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
 </head>
 <body>
   <center>
     <h2>
       PHP - Webpage Parser
     </h2>
   </center>
<form method="POST" action="result.php">
<div class="container">
  <h2>Enter URL</h2>
  <form role="form">
    <div class="form-group">
      <input type="text" class="form-control" name="url" >
    </div>
  </form>
</div>
</form>
<div class="container">
  <h3><?= 'Webpage: <a href="'.$pageurl.'" target="_blank">'.$pageurl.'</a>';?></h3>
  <h3>Results</h3>
  <dl>
    <dt>Title</dt>
    <dd> <?= "&emsp;".$title; ?></dd> <br>
    <dt>Heading</dt>
    <dd> <?= "&emsp;".$h1s[0]; ?></dd> <br>
    <dt>Meta Content</dt>
    <dd> <?= "&emsp;".$content; ?></dd> <br>
    <dt>Story</dt>
    <dd> <p class="container" style="text-align:justify;border-left:10%;border-right:10%"><?= "&emsp;".$story; ?> </p></dd> <br>
    <dt>Story Image</dt>
    <dd> <?= '<a href="'.$storyimage.'">><img src='.$storyimage.' width="400px"></img></a>' ?></dd> <br>
    <dt>Images found on this page</dt>
    <dd>
    <?php
      echo '<table border="0">
              <tr>';
      //The counter variable help in determining when to start new table new row
      $counter=0;
      //The f
      foreach($jpgs as $jpg)
      {
        $counter++;
        echo '<td align="center" width="400" height="240"> <a href="'.$jpg.'"><img src='.$jpg.' width="200px" height="200px"></img></a></td>';
        //If five images are displayed in the row than counter sets to zero and new table row gets started
        if($counter==5)
        {
          $counter=0;
          echo '</tr><tr>';
        }
      }
      echo '</tr>
            </table>
      ';
    ?>
    </dd>

  </dl>
</div>

<div class="container">
  <h2>Headings</h2>
  <p>List of headings h1, h2 and h3 tags found on this page</p>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>
          < h1 >
        </th>
      </tr>
    </thead>
    <tbody>
      <?php
      //This loop iterates through each h1 headings array and displays it inside the table
        foreach($h1s as $h1)
        {
          echo '<tr>
                  <td>
                    '.$h1.'
                  </td>
                </tr>
          ';
        }
       ?>
    </tbody>
  </table>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>
          < h2 >
        </th>
      </tr>
    </thead>
    <tbody>
      <?php
      //This loop iterates through each h2 headings array and displays it inside the table
        foreach($h2s as $h2)
        {
          echo '<tr>
                  <td>
                    '.$h2.'
                  </td>
                </tr>
          ';
        }
       ?>
    </tbody>
  </table>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>
          < h3 >
        </th>
      </tr>
    </thead>
    <tbody>
      <?php
      //This loop iterates through each h3 headings array and displays it inside the table
        foreach($h3s as $h3)
        {
          echo '<tr>
                  <td>
                    '.$h3.'
                  </td>
                </tr>
          ';
        }
       ?>
    </tbody>
  </table>
</div>

<div class="container">
  <h4>Hyperlinks</h4>
  <p>List of Hyperlinks found on this page</p>
  <table class="table table-striped">

    <tbody>
        <?php
        //This loop iterates through each link and displays it inside the table
          foreach($links as $link)
          {
            echo '<tr>
                    <td>
                      <a href="'.$link.'">'.$link.'</a>
                    </td>
                  </tr>
            ';
          }
         ?>
    </tbody>
  </table>
</div>
</body>
</html>
