<?php 
  include '../appcode/globals.inc.php';
  include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
  userAuthenticationPageLevel();
  userAuthenticationMainLevel();
  include_once('include/pageHeader.inc.php');
  #die("Line 16");
  include('include/top_user_info.inc.php');
  include('inner.php');
  include('include/pageFooter.inc.php');
?>