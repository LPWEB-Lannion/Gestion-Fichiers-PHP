<?php 

//**********  DEBUT Declaration fonction moulinette() **********/
function moulinette($file) {

    $articles = array();

    //Tant que la fin du fichier n'est pas atteint
    while(! feof($file)) {
        
        //Lecture du fichier ligne par ligne
        $ligne = trim(fgets($file));

        $data = explode("\t", $ligne);

        if(($data[7] + $data[8] + $data[9]) < 0) {
            $en_stock = "N";
        } 
        else {
            $en_stock = "O";
        }

        $articles[$data[0]] = [
            "designation" => $data[1],
            "categorie" => $data[2],
            "prix_de_vente" => $data[5],
            "taux_de_tva" => $data[6],
            "fournisseur" => $data[10],
            "en_stock" => $en_stock
        ];

    }

    return $articles;
}
   


//**********  FIN Declaration fonction moulinette() ***********/

//Ouverture du fichier 
if(file_exists('produits.dat')) {

    $ressource = fopen('produits.dat', 'r');

    //Apelle de la fonction moulinette
    $tableau_articles = moulinette($ressource);

    var_dump($tableau_articles);
    
    //Compte le nombre d'article
    $nombre_article = count($tableau_articles) - 2;

    echo "Nombre d'articles : " . $nombre_article;

    //Fermeture du fichier
    fclose($ressource);

}


?>