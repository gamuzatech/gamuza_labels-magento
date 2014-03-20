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

class Gamuza_Labels_Block_Adminhtml_Reports_Grid
extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();

		$this->setId("reportsGrid");
		$this->setDefaultSort("entity_id");
		$this->setDefaultDir("ASC");
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel('sales/order')->getCollection();
		$collection->getSelect()->join (array('table_address' => 'sales_flat_order_address'),
                                              'main_table.shipping_address_id = table_address.entity_id',
                                              array('postcode'));
		$collection->getSelect()->join (array('table_children' => 'gamuza_labels_children'),
                                              'main_table.entity_id = table_children.order_id',
                                              array('code'));
		$collection->getSelect()->join (array('table_carriers' => 'gamuza_carriers'),
                                              'table_children.carrier_id = table_carriers.id',
                                              array('table_carriers.id as carrier_id'));
                $collection->addAttributeToFilter ('state', 'processing');
	    $this->setCollection($collection);

	    return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$configModel = Mage::getModel ('utils/config');
		$carriersModel = Mage::getModel ('utils/carriers');

		$this->addColumn("entity_id", array(
		"header" => Mage::helper("labels")->__("Order ID"),
		"align" =>"right",
		"width" => "50px",
		"index" => "entity_id",
		));
		$this->addColumn("increment_id", array(
		"header" => Mage::helper("labels")->__("Order Increment ID"),
		"align" =>"left",
		"index" => "increment_id",
		));
		$this->addColumn("grand_total", array(
		"header" => Mage::helper("labels")->__("Order Grand Total"),
		"align" =>"left",
		"index" => "grand_total",
		));
		$this->addColumn("postcode", array(
		"header" => Mage::helper("labels")->__("Order Shipping Postcode"),
		"align" =>"left",
		"index" => "postcode",
		));
		$this->addColumn("label_carrier_desc", array(
		"header" => Mage::helper("labels")->__("Label Carrier Description"),
		"align" =>"left",
		"index" => "carrier_id",
		"type" => "options",
		"options" => $configModel->toOptions ($carriersModel->getCollection()->load(), array ('id' => 'description')),
		));
		$this->addColumn("label_tracking_code", array(
		"header" => Mage::helper("labels")->__("Label Tracking Code"),
		"align" =>"left",
		"index" => "code",
		));
		$this->addColumn("status", array(
		"header" => Mage::helper("labels")->__("Status"),
		"align" =>"left",
		"index" => "status",
		"type" => "options",
		"options" => Mage::getSingleton('sales/order_config')->getStatuses(),
		));
		
		return parent::_prepareColumns();
	}

	protected function _prepareMassaction()
	{
	    $this->setMassactionIdField('entity_id');
	    $this->getMassactionBlock()->setFormFieldName('orders_ids');
	    $this->getMassactionBlock()->setUseSelectAll(true);

	    $this->getMassactionBlock()->addItem('generate_report',
	      array(
	        'label'=> Mage::helper('labels')->__('Gerenate Report'),
	        'url'  => $this->getUrl('labels/adminhtml_labels/report'),
	    ));

        $configModel = Mage::getModel ('utils/config');
        $carriersModel = Mage::getModel ('utils/carriers');
        $carriers = $configModel->toOptions ($carriersModel->getCollection()->load(), array ('id' => 'description'));

	    $this->getMassactionBlock()->addItem('generate_report', array(
	         'label'=> Mage::helper('labels')->__('Generate Report'),
	         'url'  => $this->getUrl('labels/adminhtml_labels/report'),
	         'additional' => array(
	                'visibility' => array(
	                     'name' => 'carrier_id',
	                     'type' => 'select',
	                     'class' => 'required-entry',
	                     'label' => Mage::helper('labels')->__('Carriers'),
	                     'values' => $carriers,
	                 )
	         )
	    ));

	    $this->getMassactionBlock()->addItem('generate_shipments', array(
	         'label'=> Mage::helper('labels')->__('Generate Shipments'),
	         'url'  => $this->getUrl('labels/adminhtml_labels/shipment'),
	    ));
	}
	
	public function getRowUrl($row)
	{
	    return $this->getUrl("adminhtml/sales_order/view", array("order_id" => $row->getEntityId()));
	}
}

