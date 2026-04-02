<?php 

$_REQUEST['lang_id'] = $_REQUEST['lang_id'] ?? 1; 
$_REQUEST['lid'] = $_REQUEST['lid'] ?? 1; 

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />        	
	<title><?php echo $title ?? ''; ?></title>
    <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>    

    <link rel="stylesheet" href="../control/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../control/assets/vendor/DataTables/datatables.min.css">
    <link rel="stylesheet" href="../control/assets/vendor/font-awesome/css/all.min.css" />
    <link rel="stylesheet" href="../control/assets/css/style.css" />
    <script src="../control/assets/js/jquery.min.js"></script>
    <script src="../control/assets/vendor/DataTables/datatables.min.js"></script>

    
    <script type = "text/javascript">
        window.addEventListener('beforeunload', function () {
        fetch('/destroy-session', {
            method: 'POST',
            credentials: 'same-origin'
        }).catch(err => {
            console.error('Failed to destroy session:', err);
        });
    });
</script>
</head>