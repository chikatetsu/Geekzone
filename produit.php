<!DOCTYPE html>
<html>
    <head>
        <title>GeekZone - Produit</title>
        <meta charset="UTF-8">
        <link href="geekzone.css" rel="stylesheet">
        <link href="icons.ico" rel="shortcut icon">
    </head>
	
	<body>
		<!--Bandeau du site-->
		<div class="bandeau"> 
			<a class="lien" id="LBoutique" href="boutique.php"> Nos Boutiques </a>
			<a class="lien" id="LProduit"> Nos Produits </a>
			<map name="logo"> 
				<area shape="rect" coords="9, 46, 190, 160" href="index.html">
			</map>
			<img class="logo" src="logo.png" usemap="#logo">
		</div>
		
		<!--Corps du site-->
        <h1>Nos Produits</h1>
		
		<?php
			// Ouvre le fichier XML GeekZone_Gamme.xml
			$xml = simplexml_load_file("GeekZone_Gamme.xml");
			
			// Affiche toutes les catégories
			foreach($xml->categorie as $cle=>$i)
			{
				// Cadre produit
				echo "<div class=\"info\"><div class=\"module-info\">";
				// Nom de la catégorie
				echo "<div class=\"titre\">", $i->nom, "</div>";
				echo "<div class=\"flex\" id=\"centre\">";
				
				foreach($i->article as $cle=>$j)
				{
					// Affiche l'image
					echo "<div><img class=\"img-produit\" src=\"", $j->image[0], "\">";
					// Affiche le libellé du produit
					echo "<p>", $j->nom, "</br>", $j->prix, "</p></div>";
				}
				echo "</div></div></div>";
			}
		?>
		
        <!-- Footer -->
        <div class="footer">
            © 2021 GeekZone
        </div>
	</body> 
</html>