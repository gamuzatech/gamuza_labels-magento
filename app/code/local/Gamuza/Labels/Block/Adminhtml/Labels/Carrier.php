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

class Gamuza_Labels_Block_Adminhtml_Labels_Carrier
extends Mage_Adminhtml_Block_Widget_Form
{
	public function getCarriers ()
	{
		return Mage::getModel ('utils/carriers');
	}

	public function getCarriersList ()
	{
		$carriers = $this->getCarriers ()->getCollection()->load()->toArray ();
		
		return $carriers ['items'];
	}

	public function getRanges ()
	{
		return Mage::getModel ('labels/ranges');
	}

	public function getChildren ()
	{
		return Mage::getModel ('labels/children');
	}

	public function getFreight ()
	{
		return Mage::getModel ('freight/config');
	}

	public function getOrder ()
	{
		if (!$this->_order instanceof Mage_Sales_Model_Order)
		{
			$this->_order = Mage::getModel ('sales/order')->load ($this->getOrderId ());
		}
		
		return $this->_order;
	}

	public function getShippingAddress ()
	{
		return $this->getOrder()->getShippingAddress ();
	}

	protected function _prepareForm()
	{
		$order_id = $this->getOrderId ();
		$order = $this->getOrder ($order_id);
		$address = $order->getShippingAddress ();
		$postcode = $address->getData ('postcode');
		$packageWeight = $order->getWeight ();
		
		$form = new Varien_Data_Form(array ('id' => 'labels_carrier_form',
		                                    'method' => 'post',
		                                    'action' => $this->getUrl ('*/*/*', array ('order_id' => $order_id))));
		$form->setUseContainer(true);
		$this->setForm($form);
		
		$address = $this->getShippingAddress ();
	
		$fieldset = $form->addFieldset("labels_carrier_address_form", array ("legend" => Mage::helper ('labels')->__('Customer Shipping Address Information')));
		$fieldset->addField("street", "label", array(
		"label" => Mage::helper ('labels')->__('Street'),
		"value" => $address->getStreetFull (),
		));
		$fieldset->addField("postcode", "label", array(
		"label" => Mage::helper ('labels')->__('Postcode'),
		"value" => $address->getPostcode (),
		));
		$fieldset->addField("city", "label", array(
		"label" => Mage::helper ('labels')->__('City, Region and Country'),
		"value" => $address->getCity () . ' - ' . $address->getRegion () . ' - ' . $address->getCountryId (),
		));
	
		$shipping_method = explode ('_', $order->getShippingMethod ());
		$carrier = Mage::getModel ('utils/config')->getCarrier ($shipping_method [0]);
		
		$fieldset->addField ("customer_carrier_id", "hidden", array(
		"value" => $carrier->getData ('id'),
		));
		
		$fieldset->addField("carrier", "label", array(
		"label" => '<strong>' . Mage::helper ('labels')->__('Carrier') . '</strong>',
		"value" => $carrier->getData ('description'),
		));

		$fieldset = $form->addFieldset("labels_carrier_form", array ("legend" => Mage::helper ('labels')->__('Choose a Carrier and generate a new label')));
		foreach ($this->getCarriersList () as $carrier)
		{
			$carrier_id = $carrier ['id'];
			$carrier_name = $carrier ['name'];
			$carrier_desc = $carrier ['description'];
		
			$fieldset->addField("carrier_option_{$carrier_id}", "radio", array(
			"label" => "<strong>$carrier_desc</strong>",
			"class" => "required-entry",
			"required" => true,
			"name" => "carrier_id",
			"value" => $carrier_id,
			"_teste" => "checked",
			));

			$range_id = $this->getChildren ()->getRangeByCarrierId ($carrier_id);
			$alarm = $this->getRanges ()->getAlarm ($range_id);
			$available = $this->getChildren ()->getAvailable ($carrier_id);
		            
			$fieldset->addField("carrier_available_{$carrier_id}", "link", array(
			"label" => Mage::helper ('labels')->__('Available'),
			"value" => $available > 0 ? $available : "0",
			"style" => $available <= $alarm ? "color:#f00" : "color:#000",
			));
			/*
			$delivery_price = 0;
			$shipping = $this->getFreight ()->getShippingPrice ($carrier_name, $postcode, $packageWeight);
			if ($shipping != null) $delivery_price = $shipping->getData ('delivery_price');
			
			$fieldset->addField("carrier_price_{$carrier_id}", "label", array(
			"label" => Mage::helper ('labels')->__('Price'),
			"value" => Mage::helper('core')->currency ($delivery_price / 100, true, false),
			));
			*/
		}

		$fieldset = $form->addFieldset("labels_carrier_button_form", array ());
		$fieldset->addField("generate", "submit", array(
		"value" => Mage::helper ('labels')->__('Generate'),
		/* "onclick" => 'labels_carrier_form.submit()', */
		));
	
		return parent::_prepareForm ();
	}
}

