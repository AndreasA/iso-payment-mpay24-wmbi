<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Wolfgang Plaschg 2011
 * @author     Wolfgang Plaschg <wolfgang.plaschg@gmail.com>
 * @package    isotope_pymt_mpay24_wmbi
 * @license    GPL
 */
 
 
/**
 * Handle mPay24 payments
 * 
 * @extends Payment
 */
class PaymentMPay24WMBI extends IsotopePayment
{

	/**
	 * Return a list of status options.
	 * 
	 * @access public
	 * @return array
	 */
	public function statusOptions()
	{
		return array('pending', 'processing', 'complete', 'on_hold');
	}
	
	/**
	 * processPayment function.
	 * 
	 * @access public
	 * @return boolean
	 */
	public function processPayment()
	{
		return true;
	}
	
	/**
	 * log_debug function.
	 * 
	 * @access protected
	 * @param string
	 */
	protected function log_debug($strMessage)
	{
		@error_log(sprintf("[%s] %s\n", date('d-M-Y H:i:s'), $strMessage), 3, TL_ROOT . '/system/logs/iso_mpay24_debug.log');
	}
	
	protected function log_error($strMessage)
	{
		@error_log(sprintf("[%s] %s\n", date('d-M-Y H:i:s'), $strMessage), 3, TL_ROOT . '/system/logs/iso_mpay24_error.log');
	}
	
	protected function log_confirmation($strMessage)
	{
		@error_log(sprintf("[%s]\n%s\n", date('d-M-Y H:i:s'), $strMessage), 3, TL_ROOT . '/system/logs/iso_mpay24_confirmation.log');
	}
	
	/**
	 * Redirect the user to the mPay24 WMBI Interface.
	 * 
	 * @access public
	 */
	public function checkoutForm()
	{
		$this->import('Isotope');
		$objOrder = new IsotopeOrder();
		if (!$objOrder->findBy('cart_id', $this->Isotope->Cart->id))
			$this->redirect($this->addToUrl('step=failed', true));

		$objMdxiTemplate = new FrontendTemplate("mpay24_mdxi");
		
		// Prepare Shopping cart items
		foreach($this->Isotope->Cart->getProducts() as $objProduct)
		{
			// Get string with options
			$arrOptions = $objProduct->getOptions();
			if (is_array($arrOptions) && count($arrOptions))
			{
				$options = array();
				
				foreach( $arrOptions as $option )
					$options[] = $option['label'] . ': ' . $option['value'];
				
				$strOptions = ' ('.implode(', ', $options).')';
			}

			$items[] = array(
				"productNr" => $objProduct->sku,
				"description" => $objProduct->name . $strOptions,
				"quantity" => $objProduct->quantity_requested,
				"itemPrice" => number_format($objProduct->original_price, 2),
				"price" => number_format($objProduct->price, 2)
			);
		}
		$objMdxiTemplate->items = $items;
		
		// Prepare Return URLs
		if ($this->mpay24_wmbi_checkout_jumpTo) {
			$objPage = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")->limit(1)->execute($this->mpay24_wmbi_checkout_jumpTo);
			$objMdxiTemplate->successUrl = $this->Environment->base.$this->generateFrontendUrl($objPage->row()) . "?step=complete&amp;uid=" . $objOrder->uniqid;
			$objMdxiTemplate->errorUrl = $this->Environment->base.$this->generateFrontendUrl($objPage->row()) . "?step=failed&amp;uid=" . $objOrder->uniqid;
			$objMdxiTemplate->cancelUrl = $this->Environment->base.$this->generateFrontendUrl($objPage->row(), "/step/payment");
		}
		if (strlen($this->mpay24_wmbi_confirmation_username)) {
			$strBase = $this->Environment->base;
			$strAuthInfo = $this->mpay24_wmbi_confirmation_username . ":" . $this->mpay24_wmbi_confirmation_password . "@";
			if (substr($strBase, 0, 7) == "http://")
				$strBase = "http://" . $strAuthInfo . substr($strBase, 7);
			else if (substr($strBase, 0, 8) == "https://")
				$strBase = "https://" . $strAuthInfo . substr($strBase, 8);
		}
		$objMdxiTemplate->confirmationUrl = $strBase."system/modules/isotope/postsale.php?mod=pay&amp;id=".$this->id;

		// Customer ID
		if ($objOrder->pid > 0) {
			$objMdxiTemplate->customerId = $objOrder->pid;
			$objMdxiTemplate->useCustomerProfile = true;
		}
		
		$objMdxiTemplate->showShoppingCart = true;
		$objMdxiTemplate->tid = $objOrder->id;
		$objMdxiTemplate->currency = $this->Isotope->Config->currency;
		$objMdxiTemplate->subTotal = number_format($this->Isotope->Cart->subTotal, 2);
		$objMdxiTemplate->tax = number_format($this->Isotope->Cart->taxTotal, 2);
		$objMdxiTemplate->price = number_format($this->Isotope->Cart->grandTotal, 2);

		// Show billing address only
		$objMdxiTemplate->showBillingAddr = true;
		$objMdxiTemplate->billingName = $this->Isotope->Cart->billingAddress['firstname'].' '.$this->Isotope->Cart->billingAddress['lastname'];
		$objMdxiTemplate->billingStreet = $this->Isotope->Cart->billingAddress['street_1'];
		$objMdxiTemplate->billingStreet2 = $this->Isotope->Cart->billingAddress['street_2'];
		$objMdxiTemplate->billingZip = $this->Isotope->Cart->billingAddress['postal'];
		$objMdxiTemplate->billingCity = $this->Isotope->Cart->billingAddress['city'];
		$objMdxiTemplate->billingCountry = strtoupper($this->Isotope->Cart->billingAddress['country']);
		$objMdxiTemplate->billingEmail = $this->Isotope->Cart->billingAddress['email'];

		// Build MDXI
		$strMdxi = $objMdxiTemplate->parse();

		$this->log_debug("ORDER_ID:" . $objOrder->id);
		$this->log_debug("MDXI: " . $strMdxi);

		$objRequest = new Request();
		$objRequest->method = "POST";
		$objRequest->data = "OPERATION=SELECTPAYMENT&MERCHANTID=".$this->mpay24_merchant_id."&TID=".$objOrder->id."&MDXI=".urlencode($strMdxi);
		
		$objRequest->send($this->mpay24_wmbi_test_mode? $this->mpay24_wmbi_test_url : $this->mpay24_wmbi_prod_url);

		// Analyze response
		$parts = explode("&", $objRequest->response);
		foreach($parts as $part) {
			$param = explode("=", $part);
			switch (strtoupper($param[0])) {
				case "STATUS": 
					$strStatus = strtoupper($param[1]);
					break;
				case "RETURNCODE":
					$strReturnCode = strtoupper($param[1]);
					break;
				case "LOCATION":
					$strLocation = urldecode($param[1]);
			}
		}

		if ($strStatus == "OK" && $strReturnCode == "REDIRECT")
			$this->redirect($strLocation);
		else {
			// Log the error
			$this->log_error("ERROR:" . urldecode($objRequest->response));
			$this->log("mPay24 reports an error: " . urldecode($objRequest->response), "PaymentMPay24WMBI checkoutForm()", TL_ERROR);

			// Redirect to checkout/failure page
			if ($this->mpay24_checkout_jumpTo) {
				$objPage = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")->limit(1)->execute($this->mpay24_checkout_jumpTo);
				$strErrorUrl = $this->Environment->base.$this->generateFrontendUrl($objPage->row(), "/step/failed");
				$this->redirect($strErrorUrl);
			}
		}
	}

	/**
	 * Process mPay24 Confirmation Interface Request
	 *
	 * @access public
	 * @return void
	 */
	public function processPostSale() 
	{
		$objRequest = new Request();
		$objRequest->method = "POST";
		$objRequest->data = "OPERATION=TRANSACTIONSTATUS&MERCHANTID=".$this->mpay24_merchant_id."&TID=".$this->Input->get("TID");
		$objRequest->send($this->mpay24_wmbi_test_mode? $this->mpay24_wmbi_test_url : $this->mpay24_wmbi_prod_url);

		if ($objRequest->hasError())
		{
			$this->log('Request Error: ' . $objRequest->error, 'PaymentMPay24WMBI processPostSale()', TL_ERROR);
			exit;
		}
		$this->log_confirmation("Requested Transaction Status: " . $objRequest->response);

		// Split lines, since answer is delivered in two lines
		$lines = explode("\n", $objRequest->response);

		// Analyzing first line of response
		$parts = explode("&", $lines[0]);
		foreach($parts as $part) {
			$param = explode("=", $part);
			switch (strtoupper($param[0])) {
				case "STATUS": 
					$strResponseStatus = strtoupper($param[1]);
					break;
			}
		}

		if ($strResponseStatus != "OK") {
			$this->log('Couldn\'t verify transaction status for order ' . $this->Input->get('TID'), 'PaymentMPay24WMBI processPostSale()', TL_ERROR);
			return;
		}

		// Analyzing second line of response
		$parts = explode("&", $lines[1]);
		foreach($parts as $part) {
			$param = explode("=", $part);
			switch (strtoupper($param[0])) {
				case "STATUS": 
					$strTransactionStatus = strtoupper($param[1]);
					break;
			}
		}

		// Comparing statuses
		if (strtoupper($this->Input->get("STATUS")) != $strTransactionStatus) {
			$this->log('Transaction statuses do not match for order ' . $this->Input->get('TID') . ': Initial status: ' . $this->Input->get("STATUS") . ", Verified status: " . $strTransactionStatus, 'PaymentMPay24 processPostSale()', TL_ERROR);
			return;
		}

		$objOrder = new IsotopeOrder();
		if (!$objOrder->findBy('id', $this->Input->get('TID')))
		{
			$this->log('Order ID "' . $this->Input->get('TID') . '" not found', 'PaymentMPay24WMBI processPostSale()', TL_ERROR);
			return;
		}

		// Set the current system to the language when the user placed the order.
		// This will result in correct e-mails and payment description.
		$GLOBALS['TL_LANGUAGE'] = $objOrder->language;
		$this->loadLanguageFile('default');
		
		// Load / initialize data
		$arrPayment = deserialize($objOrder->payment_data, true);
		
		// Store request data in order for future references
		$arrPayment['POSTSALE'][] = $_GET;
		
		$arrData = $objOrder->getData();
		$arrData['old_payment_status'] = $arrPayment['status'];
		
		$arrPayment['status'] = $this->Input->get('STATUS');
		$arrData['new_payment_status'] = $arrPayment['status'];
		
		// Store payment data
		$objOrder->payment_data = $arrPayment;

		switch(strtoupper($this->Input->get('STATUS')))
		{
			case 'RESERVED':
				break;
			case 'BILLED':
				$objOrder->date_payed = time();
				$objOrder->new_order_status = 'complete';
				if (!$objOrder->checkout())
				{
					$this->log('Checkout for Order ID "' . $this->Input->get('TID') . '" failed', 'PaymentMPay24WMBI processPostSale()', TL_ERROR);
					return;
				} 
				$this->log('Payments billed for Order ID "' . $this->Input->get('TID') . '"', 'PaymentMPay24WMBI processPostSale()', TL_GENERAL);
				break;
			case 'CREDITED': // Gutgeschrieben
			case 'REVERSED':
			case 'SUSPENDED':
				$objOrder->date_payed = '';
				$objOrder->status = 'on_hold';
				$objOrder->save();
				$this->log('Payments reversed for Order ID "' . $this->Input->get('TID') . '"', 'PaymentMPay24WMBI processPostSale()', TL_ERROR);
				break;
			case 'ERROR':
				$this->log('Error status for Order ID "' . $this->Input->get('TID') . '"', 'PaymentMPay24WMBI processPostSale()', TL_ERROR);
				break;
		}

		header('HTTP/1.1 200 OK');
		exit;
	}
	
	public function backendInterface($intOrderId) {
		$objOrder = $this->Database->prepare("SELECT date_payed FROM tl_iso_orders WHERE id = ?")->execute($intOrderId);
		
		$objTemplate = new BackendTemplate("be_mpay24_wmbi");
		
		$objTemplate->href	= $this->getReferer(true);
		$objTemplate->title	= specialchars($GLOBALS['TL_LANG']['MSC']['backBT']);
		$objTemplate->link	= $GLOBALS['TL_LANG']['MSC']['backBT'];
		$objTemplate->h2	= sprintf($GLOBALS['TL_LANG']['ISO']['mpay24_H2'], $intOrderId);
		$objTemplate->label	= $GLOBALS['TL_LANG']['ISO']['mpay24_Label'];
		$objTemplate->text	= strlen($objOrder->date_payed) ? sprintf($GLOBALS['TL_LANG']['ISO']['mpay24_Text']['done'], $this->parseDate($GLOBALS["TL_CONFIG"]["dateFormat"], $objOrder->date_payed), $this->parseDate($GLOBALS["TL_CONFIG"]["timeFormat"], $objOrder->date_payed)) : $GLOBALS["TL_LANG"]["ISO"]["mpay24_Text"]["open"];
		
		return $objTemplate->parse();
	}
}

