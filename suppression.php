<?php 
header("Content-Type: text/html");

require_once("constantes.inc.php");

$nom = $_GET["nom"];
$prenom = $_GET["prenom"];
$ville = $_GET["ville"];
$date=$_GET["date"];
try {
    $pdo = new PDO(DSN, UTILISATEUR, MDP); // tentative de connexion
    //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // utile pour le débogage
} catch(PDOException $e) {
    echo "problème de connexion\n";
    echo $e->getMessage();
    exit(1); // on arrête le script en renvoyant un code d'erreur choisi par nous
}

try {
    $requetePreparee = $pdo->prepare('select id from client where nom=? and prenom=? and ville=?;');
    $requetePreparee->errorInfo();
    // les points d'interrogation sont des marqueurs de paramètres (le premier point d'interrogation porte le numéro 1)
    $requetePreparee->bindParam(1, $nom, PDO::PARAM_STR);
	$requetePreparee->bindParam(2, $prenom, PDO::PARAM_STR);
	$requetePreparee->bindParam(3, $ville, PDO::PARAM_STR);
    // ATTENTION !!! : si on utilise des variables au lieu de valeur en dur, il faut utiliser bindParam au lieu de bindValue
    $resultat = $requetePreparee->execute();
    
    if ($resultat) {

		$lignes = $requetePreparee->fetchAll(); // on essaie de récupérer toutes les lignes
				        //var_export($lignes);

		for($i = 0; $i < count($lignes); $i++) {
			$id=$lignes[$i]['id'];
		} 
		try {
		    $requetePreparee = $pdo->prepare('update chambre set client_id=?, date=? where client_id=? and date=?;');
		    $requetePreparee->errorInfo();
		    // les points d'interrogation sont des marqueurs de paramètres (le premier point d'interrogation porte le numéro 1)
		    $requetePreparee->bindValue(1, NULL, PDO::PARAM_STR);
		    $requetePreparee->bindValue(2, NULL, PDO::PARAM_STR);
		    $requetePreparee->bindParam(3, $id, PDO::PARAM_STR);
			$requetePreparee->bindParam(4, $date, PDO::PARAM_STR);
		    // ATTENTION !!! : si on utilise des variables au lieu de valeur en dur, il faut utiliser bindParam au lieu de bindValue
		    $resultat = $requetePreparee->execute();

		    if ($resultat){
		    	echo "suppression de la résérvation réussie\n";
		    }else{
		    	echo "suppression de la résérvation échouée\n";
		    }
		}
		catch(PDOException $e) {
			    echo "problème avec la requête d'insertion\n";
			    echo $e->getMessage();
			    exit(1); // on arrête le script
		}    

    } else {
        echo "échec\n";
        //echo $pdo->errorInfo()[2], "\n";
        echo $requetePreparee->errorInfo()[2], "\n";
    }
}
catch(PDOException $e) {
	    echo "problème avec la requête d'insertion\n";
	    echo $e->getMessage();
	    exit(1); // on arrête le script
}
