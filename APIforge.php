<?php //fichier modifier par M Vollet
//cette api doit etre lancé pour Vendre un objet
//cette API retourne un tableau avec La valeur, sa vie restant et sa vie de base
// cette api retour un tableau avec 0 si elle n'a pas eccecuter le code attendu
//une API ne dois sortir qu'un seul Echo celui de la reponse !!!!

//session_start();
//include "../session.php";

$reponse[0] = 0;

//A changer lors de l import dans le projet

//if($access)
//{
    $message = "";

    $forge = new forge($bdd);
    $forge->setForgeById($idMap);
    $entite->changeMap($forge);
    echo $forge->getNomForge().'<br>';
    $forge->vendre($entite, $idEntite);


    //appeler fonction pour vendre
    //afficher message selon objet / valeur grace a l'ID




    $reponse[0] = ;
    $reponse[1] = ;


//}
echo json_encode($reponse);
?>