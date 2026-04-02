<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);
$usr_session='';

/*if($_SESSION['user_type'] =='20'){

     $usr_session= " and (wlt.entry_by='".$_SESSION['userid']."' || wlt.nmnh_type='".$_SESSION['musume_type']."')";
}
else{
	
	$usr_session= " and wlt.nmnh_type=".$_REQUEST['nmnh_type_id_sub'];
	
}*/


if(isset($_REQUEST['nmnh_type_id_sub']) && $_SESSION['user_type'] !='20'){


    $cont_type = $_REQUEST['nmnh_type_id_sub']=='-1' ? 0 : $_REQUEST['nmnh_type_id_sub'];
    
    $usr_session= " and wlt.content_type='$cont_type'";
}



$CharBlock=(isset($_REQUEST['level']) && $_REQUEST['level']==0)?true:false;
$rs=simplefetch("select ls.show_char,lt.type_id,case when ls.position is null then '0' else ls.position end as newPos,ls.ls_id,ls.pos_id,ls.position,ls.uplink,ls.up_position,case when ls.ls_id is not null then 'checked=\"\"' else '' end as subLinkChk, case when ls.uplink=1 then 'checked=\"\"' else '' end as upLinkChk, lf.lid,lt.type,l.lang,concat(wlt.link_name, ifnull(concat(' (', wlt.link_alias, ')'),'')) as link_name,ifnull(date_format(wlt.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,ifnull(date_format(lf.publish_date,'%M %d, %Y'),'N/A')as publish_date from web_links_final lf
INNER JOIN web_link_temp wlt on wlt.link_temp_id=lf.link_temp_id
INNER JOIN web_lang l on l.lang_id=wlt.lang_id
INNER JOIN web_link_type lt on lt.type_id=wlt.type_id
LEFT JOIN (select * from web_links_structure where status='Active' and lid!=$_REQUEST[lid] and link_level is not null and parent_ls_id=$_REQUEST[lsid]) ls on ls.lid=lf.lid
where lf.`status`='Active' and wlt.continuous_content=0 and wlt.lang_id=$_REQUEST[lang_id] and lf.lid!=$_REQUEST[lid] $usr_session order by newPos+0 DESC, wlt.link_name $LimitQry",1);
        if($rs[0]>0){               
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){
                $dClass='disabled';
                $attr='disabled=\"\"';
                if(!empty($row['ls_id'])){
                    $dClass=$attr='';
                }
                
                
                    $chrBlock=($CharBlock==true && $row['type_id']==3)?
                        "<div class=\"text-center\">
                            <input type=\"text\" class=\"btn form-control $dClass\" $attr name=\"chr_$row[lid]\" id=\"chr_$row[lid]\" placeholder=\"Characters\" value=\"$row[show_char]\" size='3' data-validate=\"chr_$row[lid]|text|n|1|10|num|Please enter Valid character limit!\"/>
                        </div>":'';
                
                $data[] = array(++$sNo,
                    html_entity_decode($row['link_name']),                    
                    $row['type'],
                    $row['lang'],
                    $row['publish_date'],
                    $row['expiry_date'],
                    "<div class=\"text-center\"><input type=\"checkbox\" name=\"sChk[]\" id=\"sChk_$row[lid]\" value=\"$row[lid]\" $row[subLinkChk] /></div>",                    
                    "<div class=\"text-center\">
                        <input type=\"text\" class=\"btn form-control $dClass\" $attr name=\"pos_$row[lid]\" id=\"pos_$row[lid]\" placeholder=\"Position\" value=\"$row[position]\" size='3' data-validate=\"pos_$row[lid]|text|y|1|10|num|Please enter Valid Position!\"/>
                    </div>",
                    $chrBlock,
                );
            }
        }
        
        $recordsTotal=getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");
        $recordsFiltered=getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");
$resData=array(
    "draw"=>isset ( $request['draw'] ) ?intval( $request['draw'] ) :0,
    "recordsTotal"  => intval( $recordsTotal ),
	"recordsFiltered"  => intval( $recordsFiltered ),
	"data" =>  $data
);
echo frm_response($resData,true,false);