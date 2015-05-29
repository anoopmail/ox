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

try {

//    $storage = OW::getStorage();
$plugin = OW::getPluginManager()->getPlugin('shoppro');
//$staticDir = OW_DIR_STATIC_PLUGIN . $plugin->getModuleName() . DS;
$staticDir = OW_DIR_PLUGIN  . $plugin->getModuleName() . DS.  'static' . DS ;
//echo $staticDir."<br>";

    $userfilesDir = OW_DIR_USERFILES . 'plugins' . DS . 'shoppro' . DS;
//echo $userfilesDir;

//    $defaultPath = dirname(__FILE__) . DS .  'static' . DS ;
//    $defaultPath = $staticDir .  'static' . DS ;
    $defaultPath =$staticDir;
    $imagePath = $userfilesDir ;

    $file='prettyPhoto.css';
    if ( !copy($defaultPath.$file, $imagePath.$file) ){}



    $file='jquery.prettyPhoto.js';
    if ( !copy($defaultPath.$file, $imagePath.$file) ){}

$file='default_thumb.png';
    if ( !copy($defaultPath.$file, $imagePath.$file) ){}
$file='loader.gif';
    if ( !copy($defaultPath.$file, $imagePath.$file) ){}
$file='sprite_next.png';
    if ( !copy($defaultPath.$file, $imagePath.$file) ){}
$file='sprite.png';
    if ( !copy($defaultPath.$file, $imagePath.$file) ){}
$file='sprite_prev.png';
    if ( !copy($defaultPath.$file, $imagePath.$file) ){}
$file='sprite_x.png';
    if ( !copy($defaultPath.$file, $imagePath.$file) ){}
$file='sprite_y.png';
    if ( !copy($defaultPath.$file, $imagePath.$file) ){}


}
catch ( Exception $e ) { }

//echo "ss";exit;

$errors=array();

try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_products` ADD  `condition` INT( 5 ) NOT NULL DEFAULT  '1' AFTER  `file_attach` ,ADD  `classifieds_type` INT( 5 ) NOT NULL DEFAULT  '1' AFTER  `condition` ,ADD  `location` VARCHAR( 128 ) NULL DEFAULT NULL AFTER  `classifieds_type` ,ADD INDEX (  `location` )";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}

try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_products` ADD INDEX (  `classifieds_type` )";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}

try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_products` ADD INDEX (  `condition` )";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}

try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_products` ADD  `items` INT( 10 ) NOT NULL DEFAULT  '1' AFTER  `curency` ,ADD INDEX (  `items` )";
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


?>