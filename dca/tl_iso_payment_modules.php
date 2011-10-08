<?php if (!defined("TL_ROOT")) die("You can not access this file directly!");

/**
 * PHP version 5
 * @copyright  Wolfgang Plaschg 2011
 * @author     Wolfgang Plaschg <wolfgang.plaschg@gmail.com>
 * @package    isotope_pymt_mpay24_wmbi
 * @license	   GPL
 */
 

/*
 * palette
 */
$GLOBALS["TL_DCA"]["tl_iso_payment_modules"]["palettes"]["mpay24_wmbi"] = "{type_legend},name,label,type;{note_legend:hide},note;{config_legend},new_order_status,minimum_total,maximum_total,countries,shipping_modules,product_types;{price_legend:hide},price,tax_class;{mpay24_wmbi_legend},mpay24_merchant_id,mpay24_wmbi_checkout_jumpTo;{mpay24_wmbi_expert_legend:hide},mpay24_wmbi_test_mode,mpay24_wmbi_test_url,mpay24_wmbi_prod_url,mpay24_wmbi_confirmation_username,mpay24_wmbi_confirmation_password;{expert_legend:hide},guests,protected;{enabled_legend},enabled";
 

/*
 * fields
 */
$GLOBALS["TL_DCA"]["tl_iso_payment_modules"]["fields"]["mpay24_merchant_id"] = array(
	"label"						=> &$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_merchant_id"],
	"default"					=> "",
	"exclude"					=> true,
	"inputType"					=> "text",
	"eval"						=> array("mandatory" => true, "rgxp" => "digit", "tl_class" => "w50")
);

$GLOBALS["TL_DCA"]["tl_iso_payment_modules"]["fields"]["mpay24_wmbi_checkout_jumpTo"] = array(
	"label"						=> &$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_checkout_jumpTo"],
	"exclude"					=> true,
	"inputType"					=> "pageTree",
	'explanation'               => 'jumpTo',
	"eval"						=> array("mandatory" => true, "tl_class" => "clr", "fieldType" => "radio")
);

$GLOBALS["TL_DCA"]["tl_iso_payment_modules"]["fields"]["mpay24_wmbi_test_mode"] = array(
	"label"						=> &$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_test_mode"],
	"exclude"					=> true,
	"inputType"					=> "checkbox",
	"eval"						=> array("mandatory" => false, "tl_class" => "clr")
);

$GLOBALS["TL_DCA"]["tl_iso_payment_modules"]["fields"]["mpay24_wmbi_test_url"] = array(
	"label"						=> &$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_test_url"],
	"exclude"					=> true,
	"inputType"					=> "text",
	"eval"						=> array("mandatory" => false, "tl_class" => "w50")
);

$GLOBALS["TL_DCA"]["tl_iso_payment_modules"]["fields"]["mpay24_wmbi_prod_url"] = array(
	"label"						=> &$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_prod_url"],
	"exclude"					=> true,
	"inputType"					=> "text",
	"eval"						=> array("mandatory" => false, "tl_class" => "w50")
);

$GLOBALS["TL_DCA"]["tl_iso_payment_modules"]["fields"]["mpay24_wmbi_confirmation_username"] = array(
	"label"						=> &$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_confirmation_username"],
	"exclude"					=> true,
	"inputType"					=> "text",
	"eval"						=> array("mandatory" => false, "tl_class" => "w50")
);

$GLOBALS["TL_DCA"]["tl_iso_payment_modules"]["fields"]["mpay24_wmbi_confirmation_password"] = array(
	"label"						=> &$GLOBALS["TL_LANG"]["tl_iso_payment_modules"]["mpay24_wmbi_confirmation_password"],
	"exclude"					=> true,
	"inputType"					=> "text",
	"eval"						=> array("mandatory" => false, "tl_class" => "w50")
);

class PaymentMPay24IsoPaymentModule extends Backend {

	/**
	 * call parent constructor
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * replace umlaute
	 */
	public function reason($strValue, DataContainer $dc) {
		return utf8_romanize($strValue);
	}
}
	
?>
