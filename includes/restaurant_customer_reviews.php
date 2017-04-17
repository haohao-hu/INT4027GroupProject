<?php echo '<div class="col-md-8">';
 //if (!isset($_GET['restaurantid'])){}
if (isset($_GET['restaurantid'])) {
   $q5="SELECT `taste`,`environment`,`service`,`text`,`customer_id`,`customer_name`, `review_id` FROM `review` r,`customer` c WHERE  r.`customerId`=c.`customer_id` AND `restaurantId`=".$_GET['restaurantid']." ORDER BY `post_time`";
 } elseif (isset($_SESSION['restaurant_id'])){
 $q5="SELECT `taste`,`environment`,`service`,`text`,`customer_id`,`customer_name`, `review_id` FROM `review` r,`customer` c WHERE  r.`customerId`=c.`customer_id` AND `restaurantId`=".$_SESSION['restaurant_id']." ORDER BY `post_time`";

 }
   $r5 = @mysqli_query ($dbc, $q5)
   Or die ("Cannot retrieve review data");
echo '<ul class="list-group">';
  while ($row5 = mysqli_fetch_array ($r5, MYSQLI_NUM)){

   echo "<li class='list-group-item'><ul><li class='list-group-item' >Taste: ".$row5[0].", ";
   echo "Environment: ".$row5[1].", ";
   echo "Service: ".$row5[2]."</li>";
   echo "<li class=\"list-group-item list-group-item-info\">".$row5[3]."</li>";
   echo "<li class='list-group-item' >Posted by <a href=\"customer_profile.php?cid={$row5[4]}\">".$row5[5].'</a>';
   if (isset($_SESSION['restaurant_id'])) {
   echo ', <form class="form-inline" enctype="multipart/form-data" action="index.php" method="post" role="form" ><input type="hidden" name="reviewid" value="'.$row5[6].'" /><input type="hidden" name="submitted" value="True" /><input type="submit" name="submit" value="reply"  /></form>';
 }    
   if (isset($_SESSION['admin'])||$_SESSION['customer_id']==$row5[4]) {
    //require_once('../mysqli_connect.php');
   echo ', <form enctype="multipart/form-data" action="restaurant_profile.php" method="post" role="form" ><input type="hidden" name="rid" value="'.$row5[6].'" /><input type="hidden" name="submitted" value="True" /><input type="submit" name="submit" value="Delete review"  /></form>';
 }
 echo '</li>';
 $q6="SELECT `restaurant_name`,`review_id`,rp.`text`,`reply_time` FROM `review` rv,`reply` rp, `restaurant` rs WHERE  rs.`restaurant_id`=rv.`restaurantId` AND rv.`review_id`=rp.`reviewId` AND `review_id`=".$row5[6]." ORDER BY `reply_time`";
 $r6 = @mysqli_query ($dbc, $q6)
   Or die ("Cannot retrieve reply data");
   if ($r6) {
    //echo '<ul class="list-group">';
      while ($row6 = mysqli_fetch_array ($r6, MYSQLI_NUM)){

   echo "<li><ul  class=\"list-group\"><li class='list-group-item' >".$row6[0]." replid: </li>";
   echo "<li class='list-group-item list-group-item-info'>".$row6[2]."</li>";
   echo "<li class='list-group-item' >".$row6[3]."</li>";
   //echo "<li class=\"list-group-item \">".$row5[3]."</li>";
   //echo "<li>Posted by <a href=\"customer_profile.php?cid={$row5[4]}\">".$row5[5].'</a>'; 
   echo "</ul></li>";
   }
   //echo '</li>';
   echo "</ul></li>";
  }
}
echo '</ul>';
 echo '</div>';

?>