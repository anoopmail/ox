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


class SHOPPRO_CMP_MenuWidget extends BASE_CLASS_Widget
{

    public function __construct( BASE_CLASS_WidgetParameter $params )
    {

        parent::__construct();
/* 
        $params = $paramObject->customParamList;
 
        if ( !empty($params['content']) )
        {
            $this->content = $paramObject->customizeMode && !empty($_GET['disable-js']) ? UTIL_HtmlTag::stripJs($params['content']) : $params['content'];
        }
 
        if ( isset($params['nl_to_br']) )
        {
            $this->nl2br = (bool) $params['nl_to_br'];
        }

     if ( empty($list) && !OW::getUser()->isAuthorized('shoppro', 'add') && !$params->customizeMode )
        {
            $this->setVisible(false);

            return;
        }

*/
//        if (  strpos($_SERVER['REQUEST_URI'],"mobille/app")===true !OW::getUser()->isAuthorized('shoppro', 'add') && !$params->customizeMode )
        if (strpos($_SERVER['REQUEST_URI'],"shop")===true OR strpos($_SERVER['REQUEST_URI'],"shop")>0 OR
            strpos($_SERVER['REQUEST_URI'],"shoppro")===true OR strpos($_SERVER['REQUEST_URI'],"shoppro")>0 OR
            strpos($_SERVER['REQUEST_URI'],"shoppro_adm")===true OR strpos($_SERVER['REQUEST_URI'],"shoppro_adm")>0 OR 
            strpos($_SERVER['REQUEST_URI'],"basket")===true OR strpos($_SERVER['REQUEST_URI'],"basket")>0 OR 
//            strpos($_SERVER['REQUEST_URI'],"order")===true OR strpos($_SERVER['REQUEST_URI'],"order")>0 OR 
                (
                    (strpos($_SERVER['REQUEST_URI'],"order")===true OR strpos($_SERVER['REQUEST_URI'],"order")>0) AND  
                    (strpos($_SERVER['REQUEST_URI'],"order_")!==true AND !strpos($_SERVER['REQUEST_URI'],"order_")>0) 
                ) OR 
            strpos($_SERVER['REQUEST_URI'],"ordershop")===true OR strpos($_SERVER['REQUEST_URI'],"ordershop")>0 OR 
            strpos($_SERVER['REQUEST_URI'],"product")===true OR strpos($_SERVER['REQUEST_URI'],"product")>0
        ){
            //OK
        }else{
            $this->setVisible(false);
            return;
        }


    }

    public static function getSettingList()
    {

        $options = array();
        $settingList=array();
/*
        for ( $i = 3; $i <= 10; $i++ )
        {
            $options[$i] = $i;
        }

        $settingList['count'] = array(
            'presentation' => self::PRESENTATION_SELECT,
            'label' => OW::getLanguage()->text('shoppro', 'cmp_widget_post_count'),
            'optionList' => $options,
            'value' => 3,
        );
        $settingList['previewLength'] = array(
            'presentation' => self::PRESENTATION_TEXT,
            'label' => OW::getLanguage()->text('shoppro', 'blog_widget_preview_length_lbl'),
            'value' => 50,
        );
*/
        return $settingList;
    }

    public static function getStandardSettingValueList()
    {
        $list = array(
            self::SETTING_TITLE => OW::getLanguage()->text('shoppro', 'main_menu_item'),
            self::SETTING_SHOW_TITLE => true,
                self::SETTING_WRAP_IN_BOX => true,
            self::SETTING_ICON => 'ow_ic_write'
        );

        return $list;
    }

    public static function getAccess()
    {
        return self::ACCESS_ALL;
    }
	
    public function onBeforeRender() // The standard method of the component that is called before rendering
    {
            $content="";

//echo "Sfsdf";exit;
        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();//iss admin
            $pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();
            $pluginStaticURL =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesUrl();
            $pluginStaticDir =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesDir();

                    $curent_url = 'http';
                    if (isset($_SERVER["HTTPS"])) {$curent_url .= "s";}
                    $curent_url .= "://";
                    $curent_url .= $_SERVER["SERVER_NAME"]."/";
$curent_url=OW_URL_HOME;                                        
$from_config=$curent_url;
$from_config=str_replace("https://","",$from_config);
$from_config=str_replace("http://","",$from_config);
$trash=explode($from_config,$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);

//$url_detect=$trash[1];
$trash2=explode("?",$trash[1]);
$url_detect=$trash2[0];


if (isset($url_detect[0]) AND $url_detect[0]=="/") {
    $url_detect=substr($url_detect,1);
}
/*
$idcat=0;
list($url_detect,$idcat)=explode("/",$url_detect);
if ($url_detect=="shoppro" AND (!$idcat OR $idcat<0)) $idcat=0;
*/
$idcat=0;
if (!isset($url_detect) OR !$url_detect){
    $url_detect=0;
}else{
    $tabx=explode("/",$url_detect);
}
//list($url_detect,$idcat)=explode("/",$url_detect);
//print_r($tabx);exit;
//echo $url_detect;exit;
if (isset($tabx[0])) $url_detect=$tabx[0];
if (isset($tabx[1])) $idcat=$tabx[1];
if ($url_detect=="shoppro" AND (!$idcat OR $idcat<0)) $idcat=0;




//print_r($trash);
//echo "-------------".$url_detect;exit;


            $content .=SHOPPRO_BOL_Service::getInstance()->make_menu($idcat);
/*		
        if ($url_detect=="shop" OR $url_detect=="shoppro" OR $url_detect=="shoppro_adm" OR $url_detect=="basket" OR $url_detect=="order" OR $url_detect=="ordershop" OR $url_detect=="product"){
            $content .=SHOPPRO_BOL_Service::getInstance()->make_menu($idcat);


        }else{
            $content  ="<script>\n";
            $content .="\$(document).ready(function(){\n";
            $content .="\$(\".index-SHOPPRO_CMP_MenuWidget\").empty().remove();\n";
            $content .="    });\n";
            $content .="</script>";
        }
*/


		$this->assign('content', $content);
	}
	
}

