<!--for log out-->
<?php
session_start();
  // remove all session variables
  session_unset(); 
  // destroy the session 
  session_destroy();
 header("Location: index.php");
 //when log out bring them to log in page when they come this website
  //echo "All session variables are now removed, and the session is destroyed." 
?>