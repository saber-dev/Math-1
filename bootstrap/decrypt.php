<?php
  include_once __DIR__."/../modules/super_croissante_check.php";
  include_once __DIR__."/../modules/inv_mod_build.php";

  // decoder le message
  function decryptMess($mess = array(), $mod, $d) {
    $new_array = array();
    foreach ($mess as $values_in_mess) {
      $tmp_result = ($values_in_mess * $d);
      array_push($new_array, my_modulo($tmp_result, $mod));
    }
    return $new_array;
  }

  //fonction permettant de transformer le message codé en binaire
  function decryptMessToBin($key = array(), $mess = array()) {
    $key_count      = count_tab($key);
    $mess_count     = count_tab($mess);
    $result         = null;
    $bin_result     = null;
    $full_bin_mess  = null;
    $tmp_array      = array();
    $array_new      = array();
    $array_sort     = array();
    $sort_bin_array = array();

    // on met le tableau non ordonné dans un tableau vide
    $array_new = $key;

    natsort($array_new);
    // on doit ordonner le tableau pour decrypter le message
    foreach ($array_new as $values_in_array) {
      array_push($array_sort, $values_in_array);
    }

    // prendre les valeur dans le tableau
    for ($i = 0; $i < $mess_count; $i++) {
      $tmp_value = $mess[$i];
      if ($tmp_value == 0) {
        $full_bin_mess .= 0;
      }
      while ($tmp_value > 0) {
        for ($j = ($key_count -1); $j >= 0; $j--) {
          if ($tmp_value >= $array_sort[$j]) {

            $tmp_value -= $array_sort[$j];
            $result    += $array_sort[$j];

            // on push le resultat dans un tableau temporaire
            array_push($tmp_array, $array_sort[$j]);
          }
        }
        // dans le cas ou si jamais une piece du tableau comporte des zero
        // la variable K doit etre égal au limiteur - 1, par exemple si on utilise 7 comme limiteur, alors k devra 6
        for ($k = 6; $k >= 0; $k--) {
          if (in_array($key[$k], $tmp_array)) {
            $bin_result .= 1;
          }
          else {
            $bin_result .= 0;
          }
        }
        $full_bin_mess .= $bin_result;
        $bin_result     = null;
        $tmp_array      = array();
      }
    }
    $sort_bin_array = sortBinMess($full_bin_mess);
    // echo $full_bin_mess, "\n";
    sortBinMessToRealMess($sort_bin_array);
  }

  // ordonner le binaire en 8 bloc
  function sortBinMess($mess) {
    $tmp_mess      = null;
    $bin_array     = array();
    $length_mess   = strlen($mess);
    $count_numbers = 1;

    //pour couper le message en plusieur morceaux en bloc de 8 chacune
    for ($i = 0; $i < $length_mess; $i++) {
      $tmp_mess .= $mess[$i];
      if ($count_numbers === 8) {
        array_push($bin_array, $tmp_mess);
        $tmp_mess = null;
        $count_numbers = 0;
      }
      $count_numbers++;
    }
    // retourner un array ordonné en 8bloc chacune
    return $bin_array;
  }

  // la traduction du tableau de binaire et l'affichage du message
  function sortBinMessToRealMess($tab = array()) {
    $mess_decoded = null;

    foreach ($tab as $result_values) {
      $mess_decoded .= chr(bindec($result_values));
    }
    echo "Alice reçoit Le Message, et trouve comme Message une fois dechiffré : ", $mess_decoded, "\n";
  }

  // decoder la clé publique
  function decryptKey($tab = array(), $d, $mod) {
    $bin_message = null;
    $tmp_array = array();
    $array_new = array();
    // parcours du tableau
    foreach($tab as $message ) {
      //calcul du resultat
      $tmp_result = ($message * $d);
      // ajout dans le tableau accompagné de son modulo
      array_push($tmp_array, my_modulo($tmp_result, $mod));
    }
    return $tmp_array;
  }

  // fonction maitresse
  function decrypt($tab = array(),$e, $mod, $mess = array(), $passKey) {

    $new_key = array();
    // $key_array     = array();
    $message_array = array();
    // calcul de l'inverse modulaire
    $inverse       = inv_mod($e, $mod);
    $new_key       = passwd($passKey, $tab);
    // $key_array     = decryptKey($tab, $inverse, $mod);
    $message_array = decryptMess($mess, $mod, $inverse);

    decryptMessToBin($new_key, $message_array);
  }

  // function permettant de dechiffrer le password
  function passwd($string, $tab){
   $new_array    = array();
   $tmp_result   = null;
   $count_string = strlen($string);

   for ($i = 0;$i < $count_string;$i++){
     $tmp_result = $string[$i];
     array_push($new_array, $tab[$tmp_result]);
   }
   return $new_array;
  }
