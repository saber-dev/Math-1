<?php
  include_once __DIR__."/bootstrap/crypt.php";
  include_once __DIR__."/bootstrap/decrypt.php";
  include_once __DIR__."/bootstrap/keyCrypt.php";


  //private key
  $private_key = [1, 2, 5, 10, 20, 50, 100, 200, 500];

  $mod = 960;
  $e = 143;
  // //clé publique
  // $tabTmp = [43, 143, 256, 429, 515, 613, 695, 715, 859];

  //alice
  // tableau, la clé publique dans l'index 0, le mot de passe dans l'index 1, à changer, ne dois pas etre un array
  $public_key      = getPublicKey($private_key, $mod, $e);

  //Bernard
  $message_crypted = cryptMessage($public_key[0], "Bonjour, je m'apelle mahefa Andrianifahanana, numero de matricule 01234567890 avec comme nom de code lapin");
  // $message_crypted = cryptMessage($public_key, $mod, $e, "Mahefa Andrianifahanana");
  // password
  $passwd = $public_key[1];

  //alice
  // decrypt($public_key, $e, $mod, $message_crypted);
  decrypt($private_key, $e, $mod, $message_crypted, $passwd);
