<?php 
    include './appcode/globals.inc.php';
    // include './appcode/usercon_pdo.inc.php';
    include_once './include/website_common.inc.php';

 
    $VALIDATE_GET1 = '/^([0-9a-zA-Zs _\-+\/=])+$/mui';
    $VALIDATE_POST1 = '/^([0-9a-zA-Zs \r\n!#@%&"_+\-=\[\];:\\|,.\'\"\/?()])+$/mui';
    $filter1 = "/~|!|@|<|>|html|injection|alert|iframe|union|select|sleep|limit|onmouseover|prompt|bad|\[|\]|\?|\{|\}|\(|\)|\"|-|;|'|\\'|,|-|\*/";

    $blackList1 = '/^((?!script|html|injection|alert|iframe|union|select|sleep|limit).)*$/mui';
   
     $VALIDATE_QRYSTRING1 = '/^([0-9a-zA-Zs %=&_\-+\/])+$/mui';


    $get_error=array();
    if (count($_GET) > 0) {
      foreach ($_GET as $key => $value) {
        $value = preg_replace($filter1, '', strtolower($value));
        $_GET[$key] = $value;

            if (!preg_match($VALIDATE_GET1, $value) || !preg_match($blackList1, $value)) {
            $get_error[]="Invalid GET Data Please POST Valid GET Request";      
        }
      }
    } 


    $post_error=array();
        if (count($_POST) > 0) {
            foreach ($_POST as $key => $value) {
            if($value!=''){
                if (!preg_match($VALIDATE_POST1, $value) || !preg_match($blackList1, $value)) {
                    if ($key) {
                        $post_error[]="Invalid POST Data Please POST Valid POST Request";
                    }
                } 
            }
        }
    }



    if(sizeof($get_error) > 0  || sizeof($post_error) > 0){
      
        header('location:index.php');
        exit;
    }


    $ls_ID = filter_input(INPUT_GET, 'ls_id', FILTER_VALIDATE_INT);
    $lid   = filter_input(INPUT_GET, 'lid', FILTER_VALIDATE_INT);
    $level = filter_input(INPUT_GET, 'level', FILTER_VALIDATE_INT);

    if($level != 0)
    {
        if (!$ls_ID || !$lid || !$level) 
        {
            header('Location: index.php');
            exit;
        }
    }
    else
    {
        if (!$ls_ID || !$lid) 
        {
            header('Location: index.php');
            exit;
        }
    }

    /*
        if(((isset($_REQUEST['ls_id'])) && trim($_REQUEST['ls_id'])=='') || ((isset($_REQUEST['lid'])) && trim($_REQUEST['lid'])=='')){
            header('location:index.php');
            exit;
        }
        if(!isset($_REQUEST['ls_id']) || !isset($_REQUEST['lid'])){
            header('location:index.php');
            exit;


            
        $sql = "SELECT COUNT(sno) as tot FROM web_attempts WHERE login = ? AND ipaddress = ? AND DATE(dated) = DATE(?)";

        $res = simplefetch($sql, "sss", [$login, $ip, $cDate]);
        }*/

        #include('include/header.inc.php');
    ?>


    <body>
    <?php
    if(isset($_GET['t_id']) && !isset($_GET['ct_id'])){#for tender
        $rs=simplefetch("select wtc.t_cat_id,tt.details,tt.file_name,tf.t_id,tt.t_temp_id,wtc.cat_name,tt.tender_name,tt.close_time,ifnull(date_format(tt.pub_date,'%M %d, %Y'),'N/A')as pub_date,tt.pub_time,ifnull(date_format(tt.close_date,'%M %d, %Y'),'N/A')as close_date,ifnull(date_format(tt.open_date,'%M %d, %Y'),'N/A')as open_date,tt.open_time,ifnull(date_format(tt.expiry_date,'%M %d, %Y'),'N/A')as expiry_date
         from web_tender_temp tt
        INNER JOIN web_tender_final tf on tf.t_temp_id=tt.t_temp_id
        INNER JOIN web_tender_category wtc on wtc.t_cat_id=tt.t_cat_id
         where tt.`status`='Active' and wtc.status='Active' and wtc.app_reject=1 and tf.t_id=".$_GET['t_id']."");
         $fol_Name='T45218';
    }        
    elseif(isset($_GET['t_id']) && isset($_GET['ct_id'])){#corrigendum
        $rs=simplefetch("select tt.file_name,wtc.cat_name,tf.ct_id,tf.t_id,tt.pub_time,tt.close_time,tt.open_time,ifnull(date_format(tt.pub_date,'%M %d, %Y'),'N/A')as pub_date,ifnull(date_format(tt.close_date,'%M %d, %Y'),'N/A')as close_date,ifnull(date_format(tt.open_date,'%M %d, %Y'),'N/A')as open_date,ifnull(date_format(tt.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,tt.t_temp_id,tt.tender_name
         from web_tender_temp tt
        INNER JOIN web_tender_corrigendum_final tf on tf.t_temp_id=tt.t_temp_id
        INNER JOIN web_tender_category wtc on wtc.t_cat_id=tt.t_cat_id
         where tt.status='Active' and tf.ct_id=".$_GET['ct_id']." and tt.corrigendum=1 and tf.t_id=".$_GET['t_id']."");
         $fol_Name='T45218';
    }
    else{
        $SubQry=empty($_GET['level'])?" and ls.link_level is null":" and ls.link_level=".$_GET['level']."";    
        
		if($_SESSION['lang']==2 || $_SESSION['lang']=="3"){
		$rs=simplefetch("select lt.link_name,lt.file_name from web_links_final lf 
        INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id 
        /*INNER JOIN web_links_structure ls on ls.lid=lf.lid*/
        where lf.status='Active' and lt.status='Active' and lt.type_id=1 /*and ls.status='Active' $SubQry*/ and lt.lang_id=".$_SESSION['lang']." /*and ls.ls_id='$_REQUEST[ls_id]'*/ and lt.eng_id=".$_REQUEST['lid']."",1);	
		}else{
		$rs=simplefetch("select lt.link_name,lt.file_name from web_links_final lf 
        INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id 
        INNER JOIN web_links_structure ls on ls.lid=lf.lid
        where lf.status='Active' and lt.status='Active' and lt.type_id=1 and ls.status='Active' $SubQry and lt.lang_id=".$_SESSION['lang']." and ls.ls_id=".$_REQUEST['ls_id']." and lf.lid=".$_REQUEST['lid']."",1);
		}
        $fol_Name='L45218';

    }
    
    if($rs[0]<=0){
        headersFront('index','');
        exit;
    }

 //   var_dump($rs);
    foreach($rs[1] as $row);    
#    $fname=$row['file_name'].'.'.end(explode('.',$row['file_name']));
    $fname=$row['file_name'];
	  $fullpath="WriteReadData/$fol_Name/" . $fname;
   
           header("Location: " . $fullpath);


    // header('Content-type: application/pdf');
    // header('Content-Disposition: inline; filename="' . $fname . '"');
    // header('Content-Transfer-Encoding: binary');
    // header('Content-Length: ' . filesize($fullpath));
    // header('Accept-Ranges: bytes');
    // echo file_get_contents($fullpath);
	
    ?>
</body>
</html>