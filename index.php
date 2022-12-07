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
			<a class="lien" id="LProduit" href="produit.php"> Nos Produits </a>
			<map name="logo"> 
				<area shape="rect" coords="9, 46, 190, 160" href="index.html">
			</map>
			<img class="logo" src="logo.png" usemap="#logo">
		</div>
		
		<!--Corps du site-->
        <h1>vos recherches</h1>
    <?php

       
        // verification de l'existence d'une valeur
        function getParameter($valeur){

            $param_present = isset ($_GET[$valeur]);
            if($param_present == true){
                return $_GET[$valeur];
                
            }
            else{
                return null;
            }
        }
           
        $produit = getParameter("produit");
        
        $xml = simplexml_load_file("GeekZone_Gamme.xml");
        $xml2 = simplexml_load_file("GeekZone_Boutique.xml");
        // recherche par boutique
        foreach($xml2->boutique as $cle=>$k){
            if($produit == $k -> nom){   
                // Cadre boutique
                echo "<div class=\"info\"><div class=\"module-info\">";
                // Nom de la boutique
                echo "<div class=\"titre\">", $k->nom, "</div>";
                
                echo "<div class=\"flex\">";
                // Affiche l'image
                echo "<div><img class=\"img-boutique\" src=\"", $k->image, "\"></div>";
                // Affiche le texte descriptif
                echo "<div class=\"txt-boutique\">";
                echo "<div class=\"titre\"> Coordonnées </div>";
                // L'adresse
                echo "<p>", $k->adresse, "</br>";
                // Le numéro de téléphone
                echo "Téléphone : ", $k->tel, "</p>";
                echo "<div class=\"titre\"> Horaires d'ouvertures </div>";
                
                // Affiche toutes les horaires au cas où il y en aurait plusieurs
                echo "<p>";
                foreach($k->horaire as $cle=>$hor)
                    echo $hor, "</br>";
                    echo "</p>";
                
                    echo "</div></div></div></div>";
            }            
            
        }
        // recherche par categorie
        foreach($xml->categorie as $cle=>$i){
                if ($produit == $i->nom){
				// // Cadre produit
				echo "<div class=\"info\"><div class=\"module-info\">";
				// Nom de la catégorie
				echo "<div class=\"titre\">", $i->nom, "</div>";
				echo "<div class=\"flex\" id=\"centre\">";
                    foreach($i->article as $cle=>$j){
                        // Affiche l'image
                        echo "<div><img class=\"img-produit\" src=\"", $j->image[0], "\">";
                        // Affiche le libellé du produit
                        echo "<p>", $j->nom, "</br>", $j->prix, "</p></div>";
                    }
                }
            }
        // recherche par produit 
        
        foreach($xml->categorie as $cle=>$i){
            // // Cadre produit
            // echo "<div class=\"info\"><div class=\"module-info\">";
            // // Nom de la catégorie
            // echo "<div class=\"titre\">", $i->nom, "</div>";
            echo "<div class=\"flex\" id=\"centre\">";
            foreach($i->article as $cle=>$j){
                    if ($produit == $j->nom){
                        // Affiche l'image
                        echo "<div><img class=\"img-produit\" src=\"", $j->image[0], "\">";
                        // Affiche le libellé du produit
                        echo "<p>", $j->nom, "</br>", $j->prix, "</p></div>";
                        
                    }
                    echo "</div></div></div>";
            }
        }
        
        
    ?>
</html>
    