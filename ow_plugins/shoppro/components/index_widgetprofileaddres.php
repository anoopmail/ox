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
 * Official website only: http://oxwall.a6.pl
 * Full license available at: http://oxwall.a6.pl


 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES,
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
***/


class SHOPPRO_CMP_IndexWidgetprofileaddres extends BASE_CLASS_Widget
{
    private $content = false;
    private $nl2br = false;

    public $ciduser = 0;
 
    public function __construct( BASE_CLASS_WidgetParameter $paramObject )
    {
        parent::__construct();
        $this->ciduser = $paramObject->additionalParamList['entityId'];
        if ( OW::getPluginManager()->isPluginActive('cart') AND $this->ciduser==OW::getUser()->getId() AND OW::getUser()->getId()>0){
            //echo $userId;
            $this->content =SHOPPRO_BOL_Service::getInstance()->make_addres($this->ciduser);
        }else{
//        if (!$this->content){
            $this->setVisible(false);
            return;
        }

    }
 
    public static function getSettingList() // If you redefine this method, you'll be able to add fields to the widget configuration form 
    {
        $settingList = array();
        return $settingList;
    }
 /*
    public static function processSettingList( $settings, $place ) // This method is called before saving the widget settings. Here you can process the settings entered by a user before saving them. 
    {
 
        return $settings;
    }

 */
    public static function getStandardSettingValueList() // If you redefine this method, you will be able to set default values for the standard widget settings. 
    {
        return array(
//                self::SETTING_WRAP_IN_BOX => true,
            self::SETTING_TITLE => OW::getLanguage()->text('shoppro', 'shop_addres_setting') // Set the widget title 
        );
    }
 
    public static function getAccess() // If you redefine this method, you'll be able to manage the widget visibility 
    {
        return self::ACCESS_ALL;
    }
 
    public function onBeforeRender() // The standard method of the component that is called before rendering
    {
//echo "2222";
//echo $this->ciduser;exit;
//        $content = $this->nl2br ? nl2br( $this->content ) : $this->content;
        //$content=NOTE_BOL_Service::getInstance()->get_profile_note('profile',$this->ciduser);
        //$content =SHOPPRO_BOL_Service::getInstance()->make_list("my","data",true);
        $content=$this->content;
        $this->assign('content', $content);
    }
}

