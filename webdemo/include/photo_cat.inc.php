<div class="new-gallery">
<?php

		$HOST_FILE = $_ENV['HOST_FILE'] ?? '';

//echo("hi");
//$SubQry=(isset($_GET['vid']) && $_GET['vid']==1)?" and mt.type_of_media=2":" and mt.type_of_media=1";
$SubQry="";
require('appcode/ps_pagination.inc.php');
 $SubQry=(isset($_GET['vid']) && $_GET['vid']==1)?" and mt.type_of_media=2":" and mt.type_of_media=1";
 //$arch_qry = ((isset($_GET['varch']) && $_GET['varch']==1) && (isset($_GET['vid']) && $_GET['vid']==1))?"   and (mf.publish_date<current_date())":"";


if(isset($_GET['vid']) && $_GET['vid']==1){#in case viedo request
    //$ordBy=' GROUP BY mf.m_id  order by mf.m_id desc'; 
    $ordBy=' GROUP BY mc.m_cat_id order by mf.pos, mf.publish_date desc';    
}
else{ #show the photo gallery
    //$ordBy=' GROUP BY mc.m_cat_id order by mf.pos, mf.publish_date desc'; 
    $ordBy=' GROUP BY mc.m_cat_id order by mf.pos, mf.publish_date desc';     
}

$dynQry='  and mf.publish_date<=CURDATE()';

/*

$sql=("select mc.m_cat_id,mc.cat_name,mc.cat_name_h,mc.img_name,count(mt.m_temp_id)as tot,mf.m_id, mt.m_description, mt.image_name as vid_poster, mt.url, mt.type_of_media from web_media_category mc
INNER JOIN web_media_temp mt on mt.m_cat_id=mc.m_cat_id
INNER JOIN web_media_final mf on mf.m_temp_id=mt.m_temp_id
where mc.status='Active' and mf.status='Active' and mt.status='Active' $dynQry and mc.app_reject=1 and mc.banner_flage is null $SubQry  $ordBy");


$a="select mc.m_cat_id,mc.cat_name,mc.cat_name_h,mc.img_name,count(mt.m_temp_id)as tot,mf.m_id, mt.m_description, mt.image_name as vid_poster, mt.url, mt.type_of_media from web_media_category mc
INNER JOIN web_media_temp mt on mt.m_cat_id=mc.m_cat_id
INNER JOIN web_media_final mf on mf.m_temp_id=mt.m_temp_id
where mc.status='Active' and mf.status='Active' and mt.status='Active' $dynQry and mc.app_reject=1 and mc.banner_flage is null $SubQry  $ordBy";
// echo $a;
*/

$rs3=simplefetch("select mc.m_cat_id,mc.cat_name,mc.cat_name_h,mc.img_name,count(mt.m_temp_id)as tot,mf.m_id, mt.m_description, mt.image_name as vid_poster, mt.url, mt.type_of_media from web_media_category mc
INNER JOIN web_media_temp mt on mt.m_cat_id=mc.m_cat_id
INNER JOIN web_media_final mf on mf.m_temp_id=mt.m_temp_id
where mc.status='Active' and mf.status='Active' and mt.status='Active' $dynQry and mc.app_reject=1 /*and mc.banner_flage  is null */ $SubQry  $ordBy");
/*
$a="select mc.m_cat_id,mc.cat_name,mc.cat_name_h,mc.img_name,count(mt.m_temp_id)as tot,mf.m_id, mt.m_description, mt.image_name as vid_poster, mt.url, mt.type_of_media from web_media_category mc
INNER JOIN web_media_temp mt on mt.m_cat_id=mc.m_cat_id
INNER JOIN web_media_final mf on mf.m_temp_id=mt.m_temp_id
where mc.status='Active' and mf.status='Active' and mt.status='Active' $dynQry and mc.app_reject=1 and mc.banner_flage is null  $SubQry  $ordBy";
// echo $a;
*/

$_GET['vmod'] = $_GET['vmod'] ?? ''; 

$append.= "lang=$_SESSION[lang]&level=$_GET[level]&ls_id=$_GET[ls_id]&lid=$_GET[lid]&vmod=$_GET[vmod]";
$append.= !empty($_GET['vid'])?"&vid=$_GET[vid]":'';
//echo $sql;
//die;
$pages =new PS_Pagination($connection="", $sql, $rows_per_page = 16, $links_per_page = 5, $append );                     
$rs3[]=$pages->paginate();
//echo '<pre>';print_r($rs3);
if(isset($_REQUEST['page'])){$sno=$rs3[1];}
else{$sno=0;}
    
if($rs3[0]>0){
    echo "<div class='row photogallerymain'>";
    $lPos=1;
    $SubQry1 = $vidPlay = null;
    if(isset($_GET['vid']) && $_GET['vid']==1)
        $vidPlay = '<span style="position: absolute; margin: 25% 0px 0px 33%;" ><i class="fasu fa-play-circle-o fa-5" style="font-size:60px;"></i></span>';
        
    foreach($rs3[1] as $row){
//echo("hi");
        if(isset($_GET['vid']) && $_GET['vid']==1 && $row['type_of_media']==2){#in case viedo request            
            $clipName="$row[m_id]";

            //$row['cat_name'] = $row['m_description'];#overwright the cat name
            $vUrl = $row['url'];
            getYoutubeID($vUrl,null,array(),$vID);

            $post = "<img src='https://img.youtube.com/vi/$vID/0.jpg'>";
            
            
                            
            /*$frame = 10;            
            $movie = "WriteReadData/MD32145/btf.mp4";
            $thumbnail = "WriteReadData/PCAT8945/fram_{$row1[m_id]}.png";
            
            $mov = new ffmpeg_movie($movie);
            $frame = $mov->getFrame($frame);
            
            if ($frame) {
                $gd_image = $frame->toGDImage();
                if ($gd_image) {
                    imagepng($gd_image, $thumbnail);
                    imagedestroy($gd_image);
                    echo '<img src="'.$thumbnail.'">';
                }
            }*/            
        }
        else{#show the photo gallery            
	//echo("dsf");
            $clipName="$row[m_cat_id]";
			//echo "hi=" . $clipName;
            $post="<img src=\"WriteReadData/PCAT8945/$row[img_name]\" alt=\"\" />";            
        }
        
        $showMid=($rs3[0]==$lPos && $lPos++%4==1)?" col-md-offset-4":'';
        if($_SESSION['lang']=='2' || $_SESSION['lang']=='3'){
		$catTit=$row['cat_name_h'];	
		}else{
			$catTit=$row['cat_name'];
		}
		
        stringChunk($row['cat_name'],$nUse,130);
    ?>
    <div class="col-md-3 fancybox <?php echo $showMid;?>">        
        <a class="fancybox-thumb" rel="gallery<?php echo $clipName;?>" href="javascript:void(0);" data-toggle="tooltip"  title="<?php echo $catTit;?>">
            <?php //echo $vidPlay;?>
        	<!--<img src="WriteReadData/PCAT8945/<?php echo $row['img_name'];?>" alt="" />-->
            <?php echo $post;

            ?>
        </a>        
        <div class="CopyIcon" data-toggle="tooltip"  title="<?php echo $catTit;?>">
            <?php echo $catTit; ?><br/><?php if($_SESSION['lang']=='2' || $_SESSION['lang']=='3'){ 
			
			?> 
			<?php echo (isset($_GET['vid']) && $_GET['vid']==1)?'वीडियो':'फोटो'?> की संख्या : <?php echo $row['tot'];?>
			<?php } else { ?>No. of 
			<?php echo (isset($_GET['vid']) && $_GET['vid']==1)?'Video':'Photo'?>: <?php echo $row['tot'];?>
			<?php } ?> 
			</div>
        
        <?php
        $SubQry1="";
            if(isset($_GET['vid']) && $_GET['vid']==1){#in case viedo request
              //  $SubQry1=' and mf.m_id='."$row[m_id]";
            }
            /*else{#show the photo gallery                
            } */      
            $rs1=simplefetch("select mf.m_id,mt.m_temp_id,mt.image_name,mt.m_description,mt.url,mt.type_of_media from web_media_temp mt
            INNER JOIN web_media_final mf on mf.m_temp_id=mt.m_temp_id where mt.status='Active' $dynQry and mf.status='Active' and mt.m_cat_id=$row[m_cat_id] $SubQry $SubQry1 ");        
            $a="select mf.m_id,mt.m_temp_id,mt.image_name,mt.m_description,mt.url,mt.type_of_media from web_media_temp mt
            INNER JOIN web_media_final mf on mf.m_temp_id=mt.m_temp_id where mt.status='Active' $dynQry and mf.status='Active' and mt.m_cat_id=$row[m_cat_id] $SubQry $SubQry1 ";
            // echo $a;
            if($rs1[0]>0){
                echo '<div class="hidden">';                
                foreach($rs1[1] as $row1){
                    if((isset($_GET['vid']) && $_GET['vid']==1)){
                        if($row1['type_of_media']==2 && !empty($row1['url'])){  

                            getYoutubeID($row1['url'],NULL,array('autoplay'=>'1'));

                        ?>
                            <a  class="fancybox fancy-video" rel="gallery<?php echo $clipName;?>" title="<?php echo $row1['m_description']?>" href="<?php echo $row1['url'];?>"></a>
                        <?php
                        }
                        else if ($row1['type_of_media']==2 && empty($row1['url'])){                          

                        ?>
                        <div>
                            <video class="fancybox fancy-video" id="vid-1" rel="gallery<?php echo $clipName;?>" poster="" title="<?php echo $row1['m_description']?>" controls preload >
                                <source src="<?php echo $HOST_FILE; ?>WriteReadData/MD32145/<?php echo $row1['image_name'];?>" type="video/mp4">                
                            </video>
                        </div>
                        <?php
                        }
                    }
                    else{
                    ?>
                    <a  class="fancybox" rel="gallery<?php echo $clipName;?>" title="<?php echo $row1['m_description']?>" href="<?php echo $HOST_FILE; ?>WriteReadData/MD32145/<?php echo $row1['image_name'];?>">
                        <img src="<?php echo $HOST_FILE; ?>WriteReadData/MD32145/<?php echo $row1['image_name'];?>" alt=""/>
                    </a>
                    <?php
                    }
                }
        ?>
            
        <?php
                echo '</div>';            
        }
        ?>
    </div>
    <?php 

    echo ($lPos++%4==0) ? "</div><div class='row photogallerymain'>" : '';
    }
    echo "</div>";
    
//    if($rs3[0][4]>1){
//        echo '<div class="row text-center"> '. $pages->renderFullNav()  . '</div>';
//    }
}
?>
</div>
<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="assets/fancyBox/jquery.fancybox.pack.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="assets/fancyBox/jquery.fancybox.css?v=2.1.5" media="screen" />
<style>
.fancybox-nav{
    width: 10%;
    height: 80%;
}
.fancy-video{
    width: 600px;
    height: 500px;
}
.fasu {
    font: normal normal normal 14px/1 FontAwesome;
    color: #dcdcdc;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.hidden {
    display: none!important;
}

</style>
<script>
$(document).ready(function() {
    $(".CopyIcon").click(function(){
        $(this).siblings(".fancybox-thumb").trigger('click');        
    })
    $(".fancybox-thumb").click(function() {
        var gallery = []; // array of gallery elements
        var galCat = '';        
        $(".fancybox[rel='"+$(this).attr('rel')+"']").each(function(){            
            if($(this).hasClass('fancy-video')){
                galCat='Video';
                if( $(this).attr('poster') !== undefined){                    
                    gallery.push({'content':$(this).parent().html()}); // push element to the array
                }
                else{                    
                    gallery.push({'type': 'iframe','href':this.href.replace(new RegExp("watch\\?v=", "i"), 'v/')}); // push element to the array
                }
            }
            else{
                galCat='Image';
                gallery.push({'href':this.href,'title':this.title}); // push element to the array
            }            
                
        })
        
        $.fancybox.open(
            gallery,{                
                padding : 5,
                prevEffect	: 'fade',
		        nextEffect	: 'fade',
                beforeShow : function() {                    
                    this.title = galCat + ' ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
                },
                helpers	:{
                    /*title	: {
        				type: 'inside'
        			}*/
                }
            }
        );    
        return false;
    })        
});
</script>