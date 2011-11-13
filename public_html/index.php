<!DOCTYPE html>
<html dir="ltr" lang="fr-FR">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>JeNeSaisPasCuisiner.com | Accueil</title>
<link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
<!--[if lt IE 9]>
<script src="js/html5.js" type="text/javascript"></script>
<![endif]-->
<script src="js/jquery-1.6.4.min.js"></script>
</head>
<body>
<div id="page">
    <?php
        set_include_path('includes'); // TODO: debug (unix only pathname ?)
        include("header.inc");
    ?>

    <div id="centre">
        <?php
            include("navigation.inc");
            include("search.inc");
        ?>
        <div id="principal">
        <?php
            $PAGES = array("login"    => "login.php",
                           "register" => "register.php",
                           "basket"   => "basket.php",
                           "search"   => "search.php");
            # is the requested url correct ? No ? _> load home
            if ((isset($_GET["p"])) && (isset($PAGES[$_GET["p"]])))
                include($PAGES[$_GET["p"]]);
            else
                include("home.php");
        ?>
        </div><!-- #principal -->
    </div><!-- #centre -->
    
    <?php
        include("footer.inc");
    ?>
</div>
<!-- end page -->

</body>
</html>
