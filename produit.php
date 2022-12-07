<!DOCTYPE html>
<html>
<?php include("header.html"); ?>

		<!--Corps du site-->
        <h1>Nos Produits</h1>
		
		<?php
		//Récupère la base de données
			try {
				$sql = new PDO("mysql:host=localhost; dbname=geekzone_vitrine; charset=utf8", "root", "");
			} catch(Exception $e) {
				die("ERREUR : ".$e->getMessage());
			}
			
			//Récupère un tableau de catégorie
			$tab = array();
			$tailleCategorie = $sql->query("SELECT COUNT(`categorie_id`) FROM `categorie`")->fetch()[0];
			for($i=0; $i<$tailleCategorie; $i++) {
				$req = $sql->query("SELECT * FROM `categorie` WHERE `categorie_id`=".($i+1))->fetch();
				array_push($tab, $req["libelle"]);
			}
			
			// Affiche toutes les catégories
			foreach($tab as $cle=>$i) {
				// Cadre produit
				echo "<div class=\"info\"><div class=\"module-info\">";
				// Nom de la catégorie
				echo "<div class=\"titre\">", $i, "</div>";
				echo "<div class=\"flex\" id=\"centre\">";

				$taille = $sql->query("SELECT COUNT(`produit_id`) FROM `produit`")->fetch()[0];
				for($j=0; $j<$taille; $j++) {
					$req = $sql->query("SELECT * FROM `produit` WHERE `produit_id`=".($j+1))->fetch();
					$req2 = $sql->query("SELECT * FROM `categorie` WHERE `categorie_id`=".$req["categorie"])->fetch();
					
					//Vérifie que le produit est de la bonne catégorie
					if($req2["categorie_id"] == ($cle+1)) {
						// Affiche l'image
						echo "<div><a class=\"productName\" href=\"description.php?id=".$req["produit_id"]."\"><img class=\"img-produit\" src=\"images/",$i,"/".$req["image"], "\">";
						// Affiche le libellé du produit
						echo "<p>", $req["nom"], "</br>", number_format($req["prix"],2), "€</p></a></div>";
					}
				}
				echo "</div></div></div>";
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