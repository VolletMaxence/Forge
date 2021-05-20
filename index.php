<?php

    include("bdd.php");
    include("map.php");
    include("forge.php");
    include("entite.php");
    include("object.php");
    include("equipement.php");

    $idEntite = 1938;
    $idMap = 4330;
    $entite = new Entite($bdd);
    $entite->setEntiteById($idEntite);
    $map = new Map($bdd);
    $map->setMapById($idMap);
    $map->generateMap();
    if($map->isForge()){
        $forge = new forge($bdd);
        $forge->setForgeById($idMap);
        $entite->changeMap($forge);
        echo $forge->getNomForge().'<br>';
        $nbrEquipement = count($map->getEquipements());        
        $forge->livraison(10 - $nbrEquipement);
        $forge->vendre($entite, $idEntite);
        //$forge->acheter($entite, $idMap, $idEntite);

    }else if($map->isMarché()){
        $marche = new forge($bdd);
        $marche->setForgeById($idMap);
        $marche->changeMap($forge);
        echo $forge->getNomForge().'<br>';
        $nbrItem = count($map->getItems());        
        $marche->livraison(10 - $nbrItem);
        $marche->vendre($entite, $idEntite);
        //$marche->acheter($entite, $idMap, $idEntite);

    }else{
        echo 'Je suis une map '.$map->getNom();
    }

?>