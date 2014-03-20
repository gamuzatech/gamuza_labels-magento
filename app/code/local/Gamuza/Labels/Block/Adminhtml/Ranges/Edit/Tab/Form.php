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

class Gamuza_Labels_Block_Adminhtml_Ranges_Edit_Tab_Form
extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$configModel = Mage::getModel ('utils/config');
		$carriersModel = Mage::getModel ('utils/carriers');

		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset("labels_form", array("legend"=>Mage::helper("labels")->__("Item Information")));

		$fieldset->addField("carrier_id", "select", array(
		"label" => Mage::helper("labels")->__("Carrier Name"),
		"class" => "required-entry",
		"required" => true,
		"name" => "carrier_id",
		"options" => $configModel->toOptions ($carriersModel->getCollection()->load(), array ('id' => 'description')),
		));
		$fieldset->addField("prefix", "text", array(
		"label" => Mage::helper("labels")->__("Prefix"),
		"class" => "required-entry",
		"required" => true,
		"name" => "prefix",
		));
		$fieldset->addField("suffix", "text", array(
		"label" => Mage::helper("labels")->__("Suffix"),
		"class" => "required-entry",
		"required" => true,
		"name" => "suffix",
		));
		$fieldset->addField("begin_code", "text", array(
		"label" => Mage::helper("labels")->__("Begin Code"),
		"class" => "required-entry",
		"required" => true,
		"name" => "begin_code",
		));
		$fieldset->addField("end_code", "text", array(
		"label" => Mage::helper("labels")->__("End Code"),
		"class" => "required-entry",
		"required" => true,
		"name" => "end_code",
		));
		$fieldset->addField("alarm", "text", array(
		"label" => Mage::helper("labels")->__("Alarm"),
		"class" => "required-entry",
		"required" => true,
		"name" => "alarm",
		));
		$fieldset->addField("enabled", "select", array(
		"label" => Mage::helper("labels")->__("Enabled"),
		"name" => "enabled",
		"values" => Mage::getModel ('adminhtml/system_config_source_yesno')->toOptionArray (),
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

