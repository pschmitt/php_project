
<html>
<head>
	<title>JeNeSaisPasCuisiner.com</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
	
<body>
<pre>
<?php
    // TODO create_user -> http://dev.mysql.com/doc/refman/5.0/en/create-user.html
    $passwd_file = realpath('../.login/DB_credentials.php');
    $file = "./data/Recettes.xml";
    require "$passwd_file";
    
    define("INGREDIENT_DELIMITER", "--");

    function query($db, $sql) {
        if ((!isset($db, $sql)) || (!mysqli_query($db, $sql)))
            die("Error: ". mysqli_error($db));
    }

    // create database
    $db = mysqli_connect($db_host, $db_user, $db_password)
        or die("Connect error: ".mysqli_connect_error());
    printf("Done: %s\n", mysqli_get_host_info($db));

    // create DB (JeNeSaisPasCuisiner)
    $sql = "CREATE DATABASE IF NOT EXISTS ".$db_name;
    mysqli_query($db, $sql) 
        or die("Error: ".mysqli_error($db));

    // set default DB name
    mysqli_select_db($db, $db_name)
        or die("Couldn't select default DB(".$db_name.")");

    // set autocommit
    mysqli_autocommit($db, TRUE)
        or die("Couldn't set autocommit");
    printf("Done: DB sucessfully created.\n");

    // delete / truncate
    if (isset($_GET['d'])) {
        switch($_GET['d']) {
            case "truncate":
                $sql = "TRUNCATE TABLE ".$tables["Recipes"];
                $msg = "Truncated (".$tables["Recipes"].")";
                break;
            case "delete":
                $sql = "DROP DATABASE ".$db_name;
                $msg = "Deleted (".$db_name.")";
                break;
            default:
                die("Unknown parameter value.\n");
        }
        query($db, $sql);
        printf("Done: %s\n", $msg);
        exit;
    }

    // check if db filled 
    $sql = "SELECT * FROM ".$tables["Recipes"];
    if ($res = mysqli_query($db, $sql)) {
        !mysqli_num_rows($res)
            or die('
/!\ You just ran the script man ... What \'bout <a href="'.$_SERVER['PHP_SELF'].'?d=truncate">truncating</a> | <a href="'.$_SERVER['PHP_SELF'].'?d=delete">erasing</a> first ?');
    }
    unset($res);

    // create TABLE (recipes)
    // TODO id: unsigned int ; max_size for entries
    $sql = "CREATE TABLE IF NOT EXISTS ".$tables["Recipes"]." (
                id INT NOT NULL AUTO_INCREMENT,
                title VARCHAR(100),
                ingredients TEXT,
                preparation TEXT,
                PRIMARY KEY (id)
            )";
    query($db, $sql);
    printf("Done: TABLE %s succesfully created.\n", $tables["Recipes"]);
   
    // create TABLE (ingredients)
    $sql = "CREATE TABLE IF NOT EXISTS ".$tables["Ingredients"]." (
                id INT NOT NULL AUTO_INCREMENT,
                name VARCHAR(30) NOT NULL,
                qualifiant varchar(30) NOT NULL,
                reste varchar(20) NOT NULL,
                unit varchar(20) DEFAULT NULL,
                quantity int(11) DEFAULT NULL,
                parenthese text,
                PRIMARY KEY (id)
            )";
    query($db, $sql);
    printf("Done: TABLE %s succesfully created.\n", $tables["Ingredients"]);
    
    // create TABLE (link recipes<->ingredients)
    // TODO Autoincrement ?
    $sql = "CREATE TABLE IF NOT EXISTS ".$tables["Recipes_ln_Ingredients"]." (
                id_recipe INT NOT NULL,
                id_ingredient INT NOT NULL,
                PRIMARY KEY (id_recipe, id_ingredient)
            )";
    query($db, $sql);
    printf("Done: TABLE %s succesfully created.\n", $tables["Recipes_ln_Ingredients"]);
    
    // create TABLE (users)
    // TODO Username = unique
    $sql = "CREATE TABLE IF NOT EXISTS ".$tables["Users"]." (
                id INT AUTO_INCREMENT,
                username VARCHAR(10) NOT NULL,
                password VARCHAR(10) NOT NULL,
                name VARCHAR(20) DEFAULT NULL,
                first_name VARCHAR(20) DEFAULT NULL,
                gender VARCHAR(10) DEFAULT NULL,
                birth_year INT DEFAULT NULL,
                street_address VARCHAR(30) DEFAULT NULL,
                zip_code INT(6) DEFAULT NULL,
                city VARCHAR(30) DEFAULT NULL,
                tel_num INT(15) DEFAULT NULL,
                email VARCHAR(30) DEFAULT NULL,
                PRIMARY KEY (id)
            )";
    query($db, $sql);
    printf("Done: TABLE %s succesfully created.\n", $tables["Users"]);
    
    // create TABLE (baskets)
    $sql = "CREATE TABLE IF NOT EXISTS ".$tables["Baskets"]." (
                id INT AUTO_INCREMENT,
            	titre varchar(50) NOT NULL,
            	PRIMARY KEY (id)
            )";
    query($db, $sql);
    printf("Done: TABLE %s succesfully created.\n", $tables["Baskets"]);
    
    // create TABLE (link users<->baskets)
    $sql = "CREATE TABLE IF NOT EXISTS ".$tables["Users_ln_Baskets"]." (
                id_user INT NOT NULL,
            	id_basket INT NOT NULL,
            	PRIMARY KEY (id_user, id_basket)
            )";
    query($db, $sql);
    printf("Done: TABLE %s succesfully created.\n", $tables["Users_ln_Baskets"]);

    // create TABLE (link baskets<->recipes)
    $sql = "CREATE TABLE IF NOT EXISTS ".$tables["Baskets_ln_Recipes"]." (
                id_basket INT NOT NULL,
                id_recipes INT NOT NULL,
                PRIMARY KEY (id_basket, id_recipes)
            )";
    query($db, $sql);
    printf("Done: TABLE %s succesfully created.\n", $tables["Baskets_ln_Recipes"]);


        
    function clean_line($str) {
        // TODO error handling
        // TODO use mysqli_real_escape_string
        return utf8_encode(preg_replace('[\']','\\\'' , $str));
        //return mysqli_real_escape_string($db, utf8_encode($str));
    }

    //TODO INSERT INTO VALUES ("", "", ""), ("", "", "")
    function get_values($line, $db) {
        isset($line, $db)
            or die("No param. Exiting.\n");
        $line = clean_line($line);
        $sxml = simplexml_load_string($line);
        $ing = NULL;
        foreach($sxml->IN as $ingredient)
            $ing .= $ingredient->ING.INGREDIENT_DELIMITER;
        return "('NULL', '".mysqli_real_escape_string($db, $sxml->TI)."', '".$sxml->PR."', '".$ing."'),";
    }

    printf("Parsing XML data and inserting to DB\n");
    
    function parse_file ($file, $db, $tables) {
        // read data from file
        $fp = fopen($file, "r")
            or die("Couldn't open xml file\n");
        $sql = "INSERT INTO ".$tables["Recipes"]." VALUES ";
        $index = 0;
        while (($line = fgets($fp)) && ($index = $index + 1)) { // $i++ ?!
            // commit 50 by 50
            if ($index % 50 == 0) {
                // submit and reset $sql
                query($db, substr($sql, 0, -1));
                $sql = "INSERT INTO ".$tables["Recipes"]." VALUES ";
            }
            $values = get_values($line, $db) ;
            $sql .= $values;
        }
        query($db, substr($sql, 0, -1));
        printf("Done: read %d lines !", $index);
        fclose($fp)
            or die("Couldn't close file");
    }

    parse_file($file, $db, $tables);
    
    // search
    // $sql = "SELECT `preparation` FROM ".$table." WHERE ingredients like '%orange%'";

    mysqli_close($db);
?>
</pre>
</body>
</html>
