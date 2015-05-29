<?php

Updater::getLanguageService()->importPrefixFromZip(dirname(__FILE__).DS.'langs.zip', 'shoppro');

$config = OW::getConfig();
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




if ( !empty($errors) )
{
    print_r($errors);
}







