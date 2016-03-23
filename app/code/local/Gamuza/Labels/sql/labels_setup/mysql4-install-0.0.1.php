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

$installer = $this;
$installer->startSetup();

$sqlBlock = <<<SQLBLOCK
CREATE TABLE IF NOT EXISTS {$this->getTable ('gamuza_labels_ranges')}
(
    id int(11) unsigned NOT NULL AUTO_INCREMENT,
    carrier_id int(11) unsigned NOT NULL,
    prefix char(255) NOT NULL,
    suffix char(255) NOT NULL,
    begin_code bigint(20) unsigned NOT NULL,
    end_code bigint(20) unsigned NOT NULL,
    alarm int(11) unsigned NOT NULL,
    enabled tinyint(1) unsigned NOT NULL,
    PRIMARY KEY (id),
    KEY prefix (prefix),
    KEY suffix (suffix),
    KEY begin_code (begin_code),
    KEY end_code (end_code),
    KEY alarm (alarm),
    KEY enabled (enabled),
    KEY carrier_id (carrier_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS {$this->getTable ('gamuza_labels_children')}
(
    id int(11) unsigned NOT NULL AUTO_INCREMENT,
    range_id int(11) unsigned NOT NULL,
    carrier_id int(11) unsigned NOT NULL,
    order_id int(11) unsigned NOT NULL,
    code char(255) NOT NULL,
    enabled tinyint(1) unsigned NOT NULL,
    available tinyint(1) unsigned NOT NULL,
    PRIMARY KEY (id),
    KEY range_id (range_id),
    KEY code (code),
    KEY carrier_id (carrier_id),
    KEY enabled (enabled),
    KEY available (available)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
SQLBLOCK;

$installer->run ($sqlBlock);
//demo
//Mage::getModel('core/url_rewrite')->setId(null);
//demo
$installer->endSetup();

