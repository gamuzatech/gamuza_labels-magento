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

class Gamuza_Labels_Block_Adminhtml_Children_Grid
extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();

		$this->setId("childrenGrid");
		$this->setDefaultSort("id");
		$this->setDefaultDir("ASC");
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel("labels/children")->getCollection();
		$this->setCollection($collection);

		return parent::_prepareCollection();
	}
	protected function _prepareColumns()
	{
		$configModel = Mage::getModel ('utils/config');
		$carriersModel = Mage::getModel ('utils/carriers');

		$this->addColumn("id", array(
		"header" => Mage::helper("labels")->__("ID"),
		"align" =>"right",
		"width" => "50px",
		"index" => "id",
		));
		$this->addColumn("range_id", array(
		"header" => Mage::helper("labels")->__("Range ID"),
		"align" =>"left",
		"index" => "range_id",
		"type" => "options",
		"options" => Mage::getModel ('labels/ranges')->getCollection()->load()->toOptions (array ('id' => 'id')),
		));
		$this->addColumn("carrier_id", array(
		"header" => Mage::helper("labels")->__("Carrier ID"),
		"align" =>"left",
		"index" => "carrier_id",
		"type" => "options",
		"options" => $configModel->toOptions ($carriersModel->getCollection()->load(), array ('id' => 'description')),
		));
		$this->addColumn("order_id", array(
		"header" => Mage::helper("labels")->__("Order ID"),
		"align" =>"left",
		"index" => "order_id",
		));
		$this->addColumn("code", array(
		"header" => Mage::helper("labels")->__("Code"),
		"align" =>"left",
		"index" => "code",
		));
		$this->addColumn("enabled", array(
		"header" => Mage::helper("labels")->__("Enabled"),
		"align" =>"left",
		"index" => "enabled",
		"type" => "options",
		"options" => Mage::helper ("labels")->getYesNo (),
		));
		$this->addColumn("available", array(
		"header" => Mage::helper("labels")->__("Available"),
		"align" =>"left",
		"index" => "available",
		"type" => "options",
		"options" => Mage::helper ("labels")->getYesNo (),
		));
		
		return parent::_prepareColumns();
	}

	protected function _prepareMassaction()
	{
	    $this->setMassactionIdField('id');
	    $this->getMassactionBlock()->setFormFieldName('children_ids');
	    $this->getMassactionBlock()->setUseSelectAll(true);

	    $this->getMassactionBlock()->addItem('delete',
	      array(
	        'label'=> Mage::helper('labels')->__('Delete'),
	        'url'  => $this->getUrl('*/*/massdelete'),
	    ));
	}

	public function getRowUrl($row)
	{
	   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
	}
}

