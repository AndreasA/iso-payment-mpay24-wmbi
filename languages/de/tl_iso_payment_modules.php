<?php if (!defined("TL_ROOT")) die("You can not access this file directly!");

/**
 * PHP version 5
 * @copyright  Wolfgang Plaschg 2011
 * @author     Wolfgang Plaschg <wolfgang.plaschg@gmail.com>
 * @package    isotope_pymt_mpay24_wmbi
 * @license	   GPL
 */
 

/*
 * legend
 */
$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_legend"] = "mPay24 WMBI Einstellungen";
$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_expert_legend"] = "mPay24 WMBI Experten-Einstellungen";


/*
 * fields
 */
$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_merchant_id"]	= array("MerchantID", "Geben Sie ihre Merchant ID bei mPay24 an.");
$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_checkout_jumpTo"] = array("Kassaseite", "Geben Sie eine Seite an, die das Kassamodul enthält (zB. checkout.html).");
$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_test_mode"] = array("Test-Modus", "Klicken Sie hier, wenn die Bezahlung im Testmodus ausgeführt werden soll.");
$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_test_url"] = array("URL zur WMBI Test-Schnittstelle", "Geben Sie hier die mpay24 WMBI Test-URL an.");
$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_prod_url"] = array("URL zur WMBI Produktions-Schnittstelle", "Geben Sie hier die mpay24 WMBI URL an.");
$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_confirmation_username"] = array("Confirmation Interface HTTP AUTH Benutzer", "Geben Sie hier den Benutzernamen ein, falls Sie das Confirmation Interface (postsale.php) per HTTP AUTH schützen.");
$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_confirmation_password"] = array("Confirmation Interface HTTP AUTH Passwort", "Geben Sie hier das Passwort ein, falls Sie das Confirmation Interface (postsale.php) per HTTP AUTH schüthen.");
?>
