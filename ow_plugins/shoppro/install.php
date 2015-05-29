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

//installing language pack
OW::getLanguage()->importPluginLangs(OW::getPluginManager()->getPlugin('shoppro')->getRootDir().'langs.zip', 'shoppro');


//BOL_LanguageService::getInstance()->addPrefix('shoppro', 'Contact Us');
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
if ( !$config->configExists('shoppro', 'mode_perpage') ){
    $config->addConfig('shoppro', 'mode_perpage', "30", 'Perpage...');
}
if ( !$config->configExists('shoppro', 'sel_notyfybyemail') ){
    $config->addConfig('shoppro', 'sel_notyfybyemail', "0", '');
}
if ( !$config->configExists('shoppro', 'mode_shop') ){
    $config->addConfig('shoppro', 'mode_shop', "all", '');
}
if ( !$config->configExists('shoppro', 'max_items_inwidget') ){
    $config->addConfig('shoppro', 'max_items_inwidget', "10", '');
}
if ( !$config->configExists('shoppro', 'mode_inwidget') ){
    $config->addConfig('shoppro', 'mode_inwidget', "grid", '');
}
if ( !$config->configExists('shoppro', 'menu_colbut_color_from') ){
    $config->addConfig('shoppro', 'menu_colbut_color_from', '#ededed', '');
}
if ( !$config->configExists('shoppro', 'menu_colbut_color_to') ){
    $config->addConfig('shoppro', 'menu_colbut_color_to', '#f5f5f5', '');
}
if ( !$config->configExists('shoppro', 'menu_colbut_color_open') ){
    $config->addConfig('shoppro', 'menu_colbut_color_open', '#f5f5f5"', '');
}
if ( !$config->configExists('shoppro', 'menu_colbut_color_hover') ){
    $config->addConfig('shoppro', 'menu_colbut_color_hover', '#ededed', '');
}
if ( !$config->configExists('shoppro', 'menu_colbut_color_text') ){
    $config->addConfig('shoppro', 'menu_colbut_color_text', '#333333', '');
}
if ( !$config->configExists('shoppro', 'menu_colbut_color_shadow') ){
    $config->addConfig('shoppro', 'menu_colbut_color_shadow', '#7c777a', '');
}
if ( !$config->configExists('shoppro', 'fuck_oxwall_morerators') ){
    $config->addConfig('shoppro', 'fuck_oxwall_morerators', '1', '');
}

if ( !$config->configExists('shoppro', 'turn_on_commntsandrate') ){
    $config->addConfig('shoppro', 'turn_on_commntsandrate', '0', '');
}

if ( !$config->configExists('shoppro', 'hide_seller_avatar_onthelist') ){
    $config->addConfig('shoppro', 'hide_seller_avatar_onthelist', "0", '');
}
if ( !$config->configExists('shoppro', 'hide_product_small_details') ){
    $config->addConfig('shoppro', 'hide_product_small_details', "0", '');
}
if ( !$config->configExists('shoppro', 'hide_seller_small_icon') ){
    $config->addConfig('shoppro', 'hide_seller_small_icon', "0", '');
}
if ( !$config->configExists('shoppro', 'hide_more_button_onproductlist') ){
    $config->addConfig('shoppro', 'hide_more_button_onproductlist', "0", '');
}
if ( !$config->configExists('shoppro', 'try_hide_empty_category') ){
    $config->addConfig('shoppro', 'try_hide_empty_category', "1", '');
}
if ( !$config->configExists('shoppro', 'show_quty_inproduct') ){
    $config->addConfig('shoppro', 'show_quty_inproduct', "1", '');
}
if ( !$config->configExists('shoppro', 'comments_require_aproved') ){
    $config->addConfig('shoppro', 'comments_require_aproved', "0", '');
}
if ( !$config->configExists('shoppro', 'turn_on_ciew_couter') ){
    $config->addConfig('shoppro', 'turn_on_ciew_couter', "2", '');
}

if ( !$config->configExists('shoppro', 'corect_exif') ){
    $config->addConfig('shoppro', 'corect_exif', "0", '');
}
if ( !$config->configExists('shoppro', 'show_askbutton') ){
    $config->addConfig('shoppro', 'show_askbutton', "0", '');
}
if ( !$config->configExists('shoppro', 'hide_timeout_product') ){
    $config->addConfig('shoppro', 'hide_timeout_product', "1", '');
}
if ( !$config->configExists('shoppro', 'menu_colbut_sub_menu_bg') ){
    $config->addConfig('shoppro', 'menu_colbut_sub_menu_bg', "", '');
}
if ( !$config->configExists('shoppro', 'menu_colbut_bg_color') ){
    $config->addConfig('shoppro', 'menu_colbut_bg_color', "#FFFFFF", '');
}

if ( !$config->configExists('shoppro', 'defaut_view') ){
    $config->addConfig('shoppro', 'defaut_view', "list-view", '');
}


if ( !$config->configExists('shoppro', 'item_content_thumbal_height') ){
    $config->addConfig('shoppro', 'item_content_thumbal_height', "116", '');
}
if ( !$config->configExists('shoppro', 'item_image_thumbal_height') ){
    $config->addConfig('shoppro', 'item_image_thumbal_height', "160", '');
}
if ( !$config->configExists('shoppro', 'item_thumbal_width') ){
    $config->addConfig('shoppro', 'item_thumbal_width', "31", '');
}
if ( !$config->configExists('shoppro', 'item_price_backgroud_color') ){
    $config->addConfig('shoppro', 'item_price_backgroud_color', "#1C64A1", '');
}
if ( !$config->configExists('shoppro', 'item_background_content_color') ){
    $config->addConfig('shoppro', 'item_background_content_color', "#F1F1F1", '');
}
if ( !$config->configExists('shoppro', 'item_border_color') ){
    $config->addConfig('shoppro', 'item_border_color', "#D7D7D7", '');
}

if ( !$config->configExists('shoppro', 'hide_location') ){
    $config->addConfig('shoppro', 'hide_location', "0", '');
}
if ( !$config->configExists('shoppro', 'hide_condition') ){
    $config->addConfig('shoppro', 'hide_condition', "0", '');
}
if ( !$config->configExists('shoppro', 'hide_map_lat_lon') ){
    $config->addConfig('shoppro', 'hide_map_lat_lon', "0", '');
}
if ( !$config->configExists('shoppro', 'hide_wanted_avaiable') ){
    $config->addConfig('shoppro', 'hide_wanted_avaiable', "0", '');
}



//adding admin settings page
OW::getPluginManager()->addPluginSettingsRouteName('shoppro', 'shoppro.admin');

$authorization = OW::getAuthorization();
$groupName = 'shoppro';
$authorization->addGroup($groupName);
$authorization->addAction($groupName, 'addshopproduct');
//$authorization->addAction($groupName, 'addclassifieds',true);//fo guests too
$authorization->addAction($groupName, 'addclassifieds');

//auth_group_label

//auth_action_label_xxxxxxxxxxx
//auth_action_label_sellclassifieds
//auth_action_label_selproduct



/*
try {
    $storage = OW::getStorage();
    $userfilesDir = OW_DIR_USERFILES . 'plugins' . DS . 'shoppro' . DS;
    $defaultPath = dirname(__FILE__) . DS .  'static' . DS ;
    $imagePath = $userfilesDir ;
    $file='prettyPhoto.css';
    if ( !$storage->copyFile($defaultPath.$file, $imagePath.$file) ){}
    $file='jquery.prettyPhoto.js';
    if ( !$storage->copyFile($defaultPath.$file, $imagePath.$file) ){}

$file='default_thumb.png';
    if ( !$storage->copyFile($defaultPath.$file, $imagePath.$file) ){}
$file='loader.gif';
    if ( !$storage->copyFile($defaultPath.$file, $imagePath.$file) ){}
$file='sprite_next.png';
    if ( !$storage->copyFile($defaultPath.$file, $imagePath.$file) ){}
$file='sprite.png';
    if ( !$storage->copyFile($defaultPath.$file, $imagePath.$file) ){}
$file='sprite_prev.png';
    if ( !$storage->copyFile($defaultPath.$file, $imagePath.$file) ){}
$file='sprite_x.png';
    if ( !$storage->copyFile($defaultPath.$file, $imagePath.$file) ){}
$file='sprite_y.png';
    if ( !$storage->copyFile($defaultPath.$file, $imagePath.$file) ){}

}
catch ( Exception $e ) { }
*/

//----databases:
$sql = "DROP TABLE IF EXISTS `".OW_DB_PREFIX."shoppro_products`;";
OW::getDbo()->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS `".OW_DB_PREFIX."shoppro_products` (
  `id` int(11) NOT NULL auto_increment,
  `cat_id` int(11) NOT NULL default '0',
  `id_owner` int(11) NOT NULL,
  `has_options` enum('0','1') collate utf8_bin NOT NULL default '0',
  `has_multilanguage` enum('0','1') collate utf8_bin NOT NULL default '0',
  `name` varchar(255) collate utf8_bin NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `curency` varchar(5) collate utf8_bin NOT NULL default 'USD',
  `items` int(10) NOT NULL default '1',
  `active` enum('-1','0','1') collate utf8_bin NOT NULL default '1',
  `type_ads` enum('0','1','2') collate utf8_bin NOT NULL default '0',
  `date_add` int(11) NOT NULL,
  `date_modyfing` int(11) NOT NULL,
  `publish_totime` int(10) NOT NULL default '360',
  `to_date` int(11) default NULL,
  `promotion_date` int(11) default NULL,
  `promotion_is_vip` enum('0','1') collate utf8_bin NOT NULL default '0',
  `sortt` int(11) NOT NULL default '0',
  `file_attach` varchar(128) collate utf8_bin default NULL,
  `condition` int(5) NOT NULL default '1',
  `classifieds_type` int(5) NOT NULL default '1',
  `location` varchar(128) collate utf8_bin default NULL,
  `map_lan` varchar(64) collate utf8_bin NOT NULL,
  `map_lat` varchar(64) collate utf8_bin NOT NULL,
  `map_waschecking` enum('0','1') collate utf8_bin NOT NULL default '0',
  `description` text collate utf8_bin NOT NULL,
  `seler_account` varchar(64) collate utf8_bin default NULL,
  `seler_account_csc` varchar(64) collate utf8_bin default NULL,
  `count_downloads` int(11) NOT NULL default '0',
  `count_bay` int(11) NOT NULL default '0',
  `count_view` bigint(22) NOT NULL default '0',
  `sync_unique_id` varchar(128) collate utf8_bin NOT NULL,
  `synd_datamod` int(11) NOT NULL,
  `sync_external_partner` varchar(32) collate utf8_bin NOT NULL,
  `data_add_ads` timestamp NULL default CURRENT_TIMESTAMP,
  `data_from_ip` varchar(64) collate utf8_bin default NULL,
  PRIMARY KEY  (`id`),
  KEY `active` (`active`),
  KEY `name` (`name`),
  KEY `price` (`price`),
  KEY `id_owner` (`id_owner`),
  KEY `promotion_date` (`promotion_date`),
  KEY `promotion_is_vip` (`promotion_is_vip`),
  KEY `sortt` (`sortt`),
  KEY `to_date` (`to_date`),
  KEY `publish_totime` (`publish_totime`),
  KEY `type_ads` (`type_ads`),
  KEY `promotion_date_2` (`promotion_date`),
  KEY `promotion_is_vip_2` (`promotion_is_vip`),
  KEY `sortt_2` (`sortt`),
  KEY `promotion_date_3` (`promotion_date`),
  KEY `promotion_is_vip_3` (`promotion_is_vip`),
  KEY `sortt_3` (`sortt`),
  KEY `promotion_date_4` (`promotion_date`),
  KEY `promotion_is_vip_4` (`promotion_is_vip`),
  KEY `sortt_4` (`sortt`),
  KEY `location` (`location`),
  KEY `classifieds_type` (`classifieds_type`),
  KEY `condition` (`condition`),
  KEY `classifieds_type_2` (`classifieds_type`),
  KEY `condition_2` (`condition`),
  KEY `items` (`items`),
  KEY `date_add` (`date_add`,`date_modyfing`),
  KEY `sync_unique_id` (`sync_unique_id`,`synd_datamod`,`sync_external_partner`),
  KEY `has_options` (`has_options`),
  KEY `has_multilanguage` (`has_multilanguage`),
  KEY `count_view` (`count_view`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=300 ;";
OW::getDbo()->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS `".OW_DB_PREFIX."shoppro_products_options` (
  `id` bigint(22) NOT NULL auto_increment,
  `id_product` int(11) NOT NULL,
  `id_owner` int(11) NOT NULL,
  `order_prod` int(10) NOT NULL,
  `name` varchar(64) collate utf8_bin NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `currence` varchar(5) collate utf8_bin NOT NULL default 'USD',
  `items` int(11) NOT NULL,
  `unlimited` enum('0','1') collate utf8_bin NOT NULL default '0',
  `active` enum('0','1') collate utf8_bin NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `id_owner` (`id_owner`),
  KEY `id_product` (`id_product`),
  KEY `order_prod` (`order_prod`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=30 ;";
OW::getDbo()->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS `" . OW_DB_PREFIX . "shoppro_seller` (
  `is_owner` int(11) NOT NULL,
  `termofuse` text collate utf8_bin,
  UNIQUE KEY `is_owner` (`is_owner`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
OW::getDbo()->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS `" . OW_DB_PREFIX . "shoppro_department` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(200) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM ROW_FORMAT=DEFAULT";
OW::getDbo()->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS `" . OW_DB_PREFIX . "shoppro_catgroups` (
  `idc` int(11) NOT NULL auto_increment,
  `idc2` int(11) NOT NULL default '0',
  `id_lang_ccat` int(10) default NULL,
  `sortc` int(5) NOT NULL,
  `activec` enum('0','1') collate utf8_bin NOT NULL default '1',
  `namec` varchar(255) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`idc`),
  KEY `idc2` (`idc2`,`id_lang_ccat`),
  KEY `sortc` (`sortc`),
  KEY `activec` (`activec`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=20 ;";
OW::getDbo()->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS `".OW_DB_PREFIX."shoppro_categories` (
  `id` int(11) NOT NULL auto_increment,
  `id2` int(11) NOT NULL default '0',
  `id_cgroup` int(10) NOT NULL default '0',
  `id_lang_cat` int(10) default NULL,
  `sort` int(5) NOT NULL,
  `active` enum('0','1') collate utf8_bin NOT NULL default '1',
  `name` varchar(255) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `sort` (`sort`),
  KEY `active` (`active`),
  KEY `id2` (`id2`,`id_lang_cat`),
  KEY `id_cgroup` (`id_cgroup`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=20 ;";
OW::getDbo()->query($sql);


$sql = "DROP TABLE IF EXISTS `".OW_DB_PREFIX."shoppro_products_description`;";
OW::getDbo()->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS `".OW_DB_PREFIX."shoppro_products_description` (
  `id_product_de` bigint(22) NOT NULL,
  `id_lang_de` int(10) NOT NULL,
  `description_de` text NOT NULL,
  UNIQUE KEY `id_product_de` (`id_product_de`,`id_lang_de`),
  KEY `id_product_de_2` (`id_product_de`),
  KEY `id_lang_de` (`id_lang_de`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
OW::getDbo()->query($sql);


$sql = "DROP TABLE IF EXISTS `".OW_DB_PREFIX."shoppro_catgroups_description`;";
OW::getDbo()->query($sql);
$sql = "CREATE TABLE IF NOT EXISTS `".OW_DB_PREFIX."shoppro_catgroups_description` (
  `id_product_gr` bigint(22) NOT NULL,
  `id_lang_gr` int(10) NOT NULL,
  `description_gr` text NOT NULL,
  UNIQUE KEY `id_product_de` (`id_product_gr`,`id_lang_gr`),
  KEY `id_product_de_2` (`id_product_gr`),
  KEY `id_lang_de` (`id_lang_gr`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
OW::getDbo()->query($sql);


$sql = "DROP TABLE IF EXISTS `".OW_DB_PREFIX."shoppro_categories_description`;";
OW::getDbo()->query($sql);
$sql = "CREATE TABLE IF NOT EXISTS `".OW_DB_PREFIX."shoppro_categories_description` (
  `id_product_cat` bigint(22) NOT NULL,
  `id_lang_cat` int(10) NOT NULL,
  `description_cat` text NOT NULL,
  UNIQUE KEY `id_product_de` (`id_product_cat`,`id_lang_cat`),
  KEY `id_product_de_2` (`id_product_cat`),
  KEY `id_lang_de` (`id_lang_cat`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
OW::getDbo()->query($sql);


$sql = "INSERT INTO `".OW_DB_PREFIX."shoppro_categories` (`id`, `sort`, `active`, `name`) VALUES
('', 0, '1', 'Category 1');";
OW::getDbo()->insert($sql);

$sql="INSERT INTO  `".OW_DB_PREFIX."shoppro_catgroups` (`idc` ,`idc2` ,`id_lang_ccat` ,`sortc` ,`activec` ,`namec`)VALUES ('1' ,  '0',  NULL,  '0',  '1',  'Default');";
OW::getDbo()->insert($sql);

$sql="UPDATE  `".OW_DB_PREFIX."shoppro_categories` SET id_cgroup =  '1' WHERE 1;";
OW::getDbo()->query($sql);




$sql="DELETE FROM `".OW_DB_PREFIX."base_billing_sale` WHERE pluginKey='shoppro_product' ;";
OW::getDbo()->query($sql);


//$authorization->addAction($groupName, '');
//$authorization->addAction($groupName, 'delete_comment_by_content_owner');
//$authorization->addAction($groupName, 'view', true);
//if (!OW::getUser()->isAuthorized('adsense', 'add')) {
