<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
    

// to get per_id         
$rsmodule=$obj->simplefetch("select up.per_id,up.user_id,m.module_id,m.module_name,m.abbrev,ifnull(m.fa_icon,'fa-arrow-right')as fa_icon from web_user_permission up,web_st_module m, web_st_sub_module sm where up.status='Active' and m.status='Active' and sm.status='Active' and m.module_id=sm.module_id and sm.sub_module_id=up.sub_module_id and up.user_id=$_SESSION[userid] group by m.module_id order by m.pos");

if($rsmodule[0]>0){
    foreach ($rsmodule[1] as $rowmodule){
        $rssubmodule=$obj->simplefetch("select ifnull(sm.fa_icon,'fa-circle-o')as s_fa_icon,sm.pos,up.per_id,sm.sub_module_id,sm.sub_module_page,sm.sub_module_name from web_user_permission up,web_st_module m, web_st_sub_module sm where up.status='Active' and m.status='Active' and sm.status='Active' and m.module_id=sm.module_id and sm.sub_module_id=up.sub_module_id and up.user_id=$_SESSION[userid] and m.module_id=$rowmodule[module_id] order by sm.pos");

        if($rssubmodule[0]>0){
            foreach ($rssubmodule[1] as $rowsubmodule){                        
                if($rowsubmodule[3]==61)
                {
                    $per_id = $rowsubmodule['per_id'];
                }
            }
        }
    }
}


// filter for state user
if($_SESSION['user_type']==9){
    
    $st1=$obj->simplefetch("select wup.state_id from web_users as wu INNER JOIN web_users_profile as wup ON wup.user_id = wu.user_id where wu.user_id=$_SESSION[userid] and wu.status ='Active'",1);
    $state_id = $st1[1][0][0];
    $st_q = "and state_id=$state_id";

}


$n_id = $_REQUEST['n_id'];

$rs=$obj->simplefetch("select * from applicant_register where status ='Active' and notice_id=$_REQUEST[n_id] $st_q order by entry_date desc, freeze_date desc",1);
if($rs[0]>0){
    $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
    foreach($rs[1] as $row){   
    
        $dis="<div class=\"text-center tools\">-</div>";
        
        $sect=$obj->simplefetch("select * from neca_sectors where sector_id=$row[sector_id] and status ='Active'",1);
        foreach($sect[1] as $sectrow1)
        {
            $sect_name=$sectrow1['sector_name'];               
        }
        
        
        $subsect=$obj->simplefetch("select * from neca_subsectors where subsector_id=$row[subsector_id] and status ='Active'",1);
        foreach($subsect[1] as $subsectrow1)
        {
            $subsect_name=$subsectrow1['subsector_name'];               
        }
        
		if ($row['upload_status']==1)
		{
			$quest="<a target='_blank' href='../WriteReadData/quest/". $row['applicant_id'] ."/". $row['quest_file'] ."'>" . $row['quest_file'] . "</a>";
		
        
			$docs=$obj->simplefetch("select * from applicant_documents where applicant_id=$row[applicant_id] and notice_id=$row[notice_id] and status ='Active'",1);
			if($docs[0]>0)
			{ 
				foreach($docs[1] as $docsrow1)
				{
					$docsurl="";
					$docsurl="<a target='_blank' href='../WriteReadData/app_docs/". $row['applicant_id'] ."/". $docsrow1['doc_file'] ."'>" . $docsrow1['doc_file'] . "</a>";
					$docs=$docsurl ."<br>". $docs ;               
				}
			}
			else
			{
				$docs="<span style='color:red; font-weight:bold;'><center>Not Submitted</center></span>";
			}
		}
			else
			{
				$quest="";
				$docsurl="";
				$docs="";
			}
				
        
                
            
            //$ct1="";
            //if($sectrow1['sector_name']!=""){
            //    $ct1=$row1['ct'];
            //}
                
                //echo($sect_name);                                
            //}
        $data[] = array(++$sNo,
            $row['applicant_name'],
            $row['org_name'],
            $row['email_id'],
            $row['mobile'],
            $sect_name, 
            $subsect_name, 
            $quest,
            $docs,
            $row['entry_date'],
            "<i class=\"fa fa-retweet btn-primary btn-xs\" cdata-frmT='4' data-uid='$row[applicant_id]' title='Reset Password'></i>",
			//$ct1,              
            //$dis,
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