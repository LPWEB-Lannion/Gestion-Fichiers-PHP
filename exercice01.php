<?php 
/*
 * Main function of exercice
 * parameters : 
 * $fd is the file descriptor
 * $headerKeysArray is the array of keys from the file header
 * 
 * return :
 * $articles : array of articles with id as key
 *
*/
function moulinette($fd, $headerKeys) {

    $articles = array();

    //Tant que la fin du fichier n'est pas atteint
    while (!feof($fd)) {
        
        //Lecture du fichier ligne par ligne sans les caractères spéciaux (fonction trim())
        $ligne = trim(fgets($fd));

        //Ignore les lignes vides
        if (empty($ligne)) {
            continue;
        }

        //Extrait une chaine de caractère
        $data = explode("\t", $ligne);

        //Sauveagrde le CODE de l'article 
        $id = $data[0];
        //Recupere le tableau data à partir de l'indice 1
        $values = array_slice($data, 1);

        //intval -> interger value
        if ((intval($values[6]) + intval($values[7]) + intval($values[8])) > 0) {
            $stock = "true";
        } 
        else {
            $stock = "false";
        }

        $i = 0;
        // Construit le tableau d'article avec la clef provenant de headerKeys
        foreach($values as $value) {
            // Condition d'arret 
            if (!isset($headerKeys[$i])) {
                break;
            }
            $article[$headerKeys[$i]]= $value;
            $i++;
        }

        $article['STOCK'] = $stock;
        $articles[$id] = $article;
    }
    
    return $articles;
}

/*
 * Main function of exercice
 * parameters : 
 * $fd is the file descriptor
 * 
 * return :
 * $headerFile : array of keys from the header, default values from exercice
 *
*/
function getFileHeader($fd) {
    
    $headerFile = array();

    if (!feof($fd)) {
        $ligne = trim(fgets($fd));

        if (empty($ligne)) {
            return $headerFile;
        }

        $keys = explode("\t", $ligne);

        foreach ($keys as $key) {
            $headerFile[] = $key;
        }

        if ($headerFile[0] == 'CODE') {
            $headerFile = array_slice($headerFile, 1);
        }

    }
    else {
        $headerFile = array(
            "DESIGNATION",
            "categorie",
            "prix_de_vente",
            "taux_de_tva",
            "fournisseur",
            "en_stock"
        );
    }
    return $headerFile;
}


//Ouverture du fichier 
if (file_exists('produits.dat')) {

    //Ouverture du fichier en mode lecture
    $fd = fopen('produits.dat', 'r');

    //Apelle de la fonction getFileHeader
    $headerKeys = getFileHeader($fd);

    //Apelle de la fonction moulinette
    $tableau_articles = moulinette($fd, $headerKeys);

    var_dump($tableau_articles);
    // var_dump($headerKeys);

    echo "Nombre d'articles : " . count($tableau_articles);

    //Fermeture du fichier
    fclose($fd);

}
?>