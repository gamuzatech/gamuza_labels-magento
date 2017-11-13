<?php
/*
 * @package     Gamuza_Labels
 * @copyright   Copyright (c) 2017 Gamuza Technologies (http://www.gamuza.com.br/)
 * @author      Eneias Ramos de Melo <eneias@gamuza.com.br>
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
 * These files are distributed with Gamuza_Labels at http://github.com/gamuzatech/
 */

class Gamuza_Labels_Model_Observer
{
    public function adminhtmlBlockHtmlBefore ($observer)
    {
        $block = $observer->getEvent ()->getBlock ();

        if ($block instanceof Mage_Adminhtml_Block_Sales_Order_View
            && Mage::getStoreConfigFlag ('labels/settings/active')
            && $this->_getOrder ()->hasInvoices ()
        )
        {
            $block->addButton ('order_label', array(
                'label'   => Mage::helper ('labels')->__('Label'),
                'onclick' => "popWin ('" . $this->_getLabelUrl () . "', '','width=400,height=585,resizable=no,scrollbars=no')",
                'class'   => 'go'
            ));
        }
    }

    private function _getLabelUrl ()
    {
        return Mage::helper ('adminhtml')->getUrl ('labels/adminhtml_labels/carrier', array ('order_id' => $this->_getOrder ()->getId ()));
    }

    private function _getOrder ()
    {
        return Mage::registry ('current_order');
    }
}

