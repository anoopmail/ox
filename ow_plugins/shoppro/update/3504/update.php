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
if ( !$config->configExists('shoppro', 'max_items_inwidget') ){
    $config->addConfig('shoppro', 'max_items_inwidget', "10", '');
}
if ( !$config->configExists('shoppro', 'mode_inwidget') ){
    $config->addConfig('shoppro', 'mode_inwidget', "grid", '');
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


?>