<?php
header("Content-Type: text/html");

require_once("constantes.inc.php");


$nChambre = $_GET["nChambre"];
$date=$_GET["date"];

                    


// ici, il faudrait interroger la base de données
// (on connait la date, mais il faudrait aussi connaître le créneau)
try {
    $pdo = new PDO(DSN, UTILISATEUR, MDP); // tentative de connexion
    //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // utile pour le débogage
} catch(PDOException $e) {
    echo "problème de connexion\n";
    echo $e->getMessage();
    exit(1); // on arrête le script en renvoyant un code d'erreur choisi par nous
}

try {
    $requetePreparee = $pdo->prepare('select count(*) from chambre where numero=? and date=?;');
    $requetePreparee->errorInfo();
    // les points d'interrogation sont des marqueurs de paramètres (le premier point d'interrogation porte le numéro 1)
    $requetePreparee->bindParam(1, $nChambre, PDO::PARAM_STR);
    $requetePreparee->bindParam(2, $date, PDO::PARAM_STR);

    // ATTENTION !!! : si on utilise des variables au lieu de valeur en dur, il faut utiliser bindParam au lieu de bindValue
    $resultat = $requetePreparee->execute();
    if ($resultat) {
  
        $reponse = $requetePreparee->fetch(); // on essaie de récupérer toutes les lignes
        //var_export($reponse);
        if ($reponse[0]>0){
        	try {
				    $requetePreparee = $pdo->prepare('select * from chambre ch join client cl on(ch.client_id =cl.id) where numero=? and date=?;');
				    $requetePreparee->errorInfo();
				    // les points d'interrogation sont des marqueurs de paramètres (le premier point d'interrogation porte le numéro 1)
				    $requetePreparee->bindParam(1, $nChambre, PDO::PARAM_STR);
				    $requetePreparee->bindParam(2, $date, PDO::PARAM_STR);
				    // ATTENTION !!! : si on utilise des variables au lieu de valeur en dur, il faut utiliser bindParam au lieu de bindValue
				    $resultat = $requetePreparee->execute();
				    
				    if ($resultat) {

				        $lignes = $requetePreparee->fetchAll(); // on essaie de récupérer toutes les lignes
				        //var_export($lignes);

				        for($i = 0; $i < 1; $i++) {

			        		echo "<h2>Chambre N°",$lignes[$i]['numero'],"</h2>";
				        	echo "<label for='nom'>Nom du client :</label>";
				        	echo "<input type='text' id='nom' name='nom' value=",$lignes[$i]['nom']," disabled><br/><br/>";
				        	echo "<label for='prenom'>Prenom du client :</label>";
				        	echo "<input type='text' id='prenom' name='prenom' value=",$lignes[$i]['prenom']," disabled><br/><br/>";
				        	echo "<label for='ville'>Ville :</label>";
	        				echo "<input type='text' id='ville' name='ville' value=",$lignes[$i]['ville']," disabled><br/><br/>";
	        				echo "<label for='taille'>Taille de la chambre :</label>";
				        	echo "<input type='text' id='taille' name='taille' value=",$lignes[$i]['taille']," disabled><br/><br/>";   
				        	echo "<label for='numero'>Numero de la chambre :</label>";
				        	echo "<input type='text' id='numero' name='numero' value=",$lignes[$i]['numero']," disabled><br/><br/>";   
				        	echo "<input type='submit' value='enregistrer' class='btn btn-primary' onClick='ajout()'/>";
				        	echo "<input type='submit' value='supprimer réservation' class='btn btn-primary' onClick='suppression()'/>";

				        	                           
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
			}else{
				try {
				    $requetePreparee = $pdo->prepare('select * from chambre where numero=?;');
				    $requetePreparee->errorInfo();
				    // les points d'interrogation sont des marqueurs de paramètres (le premier point d'interrogation porte le numéro 1)
				    $requetePreparee->bindParam(1, $nChambre, PDO::PARAM_STR);

				    // ATTENTION !!! : si on utilise des variables au lieu de valeur en dur, il faut utiliser bindParam au lieu de bindValue
				    $resultat = $requetePreparee->execute();
				    if ($resultat) {
				    	$lignes = $requetePreparee->fetchAll();
		        		for($i = 0; $i < 1; $i++) {
				        	if ($lignes[$i]['client_id']==""){
					        	echo "<h2>Chambre N°",$lignes[$i]['numero'],"</h2>";
					        	echo "<label for='nom'>Nom du client :</label>";
					        	echo "<input type='text' id='nom' name='nom' ><br/><br/>";
					        	echo "<label for='prenom'>Prenom du client :</label>";
					        	echo "<input type='text' id='prenom' name='prenom' ><br/><br/>";
					        	echo "<label for='ville'>Ville :</label>";
					        	echo "<input type='text' id='ville' name='ville' ><br/><br/>";
		        				echo "<label for='taille'>Taille de la chambre :</label>";
					        	echo "<input type='text' id='taille' name='taille' value=",$lignes[$i]['taille']," disabled><br/><br/>";     
					        	echo "<label for='numero'>Numero de la chambre :</label>";
					        	echo "<input type='text' id='numero' name='numero' value=",$lignes[$i]['numero']," disabled><br/><br/>";   
					        	echo "<input type='submit' value='enregistrer' class='btn btn-primary' onClick='ajout()'/>";


		        	

		        	         }                  
		       			}
		        	}
        
				}catch(PDOException $e) {
					echo "problème avec la requête d'insertion\n";
				    echo $e->getMessage();
				    exit(1); // on arrête le script
				}
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




?>
