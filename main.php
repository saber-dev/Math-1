<?php

  // includes files from other files
  include_once __DIR__."/modules/super_croissante_check.php";
  include_once __DIR__."/modules/inv_mod_build.php";

  function getPublicKey($tab = array(), $mod, $e) {
    $length_tab = count($tab);
    $public_key = array();
    $key_inv_mod = inv_mod($e, $mod);
    // verifier si c'est une supercroissante
    if (super_croissance_check($tab)) {
      for ( $i = 0; $i < $length_tab; $i++) {
        $current_operation = ($tab[$i] * $e);
        $modulo_operation = my_modulo($current_operation, $mod);
        array_push($public_key, $modulo_operation);
      }
      natsort($public_key);
      echo "voici la clé publique : \n";
      print_r($public_key);
      echo "voici la clé principale : ", $key_inv_mod,"\n";
    }
  }

  function cryptMessage() {

  }

  echo ord("S");
  $tabTest = [1, 3, 5, 11, 25, 53, 101, 205, 512];
  //
  getPublicKey($tabTest, 960, 143);
  // super_croissance_check($tabTest);
  //
  //
  //
  // //Exemple avec de grands nombres
  // $number = 512 * 143;
  // //inv_mod($number, 960);
  // echo my_modulo($number, 960);

  // echo my_modulo($number, 960);
