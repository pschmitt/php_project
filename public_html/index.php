<?php
    session_start();
    $thesaurus_file = "./data/Thesaurus_updated.php";
    file_exists($thesaurus_file) or die ('N\'allez pas trop vite : cr�ez d\'abord une
                                          <a href="./create_db.php">base de donn�es</a> !');
    require_once("./data/Thesaurus_updated.php");
    
	/**
	 * get_title() permet d'avoir un titre dynamique dans la balise <title>.
	 * Author: Mathieu Morainville
	 */
	function get_title() {
		global $Thesaurus;
		if (isset($_GET['p'])) {
			echo ucwords($_GET['p']);
		} else if (isset($_GET['cat'])) {
			echo ucwords($Thesaurus[$_GET['cat']]['T']);
		} else {
			echo 'Home';
		}
	}
?>

<!DOCTYPE html>
<html dir="ltr" lang="fr-FR">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?php
    if (isset($_GET['p'])) {
        switch($_GET['p']) {
            case "registered":
            case "logout":
?>
<meta http-equiv="refresh" content="3;URL=index.php"> 
<?php
                break;
            case "login":
                ?>
<meta http-equiv="refresh" content="3;URL=<?php echo $_SESSION['referer']; ?>">                    
                <?php
                break;
        }
    }
    $_SESSION['referer'] = $_SERVER['REQUEST_URI'];
?>
<title>JeNeSaisPasCuisiner.com | <?php get_title(); ?></title>
<link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
<!--[if lt IE 9]>
<script src="js/html5.js" type="text/javascript"></script>
<![endif]-->
<script src="js/jquery-1.6.4.min.js"></script>
</head>
<body>
<div id="page">
    <?php
        set_include_path('includes'); // TODO: debug (unix only pathname?)
        include("header.inc.php");
    ?>

    <div id="centre">
        <?php
            include("navigation.inc.php");
            //include("search.inc.php");
        ?>
        <div id="principal">
            <?php
				include("ariane.inc.php");
                $PAGES = array("login"		=> "login.php",
                               "logout"     => "logout.php",
							   "update"		=> "update.php",
							   "updated"	=> "updated.php",
                               "register"	=> "register.php",
                               "registered"	=> "registered.php",
                               "favs"		=> "favs.php",
                               "search"		=> "search.php",
							   "recipes"	=> "recipes.php");
                # is the requested url correct? No? _> load home
                if ((isset($_GET["p"])) && (isset($PAGES[$_GET["p"]])))
                    include($PAGES[$_GET["p"]]);
                else
                    include("home.php");
            ?>
        </div><!-- #principal -->
    </div><!-- #centre -->
    <?php
        include("footer.inc.php");
    ?>
</div>
<!-- end page -->
</body>
</html>
