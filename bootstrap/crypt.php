<?php

  // includes files from other files
  include_once __DIR__."/../modules/super_croissante_check.php";
  include_once __DIR__."/../modules/inv_mod_build.php";

  // avoir la clé publique
  function getPublicKey($tab = array(), $mod, $e) {
    $length_tab  = count($tab);
    $public_key  = array();
    $key_inv_mod = inv_mod($e, $mod);

    for ( $i = 0; $i < $length_tab; $i++) {
      $current_operation = ($tab[$i] * $e);
      $modulo_operation  = my_modulo($current_operation, $mod);
      array_push($public_key, $modulo_operation);
    }
    sort($public_key);
    echo "voici la clé publique : [ ";
    foreach ($public_key as $values_in_key) {
      echo $values_in_key, " ";
    }
    echo "]\n";
    echo "voici l'inverse modulaire : ", $key_inv_mod,"\n";
    return $public_key;
  }

  function cryptMessageToBin($message) {
    $binary_encode  = array();
    $count_test     = strlen($message);
    $current_result = null;

    for ($i = 0; $count_test > $i; $i++) {
      $current_result .= sprintf("%08d", decbin(ord($message[$i])));

      // array_push($binary_encode, $current_result);
    }
    return $current_result;
  }

  // couper le message
  function cutBinMessage($mess) {
    $message_bin      = null;
    $message_bin      = cryptMessageToBin($mess);
    $tmp_mess         = null;
    $bin_message_left = null;
    $bin_array        = array();
    $length_mess      = strlen($message_bin);
    $count_numbers    = 1;

    //pour couper le message en plusieur morceaux
    for ($i = 0; $i < $length_mess; $i++) {
      $tmp_mess .= $message_bin[$i];
      if ($count_numbers === 7) {
        array_push($bin_array, strrev($tmp_mess));
        $tmp_mess = null;
        $count_numbers = 0;
      }
      $count_numbers++;
    }
    // dans le cas ou il y a encore de bloc disponible, on le complete par des zero
    for ( $j = strlen($tmp_mess); $j < 7; $j++) {
      $tmp_mess .= 0;
    }
    array_push($bin_array, strrev($tmp_mess));
    return $bin_array;
  }

  // fonction pour calculer en fonction de la clé public
  function resultPublicKeyEncode($tab = array(), $mod, $e, $mess) {
    $public_key      = array();
    $message_sort    = array();
    $result_with_key = array();

    //on donne le limiteur, qui est de 7 de base ici mais qui sera dynamique en fonction de l'user
    // cette variable nous servira de variable temporaire pour stocker nos resultats
    $tmp_result = array();
    $tmp_value  = null;

    if (super_croissance_check($tab)) {
      $public_key   = getPublicKey($tab, $mod, $e);
      $message_sort = cutBinMessage($mess);

      // dans notre cas on va inverser le tableau en ordre croissant
      sort($public_key);

      //il ne reste plus qu'a crée une boucle pour parcourir le tableau
      for ($i = 0; $i < count($message_sort); $i++) {
        $tmp_value = $message_sort[$i];
        for ($j = 6; $j >= 0; $j--) {
          if($tmp_value[$j] == 1) {
            array_push($tmp_result, $public_key[$j]);
          }
        }
        array_push($result_with_key, array_sum($tmp_result));
        $tmp_result = array();
      }
      echo "message codé : ";
      foreach ($result_with_key as $values_in_key) {
        echo "[ ", $values_in_key, " ]";
      }
      echo "\n";
    }
  }

  // main function
  function cryptMessage($tab = array(), $mod, $e, $mess) {
    resultPublicKeyEncode($tab, $mod, $e, $mess);
  }
