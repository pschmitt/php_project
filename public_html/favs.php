<h3>Vos recettes favorites</h3>
<?php
    require_once("includes/functions/mysqli.inc.php");
    require_once("includes/functions/queries.inc.php");
    
    if (isset($_SESSION['user_id'])) { 
        $db = db_con();
    
        $sql = get_favorites($_SESSION['user_id']);

        $res = query($db, $sql);
?>
    <ul>
<?php
    while ($row = mysqli_fetch_assoc($res)) {
        printf('<li>
                    <a href="'.$_SERVER['PHP_SELF'].'?p=recipes&recipe_id=%s">
                        %s
                    </a>
                </li>
                ', $row['id'], $row['title']);
    }
?>
    </ul>
<?php
        mysqli_close($db);
    }
?>

