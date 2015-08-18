<?php

// count the tab's length
  function count_tab($tab = array()) {
    if (!is_array($tab)){
      return False;
    }
    else {
      return count($tab);
    }
  }

//check if array is "super croissante"
  function super_croissance_check($tab = array()) {
    $current_tab = array();
    if (!count_tab($tab)) {
      echo "ceci est pas un tableau\n";
      return false;
    }
    else {
      // tableau de check
      $tab_check   = array();
      $current_tab = count_tab($tab);
      for ($i = 0; $i < $current_tab; $i++) {
          $actual_count = $i;
          // si c'est diferrent de zero
          for($j = 0; $j < $actual_count; $j++) {
            // on push les valeur dans un autre tableau
            array_push($tab_check, $tab[$j]);
          }
          // on place la somme du tableau dans une variable
          $result = array_sum($tab_check);
          // si le tableau n'est pas une supercroissante
          if ($tab[$actual_count] < $result) {
            echo "le tableau n'est pas une suite supercroissante\n";
            return false;
          }
          // on reset le tableau pour le prochain resultat
          $tab_check = array();
      }
      // on affiche un message si c'est bien une suite supercroissante
      echo "Apres vérification, alice confirme que c'est une suite supercroissante\n";
      return true;
    }
  }
