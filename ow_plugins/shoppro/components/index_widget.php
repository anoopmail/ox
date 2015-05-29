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


class SHOPPRO_CMP_IndexWidget extends BASE_CLASS_Widget
{
    private $content = false;
    private $nl2br = false;
 
    public function __construct( BASE_CLASS_WidgetParameter $paramObject )
    {
//        parent::__construct();

        if (isset($paramObject->additionalParamList['entityId'])){
            $this->ciduser = $paramObject->additionalParamList['entityId'];
        }else{
            $this->ciduser =0;
        }
        //echo $userId;
//        $this->content =SHOPPRO_BOL_Service::getInstance()->make_list($this->ciduser);

//            $curent_lang=SHOPPRO_BOL_Service::getInstance()->get_curect_lang_id();
        $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products 
                        WHERE active  = '1' 
AND ( (type_ads='2' AND items>'0') OR (type_ads='1' AND items>'0') OR type_ads='0') 
ORDER BY id DESC, file_attach, name LIMIT 1";
            $arr = OW::getDbo()->queryForList($query);
            if (!isset($arr[0]) OR !count($arr[0])){
                $this->setVisible(false);
                return;
            }

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
*/
    }
 

    public static function getStandardSettingValueList()
    {
        $list = array(
            self::SETTING_TITLE => OW::getLanguage()->text('shoppro', 'recently_added'),
            self::SETTING_SHOW_TITLE => true,
                self::SETTING_WRAP_IN_BOX => true,
            self::SETTING_ICON => 'ow_ic_cart'
        );

        return $list;
    }


    public static function getSettingList() // If you redefine this method, you'll be able to add fields to the widget configuration form 
    {
        $settingList = array();
/*
        $settingList['content'] = array(
            'presentation' => self::PRESENTATION_TEXTAREA, // Field type
            'label' => OW::getLanguage()->text('base', 'custom_html_widget_content_label'), // Field name
            'value' => '' // Default value
        );
 
        $settingList['nl_to_br'] = array(
            'presentation' => self::PRESENTATION_CHECKBOX,
            'label' => OW::getLanguage()->text('base', 'custom_html_widget_nl2br_label'),
            'value' => '0'
        );
*/
        return $settingList;
    }
/* 
    public static function processSettingList( $settings, $place ) // This method is called before saving the widget settings. Here you can process the settings entered by a user before saving them. 
    {

        if ( $place != BOL_ComponentService::PLACE_DASHBOARD && !OW::getUser()->isAdmin() )
        {
            $settings['content'] = UTIL_HtmlTag::stripJs($settings['content']);
            $settings['content'] = UTIL_HtmlTag::stripTags($settings['content'], array('frame'), array(), true, true);
        }
        else
        {
            $settings['content'] = UTIL_HtmlTag::sanitize($settings['content']);
        }
        return $settings;
    }

 
    public static function getStandardSettingValueList() // If you redefine this method, you will be able to set default values for the standard widget settings. 
    {
        return array(
            self::SETTING_TITLE => OW::getLanguage()->text('shoppro', 'main_menu_item') // Set the widget title 
        );
    }
*/
    public static function getAccess() // If you redefine this method, you'll be able to manage the widget visibility 
    {
        return self::ACCESS_ALL;
    }
 
    public function onBeforeRender() // The standard method of the component that is called before rendering
    {
$curent_url=OW_URL_HOME;
//echo "fsdF";exit;
        $content="";
//        $content .="OK";
$curent_lang=SHOPPRO_BOL_Service::getInstance()->get_curect_lang_id();
$pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();
//$mode="list";
$mode=OW::getConfig()->getValue('shoppro', 'mode_inwidget');
if (!$mode) $mode="grid";
$maxx=OW::getConfig()->getValue('shoppro', 'max_items_inwidget');
if (!$maxx) $maxx=5;

        $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products 
                        WHERE active  = '1' 
AND ( (type_ads='2' AND items>'0') OR (type_ads='1' AND items>'0') OR type_ads='0') 
ORDER BY id DESC, file_attach, name LIMIT ".$maxx;


/*
            $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products pr 
    LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_description prsesc ON (prsesc.id_product_de=pr.id AND prsesc.id_lang_de='".addslashes($curent_lang)."') 
            WHERE active = '1' 
AND ( (pr.type_ads='2' AND pr.items>'0') OR (pr.type_ads='1' AND pr.items>'0') OR pr.type_ads='0') 
            ORDER BY id DESC, file_attach, name 
            LIMIT ".$maxx;
*/
//echo $query;exit;            

        


            $content_list="";
            $arr = OW::getDbo()->queryForList($query);
                        //$value=array();
            foreach ( $arr as $value )
            {
                                $product_image="ow_userfiles/plugins/shoppro/images/product_".$value['id'].".jpg";
                                if (is_file("./".$product_image)){
                                    $product_image=$curent_url.$product_image;
                                }else{
                                    $product_image="";
                                }
$seo_title="index";
//$seo_title=$this->make_seo_url($seo_title,100);


                if ($mode=="grid"){
                    $content_list .="<div style=\"float: left;height: 140px;padding: 11px 0px;text-align: center;overflow:hidden;\">";
//padding: 4px 6px 10px 10px;

                    $content_list .="<a href=\"".$curent_url."product/".$value['id']."/zoom/".$seo_title.".html\" alt=\"".stripslashes($value['name'])."\" style=\"text-decoration:none;\">";
                    $content_list .="<div style=\"position: relative;width: 130px;height: 90px;
padding: 4px 0px 10px 5px;
background: transparent url('images/photo_list_item_thumb.png') no-repeat 15px 0px;\">";
                    


                $content_list .="<div style=\"display:block;width:100%;margin:auto;text-align:center;\">";
//                if (strlen($value['seler_account'])>6 AND $value['price']>0){
                if ($value['price']>0 AND !$value['has_options']){
//                if (($value['price']*1)>0){
                    if ($value['type_ads']==2){
                        $content_list .="<b>".$value['price']."</b>&nbsp;<span style=\"font-size:9px;\">".OW::getLanguage()->text('shoppro', 'product_credits')."</span>";
                    }else{
                        $content_list .="<b>".$value['price']."</b>&nbsp;<span style=\"font-size:9px;\">".$value['curency']."</span>";
                    }
                }else if (!$value['price'] OR $value['price']==0){
//                    $content_list .="<b style=\"color:#080;\">".OW::getLanguage()->text('shoppro', 'product_table_product_free_ads')."</b>";
                    if (!$value['has_options']){
                        $content_list .="<b ><i>".OW::getLanguage()->text('shoppro', 'product_table_product_free_ads')."</i></b>";
                    }
                }
                $content_list .="</div>";

                    if ($product_image){
//                        $content_list .= "<div class=\"ow_box_emptyX ow_stdmarginX clearfix\"><img src=\"".$product_image."\" border=\"0\" width=\"80px\" title=\"".stripslashes($value['name'])."\" align=\"center\" style=\"margin:10px;\"></div>";
                        $content_list .= "<div class=\"ow_box_emptyX ow_stdmarginX clearfix\" style=\"max-height: 90px;\"><img src=\"".$product_image."\" border=\"0\" width=\"80px\" title=\"".stripslashes($value['name'])."\" align=\"center\" style=\"margin:10px;max-width:80px;max-height:80px;\"></div>";
                    }else{
                        $content_list .="<div class=\"ow_box_emptyX ow_stdmarginX clearfix\" style=\"height: 55px;max-height: 60px;\"><img id=\"img\" class=\"shop-slide_noimg\" border=\"0\" width=\"80px\" src=\"".$pluginStaticURL2."pkt.gif\" alt=\"".stripslashes($value['name'])."\" align=\"center\" style=\"margin:10px;height: 55px;max-width:80px;max-height:80px;\"/></div>";
                    }

                if (strlen($value['name'])>25) $endd="...";
                    else $endd="";
                $content_list .="<strong style=\"overflow: hidden;
white-space: normal;
max-height: 35px;
display: inline;\">".mb_substr($value['name'],0,25).$endd."</strong>";


                    $content_list .="</div>";
                    $content_list .="</a>";
                    
                    $content_list .="</div>";

                }else{
                $content_list .="<tr>";
                $content_list .="<td style=\"border-bottom:1px solid #eee;width:90px;text-align:center;\" valign=\"top\">";
                if ($product_image){
                    $content_list .="<a href=\"".$curent_url."product/".$value['id']."/zoom/".$seo_title.".html\" alt=\"".stripslashes($value['name'])."\">";
                    $content_list .= "<img src=\"".$product_image."\" border=\"0\" width=\"80px\" title=\"".stripslashes($value['name'])."\" align=\"left\" style=\"margin:10px;\">";
                    $content_list .="</a>";
                }
                $content_list .="</td>";
                $content_list .="<td style=\"border-bottom:1px solid #eee;\" valign=\"top\">";
                $content_list .="<a href=\"".$curent_url."product/".$value['id']."/zoom/".$seo_title.".html\" alt=\"".stripslashes($value['name'])."\">";
                if (strlen($value['name'])>25) $endd="...";
                    else $endd="";
                $content_list .="<strong>".mb_substr($value['name'],0,25).$endd."</strong>";
                $content_list .="</a>";
                $content_list .="<div style=\"display:block;width:100%;margin:auto;text-align:right;\">";
//                if (strlen($value['seler_account'])>6 AND $value['price']>0){
                if ($value['price']>0){
//                if (($value['price']*1)>0){
                    if ($value['type_ads']==2){
                        $content_list .=$value['price']."&nbsp;<span style=\"font-size:9px;\">".OW::getLanguage()->text('shoppro', 'product_credits')."</span>";
                    }else{
                        $content_list .=$value['price']."&nbsp;<span style=\"font-size:9px;\">".$value['curency']."</span>";
                    }
                }else if (!$value['price'] OR $value['price']==0){
//                    $content_list .="<b style=\"color:#080;\">".OW::getLanguage()->text('shoppro', 'product_table_product_free_ads')."</b>";
                    $content_list .="<b ><i>".OW::getLanguage()->text('shoppro', 'product_table_product_free_ads')."</i></b>";
                }
/*
                }else if (OW::getConfig()->getValue('shoppro', 'mode_sellfiles')==1 AND !$id_user){
                    $protect=substr(session_id(),3,10);
                    $content_list .="<a href=\"".$curent_url."sign-in?back-uri=".urlencode("shop/download/".$value['id']."/".$protect)."\">";
                    $content_list .= "<b style=\"color:#f00;\">".OW::getLanguage()->text('shoppro', 'product_loginfirst')."</b>";
                    $content_list .="</a>";
                }
*/
                $content_list .="</div>";
                $content_list .="</td>";
                $content_list .="</tr>";
                }
            }//for

//echo "2222";
//        $content = $this->nl2br ? nl2br( $this->content ) : $this->content;
$content_m ="";
            if ($content_list) {
                if ($mode=="grid"){
//                    $content ="<div style=\"float: left;height: 165px;padding: 11px 0px;text-align: center;\">";
                    $content .= $content_list;
//                    $content ="</div>";
                }else{
                    $content = "<table style=\"width:100%;margin:auto;\">".$content_list."</table>";
                }
                

$content ="<div class=\"clearfix\">".$content."</div>
<div class=\"ow_box_toolbar_cont clearfix\">
    <div class=\"ow_box_toolbar ow_remark\">
        <span style=\"\" class=\"ow_nowrap\">
        <a href=\"".$curent_url."shop\">".OW::getLanguage()->text('shoppro', 'more')."</a>
        </span>
    </div>
    </div>";

            }else{
                $content = "<div style=\"text-align:center;\">".OW::getLanguage()->text('shoppro', 'product_table_noitems')."</div>";
            }


$xx=$_SERVER["REQUEST_URI"];
if ($xx=="/index/customize" OR $xx=="index/customize" OR $xx=="index/customize/" OR $xx=="/dashboard/customize" OR $xx=="dashboard/customize" OR $xx=="dashboard/customize/" 
OR strpos($xx,"index/customize")!==false){
$script ="";
    $script .="<script>";
        $script .="$(document).ready(function(){";
$script .="$('.index-SHOPPRO_CMP_MenuWidget').hide();";
$script .="    });";
/*
    $script .="$(document).ready(function(){";
    $script .="
        $('.index-SHOPPRO_CMP_MenuWidget').hide();
        $('.index-SHOPPRO_CMP_MenuWidget')css('display','none');
alert('sss');
    ";

    $script .="    });";
*/
    $script .="</script>";
//echo "sdfsdF";exit;

//    OW::getDocument()->addOnloadScript($script);
    $content .=   $script;
}

        $this->assign('content', $content);
    }
}
