<?php

/***
 * This software is intended for use with Oxwall Free Community Software
 * http://www.oxwall.org/ and is a proprietary licensed product.
 * For more information see License.txt in the plugin folder.

 * =============================================================================
 * Copyright (c) 2012 by Aron. All rights reserved.
 * =============================================================================


 * Redistribution and use in source and binary forms, with or without modification, are not permitted provided.
 * Pass on to others in any form are not permitted provided.
 * Sale are not permitted provided.
 * Sale this product are not permitted provided.
 * Gift this product are not permitted provided.
 * This plugin should be bought from the developer by paying money to PayPal account: biuro@grafnet.pl
 * Legal purchase is possible only on the web page URL: http://www.oxwall.org/store
 * Modyfing of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
 * Modifying source code, all information like:copyright must remain.
 * Official website only: http://test.a6.pl
 * Full license available at: http://test.a6.pl


 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES,
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
***/


Updater::getLanguageService()->importPrefixFromZip(dirname(__FILE__).DS.'langs.zip', 'shoppro');

$config = OW::getConfig();
if ( !$config->configExists('shoppro', 'mode_perpage') ){
    $config->addConfig('shoppro', 'mode_perpage', "30", 'Perpage...');
}
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

if ( !$config->configExists('shoppro', 'mode_membercanshell') ){
    $config->addConfig('shoppro', 'mode_membercanshell', "1", 'Member can shell each products....');
}
if ( !$config->configExists('shoppro', 'mode_sellfiles') ){
    $config->addConfig('shoppro', 'mode_sellfiles', "0", 'Member can shell files...');
}

if ( !$config->configExists('shoppro', 'publish_newproduct_onwall') ){
    $config->addConfig('shoppro', 'publish_newproduct_onwall', "1", 'Publish new product on the wall...');
}

if ( !$config->configExists('shoppro', 'publish_updateproduct_onwall') ){
    $config->addConfig('shoppro', 'publish_updateproduct_onwall', "0", 'Publish update product on the wall...');
}

if ( !$config->configExists('shoppro', 'admin_replace_btobr') ){
    $config->addConfig('shoppro', 'admin_replace_btobr', "0", 'replace n to br...');
}
if ( !$config->configExists('shoppro', 'max_product_title_chars') ){
    $config->addConfig('shoppro', 'max_product_title_chars', "45", 'Max char in list product...');
}
if ( !$config->configExists('shoppro', 'config_page_on_top_shop') ){
    $config->addConfig('shoppro', 'config_page_on_top_shop', "", 'Info top text...');
}
if ( !$config->configExists('shoppro', 'config_page_on_top_shop_title') ){
    $config->addConfig('shoppro', 'config_page_on_top_shop_title', "", 'Info top title...');
}
if ( !$config->configExists('shoppro', 'mode_membercanpromotion') ){
    $config->addConfig('shoppro', 'mode_membercanpromotion', "0", 'Info top title...');
}
if ( !$config->configExists('shoppro', 'mode_member_accounttype_cansale') ){
    $config->addConfig('shoppro', 'mode_member_accounttype_cansale', "0", 'Account type can sale...');
}
if ( !$config->configExists('shoppro', 'mode_member_role_cansale') ){
    $config->addConfig('shoppro', 'mode_member_role_cansale', "0", 'Role type can sale...');
}
if ( !$config->configExists('shoppro', 'mode_ads_approval') ){
    $config->addConfig('shoppro', 'mode_ads_approval', "0", 'Approved...');
}
if ( !$config->configExists('shoppro', 'mode_membercanselingbypoints') ){
    $config->addConfig('shoppro', 'mode_membercanselingbypoints', "0", 'Sell by points...');
}
if ( !$config->configExists('shoppro', 'mode_membermastpaybyseling') ){
    $config->addConfig('shoppro', 'mode_membermastpaybyseling', "0", 'Pay by seling...');
}
if ( !$config->configExists('shoppro', 'mode_membergepointsfrombaing') ){
    $config->addConfig('shoppro', 'mode_membergepointsfrombaing', "0", 'Add points when member baing...');
}


$errors=array();

try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_products` ADD  `publish_totime` INT( 5 ) NOT NULL DEFAULT  '360' AFTER  `active` ,ADD INDEX (  `publish_totime` )";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}

try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_products` ADD  `type_ads` ENUM(  '0',  '1' ) NOT NULL DEFAULT  '0' AFTER  `active` ,ADD INDEX (  `type_ads` )";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}
try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_products` ADD  `to_date` INT( 11 ) NULL DEFAULT NULL AFTER  `publish_totime` ,ADD INDEX (  `to_date` )";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}


try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_products` ADD  `promotion_date` INT( 11 ) NULL DEFAULT NULL AFTER  `active` ,
    ADD  `promotion_is_vip` ENUM(  '0',  '1' ) NOT NULL DEFAULT  '0' AFTER  `promotion_date` ,
    ADD  `sortt` INT( 11 ) NOT NULL DEFAULT  '0' AFTER  `promotion_is_vip` ";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}


try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_products` ADD INDEX (  `promotion_date` )";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}

try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_products` ADD INDEX (  `promotion_is_vip` )";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}

try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_products` ADD INDEX (  `sortt` )";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}

try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_products` CHANGE  `active`  `active` ENUM(  '-1',  '0',  '1' ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT  '1'";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}


try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_products` CHANGE  `type_ads`  `type_ads` ENUM(  '0',  '1',  '2' ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT  '0'";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}


if ( !empty($errors) )
{
    print_r($errors);
}







