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
      return 0;
    }
    else {
      $current_tab = count_tab($tab);
      for ($i = 0; $i < $current_tab; $i++) {
          $actual_count = $i;
          // si c'est diferrent de zero
          echo "tableau actuel :", $tab[$actual_count], "\n";
          for($j = 0; $j < $actual_count; $j++) {
            echo "tableau auquel il doit utiliser :", $tab[$j], "\n";
            // echo $second, "\n";
            // echo $tab[$actual_count], "\n";
            // echo "le resultat est de : ", $test, "et il ne dois pas depasser le resulat suivant ; ", $tab[$actual_count],  "\n";
          }
          // echo $tab[$i] + $tab[$current_calcul], "\n";
      }
    }
  }

//test values
$tabTest = [1, 2, 5, 10, 20, 50];
super_croissance_check($tabTest);
// echo $tabTest[0] + $tabTest[3];
