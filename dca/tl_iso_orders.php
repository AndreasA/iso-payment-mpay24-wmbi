<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
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
 * @copyright  de la Haye Kommunikationsdesign 2011
 * @author     Christian de la Haye <http://www.delahaye.de>
 * @package    Isotope EU tax handling
 * @license    LGPL
 * @filesource
 */

$GLOBALS['TL_DCA']['tl_iso_orders']['palettes']['default'] = str_replace(';{email_legend:hide}',',mpay24_wmbi_remaining_payment_amount;{email_legend:hide}',$GLOBALS['TL_DCA']['tl_iso_orders']['palettes']['default']);

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_iso_orders']['list']['label']['fields'][] = 'id';

$GLOBALS['TL_DCA']['tl_iso_orders']['fields']['id']['label'] = $GLOBALS['TL_LANG']['tl_iso_orders']['id'];
$GLOBALS['TL_DCA']['tl_iso_orders']['fields']['id']['eval']['doNotShow'] = false;
$GLOBALS['TL_DCA']['tl_iso_orders']['fields']['id']['eval']['readonly'] = true;
$GLOBALS['TL_DCA']['tl_iso_orders']['fields']['id']['search'] = true;
$GLOBALS['TL_DCA']['tl_iso_orders']['fields']['id']['sorting'] = true;
$GLOBALS['TL_DCA']['tl_iso_orders']['fields']['id']['flag'] = 12;

$GLOBALS['TL_DCA']['tl_iso_orders']['fields']['order_id']['flag'] = 12;

$GLOBALS['TL_DCA']['tl_iso_orders']['fields']['mpay24_wmbi_remaining_payment_amount'] = array(
    'label'	=> &$GLOBALS['TL_LANG']['tl_iso_orders']['mpay24_wmbi_remaining_payment_amount'],
    'inputType' => 'text',
    'eval' => array('readonly' => true, 'disabled' => true)
);

?>
