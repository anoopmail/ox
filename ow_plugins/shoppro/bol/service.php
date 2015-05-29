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


//$is_points=SHOPPRO_BOL_Service::getInstance()->isplugin('usercredits');
//SHOPPRO_BOL_Service::getInstance()->is_cart();
//SHOPPRO_BOL_Service::getInstance()->is_fuckmoderators();
class SHOPPRO_BOL_Service
{
    private static $classInstance;

    var $tabmenu=array();    

    public static function getInstance()
    {
        if ( self::$classInstance === null )
        {
            self::$classInstance = new self();
        }

        return self::$classInstance;
    }

    private function __construct()
    {

    }

    public function getDepartmentLabel( $id )
    {
        return OW::getLanguage()->text('shoppro', $this->getDepartmentKey($id));
    }

    public function addDepartment( $email, $label )
    {
        $contact = new SHOPPRO_BOL_Department();
        $contact->email = $email;
        SHOPPRO_BOL_DepartmentDao::getInstance()->save($contact);

        BOL_LanguageService::getInstance()->addValue(
            OW::getLanguage()->getCurrentId(),
            'shoppro',
            $this->getDepartmentKey($contact->id),
            trim($label));
    }

    public function is_fuckmoderators( )
    {
//        return OW::getConfig()->getValue('shoppro', 'fuck_oxwall_morerators');
        return 0;
    }

    public function deleteDepartment( $id )
    {
        $id = (int) $id;
        if ( $id > 0 )
        {
            $key = BOL_LanguageService::getInstance()->findKey('shoppro', $this->getDepartmentKey($id));
            BOL_LanguageService::getInstance()->deleteKey($key->id, true);
            SHOPPRO_BOL_DepartmentDao::getInstance()->deleteById($id);
        }
    }

    public function get_curency_paypal_options($paypal_currency ="")
    {               
        $content="";
if (!$paypal_currency) {
    if (OW::getConfig()->getValue('base', 'billing_currency')) $paypal_currency=OW::getConfig()->getValue('base', 'billing_currency');
        else $paypal_currency="USD";
}

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
        return $content;
    }


    public function get_one_paymentoption($product_id=0,$type="smaller")//return one payment option
    {
        $ret=array();
        if ($product_id>0){
//            $today=strtotime(date('Y-m-d H:i:s'));
            if ($type=="bigger"){
                $sql = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products_options WHERE id_product='".addslashes($product_id)."' AND (items>'0' OR unlimited>'0') AND active='1' ORDER BY price DESC LIMIT 1";
            }else{//smaller
                $sql = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products_options WHERE id_product='".addslashes($product_id)."' AND (items>'0' OR unlimited>'0') AND active='1'  ORDER BY price ASC LIMIT 1";
            }
            $arr = OW::getDbo()->queryForList($sql);
            foreach ( $arr as $value )
            {       
                $ret=$value;
            }
        }
        if (!isset($value['id']) OR !$value['id']){
            $value['id']=0;
            $ret=$value;
        }
        return $ret;
    }

    public function make_paymet_options($product_id=0,$ac="show")
    {
        $ret ="";
        $reth ="";
$max_opts=10;
        if ($product_id>0){
//            $today=strtotime(date('Y-m-d H:i:s'));
            $sql = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products_options WHERE id_product='".addslashes($product_id)."' ORDER BY order_prod ASC ";
            $arr = OW::getDbo()->queryForList($sql);
            $lp=0;
            foreach ( $arr as $value )
            {            
                $lp++;
                if ($ac=="edit"){
                    $ret .="<tr>";
                    $ret .="<td>";
                    $ret .="<input type=\"hidden\" name=\"fopid[]\" value=\"".$value['id']."\">";
                    $ret .=$lp;
                    $ret .="</td>";
                    $ret .="<td>";
                    $ret .="<input type=\"text\" name=\"fop_name[".$value['id']."]\" value=\"".stripslashes($value['name'])."\">";
                    $ret .="</td>";
                    $ret .="<td>";
                    $ret .="<input type=\"text\" name=\"fop_price[".$value['id']."]\" value=\"".$value['price']."\">";
                    $ret .="</td>";
                    $ret .="<td>";
//                    $ret .="<input type=\"text\" name=\"fop_currence[".$value['id']."]\" value=\"".$this->get_curency_paypal_options($value['currence'])."\">";
                    $ret .="<select name=\"fop_currence[".$value['id']."]\">";
                    $ret .=$this->get_curency_paypal_options($value['currence']);
                    $ret .="</select>";
                    $ret .="</td>";
                    $ret .="<td>";
                    $ret .="<input type=\"text\" name=\"fop_items[".$value['id']."]\" value=\"".$value['items']."\">";
                    $ret .="</td>";
                    $ret .="<td>";
                    if ($value['unlimited']==1) $sel=" CHECKED ";
                        else $sel="";
                    $ret .="<input ".$sel." type=\"checkbox\" name=\"fop_unlimited[".$value['id']."]\" value=\"1\">";
                    $ret .="</td>";
                    $ret .="<td>";//product_table_sort
                    $ret .="<input type=\"text\" name=\"fop_sort[".$value['id']."]\" value=\"".$value['order_prod']."\">";
                    $ret .="</td>";
                    $ret .="</tr>";
                }else{
//echo "fsdF";exit;
                    
                    $qty="";
                    $is_avaiable=false;
                    if ($value['unlimited']==1){
                        $ret .="<option value=\"".$value['id']."\">".stripslashes($value['name'])." ".$value['price']." ".$value['currence']." ".$qty."</option>";
                        $is_avaiable=true;
                    }else if ($value['unlimited']==0 AND $value['active']==1 AND $value['items']>0){
                        if (OW::getConfig()->getValue('shoppro', 'show_quty_inproduct')){
                            $qty="(".$value['items']." ".OW::getLanguage()->text('shoppro', 'short_qty').")";
                        }
                        $ret .="<option value=\"".$value['id']."\">".stripslashes($value['name'])." ".$value['price']." ".$value['currence']." ".$qty."</option>";
                        $is_avaiable=true;
                    }

                    if ($is_avaiable==true){
                        $reth .="<input type=\"hidden\" id=\"opt_".$product_id."_".$value['id']."_id\" name=\"opt_".$product_id."_".$value['id']."\" value=\"".$value['id']."\">";
                        $reth .="<input type=\"hidden\" id=\"opt_".$product_id."_".$value['id']."_price\" name=\"opt_".$product_id."_".$value['id']."_price\" value=\"".$value['price']."\">";
                        $reth .="<input type=\"hidden\" id=\"opt_".$product_id."_".$value['id']."_currence\"  name=\"opt_".$product_id."_".$value['id']."_currence\" value=\"".$value['currence']."\">";
                        $reth .="<input type=\"hidden\" id=\"opt_".$product_id."_".$value['id']."_name\"  name=\"opt_".$product_id."_".$value['id']."_name\" value=\"".$value['name']."\">";
                    }
                }
            }


        if ($ac=="edit"){
            if ($lp<$max_opts){
                for ($i=$lp;$i<$max_opts;$i++){
                    $lp++;

                    $ret .="<tr>";
                    $ret .="<td>";
                    $ret .="<input type=\"hidden\" name=\"fopid_new[]\" value=\"".$i."\">";
                    $ret .=$lp;
                    $ret .="</td>";
                    $ret .="<td>";
                    $ret .="<input type=\"text\" name=\"fop_name_new[".$i."]\" value=\"\">";
                    $ret .="</td>";
                    $ret .="<td>";
                    $ret .="<input type=\"text\" name=\"fop_price_new[".$i."]\" value=\"\">";
                    $ret .="</td>";
                    $ret .="<td>";
//                    $ret .="<input type=\"text\" name=\"fop_currence_new[".$i."]\" value=\"".$this->get_curency_paypal_options()."\">";
                    $ret .="<select name=\"fop_currence_new[".$i."]\">";
                    $ret .=$this->get_curency_paypal_options();
                    $ret .="</select>";
                    $ret .="</td>";
                    $ret .="<td>";
                    $ret .="<input type=\"text\" name=\"fop_items_new[".$i."]\" value=\"1\">";
                    $ret .="</td>";
                    $ret .="<td>";
                    $ret .="<input type=\"checkbox\" name=\"fop_unlimited_new[".$i."]\" value=\"1\">";
                    $ret .="</td>";
                    $ret .="<td>";//product_table_sort
                    $ret .="<input type=\"text\" name=\"fop_sort_new[".$i."]\" value=\"".(($i+1)*5)."\">";
                    $ret .="</td>";
                    $ret .="</tr>";
                }
            }//if
        }

        }else if ($ac=="edit"){
            $lp=0;
            for ($i=0;$i<$max_opts;$i++){
                    $lp++;
                    $ret .="<tr>";
                    $ret .="<td>";
                    $ret .="<input type=\"hidden\" name=\"fopid_new[]\" value=\"".$i."\">";
                    $ret .=$lp;
                    $ret .="</td>";
                    $ret .="<td>";
                    $ret .="<input type=\"text\" name=\"fop_name_new[".$i."]\" value=\"\">";
                    $ret .="</td>";
                    $ret .="<td>";
                    $ret .="<input type=\"text\" name=\"fop_price_new[".$i."]\" value=\"\">";
                    $ret .="</td>";
                    $ret .="<td>";
//                    $ret .="<input type=\"text\" name=\"fop_currence_new[".$i."]\" value=\"".$this->get_curency_paypal_options()."\">";
                    $ret .="<select name=\"fop_currence_new[".$i."]\">";
                    $ret .=$this->get_curency_paypal_options();
                    $ret .="</select>";
                    $ret .="</td>";
                    $ret .="<td>";
                    $ret .="<input type=\"text\" name=\"fop_items_new[".$i."]\" value=\"1\">";
                    $ret .="</td>";
                    $ret .="<td>";
                    $ret .="<input type=\"checkbox\" name=\"fop_unlimited_new[".$i."]\" value=\"1\">";
                    $ret .="</td>";
                    $ret .="<td>";//product_table_sort
                    $ret .="<input type=\"text\" name=\"fop_sort_new[".$i."]\" value=\"".(($i+1)*5)."\">";
                    $ret .="</td>";
                    $ret .="</tr>";
            }
        }
        if ($ac=="edit"){
            return $ret;
        }else{
            $retx=array();
            $retx['sel']=$ret;
            $retx['selh']=$reth;
            return $retx;
        }

    }

    public function is_cart()
    {
        if (!OW::getPluginManager()->isPluginActive('cart')) return false;
        else if (OW::getConfig()->getValue('cart', 'cart_on')=="0") return false;
        else return true;
    }





    //------------------------------------------------------------main product loypiyt
    //------------------------------------------------------------main product loypiyt
    public function thene_product($value=array(),$type="shop")
    {
    
        $curent_url=OW_URL_HOME;
        $is_user = OW::getUser()->getId();
        $id_user =$is_user;
        $is_admin = OW::getUser()->isAdmin();
        $products ="";

//$height_thumbal=180;//add to params
$height_thumbal=OW::getConfig()->getValue('shoppro', 'item_image_thumbal_height');
if (!$height_thumbal){
    $height_thumbal=160;//add to params
}

$height_thumbal_content=OW::getConfig()->getValue('shoppro', 'item_content_thumbal_height');
if (!$height_thumbal_content){
    $height_thumbal_content=116;//add to params 75
}


$width_thumbal=OW::getConfig()->getValue('shoppro', 'item_thumbal_width');
if (!$width_thumbal){
    $width_thumbal=30;//add to params 30
}


$border_cool_thumbal=OW::getConfig()->getValue('shoppro', 'item_border_color');
if (!$border_cool_thumbal){
    $border_cool_thumbal="#d7d7d7";//add to params #d7d7d7
}
$background_cool_thumbal=OW::getConfig()->getValue('shoppro', 'item_background_content_color');
if (!$background_cool_thumbal){
    $background_cool_thumbal="#f1f1f1";//add to params #f1f1f1
}
$background_ptica_color=OW::getConfig()->getValue('shoppro', 'item_price_backgroud_color');
if (!$background_ptica_color){
    $background_ptica_color="#1C64A1";//add to params #1C64A1
}


$border_cool_thumbal_add="";
if ($border_cool_thumbal){
    $border_cool_thumbal_add="border-width: 1px;border-style: solid;";
}


        $pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();
//                            $pluginStaticURL =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesUrl();
        $pluginStaticURL =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesUrl();
                            //$pluginDir =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesDir();
//                            $pluginStaticDir =OW::getPluginManager()->getPlugin('shoppro')->getStaticDir();
        $pluginStaticDir =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesDir();

        $dname=BOL_UserService::getInstance()->getDisplayName($value['id_owner']);
        $uurl=BOL_UserService::getInstance()->getUserUrl($value['id_owner']);
        $uimg=BOL_AvatarService::getInstance()->getAvatarUrl($value['id_owner']);

        $product_path=$pluginStaticDir;
//                                $product_image="ow_userfiles/plugins/shoppro/images/product_".$value['id'].".jpg";
        $product_image="product_".$value['id'].".jpg";
//        if (is_file($product_path."images/".$product_image)){
        if ($this->file_exist($product_path."images/".$product_image)){
            $product_image_url=$pluginStaticURL."images/".$product_image;
            $product_image=true;
        }else{
            $product_image_url=$pluginStaticURL2."ext/no_image.jpg";
            $product_image=false;
        }

        $seo_title=stripslashes($value['name']);
        $seo_title=$this->make_seo_url($seo_title,100);
//----

        $product_id=$value['id'];
//        $product_number=number_format($value['id'],10);
        $product_number=sprintf("%010d", $value['id']);
        $product_name=stripslashes($value['name']);
        $product_name= UTIL_String::truncate($product_name, 62, '..');//65

//                    $table .="<strong>".UTIL_DateTime::formatDate((int) $value['timeStamp'])."</strong>";

        $price="";
        $curency="";
        $price_block_display="none";
//echo $type;


        if ($type=="free"){
//            $price="<i>".OW::getLanguage()->text('shoppro', 'product_table_product_free_ads')."</i>";
                                if ($value['price']>0 AND !$value['has_options']){
                                    if ($value['type_ads']==2){//-------------------------------------------------------------------------credits
//                                        $products .="<strong style=\"font-size:16px;\">".$value['price']."<span style=\"font-size:9px;\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_credits')."</span></strong>";
                                        $price=$value['price'];
                                        $curency=OW::getLanguage()->text('shoppro', 'product_credits');
                                        $price_block_display="block";
                                    }else{//----------------------------------------------------------------------------------------------shop
//                                        $products .="<strong style=\"font-size:16px;\">".$value['price']."<span style=\"font-size:9px;\">&nbsp;".$value['curency']."</span></strong>";
                                        $price=$value['price'];
                                        $curency=$value['curency'];
                                        $price_block_display="block";
                                    }
                                }else if ((!$value['price'] OR $value['price']==0) AND !$value['has_options']){//--------------------------freee
//                                    $products .="<b ><i>".OW::getLanguage()->text('shoppro', 'product_table_product_free_ads')."</i></b>";
                                    $price="<i>".OW::getLanguage()->text('shoppro', 'product_table_product_free_ads')."</i>";
//                                    $price_block_display="none";
                                        $price_block_display="block";
                                }else if ($value['has_options']){//------------------------------------------------------------------------options
//                                    $price=$this->get_one_paymentoption($product_id=0,$type="smaller")
                                    $item_options=$this->get_one_paymentoption($product_id,"smaller");
                                    if ($item_options['id']>0){
                                        $price=OW::getLanguage()->text('shoppro', 'from').": ".$item_options['price'];
                                        $curency=$item_options['currence'];
                                        $price_block_display="block";
                                    }else{//---not found options
                                        $price_block_display="none";
                                    }
                                }

        }else if ($type=="credits"){
            if ($value['price']>0){
                $price=$value['price'];
//                $curency="credits";
                $curency=OW::getLanguage()->text('shoppro', 'product_credits');
                $price_block_display="block";
            }
        }else{


            if ($value['price']>0){
//                $products .="<div id=\"product_price_".$value['id']."\"  class=\"ow_alt\" clearfix\" style=\"text-align:center;font-size:14px;margin:0px;margin-top:20px;\">";
//                $products .= "<strong style=\"font-size:16px;\">".$value['price']."<span style=\"font-size:9px;\">&nbsp;".$value['curency']."</span></strong>";
//                $products .="</div>";
                $price=$value['price'];
                $curency=$value['curency'];
                $price_block_display="block";
            }
//            }else{//-----multiple
//                $price=100;
//                $curency="qqq";
//                $price_block_display="block";
//            }
        }
/*
        if (OW::getConfig()->getValue('shoppro', 'show_quty_inproduct')){
            $products .="<br/>&nbsp;";
            $products .="(".$value['items']." ".OW::getLanguage()->text('shoppro', 'short_qty').")";
        }
*/
//----------------------
        $products .="<li class=\"thumbnail\" style=\"width:".$width_thumbal."%;\" id=\"product_".$product_id."\" itemprop=\"itemListElement\" itemscope=\"\" itemtype=\"http://schema.org/Product\">";
//$products .=$type;

            $products .="<div class=\"js-thumbnail thumbnail-preview\" data-tid=\"".$product_id."\" style=\"height:".$height_thumbal."px;border-color:".$border_cool_thumbal.";".$border_cool_thumbal_add.";\">
                <span class=\"img-placeholder\"></span>
                <a class=\"thumb_preview js-thumb_preview\" href=\"".$curent_url."product/".$product_id."/zoom/".$seo_title.".html\" data-tid=\"".$product_id."\">
                    <img class=\"js-thumbnail-img\" alt=\"".stripslashes($value['name'])."\" alt=\"".stripslashes($value['name'])."\" itemprop=\"image\" src=\"".$product_image_url."\">
                </a>
            </div>";

            $products .="<div class=\"template-data js-template-data\">

                <div class=\"thumbnail-info clearfix\" style=\"border-color:".$border_cool_thumbal.";".$border_cool_thumbal_add.";background-color:".$background_cool_thumbal.";\">
                    <div class=\"thumbnail-arrow\" style=\"border-bottom-color:".$border_cool_thumbal.";border-bottom-color:".$border_cool_thumbal.";\"></div>
                    <div class=\"price-block discount\" style=\"display:".$price_block_display.";\" itemprop=\"offers\" itemscope=\"\" itemtype=\"http://schema.org/Offer\">
                        <div class=\"template-price js-template-price\" style=\"background-color:".$background_ptica_color.";\" data-price=\"".$price."\" data-tid=\"".$product_id."\" itemprop=\"price\">
                            ".$price." <span class=\"dollar-icon\">".$curency."</span>
                        </div>
                        <div class=\"price-corner-right\"></div>
                        <div class=\"price-corner-left\">
                            <svg version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" width=\"10px\" height=\"27px\">
                                <polygon fill=\"".$background_ptica_color."\" points=\"0,13 8,0 10,0 10,27 8,27 \"></polygon>
                            </svg>
                        </div>
                    </div>";


    $products .="<div class=\"clearfix thumbnail-description\" style=\"height:".$height_thumbal_content."px;\">";

//                    $products .="<b class=\"svg square-icon icon-osc\" style=\"background-image: url(data:image/svg+xml;utf-8,%3Csvg%3Asvg%20xmlns%3Asvg%3D%22http%3A//www.w3.org/2000/svg%22%20class%3D%22i%22%20id%3D%22oscommerce%22%20viewBox%3D%220%200%20100%20100%22%20width%3D%22100%22%20height%3D%22100%22%3E%0A%09%3Cpath%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20fill%3D%22%23FFFFFF%22%20stroke%3D%22%23C4C4C4%22%20d%3D%22M22.8%2C9.999h54.399c7.068%2C0%2C12.801%2C5.732%2C12.801%2C12.8v54.4c0%2C7.066-5.73%2C12.8-12.801%2C12.8%20%20%20H22.8c-7.07%2C0-12.801-5.731-12.801-12.8v-54.4C10%2C15.731%2C15.73%2C9.999%2C22.8%2C9.999z%22/%3E%0A%09%3Cg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cpath%20fill%3D%22%233FA500%22%20d%3D%22M59.486%2C50.091c-1.793-3.81-5.149-7.184-8.889-8.924c-1.625-0.748-4.042-1.409-5.58-1.513%20%20%20%20c-0.712-0.053-1.495-0.104-1.738-0.14c-0.243-0.018-1.184%2C0.018-2.088%2C0.087c-7.723%2C0.626-14.438%2C6.628-16.021%2C14.333%20%20%20%20c-0.435%2C2.105-0.435%2C5.375%2C0%2C7.48c1.461%2C7.098%2C7.185%2C12.716%2C14.299%2C14.09c1.705%2C0.33%2C5.045%2C0.365%2C6.61%2C0.087%20%20%20%20c1.444-0.261%2C3.688-0.974%2C4.771-1.513c2.646-1.322%2C5.604-3.896%2C7.223-6.297C61.557%2C62.598%2C62.111%2C55.71%2C59.486%2C50.091z%22/%3E%3Cpath%20fill%3D%22%23D11B1E%22%20d%3D%22M43.495%2C37.017c3.036-3.947%2C7.632-6.632%2C12.657-7.039c0.904-0.07%2C1.844-0.105%2C2.088-0.088%20%20%20%20c0.242%2C0.035%2C1.025%2C0.088%2C1.738%2C0.141c0.021%2C0.001%2C0.041%2C0.004%2C0.062%2C0.005c-1.345-3.89-4.888-7.205-9.108-8.542%20%20%20%20c-1.354-0.418-4.924-0.627-6.385-0.348c-5.166%2C0.939-9.603%2C5.062-10.941%2C10.193c-0.487%2C1.931-0.487%2C5.01%2C0.018%2C6.924%20%20%20%20c0.142%2C0.517%2C0.298%2C1.033%2C0.412%2C1.373c2.371-1.406%2C5.045-2.303%2C7.844-2.529C42.462%2C37.062%2C43.06%2C37.03%2C43.495%2C37.017z%22/%3E%3Cpath%20fill%3D%22%230D3C8F%22%20d%3D%22M60.113%2C65.631l0.625-1.311c2.313-4.85%2C2.367-10.586%2C0.145-15.341c-1.767-3.756-5.148-7.152-8.824-8.862%20%20%20%20c-1.597-0.737-4.009-1.396-5.491-1.497l-2.225-0.161l0.968-1.059c0.135-0.147%2C0.278-0.302%2C0.429-0.458%20%20%20%20c2.637-2.761%2C5.825-4.465%2C9.475-5.063c0.758-0.129%2C1.617-0.194%2C2.547-0.194c2.326%2C0%2C4.781%2C0.416%2C6.406%2C1.086%20%20%20%20c6.333%2C2.608%2C10.379%2C8.164%2C10.822%2C14.861c0.441%2C6.752-3.413%2C13.302-9.596%2C16.296c-1.09%2C0.53-2.881%2C1.139-3.869%2C1.37L60.113%2C65.631%20%20%20%20L60.113%2C65.631z%22/%3E%3Cpath%20fill%3D%22%230D3C8F%22%20d%3D%22M47.346%2C37.304c1.619%2C0.223%2C3.767%2C0.844%2C5.296%2C1.551c4.021%2C1.87%2C7.563%2C5.434%2C9.5%2C9.533%20%20%20%20c2.188%2C4.686%2C2.334%2C10.244%2C0.438%2C15.15c0.771-0.256%2C1.604-0.575%2C2.195-0.863c5.683-2.75%2C9.224-8.759%2C8.813-14.951%20%20%20%20c-0.404-6.156-4.133-11.265-9.964-13.666c-1.472-0.605-3.722-0.982-5.877-0.982c-0.854%2C0-1.634%2C0.059-2.313%2C0.176%20%20%20%20C52.366%2C33.757%2C49.646%2C35.119%2C47.346%2C37.304L47.346%2C37.304z%22/%3E%3C/g%3E%0A%3C/svg%3Asvg%3E);\"></b>";
                    $products .="<a class=\"link-blue\" href=\"".$curent_url."product/".$product_id."/zoom/".$seo_title.".html\" itemprop=\"name\">".$product_name."</a>";




    //---buttons
    $products .="<div class=\"clearfix\" style=\"position: absolute;bottom: 40px;width: 100%;\">";
        $products .=$this->create_button($value,$type,$uurl);
    $products .="</div>";




                    $products .="<br/>";
//                    $products .="osCommerce";

//                    $products .="<span class=\"template-number\">#".$product_number."</span>";

/*
                    $products .="<div class=\"rating-stars-block\">
                        <div class=\"stars rating-style_0\"></div>
                    </div>";
*/
//---------111



                        $products .="<div class=\"clearfix addinfo-block-first ow_smallmargin\">";

                                    if (!OW::getConfig()->getValue('shoppro', 'hide_product_small_details')){

                                        if (OW::getConfig()->getValue('shoppro', 'turn_on_ciew_couter')==1 OR (OW::getConfig()->getValue('shoppro', 'turn_on_ciew_couter')==2 AND (($value['id_owner']==$id_user AND $id_user>0) OR $is_admin))  ){
//                                            if (OW::getConfig()->getValue('shoppro', 'hide_seller_avatar_onthelist') && !OW::getConfig()->getValue('shoppro', 'hide_seller_small_icon')){
//                                                $products .=", ";   
//                                            }
                                            $products .="<i class=\"ow_remark\">".OW::getLanguage()->text('shoppro', 'count_view').":</i>&nbsp;";
                                            $products .="<b>".$value['count_view']."</b>";
                            
                                        }
/*
                                        if ($value['condition']>0){
                                            if ((OW::getConfig()->getValue('shoppro', 'hide_seller_avatar_onthelist') && !OW::getConfig()->getValue('shoppro', 'hide_seller_small_icon')) OR (OW::getConfig()->getValue('shoppro', 'turn_on_ciew_couter')==1 OR (OW::getConfig()->getValue('shoppro', 'turn_on_ciew_couter')==2 AND $value['id_owner']==$id_user AND $id_user>0))  ){
                                                $products .=", ";   
                                            }

                                            $products .="<i>".OW::getLanguage()->text('shoppro', 'product_condition')."</i>:&nbsp;";
                                            if ($value['condition']==0){
                                                $products .="<b>".OW::getLanguage()->text('shoppro', 'product_condition_na')."</b>";
                                            }else if ($value['condition']==1){
                                                $products .="<b>".OW::getLanguage()->text('shoppro', 'product_condition_new')."</b>";
                                            }else if ($value['condition']==2){
                                                $products .="<b>".OW::getLanguage()->text('shoppro', 'product_condition_used')."</b>";
                                            }
                                        }
*/
/*
                                        if ($value['type_ads']==0){
                                            if ($value['classifieds_type']==1){
                                                if ($value['location'] OR $value['condition']>0) $products .=", ";
                                                $products .="<i>".OW::getLanguage()->text('shoppro', 'product_type_classifieds')."</i>: ";
                                                $products .="<b>".OW::getLanguage()->text('shoppro', 'product_available')."</b>";
                                            }else if ($value['classifieds_type']==2){
                                                if ($value['location'] OR $value['condition']) $products .=", ";
                                                $products .="<i>".OW::getLanguage()->text('shoppro', 'product_type_classifieds')."</i>:&nbsp;";
                                                $products .="<b>".OW::getLanguage()->text('shoppro', 'product_wanted')."</b>";
                                            }
                                        }
*/
/*
                                        if ($value['location']){
                                            if ($value['classifieds_type'] OR $value['condition']>0) $products .=", ";
                                            $products .="<i>".OW::getLanguage()->text('shoppro', 'product_location')."</i>:&nbsp;";
                                            $loc=str_replace("'","",stripslashes($value['location']));
                                            $loc=str_replace("\r\n","",$loc);
                                            $loc=str_replace("\r","",$loc);
                                            $loc=str_replace("\n","",$loc);
                                            $loc=str_replace("\t","",$loc);
                                            $loc=str_replace(" ","+",$loc);
                                            $products .="<b><a href=\"https://maps.google.com/maps?tab=wl&q=".$loc."\" target=\"_blank\">".mb_substr(stripslashes($value['location']),0,20)."</a></b>";
                                        }
                                        if ($value['map_lat']!="" AND $value['map_lan']){
                                            $products .=", <i>".OW::getLanguage()->text('shoppro', 'map')."</i>:&nbsp;";
                                            $loc=$value['map_lat'].",".$value['map_lan'];
                                            $products .="<b><a href=\"http://maps.google.com/maps?tab=wl&q=".$loc."\" target=\"_blank\">".OW::getLanguage()->text('shoppro', 'show_location')."</a></b>";
                                        }
*/
                                    }else{//if (!OW::getConfig()->getValue('shoppro', 'hide_product_small_details')){
                                        if (OW::getConfig()->getValue('shoppro', 'turn_on_ciew_couter')==1 OR (OW::getConfig()->getValue('shoppro', 'turn_on_ciew_couter')==2 AND (($value['id_owner']==$id_user AND $id_user>0) OR $is_admin))  ){
                                            $products .="<i>".OW::getLanguage()->text('shoppro', 'count_view')."</i>:&nbsp;";
                                            $products .="<b>".$value['count_view']."</b>";
                                        }
                                    }


                        $products .="</div>";

//---------22
//                    if (OW::getConfig()->getValue('shoppro', 'hide_seller_avatar_onthelist') && !OW::getConfig()->getValue('shoppro', 'hide_seller_small_icon')){
                        $products .="<div class=\"clearfix addinfo-block ow_smallmargin\">";
                        $products .="<img border=\"0\" style=\"vertical-align:text-bottom;\" src=\"".$pluginStaticURL2."user.png\">&nbsp;".$dname;
                        $products .="</div>";
//                    }


                    $products .="<div class=\"rating-stars-block ow_right ow_remark\">
                        #".$product_number."
                    </div>";


    $products .="</div>";



                $products .="</div>";

//----------details start
/*
                $products .="<div class=\"thumbnail-data\">
                    <table>
                    <tbody>
                    <tr>
                        <td>Item number:</td>
                        <td class=\"template-number\">#47089</td>
                    </tr>
                    <tr>
                        <td>Author:</td>
                        <td>
                            <a href=\"/authors/delta/\" class=\"link-blue\" onclick=\"_gaq.push(['b._trackEvent', 'products', 'click', 'author']);\">Delta</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Downloads:</td>
                        <td class=\"template-count\">1</td>
                    </tr>
                    <tr>
                        <td>Rating:</td>
                        <td class=\"template-rating\">
                            <div class=\"rating-stars-block\">
                                <div class=\"stars rating-style_0\"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td itemprop=\"description\">The template was developed specifically for book, newspaper and magazine stores.</td>
                    </tr>
                    </tbody>
                    </table>
                    <div class=\"list-view-btn js-live-buttons\">
                        <a href=\"/demo/47089.html\" class=\"btn btn-primary\" target=\"_blank\">live Demo<span class=\"icon-pop-out\"></span></a>
                        <a href=\"/oscommerce-templates/47089.html\" class=\"btn btn-default\">view details</a>
                    </div>
                </div>";


            $products .="</div>";
*/
//----------details end

            $products .="<div class=\"clearfix\"></div>";

        $products .="</li>";

        return $products;
    }








    //----------------------------------------------------buttons
    public function create_button($value=array(),$type="shop",$uurl="")
    {
        $curent_url=OW_URL_HOME;
        $is_user = OW::getUser()->getId();
        $id_user =$is_user;
        $is_admin = OW::getUser()->isAdmin();
        $products ="";
//echo $type."|";

//                                $dname=BOL_UserService::getInstance()->getDisplayName($value['id_owner']);
                                $uurl=BOL_UserService::getInstance()->getUserUrl($value['id_owner']);
//                                $uimg=BOL_AvatarService::getInstance()->getAvatarUrl($value['id_owner']);
        
        //-----------------------------------------------------------------------------credits START
        if ($type=="credits"){
                                if ($value['active']==-1){
//                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
//                                    $products .=OW::getLanguage()->text('shoppro', 'product_table_deleted');
//                                    $products .="</div>";
                                }else if ($value['active']!=1){
//                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
//                                    $products .=OW::getLanguage()->text('shoppro', 'product_table_moderation');
//                                    $products .="</div>";
                                }else if (!$id_user OR $value['id_owner']!=$id_user){
//---pop tart 1
                                    if (!SHOPPRO_BOL_Service::getInstance()->is_cart()){

                                        $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window2(
                                        "",
                                        $curent_url."baynowcredits/".$value['id']."_".substr(session_id(),7,6),
                                        "button",
                                        "center",
                                        "cart",
                                        OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits'),
                                        OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits'),
                                        OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information'),
                                        OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description'),
                                        OW::getLanguage()->text('shoppro', 'product_table_bayusingcreditspay'),
                                        "button",
                                        SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                                        ,$value['has_options'],$value['id']
                                        );
                                    }else{
                                        if (SHOPPRO_BOL_Service::getInstance()->is_cart()){
                                            $products .=SHOPPRO_BOL_Service::getInstance()->make_acccartbutton2(
                                                $value['id'],$value['id_owner'],$value['name'],$value['description'],1,$value['price'],$value['curency'],'credit',$value['has_options'],$value['id']
                                            );
                                        }
                                    }//else
//---pop end 2
                                }else{
//                                    $products .="<div class=\"ow_center\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits')."</div>";
//            $products .="<div class=\"clearfix ow_submit ow_smallmargin\">
            $products .="<div class=\"clearfix\">
                <div class=\"ow_center\">
<a href=\"".$curent_url."product/".$value['id']."/zoom/index.html\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"submit\" name=\"dosave\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_open_product')."\" class=\"ow_ic_lens ow_positive\">
                        </span>
                    </span>
</a>
                </div>
            </div>";
                                }
        //-----------------------------------------------------------------------------shop
        }else if ($type=="shop"){
                                if ($value['active']==-1){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
                                    $products .=OW::getLanguage()->text('shoppro', 'product_table_deleted');
                                    $products .="</div>";
                                }else if ($value['active']!=1){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
                                    $products .=OW::getLanguage()->text('shoppro', 'product_table_moderation');
                                    $products .="</div>";
                                }else if (!$id_user OR $value['id_owner']!=$id_user){
//---pop tart 2
                                    if (!SHOPPRO_BOL_Service::getInstance()->is_cart()){

                                        $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window2(
                                        "",
                                        $curent_url."baynow/".$value['id'],
                                        "button",
                                        "center",
                                        "cart",
                                        OW::getLanguage()->text('shoppro', 'product_table_baynow'),
                                        OW::getLanguage()->text('shoppro', 'product_table_baynow'),
                                        OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information'),
                                        OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description'),
                                        OW::getLanguage()->text('shoppro', 'product_table_baynow'),
                                        "button",
                                        SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                                        ,$value['has_options'],$value['id']
                                        );
                                    }else{
                                        if (SHOPPRO_BOL_Service::getInstance()->is_cart()){
                                            $products .=SHOPPRO_BOL_Service::getInstance()->make_acccartbutton2(
                                                $value['id'],$value['id_owner'],$value['name'],$value['description'],1,$value['price'],$value['curency'],'shop',$value['has_options'],$value['id']
                                            );
                                        }
                                    }//else

                                }else{//your product
//                                    $products .="<div class=\"ow_center\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_table_add_type_shop')."</div>";
//                                    $products .="<div class=\"clearfix ow_submit ow_smallmargin\">";
                                    $products .="<div class=\"clearfix\">";
                                    $products .="<div class=\"ow_center\">
                                        <span class=\"ow_button\">
                                            <span class=\" ow_positiveX ow_negative\">
                                                <input disabled type=\"button\" name=\"dosavexx\" value=\"".OW::getLanguage()->text('shoppro', 'its_your_product')."\" class=\"ow_ic_info ow_positive\">
                                            </span>
                                        </span>
                                    </div>";
                                    $products .="</div>";
                                }
        //-----------------------------------------------------------------------------free
        }else if ($type=="free"){

//---pop start 3
                                if (!$id_user OR $value['id_owner']!=$id_user){

                                    if (strlen($value['file_attach'])>3){//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------file download

                                        $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window2(
                                        "",
                                        $curent_url."baynow/".$value['id']."_".substr(session_id(),7,6),
                                        "button",
                                        "center",
                                        "cart",
                                        OW::getLanguage()->text('shoppro', 'product_table_baynow'),
                                        OW::getLanguage()->text('shoppro', 'product_table_baynow'),
                                        OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information'),
                                        OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description'),
                                        OW::getLanguage()->text('shoppro', 'confirm_buyaction'),
                                        "button",
                                        SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                                        ,$value['has_options'],$value['id']
                                        );

                                    }else if (SHOPPRO_BOL_Service::getInstance()->is_cart()){
                                        if ($value['has_options']){
                                            $products .=SHOPPRO_BOL_Service::getInstance()->make_acccartbutton2(
                                                $value['id'],$value['id_owner'],$value['name'],$value['description'],1,$value['price'],$value['curency'],'clasifid',$value['has_options'],$value['id']
                                            );
                                        }else{
//----send question s IN CART - duplocate in without cart
//                                            $products .=SHOPPRO_BOL_Service::getInstance()->make_inqiure_button($value['id']);
//----send question e
            $products .="<div class=\"clearfix\">
                <div class=\"ow_center\">
<a href=\"".$curent_url."product/".$value['id']."/zoom/index.html\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"submit\" name=\"dosave\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_open_product')."\" class=\"ow_ic_lens ow_positive\">
                        </span>
                    </span>
</a>
                </div>
            </div>";
                                        }
//exit;
                                    }else{//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------contact to seler
//exit;
                                        if ($value['has_options']){
                                            if (!$value['seler_account']){

                                                $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window2(
                                                "",
                                                $uurl,
                                                "button",
                                                "center",
                                                "mail",
                                                OW::getLanguage()->text('shoppro', 'product_classifiedss'),
                                                OW::getLanguage()->text('shoppro', 'product_classifiedss'),
                                                OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information_mail'),
                                                OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description_mail'),
                                                OW::getLanguage()->text('shoppro', 'product_table_contactseler'),
                                                "button",
                                                SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                                                ,$value['has_options'],$value['id']
                                                );
                                            }else{//-------------------------------------------has options
/*
                                                $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window2(
                                                "",
                                                $curent_url."baynow/".$value['id']."_".substr(session_id(),7,6),
                                                "button",
                                                "center",
                                                "cart",
                                                OW::getLanguage()->text('shoppro', 'product_table_open_product'),
                                                OW::getLanguage()->text('shoppro', 'product_table_open_product'),
                                                OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information'),
                                                OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description'),
                                                OW::getLanguage()->text('shoppro', 'confirm_buyaction'),
                                                "button",
                                                SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                                                ,$value['has_options'],$value['id']
                                                );
*/
//            $products .="<div class=\"clearfix ow_submit ow_smallmargin\">
            $products .="<div class=\"clearfix\">
                <div class=\"ow_center\">
<a href=\"".$curent_url."product/".$value['id']."/zoom/index.html\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"submit\" name=\"dosave\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_open_product')."\" class=\"ow_ic_lens ow_positive\">
                        </span>
                    </span>
</a>
                </div>
            </div>";


                                            }//if is email

                                        }else{

                                            $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window2(
                                            "",
                                            $uurl,
                                            "button",
                                            "center",
                                            "mail",
                                            OW::getLanguage()->text('shoppro', 'product_classifiedss'),
                                            OW::getLanguage()->text('shoppro', 'product_classifiedss'),
                                            OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information_mail'),
                                            OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description_mail'),
                                            OW::getLanguage()->text('shoppro', 'product_table_contactseler'),
                                            "button",
                                            SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                                            ,$value['has_options'],$value['id']
                                            );
                                        }
                                    }//---------------------------------------------------------------------------------------------------------------------------------else end

//---pop end 3
                                }else{

//                                    $products .="<div class=\"ow_center\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_table_add_type_classified')."</div>";
//            $products .="<div class=\"clearfix ow_submit ow_smallmargin\">
            $products .="<div class=\"clearfix\">
                <div class=\"ow_center\">
<a href=\"".$curent_url."product/".$value['id']."/zoom/index.html\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"submit\" name=\"dosave\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_open_product')."\" class=\"ow_ic_lens ow_positive\">
                        </span>
                    </span>
</a>
                </div>
            </div>";
                                }


        //-----------------------------------------------------------------------------classifieds
        }else if ($type=="classified"){


            if (!$id_user OR $value['id_owner']!=$id_user){


                if (!SHOPPRO_BOL_Service::getInstance()->is_cart()){

                    $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window2(
                    "",
                    $uurl,
                    "button",
                    "center",
                    "mail",
                    OW::getLanguage()->text('shoppro', 'product_classifiedss'),
                    OW::getLanguage()->text('shoppro', 'product_classifiedss'),
                    OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information_mail'),
                    OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description_mail'),
                    OW::getLanguage()->text('shoppro', 'product_table_contactseler'),
                    "button",
                    SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                    ,$value['has_options'],$value['id']
                    );
    
                }else{
                    if (SHOPPRO_BOL_Service::getInstance()->is_cart()){
                        $products .=SHOPPRO_BOL_Service::getInstance()->make_acccartbutton2(
                            $value['id'],$value['id_owner'],$value['name'],$value['description'],1,$value['price'],$value['curency'],'clasifid',$value['has_options'],$value['id']
                        );
                    }
                }//else
            }else{
//                $products .="<div class=\"ow_center\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_table_add_type_classified')."</div>";
//            $products .="<div class=\"clearfix ow_submit ow_smallmargin\">
            $products .="<div class=\"clearfix\">
                <div class=\"ow_center\">
<a href=\"".$curent_url."product/".$value['id']."/zoom/index.html\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"submit\" name=\"dosave\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_open_product')."\" class=\"ow_ic_lens ow_positive\">
                        </span>
                    </span>
</a>
                </div>
            </div>";
            }

        }



        //-----------------------------------------------------------------------------END

        return $products;
    }







    //------------------------------------------------------------credits
    public function thene_credits($value=array())
    {
        
        $curent_url=OW_URL_HOME;
        $is_user = OW::getUser()->getId();
        $id_user =$is_user;
        $is_admin = OW::getUser()->isAdmin();
        $products ="";


//                                $dname=BOL_UserService::getInstance()->getDisplayName($value['id_owner']);
                                $uurl=BOL_UserService::getInstance()->getUserUrl($value['id_owner']);
//                                $uimg=BOL_AvatarService::getInstance()->getAvatarUrl($value['id_owner']);


                                $products .="<div id=\"product_price_".$value['id']."\" class=\"ow_alt\" clearfix\" style=\"width:100%;float:right;text-align:center;font-size:14px;display:block;margin:0px;margin-top:20px;\">";
                                $products .= "<strong style=\"font-size:16px;\">".$value['price']."<span style=\"font-size:9px;\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_credits')."</span></strong>";

                                if (OW::getConfig()->getValue('shoppro', 'show_quty_inproduct')){
                                    $products .="<br/>&nbsp;";
                                    $products .="(".$value['items']." ".OW::getLanguage()->text('shoppro', 'short_qty').")";
                                }

                                $products .="</div>";
                                $products .="<br/>&nbsp;";

                                if ($value['active']==-1){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
                                    $products .=OW::getLanguage()->text('shoppro', 'product_table_deleted');
                                    $products .="</div>";
                                }else if ($value['active']!=1){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
                                    $products .=OW::getLanguage()->text('shoppro', 'product_table_moderation');
                                    $products .="</div>";
                                }else if (!$id_user OR $value['id_owner']!=$id_user){
//---pop tart 1
                                    if (!SHOPPRO_BOL_Service::getInstance()->is_cart()){

                                        $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window(
                                        "",
                                        $curent_url."baynowcredits/".$value['id']."_".substr(session_id(),7,6),
                                        "button",
                                        "center",
                                        "cart",
                                        OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits'),
                                        OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits'),
                                        OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information'),
                                        OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description'),
                                        OW::getLanguage()->text('shoppro', 'product_table_bayusingcreditspay'),
                                        "button",
                                        SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                                        ,$value['has_options'],$value['id']
                                        );
                                    }else{
                                        if (SHOPPRO_BOL_Service::getInstance()->is_cart()){
                                            $products .=SHOPPRO_BOL_Service::getInstance()->make_acccartbutton(
                                                $value['id'],$value['id_owner'],$value['name'],$value['description'],1,$value['price'],$value['curency'],'credit',$value['has_options'],$value['id']
                                            );
                                        }
                                    }//else
//---pop end 2
                                }else{
                                    $products .="<div class=\"ow_center\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits')."</div>";
                                }
        return $products;
    }

    //------------------------------------------------------------shop
    public function thene_shop($value=array())
    {
        
        $curent_url=OW_URL_HOME;
        $is_user = OW::getUser()->getId();
        $id_user =$is_user;
        $is_admin = OW::getUser()->isAdmin();
        $products ="";


//                                $dname=BOL_UserService::getInstance()->getDisplayName($value['id_owner']);
                                $uurl=BOL_UserService::getInstance()->getUserUrl($value['id_owner']);
//                                $uimg=BOL_AvatarService::getInstance()->getAvatarUrl($value['id_owner']);


                            if ($value['has_options']!=1){
                                $products .="<div  id=\"product_price_".$value['id']."\" class=\"ow_alt\" clearfix\" style=\"width:100%;float:right;text-align:center;display:block;margin:0px;margin-top:20px;\">";
                                    $products .="<strong style=\"font-size:16px;\">".$value['price']."<span style=\"font-size:9px;\">&nbsp;".$value['curency']."</span></strong>";
                                $products .="</div>";

                                if (OW::getConfig()->getValue('shoppro', 'show_quty_inproduct')){
                                    $products .="<br/>&nbsp;";
                                    $products .="(".$value['items']." ".OW::getLanguage()->text('shoppro', 'short_qty').")";
                                }
                                $products .="<br/>&nbsp;";
                            }

                                if ($value['active']==-1){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
                                    $products .=OW::getLanguage()->text('shoppro', 'product_table_deleted');
                                    $products .="</div>";
                                }else if ($value['active']!=1){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
                                    $products .=OW::getLanguage()->text('shoppro', 'product_table_moderation');
                                    $products .="</div>";
                                }else if (!$id_user OR $value['id_owner']!=$id_user){

//---pop tart 2
                                    if (!SHOPPRO_BOL_Service::getInstance()->is_cart()){

                                        $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window(
                                        "",
                                        $curent_url."baynow/".$value['id'],
                                        "button",
                                        "center",
                                        "cart",
                                        OW::getLanguage()->text('shoppro', 'product_table_baynow'),
                                        OW::getLanguage()->text('shoppro', 'product_table_baynow'),
                                        OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information'),
                                        OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description'),
                                        OW::getLanguage()->text('shoppro', 'product_table_baynow'),
                                        "button",
                                        SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                                        ,$value['has_options'],$value['id']
                                        );
                                    }else{
                                        if (SHOPPRO_BOL_Service::getInstance()->is_cart()){
                                            $products .=SHOPPRO_BOL_Service::getInstance()->make_acccartbutton(
                                                $value['id'],$value['id_owner'],$value['name'],$value['description'],1,$value['price'],$value['curency'],'shop',$value['has_options'],$value['id']
                                            );
                                        }
                                    }//else

                                }else{
                                    $products .="<div class=\"ow_center\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_table_add_type_shop')."</div>";
                                }

        return $products;
    }


    //------------------------------------------------------------free
    public function thene_free($value=array())
    {
        
        $curent_url=OW_URL_HOME;
        $is_user = OW::getUser()->getId();
        $id_user =$is_user;
        $is_admin = OW::getUser()->isAdmin();
        $products ="";

//                                $dname=BOL_UserService::getInstance()->getDisplayName($value['id_owner']);
                                $uurl=BOL_UserService::getInstance()->getUserUrl($value['id_owner']);
//                                $uimg=BOL_AvatarService::getInstance()->getAvatarUrl($value['id_owner']);


                                $products .="<div  id=\"product_price_".$value['id']."\" class=\"ow_alt\" clearfix\" style=\"width:100%;float:right;text-align:center;display:block;margin:0px;margin-top:20px;\">";

                                if ($value['price']>0 AND !$value['has_options']){
                                    if ($value['type_ads']==2){
                                        $products .="<strong style=\"font-size:16px;\">".$value['price']."<span style=\"font-size:9px;\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_credits')."</span></strong>";
                                    }else{
                                        $products .="<strong style=\"font-size:16px;\">".$value['price']."<span style=\"font-size:9px;\">&nbsp;".$value['curency']."</span></strong>";
                                    }
                                }else if ((!$value['price'] OR $value['price']==0) AND !$value['has_options']){
                                    $products .="<b ><i>".OW::getLanguage()->text('shoppro', 'product_table_product_free_ads')."</i></b>";
                                }

                                $products .="</div>";
                                $products .="<br/>&nbsp;";

//---pop start 3
                                if (!$id_user OR $value['id_owner']!=$id_user){

                                    if (strlen($value['file_attach'])>3){//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------file download

                                        $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window(
                                        "",
                                        $curent_url."baynow/".$value['id']."_".substr(session_id(),7,6),
                                        "button",
                                        "center",
                                        "cart",
                                        OW::getLanguage()->text('shoppro', 'product_table_baynow'),
                                        OW::getLanguage()->text('shoppro', 'product_table_baynow'),
                                        OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information'),
                                        OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description'),
                                        OW::getLanguage()->text('shoppro', 'confirm_buyaction'),
                                        "button",
                                        SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                                        ,$value['has_options'],$value['id']
                                        );

                                    }else if (SHOPPRO_BOL_Service::getInstance()->is_cart()){
                                        if ($value['has_options']){
                                            $products .=SHOPPRO_BOL_Service::getInstance()->make_acccartbutton(
                                            $value['id'],$value['id_owner'],$value['name'],$value['description'],1,$value['price'],$value['curency'],'clasifid',$value['has_options'],$value['id']
                                            );
                                        }else{
//----send question s IN CART - duplocate in without cart
                                            $products .=SHOPPRO_BOL_Service::getInstance()->make_inqiure_button($value['id']);
//----send question e
                                        }
                                    }else{//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------contact to seler

                                        if ($value['has_options']){

                                            if (!$value['seler_account']){
                                                $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window(
                                                "",
                                                $uurl,
                                                "button",
                                                "center",
                                                "mail",
                                                OW::getLanguage()->text('shoppro', 'product_classifiedss'),
                                                OW::getLanguage()->text('shoppro', 'product_classifiedss'),
                                                OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information_mail'),
                                                OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description_mail'),
                                                OW::getLanguage()->text('shoppro', 'product_table_contactseler'),
                                                "button",
                                                SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                                                ,$value['has_options'],$value['id']
                                                );
                                            }else{
                                                $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window(
                                                "",
                                                $curent_url."baynow/".$value['id']."_".substr(session_id(),7,6),
                                                "button",
                                                "center",
                                                "cart",
                                                OW::getLanguage()->text('shoppro', 'product_table_baynow'),
                                                OW::getLanguage()->text('shoppro', 'product_table_baynow'),
                                                OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information'),
                                                OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description'),
                                                OW::getLanguage()->text('shoppro', 'confirm_buyaction'),
                                                "button",
                                                SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                                                ,$value['has_options'],$value['id']
                                                );
                                            }//if is email
                                        }else{
                                            $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window(
                                            "",
                                            $uurl,
                                            "button",
                                            "center",
                                            "mail",
                                            OW::getLanguage()->text('shoppro', 'product_classifiedss'),
                                            OW::getLanguage()->text('shoppro', 'product_classifiedss'),
                                            OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information_mail'),
                                            OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description_mail'),
                                            OW::getLanguage()->text('shoppro', 'product_table_contactseler'),
                                            "button",
                                            SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                                            ,$value['has_options'],$value['id']
                                            );
                                        }
                                    }//---------------------------------------------------------------------------------------------------------------------------------else end

//---pop end 3
                                }else{
                                    $products .="<div class=\"ow_center\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_table_add_type_classified')."</div>";
                                }



        return $products;
    }

    //----------------------------------------------------------clasiffied
    public function thene_classifieds($value=array())
    {
        
        $curent_url=OW_URL_HOME;
        $is_user = OW::getUser()->getId();
        $id_user =$is_user;
        $is_admin = OW::getUser()->isAdmin();
        $products ="";

//                                $dname=BOL_UserService::getInstance()->getDisplayName($value['id_owner']);
                                $uurl=BOL_UserService::getInstance()->getUserUrl($value['id_owner']);
//                                $uimg=BOL_AvatarService::getInstance()->getAvatarUrl($value['id_owner']);

/*                                $product_path=$pluginStaticDir;
//                                $product_image="ow_userfiles/plugins/shoppro/images/product_".$value['id'].".jpg";
                                $product_image="product_".$value['id'].".jpg";
                                if (is_file($product_path."images/".$product_image)){
//                                    $product_image=$curent_url.$product_image;
                                    $product_image_url=$pluginStaticURL."images/".$product_image;
                                    $product_image=true;
                                }else{
//                                    $product_image=$curent_url."ow_userfiles/plugins/shoppro/noimage.jpg";
                                    $product_image="";
                                    $product_image_url="";
                                }

                                $seo_title=stripslashes($value['name']);
                                $seo_title=$this->make_seo_url($seo_title,100);

*/

        if ($value['price']>0){
                $products .="<div id=\"product_price_".$value['id']."\"  class=\"ow_alt\" clearfix\" style=\"text-align:center;font-size:14px;margin:0px;margin-top:20px;\">";
                $products .= "<strong style=\"font-size:16px;\">".$value['price']."<span style=\"font-size:9px;\">&nbsp;".$value['curency']."</span></strong>";
                $products .="</div>";
        }

        if (!$id_user OR $value['id_owner']!=$id_user){


            if (!SHOPPRO_BOL_Service::getInstance()->is_cart()){

                $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window(
                "",
                $uurl,
                "button",
                "center",
                "mail",
                OW::getLanguage()->text('shoppro', 'product_classifiedss'),
                OW::getLanguage()->text('shoppro', 'product_classifiedss'),
                OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information_mail'),
                OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description_mail'),
                OW::getLanguage()->text('shoppro', 'product_table_contactseler'),
                "button",
                SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                ,$value['has_options'],$value['id']
                );

            }else{
                if (SHOPPRO_BOL_Service::getInstance()->is_cart()){
                    $products .=SHOPPRO_BOL_Service::getInstance()->make_acccartbutton(
                        $value['id'],$value['id_owner'],$value['name'],$value['description'],1,$value['price'],$value['curency'],'clasifid',$value['has_options'],$value['id']
                    );
                }
            }//else
        }else{
            $products .="<div class=\"ow_center\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_table_add_type_classified')."</div>";
        }
        return $products;
    }



    public function corect_exif($path="")
    {
        if (!OW::getConfig()->getValue('shoppro', 'corect_exif')){
            return;
        }
        
//         $storage = OW::getStorage();
//          if ( !$storage->isWritable($path) )
            


        if ($path AND is_file($path) AND function_exists('exif_read_data') AND function_exists('imagerotate')){
//        if ($path AND is_file($path) AND function_exists('exif_read_data')){
//            ini_set('exif.encode_unicode', 'UTF-8');
            $exif = exif_read_data($path);
            if($exif) {
                if (isset($exif['Orientation'])){
                    $ort = $exif['Orientation'];
                }else if (isset($exif['IFD0']['Orientation'])){
                    $ort = $exif['IFD0']['Orientation'];
                }else if (isset($exif['EXIF']['Orientation'])){
                    $ort = $exif['EXIF']['Orientation'];
                }

                if($ort != 1){
                    $img = imagecreatefromjpeg($path) or die('Error opening file '.$path);
                    $deg = 0;
                    switch ($ort) {
                        case 3:
                            $deg = 180;
                        break;
                        case 6:
                            $deg = 270;
                        break;
                        case 8:
                            $deg = 90;
                        break;
                    }
                    if ($deg) {
//                      $imgr = $this->imagerotateXY($img, $deg, 0);        
                      $imgr = imagerotate($img, $deg, 0);        
                    }else{
                      $imgr=$img;
                    }
                    imagejpeg($imgr, $path, 95);
                    imagedestroy($img);
                    imagedestroy($imgr);
                }
            } // if have the exif orientation info
//        }else  if ($path AND is_file($path) AND function_exists('exif_read_data') AND extension_loaded('magickwand')){
//        }else  if ($path AND is_file($path) AND function_exists('exif_read_data') AND function_exists("NewMagickWand")){
//        }else  if ($path AND is_file($path) AND function_exists('exif_read_data') AND extension_loaded('imagick')){
        }else  if ($path AND is_file($path) AND function_exists('exif_read_data') AND class_exists("Imagick")){
            $exif = exif_read_data($path);
            if($exif) {
                if (isset($exif['Orientation'])){
                    $ort = $exif['Orientation'];
                }else if (isset($exif['IFD0']['Orientation'])){
                    $ort = $exif['IFD0']['Orientation'];
                }else if (isset($exif['EXIF']['Orientation'])){
                    $ort = $exif['EXIF']['Orientation'];
                }

                if($ort != 1){
                    $deg = 0;
                    switch ($ort) {
                        case 3:
                            $deg = -180;
                        break;
                        case 6:
                            $deg = -270;
                        break;
                        case 8:
                            $deg = -90;
                        break;
                    }
                    if ($deg) {
                        $imagick = new Imagick(); 
                        $imagick->readImage($path ); 
                        $imagick->rotateImage(new ImagickPixel('none'), $deg); 
                        $imagick->writeImage($path ); 
                        $imagick->clear(); 
                        $imagick->destroy(); 
                    }
                }
            }
        }
    }



    public function exif_v2($file="") {//not used
        //This line reads the EXIF data and passes it into an array
        $exif = read_exif_data($file['file']);

        //We're only interested in the orientation
        $exif_orient = isset($exif['Orientation'])?$exif['Orientation']:0;
        $rotateImage = 0;

        //We convert the exif rotation to degrees for further use
        if (6 == $exif_orient) {
            $rotateImage = 90;
            $imageOrientation = 1;
        } elseif (3 == $exif_orient) {
            $rotateImage = 180;
            $imageOrientation = 1;
        } elseif (8 == $exif_orient) {
            $rotateImage = 270;
            $imageOrientation = 1;
        }

        //if the image is rotated
        if ($rotateImage) {

            //WordPress 3.5+ have started using Imagick, if it is available since there is a noticeable difference in quality
            //Why spoil beautiful images by rotating them with GD, if the user has Imagick

            if (class_exists('Imagick')) {
                $imagick = new Imagick();
                $imagick->readImage($file['file']);
                $imagick->rotateImage(new ImagickPixel(), $rotateImage);
                $imagick->setImageOrientation($imageOrientation);
                $imagick->writeImage($file['file']);
                $imagick->clear();
                $imagick->destroy();
            } else {

                //if no Imagick, fallback to GD
                //GD needs negative degrees
                $rotateImage = -$rotateImage;

                switch ($file['type']) {
                    case 'image/jpeg':
                        $source = imagecreatefromjpeg($file['file']);
                        $rotate = imagerotate($source, $rotateImage, 0);
                        imagejpeg($rotate, $file['file']);
                        break;
                    case 'image/png':
                        $source = imagecreatefrompng($file['file']);
                        $rotate = imagerotate($source, $rotateImage, 0);
                        imagepng($rotate, $file['file']);
                        break;
                    case 'image/gif':
                        $source = imagecreatefromgif($file['file']);
                        $rotate = imagerotate($source, $rotateImage, 0);
                        imagegif($rotate, $file['file']);
                        break;
                    default:
                        break;
                }
            }
        }
        // The image orientation is fixed, pass it back for further processing
        return $file;
    }


    public function make_acccartbutton2($idp=0,$ido=0,$ptitle="",$desc="",$amout=1,$price=0,$curency="",$product_type="shop",$has_option=false,$has_option_val=0)
    {
//return;
        $content="";
        $id_user = OW::getUser()->getId();
        $curent_url=OW_URL_HOME;
        if (!$this->is_cart()) return $content;

            $desc=$this->html2txt($desc);
            $desc=mb_substr($desc,0,200);
            $ptitle=mb_substr($ptitle,0,100);

        if (!$id_user){

            $content .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">";
            $sel_tmp=$this->make_paymet_options($idp,'select');
            if (isset($sel_tmp['sel']) AND $sel_tmp['sel']){
                $content .="<select class=\"p_sel_option\" id=\"p_option_".$idp."\" name=\"p_option_".$idp."\">";
                $content .=$sel_tmp['sel'];
                $content .="</select>";
                if (isset($sel_tmp['selh'])){
                    $content .=$sel_tmp['selh'];
                }
            }

                    $content .="<span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <a href=\"".$curent_url."sign-in?back-uri=shop\" rel=\"nofollow\">
                            <input type=\"button\" name=\"tocart\" value=\"".OW::getLanguage()->text('cart', 'addtocart')."\" class=\"ow_ic_add ow_positive\">
                            </a>
                        </span>
                    </span>
                </div>
            </div>";

        }else{


            if ($has_option){//----------------------------------have option

                                    $item_options=$this->get_one_paymentoption($idp,"smaller");
                                    if ($item_options['id']>0){
                                        $price=OW::getLanguage()->text('shoppro', 'from').": ".$item_options['price'];
                                        $curency=$item_options['currence'];
                                        $price_block_display="block";
                                    }else{//---not found options
                                        $price_block_display="none";
                                    }

                $content .="<div class=\"ow_center\">";

/*
                $sel_tmp=$this->make_paymet_options($idp,'select');
                if (isset($sel_tmp['sel']) AND $sel_tmp['sel']){
                    $content .="<select class=\"p_sel_option\" id=\"p_option_".$idp."\" name=\"p_option_".$idp."\">";
                    $content .=$sel_tmp['sel'];
                    $content .="</select>";
                    if (isset($sel_tmp['selh'])){
                        $content .=$sel_tmp['selh'];
                    }
                }

                    $content .="<span class=\"ow_button\" style=\"margin-top:10px;\">
                        <span class=\" ow_positive\">";

                    $content .="<input type=\"button\" id=\"shop_addtocart\" name=\"tocart\" value=\"".OW::getLanguage()->text('cart', 'addtocart')."\" class=\"ow_ic_add ow_positive shop_addtocart\" 
                        idp=\"".$idp."\" 
                        ido=\"".$ido."\" 
                        ptitle=\"".$ptitle."\" 
                        poption=\"".$has_option_val."\" 
                        hoption=\"".$has_option."\" 
                        desc=\"".$desc."\" 
                        amout=\"".$amout."\" 
                        price=\"".$price."\" 
                        curency=\"".$curency."\" 
                        product_type=\"".$product_type."\" >";

                        $content .="</span>
                    </span>";
*/
/*
                    $content .="<span class=\"ow_button\" style=\"margin-top:10px;\">
                        <span class=\" ow_positive\">";

                $content .="<a href=\"".$curent_url."product/".$idp."/zoom/index.html\">";
                    $content .="<input type=\"button\" id=\"shop_addtocartx\" name=\"tocartx\" value=\"".OW::getLanguage()->text('cart', 'addtocart')."\" class=\"ow_ic_lone ow_positive \" >";
                $content .="</a>";

                        $content .="</span>
                    </span>";
*/
            $content .="<div class=\"clearfix\">
                <div class=\"ow_center\">
<a href=\"".$curent_url."product/".$idp."/zoom/index.html\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"submit\" name=\"dosave\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_open_product')."\" class=\"ow_ic_lens ow_positive\">
                        </span>
                    </span>
</a>
                </div>
            </div>";


                $content .="</div>";

            }else{//----------------------------------not option

                $content .="<input type=\"hidden\" id=\"p_option_".$idp."\" name=\"p_option_".$idp."\" value=\"0\">";
                $content .="<div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"button\" id=\"shop_addtocart\" name=\"tocart\" value=\"".OW::getLanguage()->text('cart', 'addtocart')."\" class=\"ow_ic_add ow_positive shop_addtocart\" 
                        idp=\"".$idp."\" 
                        ido=\"".$ido."\" 
                        ptitle=\"".$ptitle."\" 
                        poption=\"".$has_option_val."\" 
                        hoption=\"".$has_option."\" 
                        desc=\"".$desc."\" 
                        amout=\"".$amout."\" 
                        price=\"".$price."\" 
                        curency=\"".$curency."\" 
                        product_type=\"".$product_type."\" >
                        </span>
                    </span>
                </div>";

            }//-------------------------not option end
        }

                $content .=$this->make_inqiure_button2($idp);
//----send question e
        return $content;
    }


    public function make_acccartbutton($idp=0,$ido=0,$ptitle="",$desc="",$amout=1,$price=0,$curency="",$product_type="shop",$has_option=false,$has_option_val=0)
    {
//echo $idp."-";
//echo $has_option;exit;
        $content="";
        $id_user = OW::getUser()->getId();
        $curent_url=OW_URL_HOME;
//        if (!OW::getPluginManager()->isPluginActive('cart')) return $content;
//        if (OW::getConfig()->getValue('cart', 'cart_on')=="0") return $content;
        if (!$this->is_cart()) return $content;


//,$has_option_title="",$has_option_price=0,$has_option_cur=""
//            if ($has_option==1 AND $has_option_val>0){
//                $sqlo = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products_options WHERE id_product='".addslashes($has_option_val)."' id_product='".addslashes($has_option_val)."' ORDER BY order_prod ";
//                $arro = OW::getDbo()->queryForList($sqlo);
//                    foreach ( $arr as $value )
//            }else{
//            }

    
            $desc=$this->html2txt($desc);
            $desc=mb_substr($desc,0,200);
            $ptitle=mb_substr($ptitle,0,100);

        if (!$id_user){
            $content .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">";
$sel_tmp=$this->make_paymet_options($idp,'select');
if (isset($sel_tmp['sel']) AND $sel_tmp['sel']){
$content .="<select class=\"p_sel_option\" id=\"p_option_".$idp."\" name=\"p_option_".$idp."\">";
$content .=$sel_tmp['sel'];
$content .="</select>";
    if (isset($sel_tmp['selh'])){
        $content .=$sel_tmp['selh'];
    }
}

                    $content .="<span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <a href=\"".$curent_url."sign-in?back-uri=shop\" rel=\"nofollow\">
                            <input type=\"button\" name=\"tocart\" value=\"".OW::getLanguage()->text('cart', 'addtocart')."\" class=\"ow_ic_add ow_positive\">
                            </a>
                        </span>
                    </span>
                </div>
            </div>";
        }else{
/*
            $content .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"button\" value=\"tocart\" name=\"".OW::getLanguage()->text('cart', 'addtocart')."\" class=\"ow_ic_add ow_positive\">
                        </span>
                    </span>
                </div>
            </div>";
*/
//                            <input type=\"button\" id=\"shop_addtocart\" name=\"tocart\" value=\"".OW::getLanguage()->text('cart', 'addtocart')."\" class=\"ow_ic_add ow_positive shop_btnDialog\">

            if ($has_option){//----------------------------------have option
//echo "sss";exit;
                $content .="<div class=\"ow_center\">";
$sel_tmp=$this->make_paymet_options($idp,'select');
if (isset($sel_tmp['sel']) AND $sel_tmp['sel']){
$content .="<select class=\"p_sel_option\" id=\"p_option_".$idp."\" name=\"p_option_".$idp."\">";
$content .=$sel_tmp['sel'];
$content .="</select>";
    if (isset($sel_tmp['selh'])){
        $content .=$sel_tmp['selh'];
    }
}
                    $content .="<span class=\"ow_button\" style=\"margin-top:10px;\">
                        <span class=\" ow_positive\">";

                            $content .="<input type=\"button\" id=\"shop_addtocart\" name=\"tocart\" value=\"".OW::getLanguage()->text('cart', 'addtocart')."\" class=\"ow_ic_add ow_positive shop_addtocart\" 
idp=\"".$idp."\" 
ido=\"".$ido."\" 
ptitle=\"".$ptitle."\" 
poption=\"".$has_option_val."\" 
hoption=\"".$has_option."\" 
desc=\"".$desc."\" 
amout=\"".$amout."\" 
price=\"".$price."\" 
curency=\"".$curency."\" 
product_type=\"".$product_type."\" >";

                        $content .="</span>
                    </span>
                </div>";
            }else{//----------------------------------not option
                $content .="<input type=\"hidden\" id=\"p_option_".$idp."\" name=\"p_option_".$idp."\" value=\"0\">";
                $content .="<div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"button\" id=\"shop_addtocart\" name=\"tocart\" value=\"".OW::getLanguage()->text('cart', 'addtocart')."\" class=\"ow_ic_add ow_positive shop_addtocart\" 
idp=\"".$idp."\" 
ido=\"".$ido."\" 
ptitle=\"".$ptitle."\" 
poption=\"".$has_option_val."\" 
hoption=\"".$has_option."\" 
desc=\"".$desc."\" 
amout=\"".$amout."\" 
price=\"".$price."\" 
curency=\"".$curency."\" 
product_type=\"".$product_type."\" 
>
                        </span>
                    </span>
                </div>";
            }//-------------------------not option end
        }



//----send question s IN CART - duplocate in without cart

/*
                $content .="<div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"button\" id=\"shop_send_question\" name=\"send_question\" value=\"".OW::getLanguage()->text('shop', 'send_question')."\" class=\"ow_ic_add ow_positive shop_addtocart\" 
idp=\"".$idp."\" 
ido=\"".$ido."\" 
ptitle=\"".$ptitle."\" 
poption=\"".$has_option_val."\" 
hoption=\"".$has_option."\" 
desc=\"".$desc."\" 
amout=\"".$amout."\" 
price=\"".$price."\" 
curency=\"".$curency."\" 
product_type=\"".$product_type."\" 
>
                        </span>
                    </span>
                </div>";
*/



/*
                $content .="<div class=\"clearfix\">";
                $content .="<div class=\"ow_center\" style=\"margin-top:8px;\">";
                $content .="<ul class=\"ow_bl clearfix ow_small ow_stdmargin ow_center\">
            <li style=\"float: none;\">";

                    $content .="<a href=\"#\" data-reveal-id=\"myModal\" data-idp=\"".$idp."\" data-ido=\"".$ido."\" data-animation=\"none\" data-animationspeed=\"300\" data-closeonbackgroundclick=\"true\" data-dismissmodalclass=\"close-reveal-modal\" class=\"ow_mild_green wp_init\" rel=\"nofollow\">";
                    $content .= OW::getLanguage()->text('shop', 'send_question');
                    $content .="</a>
        </li>

    </ul>";
        
                $content .="</div>";
                $content .="</div>";
*/
//echo $idp."=";
                $content .=$this->make_inqiure_button($idp);
//----send question e
        return $content;
    }

    public function make_thermofuse($foruser=0)
    {
        $ret="";
        if ($foruser>0){
        $curent_url=OW_URL_HOME;
//--------------if exist term of use START
            $query2 = "SELECT termofuse FROM " . OW_DB_PREFIX. "shoppro_seller WHERE is_owner='".addslashes($foruser)."' LIMIT 1";
            $arrp2 = OW::getDbo()->queryForList($query2);
            if (isset($arrp2[0]) AND strlen($arrp2[0]['termofuse'])>3) {
//                $valuep2=$arrp2[0];


        $ret .="<div class=\"flearfix\">";
        $ret .="<div class=\"ow_right\">";
        $ret .="<a href=\"".$curent_url."shoppro/termofuse/".$foruser."\" target=\"_blank\">";
        $ret .=OW::getLanguage()->text('shoppro', 'im_readed_and_agree_termofuse').":&nbsp;";
        $ret .="</a>";
        $ret .="<input checked type=\"checkbox\" class=\"agree_termofuse\" id=\"agree_termofuse\" name=\"agree_termofuse\" value=\"AGREE\">";
        $ret .="</div>";
        $ret .="</div>";


            }else{
                $ret .="<input type=\"hidden\" class=\"agree_termofuse_hid\" id=\"agree_termofuse_hid\" name=\"agree_termofuse_hid\" value=\"AGREE\">";
            }
//-----------------if exist term of use END
        }
        return $ret;
    }


    public function make_popup_window2( $id="",$url="" ,$button_type="submit",$button_position="center",$button_ico="cart",$button_title_mainbutton="Submit",$title_bsubmit="Submit", $title="",$content="",$title_header="Info",$button_theme="button",$thermofuse="",$has_option=0,$idp=0,$frommode="shop" )
    {
//return;
//echo "sdfsdF";
        $curent_url=OW_URL_HOME;
        $id_user = OW::getUser()->getId();
        $pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();
        if (!$id) $id=time().'-'.uniqid(true);
        $ret ="<div id=\"shop_dialog_".$id."\" dial=\"".$id."\" has_option=\"".$has_option."\" class=\"shop_dialog\">
<div class=\"ow_alt2\">
        <table style=\"width: 100%; border: 0px;\" cellpadding=\"3\" cellspacing=\"0\">
            <tr class=\"ow_alt1\">
                <td class=\"ow_alt2 shop_dialog_title\"  style=\"text-align:left;font-weight:bold;\">&nbsp;".mb_strtoupper($title_header)."</td>
                <td class=\"ow_alt2 shop_dialog_title align_right\">
                    <a href=\"#\" id=\"shop_btnClose\" class=\"shop_btnClose\" dial=\"".$id."\" style=\"font-weight:bold;\">";

                        $ret .=OW::getLanguage()->text('shoppro', 'close_popup');
                    $ret .="&nbsp;<img src=\"".$pluginStaticURL2."remove.png\" style=\"border:0;padding:0;margin:0;margin-right:5px;\" alt=\"".OW::getLanguage()->text('shoppro', 'close_popup')."\">&nbsp;";
                        $ret .="</a>
                </td>
            </tr>";

        if ($title){
            $ret .="<tr>
                <td colspan=\"2\"> &nbsp;</td>
            </tr>";
            $ret .="<tr>
                <td colspan=\"2\" style=\"padding-left: 15px;\">
                    <b>".$title."</b>
                </td>
            </tr>";
        }
            $ret .="<tr>
                <td colspan=\"2\"> &nbsp;</td>
            </tr>";
        
            $ret .="<tr>
                <td colspan=\"2\" style=\"padding-left: 15px;\">
                    <div id=\"brands\">
                    ".$content."
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan=\"2\"> &nbsp;</td>
            </tr>";

        if ($thermofuse){
            $ret .="<tr>
            <td colspan=\"2\">";
            $ret .=$thermofuse;
            $ret .="</td>
            </tr>";
            $ret .="<tr>
            <td colspan=\"2\">";
            $ret .="</td>
            </tr>";
        }

        if ($button_ico=="mail"){

            $ret .="<tr>
            <td colspan=\"2\" style=\"text-align:left;\">";
            $ret .="<b>".OW::getLanguage()->text('shoppro', 'subject_ask_product')."</b>";
            $ret .="</td>
            </tr>";
            $ret .="<tr>
            <td colspan=\"2\">";
            $content_defalt=OW::getLanguage()->text('shoppro', 'default_message').": ".$curent_url."product/".$idp."/zoom/index.html";
            $ret .="<textarea id=\"mail_content\" name=\"mail_content\">".$content_defalt."</textarea>";
            $ret .="</td>
            </tr>";
            $ret .="<tr>
            <td colspan=\"2\">";
            $ret .="</td>
            </tr>";

        }

        if ($title_bsubmit){
            $ret .="<tr class=\"ow_alt1\">";
            $ret .="<td colspan=\"2\" style=\"text-align: center;\">";
                if ($url){
                    $ret .="<table style=\"width:100%;margin:auto;border:0;min-height: 30px\">";
                    $ret .="<tr>";
                    $ret .="<td style=\"text-align: center; width:50%;\">";

//                    $ret .="<input id=\"shop_btnCancel\" class=\"shop_btnCancel ow_ic_delete ow_center\" dial=\"".$id."\" type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" title=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" />";
            $ret .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">";
                            $ret .="<input id=\"shop_btnCancel\" class=\"shop_btnCancel ow_ic_delete ow_center\" dial=\"".$id."\" has_option=\"".$has_option."\" type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" title=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" />";
                        $ret .="</span>
                    </span>
                </div>
            </div>";

                    $ret .="</td>";
                    $ret .="<td style=\"text-align: center; width:50%;\">";
                    if ($title_bsubmit AND $button_ico!="mail"){
//                        $ret .="<input id=\"shop_btnSubmit\" class=\"shop_btnSubmit ow_ic_".$button_ico." ow_center\" type=\"button\" value=\"".$title_bsubmit."\" url=\"".$url."\" title=\"".$title_bsubmit."\"  />";
            $ret .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">";
                            $ret .="<input id=\"shop_btnSubmit\" class=\"shop_btnSubmit ow_ic_".$button_ico." ow_center\" dial=\"".$id."\" has_option=\"".$has_option."\" type=\"button\" value=\"".$title_bsubmit."\" url=\"".$url."\" title=\"".$title_bsubmit."\"  />";
                        $ret .="</span>
                    </span>
                </div>
            </div>";
                    }else if ($button_ico=="mail"){
                        $urlm=$curent_url."shop/sm/".substr(session_id(),4,6);
            $ret .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">";
                            $ret .="<input id=\"shop_btnSubmit_mail\" class=\"shop_btnSubmit_mail ow_ic_".$button_ico." ow_center\" dial=\"".$id."\" pid=\"".$idp."\" burl=\"".$frommode."\" has_option=\"".$has_option."\" type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'send_message')."\" url=\"".$urlm."\" title=\"".OW::getLanguage()->text('shoppro', 'send_message')."\"  />";
                        $ret .="</span>
                    </span>
                </div>
            </div>";                        
                    }else{
                        $ret .="&nbsp;";
                    }
                    $ret .="</td>";
                    $ret .="</tr>";
                    $ret .="</table>";
                }else{
//                    $ret .="<td colspan=\"2\" style=\"text-align: center;\">
//                    $ret .="<input id=\"shop_btnCancel\" class=\"shop_btnCancel ow_ic_delete ow_center\" dial=\"".$id."\" type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" title=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" />";
            $ret .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">";
                            $ret .="<input id=\"shop_btnCancel\" class=\"shop_btnCancel ow_ic_delete ow_center\" dial=\"".$id."\" has_option=\"".$has_option."\" type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" title=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" />";
                        $ret .="</span>
                    </span>
                </div>
            </div>";
//                    $ret .="</td>";
                }

            $ret .="</td>";
            $ret .="</tr>";
        }









            $ret .="<tr>
                <td colspan=\"2\"> &nbsp;</td>
            </tr>
        </table>
</div>
        </div>
        ";

//echo $has_option."--".$id;exit;

            if ($has_option AND $idp>0){//----------------------------------have option
/*
//echo "sss";exit;
                $ret .="<div class=\"ow_center\">";
$sel_tmp=$this->make_paymet_options($idp,'select');
if (isset($sel_tmp['sel']) AND $sel_tmp['sel']){
$ret .="<select class=\"p_sel_option\" id=\"p_option_".$id."\" name=\"p_option_".$id."\">";
$ret .=$sel_tmp['sel'];
$ret .="</select>";
    if (isset($sel_tmp['selh'])){
        $ret .=$sel_tmp['selh'];
    }
}
                $ret .="</div>";
*/
            }else{//----------------------------------not option
                $ret .="<input type=\"hidden\" id=\"p_option_".$id."\" name=\"p_option_".$id."\" value=\"0\">";

            }//-------------------------not option end



        if ($button_ico=="mail" AND !$id_user){
                $curent_full_url=$_SERVER["REQUEST_URI"];
                if (!$curent_full_url) $curent_full_url="shop";
                $ret .="<div class=\"clearfix ow_submit ow_smallmargin\" style=\"margin-top:10px;\">
                <div class=\"ow_center\">
                    <a href=\"".$curent_url."sign-in?back-uri=".$curent_full_url."\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"button\" name=\"ok\" value=\"".$button_title_mainbutton."\" class=\"ow_ic_".$button_ico." ow_positive\" >
                        </span>
                    </span>
                    </a>
                </div>
            </div>";
        }else{

            if ($button_theme=="image"){
//        if ($button_theme=="button"){
                $ret .=$this->make_popup_button_image( $id,$button_type,$button_position,$button_title_mainbutton,$button_ico,$has_option,$idp);
            }else{
                $ret .=$this->make_popup_button2( $id,$button_type,$button_position,$button_title_mainbutton,$button_ico,$has_option,$idp);
            }
        }

//----send question s IN CART - duplocate in without cart
//                $ret .=$this->make_inqiure_button($idp);
//----send question e

        return $ret;
    }


    public function make_popup_window( $id="",$url="" ,$button_type="submit",$button_position="center",$button_ico="cart",$button_title_mainbutton="Submit",$title_bsubmit="Submit", $title="",$content="",$title_header="Info",$button_theme="button",$thermofuse="",$has_option=0,$idp=0,$frommode="shop" )
    {
        $curent_url=OW_URL_HOME;
        $id_user = OW::getUser()->getId();
        $pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();
        if (!$id) $id=time().'-'.uniqid(true);
        $ret ="<div id=\"shop_dialog_".$id."\" dial=\"".$id."\" has_option=\"".$has_option."\" class=\"shop_dialog\">
<div class=\"ow_alt2\">
        <table style=\"width: 100%; border: 0px;\" cellpadding=\"3\" cellspacing=\"0\">
            <tr class=\"ow_alt1\">
                <td class=\"ow_alt2 shop_dialog_title\"  style=\"text-align:left;font-weight:bold;\">&nbsp;".mb_strtoupper($title_header)."</td>
                <td class=\"ow_alt2 shop_dialog_title align_right\">
                    <a href=\"#\" id=\"shop_btnClose\" class=\"shop_btnClose\" dial=\"".$id."\" style=\"font-weight:bold;\">";

                        $ret .=OW::getLanguage()->text('shoppro', 'close_popup');
                    $ret .="&nbsp;<img src=\"".$pluginStaticURL2."remove.png\" style=\"border:0;padding:0;margin:0;margin-right:5px;\" alt=\"".OW::getLanguage()->text('shoppro', 'close_popup')."\">&nbsp;";
                        $ret .="</a>
                </td>
            </tr>";

        if ($title){
            $ret .="<tr>
                <td colspan=\"2\"> &nbsp;</td>
            </tr>";
            $ret .="<tr>
                <td colspan=\"2\" style=\"padding-left: 15px;\">
                    <b>".$title."</b>
                </td>
            </tr>";
        }
            $ret .="<tr>
                <td colspan=\"2\"> &nbsp;</td>
            </tr>";
        
            $ret .="<tr>
                <td colspan=\"2\" style=\"padding-left: 15px;\">
                    <div id=\"brands\">
                    ".$content."
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan=\"2\"> &nbsp;</td>
            </tr>";

        if ($thermofuse){
            $ret .="<tr>
            <td colspan=\"2\">";
            $ret .=$thermofuse;
            $ret .="</td>
            </tr>";
            $ret .="<tr>
            <td colspan=\"2\">";
            $ret .="</td>
            </tr>";
        }

        if ($button_ico=="mail"){

            $ret .="<tr>
            <td colspan=\"2\" style=\"text-align:left;\">";
            $ret .="<b>".OW::getLanguage()->text('shoppro', 'subject_ask_product')."</b>";
            $ret .="</td>
            </tr>";
            $ret .="<tr>
            <td colspan=\"2\">";
            $content_defalt=OW::getLanguage()->text('shoppro', 'default_message').": ".$curent_url."product/".$idp."/zoom/index.html";
            $ret .="<textarea id=\"mail_content\" name=\"mail_content\">".$content_defalt."</textarea>";
            $ret .="</td>
            </tr>";
            $ret .="<tr>
            <td colspan=\"2\">";
            $ret .="</td>
            </tr>";

        }

        if ($title_bsubmit){
            $ret .="<tr class=\"ow_alt1\">";
            $ret .="<td colspan=\"2\" style=\"text-align: center;\">";
                if ($url){
                    $ret .="<table style=\"width:100%;margin:auto;border:0;min-height: 30px\">";
                    $ret .="<tr>";
                    $ret .="<td style=\"text-align: center; width:50%;\">";

//                    $ret .="<input id=\"shop_btnCancel\" class=\"shop_btnCancel ow_ic_delete ow_center\" dial=\"".$id."\" type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" title=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" />";
            $ret .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">";
                            $ret .="<input id=\"shop_btnCancel\" class=\"shop_btnCancel ow_ic_delete ow_center\" dial=\"".$id."\" has_option=\"".$has_option."\" type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" title=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" />";
                        $ret .="</span>
                    </span>
                </div>
            </div>";

                    $ret .="</td>";
                    $ret .="<td style=\"text-align: center; width:50%;\">";
                    if ($title_bsubmit AND $button_ico!="mail"){
//                        $ret .="<input id=\"shop_btnSubmit\" class=\"shop_btnSubmit ow_ic_".$button_ico." ow_center\" type=\"button\" value=\"".$title_bsubmit."\" url=\"".$url."\" title=\"".$title_bsubmit."\"  />";
            $ret .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">";
                            $ret .="<input id=\"shop_btnSubmit\" class=\"shop_btnSubmit ow_ic_".$button_ico." ow_center\" dial=\"".$id."\" has_option=\"".$has_option."\" type=\"button\" value=\"".$title_bsubmit."\" url=\"".$url."\" title=\"".$title_bsubmit."\"  />";
                        $ret .="</span>
                    </span>
                </div>
            </div>";
                    }else if ($button_ico=="mail"){
                        $urlm=$curent_url."shop/sm/".substr(session_id(),4,6);
            $ret .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">";
                            $ret .="<input id=\"shop_btnSubmit_mail\" class=\"shop_btnSubmit_mail ow_ic_".$button_ico." ow_center\" dial=\"".$id."\" pid=\"".$idp."\" burl=\"".$frommode."\" has_option=\"".$has_option."\" type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'send_message')."\" url=\"".$urlm."\" title=\"".OW::getLanguage()->text('shoppro', 'send_message')."\"  />";
                        $ret .="</span>
                    </span>
                </div>
            </div>";                        
                    }else{
                        $ret .="&nbsp;";
                    }
                    $ret .="</td>";
                    $ret .="</tr>";
                    $ret .="</table>";
                }else{
//                    $ret .="<td colspan=\"2\" style=\"text-align: center;\">
//                    $ret .="<input id=\"shop_btnCancel\" class=\"shop_btnCancel ow_ic_delete ow_center\" dial=\"".$id."\" type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" title=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" />";
            $ret .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">";
                            $ret .="<input id=\"shop_btnCancel\" class=\"shop_btnCancel ow_ic_delete ow_center\" dial=\"".$id."\" has_option=\"".$has_option."\" type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" title=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" />";
                        $ret .="</span>
                    </span>
                </div>
            </div>";
//                    $ret .="</td>";
                }

            $ret .="</td>";
            $ret .="</tr>";
        }









            $ret .="<tr>
                <td colspan=\"2\"> &nbsp;</td>
            </tr>
        </table>
</div>
        </div>
        ";

//echo $has_option."--".$id;exit;

            if ($has_option AND $idp>0){//----------------------------------have option
//echo "sss";exit;
                $ret .="<div class=\"ow_center\">";
$sel_tmp=$this->make_paymet_options($idp,'select');
if (isset($sel_tmp['sel']) AND $sel_tmp['sel']){
$ret .="<select class=\"p_sel_option\" id=\"p_option_".$id."\" name=\"p_option_".$id."\">";
$ret .=$sel_tmp['sel'];
$ret .="</select>";
    if (isset($sel_tmp['selh'])){
        $ret .=$sel_tmp['selh'];
    }
}
                $ret .="</div>";
            }else{//----------------------------------not option
                $ret .="<input type=\"hidden\" id=\"p_option_".$id."\" name=\"p_option_".$id."\" value=\"0\">";

            }//-------------------------not option end



        if ($button_ico=="mail" AND !$id_user){
                $curent_full_url=$_SERVER["REQUEST_URI"];
                if (!$curent_full_url) $curent_full_url="shop";
                $ret .="<div class=\"clearfix ow_submit ow_smallmargin\" style=\"margin-top:10px;\">
                <div class=\"ow_center\">
                    <a href=\"".$curent_url."sign-in?back-uri=".$curent_full_url."\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"button\" name=\"ok\" value=\"".$button_title_mainbutton."\" class=\"ow_ic_".$button_ico." ow_positive\" >
                        </span>
                    </span>
                    </a>
                </div>
            </div>";
        }else{

            if ($button_theme=="image"){
//        if ($button_theme=="button"){
                $ret .=$this->make_popup_button_image( $id,$button_type,$button_position,$button_title_mainbutton,$button_ico,$has_option,$idp);
            }else{
                $ret .=$this->make_popup_button( $id,$button_type,$button_position,$button_title_mainbutton,$button_ico,$has_option,$idp);
            }
        }

//----send question s IN CART - duplocate in without cart
//                $ret .=$this->make_inqiure_button($idp);
//----send question e

        return $ret;
    }


    public function make_inqiure_button($id_product=0,$idmodel="myModal"){//adk button for zoom product
//echo $id_product."-";
        if (!OW::getConfig()->getValue('shoppro', 'show_askbutton')) return;

        if (!OW::getRequest()->isPost() AND !OW::getRequest()->isAjax() AND 
            strpos($_SERVER["REQUEST_URI"],"base/media-panel")===false AND 
            strpos($_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"],"ow_cron")===false AND 
            strpos($_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"],"mobile/v2/option/shop")!==false 
        ){
            return;
        }


        $id_user = OW::getUser()->getId();
        $curent_url=OW_URL_HOME;
        $ret="";
//        if ($id_product>0 AND $id_user>0){
        if ($id_product>0 ){
//----send question s IN CART - duplocate in WITH cart

/*
                $content .="<div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"button\" id=\"shop_send_question\" name=\"send_question\" value=\"".OW::getLanguage()->text('shop', 'send_question')."\" class=\"ow_ic_add ow_positive shop_addtocart\" 
idp=\"".$idp."\" 
ido=\"".$ido."\" 
ptitle=\"".$ptitle."\" 
poption=\"".$has_option_val."\" 
hoption=\"".$has_option."\" 
desc=\"".$desc."\" 
amout=\"".$amout."\" 
price=\"".$price."\" 
curency=\"".$curency."\" 
product_type=\"".$product_type."\" 
>
                        </span>
                    </span>
                </div>";
*/

        
            $id_owner=0;

            $sql="SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($id_product)."' LIMIT 1";
            $arrac = OW::getDbo()->queryForList($sql);
            if (isset($arrac['0']['id']) AND $arrac['0']['id']>0 AND isset($arrac['0']['id_owner']) AND $arrac['0']['id_owner']>0 AND $arrac['0']['id_owner']!=$id_user){
                $id_owner=$arrac['0']['id_owner'];

/*
                $ret .="<div class=\"clearfix\">";
                $ret .="<div class=\"ow_center\" style=\"margin-top:8px;\">";
    $ret .="<ul class=\"ow_bl clearfix ow_small ow_stdmargin ow_center\">
            <li style=\"float: none;\">";

                    if ($id_user>0){
                        $ret .="<a href=\"#\" data-reveal-id=\"".$idmodel."\" data-idp=\"".$id_product."\" data-ido=\"".$id_owner."\" data-title=\"".$this->clear_html(stripslashes($arrac['0']['name']))."\" data-purl=\"".$curent_url."product/".$arrac['0']['id']."/zoom/index.html\" data-animation=\"none\" data-animationspeed=\"300\" data-closeonbackgroundclick=\"true\" data-dismissmodalclass=\"close-reveal-modal\" class=\"ow_mild_green wp_init\" rel=\"nofollow\">";
                    }else{
                        $ret .="<a href=\"".$curent_url."sign-in?back-uri=product/".$arrac['0']['id']."/zoom/index.html\" rel=\"nofollow\">";
                    }
                    $ret .= OW::getLanguage()->text('shoppro', 'send_question');
                    $ret .="</a>
            </li>

    </ul>";
        
                $ret .="</div>";
                $ret .="</div>";
*/
            $ret .="<div class=\"clearfix\" style=\"margin-top:10px;\">
                <div class=\"ow_center\">";
                    if ($id_user>0){
                        $ret .="<a href=\"#\" data-reveal-id=\"".$idmodel."\" data-idp=\"".$id_product."\" data-ido=\"".$id_owner."\" data-title=\"".$this->clear_html(stripslashes($arrac['0']['name']))."\" data-purl=\"".$curent_url."product/".$arrac['0']['id']."/zoom/index.html\" data-animation=\"none\" data-animationspeed=\"300\" data-closeonbackgroundclick=\"true\" data-dismissmodalclass=\"close-reveal-modal\" class=\"ow_mild_green wp_init\" rel=\"nofollow\">";
                    }else{
                        $ret .="<a href=\"".$curent_url."sign-in?back-uri=product/".$arrac['0']['id']."/zoom/index.html\" rel=\"nofollow\">";
                    }
                    $ret .="<span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"submit\" name=\"dosave\" value=\"".OW::getLanguage()->text('shoppro', 'send_question')."\" class=\"ow_ic_mail ow_positive\">
                        </span>
                    </span>
</a>
                </div>
            </div>";



            }//if ($id_owner>0)

//----send question e
        }
        return $ret;
    }

    public function make_inqiure_button2($id_product=0,$idmodel="myModal"){
return "";
//echo $id_product."-";
        if (!OW::getConfig()->getValue('shoppro', 'show_askbutton')) return;

        if (!OW::getRequest()->isPost() AND !OW::getRequest()->isAjax() AND 
            strpos($_SERVER["REQUEST_URI"],"base/media-panel")===false AND 
            strpos($_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"],"ow_cron")===false AND 
            strpos($_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"],"mobile/v2/option/shop")!==false 
        ){
            return;
        }


        $id_user = OW::getUser()->getId();
        $curent_url=OW_URL_HOME;
        $ret="";
//        if ($id_product>0 AND $id_user>0){
        if ($id_product>0 ){
//----send question s IN CART - duplocate in WITH cart
    
            $id_owner=0;

            $sql="SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($id_product)."' LIMIT 1";
            $arrac = OW::getDbo()->queryForList($sql);
            if (isset($arrac['0']['id']) AND $arrac['0']['id']>0 AND isset($arrac['0']['id_owner']) AND $arrac['0']['id_owner']>0 AND $arrac['0']['id_owner']!=$id_user){
                $id_owner=$arrac['0']['id_owner'];

/*
                $ret .="<div class=\"clearfix\">";
                $ret .="<div class=\"ow_center\" style=\"margin-top:8px;\">";
                $ret .="<ul class=\"ow_bl clearfix ow_small ow_stdmargin ow_center\">
            <li style=\"float: none;\">";
*/

                    if ($id_user>0){
                        $ret .="<a class=\"ow_lbutton ow_green\" href=\"#\" data-reveal-id=\"".$idmodel."\" data-idp=\"".$id_product."\" data-ido=\"".$id_owner."\" data-title=\"".$this->clear_html(stripslashes($arrac['0']['name']))."\" data-purl=\"".$curent_url."product/".$arrac['0']['id']."/zoom/index.html\" data-animation=\"none\" data-animationspeed=\"300\" data-closeonbackgroundclick=\"true\" data-dismissmodalclass=\"close-reveal-modal\" rel=\"nofollow\">";
                    }else{
                        $ret .="<a class=\"ow_lbutton ow_green\" href=\"".$curent_url."sign-in?back-uri=product/".$arrac['0']['id']."/zoom/index.html\" rel=\"nofollow\">";
                    }
                    $ret .= OW::getLanguage()->text('shoppro', 'send_question');
                    $ret .="</a>";
/*
        $ret .="</li>

    </ul>";
        
                $ret .="</div>";
                $ret .="</div>";
*/

            }//if ($id_owner>0)

//----send question e
        }
        return $ret;
    }


    public function make_popup_inquire_dialog($idmodel="myModal")
    {
        if (!OW::getConfig()->getValue('shoppro', 'show_askbutton')) return;

        if (!$idmodel) $idmodel="myModal";
        $curent_url=OW_URL_HOME;
        $id_user = OW::getUser()->getId();

        $content ="<div id=\"".$idmodel."\" class=\"reveal-modal\">
            <h1>".OW::getLanguage()->text('shoppro', 'ask_seller')."</h1>

                        <form action=\"".$curent_url."shop/inquire\" method=\"POST\">
                        <input type=\"hidden\" name=\"ss\" value=\"".substr(session_id(),2,6)."\">
                        <input type=\"hidden\" name=\"idp\" id=\"idp\" value=\"0\">
                        <input type=\"hidden\" name=\"idu\" id=\"idu\" value=\"0\">
                        <input type=\"hidden\" name=\"ac\" value=\"send_message\">
            <table class=\"ow_table_1Z ow_form\" style=\"width:100%;margin:auto;\">

            <tbody><tr>
            <td class=\"ow_label ow_left\" style=\"text-align:left;\">".OW::getLanguage()->text('shoppro', 'message_title').":
            </td>
            <td class=\"ow_value\"><input type=\"text\" name=\"tit\" id=\"tit\" value=\"\">
            </td>
            </tr>

            <tr>
            <td class=\"ow_label ow_left\" style=\"text-align:left;\" colspan=\"2\">".OW::getLanguage()->text('shoppro', 'message_content').":
            </td>
            </tr>

            <tr>
            <td class=\"ow_value\" colspan=\"2\"><textarea name=\"cont\" id=\"cont\" style=\"min-height:200px;\"></textarea>
            </td>
            </tr>

            <tr>
            <td colspan=\"2\">

                        <div class=\"ow_center\">
                            <span class=\"ow_button\">
                                <span class=\"ow_positive\">
                                    <input type=\"submit\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'send_message')."\" class=\"ow_ic_file ow_positive\">
                                </span>
                            </span>
                        </div>

            </td>
            </tr>

            </tbody></table>
                        </form>

            <a class=\"close-reveal-modal\" rel=\"nofollow\">×</a>
            </div>
";
        return $content;
    }


    private function make_popup_button( $id="",$type="submit",$position="center",$title_mainbutton="Submit",$button_ico="cart",$has_option=0,$idp=0 )
    {
        if (!$id) return;
                $ret="<div class=\"clearfix ow_submit ow_smallmargin\" style=\"margin-top:10px;\">
                <div class=\"ow_".$position."\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"".$type."\" name=\"ok\" value=\"".$title_mainbutton."\" class=\"ow_ic_".$button_ico." ow_positive shop_btnDialog\" dial=\"".$id."\" has_option=\"".$has_option."\" >
                        </span>
                    </span>
                </div>
            </div>";
            if ($button_ico!="mail"){
                $ret .=$this->make_inqiure_button($idp);            
            }
//echo $ret;exit;
            return $ret;
    }

    private function make_popup_button2( $id="",$type="submit",$position="center",$title_mainbutton="Submit",$button_ico="cart",$has_option=0,$idp=0 )
    {
        if (!$id) return;
//                $ret="<div class=\"clearfix ow_submit ow_smallmargin\" style=\"margin-top:10px;\">
                $ret="<div class=\"clearfix \" style=\"\">
                <div class=\"ow_".$position."\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"".$type."\" name=\"ok\" value=\"".$title_mainbutton."\" class=\"ow_ic_".$button_ico." ow_positive shop_btnDialog\" dial=\"".$id."\" has_option=\"".$has_option."\" >
                        </span>
                    </span>
                </div>
            </div>";
            if ($button_ico!="mail"){
                $ret .=$this->make_inqiure_button2($idp);            
            }
//echo $ret;exit;
            return $ret;
    }

    private function make_popup_button_image( $id="",$type="submit",$position="center",$title_mainbutton="Submit",$button_ico="doc6.gif",$has_option=0,$idp=0 )
    {
//return "ss";
        if (!$id) return;
        $ret="";
            $pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();
            $pluginStaticURL =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesUrl();
            $pluginStaticDir =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesDir();
//            $ret .="<div class=\"ow_".$position."\">";
//            $ret .="<a href=\"".$curent_url."product/".$value['entityId']."/block?ss=".substr(session_id(),3,2)."&spr=".$value['id'].$ff."\" title=\"".$title_mainbutton."\"  onclick=\"return confirm('".OW::getLanguage()->text('shoppro', 'qestion_anuluj_payment')."');\">";
//            $ret .="<a class=\"ow_".$position." shop_btnDialog\" href=\"".$curent_url."product/".$value['entityId']."/block?ss=".substr(session_id(),3,2)."&spr=".$value['id'].$ff."\" title=\"".$title_mainbutton."\" >";
            $ret .="<a class=\"ow_".$position." shop_btnDialog\" href=\"#\" title=\"".$title_mainbutton."\" dial=\"".$id."\" has_option=\"".$has_option."\" >";
//            $ret .="<img src=\"".$pluginStaticURL2."remove.png\" style=\"border:0;padding:0;margin:0;margin-right:5px;\">";
            $ret .="<img src=\"".$pluginStaticURL2.$button_ico."\" style=\"border:0;padding:0;margin:0;margin-right:5px;\">";
            $ret .="</a>";
//            $ret .="</div>";
/*
                $ret="<div class=\"clearfix ow_submit ow_smallmargin\" style=\"margin-top:10px;\">
                <div class=\"ow_".$position."\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"".$type."\" name=\"ok\" value=\"".$title_mainbutton."\" class=\"ow_ic_".$button_ico." ow_positive shop_btnDialog\" dial=\"".$id."\">
                        </span>
                    </span>
                </div>
            </div>";
*/

                $ret .=$this->make_inqiure_button($idp);
            return $ret;
    }

//                    add_to_mailbox($id_user,$for_user,$title,$message,strtotime(date('Y-m-d H:i:s')),"");
    public function add_to_mailbox($from=0,$to=0,$title="",$message="",$datamessage="",$from_email="")
    {
//echo "NEW!!!";exit;
        if (!$from) $from=0;
        if (!$datamessage) $datamessage=strtotime(date('Y-m-d H:i:s'));
        if ($to>0 AND ($title OR $message)){
            $sql="INSERT INTO " . OW_DB_PREFIX. "mailbox_conversation (
                `id` ,     `initiatorId`   ,  `interlocutorId`,  `subject`, `read`,`deleted` ,`viewed`,`notificationSent`,`createStamp`
            )VALUES(
                '','".addslashes($from)."','".addslashes($to)."','".addslashes($title)."','1','0','1','0','".addslashes($datamessage)."'
            )";
//echo $sql;exit;
            $newid=OW::getDbo()->insert($sql);

            if ($newid>0){
$message=str_ireplace("src=\"../ow_static","src=\"../../ow_static",$message);

                $sql="INSERT INTO " . OW_DB_PREFIX. "mailbox_message (
                    `id` , `conversationId` , `timeStamp`      , `senderId`     ,   `recipientId`  ,   `text`
                )VALUES(
                    '','".addslashes($newid)."','".addslashes($datamessage)."','".addslashes($from)."','".addslashes($to)."','".addslashes($this->safe_content($message))."'
                )";
//echo $sql;exit;
                $newid_msg=OW::getDbo()->insert($sql);
                if ($newid_msg>0){                    

                        $sql="UPDATE " . OW_DB_PREFIX. "mailbox_conversation SET 
                            lastMessageId='".addslashes($newid_msg)."',       
                            lastMessageTimestamp='".addslashes($datamessage)."' 
                        WHERE id='".addslashes($newid)."' LIMIT 1";
                        OW::getDbo()->query($sql);

                    if ($from_email AND OW::getPluginManager()->isPluginActive('mailboxpro')){
                        $pattern = '/([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])'.'(([a-z0-9-])*([a-z0-9]))+' . '(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)/i';
                        preg_match ($pattern, $from_email, $matches);
                        if (isset($matches[0]) AND $matches[0]){
                            $from_em=$matches[0];
                            $sql="INSERT INTO " . OW_DB_PREFIX. "mailboxpro_msg (
                                id,active,e_conversationId,email,data_lastincoming,data_incoming
                            )VALUES(
                                '','1','".addslashes($newid)."','".addslashes($from_em)."',NOW(),'".addslashes($datamessage)."'
                            ) ON DUPLICATE KEY UPDATE data_lastincoming=NOW() ";
                            OW::getDbo()->insert($sql);
                        }
                    }

                    $sql="SELECT * FROM " . OW_DB_PREFIX. "mailbox_last_message WHERE conversationId='".addslashes($newid)."' LIMIT 1";
                    $arra = OW::getDbo()->queryForList($sql);
                    if (isset($arra['0']['id']) AND $arra['0']['id']>0){
                        $sql="UPDATE " . OW_DB_PREFIX. "mailbox_last_message SET 
                            interlocutorMessageId='".addslashes($newid_msg)."' 
                        WHERE id='".addslashes($arra['0']['id'])."' LIMIT 1";
                        $newid_lmsg=OW::getDbo()->query($sql);
                    }else{
                        $sql="INSERT INTO " . OW_DB_PREFIX. "mailbox_last_message (
                            id  ,    conversationId , initiatorMessageId ,     interlocutorMessageId
                        )VALUES(
                            '','".addslashes($newid)."','".addslashes($newid_msg)."','0'
                        )";
//echo $sql;
                        $newid_lmsg=OW::getDbo()->insert($sql);
                    }

                $sql="DELETE FROM " . OW_DB_PREFIX. "mailbox_user_last_data 
                WHERE userId='".addslashes($from)."' LIMIT 1";
                OW::getDbo()->query($sql);

                $sql="DELETE FROM " . OW_DB_PREFIX. "mailbox_user_last_data 
                WHERE userId='".addslashes($to)."' LIMIT 1";
                OW::getDbo()->query($sql);


                    
                }
            }
        }
    }


    private function getDepartmentKey( $name )
    {
        return 'dept_' . trim($name);
    }

    public function getDepartmentList()
    {
        return SHOPPRO_BOL_DepartmentDao::getInstance()->findAll();
    }

    public function tabmenu_addtab($sel=0,$name="",$url="",$icon="ow_ic_plugin")
    {
        if ($sel) $checked=" active ";
        else $checked="";
        $this->tabmenu .="<li class=\"_plugin ".$checked."\"><a href=\"".$url."\"><span class=\"".$icon."\">".$name."</span></a></li>";
    }

    public function tabmenu_make()//mast be between: "<div class=\"ow_content\">......................</div>";
    {
        $ret="";
            
        $ret .="<div class=\"ow_content_menu_wrap\">
        <ul class=\"ow_content_menu clearfix\">
        <li class=\"_plugin \"><a href=\"http://www.oxwall.org/store\"><span class=\"ow_ic_plugin\">Plugins</span></a></li>
        <li class=\"_theme \"><a href=\"http://www.oxwall.org/store/themes\"><span class=\"ow_ic_plugin\">Themes</span></a></li>
        <li class=\"_store_purchase_list \"><a href=\"http://www.oxwall.org/store/granted-list\"><span class=\"ow_ic_cart\">My purchases</span></a></li>
        <li class=\"_store_my_items  active\"><a href=\"http://www.oxwall.org/store/list/my-items\"><span class=\"ow_ic_plugin\">My items</span></a></li>
        <li class=\"_store_dev_tools \"><a href=\"http://www.oxwall.org/store/dev-tools\"><span class=\"ow_ic_gear_wheel\">Developer tools</span></a></li>
        </ul>
        </div>";
        return $ret;
    }

    public function make_file_downloadurl($value="",$par="")
    {
        $id_user = OW::getUser()->getId();
        $is_admin = OW::getUser()->isAdmin();
        $curent_url=OW_URL_HOME;
        $table="";
if ($par=="fromid" OR $par=="id"){
    if (!isset($value['entityId']) AND $value['id']>0) $value['entityId']=$value['id'];
}
//return $value['entityId'];
//print_r($value);exit;
                                if (OW::getConfig()->getValue('shoppro', 'mode_sellfiles')==1 AND $value['entityId']>0){


                                if (!$is_admin){
                                    $add=" bs.userId='".addslashes($id_user)."' AND ";
                                    $addbs=" AND bs.userId='".addslashes($id_user)."' ";
                                }else{
                                    $add=" ";
                                    $addbs="";
                                }


//if ($valuex['id']>0 AND $valuex['id']==$value['entityId'] AND $valuex['file_attach'] AND $valuex['username']){

                        $table .="<div style=\"display:block;width:100%;margin:auto;\">";
/*
                                if (!$is_admin){
                                    $add=" AND sp.id_owner='".addslashes($id_user)."' ";
                                }else{
                                    $add=" ";
                                }

                                $query = "SELECT sp.*, bu.username FROM " . OW_DB_PREFIX. "shoppro_products sp 
                                        LEFT JOIN " . OW_DB_PREFIX. "base_user bu ON (bu.id=sp.id_owner) 
                                        WHERE sp.id='".addslashes($value['entityId'])."' ".$add." LIMIT 1";
//return $query;
                                $arrxx = OW::getDbo()->queryForList($query);
                                if (isset($arrxx[0])){
                                    $valuex=$arrxx[0];
                                }else{
                                    $valuex=array();
                                    $valuex['id']=0;
                                }
*/
//                                    LEFT JOIN " . OW_DB_PREFIX. "base_user bu ON (bu.id=pr.id_owner) 
                                $query = "SELECT pr.*,bu.username,bs.transactionUid, bs.status,bs.price as pricebs FROM " . OW_DB_PREFIX. "shoppro_products pr 
                                    LEFT JOIN " . OW_DB_PREFIX. "base_billing_sale bs ON ( bs.entityId=pr.id AND ".$add." (bs.status='processing' OR bs.status='verified' OR bs.status='delivered') )  
                                    LEFT JOIN " . OW_DB_PREFIX. "base_user bu ON (bu.id=pr.id_owner) 
                                    WHERE pr.id='".addslashes($value['entityId'])."' ".$addbs." LIMIT 1";

                                $arrxx = OW::getDbo()->queryForList($query);
                                if (isset($arrxx[0])){
                                    $valuex=$arrxx[0];
                                }else{
                                    $valuex=array();
                                    $valuex['id']=0;
                                }



//if ($par==1){
//    $table .= $query;
//}
                                if ($valuex['id']>0 AND $valuex['id']==$value['entityId'] AND $valuex['file_attach'] AND $valuex['username']){
//return "ss";
                                    $hash=$valuex['file_attach'];
                                    $pluginStaticURL =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesUrl();
                                    $pluginStaticDir =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesDir();
                                    $path_file=$pluginStaticDir."files/";
                                    $name_file="file_".$value['entityId']."_".$hash.".pack";
//                                    $table .="<table>";
                                    if (is_file($path_file.$name_file)){
//$table .="IS FILE!!!";
//                                        unlink($path_file.$name_file);
                                        $protect=substr(session_id(),3,10);
//                                        $table .="<tr>";
//                                        $table .="<td style=\"text-align:right;\">";
//                                        $table .= "<b>".OW::getLanguage()->text('shoppro', 'product_table_filefordownload').":</b>";
//                                        $table .="</td>";
//                                        $table .="<td>";
//                                        $table .= "&nbsp;";
                                        $table .="<a href=\"".$curent_url."shop/download/".$value['entityId']."/".$protect."\">";
//                                        $table .= "<b style=\"color:#00f;text-decoration:underline;\">".OW::getLanguage()->text('shoppro', 'product_table_filefordownload_download')."</b>";
            $table .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"button\" name=\"dosave\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_filefordownload_download')."\" class=\"ow_ic_up ow_positive\" onclick=\"location.href='".$curent_url."shop/download/".$value['entityId']."/".$protect."'\">
                        </span>
                    </span>
                </div>
            </div>";

                                        $table .="</a>";
//                                        $table .="</td>";
//                                        $table .="</tr>";
                                    }else{
//$table .="NOT FILE!!!";
//                                        $table .="<tr>";
//                                        $table .="<td style=\"text-align:right;\">";
//                                        $table .= "<b>".OW::getLanguage()->text('shoppro', 'product_table_filefordownload').":</b>";
//                                        $table .="</td>";
//                                        $table .="<td>";
//                                        $table .= "&nbsp;";
                                        $table .="<a href=\"".$curent_url."user/".$valuex['username']."\">";
                                        $table .= "<b style=\"color:#00f\">".OW::getLanguage()->text('shoppro', 'product_table_filefordownload_notexist')."</b>";
                                        $table .="</a>";
//                                        $table .="</td>";
//                                        $table .="</tr>";
                                    }
//                                    $table .="</table>";
                                }
                        $table .="</div>";
//        }//if ($valuex['id']>0 AND $valuex['id']==$value['entityId'] AND $valuex['file_attach'] AND $valuex['username']){
                            }
                    return $table;
    }


    public function email_notyfication($reciver="",$subject="",$content="")
    {
        $dname="";
        $remail="";
        $is_reviver=false;
        if (strpos($reciver,"@")!==false){
            $is_reviver="email";
        }else if ($reciver>0) {
            $is_reviver="id";
        }else{
            $is_reviver=false;
        }
        if ( $is_reviver!=false AND $content){
                    if ($is_reviver=="id"){
                        $dname=BOL_UserService::getInstance()->getDisplayName($reciver);
                        $user = BOL_UserService::getInstance()->findUserById($reciver);
                        if ($user->email){
                            $remail=$user->email;            
                        }else{
                            $is_reviver=false;
                            $remail="";
                        }
                    }else{
                        $remail=$reciver;
                    }

                    if ($is_reviver!=false AND strpos($remail,"@")!==false){
                        if (!$subject) $subject="From: ".$remail;
                        $mail = OW::getMailer()->createMail();
                        $mail->addRecipientEmail($remail);
                        $mail->setSender(OW::getConfig()->getValue('base', 'site_email'));
                        $mail->setSubject($subject);
//                        $mail->setTextContent($content);
                        $mail->setTextContent($this->html2txt($content));
                        $mail->setHtmlContent($content);

                        OW::getMailer()->send($mail);
                    }
        }
        
    }

    public function ntobr($description="")
    {
                $description=str_replace("<br />","<br/>",$description);
                $description=str_replace("<br >","<br/>",$description);
                $description=str_replace("<br>","<br/>",$description);
                $description=str_replace("<br/>","\r\n",$description);
                $description=str_replace("\r","",$description);
                $description=str_replace("\n","\r\n",$description);
                $description=str_replace("\r\n","<br/>",$description);
                $description=str_replace("\r","",$description);
                $description=str_replace("\n","<br/>",$description);
        return $description;
    }

    public function brton($pdesc="")
    {
                $pdesc=str_replace("<br />","<br/>",$pdesc);
                $pdesc=str_replace("<br >","<br/>",$pdesc);
                $pdesc=str_replace("<br>","<br/>",$pdesc);
                $pdesc=str_replace("<br/>","\r\n",$pdesc);
        return $pdesc;
    }

    public function brtospace($pdesc="")
    {
                $pdesc=str_replace("<br />"," ",$pdesc);
                $pdesc=str_replace("<br >"," ",$pdesc);
                $pdesc=str_replace("<br>"," ",$pdesc);
                $pdesc=str_replace("<br/>"," ",$pdesc);
                $pdesc=str_replace("  "," ",$pdesc);
        return $pdesc;
    }

    public function isplugin($plugname){
        if ($plugname){
            if ( OW::getPluginManager()->isPluginActive($plugname) ){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public function get_curentuser_accounttype(){
        $id_user = OW::getUser()->getId();
//        $roster_list = AJAXIM_BOL_Service::getInstance()->getSessionRosterList();
//        $roster_list = OW::getSession()->get('ajaxim.roster_list');
        $accountType = BOL_UserService::getInstance()->findUserById($id_user)->getAccountType();
//echo $roster_list[1]['accountType'];
//print_r(unserialize($roster_list));
//print_r($_SESSION);
//print_r($roster_list[1]);
//foreach ( $roster_list[1] as $item ) {
/*
foreach ( $roster_list[1] as  $item=>$value ) {
//    echo $item."--".$value."<br>";
    if ($item=="accountType") $accountType=$value;
    else if ($item=="id") $idu=$value;
    if ($idu>0 AND $accountType!="") break;
}
echo $id_user."--".$idu."--".$accountType;    
exit;
*/
/*
        $questionsService = BOL_QuestionService::getInstance();
        $userService = BOL_UserService::getInstance();

        $accountType = $userService->findUserById($userId)->getAccountType();
        $editQuestionsDtoList = $questionsService->findEditQuestionsForAccountType($accountType);

        $editQuestions = array();
        foreach ( $editQuestionsDtoList as $item )
        {
            $editQuestions[] = $item['name'];
        }
print_r($editQuestions);exit;
*/



        if ($id_user>0 AND $accountType!=""){
            return $accountType;
        }else{
            return false;
        }
    }

    public function check_acces()
    {
            if (OW::getUser()->isAdmin()){
                return true;
            }else if  (
                    ( 
                        (!OW::getConfig()->getValue('shoppro', 'mode_shop') OR OW::getConfig()->getValue('shoppro', 'mode_shop')=="all") 
                            AND 
                        (OW::getUser()->isAuthorized('shoppro', 'addshopproduct') OR OW::getUser()->isAuthorized('shoppro', 'addclassifieds') ) 
                    )OR(
                        (OW::getConfig()->getValue('shoppro', 'mode_shop')=="classifieds" AND OW::getUser()->isAuthorized('shoppro', 'addclassifieds')) 
                    )OR(
                        (OW::getConfig()->getValue('shoppro', 'mode_shop')=="shop" AND OW::getUser()->isAuthorized('shoppro', 'addshopproduct')) 
                    )
            ){
                return true;
            }else{
                return false;
            }
    }
    public function check_userrole($iduser=0,$idrole=0,$return_type="is"){//    is or id
//        if (OW::getUser()->isAuthorized('html', 'add'){
//        }
        if ($iduser>0 AND $idrole>0){
            $role=OW::getConfig()->getValue('shoppro', 'mode_member_role_cansale');
            if ($role){
                $add_role=" AND roleId IN (".addslashes($role).") ";
//            $query = "SELECT * FROM " . OW_DB_PREFIX. "base_authorization_user_role WHERE userId='".addslashes($iduser)."' AND roleId='".addslashes($idrole)."' LIMIT 1";
                $query = "SELECT * FROM " . OW_DB_PREFIX. "base_authorization_user_role WHERE userId='".addslashes($iduser)."' ".addslashes($add_role)." LIMIT 1";
//echo 
                $arrx = OW::getDbo()->queryForList($query);
                $value=$arrx[0];
                if ($value['id']>0) {
                    if ($return_type=="id"){
                        return $value['id'];
                    }else{
                        return true;
                    }
                }else return 0;
            }else{
                return 0;
            }

        }else return 0;
    }

    public function add_comment($entityType="",$entityId=0,$pluginKey="",$active=1)
    {
//entityType=photo_comment
//entityId=id_photo
            $query = "INSERT INTO " . OW_DB_PREFIX. "base_comment_entity (
                id ,     entityType,      entityId ,       pluginKey  ,     active
            )VALUES(
                '','".addslashes($entityType)."','".addslashes($entityId)."','".addslashes($pluginKey)."','".addslashes($active)."'
            )";
            $idconversation = OW::getDbo()->insert($query);
            if ($idconversation>0){
                $query = "INSERT INTO " . OW_DB_PREFIX. "base_comment_entity (
                    id ,     entityType,      entityId ,       pluginKey  ,     active
                )VALUES(
                    '','".addslashes($entityType)."','".addslashes($entityId)."','".addslashes($pluginKey)."','".addslashes($active)."'
                )";
            }

//userId='".addslashes($iduser)."' ".addslashes($add_role)." LIMIT 1";
//echo 
            $arrx = OW::getDbo()->queryForList($query);
//        base_comment_entity
    }


    public function inc_view($id_product=0)
    {
        if ($id_product>0){
            $query = "UPDATE " . OW_DB_PREFIX. "shoppro_products SET count_view=count_view+1 WHERE id='".addslashes($id_product)."' LIMIT 1";
            OW::getDbo()->query($query);
        }
    }



    public function image_resize($file_source="",$crop=false,$width=800,$height=600)
    {
        return $this->image_copy_resize($file_source,$file_source,$crop,$width,$height);
    }

    public function image_copy_resize($file_source="",$file_dest="",$crop=false,$width=800,$height=600)
    {
        if ($file_source AND $file_dest){
            $image = new UTIL_Image($file_source);
            $mainPhoto = $image ->resizeImage($width, $height,$crop) ->saveImage($file_dest);
            return true;
        }else{
            return false;
        }
    }
    public function file_copy($src="",$dest="")
    {
        if ($src AND $dest){
//                    $this->corect_exif($src);//corect orienatation
            $storage = OW::getStorage();
            return $storage->copyFile($src,$dest);
        }else{
            return false;
        }
    }

    public function file_delete($src="")
    {
        if ($src){
            $storage = OW::getStorage(); 
            if ( $storage->fileExists($src) )
            {
                $storage->removeFile($src);
            }
            return true;
        }else{
            return false;
        }
    }

    public function file_exist($src="")
    {
        if ($src){
            $storage = OW::getStorage(); 
            if ( $storage->fileExists($src) )
            {
                return true;
            }else {
                return false;
            }
        }else{
            return false;
        }
    }
    public function get_plugin_dir($plugin="")
    {
        if ($plugin){
            return OW::getPluginManager()->getPlugin($plugin)->getUserFilesDir();
        }else{
            return false;
        }
    }
    public function get_plugin_url($plugin="")
    {
        if ($plugin){
            return OW::getStorage()->getFileUrl(OW::getPluginManager()->getPlugin($plugin)->getUserFilesDir());
        }else{
            return false;
        }
    }

 public function html2txt($document){
    $search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
               '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
               '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
               '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
    );
    $text = preg_replace($search, '', $document);
        $text=preg_replace("/(&?!amp;)/i", " ", $text);
        $text=preg_replace("/(&#\d+);/i", " ", $text); // For numeric entities
        $text=preg_replace("/(&\w+);/i", " ", $text); // For literal entities
    return $text;
}


public function crop_html( $s, $srt, $len = NULL, $strict=false, $suffix = NULL )
{
    if ( is_null($len) ){ $len = strlen( $s ); }
    
    $f = 'static $strlen=0; 
            if ( $strlen >= ' . $len . ' ) { return "><"; } 
            $html_str = html_entity_decode( $a[1] );
            $subsrt   = max(0, ('.$srt.'-$strlen));
            $sublen = ' . ( empty($strict)? '(' . $len . '-$strlen)' : 'max(@strpos( $html_str, "' . ($strict===2?'.':' ') . '", (' . $len . ' - $strlen + $subsrt - 1 )), ' . $len . ' - $strlen)' ) . ';
            $new_str = substr( $html_str, $subsrt,$sublen); 
            $strlen += $new_str_len = strlen( $new_str );
            $suffix = ' . (!empty( $suffix ) ? '($new_str_len===$sublen?"'.$suffix.'":"")' : '""' ) . ';
            return ">" . htmlentities($new_str, ENT_QUOTES, "UTF-8") . "$suffix<";';
    
    return preg_replace( array( "#<[^/][^>]+>(?R)*</[^>]+>#", "#(<(b|h)r\s?/?>){2,}$#is"), "", trim( rtrim( ltrim( preg_replace_callback( "#>([^<]+)<#", create_function(
            '$a',
          $f
        ), ">$s<"  ), ">"), "<" ) ) );
}

public function crop_html2($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true) {
    if ($considerHtml) {
        // if the plain text is shorter than the maximum length, return the whole text
        if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
        }
        // splits all html-tags to scanable lines
        preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
        $total_length = strlen($ending);
        $open_tags = array();
        $truncate = '';
        foreach ($lines as $line_matchings) {
            // if there is any html-tag in this line, handle it and add it (uncounted) to the output
            if (!empty($line_matchings[1])) {
                // if it's an "empty element" with or without xhtml-conform closing slash
                if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
                    // do nothing
                // if tag is a closing tag
                } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                    // delete tag from $open_tags list
                    $pos = array_search($tag_matchings[1], $open_tags);
                    if ($pos !== false) {
                    unset($open_tags[$pos]);
                    }
                // if tag is an opening tag
                } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
                    // add tag to the beginning of $open_tags list
                    array_unshift($open_tags, strtolower($tag_matchings[1]));
                }
                // add html-tag to $truncate'd text
                $truncate .= $line_matchings[1];
            }
            // calculate the length of the plain text part of the line; handle entities as one character
            $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
            if ($total_length+$content_length> $length) {
                // the number of characters which are left
                $left = $length - $total_length;
                $entities_length = 0;
                // search for html entities
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                    // calculate the real length of all entities in the legal range
                    foreach ($entities[0] as $entity) {
                        if ($entity[1]+1-$entities_length <= $left) {
                            $left--;
                            $entities_length += strlen($entity[0]);
                        } else {
                            // no more characters left
                            break;
                        }
                    }
                }
                $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
                // maximum lenght is reached, so get off the loop
                break;
            } else {
                $truncate .= $line_matchings[2];
                $total_length += $content_length;
            }
            // if the maximum length is reached, get off the loop
            if($total_length>= $length) {
                break;
            }
        }
    } else {
        if (strlen($text) <= $length) {
            return $text;
        } else {
            $truncate = substr($text, 0, $length - strlen($ending));
        }
    }
    // if the words shouldn't be cut in the middle...
    if (!$exact) {
        // ...search the last occurance of a space...
        $spacepos = strrpos($truncate, ' ');
        if (isset($spacepos)) {
            // ...and cut the text in this position
            $truncate = substr($truncate, 0, $spacepos);
        }
    }
    // add the defined ending to the text
    $truncate .= $ending;
    if($considerHtml) {
        // close all unclosed html-tags
        foreach ($open_tags as $tag) {
            $truncate .= '</' . $tag . '>';
        }
    }
    return $truncate;
}



public function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

    public static function checkcurentlang()
    {
        $curent_language_id=0;
        if (isset($_SESSION['base.language_id']) AND $_SESSION['base.language_id']>0){
            $curent_language_id=$_SESSION['base.language_id'];
        }
        return $curent_language_id;
    }

    public function safe_content($content="",$more=1){
        $content = preg_replace("/(<iframe[^<]+<\/iframe>)/", '', $content);
        $content = preg_replace('/<script\b[^>]*>(.*?)<\/script>/i', "", $content);
        $content = preg_replace('~<\s*\bscript\b[^>]*>(.*?)<\s*\/\s*script\s*>~is', '', $content);

        $content = str_replace("'","`",$content);
        $content = str_replace("$","",$content);
//        if ($more){
//            $content=addslashes($content);
//        }
        return $content;
    }


    public function make_seo_url($name,$lengthtext=100)
    {
        $seo_sep="-";//- or _
        $seo_title=stripslashes($name);

$seo_title = preg_replace(array('/\s{2,}/', '/[\t\n]/'), $seo_sep, $seo_title);

        $seo_title=str_ireplace("_"," ",$seo_title);
        $seo_title=str_ireplace("  "," ",$seo_title);
        $seo_title=str_ireplace(" ",$seo_sep,$seo_title);
        $seo_title=str_ireplace(chr(160),$seo_sep,$seo_title);
        $seo_title=str_ireplace("~","",$seo_title);
        $seo_title=str_ireplace("(","",$seo_title);
        $seo_title=str_ireplace(")","",$seo_title);
        $seo_title=str_ireplace("]","",$seo_title);
        $seo_title=str_ireplace("[","",$seo_title);
        $seo_title=str_ireplace("}","",$seo_title);
        $seo_title=str_ireplace("{","",$seo_title);
        $seo_title=str_ireplace("/","",$seo_title);
        $seo_title=str_ireplace("\\","",$seo_title);
        $seo_title=str_ireplace("+","",$seo_title);
        $seo_title=str_ireplace(":","",$seo_title);
        $seo_title=str_ireplace(";","",$seo_title);
        $seo_title=str_ireplace("\"","",$seo_title);
        $seo_title=str_ireplace("<","",$seo_title);
        $seo_title=str_ireplace(">","",$seo_title);
        $seo_title=str_ireplace("?","",$seo_title);
        $seo_title=str_ireplace(",",".",$seo_title);
        $seo_title=str_ireplace("!","",$seo_title);
        $seo_title=str_ireplace("`","",$seo_title);
        $seo_title=str_ireplace("'","",$seo_title);
        $seo_title=str_ireplace("@","",$seo_title);
        $seo_title=str_ireplace("#","",$seo_title);
        $seo_title=str_ireplace("$","",$seo_title);
        $seo_title=str_ireplace("%","",$seo_title);
        $seo_title=str_ireplace("^","",$seo_title);
        $seo_title=str_ireplace("&","",$seo_title);
        $seo_title=str_ireplace("*","",$seo_title);
        $seo_title=str_ireplace("|","",$seo_title);
        $seo_title=str_ireplace("=","",$seo_title);
        $seo_title=str_ireplace(" ",$seo_sep,$seo_title);
        $seo_title=str_ireplace("/","",$seo_title);
        $seo_title=str_ireplace("?",$seo_sep,$seo_title);
        $seo_title=str_ireplace("#",$seo_sep,$seo_title);
        $seo_title=str_ireplace("=",$seo_sep,$seo_title);
        $seo_title=str_ireplace("=",$seo_sep,$seo_title);
        $seo_title=str_ireplace("&amp;",$seo_sep,$seo_title);
        $seo_title=str_ireplace($seo_sep.$seo_sep,$seo_sep,$seo_title);
        $seo_title=str_ireplace($seo_sep.$seo_sep,$seo_sep,$seo_title);
        $seo_title=str_ireplace($seo_sep.$seo_sep,$seo_sep,$seo_title);

        $seo_title = preg_replace('/[^(\x20-\x7F)\x0A]*/','', $seo_title);
        $seo_title =strtolower($seo_title);
        $seo_title=mb_substr($seo_title,0,100);
        return $seo_title;
    }

    public function make_seo_urlOLD($name,$lengthtext=100)
    {
        $seo_title=stripslashes($name);
        $seo_title=str_replace(" ","_",$seo_title);
        $seo_title=str_replace(chr(160),"_",$seo_title);
        $seo_title=str_replace("~","",$seo_title);
        $seo_title=str_replace("(","",$seo_title);
        $seo_title=str_replace(")","",$seo_title);
        $seo_title=str_replace("]","",$seo_title);
        $seo_title=str_replace("[","",$seo_title);
        $seo_title=str_replace("}","",$seo_title);
        $seo_title=str_replace("{","",$seo_title);
        $seo_title=str_replace("/","",$seo_title);
        $seo_title=str_replace("\\","",$seo_title);
        $seo_title=str_replace("+","",$seo_title);
        $seo_title=str_replace(":","",$seo_title);
        $seo_title=str_replace(";","",$seo_title);
        $seo_title=str_replace("\"","",$seo_title);
        $seo_title=str_replace("<","",$seo_title);
        $seo_title=str_replace(">","",$seo_title);
        $seo_title=str_replace("?","",$seo_title);
        $seo_title=str_replace(",",".",$seo_title);
        $seo_title=str_replace("!","",$seo_title);
        $seo_title=str_replace("`","",$seo_title);
        $seo_title=str_replace("'","",$seo_title);
        $seo_title=str_replace("@","",$seo_title);
        $seo_title=str_replace("#","",$seo_title);
        $seo_title=str_replace("$","",$seo_title);
        $seo_title=str_replace("%","",$seo_title);
        $seo_title=str_replace("^","",$seo_title);
        $seo_title=str_replace("&","",$seo_title);
        $seo_title=str_replace("*","",$seo_title);
        $seo_title=str_replace("|","",$seo_title);
        $seo_title=str_replace("=","",$seo_title);
        $seo_title=str_replace(" ","_",$seo_title);
        $seo_title=str_replace("/","",$seo_title);
        $seo_title=str_replace("?","_",$seo_title);
        $seo_title=str_replace("#","_",$seo_title);
        $seo_title=str_replace("=","_",$seo_title);
        $seo_title=str_replace("=","_",$seo_title);
        $seo_title=str_replace("&amp;","_",$seo_title);
        $seo_title=str_replace("__","_",$seo_title);
        $seo_title = preg_replace('/[^(\x20-\x7F)\x0A]*/','', $seo_title);
        $seo_title =strtolower($seo_title);
        $seo_title=mb_substr($seo_title,0,100);
        return $seo_title;
    }


    public function clear_text($desc="") 
    {
        return $this->clear_content($desc);
    }

    public function clear_content($desc="") 
    {
        $desc = preg_replace('/<[^>]*>/', '', $desc);
        $desc = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', strip_tags($desc) );
        return $desc;
    }

    public function clear_html($string) { 
    
    // ----- remove HTML TAGs ----- 
    $string = preg_replace ('/<[^>]*>/', ' ', $string); 

    $string = str_replace("&nbsp;", ' ', $string);    // --- replace with empty space
    
    // ----- remove control characters ----- 
    $string = str_replace("\r", '', $string);    // --- replace with empty space
     $string = str_replace("\n", ' ', $string);   // --- replace with space
     $string = str_replace("\t", ' ', $string);   // --- replace with space
     
    // ----- remove multiple spaces ----- 
    $string = trim(preg_replace('/ {2,}/', ' ', $string));
    $string = trim(preg_replace('/ {2,}/', ' ', $string));
     
    return $string; 
}



    public function get_payment_options($selected="",$cauction=0,$fmode="edit",$history_id=0){
        $content ="";
        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();
        $curent_url=OW_URL_HOME;
        $curent_lang=$this->get_curect_lang_id();
        $curent_lang_def=$this->get_system_lang_id();//default oxwall website language
        $pluginStaticURL=OW::getPluginManager()->getPlugin('auction')->getStaticUrl();

        if (!$history_id) $history_id=0;

        if (!$cauction) $cauction=0;
            if ($fmode=="show"){
                $add =" ac.active='1'  ";
            }else{
                $add=" 1 ";
                if (!$is_admin){
                    $add .=" AND ac.active='1'  ";
                }
            }

            if (($fmode=="show" OR $fmode=="show_zero" OR $fmode=="show_zero_zero") AND $history_id>0){
                $sql = "SELECT ac.*,acl.cname, aclm.cname as cname_main, ap.price_cost, ap.payment_id as payment_id_set, ap.input_text  FROM " . OW_DB_PREFIX. "shoppro_payment_avaiable ac 
            LEFT JOIN " . OW_DB_PREFIX. "shoppro_payment_avaiable_lang acl ON (ac.id_paymethod=acl.id_payment AND acl.id_lang='".addslashes($curent_lang)."') 
            LEFT JOIN " . OW_DB_PREFIX. "shoppro_payment_avaiable_lang aclm ON (ac.id_paymethod=aclm.id_payment AND aclm.id_lang='".addslashes($curent_lang_def)."') 

    LEFT JOIN " . OW_DB_PREFIX. "shoppro_purchases_history aph ON (aph.ida='".addslashes($history_id)."' AND aph.id_auction='".addslashes($cauction)."' ) 
    LEFT JOIN " . OW_DB_PREFIX. "shoppro_payment ap ON (ap.payment_id=aph.selected_payment AND ap.id_auction='".addslashes($cauction)."' ) 

                WHERE ".$add." GROUP BY ac.id_paymethod ORDER BY ac.payment_order ";
            }else{
                if ($cauction>0){
                    $sql = "SELECT ac.*,acl.cname, aclm.cname as cname_main, ap.price_cost, ap.payment_id as payment_id_set, ap.input_text FROM " . OW_DB_PREFIX. "shoppro_payment_avaiable ac 
                LEFT JOIN " . OW_DB_PREFIX. "shoppro_payment_avaiable_lang acl ON (ac.id_paymethod=acl.id_payment AND acl.id_lang='".addslashes($curent_lang)."') 
                LEFT JOIN " . OW_DB_PREFIX. "shoppro_payment_avaiable_lang aclm ON (ac.id_paymethod=aclm.id_payment AND aclm.id_lang='".addslashes($curent_lang_def)."') 
        LEFT JOIN " . OW_DB_PREFIX. "shoppro_payment ap ON (ap.payment_id=ac.id_paymethod AND ap.id_auction='".addslashes($cauction)."' ) 
                    WHERE ".$add." AND ap.payment_id>'0' GROUP BY ac.id_paymethod ORDER BY ac.payment_order ";
                }else{
                    $sql = "SELECT ac.*,acl.cname, aclm.cname as cname_main, ap.price_cost, ap.payment_id as payment_id_set, ap.input_text FROM " . OW_DB_PREFIX. "shoppro_payment_avaiable ac 
                LEFT JOIN " . OW_DB_PREFIX. "shoppro_payment_avaiable_lang acl ON (ac.id_paymethod=acl.id_payment AND acl.id_lang='".addslashes($curent_lang)."') 
                LEFT JOIN " . OW_DB_PREFIX. "shoppro_payment_avaiable_lang aclm ON (ac.id_paymethod=aclm.id_payment AND aclm.id_lang='".addslashes($curent_lang_def)."') 
        LEFT JOIN " . OW_DB_PREFIX. "shoppro_payment ap ON (ap.payment_id=ac.id_paymethod AND ap.id_auction='".addslashes($cauction)."' ) 
                    WHERE ".$add." GROUP BY ac.id_paymethod ORDER BY ac.payment_order ";
                }
            }
//echo $sql;exit;
            $arrl = OW::getDbo()->queryForList($sql);
            $def_val_price="0.00";
            $content_tmp="";
            $all_method=count($arrl);
            foreach ( $arrl as $value ){
                if ($value['cname']) $cname=$value['cname'];
                    else $cname=$value['cname_main'];
//                $content .="<o$value['cname_main'];ption value=\"".$value['id_paymethod']."\">".stripslashes($cname)."</option>";
                if ($value['payment_id_set']==$value['id_paymethod'] OR $all_method==1){
                    $sel=" CHECKED ";
                }else{
                    $sel="";
                }
                if ($value['price_cost']>0){
                    $def_val_price=$value['price_cost'];
                }else{
                    $def_val_price="0.00";
                }

                if ($value['input_text']!=""){
                    $def_input_text=stripslashes($value['input_text']);
                }else{
                    $def_input_text="";
                }

                $content_tmp.="<tr>";
                $content_tmp.="<td class=\"ow_labelX\" style=\"\">";
                $content_tmp.="<input type=\"hidden\"  name=\"paymet_options_index[]\" value=\"".$value['id_paymethod']."\">";
                if ($fmode=="show_zero" OR $fmode=="show_zero_zero"){
                    if (!$value['active']){
                        $content_tmp.="<span style=\"color:#f00;text-decoration: line-through;\">".stripslashes($cname)."</span>";
                    }else{
                        if (!$sel){
                            $content_tmp.="<span style=\"text-decoration: line-through;\">".stripslashes($cname)."</span>";
                        }else{
                            $content_tmp.="<h3>".stripslashes($cname)."</h3>";
                        }
                    }
                }else if ($fmode=="show"){
                    if (!$value['active']){
                        $content_tmp.="<input disabled ".$sel." type=\"radio\"  class=\"paymet_options_price_hide\"   name=\"paymet_options[]\" value=\"".$value['id_paymethod']."\"><span style=\"color:#f00;text-decoration: line-through;\">".stripslashes($cname)."</span>";
                    }else{
                        $content_tmp.="<input ".$sel." type=\"radio\"  class=\"paymet_options_price_hide\"   name=\"paymet_options[]\" value=\"".$value['id_paymethod']."\">".stripslashes($cname);
                    }
                }else{
                    if (!$value['active']){
                        $content_tmp.="<input disabled ".$sel." type=\"checkbox\"  class=\"paymet_options_price_hide\"   name=\"paymet_options[]\" value=\"".$value['id_paymethod']."\"><span style=\"color:#f00;text-decoration: line-through;\">".stripslashes($cname)."</span>";
                    }else{
                        $content_tmp.="<input ".$sel." type=\"checkbox\"  class=\"paymet_options_price_hide\"   name=\"paymet_options[]\" value=\"".$value['id_paymethod']."\">".stripslashes($cname);
                    }
                }
                $content_tmp.="</td>";

                $content_tmp.="<td class=\"ow_valueX\">";
                if ($value['payment_id_set']>0){
                    $hide_it=" display:inline-block; ";
                }else{
                    $hide_it=" display:none; ";
                }
                if ($fmode=="show" OR $fmode=="show_zero" OR $fmode=="show_zero_zero"){
                    $content_tmp.="<h3>".$def_val_price."</h3>";
                }else{
                    $content_tmp.="<input type=\"text\" id=\"paymet_options_price_".$value['id_paymethod']."\" name=\"paymet_options_price[".$value['id_paymethod']."]\" value=\"".$def_val_price."\" style=\"display:inline-block;max-width:50px;".$hide_it."\">";
                }
                $content_tmp.="</td>";


        if ($fmode!="show_zero_zero"){
                $content_tmp.="<td class=\"ow_valueX\">";
                if ($value['payment_id_set']>0){
                    $hide_it=" display:inline-block; ";
                }else{
                    $hide_it=" display:none; ";
                }


                $content_tmp.="<input type=\"hidden\"  name=\"paymet_input_type[".$value['id_paymethod']."]\" value=\"".$value['type_method']."\">";
//                if ($value['input_type']=="paypal"){
//                if ($value['type_method']=="paypal" AND $def_input_text){
                if ($value['type_method']=="paypal"){
                    if ($fmode=="show_zero" OR $fmode=="show_zero_zero"){
                        $content_tmp .="<div style=\"margin:0 10px 0 0px;display:inline-block;\" class=\"ow_right\">";
                            if ($value['active'] AND $sel){
                                $content_tmp .=$this->paypal_button($value);
                            }else{
//                                $content_tmp .="<img src=\"".$pluginStaticURL."btn_xpressCheckout.gif\" style=\"border:0;display:inline-block;max-width:350px;max-height:25px;\">";
                                $content_tmp .="";
                            }
                        $content_tmp .="</div>";
                    }else if ($fmode=="show"){
//                        $content_tmp.=$def_input_text;
//paypal payment
                        $content_tmp .="<div style=\"margin:0 10px 0 0px;display:inline-block;\" class=\"ow_right\">";
                            $content_tmp .="<img src=\"".$pluginStaticURL."btn_xpressCheckout.gif\" style=\"border:0;display:inline-block;max-width:350px;max-height:25px;\">";
                        $content_tmp .="</div>";
                    }else{
                        $content_tmp.="<input type=\"text\" id=\"paymet_input_text_".$value['id_paymethod']."\" name=\"paymet_input_text[".$value['id_paymethod']."]\" value=\"".$def_input_text."\" placeholder=\"".OW::getLanguage()->text('auction', 'type_your_paypal_email')."\" style=\"display:inline-block;min-width:50px;".$hide_it."\">";
                    }
                }else if ($value['type_method']=="bank"){
                    if ($fmode=="show_zero" OR $fmode=="show_zero_zero"){
                        if ($value['active'] AND $sel){
                            $content_tmp.="<h3>".$def_input_text."</h3>";
                        }else{
//                            $content_tmp.="<i>".OW::getLanguage()->text('auction', 'bank_accout_no')."</i>";
                            $content_tmp.="";
                        }
                    }else if ($fmode=="show"){
                        $content_tmp.="<i>".OW::getLanguage()->text('auction', 'bank_accout_no')."</i>";
                    }else{
                        $content_tmp.="<input type=\"text\" id=\"paymet_input_text_".$value['id_paymethod']."\" name=\"paymet_input_text[".$value['id_paymethod']."]\" value=\"".$def_input_text."\" placeholder=\"".OW::getLanguage()->text('auction', 'type_your_bank_account_number')."\" style=\"display:inline-block;min-width:50px;".$hide_it."\">";
                    }
                }else{
                    $content_tmp.="<input type=\"hidden\" id=\"paymet_input_text_".$value['id_paymethod']."\" name=\"paymet_input_text[".$value['id_paymethod']."]\" value=\"0\" style=\"display:inline-block;min-width:50px;display:none;\">";
                }
//$content_tmp.=$value['input_type'];
                $content_tmp.="</td>";
        }//        if ($fmode!="show_zero_zero"){


                $content_tmp.="</tr>";
            }
            $content.="<div class=\"clearfix\">";
//            if ($content_tmp){
                $content.="<table class=\"ow_table ow_left\" style=\"display:table;margin:auto;\">";
                $content.="<tr>";
                $content.="<th class=\"ow_labelX\" style=\"min-width:290px;\">";
                $content.=OW::getLanguage()->text('auction', 'paymet_name');
                $content.="</th>";
                $content.="<th class=\"ow_valueX\">";
                $content.=OW::getLanguage()->text('auction', 'paymet_price');
                $content.="</th>";
        if ($fmode!="show_zero_zero"){
                $content.="<th class=\"ow_valueX\">";
                $content.=OW::getLanguage()->text('auction', 'bank_account_paypal_email');
                $content.="</th>";
        }
                $content.="</tr>";
                $content.=$content_tmp;
                $content.="</table>";
//            }
            $content.="</div>";
        return $content;
    }

    public function get_delivery_options($selected="",$type="inadvence",$cauction=0,$fmode="edit",$history_id=0){//ondelivery
        $content ="";
        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();
        $curent_url=OW_URL_HOME;
        $curent_lang=$this->get_curect_lang_id();
        $curent_lang_def=$this->get_system_lang_id();//default oxwall website language

        if (!$history_id) $history_id=0;

        if (!$cauction) $cauction=0;
            if ($type=="ondelivery"){
                $add=" ac.delivery_type='ondelivery' ";
                $type="ondelivery";
            }else{
                $add=" ac.delivery_type='inadvence' ";
                $type="inadvence";
            }

            if ($fmode=="show"){
                $add .=" AND ac.active='1'  ";
            }else{
                if (!$is_admin){
                    $add .=" AND ac.active='1'  ";
                }
            }



            if (($fmode=="show" OR $fmode=="show_zero" OR $fmode=="show_zero_zero") AND $history_id>0){
                $sql = "SELECT ac.*,acl.cname, aclm.cname as cname_main,ad.price_cost, ad.delivery_id as delivery_id_set  FROM " . OW_DB_PREFIX. "shoppro_delivery_avaiable ac 
            LEFT JOIN " . OW_DB_PREFIX. "shoppro_delivery_avaiable_lang acl ON (ac.id_deliverymethod=acl.id_delivery AND acl.id_lang='".addslashes($curent_lang)."') 
            LEFT JOIN " . OW_DB_PREFIX. "shoppro_delivery_avaiable_lang aclm ON (ac.id_deliverymethod=aclm.id_delivery AND aclm.id_lang='".addslashes($curent_lang_def)."') 

    LEFT JOIN " . OW_DB_PREFIX. "shoppro_purchases_history aph ON (aph.ida='".addslashes($history_id)."' AND aph.id_auction='".addslashes($cauction)."' ) 
    LEFT JOIN " . OW_DB_PREFIX. "shoppro_delivery ad ON (ad.delivery_id=aph.selected_delivery AND ad.id_auction='".addslashes($cauction)."' ) 

                WHERE ".$add." AND ad.delivery_id>'0'  GROUP BY ac.id_deliverymethod ORDER BY ac.delivery_order ";
            }else{
                if ($cauction>0){
                $sql = "SELECT ac.*,acl.cname, aclm.cname as cname_main,ad.price_cost, ad.delivery_id as delivery_id_set  FROM " . OW_DB_PREFIX. "shoppro_delivery_avaiable ac 
            LEFT JOIN " . OW_DB_PREFIX. "shoppro_delivery_avaiable_lang acl ON (ac.id_deliverymethod=acl.id_delivery AND acl.id_lang='".addslashes($curent_lang)."') 
            LEFT JOIN " . OW_DB_PREFIX. "shoppro_delivery_avaiable_lang aclm ON (ac.id_deliverymethod=aclm.id_delivery AND aclm.id_lang='".addslashes($curent_lang_def)."') 
    LEFT JOIN " . OW_DB_PREFIX. "shoppro_delivery ad ON (ad.delivery_id=ac.id_deliverymethod AND ad.id_auction='".addslashes($cauction)."' ) 
                WHERE ".$add." AND ad.delivery_id>'0'  GROUP BY ac.id_deliverymethod ORDER BY ac.delivery_order ";
                }else{
                $sql = "SELECT ac.*,acl.cname, aclm.cname as cname_main,ad.price_cost, ad.delivery_id as delivery_id_set  FROM " . OW_DB_PREFIX. "shoppro_delivery_avaiable ac 
            LEFT JOIN " . OW_DB_PREFIX. "shoppro_delivery_avaiable_lang acl ON (ac.id_deliverymethod=acl.id_delivery AND acl.id_lang='".addslashes($curent_lang)."') 
            LEFT JOIN " . OW_DB_PREFIX. "shoppro_delivery_avaiable_lang aclm ON (ac.id_deliverymethod=aclm.id_delivery AND aclm.id_lang='".addslashes($curent_lang_def)."') 
    LEFT JOIN " . OW_DB_PREFIX. "shoppro_delivery ad ON (ad.delivery_id=ac.id_deliverymethod AND ad.id_auction='".addslashes($cauction)."' ) 
                WHERE ".$add."  GROUP BY ac.id_deliverymethod ORDER BY ac.delivery_order ";
                }
//echo $sql;
            }
//return;
            $arrl = OW::getDbo()->queryForList($sql);
            $content_tmp="";
            $all_method=count($arrl);
            foreach ( $arrl as $value ){
                if ($value['cname']) $cname=$value['cname'];
                    else $cname=$value['cname_main'];

                $def_val_price="0.00";
                $def_val_time="3";


//                if ($selected AND $selected==$value['id_deliverymethod']) $sel=" CHECKED ";
//                    else $sel="";
//                $sel="";
//echo $value['delivery_id_set']."--".$value['id_deliverymethod']."<hr>";
                if ($value['delivery_id_set']==$value['id_deliverymethod'] OR $all_method==1){
                    $sel=" CHECKED ";
                }else{
                    $sel="";
                }
                if ($value['price_cost']>0){
                    $def_val_price=$value['price_cost'];
                }else{
                    $def_val_price="0.00";
                }
//echo $def_val_price."--".$value['price_cost']."<hr>";
                if ($value['delivery_id_set']==$value['id_deliverymethod'] OR  $all_method==1){
                    $hide_it=" display:inline-block; ";
                }else{
                    $hide_it=" display:none; ";
                }


                $content_tmp.="<tr>";
                $content_tmp.="<td class=\"ow_labelX\" style=\"\">";
//$content_tmp.=$value['delivery_id_set']."-".$value['id_deliverymethod'];
                $content_tmp.="<input type=\"hidden\"  name=\"delivery_options_index[]\" value=\"".$value['id_deliverymethod']."\">";
                    if ($fmode=="show_zero" OR $fmode=="show_zero_zero"){
                        if (!$value['active']){
                            $content_tmp.="<span style=\"color:#f00;text-decoration: line-through;\">".stripslashes($cname)."</span>";
                        }else{
                            if (!$sel){
                                $content_tmp.="<span style=\"text-decoration: line-through;\">".stripslashes($cname)."</span>";
                            }else{
                                $content_tmp.="<h3>".stripslashes($cname)."</h3>";
                            }
                        }
                    }else if ($fmode=="show"){
                        if (!$value['active']){
                            $content_tmp.="<input disabled ".$sel." type=\"radio\" class=\"delivery_options_price_hide\" name=\"delivery_options[]\" value=\"".$value['id_deliverymethod']."\"><span style=\"color:#f00;text-decoration: line-through;\">".stripslashes($cname)."</span>";
                        }else{
                            $content_tmp.="<input ".$sel." type=\"radio\" class=\"delivery_options_price_hide\" name=\"delivery_options[]\" value=\"".$value['id_deliverymethod']."\">".stripslashes($cname);
                        }
                    }else{
//                $content_tmp.="<input ".$sel." type=\"checkbox\" class=\"delivery_options_price_hide\" name=\"delivery_options[".$type."][]\" value=\"".$value['id_deliverymethod']."\">".stripslashes($cname);
                        if (!$value['active']){
                            $content_tmp.="<input disabled ".$sel." type=\"checkbox\" class=\"delivery_options_price_hide\" name=\"delivery_options[]\" value=\"".$value['id_deliverymethod']."\"><span style=\"color:#f00;text-decoration: line-through;\">".stripslashes($cname)."</span>";
                        }else{
                            $content_tmp.="<input ".$sel." type=\"checkbox\" class=\"delivery_options_price_hide\" name=\"delivery_options[]\" value=\"".$value['id_deliverymethod']."\">".stripslashes($cname);
                        }
                    }
                $content_tmp.="</td>";
                $content_tmp.="<td class=\"ow_valueX\">";
                    if ($fmode=="show" OR $fmode=="show_zero" OR $fmode=="show_zero_zero"){
                        $content_tmp.="<h3>".$def_val_price."</h3>";
//                        $content_tmp.="IBAN: xxxxxxxxxxxxx..";
                    }else{
//                $content_tmp.="<input type=\"text\" id=\"delivery_options_price_".$value['id_deliverymethod']."\" name=\"delivery_options_price[".$type."][".$value['id_deliverymethod']."]\" value=\"".$def_val_price."\" style=\"display:inline-block;max-width:50px;display:none;\">";
                        $content_tmp.="<input type=\"text\" id=\"delivery_options_price_".$value['id_deliverymethod']."\" name=\"delivery_options_price[".$value['id_deliverymethod']."]\" value=\"".$def_val_price."\" style=\"max-width:50px;".$hide_it."\">";
//                $content_tmp.="<input type=\"text\" id=\"delivery_options_price_".$value['id_deliverymethod']."\" name=\"delivery_options_price[]\" value=\"".$def_val_price."\" style=\"display:inline-block;max-width:50px;display:none;\">";
                    }
                $content_tmp.="</td>";
/*
                $content_tmp.="<td class=\"ow_valueX\">";
                $hide_it=" display:none; ";
//                $content_tmp.="<input type=\"text\" id=\"delivery_options_time_".$value['id_deliverymethod']."\"  name=\"delivery_options_time[".$type."][".$value['id_deliverymethod']."]\" value=\"".$def_val_time."\" style=\"display:inline-block;max-width:50px;display:none;\">&nbsp;<span id=\"delivery_options_time_jm_".$value['id_deliverymethod']."\" style=\"display:none;\">".OW::getLanguage()->text('auction', 'days')."</span>";
                $content_tmp.="<input type=\"text\" id=\"delivery_options_time_".$value['id_deliverymethod']."\"  name=\"delivery_options_time[".$value['id_deliverymethod']."]\" value=\"".$def_val_time."\" style=\"max-width:50px;".$hide_it.";\">&nbsp;<span id=\"delivery_options_time_jm_".$value['id_deliverymethod']."\" style=\"display:none;\">".OW::getLanguage()->text('auction', 'days')."</span>";
//                $content_tmp.="<input type=\"text\" id=\"delivery_options_time_".$value['id_deliverymethod']."\"  name=\"delivery_options_time[]\" value=\"".$def_val_time."\" style=\"display:inline-block;max-width:50px;display:none;\">&nbsp;<span id=\"delivery_options_time_jm_".$value['id_deliverymethod']."\" style=\"display:none;\">".OW::getLanguage()->text('auction', 'days')."</span>";
                $content_tmp.="</td>";
*/
                $content_tmp.="</tr>";

            }
            $content.="<div class=\"clearfix\">";
            if ($content_tmp){
                $content.="<table class=\"ow_table ow_left\" style=\"display:table;margin:auto;\">";
                $content.="<tr>";
                $content.="<th class=\"ow_labelX\" style=\"min-width:290px;\">";
                if ($type=="inadvence"){
                    $content.=OW::getLanguage()->text('auction', 'delivery_inadvence');
                }else{
                    $content.=OW::getLanguage()->text('auction', 'delivery_ondelivery');
                }
                $content.="</th>";
                $content.="<th class=\"ow_valueX\">";
                $content.=OW::getLanguage()->text('auction', 'delivery_price');
                $content.="</th>";
/*
                $content.="<th class=\"ow_valueX\">";
                $content.=OW::getLanguage()->text('auction', 'delivery_time');
                $content.="</th>";
*/
                $content.="</tr>";
                $content.=$content_tmp;
                $content.="</table>";
            }
            $content.="</div>";
        return $content;
    }
//$fmode=="show_zero"



    public function make_addres($for_user=0)
    {
        $curent_url=OW_URL_HOME;
$item_sh="";
        $is_user = OW::getUser()->getId();
        $id_user =$is_user;
        $is_admin = OW::getUser()->isAdmin();
        $user_c_name="";
//        $ret .="";
        $content="";
        if (!OW::getPluginManager()->isPluginActive('cart')){
            return $content;
        }

        if (!$id_user){
            return $content;
        }


        if ($for_user>0 AND $for_user==$is_user){

            $sqlp = "SELECT * FROM " . OW_DB_PREFIX. "base_user WHERE id='".$id_user."' LIMIT 1 ";
            $arrp = OW::getDbo()->queryForList($sqlp);
            if (isset($arrp[0])){
                $user_c_name=$arrp[0]['username'];
            }else{
                return $content;
            }

//------------------ssssssssssssss

            $content="";
    $content_addres="";
    $content_delivery="";
    $content_cart="";
    $content_checkout="";
    $content_checkout_it="";
    $content_checkout_it_ar=array();
    $content_termofuse="";
$addres_fields=0;


        if (isset($_POST['action']) AND $_POST['action']=="checkoutsav" AND isset($_POST['ss']) AND $_POST['ss']==substr(session_id(),3,5)){
//----corect personal info start 

        $_POST['p_name_first']=CART_BOL_Service::getInstance()->safe_content($_POST['p_name_first']);
        $_POST['p_name_sec']=CART_BOL_Service::getInstance()->safe_content($_POST['p_name_sec']);
        $_POST['p_corporation_name']=CART_BOL_Service::getInstance()->safe_content($_POST['p_corporation_name']);
        $_POST['p_corporation_nip']=CART_BOL_Service::getInstance()->safe_content($_POST['p_corporation_nip']);
        $_POST['p_street']=CART_BOL_Service::getInstance()->safe_content($_POST['p_street']);
        $_POST['p_postcode']=CART_BOL_Service::getInstance()->safe_content($_POST['p_postcode']);
        $_POST['p_city']=CART_BOL_Service::getInstance()->safe_content($_POST['p_city']);
        $_POST['p_country']=CART_BOL_Service::getInstance()->safe_content($_POST['p_country']);
        $_POST['p_state_province']=CART_BOL_Service::getInstance()->safe_content($_POST['p_state_province']);
        $_POST['p_email']=CART_BOL_Service::getInstance()->safe_content($_POST['p_email']);
        $_POST['p_phone']=CART_BOL_Service::getInstance()->safe_content($_POST['p_phone']);
        $_POST['p_note_toseller']=CART_BOL_Service::getInstance()->safe_content($_POST['p_note_toseller']);

                $query = "INSERT INTO " . OW_DB_PREFIX. "cart_clients (
                    id , id_owner    ,    is_corporation,  name_first   ,   name_sec    ,    corporation_name  ,      
                    corporation_nip, street , postcode      ,  city  ,  country, state_province , 
                    email  , phone  , note_toseller
                )VALUES(
                    '','".addslashes($id_user)."','".addslashes($_POST['p_is_corporation'])."','".addslashes($_POST['p_name_first'])."','".addslashes($_POST['p_name_sec'])."','".addslashes($_POST['p_corporation_name'])."',
                    '".addslashes($_POST['p_corporation_nip'])."','".addslashes($_POST['p_street'])."','".addslashes($_POST['p_postcode'])."','".addslashes($_POST['p_city'])."','".addslashes($_POST['p_country'])."','".addslashes($_POST['p_state_province'])."',
                    '".addslashes($_POST['p_email'])."','".addslashes($_POST['p_phone'])."','".addslashes($_POST['p_note_toseller'])."'
                ) ON DUPLICATE KEY UPDATE  
                    is_corporation='".addslashes($_POST['p_is_corporation'])."',
                    name_first='".addslashes($_POST['p_name_first'])."'   ,   
                    name_sec='".addslashes($_POST['p_name_sec'])."'    ,    
                    corporation_name ='".addslashes($_POST['p_corporation_name'])."'  ,      
                    corporation_nip='".addslashes($_POST['p_corporation_nip'])."', 
                    street= '".addslashes($_POST['p_street'])."', 
                    postcode= '".addslashes($_POST['p_postcode'])."'     ,  
                    city ='".addslashes($_POST['p_city'])."' ,  
                    country='".addslashes($_POST['p_country'])."', 
                    state_province ='".addslashes($_POST['p_state_province'])."', 
                    email ='".addslashes($_POST['p_email'])."' , 
                    phone ='".addslashes($_POST['p_phone'])."' , 
                    note_toseller ='".addslashes($_POST['p_note_toseller'])."' ";
//echo $query;exit;
                    
                OW::getDbo()->insert($query);
                OW::getApplication()->redirect($curent_url."user/".$user_c_name);
                exit;
            
        }//if save

//----corect personal info end
$edit_mode=false;
if ( (isset($_GET['op']) AND $_GET['op']=="edcsh") OR (isset($_POST['op']) AND $_POST['op']=="edcsh") ){
    $edit_mode=true;
}


        $sqlp = "SELECT * FROM " . OW_DB_PREFIX. "cart_clients WHERE id_owner='".$id_user."' LIMIT 1 ";
        $arrp = OW::getDbo()->queryForList($sqlp);
        if (isset($arrp[0])){
            $pers=$arrp[0];
        }else{
            $pers=array();
            $pers['id']=0;
            $pers['is_corporation']="";
            $pers['name_first']="";
            $pers['name_sec']="";
            $pers['corporation_name']="";
            $pers['corporation_nip']="";
            $pers['street']="";
            $pers['postcode']="";
            $pers['city']="";
            $pers['country']="";
            $pers['state_province']="";
            $pers['email']="";
            $pers['phone']="";
            $pers['note_toseller']="";
        }




$item_sh .="<form name=\"form_cart_checkout\" id=\"form_cart_checkout\" action=\"".$curent_url."user/".$user_c_name."?op=save\" method=\"post\">";
$item_sh .="<input type=\"hidden\" name=\"ss\" value=\"".substr(session_id(),3,5)."\">";
$item_sh .="<input type=\"hidden\" name=\"action\" value=\"checkoutsav\">";
$item_sh .="<input type=\"hidden\" id=\"tp_tp\"  name=\"tp_tp\" value=\"shop\">";
//$item_sh .="<input type=\"hidden\" id=\"cid_cart_mid\" name=\"cid\" value=\"0\">";
//$item_sh .="<table id=\"cart_console_items_w\" cellspacing=\"0\" cellpadding=\"0\" style=\"border:0;\" >";


//$tabscontent['default']="1";
//$tabscontent['name']="cart";
//$tabscontent['content']=;
        //make_tabs_java($selected="",$tabscontent=array())//$tabscontent['default'],$tabscontent['name'], $tabscontent['content']


//---------personal data start



//$item_sh .="<div class=\"clearfix \">";
$item_sh .="<div class=\"clearfix ow_rightX tb_conetnt\" id=\"tc_delivery\" style=\"\">";//tb_

/*
$item_sh .="<div id=\"confirmdialog\" style=\"display:none;background:#f00;\" ><a name=\"error\"></a>
<div style=\"margin:5px;padding:3px;\">
    <center>
        <h1 style=\"margin:10px;\"><p style=\"font-weight: bold;color:#fff;text-shadow: none;\"></p></h1>
    </center>
</div>
</div>";
*/

//$content_addres .="<table class=\"ow_table_1 ow_form\" cellspacing=\"0\" cellpadding=\"0\" style=\"border:0;width:100%;\" >";

$item_sh .="<table class=\"ow_table_1 ow_form\" id=\"cart_console_items_w\" cellspacing=\"0\" cellpadding=\"0\" style=\"border:0;width:100%;\" >";
/*
$item_sh .="<tr class=\"ow_tr_first\">
        <th class=\"ow_name ow_txtleft\" colspan=\"2\">
            <span class=\"ow_section_icon ow_ic_star\">".OW::getLanguage()->text('cart', 'your_contact')."</span>
        </th>
</tr>";
*/
if ($edit_mode){
    $item_sh .="<div class=\"clearfix\" style=\"margin:10px;\">
        <div class=\"ow_right\"><a href=\"?op=ok\" class=\"ow_lbutton ow_red section_delete_button\" style=\"display: block;height:15px;\" rel=\"nofollow\">
    ".OW::getLanguage()->text('shoppro', 'edit_shop_profile_detail_back')."
    </a>
    </div>
    </div>";
}else{
    $item_sh .="<div class=\"clearfix\" style=\"margin:10px;\">
        <div class=\"ow_right\"><a href=\"?op=edcsh\" class=\"ow_lbutton ow_red section_delete_button\" style=\"display: block;height:15px;\" rel=\"nofollow\">
    ".OW::getLanguage()->text('shoppro', 'edit_shop_profile_detail')."
    </a>
    </div>
    </div>";
}


$item_sh .="<tr class=\"ow_tr_first\">
<td class=\"ow_label\">
".OW::getLanguage()->text('cart', 'is_corporation')."
</td>
<td class=\"ow_value\">";
if ($edit_mode){
//<input type=\"text\" id=\"p_is_corporation\" name=\"p_is_corporation\" value=\"".$pers['is_corporation']."\">
        $item_sh .="<select id=\"p_is_corporation\" name=\"p_is_corporation\">";
        if ($pers['is_corporation']=="" OR $pers['is_corporation']=="0") $sel=" SELECTED ";
            else $sel="";
        $item_sh .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('cart', 'im_not_corporation')."</option>";
        if ($pers['is_corporation']==1) $sel=" SELECTED ";
            else $sel="";
        $item_sh .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('cart', 'im_corporation')."</option>";
        $item_sh .="</select>";
}else{
    if ($pers['is_corporation']==1) $item_sh .="<span class=\"\">".OW::getLanguage()->text('cart', 'im_corporation')."</span>";
        else $item_sh .="<span class=\"\">".OW::getLanguage()->text('cart', 'im_not_corporation')."</span>";
}
$item_sh .="<div class=\"ow_clearfix ccd_all\" id=\"confirmdialog_p_is_corporation\" style=\"display:none;background:#f00;\" ></div>
</td>
</tr>";


if ($pers['is_corporation']=="1") $corp_form_show_class="";
    else $corp_form_show_class=" style=\"display:none;\" ";
$item_sh .="<tr class=\"ow_tr_first cart_corp\" ".$corp_form_show_class.">
<td class=\"ow_label\">
".OW::getLanguage()->text('cart', 'corporation_name')."
</td>
<td class=\"ow_value\">";
if ($edit_mode){
    $item_sh .="<input type=\"text\" id=\"p_corporation_name\" name=\"p_corporation_name\" value=\"".$pers['corporation_name']."\">";
}else{
    $item_sh .="<span class=\"\">".$pers['corporation_name']."</span>";
}
$item_sh .="<div class=\"ow_clearfix ccd_all\" id=\"confirmdialog_p_corporation_name\" style=\"display:none;background:#f00;\" ></div>";
$item_sh .="</td>
</tr>";

if ($pers['is_corporation']=="1") $corp_form_show_class="";
     else $corp_form_show_class=" style=\"display:none;\" ";
$item_sh .="<tr class=\"ow_tr_first cart_corp\" ".$corp_form_show_class.">
<td class=\"ow_label\">
".OW::getLanguage()->text('cart', 'corporation_nip')."
</td>
<td class=\"ow_value\">";
if ($edit_mode){
    $item_sh .="<input type=\"text\" id=\"p_corporation_nip\" name=\"p_corporation_nip\" value=\"".$pers['corporation_nip']."\">";
}else{
    $item_sh .="<span class=\"\">".$pers['corporation_nip']."</span>";
}
$item_sh .="<div class=\"ow_clearfix ccd_all\" id=\"confirmdialog_p_corporation_nip\" style=\"display:none;background:#f00;\" ></div>";
$item_sh .="</td>
</tr>";


$item_sh .="<tr class=\"ow_tr_first\">
<td class=\"ow_label\">
".OW::getLanguage()->text('cart', 'name_first')."
</td>
<td class=\"ow_value\">";
if ($edit_mode){
    $item_sh .="<input type=\"text\" id=\"p_name_first\" name=\"p_name_first\" value=\"".$pers['name_first']."\">";
}else{
    $item_sh .="<span class=\"\">".$pers['name_first']."</span>";
}
$item_sh .="<div class=\"ow_clearfix ccd_all\" id=\"confirmdialog_p_name_first\" style=\"display:none;background:#f00;\" ></div>";
$item_sh .="</td>
</tr>";

$item_sh .="<tr class=\"ow_tr_first\">
<td class=\"ow_label\">
".OW::getLanguage()->text('cart', 'name_sec')."
</td>
<td class=\"ow_value\">";
if ($edit_mode){
    $item_sh .="<input type=\"text\" id=\"p_name_sec\" name=\"p_name_sec\" value=\"".$pers['name_sec']."\">";
}else{
    $item_sh .="<span class=\"\">".$pers['name_sec']."</span>";
}
$item_sh .="<div class=\"ow_clearfix ccd_all\" id=\"confirmdialog_p_name_sec\" style=\"display:none;background:#f00;\" ></div>";
$item_sh .="</td>
</tr>";



$item_sh .="<tr class=\"ow_tr_first\">
<td class=\"ow_label\">
".OW::getLanguage()->text('cart', 'street')."
</td>
<td class=\"ow_value\">";
if ($edit_mode){
    $item_sh .="<input type=\"text\" id=\"p_street\" name=\"p_street\" value=\"".$pers['street']."\">";
}else{
    $item_sh .="<span class=\"\">".$pers['street']."</span>";
}
$item_sh .="<div class=\"ow_clearfix ccd_all\" id=\"confirmdialog_p_street\" style=\"display:none;background:#f00;\" ></div>
</td>
</tr>";

$item_sh .="<tr class=\"ow_tr_first\">
<td class=\"ow_label\">
".OW::getLanguage()->text('cart', 'postcode')."
</td>
<td class=\"ow_value\">";
if ($edit_mode){
    $item_sh .="<input type=\"text\" id=\"p_postcode\" name=\"p_postcode\" value=\"".$pers['postcode']."\">";
}else{
    $item_sh .="<span class=\"\">".$pers['postcode']."</span>";
}
$item_sh .="<div class=\"ow_clearfix ccd_all\" id=\"confirmdialog_p_postcode\" style=\"display:none;background:#f00;\" ></div>
</td>
</tr>";

$item_sh .="<tr class=\"ow_tr_first\">
<td class=\"ow_label\">
".OW::getLanguage()->text('cart', 'city')."
</td>
<td class=\"ow_value\">";
if ($edit_mode){
    $item_sh .="<input type=\"text\" id=\"p_city\" name=\"p_city\" value=\"".$pers['city']."\">";
}else{
    $item_sh .="<span class=\"\">".$pers['city']."</span>";
}
$item_sh .="<div class=\"ow_clearfix ccd_all\" id=\"confirmdialog_p_city\" style=\"display:none;background:#f00;\" ></div>
</td>
</tr>";

$item_sh .="<tr class=\"ow_tr_first\">
<td class=\"ow_label\">
".OW::getLanguage()->text('cart', 'country')."
</td>
<td class=\"ow_value\">";
if ($edit_mode){
    $item_sh .="<input type=\"text\" id=\"p_country\" name=\"p_country\" value=\"".$pers['country']."\">";
}else{
    $item_sh .="<span class=\"\">".$pers['country']."</span>";
}
$item_sh .="<div class=\"ow_clearfix ccd_all\" id=\"confirmdialog_p_country\" style=\"display:none;background:#f00;\" ></div>
</td>
</tr>";

$item_sh .="<tr class=\"ow_tr_first\">
<td class=\"ow_label\">
".OW::getLanguage()->text('cart', 'state_province')."
</td>
<td class=\"ow_value\">";
if ($edit_mode){
    $item_sh .="<input type=\"text\" id=\"p_state_province\" name=\"p_state_province\" value=\"".$pers['state_province']."\">";
}else{
    $item_sh .="<span class=\"\">".$pers['state_province']."</span>";
}
$item_sh .="<div class=\"ow_clearfix ccd_all\" id=\"confirmdialog_p_state_province\" style=\"display:none;background:#f00;\" ></div>
</td>
</tr>";

$item_sh .="<tr class=\"ow_tr_first\">
<td class=\"ow_label\">
".OW::getLanguage()->text('cart', 'phone')."
</td>
<td class=\"ow_value\">";
if ($edit_mode){
    $item_sh .="<input type=\"text\" id=\"p_phone\" name=\"p_phone\" value=\"".$pers['phone']."\">";
}else{
    $item_sh .="<span class=\"\">".$pers['phone']."</span>";
}
$item_sh .="<div class=\"ow_clearfix ccd_all\" id=\"confirmdialog_p_phone\" style=\"display:none;background:#f00;\" ></div>
</td>
</tr>";

$item_sh .="<tr class=\"ow_tr_first\">
<td class=\"ow_label\">
".OW::getLanguage()->text('cart', 'email')."
</td>
<td class=\"ow_value\">";
if ($edit_mode){
    $item_sh .="<input type=\"text\" id=\"p_email\" name=\"p_email\" value=\"".$pers['email']."\">";
}else{
    $item_sh .="<span class=\"\">".$pers['email']."</span>";
}
$item_sh .="<div class=\"ow_clearfix ccd_all\" id=\"confirmdialog_p_email\" style=\"display:none;background:#f00;\" ></div>
</td>
</tr>";


$item_sh .="<tr class=\"ow_tr_first\">
<td class=\"ow_label\">
".OW::getLanguage()->text('cart', 'note_toseller')."
</td>
<td class=\"ow_value\">";
if ($edit_mode){
    $item_sh .="<textarea id=\"p_note_toseller\" name=\"p_note_toseller\">".stripslashes($pers['note_toseller'])."</textarea>";
}else{
    $item_sh .="<span class=\"\">".$pers['note_toseller']."</span>";
}
$item_sh .="<div class=\"ow_clearfix ccd_all\" id=\"confirmdialog_p_note_toseller\" style=\"display:none;background:#f00;\" ></div>
</td>
</tr>";

$item_sh .="</table>";

if ($edit_mode){
                $item_sh .="<div class=\"ow_right\">
                    <span class=\"ow_button\" style=\"margin-left:5px;margin-right:5px;\">
                        <span class=\" ow_positive\">
                            <input type=\"submit\" id=\"aa\"  name=\"save_prof\" value=\"".OW::getLanguage()->text('shoppro', 'save')."\" class=\"ow_ic_save ow_positive aa\">
                        </span>
                    </span>
                </div>";
}


$item_sh .="</div>";
$item_sh .="</form>";


            $content .=$item_sh;





//---------personal data end
//----------carre addres e

        }//if ($for_user>0 AND $for_user==$is_user){
            
        
//-------------------eeeeeeeeeeeeee
        return $content;
    }


    public function make_list($for_user=0)
    {
        $curent_url=OW_URL_HOME;
        $is_user = OW::getUser()->getId();
        $id_user =$is_user;
        $is_admin = OW::getUser()->isAdmin();
//        $ret .="";
        $content="";
//echo "SdfsdF";exit;
        if ($for_user>0){

//        $content .="OK";
            $curent_lang=SHOPPRO_BOL_Service::getInstance()->get_curect_lang_id();
            $pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();
//$mode="list";
//            $mode=OW::getConfig()->getValue('shoppro', 'mode_inwidget');
//            if (!$mode) $mode="grid";
//            $maxx=OW::getConfig()->getValue('shoppro', 'max_items_inwidget');
//            if (!$maxx) $maxx=4;
            $mode="grid";
            $maxx=8;


            $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products 
            WHERE id_owner='".addslashes($for_user)."' AND active  = '1' 
            AND ( (type_ads='2' AND items>'0') OR (type_ads='1' AND items>'0') OR type_ads='0') 
            ORDER BY RAND() LIMIT ".$maxx;
//            ORDER BY id DESC, file_attach, name LIMIT ".$maxx;

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
                if ($mode=="grid"){
                    $content_list .="<div style=\"float: left;height: 140px;padding: 11px 0px;text-align: center;overflow:hidden;\">";

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
//                    $content_list .="<b style=\"color:#080;\">".OW::getLanguage()->text('shoppro', 'product_table_product_free')."</b>";
                    if (!$value['has_options']){
                        $content_list .="<b ><i>".OW::getLanguage()->text('shoppro', 'product_table_product_free_ads')."</i></b>";
                    }
                }
                $content_list .="</div>";

                    if ($product_image){
//                        $content_list .= "<div class=\"ow_box_emptyX ow_stdmarginX clearfix\"><img src=\"".$product_image."\" border=\"0\" width=\"80px\" title=\"".stripslashes($value['name'])."\" align=\"center\" style=\"margin:10px;\"></div>";
                        $content_list .= "<div class=\"ow_box_emptyX ow_stdmarginX clearfix\" style=\"max-height: 90px;\"><img src=\"".$product_image."\" border=\"0\" width=\"80px\" title=\"".stripslashes($value['name'])."\" align=\"center\" style=\"margin:10px;max-width:80px;max-height:80px;\"></div>";
                    }else{
//                        $content_list .= "<div class=\"ow_box_emptyX ow_stdmarginX clearfix\" style=\"max-height: 90px;\"><img src=\"".$product_image."\" border=\"0\" width=\"80px\" title=\"".stripslashes($value['name'])."\" align=\"center\" style=\"margin:10px;max-width:80px;max-height:80px;\"></div>";
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
//                    $content_list .="<b style=\"color:#080;\">".OW::getLanguage()->text('shoppro', 'product_table_product_free')."</b>";
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
//                $content = "<div style=\"text-align:center;\">".OW::getLanguage()->text('shoppro', 'product_table_noitems')."</div>";
            }
        }
        return $content;
    }

    public function product_action_button($value,$type="normal",$option="",$frommodetypr="shop")
    {
        $products="";
        $curent_revers=1;
        if (!isset($value) OR !is_array($value)){
            return $products;
        }

        $curent_url=OW_URL_HOME;
        $is_user = OW::getUser()->getId();
        $id_user =$is_user;
        $is_admin = OW::getUser()->isAdmin();

        $uurl=BOL_UserService::getInstance()->getUserUrl($is_user);
        $uimg=BOL_AvatarService::getInstance()->getAvatarUrl($is_user);

//$pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();
//print_r($value);exit;

                            if (OW::getConfig()->getValue('shoppro', 'mode_membercanselingbypoints')==1 AND $value['type_ads']==2 AND $value['price']>0){//------------------------------------------------------pay by credit ZOOM2

                                $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"width:100%;float:right;text-align:center;font-size:14px;display:block;margin:0px;\">";
                                $products .= "<strong>".$value['price']."<span style=\"font-size:8px;\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_credits')."</span></strong>";

                                $products .="</div>";
                                $products .="<br/>&nbsp;";

                                if ($value['active']==-1){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
                                    $products .=OW::getLanguage()->text('shoppro', 'product_table_deleted');
                                    $products .="</div>";
                                }else if ($value['active']!=1){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
                                    $products .=OW::getLanguage()->text('shoppro', 'product_table_moderation');
                                    $products .="</div>";
                                }else if (!$id_user OR $value['id_owner']!=$id_user){
//---pop tart 1zoom
                                    if (!SHOPPRO_BOL_Service::getInstance()->is_cart() OR $type=="mobile"){//aronz_credit
                                        $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window(
                                        "",
                                        $curent_url."baynowcredits/".$value['id']."_".substr(session_id(),7,6),
                                        "button",
                                        "center",
                                        "cart",
                                        OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits'),
                                        OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits'),
                                        OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information'),
                                        OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description'),
                                        OW::getLanguage()->text('shoppro', 'product_table_bayusingcreditspay'),
                                        "button",
                                        SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                                        ,$value['has_options'],$value['id'],
                                        $frommodetypr
                                        );


                                    }else{
                                        if (SHOPPRO_BOL_Service::getInstance()->is_cart() AND $type!="mobile"){
                                            $products .=SHOPPRO_BOL_Service::getInstance()->make_acccartbutton(
                                                $value['id'],$value['id_owner'],$value['name'],$value['description'],1,$value['price'],$value['curency'],'credit',$value['has_options'],$value['id']
                                            );
                                        }

                                    }//else
//---pop end 2


//---pop end 1zoom


//                                    $products .="</a>";
//                                    <input type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits')."\" class=\"ow_ic_star ow_positive\" ></span></span></div>";
                                }else{
                                    $products .="<div class=\"ow_center\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits')."</div>";
                                }


                            }else if (strlen($value['seler_account'])>6 AND $value['type_ads']==1 AND $value['price']>0){//---------------------------------------------------------------------------------------------shop ZOOM2
//echo "ssss";exit;
//print_r($value);
//$products .="fsdfsdF";
                                if (!$value['has_options']){
                                        $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"width:100%;float:right;text-align:center;display:block;margin:0px;\">";
//                                    $products .="<div style=\"text-align:center;display:block;font-size:16px;;margin:8px;\">";
                                            $products .="<strong style=\"font-size:16px;\">".$value['price']."<span style=\"font-size:9px;\">&nbsp;".$value['curency']."</span></strong>";
//                                    $products .="</div>";
                                        $products .="</div>";
                                        $products .="<br/>&nbsp;";
                                }


                                if ($value['active']==-1){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
                                    $products .=OW::getLanguage()->text('shoppro', 'product_table_deleted');
                                    $products .="</div>";
                                }else if ($value['active']!=1){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
                                    $products .=OW::getLanguage()->text('shoppro', 'product_table_moderation');
                                    $products .="</div>";
                                }else if (!$id_user OR $value['id_owner']!=$id_user){

//---pop tart 2zoom

                                    if (!SHOPPRO_BOL_Service::getInstance()->is_cart() OR $type=="mobile"){
                                        $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window(
                                            "",
                                            $curent_url."baynow/".$value['id'],
                                            "button",
                                            "center",
                                            "cart",
                                            OW::getLanguage()->text('shoppro', 'product_table_baynow'),
                                            OW::getLanguage()->text('shoppro', 'product_table_baynow'),
                                            OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information'),
                                            OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description'),
                                            OW::getLanguage()->text('shoppro', 'product_table_baynow'),
                                            "button",
                                            SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                                            ,$value['has_options'],$value['id'],
                                            $frommodetypr
                                        );

                                    }else{
                                        $products .=SHOPPRO_BOL_Service::getInstance()->make_acccartbutton(
                                            $value['id'],$value['id_owner'],$value['name'],$value['description'],1,$value['price'],$value['curency'],'shop',$value['has_options'],$value['id']
                                        );

                                    }//else

//---pop end 2zoom
//                                    $products .="</a>";                            
                                }else{
                                    $products .="<div class=\"ow_center\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_table_add_type_shop')."</div>";
                                }

                            }else if (!$value['price'] OR $value['price']==0){//----------------------------------------------------------------------------------------------------------------------------------------free ZOOM2
//echo "sfsdfSDF";exit;
                                $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"width:100%;float:right;text-align:center;display:block;margin:0px;\">";
                                    if ($value['price']>0 AND !$value['has_options']){
                                        if ($value['type_ads']==2){
                                            $products .="<strong>".$value['price']."<span style=\"font-size:8px;\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_credits')."</span></strong>";
                                        }else{
                                            $products .="<strong>".$value['price']."<span style=\"font-size:8px;\">&nbsp;".$value['curency']."</span></strong>";
                                        }
                                    }else if ((!$value['price'] OR $value['price']==0) AND !$value['has_options']){
                                        $products .="<b ><i>".OW::getLanguage()->text('shoppro', 'product_table_product_free_ads')."</i></b>";
                                    }
//                                    $products .="<strong>".$value['price']."<span style=\"font-size:8px;\">&nbsp;".$value['curency']."</span></strong>";
//                                    $products .="</div>";
                                $products .="</div>";

//                                if ($type!="mobile"){
                                    $products .="<br/>&nbsp;";
//                                }else{
//                                    $products .=" ";
//                                }

                                if (!$id_user OR $value['id_owner']!=$id_user){
//---pop tart 3zoom

                                    //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------file download
                                    if (strlen($value['file_attach'])>3){
//$curent_url."baynowproduct/".$value['id']."_".substr(session_id(),7,6),
                                        $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window(
                                            "",
                                            $curent_url."baynow/".$value['id']."_".substr(session_id(),7,6),
                                            "button",
                                            "center",
                                            "cart",
                                            OW::getLanguage()->text('shoppro', 'product_table_baynow'),
                                            OW::getLanguage()->text('shoppro', 'product_table_baynow'),
                                            OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information'),
                                            OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description'),
                                            OW::getLanguage()->text('shoppro', 'confirm_buyaction'),
                                            "button",
                                            SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                                            ,$value['has_options'],$value['id'],
                                            $frommodetypr
                                        );
//$products .=$value['file_attach']."--";
//echo "11sfsdfSDF";exit;
//$products .="bbbb";
                                    }else if (SHOPPRO_BOL_Service::getInstance()->is_cart() AND $type!="mobile"){
//$products .="aaaa";
                                        if ($value['has_options']){
                                            $products .=SHOPPRO_BOL_Service::getInstance()->make_acccartbutton(
                                                $value['id'],$value['id_owner'],$value['name'],$value['description'],1,$value['price'],$value['curency'],'clasifid',$value['has_options'],$value['id']
                                            );
                                        }

                                    //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------contact to seler
                                    }else{
//$products .="ccc";
//$products .="Dsfsdfsdf";
//$products .="fgsdfsfsdF".$value['has_options'];

/*
if ($type=="mobile"){
    $alging="right";
}else{
    $alging="center";
}
*/
    $alging="center";
                                        if ($value['has_options']){
                                            if (!$value['seler_account']){
                                                $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window(
                                                    "",
                                                    $uurl,
                                                    "button",
//                                                    "center",
                                                    $alging,
                                                    "mail",
                                                    OW::getLanguage()->text('shoppro', 'product_classifiedss'),
                                                    OW::getLanguage()->text('shoppro', 'product_classifiedss'),
                                                    OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information_mail'),
                                                    OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description_mail'),
                                                    OW::getLanguage()->text('shoppro', 'product_table_contactseler'),
                                                    "button",
                                                    SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                                                    ,$value['has_options'],$value['id'],
                                                    $frommodetypr
                                                );
                                            }else{
                                                $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window(
                                                    "",
                                                    $curent_url."baynow/".$value['id']."_".substr(session_id(),7,6),
                                                    "button",
//                                                    "center",
                                                    $alging,
                                                    "cart",
                                                    OW::getLanguage()->text('shoppro', 'product_table_baynow'),
                                                    OW::getLanguage()->text('shoppro', 'product_table_baynow'),
                                                    OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information'),
                                                    OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description'),
                                                    OW::getLanguage()->text('shoppro', 'confirm_buyaction'),
                                                    "button",
                                                    SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                                                    ,$value['has_options'],$value['id'],
                                                    $frommodetypr
                                                );
                                            }//if
                                    }else{
                                        $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window(
                                            "",
                                            $uurl,
                                            "button",
//                                            "center",
                                            $alging,
                                            "mail",
                                            OW::getLanguage()->text('shoppro', 'product_classifiedss'),
                                            OW::getLanguage()->text('shoppro', 'product_classifiedss'),
                                            OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information_mail'),
                                            OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description_mail'),
                                            OW::getLanguage()->text('shoppro', 'product_table_contactseler'),
                                            "button",
                                            SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                                            ,$value['has_options'],$value['id'],
                                            $frommodetypr
                                        );
                                    }
//$products .=$value['file_attach']."--".$uurl;
                                }


//---pop end 3zoom


//                                $products .="</a>";                            
                                }else{
                                    $products .="<div class=\"ow_center\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_table_add_type_classified')."</div>";
                                }


//-----------file end
                            }else if (strlen($value['seler_account'])<7 OR $value['type_ads']==0){//---------------------------------------------------------------------------------------------------------------classified ZOOM2


                                if ($value['price']>0){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;font-size:14px;margin:0px;\">";
                                    $products .= "<strong>".$value['price']."<span style=\"font-size:8px;\">&nbsp;".$value['curency']."</span></strong>";
                                    $products .="</div>";
                                }

                                if (!$id_user OR $value['id_owner']!=$id_user){
//---pop tart 4zoom
                                    if (!SHOPPRO_BOL_Service::getInstance()->is_cart() OR $type=="mobile"){

                                        $products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window(
                                            "",
                                            $uurl,
                                            "button",
                                            "center",
                                            "mail",
                                            OW::getLanguage()->text('shoppro', 'product_classifiedss'),
                                            OW::getLanguage()->text('shoppro', 'product_table_contactseler_claimnow'),
                                            OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information_mail'),
                                            OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description_mail'),
                                            OW::getLanguage()->text('shoppro', 'product_table_contactseler'),
                                            "button",
                                            SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
                                            ,$value['has_options'],$value['id'],
                                            $frommodetypr
                                        );

                                    }else{
                                        if (SHOPPRO_BOL_Service::getInstance()->is_cart() AND $type!="mobile"){
                                            $products .=SHOPPRO_BOL_Service::getInstance()->make_acccartbutton(
                                                $value['id'],$value['id_owner'],$value['name'],$value['description'],1,$value['price'],$value['curency'],'clasifid',$value['has_options'],$value['id']
                                            );
                                        }
                                    }//else
//---pop end 4zoom
                                }else{
                                    $products .="<div class=\"ow_center\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_table_add_type_classified')."</div>";
                                }



                            }//end types seling

// $products .="SdsdsdF";

            return $products;

    }


    public function edit_inputtext_lang_groups($nameinput="ftitle",$cgr=0,$ccat=0) 
    {

        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();
$curent_url=OW_URL_HOME;                               
    $cval="";
        if (!$ccat) $ccat=0;
        $ret="";
        if ($cgr>0 OR $cgr=="0"){
            $for_lang=SHOPPRO_BOL_Service::getInstance()->get_curect_lang_id();
            if ($is_admin){
                $add=" 1 ";
                $add_lan="";
            }else{
                $add=" status='active' ";
                $add_lan=" AND sc.active='1' ";
            }
            $sql = "SELECT * FROM " . OW_DB_PREFIX. "base_language WHERE ".$add." ORDER BY `order` ";
            $arr = OW::getDbo()->queryForList($sql);
            $lp=0;
            $was_old_lang=0;
            foreach ( $arr as $value )
            {
                $cval="";
                if ($cgr>0){

                    if ($ccat>0){
                        $sql2="SELECT scd.*,sc.name,sc.active FROM " . OW_DB_PREFIX. "shoppro_categories sc 
                        LEFT JOIN " . OW_DB_PREFIX. "shoppro_categories_description scd ON (sc.id=scd.id_product_cat AND scd.id_lang_cat='".addslashes($value['id'])."') 
                        WHERE sc.id='".addslashes($cgr)."' ".$add_lan." LIMIT 1";
//echo $sql2;exit;
                        $arr2 = OW::getDbo()->queryForList($sql2);
                            if (isset($arr2[0]) AND isset($arr2[0]['id_product_cat']) AND isset($arr2[0]['description_cat'])){
                            $cval=stripslashes($arr2[0]['description_cat']);
                        }else if (isset($arr2[0]) AND isset($arr2[0]['name'])){
                            $cval=stripslashes($arr2[0]['name']);

                        }
                    }else{
                        $sql2="SELECT scd.*,sc.namec as name,sc.activec as active FROM " . OW_DB_PREFIX. "shoppro_catgroups sc 
                        LEFT JOIN " . OW_DB_PREFIX. "shoppro_catgroups_description scd ON (sc.idc=scd.id_product_gr AND scd.id_lang_gr='".addslashes($value['id'])."') 
                        WHERE sc.idc='".addslashes($cgr)."' ".$add_lan." LIMIT 1";

////echo $sql2;exit;
                        $arr2 = OW::getDbo()->queryForList($sql2);
                        if (isset($arr2[0]) AND isset($arr2[0]['id_product_gr']) AND isset($arr2[0]['description_gr'])){
                            $cval=stripslashes($arr2[0]['description_gr']);
                        }else if (isset($arr2[0]) AND isset($arr2[0]['name'])){
                            $cval=stripslashes($arr2[0]['name']);
                        }
                    }
                }//if ($ccat>0){
                $ret .="<b>".$value['label'].":</b><br/><input type=\"text\" name=\"".$nameinput."[".$cgr."][".$value['id']."]\" value=\"".$cval."\">";
            }
        }
        return $ret;

    }

    public function make_cat_edit($selected=0,$id_langcat=0,$content="",$id2=0,$zone=0,$items=0,$type="html")
    {
        $is_admin = OW::getUser()->isAdmin();
        if ($id_langcat==0 OR !$id_langcat){
            $id_langcat=$this->checkcurentlang();
        }

        $curent_url=OW_URL_HOME;

            $add="";
//            if (!$is_admin){
//                $add=" AND cat.active='1' AND catlang.cat_name!='' AND catlang.active='1' ";
//            }

/*
        $query = "SELECT cat.*,catlang.id_cat, catlang.id_langcat,  catlang.active as cactive,  catlang.cat_name FROM `" . OW_DB_PREFIX. "doc_cat` cat 
    LEFT JOIN `" . OW_DB_PREFIX. "doc_cat_languages` catlang ON (catlang.id_cat=cat.id AND catlang.id_langcat='".addslashes($id_langcat)."' )
        WHERE cat.id2='".addslashes($id2)."' ".$add." ORDER BY cat.order_cat ";
//echo $query;
*/
            if ($is_admin){
                $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_catgroups gr 
                        ORDER BY gr.sortc, gr.namec,gr.activec DESC ";
            }else{
                $query = "SELECT gr.* FROM " . OW_DB_PREFIX. "shoppro_catgroups gr 
                    WHERE  gr.activec=1 
                        ORDER BY gr.sortc, gr.namec ";
            }
//echo $query;exit;
        $arr = OW::getDbo()->queryForList($query);
            $content="";





            foreach ( $arr as $value )
            {
            $content.="<tr>";

                    $content.="<th>";
                    $content.=OW::getLanguage()->text('shoppro', 'group_gid');
                    $content.="</th>";


                    $content.="<th>";
                    $content.=OW::getLanguage()->text('shoppro', 'group_active');
                    $content.="</th>";
/*
                    $content.="<th>";
                    $content.=OW::getLanguage()->text('shoppro', 'cat_cat');
                    $content.="</th>";
                    $content.="<th>";
                    $content.=OW::getLanguage()->text('shoppro', 'cat_languageid');
                    $content.="</th>";
*/
                    $content.="<th>";
                    $content.=OW::getLanguage()->text('shoppro', 'group_title');
                    $content.="</th>";
                    $content.="<th>";
                    $content.=OW::getLanguage()->text('shoppro', 'group_order');
                    $content.="</th>";
                    $content.="<th>";
                    $content.=OW::getLanguage()->text('shoppro', 'group_delete');
                    $content.="</th>";
                $content.="</tr>";


                $space=0;
//                $space="";
                $items++;
                $content.="<tr style=\"background-color: yellow;\">";

                    for ($i=0;$i<$zone;$i++){
//                        $space .="&nbsp;&nbsp;";
                        $space=$space+1;
                    }
//                    if ($selected>0 AND $selected==$value['id']) $sel=" SELECTED ";
//                        else $sel="";

                    $content.="<td class=\"ow_value\" style=\"text-align:center;max-width:35px;width:35px;\">";
                    $content.="<input type=\"hidden\" name=\"fidc[]\" value=\"".$value['idc']."\">";
                    $content.="<b>#".$value['idc']."</b>";
                    $content.="</td>";


                    $content.="<td style=\"text-align:center;max-width:25px;width:25px;\">";
                    if ($value['activec']==0) $sel="";
                        else $sel=" CHECKED ";
                    $content.="<input ".$sel." type=\"checkbox\" name=\"factivec[".$value['idc']."]\" value=\"1\">";
                    $content.="</td>";




//                    $content.="<td class=\"ow_value\" style=\"text-align:center;max-width:35px;width:35px;\">";
//                    $content.="<input type=\"text\" name=\"fsubcatc[".$value['idc']."]\" value=\"".stripslashes($value['id2c'])."\">";
//                    $content.="</td>";



                    $content.="<td class=\"ow_value\">";
$sp=" margin-left:".($space*20)."px; ";
//$content.=$space;
                    $content.="<div style=\"margin:0;padding:0;border:0;".$sp."\">";
//                    $content.="<input type=\"text\" name=\"ftitlec[".$value['idc']."]\" value=\"".stripslashes($value['namec'])."\">";
//edit_inputtext_lang_groups($cgr=0,$ccat=0)
                    $content.=$this->edit_inputtext_lang_groups("ftitle_gr",$value['idc'],0);//multilanguage groups



/*
if (!$value['cat_name']){
    $queryx = "SELECT * FROM `" . OW_DB_PREFIX. "doc_cat_languages` 
        WHERE id_cat='".addslashes($value['id'])."' AND cat_name!='' LIMIT 1 ";
    $arrx = OW::getDbo()->queryForList($queryx);
    if (isset($arrx[0]) AND $arrx[0]['cat_name']){
        $content.="<div style=\"font-size: 9px;line-height:9px;display:block;margin:0;pading:0;margin-top:3px;font-style:italic;\">".stripslashes($arrx[0]['cat_name'])."</div>";
    }
//echo $query;
        $arr = OW::getDbo()->queryForList($query);
}
*/
                    $content.="</div>";
                    $content.="</td>";

                    $content.="<td class=\"ow_value\" style=\"text-align:center;max-width:35px;width:35px;\">";
                    $content.="<input type=\"text\" name=\"forderc[".$value['idc']."]\" value=\"".stripslashes($value['sortc'])."\">";
                    $content.="</td>";

                    $content.="<td style=\"background-color:#f88;text-align:right;max-width:25px;width:25px;\">";
//                    $content.="<input type=\"checkbox\" name=\"fdeletec[".$value['idc']."]\" value=\"".$value['idc']."\">";
                    $content.="<input type=\"checkbox\" name=\"fdeletec[]\" value=\"".$value['idc']."\">";
                    $content.="</td>";

                $content.="</tr>";


                $content.="<tr style=\"border-bottom:1px solid #555;\">";
                    $content.="<td colspan=\"5\" style=\"padding:0;margin:0;\">";

                            $content.="<table class=\"ow_right\" style=\"width:100%;margin:auto;\">";
                                    $content.="<tr>";

                        $content.="<th>";
                        $content.=OW::getLanguage()->text('shoppro', 'cat_group');
                        $content.="</th>";
                        $content.="<th>";
                        $content.=OW::getLanguage()->text('shoppro', 'cat_active');
                        $content.="</th>";
                        $content.="<th>";
                        $content.=OW::getLanguage()->text('shoppro', 'cat_cid');
                        $content.="</th>";



                        $content.="<th>";
                        $content.=OW::getLanguage()->text('shoppro', 'cat_fsubcat');
                        $content.="</th>";

                        $content.="<th style=\"width:100%;\">";
                        $content.=OW::getLanguage()->text('shoppro', 'cat_title');
                        $content.="</th>";
                        $content.="<th>";
                        $content.=OW::getLanguage()->text('shoppro', 'cat_order');
                        $content.="</th>";
                        $content.="<th>";
                        $content.=OW::getLanguage()->text('shoppro', 'cat_delete');
                        $content.="</th>";
                            $content.="</tr>";
//$group_id=0,$first_time=true,$type="html",$selected=0,$id_langcat=0,$content="",$id2=0,$zone=0)

                        $content.=$this->make_group_cat_ul($value['idc'],true,'tr');
                            $content.="</table>";

                    $content.="</td>";
                $content.="</tr>";

                $content.="<tr>";
                    $content.="<td colspan=\"5\" style=\"height:30px;\">";
                    $content.="</td>";
                $content.="</tr>";



//                $zone++;
//                $content_tmp=$this->make_menu_dao($content,$value['id'],$zone,$items,$type);
//                $content=$this->make_cat_edit($selected,$id_langcat,$content,$value['id'],$zone,$items,$type);
//                if ($content_tmp){
//                    $content= "<ul class=\"toc\">".$content_tmp."</ul>";
//                }
//                $zone--;
            }

            return $content;
    }


/*
    public function make_product_edit_categoryOLD($selected=0,$mode="default")
    {
        $content="";
        $is_admin = OW::getUser()->isAdmin();
        if ($is_admin){
            $query = "SELECT cat.*,gr.* FROM " . OW_DB_PREFIX. "shoppro_categories cat 
                    LEFT JOIN " . OW_DB_PREFIX. "shoppro_catgroups gr ON (gr.idc=cat.id_cgroup) 
                            ORDER BY gr.sortc, gr.namec,cat.active DESC, cat.sort, cat.name";
        }else{
                    $query = "SELECT cat.*,gr.* FROM " . OW_DB_PREFIX. "shoppro_categories  cat 
                    LEFT JOIN " . OW_DB_PREFIX. "shoppro_catgroups gr ON (gr.idc=cat.id_cgroup AND gr.activec=1) 
                        WHERE  cat.active='1' AND gr.activec=1 
                            ORDER BY gr.sortc, gr.namec, cat.sort, cat.name";
        }
                    $arrc = OW::getDbo()->queryForList($query);
        $space="&nbsp;&nbsp;&nbsp;";
                    $lastgr="";
                    foreach ( $arrc as $valuec )
                    {
                        if ($lastgr!=$valuec['idc']){
                            if ($mode=="editc"){
                                $content .="<option value=\"\" disabled></option>";
                                $content .="<option value=\"".$valuec['idc']."\">[".stripslashes($valuec['namec'])."]</option>";
                            }else{
                                $content .="<option value=\"\" disabled></option>";
                                $content .="<option value=\"\" disabled>[".stripslashes($valuec['namec'])."]</option>";
                            }

                            $lastgr=$valuec['idc'];
                        }


                        if ($valuec['id']==$selected) $sel=" selected ";
                            else $sel="";
                        $content .="<option ".$sel." value=\"".$valuec['id']."\">".$space." ".stripslashes($valuec['name'])."</option>";
                    }
        return $content;
    }
*/
    public function make_product_edit_category($selected=0,$mode="default")
    {
        $content="";
        $is_admin = OW::getUser()->isAdmin();
        $curent_lang=$this->get_curect_lang_id(); 
        $curent_lang_def=$this->get_system_lang_id();

        if ($is_admin){
            $query = "SELECT gr.*,grl.description_gr ,grlm.description_gr as description_grm FROM " . OW_DB_PREFIX. "shoppro_catgroups gr 
        LEFT JOIN " . OW_DB_PREFIX. "shoppro_catgroups_description grl ON (grl.id_product_gr=gr.idc AND grl.id_lang_gr='".addslashes($curent_lang)."') 
        LEFT JOIN " . OW_DB_PREFIX. "shoppro_catgroups_description grlm ON (grlm.id_product_gr=gr.idc AND grlm.id_lang_gr='".addslashes($curent_lang_def)."') 
                ORDER BY gr.sortc, gr.namec,gr.activec DESC ";
        }else{
            $query = "SELECT  gr.*,grl.description_gr ,grlm.description_gr as description_grm  FROM " . OW_DB_PREFIX. "shoppro_catgroups gr 
        LEFT JOIN " . OW_DB_PREFIX. "shoppro_catgroups_description grl ON (grl.id_product_gr=gr.idc AND grl.id_lang_gr='".addslashes($curent_lang)."') 
        LEFT JOIN " . OW_DB_PREFIX. "shoppro_catgroups_description grlm ON (grlm.id_product_gr=gr.idc AND grlm.id_lang_gr='".addslashes($curent_lang_def)."') 
                    WHERE  gr.activec='1' 
                ORDER BY gr.sortc, gr.namec ";
        }
//echo $query;exit;
                    $arrc = OW::getDbo()->queryForList($query);
        $space="&nbsp;&nbsp;&nbsp;";
                    $lastgr="";
                    foreach ( $arrc as $valuec )
                    {
                        $name=stripslashes($valuec['description_gr']);
                        if (!$name) $name=stripslashes($valuec['description_grm']);
                        if (!$name) $name=stripslashes($valuec['namec']);
                            if ($mode=="editc"){
                                $content .="<option value=\"\" disabled></option>";
                                $content .="<option value=\"".$valuec['idc']."_0\">[G][".$name."]</option>";
                            }else{
                                $content .="<option value=\"\" disabled></option>";
                                $content .="<option value=\"\" disabled>[G][".$name."]</option>";
                            }

//                            $content .=$this->make_group_li($valuec['id'],'li',0,"",0,0,$valuec['idc']);
                            $content .=$this->make_group_cat_ul($valuec['idc'],true,'ligr',$selected);
                    }
        return $content;
    }

    public function make_group_li($selected=0,$type="html",$id_langcat=0,$content="",$id2=0,$zone=0)
    {
        if ($id_langcat==0 OR !$id_langcat){
//            $id_langcat=$this->checkcurentlang();
        }

            $curent_url=OW_URL_HOME;
        $is_user = OW::getUser()->getId();
        $is_admin = OW::getUser()->isAdmin();
$pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();

        $curent_lang=$this->get_curect_lang_id(); 
        $curent_lang_def=$this->get_system_lang_id();


            if ($is_admin){
                $query = "SELECT gr.*,grl.description_gr ,grlm.description_gr as description_grm FROM " . OW_DB_PREFIX. "shoppro_catgroups gr 
            LEFT JOIN " . OW_DB_PREFIX. "shoppro_catgroups_description grl ON (grl.id_product_gr=gr.idc AND grl.id_lang_gr='".addslashes($curent_lang)."') 
            LEFT JOIN " . OW_DB_PREFIX. "shoppro_catgroups_description grlm ON (grlm.id_product_gr=gr.idc AND grlm.id_lang_gr='".addslashes($curent_lang_def)."') 
                    ORDER BY gr.sortc, gr.namec,gr.activec DESC ";
//                $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_catgroups  
//                        ORDER BY sortc, namec";
//                        ORDER BY active DESC, sort, name";
            }else{
                $query = "SELECT  gr.*,grl.description_gr ,grlm.description_gr as description_grm  FROM " . OW_DB_PREFIX. "shoppro_catgroups gr 
            LEFT JOIN " . OW_DB_PREFIX. "shoppro_catgroups_description grl ON (grl.id_product_gr=gr.idc AND grl.id_lang_gr='".addslashes($curent_lang)."') 
            LEFT JOIN " . OW_DB_PREFIX. "shoppro_catgroups_description grlm ON (grlm.id_product_gr=gr.idc AND grlm.id_lang_gr='".addslashes($curent_lang_def)."') 
                        WHERE  gr.activec='1' 
                    ORDER BY gr.sortc, gr.namec ";
//                $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_categories 
//                    WHERE activec = '1' 
//                        ORDER BY sortc, namec";
            }
//echo $query;exit;
            $arr = OW::getDbo()->queryForList($query);
			//$value=array();
if ($type=="html"){
            $content .="<ul>";
}
            foreach ( $arr as $value )
            {
                if ($is_admin OR $value['activec']){
    //                $title=stripslashes($value['namec']);

                        $title=stripslashes($value['description_gr']);
                        if (!$title) $title=stripslashes($value['description_grm']);
                        if (!$title) $title=stripslashes($value['namec']);

                            if (OW::getConfig()->getValue('shoppro', 'max_cat_title_chars')>0){
                                $max=OW::getConfig()->getValue('shoppro', 'max_cat_title_chars');
                            }else{
                                $max=20;
                            }
                            $title=mb_substr($title,0,$max);

                    if ($type=="li"){

                            if (!$value['activec']) $notx ="-";
                                else $notx="";
                            $content .="<option value=\"".$value['idc']."\">".$notx.$title."</option>";
                    }else{
                        $content.="<li class=\"level".($zone+1)."\">";

                            $content .="<a href=\"".$curent_url."shoppro/".$value['idc']."\">";
                            if (!$value['activec']) $content .="<i style=\"color:#f00;\">";
                            $content .=$title;
                            if (!$value['activec']) $content .="</i>";
                            $content .="</a>";

                        $content.="</li>";
                    }
/*
                        $zone++;
                        $content=$this->make_menu_ul($group_id,false,$type,$selected,$id_langcat,$content,$value['idc'],$zone);
                        $zone--;
*/
                }

            }//for
if ($type=="html"){
            $content .="</ul>";
}
        return $content;
    }


    public function make_group_cat_ul($group_id=0,$first_time=true,$type="html",$selected=0,$id_langcat=0,$content="",$id2=0,$zone=0)
    {
//        if (!$group_id) return;
        if ($id_langcat==0 OR !$id_langcat){
//            $id_langcat=$this->checkcurentlang();
        }

/*
        if ($first_time){
                $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_categories 
                    WHERE id_cgroup='".addslashes($group_id)."' AND id2='0' 
                        ORDER BY sort, name";
//                        ORDER BY active DESC, sort, name";
                $arr = OW::getDbo()->queryForList($query);
                if (isset($arr[0]) AND $arr[0]['id']>0){
                    $id2=$arr[0]['id'];
                }
            $first_time=false;
        }
*/
            $curent_url=OW_URL_HOME;
        $is_user = OW::getUser()->getId();
        $is_admin = OW::getUser()->isAdmin();
$pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();

        $curent_lang=$this->get_curect_lang_id(); 
        $curent_lang_def=$this->get_system_lang_id();

            if ($is_admin){
                $query = "SELECT cat.*,gr.*, catl.description_cat, catlm.description_cat as description_catm FROM " . OW_DB_PREFIX. "shoppro_categories cat 
LEFT JOIN " . OW_DB_PREFIX. "shoppro_categories_description catl ON (catl.id_product_cat=cat.id AND catl.id_lang_cat='".addslashes($curent_lang)."') 
LEFT JOIN " . OW_DB_PREFIX. "shoppro_categories_description catlm ON (catlm.id_product_cat=cat.id AND catlm.id_lang_cat='".addslashes($curent_lang_def)."') 
                LEFT JOIN " . OW_DB_PREFIX. "shoppro_catgroups gr ON (gr.idc=cat.id_cgroup) 
                    WHERE cat.id_cgroup='".addslashes($group_id)."' AND cat.id2='".addslashes($id2)."' 
                        ORDER BY cat.sort, cat.name";
//                        ORDER BY active DESC, sort, name";
            }else{
                $query = "SELECT cat.*,gr.*,catl.description_cat, catlm.description_cat as description_catm  FROM " . OW_DB_PREFIX. "shoppro_categories cat 
LEFT JOIN " . OW_DB_PREFIX. "shoppro_categories_description catl ON (catl.id_product_cat=cat.id AND catl.id_lang_cat='".addslashes($curent_lang)."') 
LEFT JOIN " . OW_DB_PREFIX. "shoppro_categories_description catlm ON (catlm.id_product_cat=cat.id AND catlm.id_lang_cat='".addslashes($curent_lang_def)."') 
                LEFT JOIN " . OW_DB_PREFIX. "shoppro_catgroups gr ON (gr.idc=cat.id_cgroup AND gr.activec='1') 
                    WHERE cat.id_cgroup='".addslashes($group_id)."' AND  cat.id2='".addslashes($id2)."' AND cat.active  = '1' AND gr.activec='1' 
                        ORDER BY cat.sort, cat.name";
            }
//echo $query;exit;
            $arr = OW::getDbo()->queryForList($query);
			//$value=array();
if ($type=="html"){
            $content .="<ul>";
}
            foreach ( $arr as $value )
            {
                if ($is_admin OR $value['active']){
//                    $title=stripslashes($value['name']);
                        $title=stripslashes($value['description_cat']);
                        if (!$title) $title=stripslashes($value['description_catm']);
                        if (!$title) $title=stripslashes($value['name']);


                            if (OW::getConfig()->getValue('shoppro', 'max_cat_title_chars')>0){
                                $max=OW::getConfig()->getValue('shoppro', 'max_cat_title_chars');
                            }else{
                                $max=20;
                            }
                            $title=mb_substr($title,0,$max);

                    if ($type=="tr"){
                            $space ="";
                    
                            for($i=0;$i<$zone;$i++){
                                $space .="&nbsp;&nbsp;";
                            }
                        $content .="<tr>";

                        $content .="<td>";
                        $content .="<input type=\"hidden\" name=\"fid[]\" value=\"".$value['id']."\">";
                        $content .="<input type=\"text\" name=\"fgroupid[".$value['id']."]\" value=\"".stripslashes($value['id_cgroup'])."\" style=\"width: 40px;\">";
                        $content .="</div>";


                        $content .="<td>";
                        if ($value['active']==0) $sel="";
                            else $sel=" CHECKED ";
                        $content .="<input ".$sel." type=\"checkbox\" name=\"factive[".$value['id']."]\" value=\"1\">";
                        $content .="</td>";

                        $content .="<td>";
                        $content .="<b>#".$value['id']."</b>";
                        $content .="</td>";

                        $content .="<td>";
                        $content .="<input type=\"text\" name=\"fcat2[".$value['id']."]\" value=\"".stripslashes($value['id2'])."\" style=\"width: 40px;\">";
                        $content .="</td>";
                        $content .="<td>";
//                        $content .=$space;
                        $content .="<div style=\"margin-left:".($zone*20)."px;\">";


//                        $content .="<input type=\"text\" name=\"ftitle[".$value['id']."]\" value=\"".stripslashes($value['name'])."\">";
//                        $content.=$this->edit_inputtext_lang_groups($value['id'],$value['id2']);//multilanguage
                        $content.=$this->edit_inputtext_lang_groups("ftitle_cat",$value['id'],1);//multilanguage category


                        $content .="</div>";
                        $content .="</td>";
                        $content .="<td>";
                        $content .="<input type=\"text\" name=\"fsort[".$value['id']."]\" value=\"".stripslashes($value['sort'])."\" style=\"width: 40px;\">";
                        $content .="</td>";
                        $content .="<td style=\"background-color:#f88;text-align:right;max-width:25px;width:25px;\">";
//                        $content .="<input type=\"checkbox\" name=\"fdelete[".$value['id']."]\" value=\"1\">";
                        $content .="<input type=\"checkbox\" name=\"fdelete[]\" value=\"".$value['id']."\">";
                        $content .="</td>";
                        $content .="</tr>";
                    }else if ($type=="li" OR $type=="ligr"){
                            $space ="&nbsp;&nbsp;";
                            for($i=0;$i<$zone;$i++){
                                $space .="&nbsp;&nbsp;";
                            }
                            if ($type=="ligr"){
                                $opval=$value['idc']."_".$value['id'];
                            }else{
                                $opval=$value['id'];
                            }
                            if ($value['id']==$selected) $sel=" SELECTED ";
                                else $sel="";
                            if (!$value['active']) {
                                $notx ="-";
                                $content .="<option ".$sel." value=\"".$opval."\" disabled>".$space.$notx.$title."</option>";
                            }else {
                                $notx="";
                                $content .="<option ".$sel." value=\"".$opval."\">".$space.$notx.$title."</option>";
                            }
                    }else{
                        $content.="<li class=\"level".($zone+1)."\">";

                            $content .="<a href=\"".$curent_url."shoppro/".$value['id']."\">";
                            if (!$value['active']) $content .="<i style=\"color:#f00;\">";
                            $content .=$title;
                            if (!$value['active']) $content .="</i>";
                            $content .="</a>";

                        $content.="</li>";
                    }
                    $zone++;
                    $content=$this->make_group_cat_ul($value['id_cgroup'],false,$type,$selected,$id_langcat,$content,$value['id'],$zone);
                    $zone--;
                }

            }//for
if ($type=="html"){
            $content .="</ul>";
}
//echo $content;exit;
        return $content;
    }




    public function make_menu_ul_check_productexist($group_cat=0)
    {
        if ($group_cat>0 OR $group_cat=="0"){
            $timestamp=strtotime(date('Y-m-d H:i:s'));
            $add="";

if (OW::getConfig()->getValue('shoppro', 'hide_timeout_product')==1){
            $add .=" AND (pr.to_date='0' OR pr.to_date IS NULL OR pr.to_date>='".addslashes($timestamp)."') ";
}

            $query = "SELECT pr.*,po.items as poitems, po.unlimited as pounlimited, po.active as poactive  FROM " . OW_DB_PREFIX. "shoppro_products pr 
                LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_options po ON (po.id_product=pr.id AND (po.items>'0' OR po.unlimited='1') AND po.active='1' )  
            WHERE pr.cat_id='".addslashes($group_cat)."' AND pr.active='1' AND 
            (pr.items>'0' OR pr.type_ads='0') 
            ".$add." 
            AND (pr.has_options='0' OR ((po.items>'0' OR po.unlimited='1') AND po.active='1') ) 
            LIMIT 1";
//add: OR type_ads='0'
            $arr = OW::getDbo()->queryForList($query);
            if (isset($arr[0]) AND isset($arr[0]['id']) AND $arr[0]['id']>0){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }



    public function make_menu_ul($group_id=0,$first_time=true,$type="html",$selected=0,$id_langcat=0,$content="",$id2=0,$zone=0)
    {
//        if (!$group_id) return;
        if ($id_langcat==0 OR !$id_langcat){
            $id_langcat=$this->checkcurentlang();
        }

/*
        if ($first_time){
                $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_categories 
                    WHERE id_cgroup='".addslashes($group_id)."' AND id2='0' 
                        ORDER BY sort, name";
//                        ORDER BY active DESC, sort, name";
                $arr = OW::getDbo()->queryForList($query);
                if (isset($arr[0]) AND $arr[0]['id']>0){
                    $id2=$arr[0]['id'];
                }
            $first_time=false;
        }
*/
            $curent_url=OW_URL_HOME;
        $is_user = OW::getUser()->getId();
        $is_admin = OW::getUser()->isAdmin();
$pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();

if (OW::getConfig()->getValue('shoppro', 'hide_timeout_product')==1){
    
}

            if ($is_admin){
                $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_categories sc  
                    LEFT JOIN " . OW_DB_PREFIX. "shoppro_categories_description scd ON (scd.id_product_cat=sc.id AND scd.id_lang_cat='".addslashes($id_langcat)."') 
                    WHERE sc.id_cgroup='".addslashes($group_id)."' AND sc.id2='".addslashes($id2)."' 
                        ORDER BY sc.sort, sc.name";
//                        ORDER BY active DESC, sort, name";
            }else{
                $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_categories sc 
                    LEFT JOIN " . OW_DB_PREFIX. "shoppro_categories_description scd ON (scd.id_product_cat=sc.id AND scd.id_lang_cat='".addslashes($id_langcat)."') 
                    WHERE sc.id_cgroup='".addslashes($group_id)."' AND  sc.id2='".addslashes($id2)."' AND sc.active  = '1' 
                        ORDER BY sc.sort, sc.name";
            }
//echo $query;exit;
            $arr = OW::getDbo()->queryForList($query);
			//$value=array();

            $items="";
            foreach ( $arr as $value )
            {
                if ($is_admin OR $value['active']){
                    if (OW::getConfig()->getValue('shoppro', 'try_hide_empty_category')==1){
                        $has_product=$this->make_menu_ul_check_productexist($value['id']);
                    }else{
                        $has_product=true;
                    }
    if ($is_admin OR ($has_product OR $type=="li")){
                    if (isset($value['description_cat'])){
                        $title=stripslashes($value['description_cat']);
                    }else{
                        $title=stripslashes($value['name']);
                    }

                    if (OW::getConfig()->getValue('shoppro', 'max_cat_title_chars')>0){
                        $max=OW::getConfig()->getValue('shoppro', 'max_cat_title_chars');
                    }else{
                        $max=20;
                    }
                    $title=mb_substr($title,0,$max);


                    if ($type=="li"){
                            if (!$value['active']) $notx ="-";
                                else $notx="";
                            $items .="<option value=\"".$value['id']."\">".$notx.$title."</option>";
                    }else{
                        $items.="<li class=\"level".($zone+1)." shop_submenu_button_li\">";

                            $items .="<a class=\"shop_submenu_button\" href=\"".$curent_url."shoppro/".$value['id']."\">";
                            if (!$value['active'] OR !$has_product) $items .="<i style=\"color:#f00;\">";
                            $items .=$title;
                            if (!$value['active'] OR !$has_product) $items .="</i>";
                            $items .="</a>";

                        $items.="</li>";
                    }
                    $zone++;
                    $items=$this->make_menu_ul($group_id,false,$type,$selected,$id_langcat,$items,$value['id'],$zone);
                    $zone--;
    }//if ($this->make_menu_ul_check_productexist($value['id'])){
                }

            }//for

            if ($items){
if ($type=="html"){
            $content .="<ul>";
            $content .=$items;
            $content .="</ul>";
}else{
            $content .=$items;
}
            }//if ($items){
//echo $content;exit;
        return $content;
    }

    public function make_menu($selected=0)
    {
        $content="";
        $content_menu="";
        $is_user = OW::getUser()->getId();
        $is_admin = OW::getUser()->isAdmin();
        $config = OW::getConfig();
$pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();
            $pluginStaticURL =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesUrl();
            $pluginStaticDir =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesDir();

        //    if ($id_langcat==0 OR !$id_langcat){
                $id_langcat=$this->checkcurentlang();
        //    }


            $curent_url=OW_URL_HOME;
//        if (1==1){
            if ($is_admin){
                $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_catgroups  sc 
                    LEFT JOIN " . OW_DB_PREFIX. "shoppro_catgroups_description scd ON (scd.id_product_gr=sc.idc AND scd.id_lang_gr='".addslashes($id_langcat)."') 
                        ORDER BY sc.sortc, sc.namec";
//                        ORDER BY activec DESC, sortc, namec";
            }else{
                $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_catgroups sc   
                    LEFT JOIN " . OW_DB_PREFIX. "shoppro_catgroups_description scd ON (scd.id_product_gr=sc.idc AND scd.id_lang_gr='".addslashes($id_langcat)."') 
                    WHERE sc.activec  = '1' 
                        ORDER BY sc.sortc, sc.namec";
            }


            $content_menu="";
            $arr = OW::getDbo()->queryForList($query);
			//$value=array();
            $found_items=0;
            foreach ( $arr as $value )
            {

//                $groups=$this->make_menu_ul($value['idc'],true,"text");
                $groups=$this->make_menu_ul($value['idc'],true,"html");

                if ($groups OR $is_admin){

                    if (!$groups) {
                        $mcc=false;
                        $cc=" style=\"background:#f00;\" ";
                        $groups=OW::getLanguage()->text('shoppro', 'empty_add_category');
                    }else {
                        $mcc=true;
                        $cc="";
                    }

                    if (isset($value['description_gr'])){
                        $tit=stripslashes($value['description_gr']);
                    }else{
                        $tit=stripslashes($value['namec']);
                    }

                    if (!$value['activec'] OR !$mcc) $tit_m="<i style=\"color:#f00;\">".$tit."</i>";
                        else $tit_m=$tit;


                    $content_menu .="<h3>".$tit_m."</h3>";
                    $content_menu .="<div>
                        <div id=\"shop_menu_sub\" class=\"content\" ".$cc.">".$groups."</div>
                    </div>";
                    $found_items=$found_items+1;
                }
            }//foreach



        if (!$is_admin AND $found_items<1){
            return "";
        }
            if ($selected>0){
                $content .="<div class=\"clearfix\" >";
                $content .="<a href=\"".$curent_url."shop\">";
                    $content .="<div class=\"ow_left ow_ic_house\" style=\"background-repeat:no-repeat;min-width:20px;height:20px;margin:0;padding:0;;padding-left:20px\">Home</div>";
                $content .="</a>";
                $content .="</div>";
//                $content .="<hr/>";
            }

            if ($content_menu){
//                $content .="<div style=\"margin:0px;\"><ul>".$content_menu."</ul></div>";
//                  $content .="<div class=\"shoppro_menu\" id=\"css3-animated-example\" >".$content_menu."</div>";
                  $content .="<div class=\"shoppro_menu\" id=\"css3-animated-example\">".$content_menu."</div>";
            }

            if ($is_admin){
//                $content .="<hr>";
                $content .="<br/>";
//                $content .="<a href=\"".$curent_url."shoppro_adm/add/new\" title=\"".OW::getLanguage()->text('shoppro', 'menu_addnew_cat')."\">";

                $content .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">";
                    $content .="<a href=\"".$curent_url."shop/editc/".substr(session_id(),3,3)."\" title=\"".OW::getLanguage()->text('shoppro', 'menu_addnew_cat')."\">";
                        $content .="<span class=\"ow_button\">
                            <span class=\" ow_positive\">
                                <input type=\"button\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'menu_addnew_cat')."\" class=\"ow_ic_add ow_positive\">
                            </span>
                        </span>";
                    $content .="</a>";
                $content .="</div>
                </div>";
                

            }


/*
    $content .="
      <div class=\"shoppro_menu\" id=\"css3-animated-example\">
        <h3>Hello</h3>
        <div>
          <div class=\"content\">
            <p>This example simply sets a class attribute to the details and let's an
            external stylesheet toggle the collapsed state.</p>
            <p>Hello Sir.</p>
            <p>I'm sliding</p>
          </div>
        </div>
        <h3>Friend</h3>
        <div>
          <div class=\"content\">
            <p>This example simply sets a class attribute to the details and let's an
            external stylesheet toggle the collapsed state.</p>
            <p>Hello Sir.</p>
          </div>
        </div>
        <h3>Foe</h3>
        <div>
          <div class=\"content\">
            <p>This example simply sets a class attribute to the details and let's an
            external stylesheet toggle the collapsed state.</p>
          </div>
        </div>
      </div>";
*/

/*
$color_from="#e40a55";
//$color_to="#e4246f";
$color_to="#555";

$color_open="#ff4678";
$color_close="#ff4678";

$color_hover="#e40a55";

$text_color="#fff";
$text_shadow_h2="#fff";
$text_shadow="#800a55";
*/
//$color_from="#a5a5a5";
$color_from=$config->getValue('shoppro', 'menu_colbut_color_from');
//$color_to="#e2e2e2";
$color_to=$config->getValue('shoppro', 'menu_colbut_color_to');

//$color_open="#e0dadc";
$color_open=$config->getValue('shoppro', 'menu_colbut_color_open');
    $color_close="#e0dadc";
//$color_hover="#e0dadc";
$color_hover=$config->getValue('shoppro', 'menu_colbut_color_hover');

//$text_color="#333";
$text_color=$config->getValue('shoppro', 'menu_colbut_color_text');
    $text_shadow_h2="#fff";
//$text_shadow="#7c777a";
$text_shadow=$config->getValue('shoppro', 'menu_colbut_color_shadow');


$text_open_tab=$this->hex2rgb($color_open);

$st_shadow="";
//$st_shadow="text-shadow: 1px 1px 1px ".$text_shadow.";";

$st_fontsize="font-size:85%;";

//$st_showlipoint="margin-left:8px;";
$st_showlipoint="list-style-type:disc; margin-left:8px;";

//$st_background_color_button="#fafafa";
$st_background_color_button=$config->getValue('shoppro', 'menu_colbut_sub_menu_bg');
$background_color_menu=$config->getValue('shoppro', 'menu_colbut_bg_color');
if ($background_color_menu){
    $background_color_menu=".shoppro_menu{background-color: ".$background_color_menu.";}";
}else{
    $background_color_menu="";
}

$st_ulli="margin-left: 0;padding-left: 0;";
$st_ulli.="margin-bottom: 10px;background-color: ".$st_background_color_button.";";

/*
#shop_menu_sub ul{
    margin-left:5px;
}

*/

$css="
<style>
".$background_color_menu."
.shoppro_menu .shop_submenu_button{
    width:100%;
    margin:auto;
    display:block;

}


.shoppro_menu h1 {
  border-bottom: 1px solid #333;
  font-size: 32px;
  color: #fff;
  padding-bottom: 12px;
  text-shadow: 0px 0px 2px rgba(0,0,0,0.6);
}

.shoppro_menu h2 {
  margin: 10px 0;
  color: #000;
  font-size: 18px;
  text-shadow: 1px 1px 2px ".$text_shadow_h2.";
}

.shoppro_menu h3 {
  margin: 0;
    line-height: 14px;
  background-color: ".$color_from."; 
  background-image: linear-gradient(bottom, ".$color_from." 14%, ".$color_to." 57%);
  background-image: -o-linear-gradient(bottom, ".$color_from." 14%, ".$color_to." 57%);
  background-image: -moz-linear-gradient(bottom, ".$color_from." 14%, ".$color_to." 57%);
  background-image: -webkit-linear-gradient(bottom, ".$color_from." 14%, ".$color_to." 57%);
  background-image: -ms-linear-gradient(bottom, ".$color_from." 14%, ".$color_to." 57%);
}

.shoppro_menu .content ul {
    padding: 0; 
    margin: 0; 
    ".$st_showlipoint."
}
.shoppro_menu .content ul li{
    margin:-5px;
    padding:0;
    font-size:100%;
    ".$st_ulli."
}

.shoppro_menu h3 a {
  background: url(\"".OW_URL_HOME."ow_static/plugins/shoppro/m/sprite.png\") 15px 10px no-repeat;
  display: block;
  padding: 10px;
  padding-left: 32px;
  margin: 0;
  color: ".$text_color.";
  text-decoration: none;
  font-weight: normal;
  border-bottom: 1px solid rgba(".$text_open_tab['0'].", ".$text_open_tab['1'].", ".$text_open_tab['2'].", 0.5);
    ".$st_shadow."
    ".$st_fontsize."
}
.shoppro_menu h3:hover { background: ".$color_hover."; }
.shoppro_menu h3.open  { background: ".$color_open."; }
/*.shoppro_menu h3.close  { background: ".$color_close."; } */
.shoppro_menu h3.open a { background-position: 13px -28px; }
.shoppro_menu h3 + div { padding: 10px; }

.shoppro_menu h2 + div,.shoppro_menu .example {
/*  background: #fff; */
  overflow: hidden;
  border-radius: 3px;
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
  margin-bottom: 20px;
}

.shoppro_menu h3+div {
  display: none;
}

#css3-animated-example h3 + div {
  height: 0px;
  padding: 0px;
  overflow: hidden;
/*  background: #000; */
  display: block!important;
  -webkit-transform: translateZ(0);
  -webkit-transition: all 0.3s ease;
	-moz-transition: all 0.3s ease;
	-o-transition: all 0.3s ease;
	-ms-transition:all 0.3s ease;
	transition: all 0.3s ease;
}
#css3-animated-example .content {
  padding: 10px;
}

#css3-animated-example h3.open + div {
  height: auto;
/*  background: #aaffff;*/
}

.shoppro_menu pre#event-log {
  background: #fafacc;
  padding: 10px;
  display: block;
}

.shoppro_menu @media screen and (max-width: 1056px) {
 .shoppro_menu  .c2 {
    margin-right: 0;
    margin-bottom: 0;
  }
}

.shoppro_menu @media only screen and (max-width: 704px), only screen and (-webkit-min-device-pixel-ratio : 1.5), only screen and (min-device-pixel-ratio : 1.5) {
  .shoppro_menu .c1 {
    margin-right: 0;
    margin-bottom: 0;
  }
  .shoppro_menu h1 {
    font-size: 28px;
    text-shadow: 0px 0px 1px rgba(0,0,0,0.7);
  }
}

.shoppro_menu @media only screen and (-webkit-min-device-pixel-ratio : 1.5), only screen and (min-device-pixel-ratio : 1.5) {
}





</style>

";

//    $content .=$css;
OW::getDocument()->appendBody($css);


            return $content;
    }

    public function make_menuOLD($selected=0)//not used
    {
        $content="";
        $content_menu="";
        $is_user = OW::getUser()->getId();
        $is_admin = OW::getUser()->isAdmin();
$pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();
            $pluginStaticURL =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesUrl();
            $pluginStaticDir =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesDir();

            $curent_url=OW_URL_HOME;
//        if (1==1){
            if ($is_admin){
                $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_categories 
                        ORDER BY active DESC, sort, name";
            }else{
                $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_categories 
                        WHERE active  = '1' ORDER BY sort, name";
            }


            $content_menu="";
            $arr = OW::getDbo()->queryForList($query);
			//$value=array();
            foreach ( $arr as $value )
            {
                if ($is_admin){
                    $content_menu .="<li style=\"list-style-type:none;list-style-position: inside;\">";
                }else{
                    $content_menu .="<li style=\"list-style-position: inside;list-style-type: disc;\">";
                }

                if ($is_admin){
/*
//                    $content_menu .="&nbsp;&nbsp;";
                    $content_menu .="<a href=\"".$curent_url."shoppro_adm/del/".$value['id']."\" onclick=\"return confirm('Are you sure you want to delete?');\"   title=\"".OW::getLanguage()->text('shoppro', 'menu_delete_cat')."\">";
                    $content_menu .="<b style=\"color:#f00;\">[-]</b>";
                    $content_menu .="</a>";
//                    $content_menu .="&nbsp;|&nbsp;";
                    $content_menu .="<a href=\"".$curent_url."shoppro_adm/edit/".$value['id']."\" title=\"".OW::getLanguage()->text('shoppro', 'menu_edit_cat')."\">";
                    $content_menu .="<b style=\"color:#080;\">[*]</b>";
                    $content_menu .="</a>";
*/
//        $content_menu .="<span style=\"\" class=\"ow_nowrap\">";
            $content_menu .="<a href=\"".$curent_url."shoppro_adm/edit/".$value['id']."\" title=\"".OW::getLanguage()->text('shoppro', 'menu_edit_cat')."\"><img src=\"".$pluginStaticURL2."edit3.gif\" style=\"border:0;max-width:14px;\"></a>";
//        $content_menu .="</span>";
            $content_menu .="&nbsp;";
//        $content_menu .="<span style=\"\" class=\"ow_nowrap\">";
            $content_menu .="<a onclick=\"return confirm('Are you sure you want to delete?');\" href=\"".$curent_url."shoppro_adm/del/".$value['id']."\"><img src=\"".$pluginStaticURL2."erase3.gif\" title=\"".OW::getLanguage()->text('shoppro', 'menu_delete_cat')."\" style=\"border:0;max-width:14px;\"></a>";
//        $content_menu .="</span>";
            $content_menu .="&nbsp;";
                }

                $content_menu .="<a href=\"".$curent_url."shoppro/".$value['id']."\">";
                if (!$value['active']) $content_menu .="<i style=\"color:#f00;\">";
                $title=stripslashes($value['name']);
                if (OW::getConfig()->getValue('shoppro', 'max_cat_title_chars')>0){
                    $max=OW::getConfig()->getValue('shoppro', 'max_cat_title_chars');
                }else{
                    $max=20;
                }
                $title=mb_substr($title,0,$max);
                $content_menu .=$title;
                if (!$value['active']) $content_menu .="</i>";
                $content_menu .="</a>";



                $content_menu .="</li>";

            }

            if ($is_admin){
//                $content .="<a href=\"".$curent_url."shoppro_adm/add/new\" title=\"".OW::getLanguage()->text('shoppro', 'menu_addnew_cat')."\">";
//                $content .="<b style=\"color:#f00;\">[+]&nbsp;".OW::getLanguage()->text('shoppro', 'menu_addnew_cat')."</b>";
//                $content .="</a>";
            $content .="<a href=\"".$curent_url."shoppro_adm/add/new\" title=\"".OW::getLanguage()->text('shoppro', 'menu_addnew_cat')."\">";
            $content .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"button\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'menu_addnew_cat')."\" class=\"ow_ic_add ow_positive\">
                        </span>
                    </span>
                </div>
            </div>";
                $content .="</a>";
                $content .="<hr>";
            }

            if ($content_menu){
                $content .="<div style=\"margin:0px;\"><ul>".$content_menu."</ul></div>";
            }
            return $content;
    }


    public function tonewsfeed($type="create", $message="",$paramto=0,$toowner=0 )
    {


        $config = OW::getConfig();

        $message=$this->html2txt($message);

        $curent_url=OW_URL_HOME;
        $is_user = OW::getUser()->getId();
//echo "OK:".$type."--".$message."--".$paramto;exit;

        

        if (!$is_user OR ($type=="comment" AND (!$paramto OR $paramto=="0")) ){
            return;
        }
        if ($type=="comment" AND $paramto>0){
            $action = NEWSFEED_BOL_Service::getInstance()->findActionById($paramto);
            if (empty($action)){
                return;
            }else{
                $entityId=$action->entityId;
            }
        }else{
            $entityId="";
        }


                    $timestamp=strtotime(date('Y-m-d H:i:s'));
                    $comm_entid="";
                    if ($type=="create"){
                                $sql2="DELETE FROM " . OW_DB_PREFIX. "newsfeed_status WHERE feedType='user' AND feedId='".addslashes($is_user)."' LIMIT 1";
                                OW::getDbo()->delete($sql2);

                                $sql2="INSERT INTO " . OW_DB_PREFIX. "newsfeed_status (
                                    id , feedType   ,     feedId,  timeStamp   ,    status
                                )VALUES(
                                    '','user','".$is_user."','".addslashes($timestamp)."','".addslashes($message)."'
                                )";
//                                $last_id_news=OW::getDbo()->insert($sql2);
                                $entityId=OW::getDbo()->insert($sql2);

                    }


                    if ($entityId>0 OR $type=="comment"){
                        $last_action_id=0;
                            if ($type=="create"){
                                $array=array(
                                    "content" => "".$message." [ph:attachment]",
                                    "view" => array("iconClass" => "ow_ic_comment"),
                                    "attachment" => array("oembed" => "null", "url"=>"null","attachId"=>"null"),
                                    "data" => array("userId"=>"".$is_user."","status"=>"".$message.""),
                                    "actionDto"=>"null"
                                );
//
                                $datadata=json_encode($array);

                                $sql="INSERT INTO " . OW_DB_PREFIX. "newsfeed_action (
                                    `id` ,     `entityId`      ,  `entityType`   ,   `pluginKey`    ,   `data`
                                )VALUES(
                                    '','".$entityId."','user-status','newsfeed','".addslashes($datadata)."'
                                )";
                                $last_action_id = OW::getDbo()->insert($sql);
                            }else if ($paramto>0){
                                $last_action_id=$paramto;
                            }



//echo "sss";exit;
                            if ($last_action_id>0 OR $type=="comment"){

                                if ($type=="comment" AND $paramto>0 AND $entityId>0){
                                            $sql="SELECT * FROM " . OW_DB_PREFIX. "base_comment_entity WHERE entityId='".addslashes($entityId)."' LIMIT 1";
                                            $arr = OW::getDbo()->queryForList($sql);
                                            $commentEntityId="";
                                            if (isset($arr[0])){
                                                $val=$arr[0];
                                                $commentEntityId=$val['id'];
                                                if (!$commentEntityId) $commentEntityId=0;
                                            }

                                            if (!$commentEntityId){
//BOL_CommentService::getInstance()->addComment($params->getEntityType(), $params->getEntityId(), $params->getPluginKey(), OW::getUser()->getId(), $commentText, $attachment);

                                                $sql="INSERT INTO " . OW_DB_PREFIX. "base_comment_entity (
                                                    id  ,    entityType     , entityId      ,  pluginKey  ,     active
                                                )VALUES(
                                                    '','user-status','".addslashes($entityId)."','newsfeed','1'
                                                )";

                                                $commentEntityId = OW::getDbo()->insert($sql);

                                            }

//echo $sql."---ssS---".$entityId;exit;
                                            $sql="INSERT INTO " . OW_DB_PREFIX. "base_comment (
                                                id  ,    userId , commentEntityId ,message, createStamp   ,  attachment
                                            )VALUES(
                                                '','".$is_user."','".addslashes($commentEntityId)."','".addslashes($message)."','".addslashes($timestamp)."',NULL
                                            )";
                                            $last_id_comment = OW::getDbo()->insert($sql);//11

                                        if ($last_id_comment>0){    
                                            $array=array(
                                                "commentId" => (int)$paramto,
                                                "string" => OW::getLanguage()->text('mobille', 'commented_status')
                                            );
                                            $datadata=json_encode($array);
    
                                        }else {
                                            $array=array();
                                            $datadata=json_encode($array);
                                        }

//echo $datadata;exit;


                                }else{
                                    $array=array();
                                    $datadata=json_encode($array);
                                }

//echo "ssssssssssss";exit;
                                $last_id_activity1=0;
                                $last_id_activity2=0;
                                $last_id_activity3=0;
                                if ($type=="create"){
                                    $sql="INSERT INTO " . OW_DB_PREFIX. "newsfeed_activity (
                                        `id`,      `activityType`   , `activityId` ,     `userId` , 
                                        `data` ,   `actionId`     ,   `timeStamp`  ,     `privacy` ,`visibility`   ,   `status`
                                    )VALUES(
                                        '','".addslashes($type)."','".$is_user."','".$is_user."',
                                        '".addslashes($datadata)."','".addslashes($last_action_id)."','".addslashes($timestamp)."','everybody','15','active'
                                    )";
                                    $last_id_activity1 = OW::getDbo()->insert($sql);
                                    $sql="INSERT INTO " . OW_DB_PREFIX. "newsfeed_activity (
                                        `id`,      `activityType`   , `activityId` ,     `userId` , 
                                        `data` ,   `actionId`     ,   `timeStamp`  ,     `privacy` ,`visibility`   ,   `status`
                                    )VALUES(
                                        '','subscribe','".$is_user."','".$is_user."',
                                        '".addslashes($datadata)."','".addslashes($last_action_id)."','".addslashes($timestamp)."','everybody','15','active'
                                    )";
                                    $last_id_activity2 = OW::getDbo()->insert($sql);

                                }else  if ($type=="comment" OR $last_id_comment>0){
                                    $sql="INSERT INTO " . OW_DB_PREFIX. "newsfeed_activity (
                                        `id`,      `activityType`   , `activityId` ,     `userId` , 
                                        `data` ,   `actionId`     ,   `timeStamp`  ,     `privacy` ,`visibility`   ,   `status`
                                    )VALUES(
                                        '','".addslashes($type)."','".$last_id_comment."','".$is_user."',
                                        '".addslashes($datadata)."',
                                        '".addslashes($last_action_id)."','".addslashes($timestamp)."','everybody','15','active'
                                    )";
                                    $last_id_activity3 = OW::getDbo()->insert($sql);

                                }

//                                    if ( ($last_id_activity1>0 AND $last_id_activity2>0) OR $last_id_activity3>0){
                                    if ( $last_id_activity1>0 AND $last_id_activity2>0){//create
                                        $sql="INSERT INTO " . OW_DB_PREFIX. "newsfeed_action_feed (
                                                id ,     feedType    ,    feedId , activityId
                                        )VALUES(
                                                '','user','".addslashes($is_user)."','".addslashes($last_id_activity1)."'
                                        )";
                                        $last_id_feed1 = OW::getDbo()->insert($sql);
                                        $sql="INSERT INTO " . OW_DB_PREFIX. "newsfeed_action_feed (
                                                id ,     feedType    ,    feedId , activityId
                                        )VALUES(
                                                '','user','".addslashes($is_user)."','".addslashes($last_id_activity2)."'
                                        )";
                                        $last_id_feed2 = OW::getDbo()->insert($sql);

//                                        if ($type=="comment" OR $last_id_comment>0){
//                                            MOBILLE_BOL_Service::getInstance()->tonotyficat($last_id_comment,$timestamp);
//                                        }

                                    }else if ($last_id_activity3>0){//commnt
                                        $sql="INSERT INTO " . OW_DB_PREFIX. "newsfeed_action_feed (
                                                id ,     feedType    ,    feedId , activityId
                                        )VALUES(
                                                '','user','".addslashes($is_user)."','".addslashes($last_id_activity3)."'
                                        )";
                                        $last_id_feed3 = OW::getDbo()->insert($sql);

//                                        if ($type=="comment" AND $toowner>0){
                                        if ($type=="comment" AND $toowner>0 AND $last_id_comment>0){
//    public function tonotyficat($idtype=0,$timestamp="",$status="status_comment",$act="newsfeed-status_comment",$plugin="newsfeed" )
//                                            MOBILLE_BOL_Service::getInstance()->tonotyficat($last_id_comment,$timestamp);
////////TODO                                            $this->tonotyficat($toowner,$last_id_comment,$timestamp,'status_comment','newsfeed-status_comment','newsfeed');

//tonotyficat
//                                                       ($toowner,$last_id_comment,$timestamp,'status_comment','newsfeed-status_comment','newsfeed');
//                                                ($toowner=0,$idtype=0,$timestamp="",$status="status_comment",$act="newsfeed-status_comment",$plugin="newsfeed" )
//                                                    ($toowner=0,$idtype=0,$timestamp="",$status="status_comment",$act="newsfeed-status_comment",$plugin="newsfeed",$obj_title="...",$obj_url="" )
///////SHOPPRO_BOL_Service::getInstance()->SHOPPRO_BOL_Service::getInstance()->tonotyficat($valuep2['id_owner'],$valuep2['id'],"","shop-wasbuy","shop-wasbuy","shoppro",addslashes(mb_substr(stripslashes($valuep2['name']),0,50)),$curent_url."product/".$valuep2['id']."/zoom/product.html");

                                        }

                                    }
                                

                            }


                    }//if ($entityId>0){
    }

    
    public function move_credits($from=0,$to=0,$add_to_user_for_sale=0)
    {
        $is_user = OW::getUser()->getId();
        $is_admin = OW::getUser()->isAdmin();
        if (!$from) $from=$is_user;
//echo $is_user."--".$from."--".$to."--".$add_to_user_for_sale;
        if ($is_user>0 AND $from>0 AND $to>0 AND $add_to_user_for_sale>0 AND ($is_admin OR $is_user!=$to)){
            $timeStamp=strtotime(date('Y-m-d H:i:s'));

//-------start
            if ($this->isplugin('usercredits')){

                    $query2 = "SELECT * FROM " . OW_DB_PREFIX. "usercredits_balance WHERE userId='".addslashes($from)."' LIMIT 1";
                    $arrp2 = OW::getDbo()->queryForList($query2);
                    if (isset($arrp2[0])) {
                        $valuep2=$arrp2[0];
                        if ($valuep2['balance']>=$add_to_user_for_sale){
/*
                                if ($from!=$to){
                                    $query = "INSERT INTO " . OW_DB_PREFIX. "usercredits_balance (id ,   userId , balance)VALUES ('','".addslashes($from)."','".addslashes($add_to_user_for_sale)."') 
                                    ON DUPLICATE KEY UPDATE balance=balance+".addslashes($add_to_user_for_sale); 
                                    OW::getDbo()->query($query);
//---log credits strat
                                    $query = "INSERT INTO " . OW_DB_PREFIX. "usercredits_log (
                                        id ,     userId,  actionId     ,   amount , logTimestamp
                                    )VALUES(
                                        '','".addslashes($from)."','23','".addslashes($add_to_user_for_sale)."','".addslashes($timeStamp)."'
                                    )";//recive:23
                                    OW::getDbo()->insert($query);
//---log credits end
                                }
*/
//-------------end

                                $query = "UPDATE " . OW_DB_PREFIX. "usercredits_balance SET balance=balance-".addslashes($add_to_user_for_sale)." WHERE userId='".addslashes($from)."' LIMIT 1";
                                OW::getDbo()->query($query);
//                                $query = "UPDATE " . OW_DB_PREFIX. "usercredits_balance SET balance=balance+".addslashes($add_to_user_for_sale)." WHERE userId='".addslashes($to)."' LIMIT 1";
//                                OW::getDbo()->query($query);

                                    $query = "INSERT INTO " . OW_DB_PREFIX. "usercredits_balance (id ,   userId , balance)VALUES ('','".addslashes($to)."','".addslashes($add_to_user_for_sale)."') 
                                    ON DUPLICATE KEY UPDATE balance=balance+".addslashes($add_to_user_for_sale); 
//echo $query;
                                    OW::getDbo()->insert($query);


//---log credits strat
                                    $query = "INSERT INTO " . OW_DB_PREFIX. "usercredits_log (
                                        id ,     userId,  actionId     ,   amount , logTimestamp
                                    )VALUES(
                                        '','".addslashes($from)."','22','-".addslashes($add_to_user_for_sale)."','".addslashes($timeStamp)."' 
                                    )";//send:22
                                    OW::getDbo()->insert($query);

                                    $query = "INSERT INTO " . OW_DB_PREFIX. "usercredits_log (
                                        id ,     userId,  actionId     ,   amount , logTimestamp
                                    )VALUES(
                                        '','".addslashes($to)."','23','".addslashes($add_to_user_for_sale)."','".addslashes($timeStamp)."' 
                                    )";//recive:23
                                    OW::getDbo()->insert($query);
//exit;
//---log credits end
                            OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'return_credit_succesfull'));
                        }else{
                            OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'error_notenought_credits'));
                        }
                    }
            }//isplugin
        }//isuser
    }

    public function json_corect($content=""){
//        $content=str_replace("/","\/",$content);
        return $content;
    }

    public function addtonoty($plugin="",$entityId=0,$entityType="",$action="",$lang_key="",$to_owner,$from_user=0,$from_username="",$from_avatar_img="",$form_url_profile="",$comment='',$url_to_item='',$imege_item=''){
        $curent_url=OW_URL_HOME;
//echo "-dfsdfsdf--".$lang_key;exit;
        if ($plugin AND $entityId>0 AND $entityType AND $action AND $lang_key AND $to_owner>0 AND $from_username AND $url_to_item){

        if (!$from_avatar_img) $from_avatar_img=$curent_url."ow_static/themes/".OW::getConfig()->getValue('base', 'selectedTheme')."/images/no-avatar.png";
/*
        $from_avatar_img=$from_avatar_img;
        $form_url_profile=addslashes($form_url_profile);
        $url_to_item=addslashes($url_to_item);
        $comment=addslashes($comment);
        $imege_item=addslashes($imege_item);
*/        

        $comment= UTIL_String::truncate($comment, 140, '...');

        $data = array(
            'format' => 'text',
            'avatar' => array(
                'urlInfo' => array(
                    'routeName' => 'base_user_profile',
                    'vars' => array(
                        'username' => $from_username
                    )
                ),
                'src' => $from_avatar_img,
                'url' => $form_url_profile,
            ),
            'string' => array(
                'key' =>$lang_key, 
                'vars' => array(
                    'userName' => $from_username,
                    'userUrl' => $form_url_profile,

                        'userName' => $from_username,
                        'userUrl' => $form_url_profile,
                        'profileUrl' => $form_url_profile,
                        'producturl' =>$url_to_item

                )
            ),
            'content' => !empty($comment) ? $comment : '',
            'url' => $url_to_item,
            'contentImage' => $imege_item
        );
//        $prepere_data=$this->json_corect(json_encode($data));
//        $prepere_data=addslashes(json_encode($data));
        $prepere_data=json_encode($data);



        $timeStamp=strtotime(date('Y-m-d H:i:s'));
        
            $query = "INSERT INTO " . OW_DB_PREFIX. "notifications_notification (
                    id,  entityType   ,   entityId    ,    action , userId , pluginKey   ,    
                    timeStamp   ,    viewed  ,sent,    active,  data
            )VALUES(
                    '','".addslashes($entityType)."','".addslashes($entityId)."','".addslashes($action)."','".addslashes($to_owner)."','".addslashes($plugin)."',
                    '".addslashes($timeStamp)."','0','0','1','".$prepere_data."'
            )ON DUPLICATE KEY UPDATE timeStamp='".addslashes($timeStamp)."',data='".$prepere_data."',viewed='0' ";//send:22
            OW::getDbo()->insert($query);
//echo $prepere_data;exit;
            return true;
        }else{
            return false;
        }
    }

    
    public function tonotyfitoallclients($actionId=0,$id_owner=0)
    {
$curent_url=OW_URL_HOME;
        $sql = "SELECT * FROM " . OW_DB_PREFIX. "base_billing_sale WHERE entityId='".addslashes($actionId)."' GROUP BY userId";
//echo $sql;

        $arr2 = OW::getDbo()->queryForList($sql);
        foreach ( $arr2 as $value )
        {        
//echo $value['userId'].";";
            $this->tonotyficat($id_owner,$value['entityId'],"","shop-wasbuy","shoppro+notification_string_update","shoppro",stripslashes($value['entityKey']),$curent_url."product/".$value['entityId']."/zoom/index.html");
        }
//        $this->tonotyficat($valuep2['id_owner'],$valuep2['id'],"","shop-wasbuy","shop-wasbuy","shoppro",stripslashes($valuep2['name']),$curent_url."product/".$valuep2['id']."/zoom/product.html");
//        exit;
    }

    public function tonotyficat($toowner=0,$idtype=0,$timestamp="",$status="status_comment",$act="shoppro+member_was_buy_item_url",$plugin="newsfeed",$obj_title="...",$obj_url="" )
    {
        $curent_url=OW_URL_HOME;
        $is_user = OW::getUser()->getId();
        if (!$timestamp){
            $timestamp=strtotime(date('Y-m-d H:i:s'));
        }
//        if ($toowner>0) $is_user = $toowner;
//            else $is_user = OW::getUser()->getId();
        $is_user = OW::getUser()->getId();

//echo $is_user."--".$idtype."--".$toowner;exit;
//echo $obj_title."--".$idtype."--".$toowner."--".$obj_url;exit;
//        if (!$is_user OR !$idtype OR !$toowner OR $is_user==OW::getUser()->getId() OR !$obj_url){

//        if (!$is_user OR !$idtype OR !$toowner OR $is_user==OW::getUser()->getId() ){
        if (!$is_user OR !$idtype OR !$toowner OR $is_user==$toowner ){
//echo $is_user."--".$idtype."--".$toowner."--".$obj_title."--".$idtype."--".$toowner."--".$obj_url."<br>";
//echo "----";exit;
            return;
        }
        if (!$obj_title) $obj_title=OW::getLanguage()->text('shoppro', 'member_was_buy_item');
        $obj_title=str_replace("\r\n","",$obj_title);
        $obj_title=str_replace("\r","",$obj_title);
        $obj_title=str_replace("\n","",$obj_title);
        $obj_title=str_replace("\t","",$obj_title);
        $obj_title=str_replace("\"","'",$obj_title);
        $obj_title=mb_substr($obj_title,0,50);


        $obj_url=str_replace("\r\n","",$obj_url);
        $obj_url=str_replace("\r","",$obj_url);
        $obj_url=str_replace("\n","",$obj_url);
        $obj_url=str_replace("\t","",$obj_url);

        $dname=BOL_UserService::getInstance()->getDisplayName($is_user);
//        $dname=BOL_UserService::getInstance()->getDisplayName($value['id_owner']);
        $uurl=BOL_UserService::getInstance()->getUserUrl($is_user);
        $uimg=BOL_AvatarService::getInstance()->getAvatarUrl($is_user);
        if (!$uimg) {
            $uimg=$curent_url."ow_static/themes/".OW::getConfig()->getValue('base', 'selectedTheme')."/images/no-avatar.png";
        }

//                    if ($status=="shop-wasbuy"){
                    if ($status){
//                        $lang_status="shoppro+member_was_buy_item";
//                        $lang_status="<a href=\"".$dname."\">".$dname."</a> ".OW::getLanguage()->text('shoppro', 'member_was_buy_item').": \"".$obj_title."\"";
                        $lang_status="<a href=\"".$dname."\">".$dname."</a> ".$obj_title.": '".$obj_title."'";

//echo "ss";exit;
//----
//    $comment = BOL_CommentService::getInstance()->findComment($commentId);
//    $comment=$comment->getMessage();
    $comment="";
//    $url = OW::getRouter()->urlForRoute('base_user_profile', array('username' => BOL_UserService::getInstance()->getUserName($entityId)));

    $avatars = BOL_AvatarService::getInstance()->getDataForUserAvatars(array($is_user));
    $avatar = $avatars[$is_user];

//&lt;a href="{$actorUrl}"&gt;{$actor}&lt;/a&gt; kupił(a) produkt: &lt;a href="{$url}"&gt;"{$title}"&lt;/a&gt;<

if ($act) $lang_key=$act;
else $lang_key="shoppro+member_was_buy_item_url";
//$lang_key="'".$lang_key."'";
//echo $lang_key;exit;

if (!$obj_url){
    $obj_url=$curent_url.'product/'.$idtype.'/zoom/index.html';
}

//                'key' => $lang_key,
//                'key' => 'shoppro+member_was_buy_item_url',
//echo "SfsdF";exit;
//---------------------------

        //new notyfycation
        $this->addtonoty('shoppro',$idtype,$status,$act,$lang_key,$toowner,
            $is_user,
            BOL_UserService::getInstance()->getDisplayName($is_user),
            BOL_AvatarService::getInstance()->getAvatarUrl($is_user),
            BOL_UserService::getInstance()->getUserUrl($is_user),
            $comment,
            $obj_url,
            ''
        );


//echo "Sdfsdf";exit;
//---------------------------
/*
    $event = new OW_Event('notifications.add', 
        array(
            'pluginKey' => 'shoppro',
            'entityType' => $status,
            'entityId' => $idtype,
            'action' => $act,
            'userId' => $toowner
        ), 
        array(
            'avatar' => $avatar,
            'string' => array(
                'key' => $lang_key,
//                'key' => 'shoppro+member_was_buy_item_url',
                'vars' => array(
                    'userName' => $dname,
                    'userUrl' => $uurl,
                    'profileUrl' => $uurl,
                    'status' =>'yyyyy',
                    'producturl' =>$obj_url,

                'actor' => $dname,
                'actorUrl' => $uurl,
                'title' => $obj_title,
                'url' => $obj_url

                )
            ),
            'content' => $comment,
            'url' => $uurl
        )
    );
//echo "Sdfsdf";exit;

    OW::getEventManager()->trigger($event);
*/


/*
if ($act) $lang_key=$act;
else $lang_key="shoppro+notification_string";
//$lang_key="aaaaaa";
if (!$obj_url){
    $obj_url=$curent_url.'product/'.$idtype.'/zoom/index.html';
}


   $event = new OW_Event('notifications.add', array(
        'pluginKey' => 'shoppro',
        'entityType' => 'blogs-add_comment',
        'entityId' => $idtype,
        'action' => 'blogs-add_comment',
        'userId' => $toowner,
        'time' => time()
    ), array(
        'avatar' => $avatar,
        'string' => array(
            'key' => $lang_key,
            'vars' => array(
                'actor' => $dname,
                'actorUrl' => $uurl,
                'title' => $obj_title,
                'url' => $obj_url
            )
        ),
        'content' => $comment,
        'url' => $uurl
    ));
*/
//print_r( $event );exit;

/*
      $event = new OW_Event('notifications.add', 
                            array('pluginKey' => 'shoppro',
            		          'entityType' => $status,
            			  'entityId' => $idtype,
            			  'userId' => $toowner,
            			  'replace' => true
                            ), 
            		    array('string' => 'afdsfsdf',
            		       'content' =>'sdfsdgdfg gsg dfg dfg',
            		        'view' => array('iconClass' => 'ow_ic_star')
                            )
        );
*/
//      OW::getEventManager()->trigger($event);


/*
                            $jarray=array(
                                "avatar" => array(
                                    "src" => "http://test3.a6.pl/ow_userfiles/plugins/base/avatars/avatar_2_1356950128.jpg",
                                    "url" => "http://test3.a6.pl/user/gosia",
                                    "title" => "Gosia"
                                ),"string" => array(
                                    "key" => "newsfeed+email_notifications_status_comment",
                                    "vars" => array(
                                        "userName" => "Gosia",
                                        "userUrl" =>"http://test3.a6.pl/user/gosia",
                                        "status" =>"yyyyy",
                                        "url" =>"http://test3.a6.pl/newsfeed/33"
                                    )
                                ),"contenet" => "xxxxxxxxx x x ",
                                "url" => "http://test3.a6.pl/newsfeed/33"
                            );
*/


///////    OW::getEventManager()->trigger($event);

//----


                    
/*


//                                        "status" =>"",
//                                    "title" => "$dname"

//                                    "onclick" =>"",
//                                    "class" =>"",

//                                    "id" =>"1",
//                                    "url" =>"$obj_url",



//                                ),"toolbar" => array(
//                                    "id" =>"111",
//                                    "label"=>"ddddd"

                        $jarray=array(
                                "avatar" => array(
                                    "src" => "$uimg",
                                    "url" => "$uurl"
                                ),"string" => array(
                                    "key" => "shoppro+member_was_buy_item",
                                    "vars" => array(
                                        "userName" => "$dname",
                                        "userUrl" =>"$uurl",
                                        "profileUrl" => "$uurl",
                                        "url" =>"$obj_url",
                                        "title"=>"$obj_title"
                                    )
                                ),"url" => "$obj_url",
                                "content" =>"$lang_status",
                                "contentImage" => ""
                                
                        );



                    }else{
                        $jarray=array(
                            "contenet" => "...",
                            "url" => ""
                        );
                    }

                        $datadata=json_encode($jarray);
//echo "asdfaf";exit;
//entityType,entityId,userId
                        $sql="INSERT INTO " . OW_DB_PREFIX. "notifications_notification (
                                `id`, `entityType`, `entityId` ,`action`, 
                                `userId`,`pluginKey`,`timeStamp`,`viewed`,`sent`,`active` , `data`
                        )VALUES(
                                    '',
                            '".addslashes($status)."',
                            '".addslashes($idtype)."',
                                    '".addslashes($act)."',
                            '".addslashes($toowner) ."',
                                    '".addslashes($plugin)."', '".addslashes($timestamp)."','0','0','1','".addslashes($datadata)."'
                        ) ON DUPLICATE KEY UPDATE `timeStamp`='".addslashes($timestamp)."', `data`='".addslashes($datadata)."',`viewed`='0' ";
//echo $sql;exit;
                        $last_action_id = OW::getDbo()->insert($sql);

                        if ($last_action_id>0){
                            return true;
                        }else{
                            return false;
                        }
*/
        }//if ($status=="shop-wasbuy"){
            return true;                        
    }


    public function makePagination($page = 1, $totalitems, $limit = 15, $adjacents = 1, $targetpage = "/", $pagestring = "?page=",$position="right",$contentadd="")
    {               
    //defaults
    if(!$adjacents) $adjacents = 1;
    if(!$limit) $limit = 15;
    if(!$page) $page = 1;
    if(!$targetpage) $targetpage = "/";
    $margin="";
    $padding="";
    $pagestring1="";
    //other vars
    $prev = $page - 1;                                                                  //previous page is page - 1
    $next = $page + 1;                                                                  //next page is page + 1
    $lastpage = ceil($totalitems / $limit);                             //lastpage is = total items / items per page, rounded up.
    $lpm1 = $lastpage - 1;                                                              //last page minus 1
    $space=" ";
//$lastpage++;    
//return "--".$lastpage;    
    if ($position=="center") $position="ow_center";
    else if ($position=="left") $position="ow_left";
    else $position="ow_right";
    $pagination = "";
    if($lastpage > 1)
    {   
        $pagination .= "<div class=\"".$position." ow_paging clearfix ow_smallmargin\"";
        if($margin || $padding)
        {
            $pagination .= " style=\"";
            if($margin)
                $pagination .= "margin: $margin;";
            if($padding)
                $pagination .= "padding: $padding;";
            $pagination .= "\"";
        }
        $pagination .= ">";

        //previous button
        if ($page > 1) 
            $pagination .= "<a href=\"$targetpage$pagestring$prev\">«</a>".$space;
        else
            $pagination .= "<a class=\"disabled\" href=\"".$targetpage.$pagestring1."\">«</a>".$space;
//            $pagination .= "<span class=\"disabled\">«</span>";    
        $pagination .= "&nbsp;&nbsp;&nbsp;";
        
        //pages 
        if ($lastpage < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
        {       
            for ($counter = 1; $counter <= $lastpage; $counter++)
            {
//                    $pagination .= "<span class=\"active\">$counter</span>";
                if ($counter == $page)
                    $pagination .= "<a class=\"active\" href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a>".$space;                                     
                else
                    $pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a>".$space;                                     
            }
        }
        elseif($lastpage >= 7 + ($adjacents * 2))       //enough pages to hide some
        {
            //close to beginning; only hide later pages
            if($page < 1 + ($adjacents * 3))            
            {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                {
//                        $pagination .= "<span class=\"active\">$counter</span>";
                    if ($counter == $page)
                        $pagination .= "<a class=\"active\" href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a>".$space;                                 
                    else
                        $pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a>".$space;                                 
                }
                $pagination .= "<span class=\"elipses\">...</span>".$space;
                $pagination .= "<a href=\"" . $targetpage . $pagestring . $lpm1 . "\">$lpm1</a>".$space;
                $pagination .= "<a href=\"" . $targetpage . $pagestring . $lastpage . "\">$lastpage</a>".$space;               
            }
            //in middle; hide some front and some back
            elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
            {
                $pagination .= "<a href=\"" . $targetpage . $pagestring . "1\">1</a>".$space;
                $pagination .= "<a href=\"" . $targetpage . $pagestring . "2\">2</a>".$space;
                $pagination .= "<span class=\"elipses\">...</span>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                {
//                        $pagination .= "<span class=\"active\">$counter</span>";
                    if ($counter == $page)
                        $pagination .= "<a class=\"active\" href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a>".$space;                                  
                    else
                        $pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a>".$space;                                 
                }
                $pagination .= "...";
                $pagination .= "<a href=\"" . $targetpage . $pagestring . $lpm1 . "\">$lpm1</a>".$space;
                $pagination .= "<a href=\"" . $targetpage . $pagestring . $lastpage . "\">$lastpage</a>".$space;               
            }
            //close to end; only hide early pages
            else
            {
                $pagination .= "<a href=\"" . $targetpage . $pagestring . "1\">1</a>".$space;
                $pagination .= "<a href=\"" . $targetpage . $pagestring . "2\">2</a>".$space;
                $pagination .= "<span class=\"elipses\">...</span>".$space;
                for ($counter = $lastpage - (1 + ($adjacents * 3)); $counter <= $lastpage; $counter++)
                {
//                      $pagination .= "<span class=\"active\">$counter</span>";
                    if ($counter == $page)
                        $pagination .= "<a class=\"active\" href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a>".$space;                                 
                    else
                        $pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a>".$space;                                 
                }
            }
        }
        
        //next button
        $pagination .= "&nbsp;&nbsp;&nbsp;";
        if ($page < $counter - 1) 
            $pagination .= "<a href=\"" . $targetpage . $pagestring . $next . "\">»</a>".$space;
        else
            $pagination .= "<a class=\"disabled\" href=\"" . $targetpage . $pagestring . $lastpage . "\">»</a>".$space;
//            $pagination .= "<a class=\"disabled\" href=\"" . $targetpage . $pagestring . $next . "\">»</a>".$space;
//            $pagination .= "<span class=\"disabled\">»</span>";
        $pagination .= "</div>\n";
    }

        if ($pagination){
            return "<div class=\"clearfix ow_smallmargin\">".$pagination.$contentadd."</div>";
//            return "<div class=\"clearfix ow_smallmargin\">".$pagination."</div>";
        }else if ($contentadd){
            return "<div class=\"clearfix ow_smallmargin\">".$contentadd."</div>";
//            return "<div class=\"clearfix ow_smallmargin\"></div>";
        }else{
            return "";
        }

    }

/*
<div class="ow_paging clearfix ow_smallmargin">
    <span>Pages:</span>
    <a class="active" href="http://www.oxwall.a6.pl/blogs?&amp;page=1">1</a>            
    <a href="http://www.oxwall.a6.pl/blogs?&amp;page=2">2</a>               
    <a href="http://www.oxwall.a6.pl/blogs?&amp;page=3">3</a>               
    <a href="http://www.oxwall.a6.pl/blogs?&amp;page=4">4</a>               
    <a href="http://www.oxwall.a6.pl/blogs?&amp;page=5">5</a>        
    <span>...</span>    
    <a href="http://www.oxwall.a6.pl/blogs?&amp;page=2">»</a>    
    <a href="http://www.oxwall.a6.pl/blogs?&amp;page=396">»»</a>
</div>
*/

//======================================================================================rr start
    public function read_rate($idevent=0,$event_type="",$type_result="rate")
    {
        $res=0;
        $id_user = OW::getUser()->getId();//citent login user (uwner)
        if (!$id_user){
            return 5;
//            OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'you_must_first_login'));
//            OW::getApplication()->redirect($curent_url."sign-in");
//            exit;
        }
        if ($idevent>0 AND $type_result=="one"){
            $sqla="SELECT * FROM " . OW_DB_PREFIX. "base_rate WHERE entityId='".addslashes($idevent)."' AND entityType='".addslashes($event_type)."' AND userId='".addslashes($id_user)."' AND active='1' LIMIT 1";            
            $arra = OW::getDbo()->queryForList($sqla);
            if (isset($arra['0'])){
                return $arra['0']['score'];
            }else{
                return 5;
            }
        }else if ($idevent>0 AND $type_result=="rate"){
            $sqla="SELECT SUM(score) AS value_sum, COUNT(id) as value_id FROM " . OW_DB_PREFIX. "base_rate WHERE entityId='".addslashes($idevent)."' AND entityType='".addslashes($event_type)."' AND active='1' ";
//echo $sqla;exit;
            $arra = OW::getDbo()->queryForList($sqla);
            if (isset($arra['0'])){
                $sum_score=$arra['0']['value_sum'];
                $sum_items=$arra['0']['value_id'];
            }else{
                $sum_score=0;
                $sum_items=0;
            }

            if ($sum_items>0){
                $res=round($sum_score/$sum_items);
            }else{
                $res=5;
            }
        }
        return $res;
    }

    public function save_rate($score="",$idevent=0,$event_type="",$pluginkey="shoppro",$return_url="shop")
    {
//echo "ssssssssssssssssssssss".$idevent;exit;
        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();
        $curent_url=OW_URL_HOME;            
        $timestamp=strtotime(date('Y-m-d H:i:s'));
        $last_insert_id=0;
        if (!OW::getConfig()->getValue('shoppro', 'turn_on_commntsandrate')){
            return;
            exit;
        }
        if (!$id_user) return;
        if (!$idevent OR !$event_type) {
            echo "error";
            exit;
        }
//            echo "back=errorxx";exit;
//echo "score:".$score."--".$_POST['rating'];exit;
        if (!$id_user OR $score=="" OR !isset($_POST['rating']) OR $score!=$_POST['rating']){
//            OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'you_must_first_login'));
//            OW::getApplication()->redirect($curent_url."sign-in");
            echo "error";
            exit;
        }
        if ($score>5) $score=5;
        if ($score<1) $score=1;
        $sql="SELECT * FROM " . OW_DB_PREFIX. "base_rate WHERE userId='".addslashes($id_user)."' AND entityId='".addslashes($idevent)."' AND entityType='".addslashes($event_type)."' LIMIT 1 ";
//echo $sql;exit;
        $arra = OW::getDbo()->queryForList($sql);
        if (isset($arra['0'])){
            $found_rec=$arra['0']['id'];
        }else{
            $found_rec=0;
        }
        $stat="shoppro+wasrated";
        if ($found_rec>0){
            $sql="UPDATE " . OW_DB_PREFIX. "base_rate SET 
                score='".addslashes($score)."',
                timeStamp='".addslashes($timestamp)."'
            WHERE id='".addslashes($found_rec)."' LIMIT 1 ";
            OW::getDbo()->query($sql);
            $stat="shoppro+wasupdaterate";

        }else{
            $sql="INSERT INTO " . OW_DB_PREFIX. "base_rate (
                id,  entityType,entityId,userId,score,timeStamp,active
            )VALUES(
                '','".addslashes($event_type)."','".addslashes($idevent)."','".addslashes($id_user)."','".addslashes($score)."', '".addslashes($timestamp)."','1'
            ) ";
            $rr=OW::getDbo()->insert($sql);
            $stat="shoppro+wasrated";
        }
//echo "sfdsdf";exit;
//--s
            if ($idevent>0){
                $sqlf="SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($idevent)."' LIMIT 1 ";
//print_r($sqlf);exit;
                $arraf = OW::getDbo()->queryForList($sqlf);
                if (isset($arraf['0'])){
                    $frec=$arraf['0'];
                }else{
                    $frec=array();
                    $frec['id']=0;
                }
                if ($frec['id']>0){
//print_r($frec);
                    $this->tonotyficat($frec['id_owner'],$frec['id'],"","shop-wasrated",$stat,"shoppro",stripslashes($frec['name']),$curent_url."product/".$frec['id']."/zoom/product.html");
                }
            }
//--e

        echo "OK100";
        exit;

    }

    public function save_comment($content="",$idevent=0,$event_type="",$pluginkey="shoppro",$return_url="shop")
    {
        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();
        $curent_url=OW_URL_HOME;            
        $timestamp=strtotime(date('Y-m-d H:i:s'));
        $last_insert_id=0;
        if (!OW::getConfig()->getValue('shoppro', 'turn_on_commntsandrate')){
            return;
            exit;
        }

        if (!$id_user){
            return;
            OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'you_must_first_login'));
            OW::getApplication()->redirect($curent_url."sign-in?back-uri=shop");
            exit;
        }
        if (!$idevent) {
            return;
        }

        $sql="INSERT INTO " . OW_DB_PREFIX. "base_comment_entity (
            id,  entityType     , entityId    ,    pluginKey  ,     active
        )VALUES(
            '','".addslashes($event_type)."','".addslashes($idevent)."','".addslashes($pluginkey)."','1'
        ) ON DUPLICATE KEY UPDATE entityId='".addslashes($idevent)."' ";
//echo $sql;exit;
//        $last_insert_id = OW::getDbo()->insert($sql);
        OW::getDbo()->insert($sql);

        if (!$last_insert_id){
            $sqla="SELECT * FROM " . OW_DB_PREFIX. "base_comment_entity WHERE entityId='".addslashes($idevent)."' AND entityType='".addslashes($event_type)."' LIMIT 1";
            $arra = OW::getDbo()->queryForList($sqla);
            if (isset($arra['0'])){
                $last_insert_id=$arra['0']['id'];
            }else{
                $last_insert_id=0;
            }
        }

        if ($last_insert_id>0){


//approved TODO
            if (OW::getConfig()->getValue('shoppro', 'comments_require_aproved')){
                if ($is_admin){
                    $approved="NULL";
                }else{
                    $approved="'waiting' ";
                }
            }else{
                $approved="NULL";
            }

            $sql="INSERT INTO " . OW_DB_PREFIX. "base_comment (
                id ,     userId , commentEntityId, message ,createStamp   ,  attachment
            )VALUES(
                '','".addslashes($id_user)."','".addslashes($last_insert_id)."','".addslashes($content)."','".addslashes($timestamp)."',".$approved."
            )";  
//echo $sql;exit;
            OW::getDbo()->insert($sql);

//--s
            if ($idevent>0){
                $stat="shoppro+productwascommented";
                $sqlf="SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($idevent)."' LIMIT 1 ";
//print_r($sqlf);exit;
                $arraf = OW::getDbo()->queryForList($sqlf);
                if (isset($arraf['0'])){
                    $frec=$arraf['0'];
                }else{
                    $frec=array();
                    $frec['id']=0;
                }
                if ($frec['id']>0){
//print_r($frec);
                    $this->tonotyficat($frec['id_owner'],$frec['id'],"","shop-wascommented",$stat,"shoppro",stripslashes($frec['name']),$curent_url."product/".$frec['id']."/zoom/product.html");
                }
            }
//--e

        }else{
        }


//OW::getFeedback()->error("OKOKOK save TODO");        
        if ($return_url){
            $return_url=str_replace("--","/",$return_url);
            OW::getApplication()->redirect($curent_url.$return_url);
        }else{
            OW::getApplication()->redirect($curent_url."shop");
        }
        exit;
    }

    public function make_rate($idevent=0,$event_type="",$pluginkey="shoppro",$option="",$is_item_owner=false)
    {
        
        $content="";
        $curent_url=OW_URL_HOME;            
    $id_user = OW::getUser()->getId();//citent login user (uwner)
//echo $idevent."--".$event_type;exit;
        if (!$idevent OR !$event_type) return;
$pluginStaticDir =OW::getPluginManager()->getPlugin($pluginkey)->getStaticUrl();
//echo $pluginStaticDir;exit;
$backurl=$pluginkey;
$idun=uniqid();
//echo "afsdf";
$your_score=$this->read_rate($idevent,$event_type,"one");
///$your_score=3;
//echo $your_score;
$curent_score=$this->read_rate($idevent,$event_type);

    $content .="<div class=\"clearfix ow_left\">";

    if (!$is_item_owner){
        $content .="<div class=\"clearfix ow_left\" style=\"display:inline-block;\">";
            $content .=OW::getLanguage()->text('shoppro', 'your_rate').": ";
            $content .="<div class=\"\" style=\"display:inline-block;\" id=\"aron_raty_your_".$idun."\" data-score=\"".$your_score."\" idevent=\"".$idevent."\" event_type=\"".$event_type."\"></div>";
        $content .="</div>";
    }

        $content .="<div class=\"clearfix ow_left\" style=\"display:inline-block;\">";
//            $content .=", ";
            $content .=OW::getLanguage()->text('shoppro', 'total_rate').": ";
            $content .="<div class=\"\" style=\"display:inline-block;\" id=\"aron_raty_".$idun."\" data-score=\"".$curent_score."\" idevent=\"".$idevent."\" event_type=\"".$event_type."\"></div>";
        $content .="</div>";



    $content .="</div>";
    if (1==1){
//    if (!$id_user){
//        $script  = "$(document).ready(function(){
//            window.location ='".$curent_url."sign-in';
//        });";
//    }else{

//$.fn.raty.defaults.path = '".$pluginStaticDir."extr".DS."img';
        $script  = "$(document).ready(function(){

$.fn.raty.defaults.path = '".$pluginStaticDir."extr/img';
$('#aron_raty_".$idun."').raty({
    readOnly: true,
    hints         : ['".OW::getLanguage()->text('shoppro', 'hint_bad')."', '".OW::getLanguage()->text('shoppro', 'poor')."', '".OW::getLanguage()->text('shoppro', 'hint_regular')."', '".OW::getLanguage()->text('shoppro', 'hint_good')."', '".OW::getLanguage()->text('shoppro', 'hint_gorgeous')."'],
  score: function() {
    return $(this).attr('data-score');
  },
  click: function(score, evt) {
 jQuery.ajax({  
    type: 'POST',
    url: '".$curent_url."shop/rate/".$idevent."/".$event_type."/".$pluginkey."/'+score,
    data: { idevent: '".$idevent."',event_type: '".$event_type."',rating: score, ss:'".substr(session_id(),3,5)."' },

    success: function(data) {
//alert('====:'+data);
        if (data=='OK100'){
        }
    },

    failure: function() {  },

    error: function() { }

    });

  }
});

$('#aron_raty_your_".$idun."').raty({
    hints         : ['".OW::getLanguage()->text('shoppro', 'hint_bad')."', '".OW::getLanguage()->text('shoppro', 'poor')."', '".OW::getLanguage()->text('shoppro', 'hint_regular')."', '".OW::getLanguage()->text('shoppro', 'hint_good')."', '".OW::getLanguage()->text('shoppro', 'hint_gorgeous')."'],
  score: function() {
    return $(this).attr('data-score');
  },
  click: function(score, evt) {
//    alert('ID: ' + $(this).attr('idevent') + '; score: ' + score+';');

 jQuery.ajax({  
    type: 'POST',
    url: '".$curent_url."shop/rate/".$idevent."/".$event_type."/".$pluginkey."/'+score,
    data: { idevent: '".$idevent."',event_type: '".$event_type."',rating: score, ss:'".substr(session_id(),3,5)."' },

    success: function(data) {
//alert('====:'+data);
        if (data=='OK100'){
        }
    },

    failure: function() {  },

    error: function() { }

    });

  }
});

        });";
        }//if $id_user
        OW::getDocument()->addOnloadScript($script);

        return $content;
    }

    public function make_comment_list($idevent=0,$event_type="",$maxlimit=20,$pluginkey="shoppro")
    {
        if (!$idevent OR !$event_type) return;
        $content="";
        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();
        $curent_url=OW_URL_HOME;            

        if (!$maxlimit) $maxlimit=20;
/*        
        $sql="SELECT * FROM " . OW_DB_PREFIX. "base_comment_entity bce 
        LEFT JOIN " . OW_DB_PREFIX. "base_comment bc ON (bc.commentEntityId=bce.id) 
        WHERE bce.entityId='".$idevent."' AND bce.pluginKey='".addslashes($pluginkey)."' AND bce.active='1' ORDER BY bc.createStamp DESC LIMIT ".$maxlimit;
*/

        if ($is_admin OR !OW::getConfig()->getValue('shoppro', 'comments_require_aproved')){
            $sql="SELECT *,bc.id as idp FROM " . OW_DB_PREFIX. "base_comment bc
            LEFT JOIN " . OW_DB_PREFIX. "base_comment_entity bce ON (bc.commentEntityId=bce.id) 
            WHERE bce.entityId='".$idevent."' AND bce.pluginKey='".addslashes($pluginkey)."' AND bce.active='1' ORDER BY bc.createStamp DESC LIMIT ".$maxlimit;
        }else{
            $sql="SELECT *,bc.id as idp FROM " . OW_DB_PREFIX. "base_comment bc
            LEFT JOIN " . OW_DB_PREFIX. "base_comment_entity bce ON (bc.commentEntityId=bce.id) 
            WHERE bce.entityId='".$idevent."' AND bce.pluginKey='".addslashes($pluginkey)."' AND bce.active='1' AND (bc.attachment!='waiting' OR userId='".addslashes($id_user)."') ORDER BY bc.createStamp DESC LIMIT ".$maxlimit;
        }

//        WHERE bce.entityId='".$idevent."' AND bce.active='1' ORDER BY bce.createStamp DESC LIMIT 250";
//echo $sql;exit;
        $arr2 = OW::getDbo()->queryForList($sql);
        foreach ( $arr2 as $row ){

            $dname=BOL_UserService::getInstance()->getDisplayName($row['userId']);
            $uurl=BOL_UserService::getInstance()->getUserUrl($row['userId']);
            $uimg=BOL_AvatarService::getInstance()->getAvatarUrl($row['userId']);
                $contentt ="";
                    if ($uimg){
                        $contentt .="<a href=\"".$uurl."\">";
                        $contentt .="<img src=\"".$uimg."\" alt=\"".$dname."\" title=\"".$dname."\" width=\"45px\" style=\"border:0;\" align=\"left\" >";
                        $contentt .="</a>";
                    }else{
//                        $tabt .="<i>".OW::getLanguage()->text('search', 'index_hasnotimage')."</i>";
                        $contentt .="<a href=\"".$uurl."\"  >";
                        $contentt .="<img src=\"".$curent_url."ow_static/themes/".OW::getConfig()->getValue('base', 'selectedTheme')."/images/no-avatar.png\" title=\"".$dname."\" width=\"45px\" style=\"border:0;\" align=\"left\" >";
                        $contentt .="</a>";
                    }
$content_text=stripslashes($row['message']);
$content_text=str_replace("/r/n","<hr/>",$content_text);
$content_text=str_replace("/r","<hr/>",$content_text);
$content_text=str_replace("/n","<hr/>",$content_text);
$content .="
<div class=\"ow_comments_item ow_smallmargin clearfix\">";


/*
//if (1==2){
//if ($is_admin OR $row['userId']==$id_user){
if ($is_admin){

    $content .="<div class=\"cnx_action\" style=\"display: none;\">";
        $content .="<div class=\"ow_context_action_block clearfix\">";
            $content .="<div class=\"ow_context_action\">
                        <span class=\"ow_context_more\"></span>";

$content .="<!-- div class=\"ow_context_action_wrap\" -->                                
                <div class=\"ow_tooltip  ow_comments_context_tooltip ow_small ow_tooltip_top_right\">
                    <div class=\"ow_tooltip_tail\">
                    <span></span>
                    </div>
                    <div class=\"ow_tooltip_body\">        
                        <ul class=\"ow_context_action_list ow_border\">
                            <li><a href=\"javascript://\" id=\"del-688\">".OW::getLanguage()->text('shoppro', 'delete_comments')."</a></li>
                        </ul>    
                    </div>
                </div>
            <!-- /div -->";

            $content .="</div>";
        $content .="</div>";
    $content .="</div>";
}
*/


$adm="";
if ($is_admin){
    if ($row['attachment']=="waiting"){
        $adm .="<div class=\"ow_right\">";
        $adm .="&nbsp;";
        $adm .="<b style=\"color:#f00;\">[!*waiting]</b>";
        $adm .="</div>";
    }

    $adm .="<a onclick=\"return confirm('Are you sure you want to delete?');\" href=\"".$curent_url."shop/commentdel/del/".$row['idp']."/".$row['entityId']."/shoppro/".substr(session_id(),2,5)."\" class=\"wp_init\">
    <img src=\"".$curent_url."ow_static/plugins/shoppro/delete.gif\" style=\"border:0;\">
    </a>";
}


            $content .="<div class=\"ow_comments_item_picture\">
                <div class=\"ow_avatar\">
                    ".$contentt."
                </div>
            </div>";

//                <span class=\"ow_comments_date_hover ow_comments_date ow_nowrap ow_tiny ow_remark\" style=\"display: block;\">".date("Y-m-d H:i:s",$row['createStamp']).$adm."</span>
            $content .="<div class=\"ow_comments_item_info\" style=\"text-align: left;\">
                <span class=\"ow_comments_date_hover ow_comments_date ow_nowrap ow_tiny ow_remark\" style=\"display: block;\">".UTIL_DateTime::formatDate((int) $row['createStamp']).$adm."</span>
                <div class=\"ow_comments_item_header\"><a href=\"".$uurl."\">".$dname."</a></div>
                <span class=\"comment_arr\"></span>
                <div class=\"ow_comments_item_content\"><div class=\"ow_comments_content ow_smallmargin\">".$content_text."</div></div>
            </div>
        </div>";




        }
        if ($content) {
            $content="<div class=\"clearfix\"><h2>".OW::getLanguage()->text('shoppro', 'comments').":</h2><div class=\"ow_reviews_list\" style=\"margin-top:15px;\">".$content."</div></div>";
        }
        return $content;
    }


    public function make_comment_form($idevent=0,$event_type="",$backurl="shop",$show_history=true,$show_rate=true,$maxlimit=20,$pluginkey="shoppro",$is_owner_item=false)
    {
        if (!$idevent OR !$event_type) return;

        $content="";
        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();
        $curent_url=OW_URL_HOME;            
        if (!$maxlimit) $maxlimit=20;
//echo $maxlimit;exit;
        
if ($show_history==true){
//echo "SDfsdF";exit;
    $content .=$this->make_comment_list($idevent,$event_type,$maxlimit,$pluginkey);

/*
    $content .="<div class=\"ow_box_toolbar_cont clearfix\">
<div class=\"ow_box_toolbar ow_remark\">
        <span style=\"\" class=\"ow_nowrap\">
        <a href=\"http://test3.a6.pl/users/online\">More</a>
        </span>
</div>
    </div>";
*/
}

if ($show_rate==true){
    if (OW::getConfig()->getValue('shoppro', 'turn_on_commntsandrate')){
        $content .=$this->make_rate($idevent,$event_type,"shoppro","",$is_owner_item);
    }
}

$content .="<div class=\"ow_stdmargin ow_txtright\"></div>";


//$content .="<div class=\"forum_add_post clearfix\">";

$content .="<div class=\"ow_left clearfix forum_add_post\" style=\"width: 100%;\">";

//<form id=\"form_56744537\" method=\"post\" action=\"".$curent_url."shop/comment\" name=\"add-post-form\" enctype=\"multipart/form-data\">
$content .="<form id=\"form_comment\" method=\"post\" action=\"".$curent_url."shop/comment/".$idevent."/".$event_type."/".$pluginkey."/".str_replace("/","--",$backurl)."\" name=\"add-post-form\" enctype=\"multipart/form-data\">";

$content .="<input type=\"hidden\" name=\"ss\" value=\"".substr(session_id(),3,5)."\">
<input type=\"hidden\" name=\"idevent\" value=\"".$idevent."\">
<input type=\"hidden\" name=\"eventtype\" value=\"".$event_type."\">
<input type=\"hidden\" name=\"backurl\" value=\"".$backurl."\">

<input name=\"form_name\" id=\"post_comment\" type=\"hidden\" value=\"add-post-form\"/>
<div class=\"ow_box_cap\">
<div class=\"ow_box_cap_right\">
<div class=\"ow_box_cap_body\">
<h3 class=\"ow_ic_write\">".OW::getLanguage()->text('shoppro', 'post_reply')."</h3>
</div>
</div>
</div>
<div class=\"ow_box ow_stdmargin ow_break_word\" style=\"\">
<textarea name=\"conetnt\" id=\"content\" class=\"ow_smallmargin\" style=\"max-height:60px;\"></textarea>
<span id=\"input_98351134_error\" style=\"display:none;\" class=\"error\"></span><br/>


<div class=\"clearfix\"><div class=\"ow_right\"><span class=\"ow_button\"><span class=\" ow_positive\">
    <input type=\"submit\"  value=\"".OW::getLanguage()->text('shoppro', 'send_post')."\" id=\"input_57448739\" class=\"ow_positive\"name=\"submit\" />
</span></span>
</div>
</div>
    <div class=\"ow_box_bottom_left\"></div>
    <div class=\"ow_box_bottom_right\"></div>
    <div class=\"ow_box_bottom_body\"></div>
    <div class=\"ow_box_bottom_shadow\"></div>
</div>
        
</form>";


        $content .="</div>";
//    $content ."</div>";
/*
        $content<div class=\"ow_right\" style=\"width: 27%;\">
            <div class=\"ow_box_cap\">
                <div class=\"ow_box_cap_right\">
                    <div class=\"ow_box_cap_body\">
                        <h3 class=\"ow_ic_info\">This topic</h3>
                    </div>
                </div>
            </div>
            <div class=\"ow_box ow_stdmargin ow_break_word\" style=\"\">

                <ul class=\"ow_smallmargin ow_bl_narrow clearfix ow_small\">
                                                                            </ul>
                            <input type=\"checkbox\" id=\"cb-subscribe\">
                <label for=\"cb-subscribe\">Subscribe to new posts</label>
                    
                <div class=\"ow_box_bottom_left\"></div>
                <div class=\"ow_box_bottom_right\"></div>
                <div class=\"ow_box_bottom_body\"></div>
                <div class=\"ow_box_bottom_shadow\"></div>
            </div>
        </div>";
*/
//    $content ."</div>";
//    $content ."</div>";

//if ($show_rate==true){
//    $content .=$this->make_rate($idevent);
//}

        return $content;
    }
//======================================================================================rr end

    public function get_curect_lang_id()
    {
//print_r($_SESSION);exit;
//        if (isset($_SESSION['base.language_id']) AND $_SESSION['base.language_id']>0) return $_SESSION['base.language_id'];
//            else return 0;
        $clan=0;
        if (isset($_SESSION['base.language_id']) AND $_SESSION['base.language_id']>0) $clan= $_SESSION['base.language_id'];
        if (!$clan) $this->get_system_lang_id();

        return $clan;
    }

    public function get_system_lang_id()
    {
/*
            $sql = "SELECT bc.value, bl.id FROM " . OW_DB_PREFIX. "base_config bc 
    LEFT JOIN " . OW_DB_PREFIX. "base_language bl ON (bl.tag=bc.value) 
            WHERE `key`='locale' AND `name`='default_language' LIMIT 1";
//echo $sql;exit;
            $arr = OW::getDbo()->queryForList($sql);
            if (isset($arr[0]) AND isset($arr[0]['id']) AND $arr[0]['id']>0){
                return  $arr[0]['id'];
            }else{
                if (isset($_SESSION['base.language_id']) AND $_SESSION['base.language_id']>0) return $_SESSION['base.language_id'];
                    else return 0;
            }
*/
            $sql = "SELECT * FROM " . OW_DB_PREFIX. "base_language  
            WHERE `status`='active' ORDER BY `order` LIMIT 1";

            $arr = OW::getDbo()->queryForList($sql);
            if (isset($arr[0]) AND isset($arr[0]['id']) AND $arr[0]['id']>0){
                return  $arr[0]['id'];
            }else{
                if (isset($_SESSION['base.language_id']) AND $_SESSION['base.language_id']>0) return $_SESSION['base.language_id'];
                    else return 0;
            }
    }

    public function make_languages_tabs($for_lang=0,$id_product=0,$content="")
    {
//$content="";
        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();
        $curent_url=OW_URL_HOME;
$content_t ="";
$content_d ="";
        if (!$for_lang){
            $for_lang=$this->get_curect_lang_id();
            if (!$for_lang) $for_lang=0;
        }

            $content_t .="<div class=\"ow_content\">";

/*
            $page_on_top_shop=OW::getConfig()->getValue('shoppro', 'config_page_on_top_shop');
            if ($page_on_top_shop!=""){
                $content_t .="<div class=\"ow_content_menu_wrap ow_content_html\">";
                if (OW::getConfig()->getValue('shoppro', 'admin_replace_btobr')==1 AND !OW::getPluginManager()->isPluginActive('wysiwygeditor')){
                    $page_on_top_shop=SHOPPRO_BOL_Service::getInstance()->ntobr($page_on_top_shop);
                }
                $page_top_template="";
$page_top_template .="<div class=\"ow_dnd_widget index-PAGES_CMP_MenuWidget\">";


    if (OW::getConfig()->getValue('shoppro', 'config_page_on_top_shop_title')!=""){
    $page_top_template .="<div class=\"ow_box_cap_empty ow_dnd_configurable_component clearfix\">
        <div class=\"ow_box_cap_right\">
            <div class=\"ow_box_cap_body\">ssssssssssssssss
                <h3 class=\"ow_ic_info\">".OW::getConfig()->getValue('shoppro', 'config_page_on_top_shop_title')."</h3>
            </div>
        </div>
    </div>";
    }


    $page_top_template .="<div class=\"ow_box_empty ow_stdmargin clearfix index-PAGES_CMP_MenuWidget ow_no_cap ow_break_word\" style=\"\">
        <div class=\"clearfix ow_left\" style=\"margin:10px;\">
            ".$page_on_top_shop."
        </div>
    </div>";


$page_top_template .="</div>";

            
                $content_t .=$page_top_template;

                $content_t .="</div>";
            }
*/

$content_t .="<div class=\"ow_content_menu_wrap\">";
$content_t .="<ul class=\"ow_content_menu clearfix\">";




            if ($is_admin){
                $add=" 1 ";
            }else{
                $add=" status='active' ";
            }
            $sql = "SELECT * FROM " . OW_DB_PREFIX. "base_language WHERE ".$add." ORDER BY `order` ";
            $arr = OW::getDbo()->queryForList($sql);
            $lp=0;
            $was_old_lang=0;
            foreach ( $arr as $value )
            {            
                $content_readed="";

                if ($for_lang==$value['id']) {
                    $sel=" active ";
                    $display=" ";
                }else {
                    $sel="";
                    $display=" display:none; ";
                }
                if ($value['status']!="active") $colx=" color:#f00; font-style:italic; text-decoration: line-through ";
                    else $colx="";
                $content_t .="<li class=\"_store_my_items_".$value['id']." ".$sel." all_tab_langdesc\"><a href=\"javascript:void(0);\"><span id=\"\" class=\"ow_ic_plugin change_lang_description\" idl=\"".$value['id']."\" style=\"".$colx."\">".$value['label']."</span></a></li>";


                if (!$colx AND !$was_old_lang AND $content AND !$content_readed){
//                    $content_readed .=$content;
                    $was_old_lang=1;
//$content="";
                }else if (!$colx AND !$was_old_lang){
                    $was_old_lang=1;
                }


                $content_d .="<div id=\"tpdesc_lang_".$value['id']."\" class=\"all_lang_desc\" style=\"".$display."\">";
                if ($id_product>0){
                    $sql = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products_description WHERE id_product_de='".addslashes($id_product)."' AND id_lang_de='".addslashes($value['id'])."' LIMIT 1";
                    $arrx = OW::getDbo()->queryForList($sql);
                    if (isset($arrx[0]) AND isset($arrx[0]['description_de'])){
                        $content_readed .=stripslashes($arrx[0]['description_de']);
                        $content_d .="<textarea id=\"pdesc_lang_".$value['id']."\" class=\"html\" name=\"pdesc".$value['id']."\" style=\"height:300px;\">".$content_readed."</textarea>";
                    }else{
                        $content_d .="<textarea id=\"pdesc_lang_".$value['id']."\" class=\"html\" name=\"pdesc".$value['id']."\" style=\"height:300px;\">".$content_readed.$content."</textarea>";
                    }
                }else{
                    $content_d .="<textarea id=\"pdesc_lang_".$value['id']."\" class=\"html\" name=\"pdesc".$value['id']."\" style=\"height:300px;\">".$content_readed."</textarea>";
//                    $content_d .="<textarea id=\"pdesc\" name=\"pdesc\" class=\"html\" style=\"height:300px;\"></textarea>";
                }
                $content_d .="</div>";

            }


$content_t .="</ul>";
$content_t .="</div>";
//        $content_t .=$content_d.$content;
        $content_t .=$content_d;




        $content_t .="</div>";
        return $content_t;
    }



    public function make_tabs($selected=1,$content="")
    {
        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();
        $curent_url=OW_URL_HOME;
$content_t ="";
            $content_t .="<div class=\"ow_content\">";

            $page_on_top_shop=OW::getConfig()->getValue('shoppro', 'config_page_on_top_shop');
            if ($page_on_top_shop!=""){
                $content_t .="<div class=\"ow_content_menu_wrap ow_content_html\">";
                if (OW::getConfig()->getValue('shoppro', 'admin_replace_btobr')==1 AND !OW::getPluginManager()->isPluginActive('wysiwygeditor')){
                    $page_on_top_shop=SHOPPRO_BOL_Service::getInstance()->ntobr($page_on_top_shop);
                }
                $page_top_template="";
$page_top_template .="<div class=\"ow_dnd_widget index-PAGES_CMP_MenuWidget\">";

    if (OW::getConfig()->getValue('shoppro', 'config_page_on_top_shop_title')!=""){
    $page_top_template .="<div class=\"ow_box_cap_empty ow_dnd_configurable_component clearfix\">
        <div class=\"ow_box_cap_right\">
            <div class=\"ow_box_cap_body\">
                <h3 class=\"ow_ic_info\">".OW::getConfig()->getValue('shoppro', 'config_page_on_top_shop_title')."</h3>
            </div>
        </div>
    </div>";
    }

    $page_top_template .="<div class=\"ow_box_empty ow_stdmargin clearfix index-PAGES_CMP_MenuWidget ow_no_cap ow_break_word\" style=\"\">
        <div class=\"clearfix ow_left\" style=\"margin:10px;\">
            ".$page_on_top_shop."
        </div>
    </div>";

$page_top_template .="</div>";

            
                $content_t .=$page_top_template;
                $content_t .="</div>";
            }


$content_t .="<div class=\"ow_content_menu_wrap\">";
$content_t .="<ul class=\"ow_content_menu clearfix\">";
            if ($selected==1 OR $selected=="shop" OR !$selected) $sel=" active ";
                else $sel="";
    $content_t .="<li class=\"_store_my_items ".$sel."\"><a href=\"".$curent_url."shop\"><span class=\"ow_ic_plugin\">".OW::getLanguage()->text('shoppro', 'main_menu_item')."</span></a></li>";//moje zamówienia

        if ($id_user>0 OR $is_admin){
//        if ($is_admin){
            if ($selected=="basket") $sel=" active ";
                else $sel="";
    $content_t .="<li class=\"_store_my_items ".$sel."\"><a href=\"".$curent_url."basket/showbasket\"><span class=\"ow_ic_cart\">".OW::getLanguage()->text('shoppro', 'product_table_showbasket_mypursages')."</span></a></li>";//moje zamówienia
        }


    if  (SHOPPRO_BOL_Service::getInstance()->check_acces()){


//        if ($id_user>0 OR $is_admin){
        if (($id_user>0 AND OW::getConfig()->getValue('shoppro', 'mode_membercanshell')==1) OR $is_admin){
            if ($selected=="myitems") $sel=" active ";
                else $sel="";
            $content_t .="<li class=\"_store_my_items ".$sel."\"><a href=\"".$curent_url."shopmy/show\"><span class=\"ow_ic_plugin\">".OW::getLanguage()->text('shoppro', 'product_table_showmyitems')."</span></a></li>";//moje zamówienia
        }


//        $content_t .="<li class=\"_plugin \"><a href=\"http://www.oxwall.org/store\"><span class=\"ow_ic_plugin\">Plugins</span></a></li>";
//        $content_t .="<li class=\"_theme \"><a href=\"http://www.oxwall.org/store/themes\"><span class=\"ow_ic_plugin\">Themes</span></a></li>";
//        $content_t .="<li class=\"_store_purchase_list \"><a href=\"http://www.oxwall.org/store/granted-list\"><span class=\"ow_ic_cart\">My purchases</span></a></li>";
//        $content_t .="<li class=\"_store_my_items  active\"><a href=\"http://www.oxwall.org/store/list/my-items\"><span class=\"ow_ic_plugin\">My items</span></a></li>";
//        $content_t .="<li class=\"_store_dev_tools \"><a href=\"http://www.oxwall.org/store/dev-tools\"><span class=\"ow_ic_gear_wheel\">Developer tools</span></a></li>";


//        if (($id_user>0 AND OW::getConfig()->getValue('shoppro', 'mode_membercanshell')==1) OR $is_admin){
//        if ($id_user>0 AND $is_admin){
//        if ($id_user>0 OR $is_admin){
        if (($id_user>0 AND OW::getConfig()->getValue('shoppro', 'mode_membercanshell')==1) OR $is_admin){
            if ($selected==10 OR $selected=="admin") $sel=" active ";
                else $sel="";
            $content_t .="<li class=\"_store_dev_tools ".$sel."\"><a href=\"".$curent_url."ordershop/showorder\"><span class=\"ow_ic_gear_wheel\">".OW::getLanguage()->text('shoppro', 'product_table_showorder')."</span></a></li>";
        }


        if (OW::getConfig()->getValue('shoppro', 'mode_ads_approval') AND $is_admin AND $is_admin){
//            if ($id_user>0 AND $is_admin){
                if ($selected==11 OR $selected=="approval") $sel=" active ";
                    else $sel="";
                $content_t .="<li class=\"_store_dev_tools ".$sel."\"><a href=\"".$curent_url."ordershop/approval\"><span class=\"ow_ic_gear_wheel\">".OW::getLanguage()->text('shoppro', 'product_table_approvedlist')."</span></a></li>";
//            }
        }

                                if ($is_admin OR ($id_user>0 AND OW::getConfig()->getValue('shoppro', 'mode_membercanshell')==1) ){
//                                    $content .="&nbsp;|&nbsp;";
                
            if ($selected=="addnewproduct") $sel=" active ";
                else $sel="";
            $content_t .="<li class=\"_store_dev_tools ".$sel."\"><a href=\"".$curent_url."product/0/add\"><span class=\"ow_ic_add\">".OW::getLanguage()->text('shoppro', 'product_table_selyourproduct')."</span></a></li>";

        if ( OW::getPluginManager()->isPluginActive('cart')){
            if ($selected=="cart") $sel=" active ";
                else $sel="";
            $content_t .="<li class=\"_store_dev_tools ".$sel."\"><a href=\"".$curent_url."cart\"><span class=\"ow_ic_cart\">".OW::getLanguage()->text('cart', 'ta_cart')."</span></a></li>";
        }

        if (($id_user>0 AND OW::getConfig()->getValue('shoppro', 'mode_membercanshell')==1) OR $is_admin){
            if ($selected=="setting") $sel=" active ";
                else $sel="";
            $content_t .="<li class=\"_store_dev_tools ".$sel."\"><a href=\"".$curent_url."seller/setting\"><span class=\"ow_ic_gear_wheel\">".OW::getLanguage()->text('shoppro', 'seller_setting')."</span></a></li>";
        }


        if ($is_admin){
            if ($selected=="editc") $sel=" active ";
                else $sel="";
            $content_t .="<li class=\"_store_dev_tools ".$sel."\"><a href=\"".$curent_url."shop/editc/".substr(session_id(),3,3)."\"><span class=\"ow_ic_gear_wheel\">".OW::getLanguage()->text('shoppro', 'edit_categorys_groups')."</span></a></li>";
        }



/*
                                    $content .="<a href=\"".$curent_url."product/0/add\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_addnewproduct')."\">";
//                                    $content .= "[+]";
                                $content .= "<strong>";
                                $content .= "[+]";
                                $content .=OW::getLanguage()->text('shoppro', 'product_table_selyourproduct'); 
                                $content .="</strong>";
                                    $content .="</a>";
*/
                                }
    }//if  (SHOPPRO_BOL_Service::getInstance()->check_acces()){

$content_t .="</ul>";
$content_t .="</div>";
        $content_t .=$content;
        $content_t .="</div>";
        return $content_t;
    }








    public function editpage($params,$wtype="shop") 
    {

    $wssel_start="";    
        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();
if (isset($_GET['flang']) AND $_GET['flang']>0){
    $c_lang=$_GET['flang'];
}else{
    $c_lang=SHOPPRO_BOL_Service::getInstance()->get_curect_lang_id();
}

if ($params['options']=="edit" AND $params['idproduct']>0){
    $cmode="edit";
}else{
    $cmode="new";
}

                    $curent_url = 'http';
                    if (isset($_SERVER["HTTPS"])) {$curent_url .= "s";}
                    $curent_url .= "://";
                    $curent_url .= $_SERVER["SERVER_NAME"]."/";
        $is_points=SHOPPRO_BOL_Service::getInstance()->isplugin('usercredits');
        if (!OW::getConfig()->getValue('shoppro', 'mode_membercanpromotion')){
            $is_points=false;
        }

/*
        $role=explode(",",OW::getConfig()->getValue('shoppro', 'mode_member_role_cansale'));
        if (is_array($role) AND count($role)>0) {
            $is_role=1;
        }else{
            $is_role=0;
            $role=array();
        }
*/

//        echo "------------".$role;exit;
//$config->getValue('shoppro', 'mode_member_role_cansale')

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


        $content="";

//$content="afSD:".print_r($params,1);
        if (!$is_admin AND strlen(OW::getConfig()->getValue('shoppro', 'mode_member_accounttype_cansale'))>3){
            $curent_account_type=SHOPPRO_BOL_Service::getInstance()->get_curentuser_accounttype();
            if (OW::getConfig()->getValue('shoppro', 'mode_member_accounttype_cansale')==$curent_account_type) $acces_accountype=true;
                else $acces_accountype=false;
        }else{
            $acces_accountype=true;
        }
//echo $acces_accountype;exit;
        
//        if (!$is_admin AND OW::getConfig()->getValue('shoppro', 'mode_member_role_cansale')>0){
        if (!$is_admin){
//            if (!SHOPPRO_BOL_Service::getInstance()->check_userrole($id_user,OW::getConfig()->getValue('shoppro', 'mode_member_role_cansale'),"is")){
            if  (SHOPPRO_BOL_Service::getInstance()->check_acces()){
                $acces_roletype=true;
            }else{
                $acces_roletype=false;
            }
        }else if ($is_admin){
            $acces_roletype=true;
        }else{
            $acces_roletype=false;
        }
//echo OW::getConfig()->getValue('shoppro', 'mode_shop')."----".OW::getUser()->isAuthorized('shoppro', 'addclassifieds')."------".OW::getUser()->isAuthorized('shoppro', 'addshopproduct');
//echo "=====".$acces_roletype;exit;
//echo OW::getConfig()->getValue('shoppro', 'mode_member_accounttype_cansale')."--------".$curent_account_type;exit;
        if (!$is_admin AND ($acces_accountype==false OR $acces_roletype==false)){
            $content="<div style=\"text-align:center;margin-top:20px;\"><h1>".OW::getLanguage()->text('shoppro', 'cant_sel_product_acount_type')."</h1></div>";
            $content_t=$this->make_tabs("addnewproduct",$content);
//            $this->assign('content', $content_t);
            return $content_t;
        }else if (($acces_roletype AND $acces_accountype AND $id_user>0 AND OW::getConfig()->getValue('shoppro', 'mode_membercanshell')==1) OR $is_admin){
//        print_r($params);
            $ptitle="";
            $pdesc="";
            $pprice="";
            $ppaypal_currency="";
            $file_attach="";
$pitems="";
$paccount="";
$paccount_param="";

$date_promo=0;
$wssel="";


            if ($params['options']=="edit" AND $params['idproduct']>0){
                if ($c_lang>0) $add="";
                    else $add="";
                            if ($is_admin){
                                $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($params['idproduct'])."' LIMIT 1";
                            }else{
                                $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($params['idproduct'])."' AND id_owner='".addslashes($id_user)."' LIMIT 1";
                            }
                            $arrx = OW::getDbo()->queryForList($query);
                            $value=$arrx[0];
                
                            if (!$is_admin AND !$value['id']) OW::getApplication()->redirect($curent_url."shop");

                            $ptitle=stripslashes($value['name']);
                            $pdesc=stripslashes($value['description']);
                            $pprice=stripslashes($value['price']);
                            $ppaypal_currency=stripslashes($value['curency']);
                        $file_attach=stripslashes($value['file_attach']);

                            $paccount=stripslashes($value['seler_account']);
                            $paccount_param=stripslashes($value['seler_account_csc']);
            }else{
				$value['cat_id']="0";
				$value['name']="";
				$value['description']="";
				$value['price']="";
				$value['id_owner']="";
				$value['type_ads']="0";
				$value['publish_totime']="";
				$value['to_date']="";
				$value['promotion_date']="";
                                $value['has_options']=0;
    $value['date_promo']=0;

	    }

            

            if ($params['idproduct']==0 AND $params['options']!="edit"){
                $content .="<form id=\"edform\" action=\"".$curent_url."product/".$params['idproduct']."/adds\" method=\"POST\" enctype=\"multipart/form-data\">";
            }else{
                $content .="<form id=\"edform\" action=\"".$curent_url."product/".$params['idproduct']."/editu\" method=\"POST\" enctype=\"multipart/form-data\">";
            }

            if ($wtype=="mobile"){
                $content .="<input type=\"hidden\" name=\"wtype\" value=\"form_mobi\" />";
            }else{
                $content .="<input type=\"hidden\" name=\"wtype\" value=\"form_shop\" />";
            }

                    $cost_for_sale=OW::getConfig()->getValue('shoppro', 'mode_membermastpaybyseling');

$content .="<script>
$(document).ready(function() {";

$content .="

$('.change_lang_description').click(function() {
    $('.all_lang_desc').hide();
    $('#tpdesc_lang_'+$(this).attr('idl')).show();

    $('.all_tab_langdesc').removeClass('active');
    $('._store_my_items_'+$(this).attr('idl')).addClass('active');

    return false;
});



$('#price_one').click(function() {
        $('#price_one').attr('at','1');
        $('#price_options').attr('at','0');

        $('#price_one').addClass('ow_green');
        $('#price_options').removeClass('ow_green');

        $('#pay_nooption').show();
        $('#pay_option').hide();

if ($('#padstype').val()==0){
    $('#sell_file').hide();
    $('#sell_file_no').show();
}else if ($('#padstype').val()==2){
    $('#sell_file').show();
    $('#sell_file_no').hide();
}else if ($('#padstype').val()==1){
    $('#sell_file').show();
    $('#sell_file_no').hide();
}

        $('#f_price_type').val('one');
});

$('#price_options').click(function() {
        $('#price_one').attr('at','0');
        $('#price_options').attr('at','1');

        $('#price_options').addClass('ow_green');
        $('#price_one').removeClass('ow_green');

        $('#pay_nooption').hide();
        $('#pay_option').show();
$('#sell_file').hide();
$('#sell_file_no').show();

        $('#f_price_type').val('option');
});
";

if ($cost_for_sale>0 AND ($params['options']!="editu" AND !$params['idproduct']>0) ){
$content .="
$('#edform').submit(function() {
    if ($('#debit').attr('checked')!=true && $('#debit').attr('checked')!='checked'){
        alert('".OW::getLanguage()->text('shoppro', 'error_form_requirepayforsale')."');
        return false;
    }
    if (!$('#ptitle').val() || $('#ptitle').val()=='undefined'){
        alert('".OW::getLanguage()->text('shoppro', 'error_form_enetertitle')."');
        return false;
    }
    if ($('#pcat option:selected').val()==0 || !$('#pcat option:selected').val()){
        alert('".OW::getLanguage()->text('shoppro', 'error_form_selectcategory')."');
        return false;
    }
/*
    if ($('#padstype option:selected').val()==0 || !$('#padstype option:selected').val()){
//        if ($('#classifieds_type option:selected').val()==0 || !$('#padstype option:selected').val()){
        if ($('#classifieds_type option:selected').val()==undefined || !$('#padstype option:selected').val()){
            alert('".OW::getLanguage()->text('shoppro', 'error_form_select_classifieds_type')."');
            return false;
        }
    }
*/
    if ($('#padstype option:selected').val()==1){
//    if ($('#padstype option:selected').val()==1 || $('#padstype option:selected').val()==2){
        if (!$('#paccount').val() || $('#paccount').val()=='undefined'){
            alert('".OW::getLanguage()->text('shoppro', 'error_form_enter_email_seler')."');
            return false;
        }
    }
/*
//check desc disabled - TODO
    if (!$('#pdesc').val() || $('#pdesc').val()=='undefined'){
        alert('".OW::getLanguage()->text('shoppro', 'error_form_enterdescription')."');
        return false;
    }
*/


});
";

}else{
$content .="

$('#edform').submit(function() {
    if (!$('#ptitle').val() || $('#ptitle').val()=='undefined'){
        alert('".OW::getLanguage()->text('shoppro', 'error_form_enetertitle')."');
        return false;
    }
    if ($('#pcat option:selected').val()==0 || !$('#pcat option:selected').val()){
        alert('".OW::getLanguage()->text('shoppro', 'error_form_selectcategory')."');
        return false;
    }
/*
//check desc disabled - TODO
    if (!$('#pdesc').val() || $('#pdesc').val()=='undefined'){
        alert('".OW::getLanguage()->text('shoppro', 'error_form_enterdescription')."');
        return false;
    }
*/

    if ($('#padstype option:selected').val()==1){
//    if ($('#padstype option:selected').val()==1 || $('#padstype option:selected').val()==2){
        if (!$('#paccount').val() || $('#paccount').val()=='undefined'){
            alert('".OW::getLanguage()->text('shoppro', 'error_form_enter_email_seler')."');
            return false;
        }
    }

});
";
}

//ssssaronxxxaron
$allowshop=false;
$allowclassifieds=false;
if (
    (!OW::getConfig()->getValue('shoppro', 'mode_shop') OR OW::getConfig()->getValue('shoppro', 'mode_shop')=="all" OR  OW::getConfig()->getValue('shoppro', 'mode_shop')=="classifieds") 
        AND 
    (OW::getUser()->isAuthorized('shoppro', 'addclassifieds')) 
){
    $allowclassifieds=true;
}

if (
    (!OW::getConfig()->getValue('shoppro', 'mode_shop') OR OW::getConfig()->getValue('shoppro', 'mode_shop')=="all" OR  OW::getConfig()->getValue('shoppro', 'mode_shop')=="shop") 
        AND 
    (OW::getUser()->isAuthorized('shoppro', 'addshopproduct') OR $is_admin) 
){
    $allowshop=true;
}

if ($allowclassifieds AND $value['type_ads']!=2 AND ($value['type_ads']==0 OR !$value['type_ads'] OR !$allowshop)){//ads classifieds
    $content .="

//    $('#multi_payment').hide();
    $('#multi_payment').show();
    $('#payemail').hide();

//    $('#payemail').hide();
    $('#pay_curency').show();
    $('#pay_pointsinfo').hide();
        $('#classifieds_type').show();
    $('#sell_file').hide();
    $('#sell_file_no').show();
    $('#sel_items').hide();

    ";

}else if ($value['type_ads']==1 AND $allowshop){//shop
    $content .="

    $('#multi_payment').show();
    $('#payemail').show();
    $('#pay_curency').show();
    $('#pay_pointsinfo').hide();
    $('#classifieds_type').hide();
    $('#sel_items').show();

    ";

    if ($value['has_options']==1){
        $content .="
        $('#sell_file').hide();
        $('#sell_file_no').show();
        ";
    }else{
        $content .="
        $('#sell_file').show();
        $('#sell_file_no').hide();
        ";
    }

}else if ($value['type_ads']==2){//pay credits
    $content .="

    $('#multi_payment').hide();
    $('#payemail').hide();
    $('#pay_curency').hide();
    $('#pay_pointsinfo').show();
    $('#classifieds_type').hide();
    $('#sel_items').show();
    ";

    if ($value['has_options']==1){
        $content .="
        $('#sell_file').hide();
        $('#sell_file_no').show();
        ";
    }else{
        $content .="
        $('#sell_file').show();
        $('#sell_file_no').hide();
        ";
    }

}else{//-----------------------------------------default classified

//$wssel_start="$('#classifieds_type').hide();";
//$wssel_start="";
                            $wssel_start="
                                if ($('#padstype option:selected').val()==0){
                                    $('#classifieds_type').show();
                                }else{
                                    $('#classifieds_type').hide();
                                }
                            ";

                    if ($is_admin OR 
                        ((!OW::getConfig()->getValue('shoppro', 'mode_shop') OR OW::getConfig()->getValue('shoppro', 'mode_shop')=="all" OR  OW::getConfig()->getValue('shoppro', 'mode_shop')=="classifieds") AND (OW::getUser()->isAuthorized('shoppro', 'addclassifieds')) )
                    ){
                        if ($date_promo==0 OR !$date_promo) {
                            $wssel_start="$('#classifieds_type').show();";
                        }
                    }
                    if (SHOPPRO_BOL_Service::getInstance()->isplugin('usercredits') AND ($is_admin OR OW::getConfig()->getValue('shoppro', 'mode_membercanselingbypoints')==1)){
                        if ($date_promo==2) {
                            $wssel_start="$('#classifieds_type').hide();";
                        }
                    }
                    if ($is_admin OR 
                        ((!OW::getConfig()->getValue('shoppro', 'mode_shop') OR OW::getConfig()->getValue('shoppro', 'mode_shop')=="all" OR  OW::getConfig()->getValue('shoppro', 'mode_shop')=="shop") AND (OW::getUser()->isAuthorized('shoppro', 'addshopproduct')) )
                    ){
                        if ($date_promo==1 OR !$wssel) {
                            $wssel_start="
                                if ($('#padstype option:selected').val()==0){
                                    $('#classifieds_type').show();
                                }else{
                                    $('#classifieds_type').hide();
                                }
                            ";
                        }
                    }


$content .="
    if ($('#padstype').val()==1 || $('#padstype option:selected').val()==1){//shop

        $('#multi_payment').show();
        $('#payemail').show();



//        if ($('#price_one').attr('at')==0){
        if ($('#f_price_type').val()=='one'){
            $('#sell_file').show();
            $('#sell_file_no').hide();
        }else{
            $('#sell_file').hide();
            $('#sell_file_no').show();
        }

//alert('sss'+$('#f_price_type').val());


    }else{
//alert('ssssss');
//        $('#multi_payment').hide();
        $('#multi_payment').show();
        $('#payemail').hide();

//        if ($('#price_one').attr('at')==0){
        if ($('#f_price_type').val()=='one'){
            $('#sell_file').show();
            $('#sell_file_no').hide();
        }else{
            $('#sell_file').hide();
            $('#sell_file_no').show();
        }

    }
//    $('#payemail').show();
    $('#pay_curency').show();
    $('#pay_pointsinfo').hide();
//    $('#classifieds_type').show();
    ".$wssel_start."

//                    $('#sell_file').hide();
//                    $('#sell_file_no').show();
    $('#sel_items').hide();
";
}

$content .="
    $('#padstype').change(function () {
        if ($(this).val()==0){//classified
//            $('#multi_payment').hide();
            $('#multi_payment').show();
            $('#payemail').hide();

//            $('#payemail').hide();
            $('#pay_curency').show();
            $('#pay_pointsinfo').hide();
            $('#classifieds_type').show();
            $('#sell_file').hide();
            $('#sell_file_no').show();
            $('#sel_items').hide();
        }else if ($(this).val()==1){//shop
            $('#multi_payment').show();
            $('#pay_curency').show();
            $('#pay_pointsinfo').hide();
            $('#classifieds_type').hide();
            $('#payemail').show();
            if ($('#f_price_type').val()=='option') {
                $('#sell_file').hide();
                $('#sell_file_no').show();
            }else {
                $('#sell_file').show();
                $('#sell_file_no').hide();
            }
            $('#sel_items').show();
        }else if ($(this).val()==2){//credit
            $('#multi_payment').hide();
            $('#pay_curency').hide();
            $('#pay_pointsinfo').show();
            $('#classifieds_type').hide();
            $('#payemail').hide();
            if ($('#f_price_type').val()=='option') {
                $('#sell_file').hide();
                $('#sell_file_no').show();
            }else {
                $('#sell_file').show();
                $('#sell_file_no').hide();
            }
            $('#sel_items').show();
        }else{
            $('#multi_payment').show();
            $('#pay_curency').show();
            $('#pay_pointsinfo').hide();
//            $('#classifieds_type').show();
            ".$wssel_start."
            $('#payemail').show();
            $('#sell_file').hide();
            $('#sell_file_no').show();
            $('#sel_items').hide();
        }
    });
});
</script>";
/*
        var str = "";
        $('select option:selected').each(function () {
            str += $(this).text() + ' ';
        });
        $('div').text(str);
*/

            $content .="<table style=\"width:100%;margin:auto;\" class=\"ow_table_1 ow_form ow_stdmargin\">";
$you_can_sale=true;
//echo "fsdfSD".$is_points;exit;
            if ($is_points){
                if ($is_admin AND $value['id_owner']>0){
                    $pforuser=$value['id_owner'];
                }else{
                    $pforuser=$id_user;
                }
                    $query = "SELECT * FROM " . OW_DB_PREFIX. "usercredits_balance WHERE userId='".addslashes($pforuser)."' LIMIT 1";
                    $arrp = OW::getDbo()->queryForList($query);
                    if (isset($arrp[0])) {
                        $valuep=$arrp[0];
                    }else{
                        $valuep=array();
                        $valuep['balance']=0;
                    }



                if ($cost_for_sale>0 AND $valuep['balance']<$cost_for_sale AND ($params['options']!="editu" AND !$params['idproduct']>0)){
                        $you_can_sale=false;

        $content .="<tr class=\"ow_tr_first\">
            <th class=\"ow_name ow_txtleft\" colspan=\"2\">
                <span class=\"ow_section_icon ow_ic_gear_wheel\">".OW::getLanguage()->text('shoppro', 'cost_for_sale')."</span>
            </th>
        </tr>";

                        $content .="<tr>";
                        $content .="<td colspan=\"2\" style=\"margin:auto;border-bottom:1px solid #ddd;text-align:center;\">";
                        $content .="<h1 style=\"color:#f00;\">";
                        $content .=OW::getLanguage()->text('shoppro', 'error_forbaingyoumastpaypoints').": ".$cost_for_sale." ".OW::getLanguage()->text('shoppro', 'product_credits')."<br/>".OW::getLanguage()->text('shoppro', 'error_youhavetosmmalcredits');

                        $content .="<br/>";
                    $content .="<a href=\"".$curent_url."user-credits/buy-credits\">";
//                    $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_youhave_points')."</strong>";
                    $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_youhave_credits')."</strong>";
                    $content .=":</a>";
                        $content .="&nbsp;";
                    $content .="<a href=\"".$curent_url."user-credits/buy-credits\">";
                    $content .=$valuep['balance'];
                    $content .=":</a>";
                        $content .="&nbsp;&nbsp;&nbsp;";
                    $content .="<a href=\"".$curent_url."user-credits/buy-credits\">";
                    $content .="(".OW::getLanguage()->text('shoppro', 'product_buy_credits').")";
                    $content .="</a>";
                        $content .="</h1>";
                        $content .="</td>";
                        $content .="</tr>";


                }else{//if



        $content .="<tr class=\"ow_tr_first\">
            <th class=\"ow_name ow_txtleft\" colspan=\"2\">
                <span class=\"ow_section_icon ow_ic_gear_wheel\">".OW::getLanguage()->text('shoppro', 'cost_for_sale')."</span>
            </th>
        </tr>";

                    $content .="<tr>";
                    $content .="<td align=\"right\" valign=\"top\" style=\"min-width:250px;\">";
                    $content .="<a href=\"".$curent_url."user-credits/buy-credits\">";
                    $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_youhave_points')."</strong>";
                    $content .="</a>";
                    $content .="</td>";
                    $content .="<td valign=\"top\"style=\"\">";
                    $content .="<a href=\"".$curent_url."user-credits/buy-credits\">";
                    $content .=$valuep['balance'];
                    $content .="</a>";
                    $content .="&nbsp;";
                    $content .="<a href=\"".$curent_url."user-credits/buy-credits\">";
                    $content .="(".OW::getLanguage()->text('shoppro', 'product_buy_credits').")";
                    $content .="</a>";
                    $content .="</td>";
                    $content .="</tr>";


                    if ($cost_for_sale>0 AND ($params['options']!="editu" AND !$params['idproduct']>0) ){
                        $content .="<tr>";
                        $content .="<td align=\"right\" valign=\"top\" style=\"min-width:250px;\">";
                        $content .="<strong style=\"color:#f00;\">".OW::getLanguage()->text('shoppro', 'product_info_cost_sale');
                        $content .="<br/>".OW::getLanguage()->text('shoppro', 'product_require')." ***";
                        $content .="</strong>";
                        $content .="</td>";
                        $content .="<td valign=\"top\"style=\"\">";
                        $content .="<a href=\"".$curent_url."user-credits/buy-credits\">";
//                        $content .=$valuep['balance'];
                        $content .=$cost_for_sale." ".OW::getLanguage()->text('shoppro', 'product_credits');
                        $content .="</a>";
                        $content .="<br/>";
                        $content .="<input type=\"checkbox\" id=\"debit\" name=\"debit\" value=\"YES_".substr(session_id(),6,3)."\" />&nbsp;";
                        $content .=OW::getLanguage()->text('shoppro', 'product_agree_for_dec_credits');
//                        $content .="&nbsp;";
//                        $content .="<a href=\"".$curent_url."user-credits/buy-credits\">";
///                        $content .="(".OW::getLanguage()->text('shoppro', 'product_buy_credits').")";
//                        $content .="</a>";
                        $content .="</td>";
                        $content .="</tr>";
                    }



        $content .="<tr class=\"ow_tr_first\">
            <th class=\"ow_name ow_txtleft\" colspan=\"2\">
                <span class=\"ow_section_icon ow_ic_gear_wheel\">".OW::getLanguage()->text('shoppro', 'promotion_your_item')."</span>
            </th>
        </tr>";


                    $content .="<tr>";
                    $content .="<td align=\"right\" valign=\"top\" style=\"width:150px;\">";
                    $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_baypromotion_for_points')."</strong>";
                    $content .="</td>";
                    $content .="<td valign=\"top\">";
                    $content .="<input type=\"text\" name=\"pbay_promotion\" value=\"0\" style=\"width:80px;\">";
                    $content .="<br/>".OW::getLanguage()->text('shoppro', 'product_baypromotion_for_points_info');
/*
                $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_categories 
                        ORDER BY active DESC, sort, name";
                $arrc = OW::getDbo()->queryForList($query);

                $content .="<select name=\"pcat\">";
                if (!$value['cat_id']) $sel=" selected ";
                    else $sel="";
                $content .="<option ".$sel." value=\"0\">---- ".OW::getLanguage()->text('shoppro', 'product_table_select')." ----</option>";
                foreach ( $arrc as $valuec )
                {
                    if ($valuec['id']==$value['cat_id']) $sel=" selected ";
                        else $sel="";
                    $content .="<option ".$sel." value=\"".$valuec['id']."\">".stripslashes($valuec['name'])."</option>";
                }
                $content .="</select>";
*/
                    $content .="</td>";
                    $content .="</tr>";


                    $content .="<tr>";
                    $content .="<td colspan=\"2\" style=\"margin:auto;\">";
                    $content .="</td>";
                    $content .="</tr>";


                }//if uer can sale








//OW::getConfig()->getValue('shoppro', 'mode_membercanselingbypoints'));
//mode_membercanselingbypoints

//OW::getConfig()->getValue('shoppro', 'mode_membermastpaybyseling'));
//mode_membermastpaybyseling

//echo "sfsdF";exit;                

            }//end if is points


            if ($you_can_sale==true){

        $content .="<tr class=\"ow_tr_first\">
            <th class=\"ow_name ow_txtleft\" colspan=\"2\">
                <span class=\"ow_section_icon ow_ic_gear_wheel\">".OW::getLanguage()->text('shoppro', 'product_details')."</span>
            </th>
        </tr>";

                $content .="<tr>";
                $content .="<td align=\"right\" valign=\"top\" style=\"min-width:150px;\">";
if (!$is_points){//zeby ni ekrzyczal o zaplate punktami
        $content .="<input type=\"hidden\" id=\"debit\" name=\"debit\" checked=\"true\" value=\"YES_".substr(session_id(),6,3)."\" />";
}
                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_title')."</strong>";
                $content .="</td>";
                $content .="<td valign=\"top\">";
                $content .="<input type=\"text\" id=\"ptitle\" name=\"ptitle\" value=\"".$ptitle."\">";
                $content .="</td>";
                $content .="</tr>";

                $content .="<tr>";
                $content .="<td align=\"right\" valign=\"top\">";
                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_category')."</strong>";
                $content .="</td>";
                $content .="<td valign=\"top\">";
//$content .=$value['cat_id'];
                    $content .="<select id=\"pcat\" name=\"pcat\">";

                    if (!$value['cat_id']) {
                        $sel=" selected ";
                        $content .="<option ".$sel." value=\"0\">---- ".OW::getLanguage()->text('shoppro', 'product_table_select')." ----</option>";
                    }
                    $content .=SHOPPRO_BOL_Service::getInstance()->make_product_edit_category($value['cat_id']);
                    $content .="<option value=\"\" disabled></option>";

/*
                    $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_categories 
                            ORDER BY active DESC, sort, name";
                    $arrc = OW::getDbo()->queryForList($query);

                    foreach ( $arrc as $valuec )
                    {
                        if ($valuec['id']==$value['cat_id']) $sel=" selected ";
                            else $sel="";
                        $content .="<option ".$sel." value=\"".$valuec['id']."\">".stripslashes($valuec['name'])."</option>";
                    }
*/
                    $content .="</select>";

                $content .="</td>";
                $content .="</tr>";



                $content .="<tr>";
                $content .="<td align=\"right\" valign=\"top\">";
                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_timepublish')."</strong>";
                $content .="</td>";
                $content .="<td valign=\"top\">";
                $date_promo=$value['to_date'];
                $days_promo=$value['publish_totime'];
                if ($date_promo>0 OR $days_promo>0){
                    if ($date_promo=="360") {
                        $content .="<b>";
                        $content .=OW::getLanguage()->text('shoppro', 'product_table_unlimited');
                        $content .="</b> (<i>".OW::getLanguage()->text('shoppro', 'you_can_not_changeineditmode')."</i>)";
                    }else {
                        $content .="<b>";
                        $content .=$days_promo." ".OW::getLanguage()->text('shoppro', 'product_table_days');
                        
                        $today=strtotime(date('Y-m-d H:i:s'));
                        $days_left=$date_promo-$today;
                        $days=round($days_left/24/60/60,0);
                        if ($days>0){
                            $content .="&nbsp(".$days.")";
                        }else{
                            $content .="&nbsp(0)";
                        }
//                    $valuec['id']
//                        $content .="</b> (<i>".OW::getLanguage()->text('shoppro', 'you_can_not_changeineditmode')."</i>)";
                    $content .="<br/>";
                    $content .="<select name=\"pthowlong\">";
                    if ($days_promo==7) $sel=" selected ";
                        else $sel="";
                    $content .="<option ".$sel." value=\"7\"> 7 ".OW::getLanguage()->text('shoppro', 'product_table_days')."</option>";
                    if ($days_promo==14 OR !$date_promo) $sel=" selected ";
                        else $sel="";
                    $content .="<option ".$sel." value=\"14\"> 14 ".OW::getLanguage()->text('shoppro', 'product_table_days')."</option>";
                    if ($days_promo==30) $sel=" selected ";
                        else $sel="";
                    $content .="<option ".$sel." value=\"30\"> 30 ".OW::getLanguage()->text('shoppro', 'product_table_days')."</option>";
                    if ($days_promo==60) $sel=" selected ";
                        else $sel="";
                    $content .="<option ".$sel." value=\"60\"> 60 ".OW::getLanguage()->text('shoppro', 'product_table_days')."</option>";
                    if ($days_promo=="360") $sel=" selected ";
                        else $sel="";
                    $content .="<option ".$sel." value=\"360\">".OW::getLanguage()->text('shoppro', 'product_table_unlimited')."</option>";

                    $content .="</select>";


                    }
                }else{
                    if (!$date_promo){
                        $date_promo=14;
                    }
                    $content .="<select name=\"pthowlong\">";
                    if ($date_promo==7) $sel=" selected ";
                        else $sel="";
                    $content .="<option ".$sel." value=\"7\"> 7 ".OW::getLanguage()->text('shoppro', 'product_table_days')."</option>";
                    if ($date_promo==14 OR !$date_promo) $sel=" selected ";
                        else $sel="";
                    $content .="<option ".$sel." value=\"14\"> 14 ".OW::getLanguage()->text('shoppro', 'product_table_days')."</option>";
                    if ($date_promo==30) $sel=" selected ";
                        else $sel="";
                    $content .="<option ".$sel." value=\"30\"> 30 ".OW::getLanguage()->text('shoppro', 'product_table_days')."</option>";
                    if ($date_promo==60) $sel=" selected ";
                        else $sel="";
                    $content .="<option ".$sel." value=\"60\"> 60 ".OW::getLanguage()->text('shoppro', 'product_table_days')."</option>";
                    if ($date_promo=="360") $sel=" selected ";
                        else $sel="";
                    $content .="<option ".$sel." value=\"360\">".OW::getLanguage()->text('shoppro', 'product_table_unlimited')."</option>";

                    $content .="</select>";

                }

                $content .="</td>";
                $content .="</tr>";


            if (!OW::getConfig()->getValue('shoppro', 'hide_condition')){
                $content .="<tr id=\"condition\">";
                $content .="<td align=\"right\" valign=\"top\">";
                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_condition')."</strong>";
                $content .="</td>";
                $content .="<td valign=\"top\">";
                    if (isset($value['condition'])){
                        $date_promo=$value['condition'];
                    }else{
                        $date_promo="";
                    }
                    $content .="<select id=\"pcondition\" name=\"pcondition\">";
                    if ($date_promo==0 OR !$date_promo) $sel=" selected ";
                        else $sel="";
                    $content .="<option ".$sel." value=\"0\">--- ".OW::getLanguage()->text('shoppro', 'product_condition_na')." ---</option>";

                    if ($date_promo==1) $sel=" selected ";
                        else $sel="";
                    $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'product_condition_new')."</option>";

                    if ($date_promo==2) $sel=" selected ";
                        else $sel="";
                    $content .="<option ".$sel." value=\"2\">".OW::getLanguage()->text('shoppro', 'product_condition_used')."</option>";

                    $content .="</select>";
                $content .="</td>";
                $content .="</tr>";
            }

                if (!OW::getConfig()->getValue('shoppro', 'hide_location')){
                    $content .="<tr>";
                    $content .="<td align=\"right\" valign=\"top\">";
                    $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_location')."</strong>";
                    $content .="</td>";
                    $content .="<td valign=\"top\">";
                    if (!isset($value['location'])) $value['location']="";
                    $content .="<input type=\"text\" name=\"plocation\" value=\"".$value['location']."\" style=\"width:50%;\">";
                    $content .="</td>";
                    $content .="</tr>";
                }


                if (!OW::getConfig()->getValue('shoppro', 'hide_map_lat_lon')){
                    $content .="<tr>";
                    $content .="<td align=\"right\" valign=\"top\">";
                    $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_map_location')."</strong>";
                    $content .="</td>";
                    $content .="<td valign=\"top\">";
                    $val1="";
                    $val2="";
                    if (isset($value['map_lat'])) $val1=$value['map_lat'];
                    if (isset($value['map_lan'])) $val2=$value['map_lan'];
                    $content .="<strong>".OW::getLanguage()->text('shoppro', 'map_lat')."</strong>: ";
                    $content .="<input type=\"text\" name=\"map_lat\" value=\"".$val1."\" style=\"max-width:150px;\">";
                    $content .=", ";
                    $content .="<strong>".OW::getLanguage()->text('shoppro', 'map_lan')."</strong>: ";
                    $content .="<input type=\"text\" name=\"map_lan\" value=\"".$val2."\" style=\"max-width:150px;\">";
                    $content .="</td>";
                    $content .="</tr>";
                }




        if ($cmode=="edit"){
                $content .="<tr>";
                $content .="<td align=\"right\" valign=\"top\" colspan=\"2\" style=\"margin:auto;\">";
//            $content .="<input type=\"submit\" name=\"submit\" value=\"Submit\" />";

//                $content .="<div class=\"ow_right\"><span class=\"ow_button ow_ic_save ow_positive\"><span>
//                <input type=\"button\" value=\"Submit\" class=\"ow_ic_save ow_positive\" onclick=\"this.form.submit()\"></span></span></div>";
/*
                $content .="<div class=\"ow_right\">
                    <span class=\"ow_button ow_ic_save ow_positive\">
                        <span>
                            <input type=\"submit\" value=\"Submit\" class=\"ow_ic_save ow_positive\" >
                        </span>
                    </span>
                </div>";
*/

            $content .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_right\">
                    <span class=\"ow_button\">
                        <span class=\"ow_positive\">
                            <input type=\"submit\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'config_save')."\" class=\"ow_ic_save ow_positive\">
                        </span>
                    </span>
                </div>
            </div>";

                $content .="</td>";
                $content .="</tr>";
        }            


        $content .="<tr class=\"ow_tr_first\">
            <th class=\"ow_name ow_txtleft\" colspan=\"2\">
                <span class=\"ow_section_icon ow_ic_gear_wheel\">".OW::getLanguage()->text('shoppro', 'selling_mode')."</span>
            </th>
        </tr>";










            

//----------------------------------------eeeeee start
                $content_t="";//move bottm
//                $content .="<td valign=\"top\">";


                    $date_promo=$value['type_ads'];
                $disabled="";
/*
                if ($cmode=="edit"){
                    if (!$date_promo) $date_promo=0;
                    $content_t .="<input type=\"hidden\" name=\"padstype\" value=\"".$date_promo."\">";
                    $disabled=" DISABLED ";
                }
*/


                    $option="";
                    $option_only_one="";
//                    if ($cmode!="edit"){
//                        $content_t .="<select id=\"padstype\" name=\"padstype\" ".$disabled.">";
//                    }

                    $wssel=false;
                    $only_one=0;
                    if ($is_admin OR 
                        ((!OW::getConfig()->getValue('shoppro', 'mode_shop') OR OW::getConfig()->getValue('shoppro', 'mode_shop')=="all" OR  OW::getConfig()->getValue('shoppro', 'mode_shop')=="classifieds") AND (OW::getUser()->isAuthorized('shoppro', 'addclassifieds')) )
                    ){
                        if ($date_promo==0 OR !$date_promo) {
                            $sel=" selected ";
                            $wssel=true;
                        } else $sel="";


                            if ($cmode=="edit" AND $sel){
                                $content_t .="<b>".OW::getLanguage()->text('shoppro', 'product_table_add_type_classified')."</b> (<i>".OW::getLanguage()->text('shoppro', 'you_can_not_changeineditmode')."</i>)";
                                $content_t .="<input type=\"hidden\" name=\"padstype\" value=\"0\">";
                            }else{
                                if ($cmode!="edit"){
                                    $option_only_one="<input type=\"hidden\" id=\"padstype\" name=\"padstype\" value=\"0\">".OW::getLanguage()->text('shoppro', 'product_table_add_type_classified');
                                    $option .="<option ".$sel." value=\"0\">".OW::getLanguage()->text('shoppro', 'product_table_add_type_classified')."</option>";
                                    $only_one++;
                                }
                            }
                    }
                    if (SHOPPRO_BOL_Service::getInstance()->isplugin('usercredits') AND ($is_admin OR OW::getConfig()->getValue('shoppro', 'mode_membercanselingbypoints')==1)){
                        if ($date_promo==2) {
                            $sel=" selected ";
                            $wssel=true;
                        }else $sel="";

                            if ($cmode=="edit" AND $sel){
                                $content_t .="<b>".OW::getLanguage()->text('shoppro', 'product_table_add_type_paybaycredits')."</b> (<i>".OW::getLanguage()->text('shoppro', 'you_can_not_changeineditmode')."</i>)";
                                $content_t .="<input type=\"hidden\" name=\"padstype\" value=\"2\">2";
                            }else{
                                if ($cmode!="edit"){
                                    $option_only_one="<input type=\"hidden\" id=\"padstype\" name=\"padstype\" value=\"2\">".OW::getLanguage()->text('shoppro', 'product_table_add_type_paybaycredits');
                                    $option .="<option ".$sel." value=\"2\">".OW::getLanguage()->text('shoppro', 'product_table_add_type_paybaycredits')."</option>";
                                    $only_one++;
                                }
                            }
                    }

                    if ($is_admin OR 
                        ((!OW::getConfig()->getValue('shoppro', 'mode_shop') OR OW::getConfig()->getValue('shoppro', 'mode_shop')=="all" OR  OW::getConfig()->getValue('shoppro', 'mode_shop')=="shop") 
                        AND 
                        (OW::getUser()->isAuthorized('shoppro', 'addshopproduct')) )
                    ){
                        if ($date_promo==1 OR !$wssel) {
                            $sel=" selected ";
                            $wssel=true;
                        }else $sel="";


                            if ($cmode=="edit" AND $sel){
                                $content_t .="<b>".OW::getLanguage()->text('shoppro', 'product_table_add_type_shop')."</b> (<i>".OW::getLanguage()->text('shoppro', 'you_can_not_changeineditmode')."</i>)";
                                $content_t .="<input type=\"hidden\" name=\"padstype\" value=\"1\">";
                            }else{
                                if ($cmode!="edit"){
                                    $option_only_one="<input type=\"hidden\" id=\"padstype\" name=\"padstype\" value=\"1\">".OW::getLanguage()->text('shoppro', 'product_table_add_type_shop');
                                    $option .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'product_table_add_type_shop')."</option>";
                                    $only_one++;
                                }
                            }
                    }

                    if ($only_one==1){
                        $content_t .=$option_only_one;
                    }else{
                        if ($cmode!="edit"){
                            $content_t .="<select id=\"padstype\" name=\"padstype\" ".$disabled.">";
                            $content_t .=$option;
                            $content_t .="</select>";
                                $content_t .="<br/>".OW::getLanguage()->text('shoppro', 'product_table_adstype_info');
                        }
                    }
            

//                if ($cmode!="edit"){
//                   $content .="<br/>".OW::getLanguage()->text('shoppro', 'product_table_adstype_info');                    
//                }






                if ($only_one==1){
                    $content .="<tr style=\"display:none;\">";
                }else{
                    $content .="<tr>";

                }

                $content .="<td align=\"right\" valign=\"top\">";
                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_adstype')."</strong>";
                $content .="</td>";
            
                $content .="<td valign=\"top\">";
                $content .=$content_t;
                $content .="</td>";
                $content .="</tr>";
//----------------------------------------eeeee end

                    if (isset($value['items'])) {
                        $pitems=$value['items'];
                    }else{
                        $pitems="";
                    }
                    if ($params['options']!="edit" AND !$params['idproduct']>0){
                        if (!$pitems) $pitems=1;
                    }
                    $content .="<tr id=\"sel_items\" >";
                    $content .="<td align=\"right\" valign=\"top\">";
                    $content .="<strong>".OW::getLanguage()->text('shoppro', 'config_items')."</strong>";
                    $content .="</td>";
                    $content .="<td valign=\"top\">";
                    $content .="<input type=\"text\" id=\"pitems\" name=\"pitems\" value=\"".$pitems."\" style=\"width:120px;\">";
                    $content .="</td>";
                    $content .="</tr>";



if (isset($value['has_options']) AND $value['has_options']==1){
    $has_option=true;
}else{
    $has_option=false;
}


                $content .="<tr id=\"multi_payment\" class=\"\" >";
                $content .="<td align=\"right\" valign=\"top\">";
                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_price')."</strong>";
                $content .="</td>";
                $content .="<td align=\"left\" valign=\"top\">";
//                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_price')."</strong>";


//$content .="<br/>";
//$content .="<a class=\"ow_lbutton\" href=\"http://www.oxwall.a6.pl/admin/plugins/mailbox\">Settings</a>";
//$content .="<a class=\"ow_lbutton ow_red\" href=\"http://www.oxwall.a6.pl/admin/plugins/deactivate/key/mailbox/\">Deactivate</a>";
//$content .="<a class=\"ow_lbutton ow_green\" href=\"http://www.oxwall.a6.pl/admin/plugins/deactivate/key/mailbox/\">Deactivate</a>";
if ($has_option){
    $content .="<input type=\"hidden\" id=\"f_price_type\" name=\"f_price_type\" value=\"option\">";
    $content .="<a id=\"price_one\" at=\"0\" class=\"ow_lbutton\" href=\"javascript:void(0);\">".OW::getLanguage()->text('shoppro', 'price_one')."</a>";
    $content .="&nbsp;";
    $content .="<a id=\"price_options\" at=\"1\" class=\"ow_lbutton ow_green\" href=\"javascript:void(0);\">".OW::getLanguage()->text('shoppro', 'price_options')."</a>";
}else{
    $content .="<input type=\"hidden\" id=\"f_price_type\" name=\"f_price_type\" value=\"one\">";
    $content .="<a id=\"price_one\" at=\"1\" class=\"ow_lbutton ow_green\" href=\"javascript:void(0);\">".OW::getLanguage()->text('shoppro', 'price_one')."</a>";
    $content .="&nbsp;";
    $content .="<a id=\"price_options\" at=\"0\" class=\"ow_lbutton\" href=\"javascript:void(0);\">".OW::getLanguage()->text('shoppro', 'price_options')."</a>";
}
                    $content .="</td>";
                    $content .="</tr>";


//-----single
                if ($has_option){
                    $content .="<tr id=\"pay_nooption\" class=\"price_type ow_hidden\" >";
                }else{
                    $content .="<tr id=\"pay_nooption\" class=\"price_type ow_show\" >";
                }
                $content .="<td align=\"right\" valign=\"top\">";
//                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_price')."</strong>";

//$content .="<a class=\"ow_lbutton\" href=\"http://www.oxwall.a6.pl/admin/plugins/mailbox\">Settings</a>";
//$content .="<a class=\"ow_lbutton ow_red\" href=\"http://www.oxwall.a6.pl/admin/plugins/deactivate/key/mailbox/\">Deactivate</a>";
//$content .="<a class=\"ow_lbutton ow_green\" href=\"http://www.oxwall.a6.pl/admin/plugins/deactivate/key/mailbox/\">Deactivate</a>";

/*
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
*/


                $content .="</td>";
                $content .="<td valign=\"top\">";
                $content .="<input type=\"text\" name=\"pprice\" value=\"".$pprice."\" style=\"width:80px;\">";
$content .="&nbsp;";
                $content .="<div id=\"pay_pointsinfo\" style=\"display:inline-block;\"><strong style=\"color:#8f8;\">".strtoupper(OW::getLanguage()->text('shoppro', 'product_credits'))."</strong></div>";




//                if ($ppaypal_currency) $paypal_currency=$ppaypal_currency;
//                    else $paypal_currency=OW::getConfig()->getValue('shoppro', 'paypal_currency');
                if (OW::getConfig()->getValue('shoppro', 'mode_shop')=="classifieds"){
                    $paypal_currency=OW::getConfig()->getValue('base', 'billing_currency');
                }else{
                    if ($ppaypal_currency) $paypal_currency=$ppaypal_currency;
                        else $paypal_currency=OW::getConfig()->getValue('shoppro', 'paypal_currency');
                }


//$content .=$paypal_currency."|".$ppaypal_currency."|".OW::getConfig()->getValue('shoppro', 'paypal_currency');    

                $content .="<select name=\"ppaypal_currency\" id=\"pay_curency\" >";

                $content .=SHOPPRO_BOL_Service::getInstance()->get_curency_paypal_options($paypal_currency);

                $content .="</select>";


                $content .="</td>";
                $content .="</tr>";

//-----options
                if ($has_option){
                    $content .="<tr id=\"pay_option\" class=\"price_type ow_show\" >";
                }else{
                    $content .="<tr id=\"pay_option\" class=\"price_type ow_hidden\" >";
                }
                $content .="<td align=\"right\" valign=\"top\">";
//                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_price')."</strong>";
                $content .="</td>";
                $content .="<td valign=\"top\">";

                $mpid=0;
                if (isset($value['id']) AND $value['id']>0){
                    $mpid=$value['id'];
                }
                
                    $content_tmp =SHOPPRO_BOL_Service::getInstance()->make_paymet_options($mpid,"edit");
                    if ($content_tmp){
                        $content .="<table>";
                    $content .="<tr>";
                    $content .="<th>";
                    $content .=OW::getLanguage()->text('shoppro', 'op_lp');
                    $content .="</th>";
                    $content .="<th>";
                    $content .=OW::getLanguage()->text('shoppro', 'op_name');
                    $content .="</th>";
                    $content .="<th>";
                    $content .=OW::getLanguage()->text('shoppro', 'op_price');
                    $content .="</th>";
                    $content .="<th>";
                    $content .=OW::getLanguage()->text('shoppro', 'op_currencyx');
                    $content .="</th>";
                    $content .="<th>";
                    $content .=OW::getLanguage()->text('shoppro', 'op_items');
                    $content .="</th>";
                    $content .="<th>";
                    $content .=OW::getLanguage()->text('shoppro', 'op_inlimitedx');
                    $content .="</th>";
                    $content .="<th>";
                    $content .=OW::getLanguage()->text('shoppro', 'product_table_sort');
                    $content .="</th>";
                    $content .="</tr>";
                        $content .=$content_tmp;

                    $content .="<tr>";
                    $content .="<td colspan=\"7\">";
                    $content .=OW::getLanguage()->text('shoppro', 'op_info_options');
                    $content .="</td>";
                    $content .="</tr>";
                        $content .="</table>";
                    }

                
//                $content .="<input type=\"hidden\" name=\"opprice\" value=\"option\" style=\"width:80px;\">";
/*
                $content .="<div id=\"pay_pointsinfo\" style=\"display:inline-block;\"><strong style=\"color:#8f8;\">".strtoupper(OW::getLanguage()->text('shoppro', 'product_credits'))."</strong></div>";
    
                $content .="<select name=\"ppaypal_currency\" id=\"pay_curency\" >";

                if ($ppaypal_currency) $paypal_currency=$ppaypal_currency;
                    else $paypal_currency=OW::getConfig()->getValue('shoppro', 'paypal_currency');

                $content .=SHOPPRO_BOL_Service::getInstance()->get_curency_paypal_options($ppaypal_currency);
*/
//                $content .="</select>";


                $content .="</td>";
                $content .="</tr>";
















                if (OW::getConfig()->getValue('shoppro', 'mode_payment')=="pay24"){
                    $content .="<tr id=\"payemail\">";
                    $content .="<td align=\"right\" valign=\"top\">";
                    $content .="<strong>".OW::getLanguage()->text('shoppro', 'config_pay24_account')."</strong>";
                    $content .="</td>";
                    $content .="<td valign=\"top\">";
                    $content .="<input type=\"text\" id=\"paccount\" name=\"paccount\" value=\"".$paccount."\" style=\"width:160px;\">";

                    $content .=",<strong>".OW::getLanguage()->text('shoppro', 'config_pay24_account_crc').":</strong>";
                    $content .="<input type=\"text\" name=\"paccount_csc\" value=\"".$paccount_param."\" style=\"width:200px;\">";
                    $content .="</td>";
                    $content .="</tr>";
                }else if (OW::getConfig()->getValue('shoppro', 'mode_payment')=="przelewy24"){
                    $content .="<tr id=\"payemail\">";
                    $content .="<td align=\"right\" valign=\"top\">";
                    $content .="<strong>".OW::getLanguage()->text('shoppro', 'config_przelewy24_account')."</strong>";
                    $content .="</td>";
                    $content .="<td valign=\"top\">";
                    $content .="<input type=\"text\" id=\"paccount\" name=\"paccount\" value=\"".$paccount."\" style=\"width:160px;\">";
/*
                    $content .=",<strong>".OW::getLanguage()->text('shoppro', 'config_przelewy24_account_crc').":</strong>";
                    $content .="<input type=\"text\" name=\"paccount_csc\" value=\"".$paccount_param."\" style=\"width:200px;\">";
*/
                    $content .="</td>";
                    $content .="</tr>";
                }else if (OW::getConfig()->getValue('shoppro', 'mode_payment')=="webtopay"){
                    $content .="<tr id=\"payemail\">";
                    $content .="<td align=\"right\" valign=\"top\">";
                    $content .="<strong>".OW::getLanguage()->text('shoppro', 'config_webtopay_account')."</strong>";
                    $content .="</td>";
                    $content .="<td valign=\"top\">";
                    $content .="<input type=\"text\" id=\"paccount\" name=\"paccount\" value=\"".$paccount."\" style=\"width:160px;\">";

                    $content .=",<div><strong>".OW::getLanguage()->text('shoppro', 'config_webtopay_account_crc')."</strong></div>";

                    $content .="<input type=\"text\" name=\"paccount_csc\" value=\"".$paccount_param."\" style=\"width:200px;\">";

                    $content .="</td>";
                    $content .="</tr>";
                }else {
                    $content .="<tr id=\"payemail\" >";
                    $content .="<td align=\"right\" valign=\"top\">";
                    $content .="<strong>".OW::getLanguage()->text('shoppro', 'config_paypal_account')."</strong>";
                    $content .="</td>";
                    $content .="<td valign=\"top\">";
                    $content .="<input type=\"text\" id=\"paccount\" name=\"paccount\" value=\"".$paccount."\" style=\"width:160px;\">";
                    $content .="</td>";
                    $content .="</tr>";
                }

            if (!OW::getConfig()->getValue('shoppro', 'hide_wanted_avaiable')){
                $content .="<tr id=\"classifieds_type\">";
                $content .="<td align=\"right\" valign=\"top\">";
                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_type_classifieds')."</strong>";
                $content .="</td>";
                $content .="<td valign=\"top\">";
                    if (isset($value['classifieds_type'])){
                    $date_promo=$value['classifieds_type'];
                    }else{
                        $date_promo="";
                    }
                    $content .="<select id=\"pclassifieds_type\" name=\"pclassifieds_type\">";
                    if (!$date_promo OR $date_promo=="0"){
                        if ($date_promo=="0" OR !$date_promo) $sel=" selected ";
                            else $sel="";
                        $content .="<option ".$sel." value=\"0\">--- ".OW::getLanguage()->text('shoppro', 'product_select_type_classifieds')." ---</option>";
                    }

                    if ($date_promo==1) $sel=" selected ";
                        else $sel="";
                    $content .="<option ".$sel." value=\"1\">".OW::getLanguage()->text('shoppro', 'product_available')."</option>";

                    if ($date_promo==2) $sel=" selected ";
                        else $sel="";
                    $content .="<option ".$sel." value=\"2\">".OW::getLanguage()->text('shoppro', 'product_wanted')."</option>";

                    $content .="</select>";
                $content .="</td>";
                $content .="</tr>";
            }


                    $content .="<tr>";
                    $content .="<td colspan=\"2\" style=\"margin:auto;\">";
                    $content .="<br/>&nbsp;";
                    $content .="</td>";
                    $content .="</tr>";



//------------------------file
                if (OW::getConfig()->getValue('shoppro', 'mode_sellfiles')==1){
/*
        $content .="<tr class=\"ow_tr_first\">
            <th class=\"ow_name ow_txtleft\" colspan=\"2\">
                <span class=\"ow_section_icon ow_ic_gear_wheel\">".OW::getLanguage()->text('shoppro', 'product_downloadable_file')."</span>
            </th>
        </tr>";
*/
                    $content .="<tr id=\"sell_file\" class=\"ow_alt2 ow_hidden\">";
                    $content .="<td align=\"right\" valign=\"top\">";
                    $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_procuctfile')."</strong>";
                    $content .="</td>";
                    $content .="<td valign=\"top\" nowrap=\"nowrap\" class=\"ow_alt2\">";
                    $content .="<input type=\"file\" name=\"selfile\" id=\"selfile\" />";


                    if ($params['options']=="edit" AND $params['idproduct']>0 AND $file_attach){
                                $pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();
                                $pluginStaticURL =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesUrl();
                                $pluginStaticDir =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesDir();
                                $product_file="ow_userfiles/plugins/shoppro/files/file_".$value['id']."_".$file_attach.".pack";
                                $prfile="file_".$value['id']."_".$file_attach.".pack";
                                if (is_file($pluginStaticDir."files/".$prfile)){
                                    $is_file=true;
//                                    $product_image=$curent_url.$product_file;
                                }else{
                                    $is_file=false;
//                                    $product_image="";
                                }
//echo $product_image;
                        if ($product_file AND $is_file){
                            $content .="<br/>&nbsp;";

                            $content .="<b>".OW::getLanguage()->text('shoppro', 'product_table_isfilefordownload')."</b>";
                            $content .=", ".OW::getLanguage()->text('shoppro', 'product_table_deletefile').": ";
                            $content .="<input type=\"checkbox\" name=\"delfile\" value=\"1\">";
                            $content .="<div class=\"ow_right\">";
                            $content .=SHOPPRO_BOL_Service::getInstance()->make_file_downloadurl($value,"id");
                            $content .="</div";
                        }else{
                            $content .="<br/>";
                            $content .="<i>".OW::getLanguage()->text('shoppro', 'product_table_nofileinthisproduct')."</i>";
                        }
                    }
//$content .=$pluginStaticDir."files/".$prfile;
                    $content .="</td>";
                    $content .="</tr>";



                    $content .="<tr id=\"sell_file_no\" class=\"ow_alt2 ow_hidden\">";
                    $content .="<td align=\"right\" valign=\"top\">";
                    $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_procuctfile')."</strong>";
                    $content .="</td>";
                    $content .="<td valign=\"top\" nowrap=\"nowrap\" class=\"ow_alt2\">";
                    $content .=OW::getLanguage()->text('shoppro', 'selling_file_allowinmodeonly');
                    $content .="</td>";
                    $content .="</tr>";

                    $content .="<tr>";
                    $content .="<td colspan=\"2\" style=\"margin:auto;\">";
                    $content .="<br/>&nbsp;";
                    $content .="</td>";
                    $content .="</tr>";

                }


        $content .="<tr class=\"ow_tr_first\">
            <th class=\"ow_name ow_txtleft\" colspan=\"2\">
                <span class=\"ow_section_icon ow_ic_gear_wheel\">".OW::getLanguage()->text('shoppro', 'product_description')."</span>
            </th>
        </tr>";

/*
                $content .="<tr>";
                $content .="<td align=\"left\" valign=\"top\" colspan=\"2\">";
                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_description')."</strong>";
                $content .="</td>";
                $content .="</tr>";
*/
/*
                $content .="<tr>";
                $content .="<td align=\"left\" valign=\"top\" colspan=\"2\">";
//                $content .="ooo";
                $content .=SHOPPRO_BOL_Service::getInstance()->make_languages_tabs($c_lang);
                $content .="</td>";
                $content .="</tr>";
*/

                $content .="<tr>";
//                $content .="<td align=\"right\" valign=\"top\">";
//                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_description')."</strong>";
//                $content .="</td>";
                $content .="<td valign=\"top\" colspan=\"2\">";


                if ($wtype=="mobile"){
                    $pdesc=SHOPPRO_BOL_Service::getInstance()->brton($pdesc);
                }else if (OW::getConfig()->getValue('shoppro', 'admin_replace_btobr')==1 AND !OW::getPluginManager()->isPluginActive('wysiwygeditor')){
                    $pdesc=SHOPPRO_BOL_Service::getInstance()->brton($pdesc);
                }

//                $content .="<textarea id=\"pdesc\" name=\"pdesc\" style=\"height:300px;\">".$pdesc."</textarea>";

                $content .=SHOPPRO_BOL_Service::getInstance()->make_languages_tabs($c_lang,$params['idproduct'],$pdesc);


/*
$content .="<div class=\"ow_superwide ow_left\" >";

$content .="<div class=\"jhtmlarea ow_smallmargin\" >";
$content .="<div class=\"toolbar clearfix\" >xx";
$content .="</div>";

$content .="<div class=\"input_ws_cont\" >";
            $content .="<textarea name=\"pdesc\" style=\"height:300px;\">".$pdesc."</textarea>";
$content .="</div>";
$content .="</div>";

$content .="</div>";
*/

/*
        $buttons = array(
            BOL_TextFormatService::WS_BTN_BOLD,
            BOL_TextFormatService::WS_BTN_ITALIC,
            BOL_TextFormatService::WS_BTN_UNDERLINE,
            BOL_TextFormatService::WS_BTN_IMAGE,
            BOL_TextFormatService::WS_BTN_LINK,
            BOL_TextFormatService::WS_BTN_ORDERED_LIST,
            BOL_TextFormatService::WS_BTN_UNORDERED_LIST,
            BOL_TextFormatService::WS_BTN_MORE,
            BOL_TextFormatService::WS_BTN_SWITCH_HTML,
            BOL_TextFormatService::WS_BTN_HTML,
            BOL_TextFormatService::WS_BTN_VIDEO
        );
*/
//$massMailingForm = new Form('massMailingForm');
//$text = new OW::WysiwygTextarea('text');
//    $ff=new Form('ss');
//    $text =new $ff->WysiwygTextarea('text');
//$text = Form::getInstance()->WysiwygTextarea('text');

//$postTextArea = new WysiwygTextarea('post', $buttons);
/*
        $postTextArea->setSize(WysiwygTextarea::SIZE_L);
        $postTextArea->setLabel(OW::getLanguage()->text('blogs', 'save_form_lbl_post'));
//        $postTextArea->setValue($post->getPost());
        $postTextArea->setValue("sdgsdg");
        $postTextArea->setRequired(true);
*/
//$content .=$postTextArea;
//        $this->addElement($postTextArea);



                $content .="</td>";
                $content .="</tr>";


        if ($cmode=="edit"){
                $content .="<tr>";
                $content .="<td align=\"right\" valign=\"top\" colspan=\"2\">";
//            $content .="<input type=\"submit\" name=\"submit\" value=\"Submit\" />";

//                $content .="<div class=\"ow_right\"><span class=\"ow_button ow_ic_save ow_positive\"><span>
//                <input type=\"button\" value=\"Submit\" class=\"ow_ic_save ow_positive\" onclick=\"this.form.submit()\"></span></span></div>";
/*
                $content .="<div class=\"ow_right\">
                    <span class=\"ow_button ow_ic_save ow_positive\">
                        <span>
                            <input type=\"submit\" value=\"Submit\" class=\"ow_ic_save ow_positive\" >
                        </span>
                    </span>
                </div>";
*/

            $content .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_right\">
                    <span class=\"ow_button\">
                        <span class=\"ow_positive\">
                            <input type=\"submit\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'config_save')."\" class=\"ow_ic_save ow_positive\">
                        </span>
                    </span>
                </div>
            </div>";

                $content .="</td>";
                $content .="</tr>";
        }

                    $content .="<tr>";
                    $content .="<td colspan=\"2\" style=\"margin:auto;\">";
                    $content .="<br/>&nbsp;";
                    $content .="</td>";
                    $content .="</tr>";

//                $content .="<tr>";
//                $content .="<td align=\"left\" valign=\"top\" colspan=\"2\">";
//                $content .="<strong>".OW::getLanguage()->text('base', 'images')."</strong>";
//                $content .="</td>";
//                $content .="</tr>";


//                    $content .="<tr>";
//                    $content .="<td colspan=\"2\" style=\"margin:auto;border-bottom:1px solid #ddd;\">";
//                    $content .="</td>";
//                    $content .="</tr>";

        $content .="<tr class=\"ow_tr_first\">
            <th class=\"ow_name ow_txtleft\" colspan=\"2\">
                <span class=\"ow_section_icon ow_ic_gear_wheel\">".OW::getLanguage()->text('shoppro', 'product_images')."</span>
            </th>
        </tr>";


        $content .="<tr>";
        $content .="<td align=\"right\" valign=\"top\" colspan=\"2\">";
        $content .="<table class=\"ow_table_1 ow_form\" style=\"width:100%;margin:auto;\">";

                $content .="<tr class=\"ow_alt2\">";
                $content .="<td align=\"center\" valign=\"top\">";
                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_procuctimage')."</strong>";
$content .="<br/>";
                $content .="<input type=\"file\" name=\"imgfile\" id=\"imgfile\" />";

                if ($params['options']=="edit" AND $params['idproduct']>0){
                                $product_image="ow_userfiles/plugins/shoppro/images/product_".$value['id'].".jpg";
                                if (is_file("./".$product_image)){
                                    $product_image=$curent_url.$product_image;
                                }else{
                                    $product_image="";
                                }
//echo $product_image;
                    if ($product_image){
                        $content .="<br/>";
                        $content .="<img src=\"".$product_image."\" border=\"0\" width=\"100px\" >";
                        $content .="<br/>";
                        $content .="<b style=\"color:#f00;\">".OW::getLanguage()->text('shoppro', 'product_table_deleteimage').":</b> ";
                        $content .="<input type=\"checkbox\" name=\"delimg\" value=\"1\">";
                    }                
                }

                $content .="</td>";
                $content .="<td align=\"center\" valign=\"top\">";
                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_procuctimage')."</strong>";
$content .="<br/>";
                $content .="<input type=\"file\" name=\"imgfile2\" id=\"imgfile2\" />";

                if ($params['options']=="edit" AND $params['idproduct']>0){
                                $product_image="ow_userfiles/plugins/shoppro/images/product_".$value['id']."_2.jpg";
                                if (is_file("./".$product_image)){
                                    $product_image=$curent_url.$product_image;
                                }else{
                                    $product_image="";
                                }
                    if ($product_image){
                        $content .="<br/>";
                        $content .="<img src=\"".$product_image."\" border=\"0\" width=\"100px\" >";
                        $content .="<br/>";
                        $content .="<b style=\"color:#f00;\">".OW::getLanguage()->text('shoppro', 'product_table_deleteimage').":</b> ";
                        $content .="<input type=\"checkbox\" name=\"delimg2\" value=\"1\">";
                    }                
                }

                $content .="</td>";
                $content .="</tr>";

                $content .="<tr class=\"ow_alt1\">";
                $content .="<td align=\"center\" valign=\"top\">";
                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_procuctimage')."</strong>";
$content .="<br/>";
                $content .="<input type=\"file\" name=\"imgfile3\" id=\"imgfile3\" />";

                if ($params['options']=="edit" AND $params['idproduct']>0){
                                $product_image="ow_userfiles/plugins/shoppro/images/product_".$value['id']."_3.jpg";
                                if (is_file("./".$product_image)){
                                    $product_image=$curent_url.$product_image;
                                }else{
                                    $product_image="";
                                }
                    if ($product_image){
                        $content .="<br/>";
                        $content .="<img src=\"".$product_image."\" border=\"0\" width=\"100px\" >";
                        $content .="<br/>";
                        $content .="<b style=\"color:#f00;\">".OW::getLanguage()->text('shoppro', 'product_table_deleteimage').":</b> ";
                        $content .="<input type=\"checkbox\" name=\"delimg3\" value=\"1\">";
                    }                
                }

                $content .="</td>";

                $content .="<td align=\"center\" valign=\"top\">";
                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_procuctimage')."</strong>";
$content .="<br/>";
                $content .="<input type=\"file\" name=\"imgfile4\" id=\"imgfile4\" />";

                if ($params['options']=="edit" AND $params['idproduct']>0){
                                $product_image="ow_userfiles/plugins/shoppro/images/product_".$value['id']."_4.jpg";
                                if (is_file("./".$product_image)){
                                    $product_image=$curent_url.$product_image;
                                }else{
                                    $product_image="";
                                }
                    if ($product_image){
                        $content .="<br/>";
                        $content .="<img src=\"".$product_image."\" border=\"0\" width=\"100px\" >";
                        $content .="<br/>";
                        $content .="<b style=\"color:#f00;\">".OW::getLanguage()->text('shoppro', 'product_table_deleteimage').":</b> ";
                        $content .="<input type=\"checkbox\" name=\"delimg4\" value=\"1\">";
                    }                
                }

                $content .="</td>";
                $content .="</tr>";


                $content .="<tr class=\"ow_alt2\">";
                $content .="<td align=\"center\" valign=\"top\">";
                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_procuctimage')."</strong>";
$content .="<br/>";
                $content .="<input type=\"file\" name=\"imgfile5\" id=\"imgfile5\" />";

                if ($params['options']=="edit" AND $params['idproduct']>0){
                                $product_image="ow_userfiles/plugins/shoppro/images/product_".$value['id']."_5.jpg";
                                if (is_file("./".$product_image)){
                                    $product_image=$curent_url.$product_image;
                                }else{
                                    $product_image="";
                                }
                    if ($product_image){
                        $content .="<br/>";
                        $content .="<img src=\"".$product_image."\" border=\"0\" width=\"100px\" >";
                        $content .="<br/>";
                        $content .="<b style=\"color:#f00;\">".OW::getLanguage()->text('shoppro', 'product_table_deleteimage').":</b> ";
                        $content .="<input type=\"checkbox\" name=\"delimg5\" value=\"1\">";
                    }                
                }

                $content .="</td>";
                $content .="<td align=\"center\" valign=\"top\">";
                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_procuctimage')."</strong>";
$content .="<br/>";
                $content .="<input type=\"file\" name=\"imgfile6\" id=\"imgfile6\" />";

                if ($params['options']=="edit" AND $params['idproduct']>0){
                                $product_image="ow_userfiles/plugins/shoppro/images/product_".$value['id']."_6.jpg";
                                if (is_file("./".$product_image)){
                                    $product_image=$curent_url.$product_image;
                                }else{
                                    $product_image="";
                                }
                    if ($product_image){
                        $content .="<br/>";
                        $content .="<img src=\"".$product_image."\" border=\"0\" width=\"100px\" >";
                        $content .="<br/>";
                        $content .="<b style=\"color:#f00;\">".OW::getLanguage()->text('shoppro', 'product_table_deleteimage').":</b> ";
                        $content .="<input type=\"checkbox\" name=\"delimg6\" value=\"1\">";
                    }                
                }

                $content .="</td>";
                $content .="</tr>";


                $content .="<tr class=\"ow_alt1\">";
                $content .="<td align=\"center\" valign=\"top\">";
                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_procuctimage')."</strong>";
$content .="<br/>";
                $content .="<input type=\"file\" name=\"imgfile7\" id=\"imgfile7\" />";

                if ($params['options']=="edit" AND $params['idproduct']>0){
                                $product_image="ow_userfiles/plugins/shoppro/images/product_".$value['id']."_7.jpg";
                                if (is_file("./".$product_image)){
                                    $product_image=$curent_url.$product_image;
                                }else{
                                    $product_image="";
                                }
                    if ($product_image){
                        $content .="<br/>";
                        $content .="<img src=\"".$product_image."\" border=\"0\" width=\"100px\" >";
                        $content .="<br/>";
                        $content .="<b style=\"color:#f00;\">".OW::getLanguage()->text('shoppro', 'product_table_deleteimage').":</b> ";
                        $content .="<input type=\"checkbox\" name=\delimg7\" value=\"1\">";
                    }                
                }

                $content .="</td>";

                $content .="<td align=\"center\" valign=\"top\">";
                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_procuctimage')."</strong>";
$content .="<br/>";
                $content .="<input type=\"file\" name=\"imgfile8\" id=\"imgfile8\" />";

                if ($params['options']=="edit" AND $params['idproduct']>0){
                                $product_image="ow_userfiles/plugins/shoppro/images/product_".$value['id']."_8.jpg";
                                if (is_file("./".$product_image)){
                                    $product_image=$curent_url.$product_image;
                                }else{
                                    $product_image="";
                                }
                    if ($product_image){
                        $content .="<br/>";
                        $content .="<img src=\"".$product_image."\" border=\"0\" width=\"100px\" >";
                        $content .="<br/>";
                        $content .="<b style=\"color:#f00;\">".OW::getLanguage()->text('shoppro', 'product_table_deleteimage').":</b> ";
                        $content .="<input type=\"checkbox\" name=\"delimg8\" value=\"1\">";
                    }                
                }

                $content .="</td>";
                $content .="</tr>";


                $content .="<tr class=\"ow_alt2\">";
                $content .="<td align=\"center\" valign=\"top\">";
                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_procuctimage')."</strong>";
$content .="<br/>";
                $content .="<input type=\"file\" name=\"imgfile9\" id=\"imgfile9\" />";

                if ($params['options']=="edit" AND $params['idproduct']>0){
                                $product_image="ow_userfiles/plugins/shoppro/images/product_".$value['id']."_9.jpg";
                                if (is_file("./".$product_image)){
                                    $product_image=$curent_url.$product_image;
                                }else{
                                    $product_image="";
                                }
                    if ($product_image){
                        $content .="<br/>";
                        $content .="<img src=\"".$product_image."\" border=\"0\" width=\"100px\" >";
                        $content .="<br/>";
                        $content .="<b style=\"color:#f00;\">".OW::getLanguage()->text('shoppro', 'product_table_deleteimage').":</b> ";
                        $content .="<input type=\"checkbox\" name=\"delimg9\" value=\"1\">";
                    }                
                }

                $content .="</td>";
                $content .="<td align=\"center\" valign=\"top\">";
                $content .="<strong>".OW::getLanguage()->text('shoppro', 'product_table_procuctimage')."</strong>";
$content .="<br/>";
                $content .="<input type=\"file\" name=\"imgfile10\" id=\"imgfile10\" />";

                if ($params['options']=="edit" AND $params['idproduct']>0){
                                $product_image="ow_userfiles/plugins/shoppro/images/product_".$value['id']."_10.jpg";
                                if (is_file("./".$product_image)){
                                    $product_image=$curent_url.$product_image;
                                }else{
                                    $product_image="";
                                }
                    if ($product_image){
                        $content .="<br/>";
                        $content .="<img src=\"".$product_image."\" border=\"0\" width=\"100px\" >";
                        $content .="<br/>";
                        $content .="<b style=\"color:#f00;\">".OW::getLanguage()->text('shoppro', 'product_table_deleteimage').":</b> ";
                        $content .="<input type=\"checkbox\" name=\"delimg10\" value=\"1\">";
                    }                
                }

                $content .="</td>";
                $content .="</tr>";

        $content .="</table>";
        $content .="</td>";
        $content .="</tr>";
        




                    $content .="<tr>";
                    $content .="<td colspan=\"2\" style=\"margin:auto;height:25px;\">";
                    $content .="</td>";
                    $content .="</tr>";






                $content .="<tr>";
                $content .="<td align=\"right\" valign=\"top\" colspan=\"2\">";
//            $content .="<input type=\"submit\" name=\"submit\" value=\"Submit\" />";

//                $content .="<div class=\"ow_right\"><span class=\"ow_button ow_ic_save ow_positive\"><span>
//                <input type=\"button\" value=\"Submit\" class=\"ow_ic_save ow_positive\" onclick=\"this.form.submit()\"></span></span></div>";
/*
                $content .="<div class=\"ow_right\">
                    <span class=\"ow_button ow_ic_save ow_positive\">
                        <span>
                            <input type=\"submit\" value=\"Submit\" class=\"ow_ic_save ow_positive\" >
                        </span>
                    </span>
                </div>";
*/
            $content .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_right\">
                    <span class=\"ow_button\">
                        <span class=\"ow_positive\">
                            <input type=\"submit\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'config_save')."\" class=\"ow_ic_save ow_positive\">
                        </span>
                    </span>
                </div>
            </div>";

                $content .="</td>";
                $content .="</tr>";


            }//if uer can sale

                $content .="</table>";


                $content .="</form>";

//        echo "Test ajax OK";
        }else{
            OW::getApplication()->redirect($curent_url."shop");
        }

        if ($wtype=="mobile"){
            $content_t=$content;
        }else{
            $content_t=$this->make_tabs("addnewproduct",$content);
        }
//        $this->assign('content', $content_t);
        return $content_t;
    }



    public function delete_product($params=array(),$wtype="shop")
    {

        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();
        $curent_url=OW_URL_HOME;


            if ($params['options']=="del" AND $params['idproduct']>0 AND 
                (($id_user>0 AND OW::getConfig()->getValue('shoppro', 'mode_membercanshell')==1) OR $is_admin)
                ){

if ($is_admin){
    $add=" ";
}else{
    $add=" AND id_owner='".addslashes($id_user)."' ";
}
                            $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($params['idproduct'])."' ".$add." LIMIT 1";
                            $arrxx = OW::getDbo()->queryForList($query);
                            if (isset($arrxx[0])) $valuex=$arrxx[0];
                                else {
                                    $valuex=array();
                                    $valuex['id']="";
                                    
                            }
                            if ($valuex['id']>0 AND $valuex['id']==$params['idproduct']){
                                $query = "DELETE FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($params['idproduct'])."' ".$add." LIMIT 1";
                                $resss= OW::getDbo()->query($query);

                                $query = "DELETE FROM " . OW_DB_PREFIX. "shoppro_products_description WHERE id_product_de='".addslashes($params['idproduct'])."' ";
                                $resss= OW::getDbo()->query($query);

                                $query = "DELETE FROM " . OW_DB_PREFIX. "shoppro_products_options WHERE id_product='".addslashes($params['idproduct'])."' ".$add." ";
                                $resss= OW::getDbo()->query($query);


//                                $path_img="./ow_userfiles/plugins/shoppro/images/";
                                $path_img=SHOPPRO_BOL_Service::getInstance()->get_plugin_dir('shoppro')."images/";

                                $name_img="product_".$params['idproduct'].".jpg";
                                if (is_file($path_img.$name_img)){
                                    unlink($path_img.$name_img);
                                }
                                for ($i=2;$i<11;$i++){
                                    $name_img="product_".$params['idproduct']."_".$i.".jpg";
                                    if (is_file($path_img.$name_img)){
                                        unlink($path_img.$name_img);
                                    }
                                }


                                $hash=$valuex['file_attach'];
                                if ($hash){
//                                    $path_file="./ow_userfiles/plugins/shoppro/files/";
                                    $path_file=SHOPPRO_BOL_Service::getInstance()->get_plugin_dir('shoppro')."files/";
                                    $name_file="file_".$params['idproduct']."_".$hash.".pack";
                                    if (is_file($path_file.$name_file)){
                                        unlink($path_file.$name_file);
                                    }
                                }
                            }
                        //----------------------------delete newsfeed
                            $query = "SELECT * FROM " . OW_DB_PREFIX. "newsfeed_action  WHERE entityId='".addslashes($params['idproduct'])."' AND pluginKey='shoppro' LIMIT 1";
                            $arrx = OW::getDbo()->queryForList($query);
                            
                            if (isset($arrx[0]) AND $arrx[0]['id']>0){
                                $value=$arrx[0];        
                                $sql="DELETE FROM " . OW_DB_PREFIX. "newsfeed_action WHERE entityId='".addslashes($params['idproduct'])."' AND pluginKey='shoppro' LIMIT 1";
                                OW::getDbo()->query($sql);
/*                                
                                $sql="DELETE FROM " . OW_DB_PREFIX. "newsfeed_action_set WHERE actionId='".addslashes($arrx[0]['id'])."' ";
                                OW::getDbo()->query($sql);

                                $sql="DELETE FROM " . OW_DB_PREFIX. "newsfeed_activity WHERE actionId='".addslashes($arrx[0]['id'])."' ";
                                OW::getDbo()->query($sql);                        
*/

                            }
                        //----------------------------delete comments
                            


//                echo "DELETE TODO...";

                if ($wtype=="mobile"){
                    OW::getApplication()->redirect($curent_url."mobile/v2/option/shop");
                    exit;
                }

            }
    }


}