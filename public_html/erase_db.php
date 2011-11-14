<html>
<head>
    <title>test</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<?php
    $passwd_file = realpath('../.login/DB_credentials.php');
    require "$passwd_file";
    
    $db = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    
    $sql = "DROP DATABASE ".$db_name;
    if (!mysqli_query($db, $sql))
        printf("Error: %s\n", mysqli_error($db));
    printf("Database successfully removed");
    mysqli_close($db);
?>

</body>
</html>
