<!DOCTYPE html>
<html>
	<?php include("header.html"); ?>

	<?php
		//Récupère la base de données
		try {
			$sql = new PDO("mysql:host=localhost; dbname=geekzone_vitrine; charset=utf8", "root", "");
		} 
		catch(Exception $e) {
			die("ERREUR : ".$e->getMessage());
		}
		
		//Récupère le produit
		$req = $sql->query("SELECT * FROM `produit` WHERE `produit_id`=".$_GET["id"])->fetch();
		$categorie = $sql->query("SELECT `libelle` FROM `categorie` WHERE `categorie_id`=".$req["categorie"])->fetch()[0];

		echo "<p class='productTitle'>".$req["nom"]."</p><br>";
		echo "<div class='product-flex module-info'>";
			echo "<div class='product-info' style='margin-left: 100px'>";
				echo "<p>".$req["description"]."</p>";
				echo "<p>".$req["detail"]."</p>";
				echo "<p>".$req["prix"]."</p>";
				echo "categorie: ".$req["categorie"]."";
			echo "</div>";
			echo "<div>";
				//NOUVEAU CODE
		$nb_image = 1;
				echo "image".$nb_image.": </br><div><img class=\"img-boutique\" src=\"images/".$categorie."/".$req["image"]."\"></div>";
				while(file_exists("images/".$categorie."/".str_replace(".", "-".$nb_image.".", $req["image"]))) {
					echo "image".($nb_image+1).": </br><div><img class=\"img-boutique\" src=\"images/".$categorie."/".str_replace(".", "-".$nb_image.".", $req["image"])."\"></div>";
					$nb_image++;
				}
			echo "</div>";
		echo "</div>";
		
	?>
	<!-- Footer -->
	<div class="footer">
		© 2021 - 2022 GeekZone
	</div>

	<script src="mybutton.js" type=""></script>
	</body>
</html>
