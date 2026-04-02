<!DOCTYPE HTML>
<html lang="en">
	<head>
        <?php
            $myVal = ['0', 'Bureau of Energy Efficiency (BEE)', '', '', ''];
            $lang = $_SESSION['lang'] ?? '';
            $lid  = $_GET['lid'] ?? null;
            if (empty($lid) && ($lang === '2' || $lang === '3')) {
                $myVal = ['0', '', '', '', ''];
            }
        ?>
        
        <?php
            header('Content-Type: text/html; charset=utf-8');
        ?>

        <meta charset="utf-8">
        <title><?php echo htmlspecialchars($myVal[1]); ?></title>
        <meta name="source" content="<?php echo htmlspecialchars($myVal[3]); ?>" />
        <meta name="author" content="<?php echo htmlspecialchars($myVal[3]); ?>" />
        <meta name="description" content="<?php echo htmlspecialchars($myVal[2]); ?>" />
        <meta name="keywords" content="<?php echo htmlspecialchars($myVal[4]); ?>" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
        <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" /> -->
        <link rel="stylesheet" href="../assets/lib/font-awesome/css/all.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
        <link rel="stylesheet" href="../assets/lib/animate/animate.min.css" />
        <link rel="stylesheet" href="../assets/lib/owlcarousel/assets/owl.carousel.min.css" />
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="../assets/lib/accessibility/style.css" />
        <link rel="stylesheet" href="../assets/css/style.css" />
        <link rel="stylesheet" href="../assets/css/custom.css" />
        <script src="../assets/js/jquery.min.js"></script>
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    </head>
    <body>    