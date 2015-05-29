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


class SHOPPRO_CTRL_Admin extends ADMIN_CTRL_Abstract
{

    public function dept()
    {

        $content="";
        $config = OW::getConfig();
        $curent_url = 'http';
        if (isset($_SERVER["HTTPS"])) {$curent_url .= "s";}
        $curent_url .= "://";
        $curent_url .= $_SERVER["SERVER_NAME"]."/";
$curent_url=OW_URL_HOME;                                        
/*
$from_config=$curent_url;
$from_config=str_replace("https://","",$from_config);
$from_config=str_replace("http://","",$from_config);
$trash=explode($from_config,$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);
$url_detect=$trash[1];
//print_r($trash);
//echo $url_detect;
*/

            $this->setPageTitle(OW::getLanguage()->text('shoppro', 'index_page_title'));
        $this->setPageHeading(OW::getLanguage()->text('shoppro', 'index_page_title'));


        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();//iss admin

if (!isset($_POST['save_config'])) $_POST['save_config']="";


/*
        if ( !$config->configExists('shoppro', 'mode') ){
            $config->addConfig('shoppro', 'mode', "0", '');//make

            $config->saveConfig('shoppro', 'mode', 0);//save
        }

//        $config->saveConfig('shoppro', 'mode', 1);

        $photosPerPage = $config->getValue('shoppro', 'mode');//read

echo "===================".$photosPerPage;
*/
//        $photosPerPage = $config->getValue('shoppro', 'mode');//read
//echo "===================".$photosPerPage;
//print_r($_POST);
        if ($_POST['save_config']==session_id() AND $id_user>0 AND $is_admin){       

            $config->saveConfig('shoppro', 'mode', $_POST['c_mode']);
    $config->saveConfig('shoppro', 'publish_newproduct_onwall', $_POST['c_publish_newproduct_onwall']);
    $config->saveConfig('shoppro', 'publish_updateproduct_onwall', $_POST['c_publish_updateproduct_onwall']);
            $config->saveConfig('shoppro', 'mode_membercanshell', $_POST['c_mode_membercanshell']);
            $config->saveConfig('shoppro', 'mode_sellfiles', $_POST['c_mode_sellfiles']);
            $config->saveConfig('shoppro', 'mode_payment', $_POST['c_mode_payment']);
            $config->saveConfig('shoppro', 'max_cat_title_chars', $_POST['c_max_cat_title_chars']);
        $config->saveConfig('shoppro', 'max_product_title_chars', $_POST['c_max_product_title_chars']);
            $config->saveConfig('shoppro', 'paypal_currency', $_POST['c_paypal_currency']);
            $config->saveConfig('shoppro', 'pay24_currency', $_POST['c_pay24_currency']);
            $config->saveConfig('shoppro', 'paypal_account', $_POST['c_paypal_account']);
            $config->saveConfig('shoppro', 'pay24_account', $_POST['c_pay24_account']);
            $config->saveConfig('shoppro', 'pay24_account_crc', $_POST['c_pay24_account_crc']);
if (!OW::getPluginManager()->isPluginActive('wysiwygeditor')){
            $config->saveConfig('shoppro', 'admin_replace_btobr', $_POST['c_admin_replace_btobr']);
}else{
            $config->saveConfig('shoppro', 'admin_replace_btobr', '0');
}

            $config->saveConfig('shoppro', 'show_quty_inproduct', $_POST['c_show_quty_inproduct']);

            $config->saveConfig('shoppro', 'config_page_on_top_shop', $_POST['c_config_page_on_top_shop']);
            $config->saveConfig('shoppro', 'config_page_on_top_shop_title', $_POST['c_config_page_on_top_shop_title']);

            if (SHOPPRO_BOL_Service::getInstance()->isplugin('usercredits')){
                $config->saveConfig('shoppro', 'mode_membercanpromotion', $_POST['c_mode_membercanpromotion']);
            }
            $config->saveConfig('shoppro', 'mode_member_accounttype_cansale', $_POST['c_mode_member_accounttype_cansale']);

            $config->saveConfig('shoppro', 'mode_ads_approval', $_POST['c_mode_ads_approval']);
            $config->saveConfig('shoppro', 'mode_membercanselingbypoints', $_POST['c_mode_membercanselingbypoints']);
            if (!$_POST['c_mode_membermastpaybyseling']) $_POST['c_mode_membermastpaybyseling']=0;
            $config->saveConfig('shoppro', 'mode_membermastpaybyseling', $_POST['c_mode_membermastpaybyseling']);

            if (!$_POST['c_mode_membergepointsfrombaing']) $_POST['c_mode_membergepointsfrombaing']=0;
            $config->saveConfig('shoppro', 'mode_membergepointsfrombaing', $_POST['c_mode_membergepointsfrombaing']);

            if (!$_POST['c_mode_perpage']) $_POST['c_mode_perpage']=30;
            $config->saveConfig('shoppro', 'mode_perpage', $_POST['c_mode_perpage']);

            
            $config->saveConfig('shoppro', 'sel_notyfybyemail', $_POST['c_sel_notyfybyemail']);

            $config->saveConfig('shoppro', 'mode_shop', $_POST['c_mode_shop']);

            $config->saveConfig('shoppro', 'max_items_inwidget', $_POST['c_max_items_inwidget']);
            if (isset($_POST['c_mode_inwidget'])){
                $config->saveConfig('shoppro', 'mode_inwidget', $_POST['c_mode_inwidget']);
            }

//            if (isset($_POST['c_max_product_desc_chars'])){
//                $config->saveConfig('shoppro', 'max_product_desc_chars', $_POST['c_max_product_desc_chars']);
//            }

            $config->saveConfig('shoppro', 'try_hide_empty_category', $_POST['c_try_hide_empty_category']);

            $config->saveConfig('shoppro', 'menu_colbut_color_from', $_POST['c_menu_colbut_color_from']);
            $config->saveConfig('shoppro', 'menu_colbut_color_to', $_POST['c_menu_colbut_color_to']);
            $config->saveConfig('shoppro', 'menu_colbut_color_open', $_POST['c_menu_colbut_color_open']);
            $config->saveConfig('shoppro', 'menu_colbut_color_hover', $_POST['c_menu_colbut_color_hover']);
            $config->saveConfig('shoppro', 'menu_colbut_color_text', $_POST['c_menu_colbut_color_text']);
            $config->saveConfig('shoppro', 'menu_colbut_color_shadow', $_POST['c_menu_colbut_color_shadow']);
            $config->saveConfig('shoppro', 'menu_colbut_sub_menu_bg', $_POST['c_menu_colbut_sub_menu_bg']);
            $config->saveConfig('shoppro', 'menu_colbut_bg_color', $_POST['c_menu_colbut_bg_color']);

            $config->saveConfig('shoppro', 'defaut_view', $_POST['c_defaut_view']);

            if (isset($_POST['c_turn_on_commntsandrate'])){
                $config->saveConfig('shoppro', 'turn_on_commntsandrate', $_POST['c_turn_on_commntsandrate']);
            }


        
            $config->saveConfig('shoppro', 'hide_seller_avatar_onthelist', $_POST['c_hide_seller_avatar_onthelist']);
            $config->saveConfig('shoppro', 'hide_product_small_details', $_POST['c_hide_product_small_details']);
            $config->saveConfig('shoppro', 'hide_seller_small_icon', $_POST['c_hide_seller_small_icon']);
            $config->saveConfig('shoppro', 'hide_more_button_onproductlist', $_POST['c_hide_more_button_onproductlist']);


            $config->saveConfig('shoppro', 'turn_on_ciew_couter', $_POST['c_turn_on_ciew_couter']);
            $config->saveConfig('shoppro', 'corect_exif', $_POST['c_corect_exif']);

            $config->saveConfig('shoppro', 'show_askbutton', $_POST['c_show_askbutton']);

            $config->saveConfig('shoppro', 'hide_timeout_product', $_POST['c_hide_timeout_product']);


            $config->saveConfig('shoppro', 'item_content_thumbal_height', $_POST['c_item_content_thumbal_height']);
            $config->saveConfig('shoppro', 'item_image_thumbal_height', $_POST['c_item_image_thumbal_height']);
            $config->saveConfig('shoppro', 'item_thumbal_width', $_POST['c_item_thumbal_width']);
            $config->saveConfig('shoppro', 'item_price_backgroud_color', $_POST['c_item_price_backgroud_color']);
            $config->saveConfig('shoppro', 'item_background_content_color', $_POST['c_item_background_content_color']);
            $config->saveConfig('shoppro', 'item_border_color', $_POST['c_item_border_color']);

            $config->saveConfig('shoppro', 'hide_location', $_POST['c_hide_location']);
            $config->saveConfig('shoppro', 'hide_condition', $_POST['c_hide_condition']);
            $config->saveConfig('shoppro', 'hide_map_lat_lon', $_POST['c_hide_map_lat_lon']);
            $config->saveConfig('shoppro', 'hide_wanted_avaiable', $_POST['c_hide_wanted_avaiable']);


//TODO
//if ( !$config->configExists('shoppro', 'comments_require_aproved') ){
//    $config->addConfig('shoppro', 'comments_require_aproved', "0", '');
//}
        if (!isset($_POST['c_comments_require_aproved'])){
            $config->saveConfig('shoppro', 'comments_require_aproved', '0');
        }else{
            $config->saveConfig('shoppro', 'comments_require_aproved', $_POST['c_comments_require_aproved']);
        }
//$config->saveConfig('shoppro', 'comments_require_aproved', '1');//show wonly for admin
//$config->saveConfig('shoppro', 'comments_require_aproved', '0');//show all comments



//    $config->saveConfig('shoppro', 'mode_member_role_cansale', $_POST['c_mode_member_role_cansale']);
        $setting_roles=$_POST['c_mode_member_role_cansale_cb'];
        if (isset($setting_roles[0]) AND $setting_roles[0]==1){
            $isforall=1;
        }else{
            $isforall=0;
        }
        $query = "SELECT * FROM " . OW_DB_PREFIX. "base_authorization_role ORDER BY sortOrder";
        $arrx = OW::getDbo()->queryForList($query);
        $roles_array="";
        foreach ( $arrx as $value ) {
            $idtmp=$value['id'];
            if ( $isforall==1 OR (isset($setting_roles[$idtmp]) AND $setting_roles[$idtmp]==1)){
                if ($roles_array) $roles_array .=",";
                $roles_array .=$idtmp;
            }
        }

        $config->saveConfig('shoppro', 'mode_member_role_cansale', $roles_array);



if (OW::getConfig()->getValue('shoppro', 'mode')==1){
//echo "ss";exit;
    BOL_ComponentAdminService::getInstance()->deleteWidget('SHOPPRO_CMP_MenuWidget');
    $cmpService = BOL_ComponentAdminService::getInstance();
//    $widget = $cmpService->addWidget('SHOPPRO_CMP_MenuWidget', false);
    $widget = $cmpService->addWidget('SHOPPRO_CMP_MenuWidget');
    $placeWidget = $cmpService->addWidgetToPlace($widget, BOL_ComponentAdminService::PLACE_INDEX);
    $cmpService->addWidgetToPosition($placeWidget, BOL_ComponentAdminService::SECTION_SIDEBAR,0);
}else{
    BOL_ComponentAdminService::getInstance()->deleteWidget('SHOPPRO_CMP_MenuWidget');
}
            OW::getApplication()->redirect($curent_url."admin/plugins/shoppro");    
        }

        $content .="<form method=\"post\" action=\"".$curent_url."admin/plugins/shoppro\">";
        $content .="<input type=\"hidden\" name=\"save_config\" value=\"".session_id()."\">";
        $content .="<table style=\"width:auto;margin:auto;\" class=\"ow_table_1 ow_form ow_stdmargin\">";
/*
        $content .="<tr>";
        $content .="<td style=\"background:#eee;border-top:1px solid #555;border-bottom:1px solid #555;\" colspan=\"2\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_global_setting').":</b>";
        $content .="</td>";
        $content .="</tr>";
*/

        $content .="<tr class=\"ow_tr_first\">
            <th class=\"ow_name ow_txtleft\" colspan=\"2\">
                <span class=\"ow_section_icon ow_ic_gear_wheel\">".OW::getLanguage()->text('shoppro', 'settings')."</span>
            </th>
        </tr>";

        $content .="<tr>";
        $content .="<td class=\"ow_label\" style=\"text-align:right;width:50%;\">";
//        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_shop_modetheme').":</b>";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_shop_modetheme_n').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\">";
        $mode=OW::getConfig()->getValue('shoppro', 'mode');
        $content .="<select name=\"c_mode\" >";
        if ($mode=="0" OR !$mode) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_mode_woutsidebar_n')."</option>";
        if ($mode=="1")  $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_mode_wsidebar_n')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";




        $content .="<tr>";
        $content .="<td class=\"ow_label\" style=\"text-align:right;width:50%;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'defaut_view').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\">";
        $mode=OW::getConfig()->getValue('shoppro', 'defaut_view');
        $content .="<select name=\"c_defaut_view\" >";
        if ($mode=="list-view" OR !$mode) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"list-view\">".OW::getLanguage()->text('shoppro', 'list_view')."</option>";
        if ($mode=="grid-view")  $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"grid-view\">".OW::getLanguage()->text('shoppro', 'grid_view')."</option>";


        if ($mode=="grid-view-only")  $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"grid-view-only\">".OW::getLanguage()->text('shoppro', 'nly_grid_view')."</option>";

        if ($mode=="list-view-only")  $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"list-view-only\">".OW::getLanguage()->text('shoppro', 'only_grid_view')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";


if (!SHOPPRO_BOL_Service::getInstance()->is_fuckmoderators()){
        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'turnon_comentsandrate_ex').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'turn_on_commntsandrate');
        $content .="<select name=\"c_turn_on_commntsandrate\">";
        if ($mode=="0" OR !$mode) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_no')."</option>";
        if ($mode=="1") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_yes')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";


        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
//        $content .="<b>".OW::getLanguage()->text('shoppro', 'comments_require_aproved').":</b>";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'comments_only_for_admin').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
//        $mode=$config->getValue('shoppro', 'comments_require_aproved');
        $mode=$config->getValue('shoppro', 'comments_only_for_admin');
        $content .="<select name=\"c_comments_require_aproved\">";
        if ($mode=="0" OR !$mode) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_no')."</option>";
        if ($mode=="1") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_yes')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";



        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'hide_timeout_product').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'hide_timeout_product');
        $content .="<select name=\"c_hide_timeout_product\">";
        if ($mode=="0") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_no')."</option>";
        if ($mode=="1" OR $mode=="") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_yes')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";

}



//TODO
//if ( !$config->configExists('shoppro', 'comments_require_aproved') ){
//    $config->addConfig('shoppro', 'comments_require_aproved', "0", '');
//}


        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'show_quty_inproduct').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'show_quty_inproduct');
        $content .="<select name=\"c_show_quty_inproduct\">";
        if ($mode=="0" OR !$mode) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_no')."</option>";
        if ($mode=="1") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_yes')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";


        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'turn_on_ciew_couter').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'turn_on_ciew_couter');
        $content .="<select name=\"c_turn_on_ciew_couter\">";
        if ($mode=="0" OR !$mode) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_no')."</option>";
        if ($mode=="1") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_yes')."</option>";
        if ($mode=="2") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"2\">".OW::getLanguage()->text('shoppro', 'only_for_owner')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";


        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'corect_exif').":</b>";
        $content .="<br/><i>".OW::getLanguage()->text('shoppro', 'corect_exif_info')."</i>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'corect_exif');
        $content .="<select name=\"c_corect_exif\">";
        if ($mode=="0") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_no')."</option>";
        if ($mode=="1" OR !$mode) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_yes')."</option>";
        $content .="</select>";

        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'show_askbutton').":</b>";
        $content .="<br/><i>".OW::getLanguage()->text('shoppro', 'show_askbutton')."</i>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'show_askbutton');
        $content .="<select name=\"c_show_askbutton\">";
        if ($mode=="0" OR !$mode) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_no')."</option>";
        if ($mode=="1" ) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_yes')."</option>";
        $content .="</select>";

        $content .="</td>";
        $content .="</tr>";




        $content .="<tr id=\"select_shop_mode\" style=\"border-top:1px solid #eee;\">";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_shop_mode').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'mode_shop');
        $content .="<select id=\"c_mode_shop\" name=\"c_mode_shop\">";

        if ($mode=="all" OR !$mode) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"all\">".OW::getLanguage()->text('shoppro', 'config_shopmode_all')."</option>";

        if ($mode=="classifieds") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"classifieds\">".OW::getLanguage()->text('shoppro', 'config_shopmode_classifieds')."</option>";

        if ($mode=="shop") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"shop\">".OW::getLanguage()->text('shoppro', 'config_shopmode_shop')."</option>";

//        if ($mode=="pay24") $sel=" selected ";
//            else $sel="";
//        $content .="<option ".$sel." value=\"pay24\">Platnosci24.pl</option>";


        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";


        $content .="<tr id=\"shop_mode1\">";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_select_payments').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'mode_payment');
        $content .="<select name=\"c_mode_payment\">";

//        if ($mode=="paypal" OR !$mode) $sel=" selected ";
//            else $sel="";
        $sel=" selected ";
        $content .="<option ".$sel." value=\"paypal\">PayPal</option>";

//        if ($mode=="przelewy24") $sel=" selected ";
//            else $sel="";
//        $content .="<option ".$sel." value=\"przelewy24\">przelewy24.pl</option>";

//        if ($mode=="pay24") $sel=" selected ";
//            else $sel="";
//        $content .="<option ".$sel." value=\"pay24\">Platnosci24.pl</option>";

//        if ($mode=="webtopay") $sel=" selected ";
//            else $sel="";
//        $content .="<option ".$sel." value=\"webtopay\">webtopay.com</option>";

        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";


        $content .="<tr id=\"shop_mode2\" >";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_paypal_currency_default').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
//$content .=$config->getValue('shoppro', 'paypal_currency');
        $content .="<select name=\"c_paypal_currency\">";

        $paypal_currency=$config->getValue('shoppro', 'paypal_currency');

        if ($paypal_currency=="AUD") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"AUD\">AUD</option>";
        if ($paypal_currency=="BRL") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"BRL\">BRL</option>";
        if ($paypal_currency=="CAD") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"CAD\">CAD</option>";
        if ($paypal_currency=="CZK") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"CZK\">CZK</option>";
        if ($paypal_currency=="DKK") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"DKK\">DKK</option>";
        if ($paypal_currency=="EUR") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"EUR\">EUR</option>";
        if ($paypal_currency=="HKD") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"HKD\">HKD</option>";


        if ($paypal_currency=="HUF") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"HUF\">HUF</option>";
        if ($paypal_currency=="ILS") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"ILS\">ILS</option>";
        if ($paypal_currency=="JPY") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"JPY\">JPY</option>";
        if ($paypal_currency=="MYR") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"MYR\">MYR</option>";
        if ($paypal_currency=="MXN") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"MXN\">MXN</option>";
        if ($paypal_currency=="NOK") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"NOK\">NOK</option>";
        if ($paypal_currency=="NZD") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"NZD\">NZD</option>";
        if ($paypal_currency=="PHP") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"PHP\">PHP</option>";
        if ($paypal_currency=="PLN") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"PLN\">PLN</option>";
        if ($paypal_currency=="GBP") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"GBP\">GBP</option>";
        if ($paypal_currency=="SGD") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"SGD\">SGD</option>";
        if ($paypal_currency=="SEK") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"SEK\">SEK</option>";
        if ($paypal_currency=="CHF") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"CHF\">CHF</option>";
        if ($paypal_currency=="TWD") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"TWD\">TWD</option>";
        if ($paypal_currency=="THB") $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"THB\">THB</option>";
        if ($paypal_currency=="USD" OR !$paypal_currency) $sel=" selected ";
            else $sel="";
$content .="<option ".$sel." value=\"USD\">USD</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";













//        $content .="<tr>";
        $content .="<tr style=\"border-top:1px solid #eee;\">";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_mode_membercanshell').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'mode_membercanshell');
        $content .="<select name=\"c_mode_membercanshell\" >";
        if ($mode=="0") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_mode_no_memberscanselling')."</option>";
        if ($mode=="1" OR (!$mode AND $mode!=0))  $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_mode_yes_memberscanselling')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_mode_ads_approval').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'mode_ads_approval');
        $content .="<select name=\"c_mode_ads_approval\" >";
        if ($mode=="0" OR !$mode) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_mode_no_memberscanselling')."</option>";
        if ($mode=="1")  $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_mode_yes_memberscanselling')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";


        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_mode_inform_seler_for_baingbyemil').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'sel_notyfybyemail');
        $content .="<select name=\"c_sel_notyfybyemail\" >";
        if ($mode=="0" OR !$mode) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_mode_no_memberscanselling')."</option>";
        if ($mode=="1")  $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_mode_yes_memberscanselling')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";




        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
//print_r($_SESSION);
//$_SESSION['accountType']
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_mode_member_role_cansale').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";

//        $content .="<a href=\"".$curent_url."admin/permissions/roles\">";
//        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_setuprole_permision').":</b>";
            $content .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_left\">";
        $content .="<a href=\"".$curent_url."admin/permissions/roles\" target=\"_blank\">";
                    $content .="<span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"button\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'config_setuprole_permision')."\" class=\"ow_ic_new ow_positive\">
                        </span>
                    </span>";
        $content .="</a>";
                $content .="</div>
            </div>";

//        $content .="</a>";
/*

//        $mode=$config->getValue('shoppro', 'mode_member_role_cansale');
        $mode=explode(",",$config->getValue('shoppro', 'mode_member_role_cansale'));

//        $content .="<select name=\"c_mode_member_role_cansale\" >";

//        if ($mode=="0" OR $mode=="") $sel=" selected ";
//            else $sel="";
///        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_mem_cam_all_sale')."</option>";

        $chcek_btn="";
//            if ($mode=="0" OR $mode=="") $sel=" checked ";
//            if (in_array(0, $mode)) $sel=" checked ";
            if (!is_array($mode)) $sel=" checked ";
                else $sel="";
            $chcek_btn .="<input ".$sel." type=\"checkbox\" name=\"c_mode_member_role_cansale_cb[0]\" value=\"1\" />&nbsp;<b>[".OW::getLanguage()->text('shoppro', 'config_mem_cam_all_sale')."]</b>";
            $chcek_btn .="<hr/>";

        $query = "SELECT * FROM " . OW_DB_PREFIX. "base_authorization_role ORDER BY sortOrder";
        $arrx = OW::getDbo()->queryForList($query);
        foreach ( $arrx as $value ) {
//            if ($mode==$value['id'])  $sel=" selected ";
//            if (is_array($mode) AND in_array($value['id'], $mode)) $sel=" checked ";
//                else $sel="";
//            $content .="<option ".$sel." value=\"".$value['id']."\">".OW::getLanguage()->text('base', "authorization_role_".$value['name'])."</option>";

//            if ($mode==$value['id'])  $sel=" checked ";
            if (is_array($mode) AND in_array($value['id'], $mode)) $sel=" checked ";
                else $sel="";
            $chcek_btn .="<input ".$sel." type=\"checkbox\" name=\"c_mode_member_role_cansale_cb[".$value['id']."]\" value=\"1\" />&nbsp;".OW::getLanguage()->text('base', "authorization_role_".$value['name']);
            $chcek_btn .="<br/>";
        }
//        $content .="</select>";

        $content .=$chcek_btn;
*/
        $content .="</td>";
        $content .="</tr>";


        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
//print_r($_SESSION);
//$_SESSION['accountType']
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_mode_member_accounttype_cansale').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'mode_member_accounttype_cansale');
        $content .="<select name=\"c_mode_member_accounttype_cansale\" >";
        if ($mode=="0" OR $mode=="") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_mem_cam_all_sale')."</option>";
        $query = "SELECT * FROM " . OW_DB_PREFIX. "base_question_account_type ORDER BY sortOrder";
        $arrx = OW::getDbo()->queryForList($query);
        foreach ( $arrx as $value ) {
            if ($mode==$value['name'])  $sel=" selected ";
                else $sel="";
            $content .="<option ".$sel." value=\"".$value['name']."\">".OW::getLanguage()->text('base', "questions_account_type_".$value['name'])."</option>";
        }
        $content .="</select>";

//        $content .="<br/>&nbsp;<a href=\"".$curent_url."admin/questions/edit-account-type\">";
//        $content .="<br/>&nbsp;";
//        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_add_account_types').":</b>";
            $content .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_left\">";
        $content .="<a href=\"".$curent_url."admin/questions/edit-account-type\" target=\"_blank\">";
                    $content .="<span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"button\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'config_add_account_types')."\" class=\"ow_ic_new ow_positive\">
                        </span>
                    </span>";
        $content .="</a>";
                $content .="</div>
            </div>";
//        $content .="</a>";

        $content .="</td>";
        $content .="</tr>";


        if (SHOPPRO_BOL_Service::getInstance()->isplugin('usercredits')){

        $content .="<tr class=\"ow_tr_first\">
            <th class=\"ow_name ow_txtleft\" colspan=\"2\">
                <span class=\"ow_section_icon ow_ic_gear_wheel\">".OW::getLanguage()->text('shoppro', 'settings_for_plugin_credits')."</span>
            </th>
        </tr>";

//            $content .="<tr>";
//            $content .="<td colspan=\"2\" style=\"width:100%;margin:auto;\">";
//            $content .="<hr/>";
//            $content .="</td>";
//            $content .="</tr>";


            $content .="<tr>";
            $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
            $content .="<b>".OW::getLanguage()->text('shoppro', 'config_mode_membercanseling_bypoints').":</b>";
            $content .="</td>";
            $content .="<td class=\"ow_value\" >";
            $mode=$config->getValue('shoppro', 'mode_membercanselingbypoints');
            $content .="<select name=\"c_mode_membercanselingbypoints\" >";
            if ($mode=="0" OR !$mode) $sel=" selected ";
                else $sel="";
            $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_mode_no_memberscanselling')."</option>";
            if ($mode=="1")  $sel=" selected ";
                else $sel="";
            $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_mode_yes_memberscanselling')."</option>";
            $content .="</select>";
            $content .="</td>";
            $content .="</tr>";


            $content .="<tr>";
            $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
            $content .="<b>".OW::getLanguage()->text('shoppro', 'config_mode_membercanpromotion_bypoints').":</b>";
            $content .="</td>";
            $content .="<td class=\"ow_value\" >";
            $mode=$config->getValue('shoppro', 'mode_membercanpromotion');
            $content .="<select name=\"c_mode_membercanpromotion\" >";
            if ($mode=="0") $sel=" selected ";
                else $sel="";
            $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_mode_no_memberscanselling')."</option>";
            if ($mode=="1" OR (!$mode AND $mode!=0))  $sel=" selected ";
                else $sel="";
            $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_mode_yes_memberscanselling')."</option>";
            $content .="</select>";
            $content .="</td>";
            $content .="</tr>";



            $content .="<tr>";
            $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
            $content .="<b>".OW::getLanguage()->text('shoppro', 'config_mode_membermastpaybyseling').":</b>";
            $content .="</td>";
            $content .="<td class=\"ow_value\" >";
            $mode=$config->getValue('shoppro', 'mode_membermastpaybyseling');
            $content .="<input type=\"text\" name=\"c_mode_membermastpaybyseling\" value=\"".$mode."\"  style=\"width:70px;\">";
/*
            $content .="<select name=\"c_mode_membermastpaybyseling\" >";
            if ($mode=="0" OR !$mode) $sel=" selected ";
                else $sel="";
            $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_mode_no_memberscanselling')."</option>";
            if ($mode=="1")  $sel=" selected ";
                else $sel="";
            $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_mode_yes_memberscanselling')."</option>";
            $content .="</select>";
*/
            $content .="</td>";
            $content .="</tr>";

            $content .="<tr>";
            $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
            $content .="<b>".OW::getLanguage()->text('shoppro', 'config_mode_membergepointsfrombaing').":</b>";
            $content .="</td>";
            $content .="<td class=\"ow_value\" >";
            $mode=$config->getValue('shoppro', 'mode_membergepointsfrombaing');
            $content .="<input type=\"text\" name=\"c_mode_membergepointsfrombaing\" value=\"".$mode."\"  style=\"width:70px;\">";
            $content .="</td>";
            $content .="</tr>";

//            $content .="<tr>";
//            $content .="<td colspan=\"2\" style=\"width:100%;margin:auto;\">";
//            $content .="<hr/>";
//            $content .="</td>";
//            $content .="</tr>";
        }




        $content .="<tr class=\"ow_tr_first\">
            <th class=\"ow_name ow_txtleft\" colspan=\"2\">
                <span class=\"ow_section_icon ow_ic_gear_wheel\">".OW::getLanguage()->text('shoppro', 'settings_menu')."</span>
            </th>
        </tr>";


        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'try_hide_empty_category').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'try_hide_empty_category');
        $content .="<select name=\"c_try_hide_empty_category\">";
        if ($mode=="0" OR !$mode) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_no')."</option>";
        if ($mode=="1") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_yes')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";


            $content .="<tr>";
            $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
            $content .="<b>".OW::getLanguage()->text('shoppro', 'menu_colbut_color_from_to').":</b>";
            $content .="</td>";
            $content .="<td class=\"ow_value\" >";
            $valc=$config->getValue('shoppro', 'menu_colbut_color_from');
            $content .="<input type=\"text\" name=\"c_menu_colbut_color_from\" value=\"".$valc."\" style=\"width:70px;\">";
            $content .="&nbsp;-&nbsp;";
            $valc=$config->getValue('shoppro', 'menu_colbut_color_to');
            $content .="<input type=\"text\" name=\"c_menu_colbut_color_to\" value=\"".$valc."\" style=\"width:70px;\">";
            $content .="&nbsp;(eg.: #ededed - #f5f5f5)";
            $content .="</td>";
            $content .="</tr>";

            $content .="<tr>";
            $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
            $content .="<b>".OW::getLanguage()->text('shoppro', 'menu_colbut_color_open').":</b>";
            $content .="</td>";
            $content .="<td class=\"ow_value\" >";
            $valc=$config->getValue('shoppro', 'menu_colbut_color_open');
            $content .="<input type=\"text\" name=\"c_menu_colbut_color_open\" value=\"".$valc."\" style=\"width:70px;\">";
            $content .="&nbsp;(eg.: #f5f5f5)";
            $content .="</td>";
            $content .="</tr>";

/*
            $content .="<tr>";
            $content .="<td style=\"text-align:right;\">";
            $content .="<b>".OW::getLanguage()->text('shoppro', 'menu_colbut_color_close').":</b>";
            $content .="</td>";
            $content .="<td>";
            $valc=$config->getValue('shoppro', 'menu_colbut_color_close');
            $content .="<input type=\"text\" name=\"c_menu_colbut_color_close\" value=\"".$valc."\" style=\"width:70px;\">";
            $content .="&nbsp;(eg.: #e0dadc)";
            $content .="</td>";
            $content .="</tr>";
*/        
            $content .="<tr>";
            $content .="<td class=\"ow_label\" style=\"text-align:right;\">";
            $content .="<b>".OW::getLanguage()->text('shoppro', 'menu_colbut_color_hover').":</b>";
            $content .="</td>";
            $content .="<td class=\"ow_value\" >";
            $valc=$config->getValue('shoppro', 'menu_colbut_color_hover');
            $content .="<input type=\"text\" name=\"c_menu_colbut_color_hover\" value=\"".$valc."\" style=\"width:70px;\">";
            $content .="&nbsp;(eg.: #ededed)";
            $content .="</td>";
            $content .="</tr>";

            $content .="<tr>";
            $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
            $content .="<b>".OW::getLanguage()->text('shoppro', 'menu_colbut_color_text').":</b>";
            $content .="</td>";
            $content .="<td class=\"ow_value\" >";
            $valc=$config->getValue('shoppro', 'menu_colbut_color_text');
            $content .="<input type=\"text\" name=\"c_menu_colbut_color_text\" value=\"".$valc."\" style=\"width:70px;\">";
            $content .="&nbsp;(eg.: #333333)";
            $content .="</td>";
            $content .="</tr>";

            $content .="<tr>";
            $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
            $content .="<b>".OW::getLanguage()->text('shoppro', 'menu_colbut_color_shadow').":</b>";
            $content .="</td>";
            $content .="<td class=\"ow_value\" >";
            $valc=$config->getValue('shoppro', 'menu_colbut_color_shadow');
            $content .="<input type=\"text\" name=\"c_menu_colbut_color_shadow\" value=\"".$valc."\" style=\"width:70px;\">";
            $content .="&nbsp;(eg.: #7c777a)";
            $content .="</td>";
            $content .="</tr>";

            $content .="<tr>";
            $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
            $content .="<b>".OW::getLanguage()->text('shoppro', 'menu_colbut_bg_color').":</b>";
            $content .="</td>";
            $content .="<td class=\"ow_value\" >";
            $valc=$config->getValue('shoppro', 'menu_colbut_bg_color');
            $content .="<input type=\"text\" name=\"c_menu_colbut_bg_color\" value=\"".$valc."\" style=\"width:70px;\">";
            $content .="&nbsp;(eg.: #FFFFFF)";
            $content .="</td>";
            $content .="</tr>";


            $content .="<tr>";
            $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
            $content .="<b>".OW::getLanguage()->text('shoppro', 'menu_colbut_sub_menu_bg').":</b>";
            $content .="</td>";
            $content .="<td class=\"ow_value\" >";
            $valc=$config->getValue('shoppro', 'menu_colbut_sub_menu_bg');
            $content .="<input type=\"text\" name=\"c_menu_colbut_sub_menu_bg\" value=\"".$valc."\" style=\"width:70px;\">";
            $content .="&nbsp;(eg.: #FEFEFE)";
            $content .="</td>";
            $content .="</tr>";

//            $content .="<tr>";
//            $content .="<td colspan=\"2\" style=\"width:100%;margin:auto;\">";
//            $content .="<hr/>";
//            $content .="</td>";
//            $content .="</tr>";


        $content .="<tr class=\"ow_tr_first\">
            <th class=\"ow_name ow_txtleft\" colspan=\"2\">
                <span class=\"ow_section_icon ow_ic_gear_wheel\">".OW::getLanguage()->text('shoppro', 'view_setting_grid')."</span>
            </th>
        </tr>";

            $content .="<tr>";
            $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
            $content .="<b>".OW::getLanguage()->text('shoppro', 'item_thumbal_width').":</b>";
            $content .="</td>";
            $content .="<td class=\"ow_value\" >";
            $mode=$config->getValue('shoppro', 'item_thumbal_width');
            $content .="<input type=\"text\" name=\"c_item_thumbal_width\" value=\"".$mode."\"  style=\"width:70px;\">&nbsp;[%]";
            $content .="&nbsp;(Default: 31)";
            $content .="</td>";
            $content .="</tr>";


            $content .="<tr>";
            $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
            $content .="<b>".OW::getLanguage()->text('shoppro', 'item_border_color').":</b>";
            $content .="</td>";
            $content .="<td class=\"ow_value\" >";
            $valc=$config->getValue('shoppro', 'item_border_color');
            $content .="<input type=\"text\" name=\"c_item_border_color\" value=\"".$valc."\" style=\"width:70px;\">";
            $content .="&nbsp;(Default: #D7D7D7)";
            $content .="</td>";
            $content .="</tr>";

            $content .="<tr>";
            $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
            $content .="<b>".OW::getLanguage()->text('shoppro', 'item_background_content_color').":</b>";
            $content .="</td>";
            $content .="<td class=\"ow_value\" >";
            $valc=$config->getValue('shoppro', 'item_background_content_color');
            $content .="<input type=\"text\" name=\"c_item_background_content_color\" value=\"".$valc."\" style=\"width:70px;\">";
            $content .="&nbsp;(Default: #F1F1F1)";
            $content .="</td>";
            $content .="</tr>";

            $content .="<tr>";
            $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
            $content .="<b>".OW::getLanguage()->text('shoppro', 'item_price_backgroud_color').":</b>";
            $content .="</td>";
            $content .="<td class=\"ow_value\" >";
            $valc=$config->getValue('shoppro', 'item_price_backgroud_color');
            $content .="<input type=\"text\" name=\"c_item_price_backgroud_color\" value=\"".$valc."\" style=\"width:70px;\">";
            $content .="&nbsp;(Default: #1C64A1)";
            $content .="</td>";
            $content .="</tr>";




            $content .="<tr>";
            $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
            $content .="<b>".OW::getLanguage()->text('shoppro', 'item_image_thumbal_height').":</b>";
            $content .="</td>";
            $content .="<td class=\"ow_value\" >";
            $mode=$config->getValue('shoppro', 'item_image_thumbal_height');
            $content .="<input type=\"text\" name=\"c_item_image_thumbal_height\" value=\"".$mode."\"  style=\"width:70px;\">&nbsp;[px]";
            $content .="&nbsp;(Default: 160)";
            $content .="</td>";
            $content .="</tr>";

/*
            $content .="<tr>";
            $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
            $content .="<b>".OW::getLanguage()->text('shoppro', 'item_content_thumbal_height').":</b>";
            $content .="</td>";
            $content .="<td class=\"ow_value\" >";
            $mode=$config->getValue('shoppro', 'item_content_thumbal_height');
            $content .="<input type=\"text\" name=\"c_item_content_thumbal_height\" value=\"".$mode."\"  style=\"width:70px;\">[px]";
            $content .="&nbsp;(Default: 116)";
            $content .="</td>";
            $content .="</tr>";
*/






        $content .="<tr class=\"ow_tr_first\">
            <th class=\"ow_name ow_txtleft\" colspan=\"2\">
                <span class=\"ow_section_icon ow_ic_gear_wheel\">".OW::getLanguage()->text('shoppro', 'settings_other')."</span>
            </th>
        </tr>";



        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'hide_seller_avatar_onthelist').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'hide_seller_avatar_onthelist');
        $content .="<select name=\"c_hide_seller_avatar_onthelist\">";
        if ($mode=="0") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_no')."</option>";
        if ($mode=="1" OR (!$mode AND $mode!=0)) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_yes')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'hide_product_small_details').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'hide_product_small_details');
        $content .="<select name=\"c_hide_product_small_details\">";
        if ($mode=="0") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_no')."</option>";
        if ($mode=="1" OR (!$mode AND $mode!=0)) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_yes')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td class=\"ow_label\" style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'hide_seller_small_icon').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'hide_seller_small_icon');
        $content .="<select name=\"c_hide_seller_small_icon\">";
        if ($mode=="0") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_no')."</option>";
        if ($mode=="1" OR (!$mode AND $mode!=0)) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_yes')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'hide_more_button_onproductlist').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'hide_more_button_onproductlist');
        $content .="<select name=\"c_hide_more_button_onproductlist\">";
        if ($mode=="0") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_no')."</option>";
        if ($mode=="1" OR (!$mode AND $mode!=0)) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_yes')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";



        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'hide_location').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'hide_location');
        $content .="<select name=\"c_hide_location\">";
        if ($mode=="0") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_no')."</option>";
        if ($mode=="1" OR (!$mode AND $mode!=0)) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_yes')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'hide_map_lat_lon').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'hide_map_lat_lon');
        $content .="<select name=\"c_hide_map_lat_lon\">";
        if ($mode=="0") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_no')."</option>";
        if ($mode=="1" OR (!$mode AND $mode!=0)) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_yes')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'hide_wanted_avaiable').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'hide_wanted_avaiable');
        $content .="<select name=\"c_hide_wanted_avaiable\">";
        if ($mode=="0") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_no')."</option>";
        if ($mode=="1" OR (!$mode AND $mode!=0)) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_yes')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'hide_condition').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'hide_condition');
        $content .="<select name=\"c_hide_condition\">";
        if ($mode=="0") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_no')."</option>";
        if ($mode=="1" OR (!$mode AND $mode!=0)) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_yes')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";






if (!SHOPPRO_BOL_Service::getInstance()->is_fuckmoderators()){
        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_max_inwidget').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $max=$config->getValue('shoppro', 'max_items_inwidget');
        if (!$max OR $max==0) $max=5;
        $content .="<input type=\"text\" name=\"c_max_items_inwidget\" value=\"".$max."\" style=\"width:70px;\">";
        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_mode_inwidget').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'mode_inwidget');
        if (!$mode) $mode="grid";
//        $content .="<input type=\"text\" name=\"c_mode_inwidget\" value=\"".$max."\">";
        $content .="<select name=\"c_mode_inwidget\">";
        if ($mode=="grid" OR !$mode) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"grid\">".OW::getLanguage()->text('shoppro', 'config_show_grid')."</option>";
        if ($mode=="list") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"list\">".OW::getLanguage()->text('shoppro', 'config_show_list')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";
}


        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_max_showperpage').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $max=$config->getValue('shoppro', 'mode_perpage');
        if (!$max OR $max==0) $max=30;
        $content .="<input type=\"text\" name=\"c_mode_perpage\" value=\"".$max."\" style=\"width:70px;\">";
        $content .="</td>";
        $content .="</tr>";


        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_mode_sellingfiles').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'mode_sellfiles');
        $content .="<select name=\"c_mode_sellfiles\" >";
        if ($mode=="0" OR !$mode) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_mode_userscantsellfiles')."</option>";
        if ($mode=="1")  $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_mode_userscansellfiles')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_max_cat_title_chars').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $content .="<input type=\"text\" name=\"c_max_cat_title_chars\" value=\"".$config->getValue('shoppro', 'max_cat_title_chars')."\"  style=\"width:70px;\">";
        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_max_product_title_chars').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $max_product_title_chars=$config->getValue('shoppro', 'max_product_title_chars');
        if (!$max_product_title_chars) $max_product_title_chars=45;
        $content .="<input type=\"text\" name=\"c_max_product_title_chars\" value=\"".$max_product_title_chars."\"  style=\"width:70px;\">";
        $content .="</td>";
        $content .="</tr>";
/*
        $content .="<tr>";
        $content .="<td style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_max_product_desc_chars').":</b>";
        $content .="</td>";
        $content .="<td>";      
        $max_product_desc_chars=$config->getValue('shoppro', 'max_product_desc_chars');
        if (!$max_product_desc_chars) $max_product_desc_chars=255;
        $content .="<input type=\"text\" name=\"c_max_product_desc_chars\" value=\"".$max_product_desc_chars."\">";
        $content .="</td>";
        $content .="</tr>";
*/

        $content .="<tr>";
        $content .="<td class=\"ow_label\"  style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_publish_newproduct_onwall').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'publish_newproduct_onwall');
        $content .="<select name=\"c_publish_newproduct_onwall\">";
        if ($mode=="0") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_no')."</option>";
        if ($mode=="1" OR (!$mode AND $mode!=0)) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_yes')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td class=\"ow_label\" style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_publish_updateproduct_onwall').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'publish_updateproduct_onwall');
        $content .="<select name=\"c_publish_updateproduct_onwall\">";
        if ($mode=="0" OR !$mode) $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_no')."</option>";
        if ($mode=="1") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_yes')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";




if (!OW::getPluginManager()->isPluginActive('wysiwygeditor')){
        $content .="<tr>";
        $content .="<td class=\"ow_label\" style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_replace_btobr').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\" >";
        $mode=$config->getValue('shoppro', 'admin_replace_btobr');
        $content .="<select name=\"c_admin_replace_btobr\" >";
        if ($mode=="0" OR !$mode OR $mode!=0 OR $mode=="") $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'config_mode_no_memberscanselling')."</option>";
        if ($mode=="1")  $sel=" selected ";
            else $sel="";
        $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'config_mode_yes_memberscanselling')."</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";
}

//        $content .="<tr style=\"border-top:1px solid #eee;\">";
        $content .="<tr >";
        $content .="<td class=\"ow_label\"  >";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_page_on_top_shop_title').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\"  style=\"text-align:right;\" >";
        $config_page_on_top_shop_title=$config->getValue('shoppro', 'config_page_on_top_shop_title');
        if (!$config_page_on_top_shop_title) $config_page_on_top_shop_title="";
        $content .="<input type=\"text\" name=\"c_config_page_on_top_shop_title\" value=\"".$config_page_on_top_shop_title."\">";
        $content .="</td>";
        $content .="</tr>";


        $content .="<tr>";
        $content .="<td class=\"ow_label\" >";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_page_on_top_shop').":</b>";
        $content .="</td>";
        $content .="<td class=\"ow_value\"  >";
        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td class=\"ow_value\" class=\"ow_value\" colspan=\"2\">";
        $content .="<textarea class=\"html\" name=\"c_config_page_on_top_shop\">".$config->getValue('shoppro', 'config_page_on_top_shop')."</textarea>";
        $content .="</td>";
        $content .="</tr>";


/*

        $content .="<tr>";
        $content .="<td style=\"background:#eee;border-top:1px solid #555;border-bottom:1px solid #555;\" colspan=\"2\">";
        $content .="<b>PayPal:</b>";
        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_paypal_account').":</b>";
        $content .="</td>";
        $content .="<td>";
        $content .="<input type=\"text\" name=\"c_paypal_account\" value=\"".$config->getValue('shoppro', 'paypal_account')."\">";
        $content .="</td>";
        $content .="</tr>";
*/


/*
        $content .="<tr>";
        $content .="<td style=\"background:#eee;border-top:1px solid #555;border-bottom:1px solid #555;\" colspan=\"2\">";
        $content .="<b>Platnosci24.pl:</b>";
        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_pay24_account').":</b>";
        $content .="</td>";
        $content .="<td>";
        $content .="<input type=\"text\" name=\"c_pay24_account\" value=\"".$config->getValue('shoppro', 'pay24_account')."\">";
        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_pay24_currency').":</b>";
        $content .="</td>";
        $content .="<td>";
        $content .="<select name=\"c_pay24_currency\">";
        $content .="<option value=\"PLN\">PLN</option>";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td style=\"text-align:right;\">";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'config_pay24_account_crc').":</b>";
        $content .="</td>";
        $content .="<td>";
        $content .="<input type=\"text\" name=\"c_pay24_account_crc\" value=\"".$config->getValue('shoppro', 'pay24_account_crc')."\">";
        $content .="</td>";
        $content .="</tr>";
*/
        $content .="<tr>";
        $content .="<td style=\"border-top:1px solid #ddd;text-align:right;\" colspan=\"2\">";
//        $content .="<input type=\"submit\" name=\"send\" value=\"".OW::getLanguage()->text('shoppro', 'config_save')."\">";
//        $content .="<span class=\"ow_button ow_ic_save\"><span><input type=\"submit\" class=\"ow_ic_save\" name=\"dosave\"  value=\"".OW::getLanguage()->text('shoppro', 'config_save')."\"></span></span>";
            $content .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"submit\" name=\"dosave\" value=\"".OW::getLanguage()->text('shoppro', 'config_save')."\" class=\"ow_ic_save ow_positive\">
                        </span>
                    </span>
                </div>
            </div>";

        $content .="</td>";
        $content .="</tr>";

        $content .="</table>";
        $content .="</form>";

        $content .="<script type=\"text/javascript\">";
        $content .="$(document).ready(function() {";

        $mode=$config->getValue('shoppro', 'mode_shop');
        if ($mode=="classifieds") {
            $content .="
                $('#shop_mode1').hide();
                $('#shop_mode2').hide();            
            ";
        }else if ($mode=="shop") {
            $content .="
                $('#shop_mode1').show();
                $('#shop_mode2').show();            
            ";
        }else{//all
            $content .="
                $('#shop_mode1').show();
                $('#shop_mode2').show();            
            ";
        }


$content .="

$('#c_mode_shop').change(function () {
    if ($(this).val()=='classifieds'){
        $('#shop_mode1').hide();
        $('#shop_mode2').hide();            
    }else if ($(this).val()=='shop'){
        $('#shop_mode1').show();
        $('#shop_mode2').show();            
    }else{
        $('#shop_mode1').show();
        $('#shop_mode2').show();            
    }    
})          

  
";
        $content .="})";
        $content .="</script>";

        $this->assign('content', $content);


/*	
        $this->setPageTitle(OW::getLanguage()->text('shoppro', 'admin_dept_title'));
        $this->setPageHeading(OW::getLanguage()->text('shoppro', 'admin_dept_heading'));
        $contactEmails = array();
        $deleteUrls = array();
        $contacts = SHOPPRO_BOL_Service::getInstance()->getDepartmentList();
        foreach ( $contacts as $contact )
        {
            // @var $contact shoppro_BOL_Department 
            $contactEmails[$contact->id]['name'] = $contact->id;
            $contactEmails[$contact->id]['email'] = $contact->email;
            $contactEmails[$contact->id]['label'] = SHOPPRO_BOL_Service::getInstance()->getDepartmentLabel($contact->id);
            $deleteUrls[$contact->id] = OW::getRouter()->urlFor(__CLASS__, 'delete', array('id' => $contact->id));
        }
        $this->assign('contacts', $contactEmails);
        $this->assign('deleteUrls', $deleteUrls);

        $form = new Form('add_dept');
        $this->addForm($form);

        $fieldEmail = new TextField('email');
        $fieldEmail->setRequired();
        $fieldEmail->addValidator(new EmailValidator());
        $fieldEmail->setInvitation(OW::getLanguage()->text('shoppro', 'label_invitation_email'));
        $fieldEmail->setHasInvitation(true);
        $form->addElement($fieldEmail);

        $fieldLabel = new TextField('label');
        $fieldLabel->setRequired();
        $fieldLabel->setInvitation(OW::getLanguage()->text('shoppro', 'label_invitation_label'));
        $fieldLabel->setHasInvitation(true);
        $form->addElement($fieldLabel);

        $submit = new Submit('add');
        $submit->setValue(OW::getLanguage()->text('shoppro', 'form_add_dept_submit'));
        $form->addElement($submit);

        if ( OW::getRequest()->isPost() )
        {
            if ( $form->isValid($_POST) )
            {
                $data = $form->getValues();
                SHOPPRO_BOL_Service::getInstance()->addDepartment($data['email'], $data['label']);
                $this->redirect();
            }
        }
*/
    }

    public function delete( $params )
    {
/*	
        if ( isset($params['id']) )
        {
            SHOPPRO_BOL_Service::getInstance()->deleteDepartment((int) $params['id']);
        }
        $this->redirect(OW::getRouter()->urlForRoute('shoppro.admin'));
*/	
    }
}
