<div id="secondaire">
    <aside id="search">
        <h3>Recherche</h3>
        <form method="post" class="searchform" action="<?php echo $_SERVER['PHP_SELF']."?p=search"; ?>">
			<div>
				<input type="text" class="search-input" value="" name="any" id="s" />
				<a onclick="$(this).parents('form:first').submit();"  href="#">GO</a>
			</div>
        </form>
		<br />
		<h3>Votre panier</h3>
		<p>Il n'y a pour l'instant aucun article dans votre panier.</p>
    </aside>
</div><!-- #secondaire -->
