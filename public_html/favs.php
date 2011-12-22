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
                    -
                    <a id="%s" class="rm_bookmark" href="#" >
                        supprimer
                    </a>
                </li>
                ', $row['id'], $row['title'], $row['id']);
    }
?>
    </ul>
<?php
        mysqli_close($db);
    }
?>

<script>
    $(".rm_bookmark").click(function() {
        $.ajax({
            type: "POST",
            url: "includes/functions/rm_bookmark.php",
            data: { recipe_id: $(this).attr('id') , user_id: <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '-1'; ?> },
            success: function(server_response) {
                $("#result").ajaxComplete(function(event, request) {
                    if (server_response == '0') {
                        $("#result").html(rm_txt);
                        $("#result").show("fast");
                        $("#bookmark").attr('src', add_icon);
                        $("#bookmark").attr('title', add_title);
                    } else {
                        $("#result").html(rm_failed_txt);
                    }
                    $("#result").fadeOut(3000);
                });
            }
        });
        $(this).parent().remove();
    });
</script>
