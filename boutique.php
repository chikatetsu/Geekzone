<!DOCTYPE html>
<html>
    <head>
        <title>GeekZone - Boutique</title>
        <meta charset="UTF-8">
        <link href="geekzone.css" rel="stylesheet">
        <link href="icons.ico" rel="shortcut icon">
    </head>

	<body>
        <a name="debut"></a>
		<!--Bandeau du site-->
		<div class="bandeau"> 
			<a class="lien" id="LBoutique"> Nos Boutiques </a>
			<a class="lien" id="LProduit" href="produit.php"> Nos Produits </a>
			<map name="logo">
				<area shape="rect" coords="9, 46, 190, 160" href="index.html">
			</map>
			<img class="logo" src="logo.png" usemap="#logo">
		</div>
		
		<!--Corps du site-->
        <h1>Nos Boutiques</h1>
		
		<?php
			// Ouvre le fichier XML GeekZone_Boutique.xml
			$xml = simplexml_load_file("GeekZone_Boutique.xml");
			
			// Affiche toutes les boutiques
			foreach($xml->boutique as $cle=>$i)
			{
				// Cadre boutique
				echo "<div class=\"info\"><div class=\"module-info\">";
				// Nom de la boutique
				echo "<div class=\"titre\">", $i->nom, "</div>";
				
				echo "<div class=\"flex\">";
				// Affiche l'image
				echo "<div><img class=\"img-boutique\" src=\"", $i->image, "\"></div>";
				// Affiche le texte descriptif
				echo "<div class=\"txt-boutique\">";
				echo "<div class=\"titre\"> Coordonnées </div>";
				// L'adresse
				echo "<p>", $i->adresse, "</br>";
				// Le numéro de téléphone
				echo "Téléphone : ", $i->tel, "</p>";
				echo "<div class=\"titre\"> Horaires d'ouvertures </div>";
				
				// Affiche toutes les horaires au cas où il y en aurait plusieurs
				echo "<p>";
				foreach($i->horaire as $cle=>$hor)
					echo $hor, "</br>";
				echo "</p>";
				
				echo "</div></div></div></div>";
			}
		?>
		<a href="#debut">clique sur moi petit coquin</a>
		
		<!-- Footer -->
		<div class="footer">
			© 2021 GeekZone
		</div>
	</body> 
</html>
