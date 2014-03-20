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

class Gamuza_Labels_Block_Adminhtml_Labels_Report
extends Mage_Adminhtml_Block_Template
{
	public function __construct ()
	{
		parent::__construct ();
		
		$this->setTemplate ('labels/report.phtml');
	}

	public function getChildren ()
	{
		return Mage::getModel ('labels/children');
	}

	public function getOrder ($order_id)
	{
		return Mage::getModel ('sales/order')->load ($order_id);
	}

	public function getOrderIncrementId ($order_id)
	{
		return $this->getOrder ($order_id)->getIncrementId ();
	}

	public function getChildCode ($order_id)
	{
		return $this->getChildren ()->getChildCode ($order_id);
	}

	public function getCarrierName ()
	{
		return $this->getChildren ()->getCarrierName ($this->getCarrierId ());
	}

	public function getCarrierDesc ()
	{
		return $this->getChildren ()->getCarrierDesc ($this->getCarrierId ());
	}
}

