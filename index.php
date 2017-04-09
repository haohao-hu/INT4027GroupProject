<?php 

session_start(); // Start the session.

$page_title = '| home';
include ('includes/header.html');
?>

<!--<h1 id="mainhead">test</h1>
<p></p>

<h2>test</h2>
<p></p>-->

 <!-- content -->
   <div id="content">
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
        
                        <p>Not a registered customer? <a href="./customer_register_page.php">Register</a> now!</p>
                        <p>Not a registered restaurant? <a href="./restaurant_register_page.php">Register</a> now!</p>                                               
                        <p><a href="index.php">Home</a>, <a href="about.php">About us</a>, <a href="browse_menu.php">Menu</a>, <a href="contact.php">Contact us</a>.
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