
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?restaurantid=".$_GET['restaurantid']; ?>" class="form-horizontal"  role="form" method="post">
        <fieldset>
            <legend>Book a table</legend>
            <div class="form-group">
                <label for="dtp_input1" class="col-md-6 control-label">Picking date and time</label>
                <div class="input-group date form_datetime col-md-12"  data-link-field="dtp_input1">
                    <input class="form-control" size="16" type="text" value="" readonly name="reservationtime">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
				<input type="hidden" id="dtp_input1" value="" /><br/>
            </div>

            <div class="form-group">

          <!-- Select Basic -->
          <label class="control-label">Number of customers</label>
        
            <select class="form-control input-xlarge" name="numberofcustomers">
            <?php 
            echo '<option></option>';
            for($x=1;$x<=100;$x+=1) {
                echo '<option>'.$x.'</option>';
            }
            ?>
           </select>
          </div>
                      <div class="form-group">
           
          <!-- Button -->
           <button class="btn btn-default" type="submit">Book!</button>
        </div>
          <input type="hidden" name="restaurantid" value="<?php echo $_GET['restaurantid'];?>"  />
           <input type="hidden" name="submitted" value="TRUE"  />
        </fieldset>
    </form>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
         format: 'yyyy-mm-dd hh:ii:00',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		forceParse: 0,
        showMeridian: 0
    });
    var datestart=Date.now()+3600000;
    var dateend=Date.now()+3600000*24*7;
    $('.form_datetime').datetimepicker('setStartDate', new Date(datestart));
    $('.form_datetime').datetimepicker('setEndDate', new Date(dateend));
    $('.form_datetime').datetimepicker('setHoursDisabled', [0,1,2,3,4,5,6,7,21,22,23]);
</script>
