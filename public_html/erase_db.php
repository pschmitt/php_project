<html>
<head>
    <title>test</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<pre>
    <?php
        $passwd_file = realpath('../.login/DB_credentials.php');
        require "$passwd_file";
        
        function usage() {
            printf("Required parameter: o\n-d: delete database(%s)\n-t: truncate table (%s)", $GLOBALS['db_name'], $GLOBALS['table']);
            exit;
        }

        if (!isset($_GET['o']))
            usage();
        
        $db = mysqli_connect($db_host, $db_user, $db_password, $db_name);
        
        
        switch($_GET['o']) {
            case 't':
                $sql = "TRUNCATE TABLE ".$table;
                $msg = "Truncated";
                break;
            case 'd':
                $sql = "DROP DATABASE ".$db_name;
                $msg = "Deleted";
                break;
        }

        if ((isset($sql)) && (! mysqli_query($db, $sql)))
            printf("Error: %s\n", mysqli_error($db));
        printf("Done: %s\n", $msg);
        mysqli_close($db);
    ?>
</pre>
</body>
</html>
