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
$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_legend"] = "mPay24 WMBI Settings";
$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_expert_legend"] = "mPay24 WMBI Expert Settings";


/*
 * fields
 */
$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_merchant_id"]	= array("Merchant ID", "Provide your Merchant ID at mPay24.");
$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_checkout_jumpTo"]	= array("Checkout Page", "Provide the page that contains the checkout module. The user will be redirected to this page after payment .");
$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_test_mode"] = array("Test mode", "Click here to start the payment process in test mode.");
$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_test_url"] = array("URL to the WMBI Test Interface", "Provide the URL to the mPay24 WMBI test interface.");
$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_prod_url"] = array("URL to the WMBI Production Interface", "Provide the URL to the mPay24 WMBI interface.");
$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_confirmation_username"] = array("HTTP AUTH Username to Confirmation Interface", "Provide the Username, if you protect the Confirmation Interface (postsale.php) via HTTP authentication.");
$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_confirmation_password"] = array("HTTP AUTH Password to Confirmation Interface", "Provide the Password, if you protect the Confirmation Interface (postsale.php) via HTTP authentication.");
?>
