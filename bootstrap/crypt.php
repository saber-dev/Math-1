<?php

  // includes files from other files
  include_once __DIR__."/../modules/super_croissante_check.php";
  include_once __DIR__."/../modules/inv_mod.php";

  function cryptMessageToBin($message) {
    $binary_encode  = array();
    $count_test     = strlen($message);
    $current_result = null;

    for ($i = 0; $count_test > $i; $i++) {
      $current_result .= sprintf("%08d", decbin(ord($message[$i])));
    }
    return $current_result;
  }

  // couper le message
  function cutBinMessage($mess, $bloc_limit) {
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
      // le limiteur est la
      if ($count_numbers == $bloc_limit) {
        array_push($bin_array, strrev($tmp_mess));
        $tmp_mess = null;
        $count_numbers = 0;
      }
      $count_numbers++;
    }
    // dans le cas ou il y a encore de bloc disponible, on le complete par des zero
    // ici le limiteur aussi
    for ( $j = strlen($tmp_mess); $j < $bloc_limit; $j++) {
      $tmp_mess .= 0;
    }
    array_push($bin_array, strrev($tmp_mess));
    return $bin_array;
  }

  // fonction pour calculer en fonction de la clé public
  function resultPublicKeyEncode($public_key = array(), $mess, $bloc_limit) {
    $message_sort    = array();
    $result_with_key = array();

    //on donne le limiteur, qui est de 7 de base ici mais qui sera dynamique en fonction de l'user
    // cette variable nous servira de variable temporaire pour stocker nos resultats
    $tmp_result = array();
    $tmp_value  = null;

    // $public_key   = getPublicKey($tab, $mod, $e);
    $message_sort = cutBinMessage($mess, $bloc_limit);
    // dans notre cas on va inverser le tableau en ordre croissant
    sort($public_key);

    $bloc_limit      = $bloc_limit - 1;
    //il ne reste plus qu'a crée une boucle pour parcourir le tableau
    for ($i = 0; $i < count($message_sort); $i++) {
      $tmp_value = $message_sort[$i];
      // ici le limiteur doit etre le limiteur - 1
      for ($j = $bloc_limit; $j >= 0; $j--) {
        if($tmp_value[$j] == 1) {
          array_push($tmp_result, $public_key[$j]);
        }
      }
      array_push($result_with_key, array_sum($tmp_result));
      $tmp_result = array();
    }
    echo "
                Chiffrement effectué avec success, Bernard envoie le message suivant à alice : ";
    foreach ($result_with_key as $values_in_key) {
      echo "[ ", $values_in_key, " ]";
    }
    echo "\n";
    return $result_with_key;
  }

  // main function
  function cryptMessage($tab = array(), $mess, $bloc_limit) {
    // on retourne le resultat
    return resultPublicKeyEncode($tab, $mess, $bloc_limit);
  }
