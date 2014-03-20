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

class Gamuza_Labels_Model_Children
extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
       $this->_init("labels/children");
    }

    private function _getSql ()
    {
		return Mage::getModel ('utils/sql');
    }

    public function getRangeByCarrierId ($carrier_id)
    {
		$rows = $this->_getSql ()->select ('labels/ranges',
			                             array ('id'),
			                             "carrier_id=$carrier_id");
		
		$id = @$rows [0]['id'];
		
		return !empty ($id) ? $id : -1;
    }

    public function getChildByOrderId ($order_id)
    {
		$rows = $this->_getSql ()->select ('labels/children',
			                             array ('id'),
			                             "order_id=$order_id");
		
		$id = @$rows [0]['id'];
		
		return !empty ($id) ? $id : -1;
    }

    public function getAvailable ($carrier_id)
    {
		$rows = $this->_getSql ()->select ('labels/children',
			                             array ('count(id) as count_id'),
			                             "carrier_id={$carrier_id} AND enabled=1 AND available=1");
		
		$count_id = @$rows [0]['count_id'];
		
		return !empty ($count_id) ? $count_id : -1;
    }

    public function getAvailableChild ($carrier_id)
    {
		$rows = $this->_getSql ()->select ('labels/children',
			                             array ('min(id) as min_id'),
			                             "carrier_id={$carrier_id} AND enabled=1 AND available=1");
		
		$min_id = @$rows [0]['min_id'];
		
		return !empty ($min_id) ? $min_id : -1;
    }

    public function updateChild ($child_id, $order_id)
    {
		$this->_getSql ()->update ('labels/children',
			                        array ('order_id' => $order_id, 'enabled' => 0, 'available' => 0),
			                        "id={$child_id}");
    }

    public function generateShipment ($order_id)
    {
	    $order = Mage::getModel ('sales/order')->load ($order_id);
	    $increment_id = $order->getIncrementId ();
	    
	    if (!$order->hasInvoices ())
	    {
		Mage::getSingleton('core/session')->addError(Mage::helper ('labels')->__('Order %d is not invoiced.', $increment_id));
		
		return false;
	    }
	    
	    if ($order->hasShipments ())
	    {
		Mage::getSingleton('core/session')->addError(Mage::helper ('labels')->__('Order %d has already shipment.', $increment_id));
		
		return false;
	    }
	    
	    $shipment = $order->prepareShipment();
	    $shipment->register();
	    $order->setIsInProcess(true);
	    
		$carrier_id = $this->getCarrierId ($order_id);
		$carrier_name = $this->getCarrierName ($carrier_id);
		$carrier_desc = $this->getCarrierDesc ($carrier_id);
		$tracking_code = $this->getChildCode ($order_id);
		$tracking = array(
			'carrier_code' => $carrier_name,
			'title' => $carrier_desc,
			'number' => $tracking_code
		);
		$track = Mage::getModel('sales/order_shipment_track')->addData($tracking);
		$shipment->addTrack($track);
		
		$shipment->sendEmail ($order->getCustomerEmail(), 'Your order has been delivered.');
		$shipment->setEmailSent (true);

	    $transactionSave = Mage::getModel('core/resource_transaction')
	            ->addObject($shipment)
	            ->addObject($shipment->getOrder())
	            ->save();
		
		$order->addStatusHistoryComment('Automatically shipped by Gamuza Labels.', false);
		$order->save ();
		
		return true;
    }

    public function getChildCode ($order_id)
    {
		$rows = $this->_getSql ()->select ('labels/children',
			                             array ('code'),
			                             "order_id={$order_id}");
		
		$code = @$rows [0]['code'];
		
		return !empty ($code) ? $code : null;
    }

    public function getCarrierId ($order_id)
    {
		$rows = $this->_getSql ()->select ('labels/children',
			                             array ('carrier_id'),
			                             "order_id={$order_id}");
		
		$carrier_id = @$rows [0]['carrier_id'];
		
		return !empty ($carrier_id) ? $carrier_id : -1;
    }

    public function getCarrierName ($carrier_id)
    {
		$rows = $this->_getSql ()->select ('utils/carriers',
			                            array ('name'),
			                            "id={$carrier_id}");
		
		$name = @$rows [0]['name'];
		
		return !empty ($name) ? $name : null;
    }

    public function getCarrierDesc ($carrier_id)
    {
		$rows = $this->_getSql ()->select ('utils/carriers',
			                           array ('description'),
			                           "id={$carrier_id}");
		
		$description = @$rows [0]['description'];
		
		return !empty ($description) ? $description : null;
    }
}

