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
        
    function clean_line($str) {
        // TODO don't delete the '
        // TODO error handling
        //return utf8_encode(preg_replace('[\']', null, $str));
        return utf8_encode(preg_replace('[\']','\\\'' , $str));
        //global $db;
        //echo "db = ".$db."\n";
        //return mysqli_real_escape_string($db, $str);
    }

    function submit($db, $sql) {
        if ((!isset($db, $sql)) || (!mysqli_query($db, $sql))) {
            printf("Error: %s\n", mysqli_error($db));
            return 0;
        } else
            return 1;
    }
   
    function line_to_db($line, $db, $table) {
        isset($line)
            or die("No param. Exiting.\n");
        $line = clean_line($line);
        $sxml = simplexml_load_string($line);
        $ing = NULL;
        foreach($sxml->IN as $ingredient)
            $ing .= $ingredient->ING.INGREDIENT_DELIMITER;
        $sql = "INSERT INTO ".$table." VALUES ('NULL', '".$sxml->TI."', '".$sxml->PR."', '".$ing."')";
        submit($db, $sql)
            or die("Couldn't submit !\n");
    }

    printf("Parsing XML data and inserting to DB\n");
    function parse_file ($file, $db, $table) {
        // read data from file
        $fp = fopen($file, "r");
        if (!$fp)
            die("Couldn't open xml file\n");
        $index = 0;
        while (($line = fgets($fp)) && ($index = $index + 1)) { // $i++ ?!
            printf("Processing line %s ...", $index);
            line_to_db($line, $db, $table);
            printf("done\n");
            //$data_array[$index] = simplexml_load_string($line);
        }
        fclose($fp)
            or die("Couldn't close file");
    }
    $file = "./data/Recettes.xml";
    parse_file($file, $db, $table);
    //$data_array = parse_file();
    /*
        // TEST
        print_r($data_array); 
        unset ($index);
    */
    

    /*foreach($data_array as $index => $recipe) {
        printf("Processing line %s ...", $index); 
        $ing = NULL;
        // TODO: Error handling (multiple executions)
        foreach($recipe->IN as $ingredient)
            $ing .= $ingredient->ING.INGREDIENT_DELIMITER;
        $sql = "INSERT INTO $table VALUES ('".$index."', '".$recipe->TI."', '".$recipe->PR."', '".$ing."')";
        
        submit($db, $sql);

        printf("done\n");
    }*/

    /*
    if (!mysqli_multi_query($db, $sql))
        printf("Error: %s\n",mysqli_error($db));
    printf("Database succesfully filled\n");
    */

    // test if already present
    // $sql = "SELECT * FROM ".$table." WHERE id = 1";
    
    // search
    // $sql = "SELECT `preparation` FROM ".$table." WHERE ingredients like '%orange%'";


    mysqli_close($db);
?>
</pre>
</body>
</html>
