<?php

/**
 * This software is intended for use with Oxwall Free Community Software http://www.oxwall.org/ and is
 * licensed under The BSD license.

 * ---
 * Copyright (c) 2011, Oxwall Foundation
 * All rights reserved.

 * Redistribution and use in source and binary forms, with or without modification, are permitted provided that the
 * following conditions are met:
 *
 *  - Redistributions of source code must retain the above copyright notice, this list of conditions and
 *  the following disclaimer.
 *
 *  - Redistributions in binary form must reproduce the above copyright notice, this list of conditions and
 *  the following disclaimer in the documentation and/or other materials provided with the distribution.
 *
 *  - Neither the name of the Oxwall Foundation nor the names of its contributors may be used to endorse or promote products
 *  derived from this software without specific prior written permission.

 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES,
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */


$config = OW::getConfig();

if ( !$config->configExists('shoppro', 'mode_payment') ){
    $config->addConfig('shoppro', 'mode_payment', "paypal", 'paypal,pay24');
}

if ( !$config->configExists('shoppro', 'mode') ){
    $config->addConfig('shoppro', 'mode', "0", 'With sitebar or not');
}

if ( !$config->configExists('shoppro', 'max_cat_title_chars') ){
    $config->addConfig('shoppro', 'max_cat_title_chars', "20", 'Max category name length');
}

if ( !$config->configExists('shoppro', 'paypal_currency') ){
    $config->addConfig('shoppro', 'paypal_currency', "USD", 'Currency (USD,PLN,...)');
}

if ( !$config->configExists('shoppro', 'pay24_currency') ){
    $config->addConfig('shoppro', 'pay24_currency', "PLN", 'Currency (PLN,...)');
}

if ( !$config->configExists('shoppro', 'paypal_account') ){
    $config->addConfig('shoppro', 'paypal_account', "", 'PayPal account');
}
if ( !$config->configExists('shoppro', 'pay24_account') ){
    $config->addConfig('shoppro', 'pay24_account', "", 'Platnosci24.pl account');
}

if ( !$config->configExists('shoppro', 'pay24_account_crc') ){
    $config->addConfig('shoppro', 'pay24_account_crc', "", 'Account Platnosci24.pl SCR');
}




Updater::getLanguageService()->importPrefixFromZip(dirname(__FILE__).DS.'langs.zip', 'shoppro');


$errors = array();

try
{
    $sql = "CREATE TABLE IF NOT EXISTS `".OW_DB_PREFIX."shoppro_categories` (
  `id` int(11) NOT NULL auto_increment,
  `sort` int(5) NOT NULL,
  `active` enum('0','1') collate utf8_bin NOT NULL default '1',
  `name` varchar(255) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `sort` (`sort`),
  KEY `active` (`active`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1";

    Updater::getDbo()->query($sql);
}
catch ( Exception $ex )
{
    $errors[] = $ex;
}


try {
    $sql = "ALTER TABLE  `".OW_DB_PREFIX."shoppro_products` ADD  `file_attach` VARCHAR( 128 ) NULL DEFAULT NULL AFTER  `active`";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}


try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_products` ADD  `id_owner` INT( 11 ) NOT NULL AFTER  `cat_id` ,ADD INDEX (  `id_owner` )";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}



try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_products` ADD  `seler_account` VARCHAR( 64 ) NULL DEFAULT NULL ,ADD  `seler_account_csc` VARCHAR( 64 ) NULL DEFAULT NULL";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}

if ( !empty($errors) )
{
//    printVar($errors);
    print_r($errors);
}







