<html>
<head>
	<title>JeNeSaisPasCuisiner.com</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
	
<body>
<pre>
<?php
    // TODO Error handling (query or die ?)
    $passwd_file = realpath('../.login/DB_credentials.php');
    $file = "./data/Recettes.xml";
    require "$passwd_file";
	require_once "includes/Fonctions.inc.php"; 
    
    define("INGREDIENT_DELIMITER", "--");

 
	//connexion au serveur avec mot d'utilisateur et mot de passe
	$connect = mysql_connect($db_host, $db_user, $db_password) or die("Erreur de connexion au serveur: ".mysql_error());
    
    $db_name = "Cooking_FRANTZ";
	//creation de la base de données cooking
	$creationDataBase = "CREATE DATABASE  IF NOT EXISTS ".$db_name;
	query($creationDataBase); 
	
	//connexion a la base de données cooking
	mysql_select_db($db_name) or die("Impossible de sélectionner la base :". $db_name);
	
	//creation de la table recipe
	$create_recipe = "CREATE TABLE IF NOT EXISTS recipe (
    `id` INT AUTO_INCREMENT,
	`titre` varchar(50) NOT NULL,
	`preparation` text NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1";
	query($create_recipe);
	
	//creation de la table ingredient
	$create_ingredient = "CREATE TABLE IF NOT EXISTS `ingredient` (
    `id` INT AUTO_INCREMENT,
	`nom` varchar(30) NOT NULL,
	`qualifiant` varchar(30) NOT NULL,
	`reste` varchar(20) NOT NULL,
	`unite` varchar(20) DEFAULT NULL,
	`quantite` int(11) DEFAULT NULL,
	`parenthese` text,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1";
	query($create_ingredient);
	
	//creation de la table recipe_ingredient
	// AUTO_INCREMENT ?
    $create_recipe_ingredient = "CREATE TABLE IF NOT EXISTS recipe_ingredient (
	`id_recipe` INT NOT NULL,
	`id_ingredient` INT NOT NULL,
	PRIMARY KEY (`id_recipe`,`id_ingredient`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1";
	query($create_recipe_ingredient);
	
	//creation de la table user
	$create_user = "CREATE TABLE IF NOT EXISTS `user` (
    `id` INT AUTO_INCREMENT,
	`username` varchar(10) NOT NULL,
	`password` varchar(10) NOT NULL,
	`name` varchar(20) DEFAULT NULL,
	`first_name` varchar(20) DEFAULT NULL,
	`gender` varchar(10) DEFAULT NULL,
	`birth_year` int(4) DEFAULT NULL,
	`street_address` varchar(30) DEFAULT NULL,
	`zip_code` int(6) DEFAULT NULL,
	`city` varchar(30) DEFAULT NULL,
	`tel_num` int(15) DEFAULT NULL,
	`email` varchar(30) DEFAULT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	query($create_user);
	
	//creation de la table panier
	$create_panier = "CREATE TABLE IF NOT EXISTS `panier` (
	`username` varchar(10) NOT NULL,
	`titre` varchar(50) NOT NULL,
	PRIMARY KEY (`username`,`titre`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1";

	query($create_panier);


	/*
	inserer ici les requetes d'insertion dans les differentes tables à partir du fichier Recettes.txt
	*/
	/*
    $sql = "SELECT * FROM ".$table;

    // haha, check that out:
    !mysqli_num_rows(mysqli_query($db, $sql))
        or die('You just ran the script man ... What \'bout <a href="erase_db.php">truncating|erasing</a> first ?');
    unset($sql);
        
    function clean_line($str, $db) {
        // TODO don't delete the '
        // TODO error handling
        //return utf8_encode(preg_replace('[\']', null, $str));
        return utf8_encode(preg_replace('[\']','\\\'' , $str));
        //global $db;
        //echo "db = ".$db."\n";
        return mysqli_real_escape_string($db, utf8_encode($str));
    }

    function submit($db, $sql) {
        if ((!isset($db, $sql)) || (!mysqli_query($db, $sql))) {
            die("Error: %s\n", mysqli_error($db));
    }
    
    //TODO INSERT INTO VALUES ("", "", ""), ("", "", "")
    function get_values($line, $db) {
        isset($line)
            or die("No param. Exiting.\n");
        $line = clean_line($line, $db);
        $sxml = simplexml_load_string($line);
        $ing = NULL;
        foreach($sxml->IN as $ingredient)
            $ing .= $ingredient->ING.INGREDIENT_DELIMITER;
        
        return "('NULL', '".$sxml->TI."', '".$sxml->PR."', '".$ing."'),";
    }

    printf("Parsing XML data and inserting to DB\n");
    function parse_file ($file, $db, $table) {
        // read data from file
        $fp = fopen($file, "r");
        if (!$fp)
            die("Couldn't open xml file\n");
        $sql = "INSERT INTO ".$table." VALUES ";
        $index = 0;
        while (($line = fgets($fp)) && ($index = $index + 1)) { // $i++ ?!
            printf("Processing line %s ...", $index);
            if (!($index % 100)) {
                // submit and reset $sql
                submit($db, substr($sql, 0, -1)) or die();
                $sql = "INSERT INTO ".$table." VALUES ";
            }
            $values = get_values($line, $db) ;
            $sql .= $values;
            printf("done\n");
        }
        submit($db, substr($sql, 0, -1)) or die();
        fclose($fp)
            or die("Couldn't close file");
    }
    parse_file($file, $db, $table);
    
    // search
    // $sql = "SELECT `preparation` FROM ".$table." WHERE ingredients like '%orange%'";
	*/

    mysql_close($connect);
?>
</pre>
</body>
</html>
