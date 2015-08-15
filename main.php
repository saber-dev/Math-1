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
        $modulo_operation  = my_modulo($current_operation, $mod);
        array_push($public_key, $modulo_operation);
      }
      natsort($public_key);
      echo "voici la clé publique : \n";
      // print_r($public_key);
      echo "voici la clé principale : ", $key_inv_mod,"\n";
    }
  }

  function cryptMessageToBin($message) {
    $binary_encode  = array();
    $count_test     = strlen($message);
    $current_result = null;

    for ($i = 0; $count_test > $i; $i++) {
      $current_result = sprintf("%08d", decbin(ord($message[$i])));
      array_push($binary_encode, $current_result);
    }
    cutBinMessage($binary_encode);
  }

  function cutBinMessage($tabCrypt = array()) {
    echo "function cutBinMessage called\n";
    print_r($tabCrypt);
  }

  cryptMessageToBin("RAS");
  //echo ord("R");
  // echo decbin(ord("R"));
  // $tabTest = [1, 3, 5, 11, 25, 53, 101, 205, 512];
  // //
  // getPublicKey($tabTest, 960, 143);
  // super_croissance_check($tabTest);
  //
  //
  //
  // //Exemple avec de grands nombres
  // $number = 512 * 143;
  // //inv_mod($number, 960);
  // echo my_modulo($number, 960);

  // echo my_modulo($number, 960);
