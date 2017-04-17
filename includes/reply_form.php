<?php
//$errors='';

?>
 <form role="form" class="form-horizontal"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="reply-form">
    <fieldset>
      <div id="legend" class="">
        <legend class="">Reply to Customer Review</legend>
      </div>

    <div class="control-group">

          <!-- Textarea -->
          <label class="control-label">Reply text</label>
          <div class="controls">
            <div class="textarea">
            	<!--<input type="textarea" name="replytext" value="">-->
                  <textarea type="text" class="form-control" name="replytext" value=""> </textarea>
            </div>
          </div>
        </div><div class="control-group">
          <label class="control-label"></label>

          <!-- Button -->
          <div class="controls">
            <button class="btn btn-default" type="submit">Reply!</button>
          </div>
        </div>
        <input type="hidden" name="rvid" value="<?php echo $_POST['reviewid'];?>"  />
           <input type="hidden" name="submitted" value="TRUE"  />
    </fieldset>
  </form>
