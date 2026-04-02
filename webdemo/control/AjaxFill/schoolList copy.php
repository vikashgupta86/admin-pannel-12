<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
        

// $LimitQry=$sspObj->limit($_GET);

$n_id = $_REQUEST['n_id'];

$rs=$obj->simplefetch("select * from school_register_$n_id where status ='Active'",1);
if($rs[0]>0){
    $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
    foreach($rs[1] as $row){   
        $sub1=$obj->simplefetch("select count(*) as ct from school_shortlisted_$n_id where school_id=$row[school_id] and group_id=1 and upload_status=2 and status ='Active'",1);
            foreach($sub1[1] as $row1){}
            
            $ct1=0;
            if($row1['ct']>0){
                $ct1=$row1['ct'];
            }
            else $ct1=0;

        $sub2=$obj->simplefetch("select count(*) as ct from school_shortlisted_$n_id where school_id=$row[school_id] and group_id=2 and upload_status=2 and status ='Active'",1);
            foreach($sub2[1] as $row2){}

            $ct2=0;
            if($row2['ct']>0){
                $ct2=$row2['ct'];
            }
            else $ct2=0;

            if($ct1+$ct2>0)
            {
                $dis="<div class=\"text-center tools\">
                <a href='painting_details.php?per_id=206&sh_id=$row[school_id]&s_year=$n_id&EncHid=$_SESSION[EncTok]' class=\"fa fa-file-text-o\" data-toggle=\"tooltip\" id='view' cdata-frmT='9' data-comp_notice_id='$row[comp_notice_id]' title='View'></a>
                </div>";
            }
            else $dis="<div class=\"text-center tools\">-</div>";

        $data[] = array(++$sNo,
            $row['school_name'], 
            $ct1,              
            $ct2,                            
            $dis,
        );
    }
}

$recordsTotal=$obj->getNameQry("select count(wu.user_id)  from web_users wu
INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
 where wu.status='Active' and wu.user_id!=1");
$recordsFiltered=$obj->getNameQry("select count(wu.user_id)  from web_users wu
INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
 where wu.status='Active' and wu.user_id!=1");


$resData=array(
    "draw"=>isset ( $request['draw'] ) ?intval( $request['draw'] ) :0,
    "recordsTotal"  => intval( $recordsTotal ),
	"recordsFiltered"  => intval( $recordsFiltered ),
	"data" =>  $data
);
echo $obj->frm_response($resData,true,false);