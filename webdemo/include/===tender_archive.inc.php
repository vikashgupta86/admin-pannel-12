<?php
$rs=$obj->simplefetch("select tf.t_id,tt.t_temp_id,tt.tender_name,tf.expiry_time,tt.t_num,ifnull(date_format(tf.publish_date,'%M %d, %Y'),'N/A')as publish_date,tf.publish_time,ifnull(date_format(tf.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,ifnull(date_format(tt.close_date,'%M %d, %Y'),'N/A')as close_date,tt.close_time,ifnull(date_format(tt.expiry_date,'%M %d, %Y'),'N/A')as expirydate
         from web_tender_temp tt
INNER JOIN web_tender_final tf on tf.t_temp_id=tt.t_temp_id
 where (tt.`status`='Active' and tt.`dept_id`= $_GET[depid] and tt.`t_cat_id`= $_GET[catid] and concat(tf.publish_date,' ',ifnull(tf.publish_time,'00:00:00'))<=CURRENT_TIMESTAMP() and concat(tf.expiry_date,' ',ifnull(tf.expiry_time,'00:00:00'))<=CURRENT_TIMESTAMP() /*and (tt.pub_date<=CURRENT_DATE() && case when tt.pub_time is null then 1=1 else tt.pub_time<=CURRENT_TIME() end) and (tt.close_date>=CURRENT_DATE() && case when tt.close_time is null then 1=1 else tt.close_time<=CURRENT_TIME() end)*/ and tt.corrigendum is null) OR ( concat(tf.publish_date,' ',ifnull(tf.publish_time,'00:00:00'))>CURRENT_TIMESTAMP()) order by tt.t_temp_id DESC");
    ?>
    <table class="table table-hover table-bordered table-responsive">
        <thead>
            <th>S.No</th>
            <th>Tender Number</th>
            <th>Title &amp; Ref.No</th>
            <th><?php if($_REQUEST['catid']==3){?>Bid-submission / Closing Date and Time<?php }else{ ?>Date and Time<?php }?></th>
            <th>Publishing</th>
            <!--<th>Bid-Submission/ Closing Date</th>-->
            <th>Corrigendum/ Addendum</th>        
            <th>Details</th>
        </thead>
        <tbody>
            <?php
            $sNo=0;
            if($rs[0]<=0){
                echo "<tr><td colspan='7' class='text-center'>No Tender Found!</td></tr>";
            }
            else{
                foreach($rs[1] as $row){
                    $corCount=$obj->getNameQry("select ifnull(count(tf.ct_id),'N/A')as tot from web_tender_temp tt 
					INNER JOIN web_tender_corrigendum_final tf on tf.t_temp_id=tt.t_temp_id 
					where tt.`status`='Active' and tt.t_id=$row[t_id] and concat(tf.publish_date,' ',ifnull(tf.publish_time,'00:00:00'))<CURRENT_TIMESTAMP() and tt.corrigendum=1");
					
            if($corCount>0)
			{
			
					$cd=$obj->getNameQry("select concat(ifnull(date_format(tt.close_date,'%M %d, %Y'),'N/A'),' ',tt.close_time) as cd from web_tender_temp tt 
					INNER JOIN web_tender_corrigendum_final tf on tf.t_temp_id=tt.t_temp_id 
					where tt.`status`='Active' and tt.t_id=$row[t_id] and tt.corrigendum=1 order by tt.t_temp_id DESC");
					
			        $pd=$obj->getNameQry("select concat(ifnull(date_format(tf.publish_date,'%M %d, %Y'),'N/A'),' ',tf.publish_time) as ed from web_tender_temp tt 
					INNER JOIN web_tender_corrigendum_final tf on tf.t_temp_id=tt.t_temp_id 
					where tt.`status`='Active' and tt.t_id=$row[t_id] and  tt.corrigendum=1 and concat(tf.publish_date,' ',ifnull(tf.publish_time,'00:00:00'))<CURRENT_TIMESTAMP() order by tt.t_temp_id DESC");
			
					
			
			}else{
			
					$cd = $row['close_date'].' '.$row['close_time'];
					$pd = $row['publish_date'].' '.$row['publish_time'];
					
			}
					
					
            ?>
            <tr>
                <td><?php echo ++$sNo;?></td>
                <td><?php echo $row['t_num'];?></td>
                <td><?php echo $row['tender_name'];?></td>
                <td><?php echo $cd;?></td>
                <td><?php echo $pd;?></td>
                <!--<td><?php //echo $row['expiry_date'].' '.$row['expiry_time'];?></td>-->
                
                <td class="text-center"><?php echo empty($corCount)?'N/A':$corCount;?></td>
                <td class="text-center"><a href="javascript:void(0);" data-toggle="tooltip" title="View Details"><i data-t_id=<?php echo $row['t_id'];?> data-catid=<?php echo $_REQUEST['catid'];?> class="fa fa-info-circle" aria-hidden="true" style="font-size: 25px;"></a></td>
            </tr>
            <?php
                }                
            }
            ?>            
            
        </tbody>
    </table>