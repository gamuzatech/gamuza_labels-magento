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

class Gamuza_Labels_Adminhtml_ChildrenController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->loadLayout()->_setActiveMenu("labels/children")->_addBreadcrumb(Mage::helper("adminhtml")->__("Children  Manager"),Mage::helper("adminhtml")->__("Children Manager"));

		return $this;
	}
	public function indexAction() 
	{
		$this->_initAction();
		$this->renderLayout();
	}

	public function editAction()
	{
		$brandsId = $this->getRequest()->getParam("id");
		$brandsModel = Mage::getModel("labels/children")->load($brandsId);
		if ($brandsModel->getId() || $brandsId == 0)
		{
			Mage::register("labels_data", $brandsModel);
			$this->loadLayout();
			$this->_setActiveMenu("labels/children");
			$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Children Manager"), Mage::helper("adminhtml")->__("Children Manager"));
			$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Children Description"), Mage::helper("adminhtml")->__("Children Description"));
			$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock("labels/adminhtml_children_edit"))->_addLeft($this->getLayout()->createBlock("labels/adminhtml_children_edit_tabs"));
			$this->renderLayout();
		} 
		else
		{
			Mage::getSingleton("adminhtml/session")->addError(Mage::helper("labels")->__("Item does not exist."));
			$this->_redirect("*/*/");
		}
	}

	public function newAction()
	{
		$id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("labels/children")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) $model->setData($data);

		Mage::register("labels_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("labels/children");
		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Children Manager"), Mage::helper("adminhtml")->__("Children Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Children Description"), Mage::helper("adminhtml")->__("Children Description"));
		$this->_addContent($this->getLayout()->createBlock("labels/adminhtml_children_edit"))->_addLeft($this->getLayout()->createBlock("labels/adminhtml_children_edit_tabs"));
		$this->renderLayout();
	}

	public function saveAction()
	{
		$post_data=$this->getRequest()->getPost();

		if ($post_data)
		{

			try
			{
				$brandsModel = Mage::getModel("labels/children")
				->addData($post_data)
				->setId($this->getRequest()->getParam("id"))
				->save();

				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Children was successfully saved"));
				Mage::getSingleton("adminhtml/session")->setChildrenData(false);

				if ($this->getRequest()->getParam("back"))
				{
					$this->_redirect("*/*/edit", array("id" => $brandsModel->getId()));

					return;
				}

				$this->_redirect("*/*/");

				return;
			} 
			catch (Exception $e)
			{
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
				Mage::getSingleton("adminhtml/session")->setChildrenData($this->getRequest()->getPost());

				$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));

				return;
			}
		}

		$this->_redirect("*/*/");
	}

	public function deleteAction()
	{
		if( $this->getRequest()->getParam("id") > 0 )
		{
			try
			{
				$brandsModel = Mage::getModel("labels/children");
				$brandsModel->setId($this->getRequest()->getParam("id"))->delete();

				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));

				$this->_redirect("*/*/");
			} 
			catch (Exception $e)
			{
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());

				$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
			}
		}

		$this->_redirect("*/*/");
	}

	public function massdeleteAction ()
	{
		$utils = Mage::getModel ('utils/sql');
		
		$children_ids = $this->getRequest()->getParam('children_ids');
		foreach ($children_ids as $id => $value)
		{
		    $result = $utils->delete ('labels/children', "id={$value}");
		    if ($result != true) Mage::getSingleton ('adminhtml/session')->addError ($result);
		}
		
		$message = $this->__('All children were successfully delete.');
		Mage::getSingleton ('adminhtml/session')->addSuccess ($message);
		
		$this->_redirect ('labels/adminhtml_children/index');
	}
}

