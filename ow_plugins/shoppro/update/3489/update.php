<?php

Updater::getLanguageService()->importPrefixFromZip(dirname(__FILE__).DS.'langs.zip', 'shoppro');
$config = OW::getConfig();
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


$errors=array();

try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_products` ADD  `curency` VARCHAR( 5 ) NOT NULL DEFAULT  'USD' AFTER  `price`";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}


try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_products` ADD  `count_downloads` INT( 11 ) NOT NULL DEFAULT  '0',ADD  `count_bay` INT( 11 ) NOT NULL DEFAULT  '0'";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}

if ( !empty($errors) )
{
//    printVar($errors);
    print_r($exArr);
}







