<?php 
header("Content-Type: text/xml");

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
require_once("constantes.inc.php");

//$date = $_GET["date"];
$etage=$_GET["etage"];
$date=$_GET["date"];


try {
    $pdo = new PDO(DSN, UTILISATEUR, MDP); // tentative de connexion
    //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // utile pour le débogage
} catch(PDOException $e) {
    echo "problème de connexion\n";
    echo $e->getMessage();
    exit(1); // on arrête le script en renvoyant un code d'erreur choisi par nous
}



if ($etage=="RDC"){
	
	echo "<chambres>\n";
	for ($i=1; $i<=13; $i++){
		try {
			    $requetePreparee = $pdo->prepare('select client_id from chambre where numero = ? and date = ? ;');
			    $requetePreparee->errorInfo();
			    // les points d'interrogation sont des marqueurs de paramètres (le premier point d'interrogation porte le numéro 1)
			    $requetePreparee->bindParam(1, $i, PDO::PARAM_STR);
			    $requetePreparee->bindParam(2, $date, PDO::PARAM_STR);

			    // ATTENTION !!! : si on utilise des variables au lieu de valeur en dur, il faut utiliser bindParam au lieu de bindValue
			    $resultat = $requetePreparee->execute();
			    
			    if ($resultat) {

			        $reponse=$requetePreparee->fetch();
        			if ($reponse[0]>0){
        				$etat="reserve";
        			} else{
        				$etat="libre";
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
		echo "    <chambre>\n";
		echo "        <numero>$i</numero>\n";
		echo "        <etat>$etat</etat>\n";
		echo "    </chambre>\n";

	}
		echo "    <chambre>\n";
		echo "        <numero>14</numero>\n";
		echo "        <etat>reception</etat>\n";
		echo "    </chambre>\n";
	echo "</chambres>\n";

}

if($etage==1){	
	echo "<chambres>\n";
	for ($i=101; $i<=113; $i++){
		try {
			    $requetePreparee = $pdo->prepare('select client_id from chambre where numero=? and date=?;');
			    $requetePreparee->errorInfo();
			    // les points d'interrogation sont des marqueurs de paramètres (le premier point d'interrogation porte le numéro 1)
			    $requetePreparee->bindParam(1, $i, PDO::PARAM_STR);
			    $requetePreparee->bindParam(2, $date, PDO::PARAM_STR);

			    // ATTENTION !!! : si on utilise des variables au lieu de valeur en dur, il faut utiliser bindParam au lieu de bindValue
			    $resultat = $requetePreparee->execute();
			    
			    if ($resultat) {

			        $reponse=$requetePreparee->fetch();
        			if ($reponse[0]>0){
        				$etat="reserve";
        			} else{
        				$etat="libre";
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
		echo "    <chambre>\n";
		echo "        <numero>$i</numero>\n";
		echo "        <etat>$etat</etat>\n";
		echo "    </chambre>\n";

	}
	echo "</chambres>\n";

}
if($etage==2){	
	echo "<chambres>\n";
	for ($i=201; $i<=209; $i++){
		try {
			    
			    $requetePreparee = $pdo->prepare('select client_id from chambre where numero=? and date=?;');
			    $requetePreparee->errorInfo();
			    // les points d'interrogation sont des marqueurs de paramètres (le premier point d'interrogation porte le numéro 1)
			    $requetePreparee->bindParam(1, $i, PDO::PARAM_STR);
			    $requetePreparee->bindParam(2, $date, PDO::PARAM_STR);

			    // ATTENTION !!! : si on utilise des variables au lieu de valeur en dur, il faut utiliser bindParam au lieu de bindValue
			    $resultat = $requetePreparee->execute();
			    
			    if ($resultat) {

			        $reponse=$requetePreparee->fetch();
        			if ($reponse[0]>0){
        				$etat="reserve";
        			} else{
        				$etat="libre";
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
		echo "    <chambre>\n";
		echo "        <numero>$i</numero>\n";
		echo "        <etat>$etat</etat>\n";
		echo "    </chambre>\n";

	}
	echo "</chambres>\n";

}
?>
