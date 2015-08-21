<?php
include_once __DIR__."/bootstrap/crypt.php";
include_once __DIR__."/bootstrap/decrypt.php";
include_once __DIR__."/bootstrap/keyCrypt.php";


// convert le CLI en array
function stringToArray($string) {
    $count_string = strlen($string);
    $tmp_string   = null;
    $actual_string = null;
    $new_array = array();

    for($i = 0; $i < $count_string; $i++) {
        $tmp_string = $string[$i];
        if(!is_numeric($tmp_string)) {
            array_push($new_array, $actual_string);
            $actual_string = null;
        }
        else {
            $actual_string .= $string[$i];
        }
    }
    return $new_array;
}

function toto($a) {


    echo shell_exec('clear');
    echo "
                Bonjour, mon nom est Bernard, je suis la pour crypter votre message.\n
                Vous etes Alice, et votre but est de m'envoyer une clé publique pour que je puisse chiffrer mon message ...\n
                D'abord, vous devez créer une clé privée, celle ci doit etre une suite super-croissante :\n
                Alice : ";

    while(true) {

// bernard : votre private key
        $pKey = readline($a);
        $private_key = stringToArray($pKey);

        if(!super_croissance_check($private_key)) {

            echo "
                Veuillez entrer une suite super croissante\n";
            $pKey = readline($a);
            $private_key = stringToArray($pKey);

            if(!super_croissance_check($private_key)) {
                echo "
                Vas t'acheter des doigts !\n";
                exit;
            }
        }
        // sleep(1);
        echo "
                Hum... c'est bien une suite supercroissante.\n";

//  bernard :      votre mod
        echo "
                Maintenant, un modulo :\n
                Alice : ";
        $mod = readline($a);

        if(!is_numeric($mod)) {
            echo "\n
                Je n'ai pas compris, 'ai besoin d'un entier pour pouvoir continuer.\n
                Alice : \n";
            $mod = readline($a);

            if(!is_numeric($mod)) {
                echo "
                Je n'ai toujours pas compris, pour eviter l'explosion de la terre je m'arette la.\n";
                exit;
            }
        }

// bernard : votre $e
        echo "
                Bien ! Maintenant un entier e.\n
                Alice : ";
        $e = readline($a);

        if(!is_numeric($e)) {
            echo "\n
                Je n'ai pas compris, 'ai besoin d'un entier pour pouvoir continuer\n
                Alice : ";
            $e = readline($a);
            if(!is_numeric($e)) {
                echo "
                Je n'ai toujours pas compris, je ... je dois vous laisser, j'ai oublié, une fourchette dans le micro-ondes\n";
                exit;
            }
        }


//        /echo "E :: $e ::";

//        limit > 4
        echo "
                Et pour finir un entier bloc pour limiter les bloc messages dont la longueur doit etre supérieur à 4 et que la longueur de cl2 privée ne depasse pas celle ci\n
                Alice : ";
        $limit = readline($a);

        if($limit <= 4 || $limit > count($private_key)) {
            echo "\n
                Hum pouvez vous recommencer ? la limite ne correspond pas au regles decrites tout à l'heure\n
                Alice : ";
            $limit = readline($a);
            if(!$limit <= 4 || $limit > count($private_key)) {
                echo "
                Hum, pouvez vous vous acheter des doigts ?\n";
                exit;
            }
        }
        echo "\n";
        // sleep(2);
        $public_key = array();
        $public_key = getPublicKey($private_key, $mod, $e, $limit);

//        bernard votre message
        echo "\n
                Tout est bon ! il ne reste plus que le message a crypter.\n
                Bernard : ";
        $mess = readline($a);
        echo "\n";
        // sleep(2);

        echo $mess, "\n";
        var_dump($public_key[0]);
        echo $limit, "\n";
        $message_crypted = cryptMessage($public_key[0], $mess, $limit);
        // $message_crypted = cryptMessage($public_key[0], $mess, $limit);

        $passwd = $public_key[1];
        // decrypt($private_key, $e, $mod, $message_crypted, $passwd, $limit);
        decrypt($private_key, $e, $mod, $message_crypted, $passwd, $limit);
        exit;

    }
echo "\n";
}

toto($argv[1]);
