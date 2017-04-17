<?php
if (isset($_POST['rid'])) {
   $q6="DELETE FROM `review` WHERE  `review_id`=".$_POST['rid'];
     $r6 = @mysqli_query ($dbc, $q6)
   Or die ("Error! Cannot delete review");
   if ($r6) {
    echo '
    <div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Review deleted!</strong>
</div>';
   }
 }
 ?>