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

class Gamuza_Labels_Model_Ranges
extends Mage_Core_Model_Abstract
{
	protected function _construct()
	{
		$this->_init("labels/ranges");
	}

	public function _getSql ()
	{
		return Mage::getModel ('utils/sql');
	}

	public function getAlarm ($range_id)
	{
		$rows = $this->_getSql ()->select ('labels/ranges',
			                             array ('alarm'),
			                             "id={$range_id}");
		
		$alarm = @$rows [0]['alarm'];
		
		return !empty ($alarm) ? $alarm : -1;
	}

	public function generateChildren ($range_id)
	{
		$rows = $this->_getSql ()->select ('labels/ranges',
			                             array ('*'),
			                             "id={$range_id}");
	
		for ($i = $rows [0]['begin_code']; $i <= $rows [0]['end_code']; $i ++)
		{
		    $pad = str_pad ($i, 8, '0', STR_PAD_LEFT);
		    $digit = Mage::helper ('labels')->getDigitVerifier ($pad);

		$fields = array ('range_id' => $rows [0]['id'],
			             'carrier_id' => $rows [0]['carrier_id'],
			             'code' => $rows [0]['prefix'] . $pad . $digit . $rows [0]['suffix'],
			             'enabled' => 1,
			             'available' => 1);
		$this->_getSql ()->insert ('labels/children', $fields);
		}
	}
}

