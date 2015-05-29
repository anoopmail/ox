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
if ( !$config->configExists('shoppro', 'mode_shop') ){
    $config->addConfig('shoppro', 'mode_shop', "all", '');
}


$authorization = OW::getAuthorization();
$groupName = 'shoppro';
//$authorization->deleteGroup($groupName);
$authorization->addGroup($groupName);
$authorization->addAction($groupName, 'addshopproduct',true);
$authorization->addAction($groupName, 'addclassifieds',true);


    $cmpService = BOL_ComponentAdminService::getInstance();
    $widget = $cmpService->addWidget('SHOPPRO_CMP_IndexSlider', false);
    $placeWidget = $cmpService->addWidgetToPlace($widget, BOL_ComponentAdminService::PLACE_INDEX);
    $cmpService->addWidgetToPosition($placeWidget, BOL_ComponentAdminService::SECTION_RIGHT,0);


$errors=array();

try {
    $sql="ALTER TABLE  `".OW_DB_PREFIX."shoppro_products` ADD  `date_add` INT( 11 ) NOT NULL AFTER  `type_ads` , ADD  `date_modyfing` INT( 11 ) NOT NULL AFTER  `date_add` ,ADD INDEX (  `date_add` ,  `date_modyfing` )";
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





?>