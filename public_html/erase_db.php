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
            printf("Required parameter: o\n-delete: delete database(%s)\n-truncate: truncate table (%s)\n\n... or click:", $GLOBALS['db_name'], $GLOBALS['table']);
            printf('</pre>
                    <form method="get" target="#">
                        <input type="submit" name="o" value="delete" />
                        <input type="submit" name="o" value="truncate" />
                    </form>
                    <pre>');
        }
        
        // TODO Rename !
        function getopts($cred) { 
            
            switch($_GET['o']) {
                case "truncate":
                    $sql = "TRUNCATE TABLE ".$cred['table'];
                    $msg = "Truncated";
                    break;
                case "delete":
                    $sql = "DROP DATABASE ".$cred['db_name'];
                    $msg = "Deleted";
                    break;
                default:
                    usage();
                    die("Unknown value.\n");
            }
            
            $db = mysqli_connect($cred['db_host'], $cred['db_user'], $cred['db_password'], $cred['db_name']);
            
            if ((isset($sql)) && (! mysqli_query($db, $sql)))
                printf("Error: %s\n", mysqli_error($db));
            printf("Done: %s\n", $msg);
            mysqli_close($db);
        }
        
        if (!isset($_GET['o']))
            usage();
        else 
            getopts($credentials);    

    ?>
</pre>
</body>
</html>
