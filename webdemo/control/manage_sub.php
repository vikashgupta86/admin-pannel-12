<?php 
    include '../appcode/globals.inc.php';
    include_once(BASE_PATH .'/control/include/include.inc.php');
    userAuthenticationPageLevel();
    userAuthenticationMainLevel();
    include_once('include/pageHeader.inc.php');
    include('include/top_user_info.inc.php'); 
?>
    
<h2 class="h5 content-header text-dark">Manage Sub Links</h2>

<?php 
    $showType=false;
    include('include/chooseLang.inc.php');

    $frmError= '';
    if(isset($_REQUEST['preSub']) && $_REQUEST['preSub']==1 && $frmError==false){
        $ShowGridFlage=true;
        ?>    
            <div class="form-box mt-3">                    
                <div class="panel panel-default">                        
                    <h4 class="">Set/ Unset Sublinks<?php echo $_SESSION['musume_type'] ?? ''; ?></h4>
                    <input type="hidden" name="lang_id" id="lang_id" value="<?php echo $_REQUEST['lang_id'];?>" />
                    <input type="hidden" name="nmnh_type_id_set" id="nmnh_type_id_set" value="<?php echo $_REQUEST['nmnh_type_id'];?>" />
                    <div>
                        <table style="border-width:0;" cellspacing="0" cellpadding="0">
                            <?php
                                if($_SESSION['user_type'] =='20'){

                                    //$condition=" and (ls.ls_id='75' || ls.entry_by='".$_SESSION['userid']."' || lt.nmnh_type='".$_SESSION['musume_type']."') ";
                                    $condition=" and (ls.entry_by='".$_SESSION['userid']."' || lt.nmnh_type='".$_SESSION['musume_type']."') ";
                                

                                    $rs=simplefetch("select nls.tot,ls.ls_id,ifnull(ls.link_level,0)as link_level,lf.lid,lt.link_name,lt.type_id,lt.lang_id,case when ls.position is null then '9999999999' else ls.position end as lPos from web_links_structure ls 
                                        INNER JOIN web_links_final lf on lf.lid=ls.lid
                                        INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
                                        LEFT JOIN (select count(ls_id)as tot,parent_ls_id from web_links_structure where STATUS='Active' and parent_ls_id is not null GROUP BY parent_ls_id) nls on nls.parent_ls_id=ls.ls_id
                                        where ls.`status`='Active' and ls.link_level is null and lt.lang_id=$_REQUEST[lang_id] $condition ORDER BY lt.link_name",1);


                                    /*$rs=simplefetch("select nls.tot,ls.ls_id,ifnull(ls.link_level,1)as link_level,lf.lid,lt.link_name,lt.type_id,lt.lang_id,case when ls.position is null then '9999999999' else ls.position end as lPos from web_links_structure ls 
                                        INNER JOIN web_links_final lf on lf.lid=ls.lid
                                        INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
                                        LEFT JOIN (select count(ls_id)as tot,parent_ls_id from web_links_structure where STATUS='Active' and parent_ls_id is not null GROUP BY parent_ls_id) nls on nls.parent_ls_id=ls.ls_id
                                        where ls.`status`='Active' and ls.link_level ='1' and lt.lang_id=$_REQUEST[lang_id] $condition ORDER BY lt.link_name",3);*/
                                } else {                        
                                    $rs=simplefetch("select nls.tot,ls.ls_id,ifnull(ls.link_level,0)as link_level,lf.lid,lt.link_name,lt.type_id,lt.lang_id,case when ls.position is null then '9999999999' else ls.position end as lPos from web_links_structure ls 
                                        INNER JOIN web_links_final lf on lf.lid=ls.lid
                                        INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
                                        LEFT JOIN (select count(ls_id)as tot,parent_ls_id from web_links_structure where STATUS='Active' and parent_ls_id is not null GROUP BY parent_ls_id) nls on nls.parent_ls_id=ls.ls_id
                                        where ls.`status`='Active' and ls.link_level is null and lt.lang_id=$_REQUEST[lang_id] and lt.content_type=$_REQUEST[nmnh_type_id] ORDER BY lt.link_name",1);
                                }

                            
                                if($rs[0]<=0) {
                                    echo "<tr><td class='text-danger'>As yet there is no Mainlink available!</td></tr>";
                                } else {
                                    foreach($rs[1] as $row){
                                        $SetSubClass=$expClass=$imgName='';

                                        switch($row['type_id']){
                                            case 1:
                                                $SetSubClass='btn disabled none';
                                                $imgName='assets/images/no_sub.gif';
                                                $glypIcon='<i class="fa fa-file-o" aria-hidden="true"></i>';
                                            break;
                                            
                                            case 2:
                                                $SetSubClass='btn disabled none';
                                                $imgName='assest/images/no_sub.gif';
                                                $glypIcon='<i class="fa fa-location-arrow" aria-hidden="true"></i>';
                                            break;

                                            case 3:
                                                $expClass='showTab';
                                                $SetSubClass='enable setSubLink';
                                                $imgName='assets/images/expand.gif';
                                                $glypIcon='<i class="fa fa-desktop" aria-hidden="true"></i>';
                                            break;
                                        }
                                        
                                        if(empty($row['tot'])){
                                            $imgName='assets/images/no_sub.gif';
                                        }
                                        ?>
                                        <tr>
                                            <td class=""><?php //echo "0".$row['ls_id'];?>                                                                                
                                                <input type="image" src="<?php echo $imgName;?>" alt="View List" title="View List" id="img_<?php echo $row['link_level'].$row['ls_id'] ?>" data-id="<?php echo $row['link_level'].$row['ls_id'] ?>" class="<?php echo $expClass;?>" />&nbsp;
                                                <span class="<?php echo $SetSubClass;?>" href="#" data-lsid="<?php echo $row['ls_id']?>" link-levl="<?php echo $row['link_level'];?>" link-lid="<?php echo $row['lid']?>" title="<?php echo html_entity_decode($row['link_name'])?>"><?php echo html_entity_decode($row['link_name'])?>
                                                <?php echo $glypIcon;?></span>
                                            </td>
                                        </tr>
                                        <?php
                                    if($row['type_id']==3)
                                        showChild($row['ls_id'],$row['link_level'],$row['lid'],$_REQUEST['per_id']);
                                    }
                                }
                            ?>
                            <tr>
                                
                        </tr>
                    </table>
                </div>                        
            </div>
            <div id="ShowMsg1"></div>                    
            <div id="reloadGrid"></div>    
         <?php
    }
?>                

<script type="text/javascript">
    $(function(){
        $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() {
            mGridTable.ajax.reload( null, false );
        });
        
        
        $('.setSubLink').click(function(){
            var lsid=$(this).data('lsid');
            var l_level=($(this).attr('link-levl')!=undefined)?$(this).attr('link-levl'):'';
            var lid=($(this).attr('link-lid')!=undefined)?$(this).attr('link-lid'):'';
            var nmnh_type=$('#nmnh_type_id_set').val();
            $('.modal-container').OpenPop({
                url:"setSub_links.php?lsid="+lsid+"&lid=" + lid +"&level=" + l_level + "&nmnh_type="+ nmnh_type+"&lang_id=<?php echo "$_REQUEST[lang_id]";?>&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                title: 'Set / Unset Sublink'
            });
        })
        
        
        $('.showTab').click(function(){
            //console.log($(this).data('id'))
            sId=$(this).data('id');                
            if($('#tab_'+sId).is(':visible')){
                //console.log('yes');
                $('#img_'+sId).attr({'src':'assets/images/expand.gif'});
                $('#tab_'+sId).hide();
            }
            else{
                //console.log('no');
                $('#img_'+sId).attr({'src':'assets/images/collapse.gif'});
                $('#tab_'+sId).show();
                
            }
            
        })
    })
</script>
<?php include('include/pageFooter.inc.php');?>
