<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$recaptcha['development']['public_key']   = '6LexnuoSAAAAACzbXNAf3Ul1qgBeubEWOIxbqk0b';
$recaptcha['development']['private_key']  = '6LexnuoSAAAAAMsVr9HWpykARQhecRJ-NAeRgf74';
$recaptcha['production']['public_key']   = '6LeOneoSAAAAAPxWX1XOJFFDSHHel811saFQvELE';
$recaptcha['production']['private_key']  = '6LeOneoSAAAAAKcZfvAKicQd6_spDKVxDe0vxkkI';
$config['public_key']   = $recaptcha[ENVIRONMENT]['public_key'];
$config['private_key']  = $recaptcha[ENVIRONMENT]['private_key'];
// Set Recaptcha theme, default red (red/white/blackglass/clean)
$config['recaptcha_theme']  = 'white';
?>
