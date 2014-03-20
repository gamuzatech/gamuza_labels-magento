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

class Gamuza_Labels_Adminhtml_LabelsController
extends Mage_Adminhtml_Controller_Action
{

	public function carrierAction()
	{
		$order_id = $this->getRequest()->getParam ('order_id');
		$children = Mage::getModel ('labels/children');
	
		$child_id = $children->getChildByOrderId ($order_id);
		if ($child_id != -1)
		{
			$this->_redirect ('*/*/print', array ('order_id' => $order_id));
			
			return;
		}

		if ($this->getRequest()->isPost())
		{
			$carrier_id = $this->getRequest()->getParam('carrier_id');
			if (empty ($carrier_id))
			{
				Mage::getSingleton('core/session')->addError(Mage::helper ('labels')->__('Please select a carrier before.'));
			}
			else
			{
				$order_id = $this->getRequest()->getParam ('order_id');
				$children = Mage::getModel ('labels/children');
			
				$child_id = $children->getChildByOrderId ($order_id);
				if ($child_id != -1)
				{
					$this->_redirect ('*/*/print', array ('order_id' => $order_id));
				}
				else
				{
					$child_id = $children->getAvailableChild ($carrier_id);
				
					if ($child_id != -1)
					{
						$children->updateChild ($child_id, $order_id);
					
						$this->_redirect ('*/*/print', array ('order_id' => $order_id));
					}
					else
					{
						Mage::getSingleton('core/session')->addError(Mage::helper ('labels')->__('There are no label child to use with selected carrier.'));
					}
				}
			}
		}
	
		$this->loadLayout ();
		
		$this->getLayout ()->getBlock ('labels_carrier')->setOrderId ($order_id);
		
		$this->renderLayout();
	}

	public function printAction ()
	{
		$this->loadLayout ();
	
		$order_id = $this->getRequest ()->getParam ('order_id');
		$this->getLayout()->getBlock('labels_print')->setOrderId ($order_id);
	
		$this->renderLayout ();
	}

	public function reportAction ()
	{
		$orders_ids = $this->getRequest()->getParam ('orders_ids');
		$carrier_id = $this->getRequest()->getParam ('carrier_id');
	
		$this->loadLayout ();
	
		$this->getLayout ()->getBlock ('labels_report')->setOrdersIds ($orders_ids);
		$this->getLayout ()->getBlock ('labels_report')->setCarrierId ($carrier_id);
	
		$this->renderLayout ();
		
		$content = $this->getLayout()->getBlock('content')->toHtml();
		
		$this->getResponse()->setHeader ('Content-Type', 'text/html; charset=UTF-8', true);
		
		$this->_prepareDownloadResponse(
		'gamuza-labels-report-' . Mage::getSingleton ('core/date')->date ('Y-m-d_H-i-s') . '.html',
		utf8_decode ($content), 'text/html');
	}

	public function shipmentAction ()
	{
		$orders_ids = $this->getRequest()->getParam ('orders_ids');
		$children = Mage::getModel ('labels/children');
		
		foreach ($orders_ids as $id => $value) $children->generateShipment ($value);
		
		Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("labels")->__("All orders shipments were created successfully."));
		
		$this->_redirect("labels/adminhtml_reports/index");
	}
}

