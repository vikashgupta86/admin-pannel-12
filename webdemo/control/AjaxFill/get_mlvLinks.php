<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);

$LimitQry=$sspObj->limit($_GET);
$subQry=(isset($_REQUEST['lid']) && $_REQUEST['lid']!='-1')?" and lf.lid=$_REQUEST[lid]":'';
$rs=$obj->simplefetch("select lf.sub_ltot,lf.char_num,case when lf.show_lName=1 then 'Yes' else 'No' end lShow,case when lf.marquee=1 then 'Yes' else 'No' end marqFlage,lf.view_type,lf.icon_name,ls.ls_id,ls.pos_id,ls.position,ls.uplink,ls.up_position,case when ls.ls_id is not null then 'checked=\"\"' else '' end as mainLinkChk, case when ls.uplink=1 then 'checked=\"\"' else '' end as upLinkChk, lf.lid,lt.type,l.lang,wlt.link_name,ifnull(date_format(wlt.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,ifnull(date_format(lf.publish_date,'%M %d, %Y'),'N/A')as publish_date from web_links_final lf
INNER JOIN web_link_temp wlt on wlt.link_temp_id=lf.link_temp_id
INNER JOIN web_lang l on l.lang_id=wlt.lang_id
INNER JOIN web_link_type lt on lt.type_id=wlt.type_id
INNER JOIN web_links_structure ls on ls.lid=lf.lid
where lf.`status`='Active' and ls.status='Active' and ls.pos_id=4 and wlt.continuous_content=0 and ls.link_level is null and wlt.lang_id=$_REQUEST[lang_id] $subQry order by lt.type,ls.position, wlt.link_name $LimitQry");
        if($rs[0]>0){                                                
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){
                $dClass='disabled';
                $attr='disabled=\"\"';
                if(!empty($row['ls_id'])){
                    $dClass=$attr='';
                }
                
                if(empty($row['view_type'])){
                    $icon="N/A";
                    $action="<i class=\"fa fa-plus-square-o\" cdata-frmT='1' pub-lid='$row[lid]' data-link_temp_id='$row[link_temp_id]' title='Add Icon' aria-hidden='true'></i>";
                }
                else{
                    switch($row['view_type']){
                        case 1:#content view
                            $icon="<div class='text-left view-page'><b>View Type:</b> Content,<br><b>Show LinkName:</b> $row[lShow],<br><b>No of Char:</b> $row[char_num]</div>";
                        break;
                        
                        case 2:#sublink view
                            $icon="<div class='text-left view-page'><b>View Type:</b> Sublink,<br><b>Show LinkName:</b> $row[lShow],<br><b>Run Marquee:</b> $row[marqFlage],<br><b>No of Sublink:</b> $row[sub_ltot]</div>";
                        break;
                    }                    
                    $action="<i class=\"fa fa-edit\" cdata-frmT='2' pub-lid='$row[lid]' data-link_temp_id='$row[link_temp_id]' title='Modify Details' aria-hidden='true'></i>
                            <i class=\"fa fa-trash-o\" cdata-frmT='3' data-lid='$row[lid]' title='Delete User' aria-hidden='true'></i>";
                }
                
                $data[] = array(++$sNo,
                    html_entity_decode($row['link_name']),                    
                    $row['type'],
                    $row['lang'],
                    $row['publish_date'],
                    $row['expiry_date'],
                    "<div class=\"text-center\">$icon</div>",
                    "<div class=\"text-center tools\">$action</div>",
                );
                
                $LinkStr='<option value=\'-1\'>Choose Any</option>';
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
