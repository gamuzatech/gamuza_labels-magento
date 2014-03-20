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

class Gamuza_Labels_Block_Adminhtml_Ranges_Grid
extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();

		$this->setId("rangesGrid");
		$this->setDefaultSort("id");
		$this->setDefaultDir("ASC");
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel("labels/ranges")->getCollection();
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
		$this->addColumn("carrier_id", array(
		"header" => Mage::helper("labels")->__("Carrier Name"),
		"align" =>"left",
		"index" => "carrier_id",
		"type" => "options",
		"options" => $configModel->toOptions ($carriersModel->getCollection()->load(), array ('id' => 'description')),
		));
		$this->addColumn("prefix", array(
		"header" => Mage::helper("labels")->__("Prefix"),
		"align" =>"left",
		"index" => "prefix",
		));
		$this->addColumn("suffix", array(
		"header" => Mage::helper("labels")->__("Suffix"),
		"align" =>"left",
		"index" => "suffix",
		));
		$this->addColumn("begin_code", array(
		"header" => Mage::helper("labels")->__("Begin Code"),
		"align" =>"left",
		"index" => "begin_code",
		));
		$this->addColumn("end_code", array(
		"header" => Mage::helper("labels")->__("End Code"),
		"align" =>"left",
		"index" => "end_code",
		));
		$this->addColumn("alarm", array(
		"header" => Mage::helper("labels")->__("Alarm"),
		"align" =>"left",
		"index" => "alarm",
		));
		$this->addColumn("enabled", array(
		"header" => Mage::helper("labels")->__("Enabled"),
		"align" =>"left",
		"index" => "enabled",
		"type" => "options",
		"options" => Mage::Helper ('labels')->getYesNo (),
		));
		
		return parent::_prepareColumns();
	}

	protected function _prepareMassaction()
	{
	    $this->setMassactionIdField('id');
	    $this->getMassactionBlock()->setFormFieldName('ranges_ids');
	    $this->getMassactionBlock()->setUseSelectAll(true);

	    $this->getMassactionBlock()->addItem('generate_children',
	      array(
	        'label'=> Mage::helper('labels')->__('Generate Children'),
	        'url'  => $this->getUrl('*/*/generate'),
	    ));

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

