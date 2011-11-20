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
    if (!$db = mysqli_connect($db_host, $db_user, $db_password))
        mysqli_connect_error();

    printf("Success... %s\n", mysqli_get_host_info($db));

    // set autocommit
    mysqli_autocommit($db, TRUE);

    // create DB (cooking)
    $sql = "CREATE DATABASE IF NOT EXISTS ".$db_name;
    if (!mysqli_query($db, $sql))
        printf("Error: %s\n", mysqli_error($db));
    printf("DB sucessfully created.\n");
    
    // set default DB name
    mysqli_select_db($db, $db_name);

    // create TABLE (recipes)
    // TODO id: unsigned int ; max_size for entries
    $sql = "CREATE TABLE IF NOT EXISTS ".$table." (
         id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
         title VARCHAR(100),
         ingredients TEXT,
         preparation TEXT
    )";
    if (!mysqli_query($db, $sql))
        printf("Error: %s\n", mysqli_error($db));
    printf("TABLE succesfully created.\n");

    $sql = "SELECT * FROM ".$table;
    if (mysqli_num_rows(mysqli_query($db, $sql)) != 0) {
        printf('You just ran the script man ... What \'bout <a href="erase_db.php">truncating|erasing</a> first ?');
        exit;
    }
    unset($sql);

    // read data from file
    $file = "./data/Recettes.xml";
    $fp = fopen($file, "r");
    if (!$fp)
        die("impossible d'ouvrir le fichier xml");
    
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
            return 1;
        } else
            return 0;
    }

    $index = 0;
    while (($line = fgets($fp)) && ($index = $index + 1)) { // $i++ ?!
        $line = clean_line($line);
        $data_array[$index] = simplexml_load_string($line);
    }
    fclose($fp);
    
    /*
        // TEST
        print_r($data_array); 
        unset ($index);
    */
    
    printf("Parsing XML data and inserting to DB");
    foreach($data_array as $index => $recipe) {
        printf("Processing line %s ...", $index); 
        $ing = NULL;
        // TODO: Error handling (multiple executions)
        foreach($recipe->IN as $ingredient)
            $ing .= $ingredient->ING.INGREDIENT_DELIMITER;
        $sql = "INSERT INTO $table VALUES ('".$index."', '".$recipe->TI."', '".$recipe->PR."', '".$ing."')";
        
        submit($db, $sql);

        printf("done\n");
    }

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
