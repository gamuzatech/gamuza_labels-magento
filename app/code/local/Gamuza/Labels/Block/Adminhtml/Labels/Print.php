<?php
/*
 * Gamuza Labels - Labels for magento platform.
 * Copyright (C) 2013 Gamuza Technologies (http://www.gamuza.com.br/)
 * Author: Eneias Ramos de Melo <eneias@gamuza.com.br>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Library General Public
 * License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Library General Public License for more details.
 *
 * You should have received a copy of the GNU Library General Public
 * License along with this library; if not, write to the
 * Free Software Foundation, Inc., 51 Franklin St, Fifth Floor,
 * Boston, MA  02110-1301, USA.
 */

/*
 * See the AUTHORS file for a list of people on the Gamuza Team.
 * See the ChangeLog files for a list of changes.
 * These files are distributed with Gamuza_Labels at http://code.google.com/p/gamuzaopen/.
 */

class Gamuza_Labels_Block_Adminhtml_Labels_Print
extends Mage_Adminhtml_Block_Template
{
	private $_barcode_params = array ('encoding' => '128', 'mode' => 'png');

	public function __construct ()
	{
		parent::__construct ();
		
		$this->setTemplate ('labels/print.phtml');
	}

	public function getPrint ()
	{
		return Mage::getModel ('labels/print');
	}

	public function getOrder ()
	{
		if (!$this->_order instanceof Mage_Sales_Model_Order)
		{
			$this->_order = $this->getPrint ()->getOrder ($this->getOrderId ());
		}
		
		return $this->_order;
	}

	public function getShippingAddress ()
	{
		return $this->getOrder ()->getShippingAddress ();
	}

	public function getChildCode ()
	{
		return $this->getPrint ()->getChildCode ($this->getOrderId ());
	}

	public function getCarrierId ()
	{
		return $this->getPrint()->getCarrierId ($this->getOrderId ());
	}

	public function getCarrierName ()
	{
		return $this->getPrint ()->getCarrierName ($this->getCarrierId ());
	}

	public function getBarCodeParams (array $params, $prepend = '?')
	{
		$this->_barcode_params = array_merge ($this->_barcode_params, $params);
		
		$barcode_params = '';
		foreach ($this->_barcode_params as $id => $value) $barcode_params .= (empty ($barcode_params) ? $prepend : '&') . "{$id}={$value}";
		
		return $barcode_params;
	}
}

