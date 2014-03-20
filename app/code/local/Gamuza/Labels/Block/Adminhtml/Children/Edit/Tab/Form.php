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

class Gamuza_Labels_Block_Adminhtml_Children_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$configModel = Mage::getModel ('utils/config');
		$carriersModel = Mage::getModel ('utils/carriers');

		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset("labels_form", array("legend"=>Mage::helper("labels")->__("Item Information")));

		$fieldset->addField("range_id", "select", array(
		"label" => Mage::helper("labels")->__("Range ID"),
		"class" => "required-entry",
		"required" => true,
		"name" => "range_id",
		"options" => Mage::getModel ('labels/ranges')->getCollection()->load()->toOptions (array ('id' => 'id')),
		));
		$fieldset->addField("carrier_id", "select", array(
		"label" => Mage::helper("labels")->__("Carrier Name"),
		"class" => "required-entry",
		"required" => true,
		"name" => "carrier_id",
		"options" => $configModel->toOptions ($carriersModel->getCollection()->load(), array ('id' => 'description')),
		));
		$fieldset->addField("code", "text", array(
		"label" => Mage::helper("labels")->__("Code"),
		"class" => "required-entry",
		"required" => true,
		"name" => "code",
		));
		$fieldset->addField("enabled", "select", array(
		"label" => Mage::helper("labels")->__("Enabled"),
		"class" => "required-entry",
		"required" => true,
		"name" => "enabled",
		"options" => Mage::helper("labels")->getYesNo (),
		));
		$fieldset->addField("available", "select", array(
		"label" => Mage::helper("labels")->__("Available"),
		"class" => "required-entry",
		"required" => true,
		"name" => "available",
		"options" => Mage::helper("labels")->getYesNo (),
		));

		if (Mage::getSingleton("adminhtml/session")->getLabelsData())
		{
			$form->setValues(Mage::getSingleton("adminhtml/session")->getLabelsData());
			Mage::getSingleton("adminhtml/session")->setLabelsData(null);
		} 
		elseif(Mage::registry("labels_data")) {
		    $form->setValues(Mage::registry("labels_data")->getData());
		}
		
		return parent::_prepareForm();
	}
}

