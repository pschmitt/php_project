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
    
    

    define("INGREDIENT_DELIMITER", "--");

    // create database
    $db = mysqli_connect($db_host, $db_user, $db_password)
        or die("Connect error: ".mysqli_connect_error());
    printf("Success... %s\n", mysqli_get_host_info($db));

    // create DB (cooking)
    $sql = "CREATE DATABASE IF NOT EXISTS ".$db_name;
    mysqli_query($db, $sql)
        or die("Error: ".mysqli_error($db));
    
    // set default DB name
    mysqli_select_db($db, $db_name);
    // set autocommit
    mysqli_autocommit($db, TRUE)
        or die("Couldn't set autocommit");
    printf("DB sucessfully created.\n");


    // create TABLE (recipes)
    // TODO id: unsigned int ; max_size for entries
    $sql = "CREATE TABLE IF NOT EXISTS ".$table." (
         id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
         title VARCHAR(100),
         ingredients TEXT,
         preparation TEXT
    )";
    mysqli_query($db, $sql)
        or die ("Error: %s".mysqli_error($db));
    printf("TABLE succesfully created.\n");

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

    mysqli_close($db);
?>
</pre>
</body>
</html>
