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


$where=" where 1=1 and epm.status='active'";

// if($_REQUEST['event_cat']!=''){
//   $where.=" and em.cat_id='".$_REQUEST['event_cat']."'";
// }
if($_REQUEST['center']!=''){
  $where.=" and em.center_id='".$_REQUEST['center']."'";
}
if($_REQUEST['event_name']!=''){
  $where.=" and em.event_name_v like '%".$_REQUEST['event_name']."%'";
}
if($_REQUEST['f_date']!=''){
  $where.=" and em.date_from ='".$obj->todate($_REQUEST['f_date'])."'";
}
if($_REQUEST['t_date']!=''){
  $where.=" and em.publish_date ='".$obj->todate($_REQUEST['t_date'])."'";
}


$rs=$obj->simplefetch("select epm.*,em.cat_id,em.event_name_v,em.center_id,em.class_group_id,ecm.category_name,mu.nmnh_type,r.Student,r.phone,r.email from event_participate_master as epm left join event_master as em on em.event_id=epm.event_id left join event_category_master as ecm on ecm.id=em.cat_id left join nmnh_type as mu on mu.id=em.center_id left join register as r on r.id=epm.student_id $where order by epm.id desc");

        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0'; 
           


             
            foreach($rs[1] as $row){
            if($row['center_id']!=0) { 
              $mu=$row['nmnh_type'];
            }
            else{
              $mu="National Museum of Natural History";
            }


            if(strpos($row['class_group_id'], ',') !== false ) {

              $st=explode(",",$row['class_group_id']);
              $class_group='';
              foreach($st as $v){
               $class_group1=$obj->getNameQry("select class_group from class_group where id ='".$v."'");
               $class_group.="<br>".$class_group1;
            }


              $class_group=ltrim($class_group,'<br>');

            }
            else{

              $class_group=$obj->getNameQry("select class_group from class_group where id='".trim($row['class_group_id'])."'");
            }

            if($row['upload_work']!=''){
              $url='../WriteReadData/participant_data/'.$row['upload_work'];
              $img="<a target='_blank' href='".$url."'><img src='".$url."' style='width:100px;'></a>";
            }
            else{
              $img="";
            }

             if($row['school_recomendation_formate']!=''){
              $url='../WriteReadData/participant_data/'.$row['school_recomendation_formate'];
              $pdf="<a target='_blank' href='".$url."'><i class='fa fa-file-pdf-o text-red' title='View File'></i></a>";
            }
            else{
              $pdf="";
            }
            

                $data[] = array(++$sNo,
                    $row['cat_id'],
                     $row['event_name_v'],
                    $class_group,
                    $mu,
                      $row['Student'],
                       $row['email'],
                       $row['phone'],
                        $pdf,
                       $img,
                       $row['status'],


                                   
                    // "<div class=\"text-center tools\">
                    //     <i class=\"fa fa-edit\" data-toggle=\"tooltip\" cdata-frmT='2' pub-lid='$row[event_id]' data-link_temp_id='$row[event_id]' title='Modify Details'></i>
                    //     <i class=\"fa fa-trash-o\" data-toggle=\"tooltip\"  cdata-frmT='3' data-link_temp_id='$row[event_id]' title='Delete User'></i>                      
                    // </div>",
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