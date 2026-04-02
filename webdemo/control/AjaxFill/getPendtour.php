<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

$usr_session='';
if($_SESSION['user_type'] =='20'){

     $usr_session= " and (t.entry_by='".$_SESSION['userid']."' || t.nmnh_type='".$_SESSION['musume_type']."')";
}

$rs=$obj->simplefetch("select t.*,nh.nmnh_type,r.cname from Tour as t left join nmnh_type as nh on t.nmnh_type=nh.id left join register as r on r.id=t.user_id where t.status='Active' $usr_session order by t.id desc $LimitQry");

        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0'; 
            $utype=array('1'=>'School','2'=>'Student','3'=>'Department','4'=>'Individual'); 
            $g=array('1'=>'Yes','2'=>'No');   
            foreach($rs[1] as $row){
                $data[] = array(++$sNo,
                    $row['nmnh_type'],
                    $utype[$row['user_type']], 
                    $row['cname'],
                     $row['date']." ".$row['time'],
                     $row['school'],
                    $row['teachers'],
                    $row['students'],
                    $row['class'],
                    $row['Adults'],
                    $row['children'],
                    $row['employee'],
                    $row['name'],
                    $row['Address'],
                    $row['phone'],
                    $row['email'],
                    $g[$row['guidance']],
                    $row['entry_date'],                    
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-check-circle-o\" cdata-frmT='4' data-id='$row[id]' title='Approve'></i>
                        <i class=\"fa fa-remove\" cdata-frmT='3' data-id='$row[id]' title='Reject'></i>                        
                    </div>",
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