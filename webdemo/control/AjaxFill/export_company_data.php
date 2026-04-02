<?php include '../../appcode/globals.inc.php';
//require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
//$obj->AjaxFilePrevent();
//$obj->userAuthenticationPageLevel();

if(isset($_SESSION['per_id']) && isset($_SESSION['EncTok']))
{
    $rs=$obj->simplefetch("SELECT * FROM applicant_register WHERE status ='Active' order by entry_date desc, freeze_date desc",1);
    if($rs[0]>0)
    {
        $delimiter = ","; 
        $filename = "company-data_" . date('Y-m-d') . ".csv"; 
        
        // Create a file pointer 
        $f = fopen('php://memory', 'w'); 
        
        // Set column headers 
        $fields = array('ID', 'Applicant ID', 'Applicant Name', 'Organization Name', 'Email', 'Mobile', 'Sector', 'Sub-Sector', 'upload_status', 'Questionnaire Document', 'Other uploaded Document', 'freeze_date', 'Registration Date'); 
        fputcsv($f, $fields, $delimiter); 
        $sno = 1;
        
        // Output each row of the data, format line as csv and write to file pointer 
        foreach($rs[1] as $row)
        { 
            $sno++;
            $export_sect=$obj->simplefetch("select * from neca_sectors where sector_id=$row[sector_id] and status ='Active'",1);
            foreach($export_sect[1] as $export_sectrow1)
            {
                $export_sect_name = $export_sectrow1['sector_name'];               
            }

            $export_subsect=$obj->simplefetch("select * from neca_subsectors where subsector_id=$row[subsector_id] and status ='Active'",1);
            foreach($export_subsect[1] as $export_subsectrow1)
            {
                $export_subsect_name = $export_subsectrow1['subsector_name'];               
            }

            if ($row['upload_status']==1)
            {
                $quest="".$_SERVER['SERVER_NAME']."/neca_awards/WriteReadData/quest/". $row['applicant_id'] ."/". $row['quest_file'] ."";
            
            
                $docs=$obj->simplefetch("select * from applicant_documents where applicant_id=$row[applicant_id] and notice_id=$row[notice_id] and status ='Active'",1);
                if($docs[0]>0)
                { 
                    foreach($docs[1] as $docsrow1)
                    {
                        $docsurl="";
                        $docsurl="".$_SERVER['SERVER_NAME']."/neca_awards/WriteReadData/app_docs/". $row['applicant_id'] ."/". $docsrow1['doc_file'] ."";
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

            $lineData = array($sno, $row['applicant_id'], $row['applicant_name'], $row['org_name'], $row['email_id'], $row['mobile'], $export_sect_name, $export_subsect_name,$row['upload_status'],$quest, $docsurl, $row['freeze_date'], $row['entry_date']); 
            fputcsv($f, $lineData, $delimiter); 
        } 
        
        // Move back to beginning of file 
        fseek($f, 0); 
        
        // Set headers to download file rather than displayed 
        header('Content-Type: text/csv'); 
        header('Content-Disposition: attachment; filename="' . $filename . '";'); 
        
        //output all remaining data on a file pointer 
        fpassthru($f);

        exit;

    }
}
else
{
    echo "<script>alert('Somthing Went Wrong !')</script>";
    echo "<script>location.assign('companies.php?per_id=".$_REQUEST['per_id']."&EncHid=".$_SESSION['EncTok']."')</script>";
}





