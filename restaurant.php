<?php 
<<<<<<< HEAD
session_start();

// Set the page title and include the HTML header:
$page_title = '| All restaurants';
include ('includes/header.html');

require_once ('./mysqli_connect.php');
 
// Default query for this page:
//$q = "SELECT artists.artist_id, CONCAT_WS(' ', first_name, middle_name, last_name) AS artist, print_name, price, description, print_id FROM artists, prints WHERE artists.artist_id = prints.artist_id ORDER BY artists.last_name ASC, prints.print_name ASC";

// Are we looking at a particular restaurant?
if (isset($_GET['rid']) && is_numeric($_GET['rid']) ) {
   $aid = (int) $_GET['rid'];
   if ($aid > 0) { // Overwrite the query:
     // $q = "SELECT restaurant_id, CONCAT_WS(' ', first_name, middle_name, last_name) AS artist, print_name, price, description, print_id FROM artists, prints WHERE artists.artist_id = prints.artist_id AND prints.artist_id = $rid ORDER BY prints.print_name";
   }
}

// Create the table head:
echo '<div id="content">
=======

session_start(); // Start the session.

$page_title = 'Welcome to Delicious Meal Web App!';
include ('includes/header.html');
?>

<!--<h1 id="mainhead">test</h1>
<p></p>

<h2>test</h2>
<p></p>-->

 <!-- content -->
   <div id="content">
>>>>>>> origin/master
      <div class="container">
         <div class="inside">
            <!-- box begin -->
            <div class="box alt">
<<<<<<< HEAD
               <div class="left-top-corner">
                  <div class="right-top-corner">
                     <div class="border-top"></div>
                  </div>
               </div>
               <div class="border-left">
                  <div class="border-right">
                     <div class="inner">
                        <div class="wrapper">
                  <table class="table-striped" border="0" width="100%" cellspacing="3" cellpadding="3" align="center">
   <tr>
      <td align="left" width="10%"><b>Name</b></td>
      <td align="left" width="10%"><b>Menu</b></td>
      <td align="left" width="20%"><b>Address</b></td>
      <td align="left" width="15%"><b>District</b></td>
      <td align="left" width="15%"><b>Taste rating</b></td>
      <td align="left" width="15%"><b>Environment rating</b></td>
      <td align="left" width="15%"><b>Service rating</b></td>
      
   </tr>';
$q='SELECT * FROM `restaurant`';
// Display all the prints, linked to URLs:
$r = mysqli_query ($dbc, $q);
while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)) {

   // Display each record:    <a href=\"view_print.php?pid={$row['print_id']}\">{$row['print_name']}</a>
   echo "\t<tr>
      <td align=\"left\"><a href=\"restaurant_profile.php?restaurantid={$row['restaurant_id']}\">{$row['restaurant_name']}</a></td>
      <td align=\"left\"><a href=\"browse_menu.php?rid={$row['restaurant_id']}\">View!</a></td>
      <td align=\"left\">{$row['address']}</td>
      <td align=\"left\">{$row['district']}</td>
            <td align=\"left\">{$row['taste']}</td>
      <td align=\"left\">{$row['environment']}</td>
      <td align=\"left\">{$row['service']}</td>
      
   </tr>\n";

} // End of while loop.

echo '</table>'
;
echo '                           <dl class="special fright">
                              </div>
=======
            	<div class="left-top-corner">
               	<div class="right-top-corner">
                  	<div class="border-top"></div>
                  </div>
               </div>
               <div class="border-left">
               	<div class="border-right">
                  	<div class="inner">
                   	  <div class="wrapper">
                        	<dl class="special fright">
                           	<dt>Special</dt>
                              <dd><img src="images/food/food1.jpg" alt="" width="97" height="67" /><span>12.95</span></dd>
                              <dd><img src="images/food/food2.jpg" alt="" width="97" height="67" /><span>12.95</span></dd>
                           </dl>
                        <h3><small>Welcome to BEL Resturant!</small></h3>
                        <p>Bel Resturant is the largest casual dining chain in the world, with locations throughout the U.S. and many countries worldwide. We take pride in having a friendly, welcoming, neighborhood environment for both <br>
                        our staff and guests that makes everyone enjoy their bels experience.<p>If you're looking for a fabulous career with a great social environment, apply to become part of the Bel's family. Hand-cut steaks, award winning ribs, fresh-baked bread and made from scratch side items are the standard at Texas Roadhouse. </p>
                        <p>All of our food is created from scratch with only the highest quality-freshest ingredients. We combine large portions and great value to give you Legendary Food at a reasonable price.
                          But we're not just about steaks. With great ribs, chicken dishes, fish, salads and lots more, we can satisfy almost any appetite. </p>
                        <p><a href="index.php"><img src="images/small_index_pic.png" width="209" height="175" align="left" /></a>We guess that's why you all voted us #1 in both Menu Variety and Value in the 2004 Restaurant & Institution Magazine's Choice in Chains Guest Survey.
                          Legendary Service for every guest and Legendary Fun with our employees, are also main ingredients in our recipe for success. </p>
                        <p>At Bells Resturant, our team has an incredible sense of pride in everything we do. We want our guests to have such a good time they'll want to come back again tomorrow.</p>
                        <p>&nbsp;	</p>                                              
                        <p><a href="home.html">Home</a>, <a href="about.php">About us</a>, <a href="menu.php">Menu</a>, <a href="contact.php">Contact us</a>, <a href="sitemap.html">Site Map</a>.
                      </div>
>>>>>>> origin/master
                     </div>
                  </div>
               </div>
               <div class="left-bot-corner">
<<<<<<< HEAD
                  <div class="right-bot-corner">
                     <div class="border-bot"></div>
=======
               	<div class="right-bot-corner">
                  	<div class="border-bot"></div>
>>>>>>> origin/master
                  </div>
               </div>
            </div>
            <!-- box end -->
<<<<<<< HEAD
   
<!--Recent articles list ends -->    
 </div>
      </div>
   </div>
'; 
mysqli_close($dbc);

include ('includes/footer.html');
?>
=======
<!--Recent articles list start-->		
<?php


echo '
<!--Recent articles list ends -->	 
 </div>
      </div>
   </div>
   <!-- footer -->';


include ('includes/footer.html');
?>
>>>>>>> origin/master
