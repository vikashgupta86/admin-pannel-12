<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

$usr_session='';
$nmnh_type = filter_input(INPUT_POST, 'nmnh_type', FILTER_VALIDATE_INT);
$lang_id = filter_input(INPUT_POST, 'lang_id', FILTER_VALIDATE_INT);
$custom_view = $_REQUEST['custom_view'] ?? ''; 
$subQry = '';
$recordsTotal = '';
$recordsFiltered = '';
$type_id = filter_input(INPUT_POST, 'type_id', FILTER_VALIDATE_INT);

if($_SESSION['user_type'] =='20'){

$usr_session= " and (wlt.entry_by='".$_SESSION['userid']."' || wlt.nmnh_type='".$_SESSION['musume_type']."')";
}

if(isset($_REQUEST['nmnh_type']) && $_SESSION['user_type'] !='20'){


    $cont_type = $nmnh_type == '-1' ? 0 : $nmnh_type;

    // $cont_type = $_REQUEST['nmnh_type']=='-1' ? 0 : $_REQUEST['nmnh_type'];
    
    $usr_session= " and wlt.content_type='$cont_type'";
    }

    $dept_type_id = $_REQUEST['dept_type_id'] ?? 0;

switch($custom_view)
{
    case 1:
            $subQry=(isset($custom_view) && $custom_view==1) ? ' and ls.ls_id is not null and ls.pos_id in(4,9)':'';
        $rs=simplefetch("select clf.cus_lid,ls.ls_id,ls.pos_id,case when clf.position is null then '999999999' else clf.position end as TempPos,clf.position,ls.uplink,ls.up_position,case when clf.cus_lid is not null then 'checked=\"\"' else '' end as mainLinkChk, case when ls.uplink=1 then 'checked=\"\"' else '' end as upLinkChk, lf.lid,lt.type,l.lang,concat(wlt.link_name, ifnull(concat(' (', wlt.link_alias, ')'),'')) as link_name,ifnull(date_format(wlt.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,ifnull(date_format(lf.publish_date,'%M %d, %Y'),'N/A')as publish_date from web_links_final lf
INNER JOIN web_link_temp wlt on wlt.link_temp_id=lf.link_temp_id
INNER JOIN web_lang l on l.lang_id=wlt.lang_id
INNER JOIN web_link_type lt on lt.type_id=wlt.type_id
LEFT JOIN (select * from web_links_structure where status='Active' and link_level is null) ls on ls.lid=lf.lid
LEFT JOIN (select * from web_links_final_cus where status='Active' and user_id = ".$_SESSION['userid'].") clf on clf.lid=lf.lid
where wlt.`status`='Active' and lf.`status`='Active' and wlt.continuous_content=0 and wlt.lang_id = ".$lang_id." AND wlt.content_type = ". $dept_type_id ." $subQry order by ls.pos_id, TempPos+0, wlt.link_name $LimitQry",1);

//         $subQry=(isset($_REQUEST['custom_view']) && $_REQUEST['custom_view']==1)?' and ls.ls_id is not null and ls.pos_id in(4,9)':'';
//         $rs=simplefetch("select clf.cus_lid,ls.ls_id,ls.pos_id,case when clf.position is null then '999999999' else clf.position end as TempPos,clf.position,ls.uplink,ls.up_position,case when clf.cus_lid is not null then 'checked=\"\"' else '' end as mainLinkChk, case when ls.uplink=1 then 'checked=\"\"' else '' end as upLinkChk, lf.lid,lt.type,l.lang,concat(wlt.link_name, ifnull(concat(' (', wlt.link_alias, ')'),'')) as link_name,ifnull(date_format(wlt.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,ifnull(date_format(lf.publish_date,'%M %d, %Y'),'N/A')as publish_date from web_links_final lf
// INNER JOIN web_link_temp wlt on wlt.link_temp_id=lf.link_temp_id
// INNER JOIN web_lang l on l.lang_id=wlt.lang_id
// INNER JOIN web_link_type lt on lt.type_id=wlt.type_id
// LEFT JOIN (select * from web_links_structure where status='Active' and link_level is null) ls on ls.lid=lf.lid
// LEFT JOIN (select * from web_links_final_cus where status='Active' and user_id=$_SESSION[userid]) clf on clf.lid=lf.lid
// where wlt.`status`='Active' and lf.`status`='Active' and wlt.continuous_content=0 and wlt.lang_id=$_REQUEST[lang_id] $subQry order by ls.pos_id, TempPos+0, wlt.link_name $LimitQry",1);
        if($rs[0]>0){
            $LinkStr='<option value=\'-1\'>Choose Any</option>';
            $rs1=fetchtable("web_st_link_position");                        
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){
                if($rs1[0]>0){
                    foreach($rs1[1] as $row1){
                        if($row['pos_id']==$row1['pos_id'])
                            $LinkStr.="<option value='$row1[pos_id]' selected=''>$row1[position]</option>";
                        else
                            $LinkStr.="<option value='$row1[pos_id]'>$row1[position]</option>";
                    }
                }
                $dClass='disabled';
                $attr='disabled=\"\"';
                if(!empty($row['cus_lid'])){
                    $dClass=$attr='';
                }
                
                
                $data[] = array(++$sNo,
                    html_entity_decode($row['link_name']),                    
                    $row['type'],
                    $row['lang'],
                    $row['publish_date'],
                    $row['expiry_date'],
                    "<div class=\"text-center\"><input type=\"checkbox\" name=\"mChk[]\" id=\"mChk_$row[lid]\" value=\"$row[lid]\" $row[mainLinkChk] /></div>",
                    /*"<div class=\"text-center\">
                        <select name=\"pos_id_$row[lid]\" id=\"pos_id_$row[lid]\" class=\"btn form-control $dClass\" $attr data-validate=\"pos_id_$row[lid]|text|y|1|10|num|dontselect=-1|Please enter Valid option!\">
                        $LinkStr
                        </select>
                    </div>",*/
                    "<div class=\"text-center\">
                        <input type=\"text\" class=\"btn form-control $dClass\" $attr name=\"pos_$row[lid]\" id=\"pos_$row[lid]\" placeholder=\"Position\" value=\"$row[position]\" size='3' data-validate=\"pos_$row[lid]|text|y|1|10|num|Please enter Valid Position!\"/>
                    </div>",
                    /*"<div class=\"text-center\"><input type=\"checkbox\"  class=\"btn $dClass\" $attr name=\"Tchk_$row[lid]\" id=\"Tchk_$row[lid]\" value=\"$row[lid]\" $row[upLinkChk]/></div>",
                    "<div class=\"text-center\">
                        <input type=\"text\" class=\"btn form-control $dClass\" $attr name=\"Tpos_$row[lid]\" id=\"Tpos_$row[lid]\" placeholder=\"Position\" value=\"$row[up_position]\" size='3' data-validate=\"Tpos_$row[lid]|text|y|1|500|alnum_spc|Please enter Valid Link Name!\"/>
                    </div>",*/
                );
                
                $LinkStr='<option value=\'-1\'>Choose Any</option>';
            }
        }
        
        $recordsTotal=getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");
        $recordsFiltered=getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");
    break;
    case '2':
        $rs=simplefetch("select ls.ls_id,ls.pos_id,case when ls.position is null then '999999999' else ls.position end as TempPos,ls.position,ls.uplink,ls.up_position,case when ls.ls_id is not null then 'checked=\"\"' else '' end as mainLinkChk, case when lf.new_icon=1 then 'checked=\"\"' else '' end as newLinkChk, lf.lid,lt.type,l.lang,concat(wlt.link_name, ifnull(concat(' (', wlt.link_alias, ')'),'')) as link_name,ifnull(date_format(wlt.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,ifnull(date_format(lf.publish_date,'%M %d, %Y'),'N/A')as publish_date, ifnull(date_format(lf.new_icon_date,'%M %d, %Y'),'N/A')as new_icon_date from web_links_final lf
        INNER JOIN web_link_temp wlt on wlt.link_temp_id=lf.link_temp_id
        INNER JOIN web_lang l on l.lang_id=wlt.lang_id
        INNER JOIN web_link_type lt on lt.type_id=wlt.type_id
        LEFT JOIN (select * from web_links_structure where status='Active' and link_level is null) ls on ls.lid=lf.lid
        where wlt.`status`='Active' and lf.`status`='Active' and wlt.continuous_content=0 and wlt.lang_id = ".$lang_id." AND wlt.content_type = ".$dept_type_id ." $subQry order by ls.pos_id DESC, TempPos+0, wlt.link_name $LimitQry",1);
                if($rs[0]>0){
                    $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
                    foreach($rs[1] as $row){                        
                        $dClass='disabled';
                        $attr='disabled=\"\"';
                        if(!empty($row['lid'])){
                            $dClass=$attr='';
                        }
                        
                        
                        $data[] = array(++$sNo,
                            html_entity_decode($row['link_name']),                    
                            $row['type'],
                            $row['lang'],
                            $row['publish_date'],
                            $row['expiry_date'],                                                        
                            $row['new_icon_date'],                                                        
                            
                            "<div class=\"text-center\"><input type=\"checkbox\" name=\"nChk[]\" id=\"mChk_$row[lid]\" value=\"$row[lid]\" $row[newLinkChk] /></div>",
                        );                        
                        
                    }
                }
        break;
    default:

        $rs=simplefetch("select ls.ls_id,ls.pos_id,case when ls.position is null then '999999999' else ls.position end as TempPos,ls.position,ls.uplink,ls.up_position,case when ls.ls_id is not null then 'checked=\"\"' else '' end as mainLinkChk, case when ls.uplink=1 then 'checked=\"\"' else '' end as upLinkChk, lf.lid,/*lt.type,*/l.lang,concat(wlt.link_name, ifnull(concat(' (', wlt.link_alias, ')'),'')) as link_name,ifnull(date_format(wlt.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,ifnull(date_format(lf.publish_date,'%M %d, %Y'),'N/A')as publish_date from web_links_final lf
        INNER JOIN web_link_temp wlt on wlt.link_temp_id=lf.link_temp_id
        INNER JOIN web_lang l on l.lang_id=wlt.lang_id
        /*INNER JOIN web_link_type lt on lt.type_id=wlt.type_id*/
        LEFT JOIN (select * from web_links_structure where status='Active' and link_level is null) ls on ls.lid=lf.lid
        where wlt.`status`='Active' and lf.`status`='Active' and wlt.continuous_content=0 and wlt.lang_id= ".$lang_id." AND wlt.content_type = ".$dept_type_id ." $subQry $usr_session order by ls.pos_id DESC, TempPos+0, wlt.link_name $LimitQry",1);
        
                if($rs[0]>0){
                    $LinkStr='<option value=\'-1\'>Choose Any</option>';
                    $rs1=fetchtable("web_st_link_position");                        
                    $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
                    foreach($rs[1] as $row){
                        if($rs1[0]>0){
                            foreach($rs1[1] as $row1){
                                if($row['pos_id']==$row1['pos_id'])
                                    $LinkStr.="<option value='$row1[pos_id]' selected=''>$row1[position]</option>";
                                else
                                    $LinkStr.="<option value='$row1[pos_id]'>$row1[position]</option>";
                            }
                        }
                        $dClass='disabled';
                        $attr='disabled=\"\"';
                        if(!empty($row['ls_id'])){
                            $dClass=$attr='';
                        }
                        
                        
                        $data[] = array(++$sNo,
                            html_entity_decode($row['link_name']),                    
                            $row['type'] ?? 'N/A',
                            $row['lang'],
                            $row['publish_date'],
                            $row['expiry_date'],
                            "<div class=\"text-center\"><input type=\"checkbox\" name=\"mChk[]\" id=\"mChk_$row[lid]\" value=\"$row[lid]\" $row[mainLinkChk] /></div>",
                            "<div class=\"text-center\">
                                <select name=\"pos_id_$row[lid]\" id=\"pos_id_$row[lid]\" class=\"btn form-control $dClass\" $attr data-validate=\"pos_id_$row[lid]|text|y|1|10|num|dontselect=-1|Please enter Valid option!\">
                                $LinkStr
                                </select>
                            </div>",
                            "<div class=\"text-center\">
                                <input type=\"text\" class=\"btn form-control $dClass\" $attr name=\"pos_$row[lid]\" id=\"pos_$row[lid]\" placeholder=\"Position\" value=\"$row[position]\" size='3' data-validate=\"pos_$row[lid]|text|y|1|10|num|Please enter Valid Position!\"/>
                            </div>",
                            "<div class=\"text-center\"><input type=\"checkbox\"  class=\"btn $dClass\" $attr name=\"Tchk_$row[lid]\" id=\"Tchk_$row[lid]\" value=\"$row[lid]\" $row[upLinkChk]/></div>",
                            "<div class=\"text-center\">
                                <input type=\"text\" class=\"btn form-control $dClass\" $attr name=\"Tpos_$row[lid]\" id=\"Tpos_$row[lid]\" placeholder=\"Position\" value=\"$row[up_position]\" size='3' data-validate=\"Tpos_$row[lid]|text|y|1|500|alnum_spc|Please enter Valid Link Name!\"/>
                            </div>",
                        );
                        
                        $LinkStr='<option value=\'-1\'>Choose Any</option>';
                    }
                }
                
                $recordsTotal=getNameQry("select count(wu.user_id)  from web_users wu
                INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
                 where wu.status='Active' and wu.user_id!=1");
                $recordsFiltered=getNameQry("select count(wu.user_id)  from web_users wu
                INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
                 where wu.status='Active' and wu.user_id!=1");
    break;
}

$resData=array(
    "draw"=>isset ( $request['draw'] ) ?intval( $request['draw'] ) :0,
    "recordsTotal"  => intval( $recordsTotal ),
	"recordsFiltered"  => intval( $recordsFiltered ),
	"data" =>  $data
);
echo frm_response($resData,true,false);