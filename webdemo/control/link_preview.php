<?php 
    include '../appcode/globals.inc.php';
    include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
    AjaxFilePrevent();

    //$rs=simplefetch("select wlt.* from web_link_temp wlt where wlt.`status`='Active' and wlt.link_temp_id=$_GET[link_temp_id]");

    $link_temp_id = (int)$_GET['link_temp_id'];

    $rsqru = "SELECT wlt.* from web_link_temp wlt where wlt.`status`='Active' and wlt.link_temp_id = ? ";
    $rs = simplefetch($rsqru, "i", [$link_temp_id]);

    if($rs[1]>0){
        foreach($rs[1] as $row){
            switch($row['type_id']){
                case 1:
    #               $fname=$row['link_name'].'.'.end(explode('.',$row['file_name']));

                    $file = basename($row['file_name']);
                    $baseDir = "../WriteReadData/L45218/";
                    $path = $baseDir . $file;

                    if (!file_exists($path)) {
                        exit("File not found");
                    }

                    $ext  = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    $mime = mime_content_type($path);

                    $imgTypes = ['jpg','jpeg','png','gif','webp'];
                    $pdfTypes = ['pdf'];

                    echo '<div class="w-100 h-100 text-center">';
                    if (in_array($ext, $imgTypes) || in_array($ext, $pdfTypes)) {
                        $data = base64_encode(file_get_contents($path));
                        $src  = "data:$mime;base64,$data";
                        if (in_array($ext, $imgTypes)) {
                            echo '<img src="'.$src.'" class="w-100 h-100 border-0">';
                        } elseif (in_array($ext, $pdfTypes)) {
                            echo '<iframe src="'.$src.'" class="w-100 h-100 border-0"></iframe>';
                        }
                    } else {
                        echo '<p>This file cannot be previewed.</p>';
                        echo '<a class="btn btn-primary" href="'.$path.'" download>Download File</a>';
                    }
                    echo '</div>';
                    echo '<div class="modal-footer in-modal-body mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>';

                break;

                case 2:

                ?>
                <script type="text/javascript">
                    function openMe(url){
                        if(url.search(".nic")<=0 && url.search(".gov")<=0){
                            alert("You are being redirected to a link which is outside NIC domain")
                        }
                        location.href=url;
                    }    
                    openMe('<?php echo $row['url'];?>');
                </script>
                <?php
                break;

                case 3:

                if(empty($row['details']))
                    echo "<div class='alert alert-info'>No Data Available!<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a></div>";
                else {
                    // rtfPathManage($row['details'],false);
                     echo _html_entity_decode($row['details']) ?? '';
                }
                ?>
                <div class="modal-footer in-modal-body">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>                
                </div>                
                <?php
                break;
            }
        }
    }
    ?>