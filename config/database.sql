-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

-- 
-- Table `tl_iso_payment_modules`
-- 

CREATE TABLE `tl_iso_payment_modules` (
  `mpay24_merchant_id` varchar(255) NOT NULL default '',
  `mpay24_wmbi_checkout_jumpTo` int(10) unsigned NOT NULL default '0',
  `mpay24_wmbi_test_mode` char(1) NOT NULL default '', 
  `mpay24_wmbi_test_url` varchar(255) NOT NULL default 'https://test.mpay24.com/app/bin/etpv5',
  `mpay24_wmbi_prod_url` varchar(255) NOT NULL default 'https://www.mpay24.com/app/bin/etpv5',
  `mpay24_wmbi_confirmation_username` varchar(255) NOT NULL default '',
  `mpay24_wmbi_confirmation_password` varchar(255) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------



-- PRODUCT ATTRIBUTES START --
-- PRODUCT ATTRIBUTES STOP --

