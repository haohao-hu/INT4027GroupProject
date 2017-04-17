    <?php 
       require_once ('includes/login_functions.inc.php');
   require_once ('mysqli_connect.php');

if (!isset($_SESSION['customer_id'])) {

   $url = absolute_url('login.php');
   header("Location: $url");
   exit();     
}

            ?>
  <form role="form" class="form-horizontal"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'?restaurantid='.$_GET['restaurantid'];?>" method="post" id="customer-review-form">
    <fieldset>
      <div id="legend" class="">
        <legend class="">Post Customer Review</legend>
      </div>
    <div class="control-group">

          <!-- Select Basic -->
          <label class="control-label">Taste rating</label>
          <div class="controls">
            <select class="form-control input-xlarge" name="tasterate">
            <?php 
            echo '<option></option>';
            for($x=0.5;$x<=5.0;$x+=0.5) {
                echo '<option>'.$x.'</option>';
            }
            ?>
           </select>
          </div>

        </div>

    <div class="control-group">

          <!-- Select Basic -->
          <label class="control-label">Environment rating</label>
          <div class="controls">
            <select class="form-control input-xlarge" name="envrate">
    <?php 
    echo '<option></option>';
            for($x=0.5;$x<=5.0;$x+=0.5) {
                echo '<option>'.$x.'</option>';
            }
            ?></select>
          </div>

        </div>

    

    <div class="control-group">

          <!-- Select Basic -->
          <label class="control-label">Service rating</label>
          <div class="controls">
            <select class="form-control input-xlarge" name="servicerate">
    <?php 
    echo '<option></option>';
            for($x=0.5;$x<=5.0;$x+=0.5) {
                echo '<option>'.$x.'</option>';
            }
            ?></select>
          </div>

        </div>

    

    <div class="control-group">

          <!-- Textarea -->
          <label class="control-label">Review text</label>
          <div class="controls">
            <div class="textarea">
                  <textarea type="text" class="form-control" name="reviewtext"> </textarea>
            </div>
          </div>
        </div><div class="control-group">
          <label class="control-label"></label>

          <!-- Button -->
          <div class="controls">
            <button class="btn btn-default" type="submit">Post comment</button>
          </div>
        </div>
        <input type="hidden" name="restaurantid" value="<?php echo $_GET['restaurantid'];?>"  />
           <input type="hidden" name="submitted" value="TRUE"  />
    </fieldset>
  </form>
