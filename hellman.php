<?php
  include_once __DIR__."/bootstrap/crypt.php";
  include_once __DIR__."/bootstrap/decrypt.php";
  include_once __DIR__."/bootstrap/keyCrypt.php";
  include_once __DIR__."/modules/check_length_block.php";


  function hellman($private_key, $e, $mod,$block_limit, ) {
    //clé privée
    // $private_key = [1, 2, 5, 10, 20, 50, 100, 200];
    // $mod = 512;
    // $e = 255;

    //alice
    // tableau, la clé publique dans l'index 0, le mot de passe dans l'index 1, à changer, ne dois pas etre un array
    // if (super_croissance_check($private_key) && checkLengthBlock($private_key, $block_limit)) {
      // $public_key      = getPublicKey($private_key, $mod, $e, $block_limit);
      //Bernard
      $message_crypted = cryptMessage($public_key[0], "toto", $block_limit);
      // password
      // $passwd = $public_key[1];
      //alice
      // decrypt($public_key, $e, $mod, $message_crypted);
      decrypt($private_key, $e, $mod, $message_crypted, $passwd, $block_limit);
  // }
}

hellman(6);
