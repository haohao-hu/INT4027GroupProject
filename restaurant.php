<?php 

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

      <div class="container">
         <div class="inside">
            <!-- box begin -->
            <div class="box alt">

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

                     </div>
                  </div>
               </div>
               <div class="left-bot-corner">

                  <div class="right-bot-corner">
                     <div class="border-bot"></div>

                  </div>
               </div>
            </div>
            <!-- box end -->

   
<!--Recent articles list ends -->    
 </div>
      </div>
   </div>
'; 
mysqli_close($dbc);

include ('includes/footer.html');
?>

