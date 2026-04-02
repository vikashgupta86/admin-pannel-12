<?php
$rs=simplefetch("select tf.t_id,tt.t_temp_id,tt.tender_name,tt.close_time,ifnull(date_format(tt.pub_date,'%M %d, %Y'),'N/A')as pub_date,tt.pub_time,ifnull(date_format(tt.close_date,'%M %d, %Y'),'N/A')as close_date,ifnull(date_format(tt.open_date,'%M %d, %Y'),'N/A')as open_date,tt.open_time,ifnull(date_format(tt.expiry_date,'%M %d, %Y'),'N/A')as expiry_date
         from web_tender_temp tt
INNER JOIN web_tender_final tf on tf.t_temp_id=tt.t_temp_id
 where tt.`status`='Active' and concat(tt.pub_date,' ',ifnull(tt.pub_time,'00:00:00'))<=CURRENT_TIMESTAMP() and concat(tt.close_date,' ',ifnull(tt.close_time,'00:00:00'))>=CURRENT_TIMESTAMP() /*and (tt.pub_date<=CURRENT_DATE() && case when tt.pub_time is null then 1=1 else tt.pub_time<=CURRENT_TIME() end) and (tt.close_date>=CURRENT_DATE() && case when tt.close_time is null then 1=1 else tt.close_time<=CURRENT_TIME() end)*/ and tt.corrigendum is null order by tt.t_temp_id DESC");
    ?>
    <table class="table table-hover table-bordered table-responsive">
        <thead>
            <th>S.No</th>
            <th>Title &amp; Ref.No</th>
            <th>Published Date</th>
            <th>Bid-Submission/ Closing Date</th>
            <th>Tender Opening Date</th>
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
                    $corCount=getNameQry("select count(tf.ct_id)as tot from web_tender_temp tt 
INNER JOIN web_tender_corrigendum_final tf on tf.t_temp_id=tt.t_temp_id 
where tt.`status`='Active' and tt.t_id=$row[t_id] and tt.corrigendum=1");
            ?>
            <tr>
                <td><?php echo ++$sNo;?></td>
                <td><?php echo $row['tender_name'];?></td>
                <td><?php echo $row['pub_date'].' '.$row['pub_time'];?></td>
                <td><?php echo $row['close_date'].' '.$row['close_time'];?></td>
                <td><?php echo $row['open_date'].' '.$row['open_time'];?></td>
                <td class="text-center"><?php echo empty($corCount)?'N/A':$corCount;?></td>
                <td class="text-center"><a href="javascript:void(0);" data-toggle="tooltip" title="View Details"><i  data-t_id=<?php echo $row['t_id'];?> class="fa fa-info-circle" aria-hidden="true" style="font-size: 25px;"></a></td>
            </tr>
            <?php
                }                
            }
            ?>            
            
        </tbody>
    </table>