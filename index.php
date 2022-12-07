<!DOCTYPE html>
<html>
    <?php include("header.html"); ?>
	
    <!--Barre de recherche-->
    <h1>Vos recherches</h1>
    <form action="index.php" method="get">
        <div class="search">
            <input name="produit" id= "barre" type="search" placeholder="rechercher une boutique ou un produit..." aria-label="Search">
            <input id="bouton" type="submit" value="rechercher">
        </div>
    </form>
    
    <!--Corps du site-->
    <?php
    //Récupère la base de données
    try {
        $sql = new PDO("mysql:host=localhost; dbname=geekzone_vitrine; charset=utf8", "root", "");
    } catch(Exception $e) {
        die("ERREUR : ".$e->getMessage());
    }

    /** Adapte le texte de la recherche pour la requête SQL */
    function getParameter($valeur) {
        if(isset($_GET[$valeur]))
            if($_GET[$valeur] != "")
                return "'%".str_replace(array(" ", "-"), "%", $_GET[$valeur])."%'";
        return "''";
    }
    
    $recherche = getParameter("produit");

    //Vérifie que l'utilisateur a fait une recherche
    if($recherche == "''") {
        //Ouvre le cadre des produits
        echo "<div class=\"info\" id=\"contour\"><div class=\"module-info\">";
        echo "<div class=\"titre\">Suggestions pour vous</div>";
        echo "<div class=\"flex\" id=\"centre\">";

        //Fait un tableau d'id aléatoire
        $nbProduit = $sql->query("SELECT COUNT(`produit_id`) FROM `produit`")->fetch()[0];
        srand();
        $tabId = array(rand(1,$nbProduit));
        
        //Vérifie que toutes les valeurs sont différentes
        while(count($tabId) < 4) {
            $random = rand(1,$nbProduit);
            $different = true;
            for($i=0; $i<count($tabId); $i++)
                if($tabId[$i] == $random)
                    $different = false;
            if($different)
                array_push($tabId, $random);
        }
        
        //Affiche les produits à partir des id aléatoires
        foreach($tabId as $cle=>$i) {
            $req = $sql->query("SELECT * FROM `produit` WHERE `produit_id`=".$i)->fetch();
            $categorie = $sql->query("SELECT `libelle` FROM `categorie` WHERE `categorie_id`=".$req["categorie"])->fetch()[0];
            echo "<div><a class=\"productName\" href=\"description.php?id=".$req["produit_id"]."\"><img class=\"img-produit\" src=\"images/".$categorie."/".$req["image"]."\">";
            echo "<p>".$req["nom"]."</br>";
            echo $req["prix"]."€</p></div>";
        }

        //Ferme le cadre
        echo "</div></div></div>";
    }
    else {
        //Vérifie que la recherche a un résultat
        $sizeProduit = $sql->query("SELECT COUNT(`produit_id`) FROM `produit` WHERE `nom` LIKE ".$recherche." OR `description` LIKE ".$recherche)->fetch()[0];
        $sizeBoutique = $sql->query("SELECT COUNT(`id`) FROM `boutique` WHERE `ville` LIKE ".$recherche." OR `cp` LIKE ".$recherche)->fetch()[0];
        $sizeCategorie = $sql->query("SELECT COUNT(`categorie_id`) FROM `categorie` WHERE `libelle` LIKE ".$recherche)->fetch()[0];
        if(($sizeProduit+$sizeBoutique+$sizeCategorie) == 0) {
            echo "Votre recherche \"".$_GET["produit"]."\" n'a pas donné de résultat";
        }
        else {
            //Crée un tableau d'id de catégories selon la recherche
            $tab = [];
            /*$taille = $sql->query("SELECT COUNT(`categorie_id`) FROM `categorie` WHERE `libelle` LIKE ".$recherche)->fetch()[0];
            for($i=0; $i<$taille; $i++) {
                array_push($tab, $sql->query("SELECT `id` FROM `categorie` WHERE `libelle` LIKE ".$recherche)->fetch()["id"]);
            }*/

            // Cadre produit
            echo "<div class=\"info\"><div class=\"module-info\">";
            echo "<div class=\"flex\" id=\"centre\">";
            //Recherche par produit
            for($i=0; $i<$sizeProduit; $i++) {
                $req = $sql->query("SELECT * FROM `produit` WHERE `nom` LIKE ".$recherche." OR `description` LIKE ".$recherche)->fetchall()[$i];
                $categorie = $sql->query("SELECT `libelle` FROM `categorie` WHERE `categorie_id`=".$req["categorie"])->fetch()[0];
                
                //Dans le cas où la recherche donne plus de 4 produits
                if($i%4==0 && $i!=0) {
                    echo "</div></div></div>";
                    echo "<div class=\"info\"><div class=\"module-info\">";
                    echo "<div class=\"flex\" id=\"centre\">";
                }

                // Affiche l'image
                echo "<div><a class=\"productName\" href=\"description.php?id=".$req["produit_id"]."\"><img class=\"img-produit\" src=\"images/".$categorie."/".$req["image"], "\">";
                // Affiche le libellé du produit
                echo "<p>", $req["nom"], "</br>", round(floatval($req["prix"]),2), "€</p></a></div>";
            }
            echo "</div></div></div>";

            //Recherche par boutique
            for($i=0; $i<$sizeBoutique; $i++) {
                //Récupère chaque boutique
                $req = $sql->query("SELECT * FROM `boutique` WHERE `ville` LIKE ".$recherche." OR `cp` LIKE ".$recherche)->fetchall()[$i];
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
        }
    }
    ?>

    <div class="footer">
		© 2021 - 2022 GeekZone
	</div>

    </body>
</html>