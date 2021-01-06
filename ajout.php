<?php 
header("Content-Type: text/html");

require_once("constantes.inc.php");

$nom = $_GET["nom"];
$prenom = $_GET["prenom"];
$numero=$_GET["numero"];
$ville=$_GET["ville"];
$numero=$_GET["numero"];
$date=$_GET["date"];
$taille=$_GET["taille"];

if($nom==null||$prenom==null||$ville==null){
    echo "ERREUR : Veuillez vérifier que le nom, le prénom et la ville du client sont bien renseignés.";
}else{
    try {
        $pdo = new PDO(DSN, UTILISATEUR, MDP); // tentative de connexion
        //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // utile pour le débogage
    } catch(PDOException $e) {
        echo "problème de connexion\n";
        echo $e->getMessage();
        exit(1); // on arrête le script en renvoyant un code d'erreur choisi par nous
    }

    if ($nom)
    try {
        $requetePreparee = $pdo->prepare('select count(*) from client where nom=? and prenom=? and ville=?');
        $requetePreparee->errorInfo();
        // les points d'interrogation sont des marqueurs de paramètres (le premier point d'interrogation porte le numéro 1)

        $requetePreparee->bindParam(1, $nom, PDO::PARAM_STR);
        $requetePreparee->bindParam(2, $prenom, PDO::PARAM_STR);
        $requetePreparee->bindParam(3, $ville, PDO::PARAM_STR);

        // ATTENTION !!! : si on utilise des variables au lieu de valeur en dur, il faut utiliser bindParam au lieu de bindValue
        $resultat = $requetePreparee->execute();
        if($resultat){
            $reponse=$requetePreparee->fetch();
            if ($reponse[0]>0){

                try {
                    $requetePreparee = $pdo->prepare('select id from client where nom=? and prenom=? and ville=?;');
                    $requetePreparee->errorInfo();
                    // les points d'interrogation sont des marqueurs de paramètres (le premier point d'interrogation porte le numéro 1)
                    $requetePreparee->bindParam(1, $nom, PDO::PARAM_STR);
                    $requetePreparee->bindParam(2, $prenom, PDO::PARAM_STR);
                    $requetePreparee->bindParam(3, $ville, PDO::PARAM_STR);


                    // ATTENTION !!! : si on utilise des variables au lieu de valeur en dur, il faut utiliser bindParam au lieu de bindValue
                    $resultat = $requetePreparee->execute();
                    if($resultat){
                        $lignes = $requetePreparee->fetchAll(); // on essaie de récupérer toutes les lignes
                        //var_export($lignes);
                        for($i = 0; $i < count($lignes); $i++) {

                            try {
                                $requetePreparee = $pdo->prepare('select count(*) from chambre where client_id=? and date=? and taille=? and numero=?;');
                                $requetePreparee->errorInfo();
                                // les points d'interrogation sont des marqueurs de paramètres (le premier point d'interrogation porte le numéro 1)

                                $requetePreparee->bindParam(1, $lignes[$i]['id'], PDO::PARAM_STR);
                                $requetePreparee->bindParam(2, $date, PDO::PARAM_STR);
                                $requetePreparee->bindParam(3, $taille, PDO::PARAM_STR);
                                $requetePreparee->bindParam(4, $numero, PDO::PARAM_STR);

                                // ATTENTION !!! : si on utilise des variables au lieu de valeur en dur, il faut utiliser bindParam au lieu de bindValue
                                $resultat = $requetePreparee->execute();

                                if($resultat){
                                     $reponses = $requetePreparee->fetch();
                                     if ($reponse[0]>0){
                                       try { 
                                            $requetePreparee = $pdo->prepare('update chambre set client_id=?, date=?, taille=? where numero=?;');
                                            $requetePreparee->errorInfo();
                                            // les points d'interrogation sont des marqueurs de paramètres (le premier point d'interrogation porte le numéro 1)

                                            $requetePreparee->bindParam(1, $lignes[$i]['id'], PDO::PARAM_STR);
                                            $requetePreparee->bindParam(2, $date, PDO::PARAM_STR);
                                            $requetePreparee->bindParam(3, $taille, PDO::PARAM_STR);
                                            $requetePreparee->bindParam(4, $numero, PDO::PARAM_STR);
                                            if($resultat){
                                                echo"Ajout réussi";
                                                
                                            }else{
                                                echo "Echec de l'ajout";

                                            }
                                        } catch(PDOException $e) {
                                            echo "problème avec la requête d'insertion\n";
                                            echo $e->getMessage();
                                            exit(1); // on arrête le script
                                        }  

                                    }else{
                                        try {
                                            $requetePreparee = $pdo->prepare('insert into chambre (client_id, date, taille, numero) values( ?, ?, ?, ?);');
                                            $requetePreparee->errorInfo();
                                            // les points d'interrogation sont des marqueurs de paramètres (le premier point d'interrogation porte le numéro 1)

                                            $requetePreparee->bindParam(1, $lignes[$i]['id'], PDO::PARAM_STR);
                                            $requetePreparee->bindParam(2, $date, PDO::PARAM_STR);
                                            $requetePreparee->bindParam(3, $taille, PDO::PARAM_STR);
                                            $requetePreparee->bindParam(4, $numero, PDO::PARAM_STR);

                                            // ATTENTION !!! : si on utilise des variables au lieu de valeur en dur, il faut utiliser bindParam au lieu de bindValue
                                            $resultat = $requetePreparee->execute();

                                            if($resultat){
                                                echo"Ajout réussi";
                                            }else{
                                                echo "Echec de l'ajout";

                                            }
                                        } catch(PDOException $e) {
                                            echo "problème avec la requête d'insertion\n";
                                            echo $e->getMessage();
                                            exit(1); // on arrête le script
                                        }  

                                    }
                                }else{
                                    echo "Echec de l'ajout";

                                }
                            } catch(PDOException $e) {
                                echo "problème avec la requête d'insertion\n";
                                echo $e->getMessage();
                                exit(1); // on arrête le script
                            }
                            
                        }
                    }else{
                        echo "Echec de l'ajout";

                    }
                } catch(PDOException $e) {
                    echo "problème avec la requête d'insertion\n";
                    echo $e->getMessage();
                    exit(1); // on arrête le script
                }   

            }else{
                try {
                    $requetePreparee = $pdo->prepare('insert into client (nom, prenom, ville) values( ?, ?, ?);');
                    $requetePreparee->errorInfo();
                    // les points d'interrogation sont des marqueurs de paramètres (le premier point d'interrogation porte le numéro 1)

                    $requetePreparee->bindParam(1, $nom, PDO::PARAM_STR);
                    $requetePreparee->bindParam(2, $prenom, PDO::PARAM_STR);
                    $requetePreparee->bindParam(3, $ville, PDO::PARAM_STR);

                    // ATTENTION !!! : si on utilise des variables au lieu de valeur en dur, il faut utiliser bindParam au lieu de bindValue
                    $resultat = $requetePreparee->execute();
                    if($resultat){
                        try {
                            $requetePreparee = $pdo->prepare('select * from client where nom=?;');
                            $requetePreparee->errorInfo();
                            // les points d'interrogation sont des marqueurs de paramètres (le premier point d'interrogation porte le numéro 1)

                            $requetePreparee->bindParam(1, $nom, PDO::PARAM_STR);


                            // ATTENTION !!! : si on utilise des variables au lieu de valeur en dur, il faut utiliser bindParam au lieu de bindValue
                            $resultat = $requetePreparee->execute();
                            if($resultat){
                                $lignes = $requetePreparee->fetchAll(); // on essaie de récupérer toutes les lignes
                         //var_export($lignes);
                                for($i = 0; $i < count($lignes); $i++) {

                                    try {
                                $requetePreparee = $pdo->prepare('select count(*) from chambre where client_id=? and date=? and taille=? and numero=?;');
                                $requetePreparee->errorInfo();
                                // les points d'interrogation sont des marqueurs de paramètres (le premier point d'interrogation porte le numéro 1)

                                $requetePreparee->bindParam(1, $lignes[$i]['id'], PDO::PARAM_STR);
                                $requetePreparee->bindParam(2, $date, PDO::PARAM_STR);
                                $requetePreparee->bindParam(3, $taille, PDO::PARAM_STR);
                                $requetePreparee->bindParam(4, $numero, PDO::PARAM_STR);

                                // ATTENTION !!! : si on utilise des variables au lieu de valeur en dur, il faut utiliser bindParam au lieu de bindValue
                                $resultat = $requetePreparee->execute();

                                if($resultat){
                                     $reponses = $requetePreparee->fetch();
                                     if ($reponse[0]>0){
                                       try { 
                                            $requetePreparee = $pdo->prepare('update chambre set client_id=?, date=? where numero=?;');
                                            $requetePreparee->errorInfo();
                                            // les points d'interrogation sont des marqueurs de paramètres (le premier point d'interrogation porte le numéro 1)

                                            $requetePreparee->bindParam(1, $lignes[$i]['id'], PDO::PARAM_STR);
                                            $requetePreparee->bindParam(2, $date, PDO::PARAM_STR);
                                            $requetePreparee->bindParam(4, $numero, PDO::PARAM_STR);
                                            if($resultat){
                                                echo"Ajout réussi";
                                            }else{
                                                echo "Echec de l'ajout";

                                            }
                                        } catch(PDOException $e) {
                                            echo "problème avec la requête d'insertion\n";
                                            echo $e->getMessage();
                                            exit(1); // on arrête le script
                                        }  

                                    }else{
                                        try {
                                            $requetePreparee = $pdo->prepare('insert into chambre (client_id, date, taille, numero) values( ?, ?, ?, ?);');
                                            $requetePreparee->errorInfo();
                                            // les points d'interrogation sont des marqueurs de paramètres (le premier point d'interrogation porte le numéro 1)

                                            $requetePreparee->bindParam(1, $lignes[$i]['id'], PDO::PARAM_STR);
                                            $requetePreparee->bindParam(2, $date, PDO::PARAM_STR);
                                            $requetePreparee->bindParam(3, $taille, PDO::PARAM_STR);
                                            $requetePreparee->bindParam(4, $numero, PDO::PARAM_STR);

                                            // ATTENTION !!! : si on utilise des variables au lieu de valeur en dur, il faut utiliser bindParam au lieu de bindValue
                                            $resultat = $requetePreparee->execute();

                                            if($resultat){
                                                echo"Ajout réussi";
                                            }else{
                                                echo "Echec de l'ajout";

                                            }
                                        } catch(PDOException $e) {
                                            echo "problème avec la requête d'insertion\n";
                                            echo $e->getMessage();
                                            exit(1); // on arrête le script
                                        }  

                                    }
                                }else{
                                    echo "Echec de l'ajout";

                                }
                            } catch(PDOException $e) {
                                echo "problème avec la requête d'insertion\n";
                                echo $e->getMessage();
                                exit(1); // on arrête le script
                            }  
                                }
                            }else{
                                echo "Echec de l'ajout";

                            }
                        } catch(PDOException $e) {
                            echo "problème avec la requête d'insertion\n";
                            echo $e->getMessage();
                            exit(1); // on arrête le script
                        }  


                        
                    }else{
                        echo "Echec de l'ajout";

                    }
                } catch(PDOException $e) {
                    echo "problème avec la requête d'insertion\n";
                    echo $e->getMessage();
                    exit(1); // on arrête le script
                }  
            }
        }   
    } catch(PDOException $e) {
        echo "problème avec la requête d'insertion\n";
        echo $e->getMessage();
        exit(1); // on arrête le script
    }  
}







?>
