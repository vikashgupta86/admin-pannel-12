<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);
$subQry=(isset($_REQUEST['lid']) && $_REQUEST['lid']!='-1')?" and lf.lid=$_REQUEST[lid]":'';
$rs = simplefetch("select wlt.link_temp_id,lf.icon_name/*,ls.ls_id,ls.pos_id,ls.position,ls.uplink,ls.up_position,case when ls.ls_id is not null then 'checked=\"\"' else '' end as mainLinkChk, case when ls.uplink=1 then 'checked=\"\"' else '' end as upLinkChk*/, lf.lid,lt.type,l.lang,concat(wlt.link_name, ifnull(concat(' (', wlt.link_alias, ')'),'')) as link_name,ifnull(date_format(wlt.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,ifnull(date_format(lf.publish_date,'%M %d, %Y'),'N/A')as publish_date from web_links_final lf
INNER JOIN web_link_temp wlt on wlt.link_temp_id=lf.link_temp_id
INNER JOIN web_lang l on l.lang_id=wlt.lang_id
INNER JOIN web_link_type lt on lt.type_id=wlt.type_id
/*INNER JOIN (select * from web_links_structure where status='Active') ls on ls.lid=lf.lid*/
where wlt.status='Active' and lf.`status`='Active' and wlt.continuous_content=0 and wlt.type_id=$_REQUEST[type_id] and wlt.lang_id=$_REQUEST[lang_id] /*and wlt.nmnh_type=$_REQUEST[nmnh_type]*/ $subQry order by lt.type/*,ls.position*/, wlt.link_name $LimitQry");
        if($rs[0]>0){
            $LinkStr='<option value=\'-1\'>Choose Any</option>';                                    
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){
                $dClass='disabled';
                $attr='disabled=\"\"';
                if(!empty($row['ls_id'])){
                    $dClass=$attr='';
                }
                
                if(empty($row['icon_name'])){
                    $icon="<i class=\"fas fa-images\" aria-hidden=\"true\"></i>";
                    $action="<i class=\"fas fa-plus-square\" cdata-frmT='1' pub-lid='$row[lid]' data-link_temp_id='$row[link_temp_id]' title='Add Icon' aria-hidden='true'></i>";
                }
                else{
                    $icon="<img src=\"../WriteReadData/IC1425/$row[icon_name]\" class=\"img-circle\" alt=\"Link Icon\" width=\"50\" height=\"50\">";
                    $action="<i class=\"fa fa-edit\" cdata-frmT='2' pub-lid='$row[lid]' data-link_temp_id='$row[link_temp_id]' title='Modify Icon' aria-hidden='true'></i>
                            <i class=\"fa fa-trash-o\" cdata-frmT='3' data-lid='$row[lid]' title='Remove Icon' aria-hidden='true'></i>";
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
        
        $recordsTotal = getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");
        $recordsFiltered = getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");
$resData=array(
    "draw"=>isset ( $request['draw'] ) ?intval( $request['draw'] ) :0,
    "recordsTotal"  => intval( $recordsTotal ),
	"recordsFiltered"  => intval( $recordsFiltered ),
	"data" =>  $data
);
echo frm_response($resData,true,false);