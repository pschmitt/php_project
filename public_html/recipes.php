<?php
require_once("includes/functions/functions.inc.php");
require_once("includes/functions/mysqli.inc.php");
require_once("includes/functions/queries.inc.php");

$db = db_con();

if (isset($_GET['recipe_id'])) {
	// Si un id de recette est défini, on affiche le titre, les ingrédients et la préparation
	// correspondant à l'id de cette recette.
	
    $sql = recipe_by_id($_GET['recipe_id']);
    $res = query($db, $sql);
    $recipe = mysqli_fetch_assoc($res);
    mysqli_free_result($res);
    $sql = ingredients_by_recipe_id($_GET['recipe_id']);
    $res = query($db, $sql);
    while ($row = mysqli_fetch_assoc($res)) {
        $recipe['ing'][] = $row['name'];
    }
    mysqli_free_result($res);
    printf('<h2>%s</h2>', $recipe['title']);
    ?>
    <div id="favs">
        <img id="bookmark" src="images/heart.png" height="32" width="32" alt="heart" title="ajouter aux favoris"/>
        <br />
        <span id="result"></span>
    </div>
    <?php
	echo '<div class="entry-content">'."
	<h3>Ingredients</h3>
	<ul>\n";
    foreach ($recipe['ing'] as $ing)
        printf("\t\t<li>%s</li>\n", ucfirst($ing));
    printf("\t</ul>\n\t<h3>Preparation</h3>\n\t<p>%s</p>\n\t</div>", capitalize_sentence($recipe['preparation']));

} else if (isset($_GET['cat'])) {
	// Sinon, si une catégorie est définie, cela signifie qu'on a cliqué dans le menu et on affiche
	// donc le titre de toutes les recettes contenant au moins un des ingrédients.
	
	$ing_list = array();
	if (isset($Thesaurus[$_GET['cat']])) {
		// Construction de la requête SQL
		// Liste d'ingrédients
		
		function make_ing_list($ingredient_type, $array) {
			global $db;
			global $ing_list;
			
			if (isset($ingredient_type['S'])) {
				foreach($ingredient_type['E'] as $synonyms => $synonym) {
					$str = mysqli_real_escape_string($db, $synonym);
					if (!in_array($str, $ing_list))
						$ing_list[] = $str;
				}
				foreach($ingredient_type['S'] as $sons => $son) {
					foreach($array[$son]['E'] as $synonyms => $synonym) {
						$str = mysqli_real_escape_string($db, $synonym);
						if (!in_array($str, $ing_list))
							$ing_list[] = $str;
					}
					//echo $array[$son]['T'].", ";
					make_ing_list($array[$son], $array);
				}
			} else {
				foreach($ingredient_type['E'] as $synonyms => $synonym) {
					$str = mysqli_real_escape_string($db, $synonym);
					if (!in_array($str, $ing_list))
						$ing_list[] = $str;
				}
			}
		}
		
		make_ing_list($Thesaurus[$_GET['cat']], $Thesaurus);
		$ing_list = implode("', '", $ing_list);
		
		$sql = recipes_by_ing_list($ing_list);	
		
		//--frantz-- $result = query($db, $sql);
		$result = query($db, $sql);
		//----- debut de la pagination-----
		$sql_Limit = $sql;
		$messagesParPage = 15; //Nous allons afficher 15 messages par page.
		$total = mysqli_num_rows($result);
		//Nous allons maintenant compter le nombre de pages.
		$nombreDePages = ceil($total / $messagesParPage);
		if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
		{	
			$pageActuelle = intval($_GET['page']);

			if($pageActuelle > $nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
			{
				$pageActuelle = $nombreDePages;
			}
		}
		else // Sinon
		{
			$pageActuelle = 1; // La page actuelle est la n°1    
		}
		$premiereEntree = ($pageActuelle - 1) * $messagesParPage; // On calcul la première entrée à lire
		// La requête sql pour récupérer les messages de la page actuelle.
		$sql_Limit .= ' LIMIT '.$premiereEntree.', '.$messagesParPage.'';
		$result = query($db, $sql_Limit);

		//----- suite pagination-----
		
		echo "<h2>Recipes with: ".strtolower($Thesaurus[$_GET['cat']]['T'])."</h2>";
		
		//echo $sql_Limit;

		$row = mysqli_fetch_assoc($result);
		if($row) {
			echo "<dl>\n";
			while ($row = mysqli_fetch_assoc($result)) {
				//print_r($row);
				
				//$recipe_temp_table[$row['id_recipe']][$row['title']][] = $row['name'];
				
				//print_r($recipe_temp_table);
				
				echo '<dt><a href="index.php?p=recipes&recipe_id='.$row['id'].'">'.$row['title'].'</a></dt>'."\n";
				echo "<dd><strong>Preparation </strong>: ".substr(capitalize_sentence($row['preparation']), 0, 256)." [...]"."</dd><br />\n\n";
			}
			echo "</dl>\n";
			
			//--- suite pagination
			echo '<p align="center">Page : '; //Pour l'affichage, on centre la liste des pages
			for($page = 1; $page <= $nombreDePages; $page++) 
			{
				//On va faire notre condition
				if ($page == $pageActuelle) //Si il s'agit de la page actuelle...
				{
				 echo ' [ '.$page.' ] '; 
				}	
				else //Sinon...
				{
				  //echo ' <a href="index.php?p=recipes&page='.$i.'">'.$i.'</a> ';
				  echo ' <a href="'.$_SERVER['PHP_SELF'].'?p=recipes&cat='.$Thesaurus[$_GET['cat']]['N'].'&page='.$page.'">'.$page.'</a> ';
				}
			}
			echo '</p>';
		} // fin if($row)
		else {
			echo "<p>Désolé, mais il n'y a pas de recettes dans cette catégorie.</p>";
		}
		
		//--- suite pagination
	}
}
mysqli_close($db);
?>

<script>
    var add_icon = "images/heart.png";
    var rm_icon = "images/heart_del.png";
    var add_title = "add to bookmarks";
    var rm_title = "remove from bookmarks";
    var added_txt = "bookmarked !";
    var added_failed_txt = "coudn't bookmark ..!";
    var rm_txt = "removed from bookmarks !";
    var rm_failed_txt = "couldn't remove bookmark..!";


    function add_bookmark() {
        $.ajax({
            type: "POST",
            url: "includes/functions/bookmark.php",
            data: { recipe_id: <?php echo isset($_GET['recipe_id']) ? $_GET['recipe_id'] : '-1'; ?>, user_id: <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '-1'; ?> },
            success: function(server_response) {
                $("#result").ajaxComplete(function(event, request) {
                    if (server_response == '0') {
                        $("#result").html(added_txt);
                        $("#result").show("fast");
                        $("#bookmark").attr('src', rm_icon);
                        $("#bookmark").attr('title', rm_title);
                    } else {
                        $("#result").html(added_failed_txt);
                    }
                    $("#result").fadeOut(3000);
                });
            }
        });
    };
    
    function rm_bookmark() {
        $.ajax({
            type: "POST",
            url: "includes/functions/rm_bookmark.php",
            data: { recipe_id: <?php echo isset($_GET['recipe_id']) ? $_GET['recipe_id'] : '-1'; ?>, user_id: <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '-1'; ?> },
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
    };
    
    $(document).ready(function() {
         $.ajax({
            type: "POST",
            url: "includes/functions/is_bookmarked.php",
            data: { recipe_id: <?php echo isset($_GET['recipe_id']) ? $_GET['recipe_id'] : '-1'; ?>, user_id: <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '-1'; ?> },
            success: function(server_response) {
                $("#result").ajaxComplete(function(event, request) {
                    if (server_response == '0') {
                        $("#bookmark").attr('src', 'images/heart_del.png');
                        $("#bookmark").attr('title', 'remove from bookmarks');
                    }
                });
            }
        });
    });
    $("#bookmark").click(function() {
        if ($("#bookmark").attr('src') == "images/heart.png") {
            add_bookmark();
        } else {
            rm_bookmark();
        }
    });
</script>
