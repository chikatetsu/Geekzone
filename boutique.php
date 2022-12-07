<!DOCTYPE html>
<html>
    <?php include("header.html"); ?>

	<!--Corps du site-->
	<h1>Nos Boutiques</h1>
	
	<?php
		//Récupère la base de données
		try {
			$sql = new PDO("mysql:host=localhost; dbname=geekzone_vitrine; charset=utf8", "root", "");
		} catch(Exception $e) {
			die("ERREUR : ".$e->getMessage());
		}
		
		//Effectue la requête récupérant toutes les informations des boutiques
		$taille = $sql->query("SELECT COUNT(`id`) FROM `boutique`")->fetch()[0];

		// Affiche toutes les boutiques
		for($i=0; $i<$taille; $i++) {
			//Récupère chaque boutique
			$req = $sql->query("SELECT * FROM `boutique` WHERE `id`=".($i+1))->fetch();

			// Cadre boutique
			echo "<div class=\"info\"><div class=\"module-info\">";
			// Nom de la boutique
			echo "<div class=\"titre\">", $req["ville"], " - ", $req["cp"], "</div>";
			
			echo "<div class=\"flex\">";
			// Affiche l'image
			echo "<div><img class=\"img-boutique\" src=\"images/boutiques/", $req["image"], "\"></div>";
			// Affiche le texte descriptif
			echo "<div class=\"txt-boutique\">";
			echo "<div class=\"titre\"> Coordonnées </div>";
			// L'adresse
			echo "<p>", $req["rue"], ", ", $req["ville"], " ", $req["cp"], "</br>";
			// Le numéro de téléphone
			echo "Téléphone : ", $req["telephone"], "</p>";
			echo "<div class=\"titre\"> Horaires d'ouvertures </div>";
			// Les horaires
			echo "<p>", nl2br($req["horaires"]), "</p>";
			
			echo "</div></div></div></div>";
		}
	?>
	<button onclick="topFunction()" id="myBtn" title="Go to top">↑</button>
	
	<!-- Footer -->
	<div class="footer">
		© 2021 - 2022 GeekZone
	</div>
	
	<script src="mybutton.js" type=""></script>
	</body> 
</html>