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

class Gamuza_Labels_Helper_Data
extends Mage_Core_Helper_Abstract
{
	public function getYesNo ()
	{
		return array (1 => $this->__('Yes'), 0 => $this->__('No'));
	}

	public function toOptions (Mage_Core_Model_Mysql4_Collection_Abstract $collection, $fields)
	{
		$key = key ($fields);
		$value = $fields [$key];
		
		$data = $collection->toArray (array ($key, $value));
		
		$result = '';
		foreach ($data ['items'] as $item) $result [$item [$key]] = $item [$value];
		
		return $result;
	}

	public function getDigitVerifier ($digit)
	{
		static $result = 0;

		$calculate = ((((int) substr ($digit, 0, 1)) * 8)
		           + (((int) substr ($digit, 1, 1)) * 6)
		           + (((int) substr ($digit, 2, 1)) * 4)
		           + (((int) substr ($digit, 3, 1)) * 2)
		           + (((int) substr ($digit, 4, 1)) * 3)
		           + (((int) substr ($digit, 5, 1)) * 5)
		           + (((int) substr ($digit, 6, 1)) * 9)
		           + (((int) substr ($digit, 7, 1)) * 7));

		if (($calculate % 11) == 0) $result = 5;
		elseif (($calculate % 11) == 1) $result = 0;
		else $result = 11 - ((int) $calculate % 11);

		return $result;
	}
}

