<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

// $usr_session='';
// if($_SESSION['user_type'] =='20'){

//      $usr_session= " and (t.entry_by='".$_SESSION['userid']."' || t.nmnh_type='".$_SESSION['musume_type']."')";
// }


$where=" where status='active'";

// if($_REQUEST['event_cat']!=''){
//   $where.=" and em.cat_id='".$_REQUEST['event_cat']."'";
// }
if($_REQUEST['center']!='' && $_REQUEST['center']!=0){
  $where.=" and job_id='".$_REQUEST['center']."'";
}
/*if($_REQUEST['event_name']!=''){
  $where.=" and em.event_name_v like '%".$_REQUEST['event_name']."%'";
}*/

if($_REQUEST['f_date']!='' && $_REQUEST['t_date']!=''	){
  $where.=" and entry_date between '".$obj->todate($_REQUEST['f_date'])."' and '".$obj->todate($_REQUEST['t_date'])."'";
}


/*if($_REQUEST['f_date']!=''){
  $where.=" and entry_date ='".$obj->todate($_REQUEST['f_date'])."'";
}*/

/*if($_REQUEST['t_date']!=''){
  $where.=" and registration_end_date ='".$obj->todate($_REQUEST['t_date'])."'";
}*/


$rs=$obj->simplefetch("select * from applicant_register $where order by id desc");

        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0'; 
           
            foreach($rs[1] as $row){

                $data[] = array(++$sNo,
                    $row['applicant_name'],
                     $obj->fromdate($row['dob']),
                      $row['phone'],
                       $row['email'],
                       $row['Address'],

                     "<div class=\"text-center tools\">
					 <i class=\"fa fa-eye Lpreview\" data-toggle=\"tooltip\" aria-hidden=\"true\" cdata-frmT='7' data-applicant_id='$row[id]' title='Preview'></i>
                    <!--<i class=\"fa fa-edit\" data-toggle=\"tooltip\" cdata-frmT='2' pub-lid='$row[event_id]' data-link_temp_id='$row[event_id]' title='Modify Details'></i>
                    <i class=\"fa fa-trash-o\" data-toggle=\"tooltip\"  cdata-frmT='3' data-link_temp_id='$row[event_id]' title='Delete User'></i>-->                      
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