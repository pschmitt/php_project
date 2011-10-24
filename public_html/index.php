<!DOCTYPE html>
<html>
<head>
	<title>JeNeSaisPasCuisiner.com</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" media="screen" title="JSPC_css" href="./css/default.css" />
</head>
	
<body>

<?php
    set_include_path('includes'); // TODO: debug (unix only pathname ?)
    include("header.php");
    include("menu.php");
    
    $OK = array("home" => "home.php",
                "login" => "login.php",
                "register" => "register.php",
                "basket" => "basket.php",
                "search" => "search.php");
    # is the requested url correct ? No ? _> load home
    if ((isset($_GET["p"])) && (isset($OK[$_GET["p"]])))
                include($OK[$_GET["p"]]);
            else
                include("home.php");

    include("footer.php");
?>

<script src="js/jquery-1.6.4.js"></script>
</body>
</html>
