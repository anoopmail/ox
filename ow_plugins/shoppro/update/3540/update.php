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



/*
$config = OW::getConfig();
if ( !$config->configExists('shoppro', 'turn_on_commntsandrate') ){
    $config->addConfig('shoppro', 'turn_on_commntsandrate', '0', '');
}

$plname="shoppro";
$source=OW_DIR_PLUGIN.$plname. DS.'static'. DS;
$pluginStaticDir = OW_DIR_STATIC .'plugins'.DS.$plname.DS;


//echo $source;
//echo "<hr>";
//echo $pluginStaticDir;
//exit;

//CMS_BOL_Service::getInstance()->cpydir($source, $pluginStaticDir);
//echo "sss";exit;

if (!function_exists('shoppro_cms_cpydir')) {    
    function shoppro_cms_cpydir($source,$dest){
        if(is_dir($source)) {
            $dir_handle=opendir($source);
            while($file=readdir($dir_handle)){
                if($file!="." && $file!=".."){
                    if(is_dir($source.$file)){

                        if (!is_dir($dest.$file.DS)) mkdir($dest.$file.DS);

                        shoppro_cms_cpydir($source.$file.DS, $dest.$file.DS);
                    } else {
//echo $source.$file."<br>".$dest.$file."<hr>";
//                        if (!is_file($dest.$file)) copy($source.$file, $dest.$file);
                         copy($source.$file, $dest.$file);
                    }
                }
            }
            closedir($dir_handle);
        } else {
            copy($source, $dest);
        }
    }
}
shoppro_cms_cpydir($source, $pluginStaticDir);
*/


/*
$errors=array();

try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_categories` ADD  `id2` INT NOT NULL DEFAULT  '0' AFTER  `id` ,ADD  `id_lang_cat` INT( 10 ) NULL DEFAULT NULL AFTER  `id2` ,ADD INDEX (  `id2` ,  `id_lang_cat` )";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}


try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_categories` ADD  `id_cgroup` INT( 10 ) NOT NULL DEFAULT  '0' AFTER  `id2` ,ADD INDEX (  `id_cgroup` )";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}


try {
    $sql="CREATE TABLE IF NOT EXISTS `".OW_DB_PREFIX."shoppro_catgroups` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=8 ;";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}


try {
    $sql="INSERT INTO  `".OW_DB_PREFIX."shoppro_catgroups` (`idc` ,`idc2` ,`id_lang_ccat` ,`sortc` ,`activec` ,`namec`)VALUES ('1' ,  '0',  NULL,  '0',  '1',  'Default');";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}


try {
    $sql="UPDATE  `".OW_DB_PREFIX."shoppro_categories` SET id_cgroup =  '1' WHERE 1;";
    Updater::getDbo()->query($sql);
} 
catch ( Exception $e ) 
{ 
    $errors[] = $e;
}


if ( !empty($errors) )
{
//    print_r($errors);
}
*/

?>