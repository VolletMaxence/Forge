<?php

    //Faire une liaison entre entite equipement et entiteequipement

    class Marche extends Map{
        /* PRIVATE */

        /* METHOD */
        public function __construct($bdd){
            parent::__construct($bdd);
        }            

        public function livraison($nbrItem){
            for($i=0; $i<$nbrItem; $i++){
                $item = new Item($this->_bdd);
                $this->addItem($equipement->createItemAleatoire()); 
            }
        }

        public function acheter($entite, $idMap, $idEntite){
            $req = "SELECT mapitems.idMap, item.nom, item.valeur FROM `mapitems`, `item` WHERE item.id = mapitems.idItem AND `idMap` = $idMap";
            $RequetStatement = $this->_bdd->query($req);
            ?><form method="post"><table><?php
            while($Tab=$RequetStatement->fetch()){
                ?>
                    <tr>
                        <td> <?= $Tab[1] ?> </td>
                        <td> <?= $Tab[2] ?> </td>
                        <td><input type="radio" name="radio[]" value="<?= $Tab[0] ?>"></td>
                    </tr>
                <?php
            }
            ?></table><input type="submit" name="acheter" value="Acheter"></form><?php

            // Récupère l'argent du user
            $req = "SELECT user.money FROM `user`, `entite` WHERE user.idPersonnage=entite.id AND entite.id = $idEntite";
            $RequetStatement = $this->_bdd->query($req);
            while($Tab=$RequetStatement->fetch()){
                $money = $Tab[0];
            }
            if(isset($_POST['radio'])){
                foreach($_POST['radio'] as $checkId){
                    $item = new Item($this->_bdd);
                    $item->setItemById($checkId);
                    $valeur = $item->getValeur($checkId);
                }
                if($valeur > $money){
                    echo "Vous n'avez pas assez d'argent";
                }else{
                    $entite->addEquipement($equipement);
                    $this->removeEquipementById($checkId);
                    $money -= $valeur;
                    $req = "UPDATE `user`, `entite` SET user.money = $money WHERE user.idPersonnage=entite.id AND entite.id = $idEntite";
                    $RequetStatement = $this->_bdd->query($req);
                }
            }

        }

        public function vendre($entite, $idEntite){
            $req = "SELECT entiteequipement.idEquipement, equipement.nom, equipement.valeur FROM `entiteequipement`, `equipement` WHERE equipement.id = entiteequipement.idEquipement AND `equipe` != 1 AND `idEntite` = $idEntite";
            $RequetStatement = $this->_bdd->query($req);
            $equipements = $entite->getEquipementNonPorte();
            ?><form method="post"><table><?php
            while($Tab=$RequetStatement->fetch()){
                ?>
                    <tr>
                        <td> <?= $Tab[1] ?> </td>
                        <td> <?= $Tab[2] ?> </td>
                        <td><input type="checkbox" name="checkbox[]" value="<?= $Tab[0] ?>"></td>
                    </tr>
                <?php
            }
            ?></table><input type="submit" name="vendre" value="Vendre"></form><?php

            // Récupère l'argent du user
            $req = "SELECT user.money FROM `user`, `entite` WHERE user.idPersonnage=entite.id AND entite.id = $idEntite";
            $RequetStatement = $this->_bdd->query($req);
            while($Tab=$RequetStatement->fetch()){
                $money = $Tab[0];
            }
            if(isset($_POST['checkbox'])){
                foreach($_POST['checkbox'] as $checkId){
                    $equipement = new equipement($this->_bdd);
                    $equipement->setEquipementById($checkId);
                    $valeur = $equipement->getValeur($checkId);
                    $equipements = $entite->removeEquipementByID($checkId);
                    $money += $valeur;
                }
            }
            $req = "UPDATE `user`, `entite` SET user.money = $money WHERE user.idPersonnage=entite.id AND entite.id = $idEntite";
            $RequetStatement = $this->_bdd->query($req);

        }

        public function getNomMarche(){
            return 'Je suis le marché '.$this->_nom;
        }

        public function setMarcheById($id){
            parent::setMapById($id);
        }
    }

?>