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


class SHOPPRO_CMP_IndexSlider extends BASE_CLASS_Widget
{

    private $value_content = array();


    public function __construct( BASE_CLASS_WidgetParameter $params )
    {
//        parent::__construct();

        parent::__construct();

//        $this->ciduser = $paramObject->additionalParamList['entityId'];
        //echo $userId;
//        $this->content =SHOPPRO_BOL_Service::getInstance()->make_list($this->ciduser);
/*
//echo $_SERVER["REQUEST_URI"];exit;
            $xx=$_SERVER["REQUEST_URI"];
            if ($xx=="/index/customize" OR $xx=="index/customize" OR $xx=="index/customize/"){
                $this->setVisible(false);
                return;
            }else{
*/
                $curent_lang=SHOPPRO_BOL_Service::getInstance()->get_curect_lang_id();
                $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products pr 
    LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_description prsesc ON (prsesc.id_product_de=pr.id AND prsesc.id_lang_de='".addslashes($curent_lang)."') 
                WHERE active = '1' 
AND ( (pr.type_ads='2' AND pr.items>'0') OR (pr.type_ads='1' AND pr.items>'0') OR pr.type_ads='0') 
                ORDER BY pr.promotion_is_vip DESC, pr.date_modyfing DESC 
                LIMIT 1";
                $arr = OW::getDbo()->queryForList($query);
                if (!isset($arr[0]) OR !count($arr[0])){
                    $this->setVisible(false);
                    return;
                }
//            }

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
            self::SETTING_TITLE => OW::getLanguage()->text('shoppro', 'shop_slider'),
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


//$this->setVisible(false);
//        $this->setVisible(false);
//        return;
//echo "sfsdF";exit;
            $content="";
        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();//iss admin
        $curent_lang=SHOPPRO_BOL_Service::getInstance()->get_curect_lang_id();

//                    $curent_url .= $_SERVER["SERVER_NAME"]."/";
$curent_url=OW_URL_HOME; 

//        OW::getDocument()->addScript(OW_URL_HOME.'ow_static/plugins/shoppro/ext/jquery.movingboxes.min.js');
//        OW::getDocument()->addScript(OW_URL_HOME.'ow_static/plugins/shoppro/ext/slidershop.js?'.rand(100,500));
        OW::getDocument()->addScript(OW_URL_HOME.'ow_static/plugins/shoppro/ext/slidershop.js?a=1');




//$main_slider_width=475;//960
//$main_slider_width=480;//960
$main_slider_width=250;//960
$main_slider_background="background: transparent;";//background: white;

//$slide_background="transparent";//white;
$slide_background="";//white;
//$slide_width=$main_slider_width-60;//415//900
$slide_width=$main_slider_width-30;//415//900
$slide_height=227;//227

$slider_width=$slide_width-10;


$slide_img_mxwidth=200;//100%
$slide_img_mxheight=$slide_height-35;

$slide_p_width=$main_slider_width-$slide_img_mxwidth-60;//180//300
$slide_p_width .="px";

$slide_p_width ="45%";

$slide_img_left=$slide_p_width-20;//400

//$slide_img_right="80px";
$slide_img_right="10px";

$products_no=10;

            $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products pr 
    LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_description prsesc ON (prsesc.id_product_de=pr.id AND prsesc.id_lang_de='".addslashes($curent_lang)."') 
            WHERE active = '1' 
AND ( (pr.type_ads='2' AND pr.items>'0') OR (pr.type_ads='1' AND pr.items>'0') OR pr.type_ads='0') 
            ORDER BY pr.promotion_is_vip DESC, pr.date_modyfing DESC 
            LIMIT ".$products_no;
//echo $query;exit;

$pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();
$pluginStaticURL =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesUrl();
$pluginStaticDir =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesDir();
            $content_menu="";
            $arr = OW::getDbo()->queryForList($query);
			//$value=array();
            $boxes="";

            $is_first=true;
            foreach ( $arr as $value ) {
/*
                                $dname=BOL_UserService::getInstance()->getDisplayName($value['id_owner']);
                                $uurl=BOL_UserService::getInstance()->getUserUrl($value['id_owner']);
                                $uimg=BOL_AvatarService::getInstance()->getAvatarUrl($value['id_owner']);


*/            
                                $product_path=$pluginStaticDir;
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
$seo_title=SHOPPRO_BOL_Service::getInstance()->make_seo_url($seo_title,100);
$product_url=$curent_url."product/".$value['id']."/zoom/".$seo_title.".html";


                if ($is_first){
                    $boxes .="<div class=\"shop-slide\" id=\"slide-1\" murl=\"".$product_url."\">";
                    $is_first=false;
                }else{
                    $boxes .="<div class=\"shop-slide\" murl=\"".$product_url."\">";
                }
    $max_chars=45;
    $title = mb_substr(stripslashes($value['name']),0,$max_chars);
    if (strlen(stripslashes($value['name']))>$max_chars) $title .="...";

                    $boxes .="<h1>".$title."</h1>";



//                                if ($product_image AND $product_image_url){
                                if ($product_image AND $product_image_url){
//                                    if ($product_image_url) $urll=$product_image_url;
//                                        else $urll="#";


//                                    $boxes .="<a href=\"".$product_url."\">";
//                                    $boxes .="<a href=\"#\">";
                                    $boxes .="<img id=\"img\" class=\"shop-slide_image\" src=\"".$product_image_url."\" alt=\"".$title."\" style=\"width:".$slide_img_mxwidth."px;max-height:".$slide_img_mxheight."px;\"/>";
//                                    $boxes .="</a>";

//                                    if ($product_image_url) $products .="<a href=\"".$curent_url."product/".$value['id']."/zoom/".$seo_title.".html\" alt=\"".stripslashes($value['name'])."\">";
//                                    $products .= "<img src=\"".$product_image_url."\" border=\"0\" width=\"100px\" title=\"".stripslashes($value['name'])."\" align=\"left\" style=\"margin:8px;\">";
//                                    if ($product_image_url) $products .="</a>";
                                }else{
//                                    $boxes .="<a href=\"#\">";
//                                    $boxes .="<img id=\"img\" class=\"shop-slide_noimg\" src=\"".$pluginStaticURL2."pkt.gif\" alt=\"".$title."\" style=\"width:".$slide_img_mxwidth."px;max-height:".$slide_img_mxheight."px;border:0;\"/>";
//                                    $boxes .="<img id=\"img\" class=\"shop-slide_noimg\" src=\"".$pluginStaticURL2."pkt.gif\" alt=\"".$title."\" style=\"width:1px;max-height:1px;border:0;\"/>";
                                    $boxes .="<img id=\"img\" class=\"shop-slide_noimg\" src=\"".$pluginStaticURL2."pkt.gif\" alt=\"".$title."\" style=\"width:".$slide_img_mxwidth."px;max-height:".$slide_img_mxheight."px;\"/>";
//                                    $boxes .="</a>";
                                }

                    
                    $boxes .="<p style=\"width:100px;\">";

if ($value['description_de']) $description=$value['description_de'];
    else $description=$value['description'];

if (OW::getConfig()->getValue('shoppro', 'max_product_desc_chars')>0){
    $max_chars=OW::getConfig()->getValue('shoppro', 'max_product_title_chars');
    $description=SHOPPRO_BOL_Service::getInstance()->html2txt(stripslashes($description));
    $pr = mb_substr($description,0,$max_chars);
    if (strlen(stripslashes($value['name']))>$max_chars) $pr .="...";
    $description=SHOPPRO_BOL_Service::getInstance()->brtospace($pr);
}else{
    $description=SHOPPRO_BOL_Service::getInstance()->html2txt(stripslashes($description));
    $pr = mb_substr($description,0,255);
    $description=SHOPPRO_BOL_Service::getInstance()->brtospace($pr);
}
                    $boxes .=$description;
                    $boxes .="</p>";




                    
                $boxes .="</div>";

            }

//echo "=========".$boxes."========";exit;


if ($boxes){
$content .="<div id=\"shop-page-wrap\" class=\"ow_center\">";
        $content .="<div id=\"shop-slider\" class=\"ow_boxX\">";
            $content .="<div id=\"shop-mover\">";
                $content .=$boxes;
        $content .="</div>";
    $content .="</div>";
$content .="</div>";


//#slider { background: ".$slide_background." url(http://css-tricks.com/examples/StartStopSlider/images/slider-bg.jpg); min-height: ".$slide_height."px; overflow: hidden; position: relative; margin: 50px 0; }
//#slider-stopper { position: absolute; top: 1px; right: 20px; background: #ac0000; color: white; padding: 3px 8px; font-size: 10px; text-transform: uppercase; z-index: 1000; }
//.shop-slide h1 { font-family: Helvetica, Sans-Serif; font-size: 22px; letter-spacing: -1px; color: #ac0000; z-index: 10;position: relative;padding: 0;margin: auto;margin-top: -10px;}
//.shop-slide { padding: 40px 30px; width: ".$slide_width."px; float: left; position: relative;}
//.shop-slide_image {position: absolute; top: 40px; left: ".$slide_img_left."px; max-width:".$slide_img_mxwidth."px;max-height:".$slide_img_mxheight."px;}
//.shop-slide img { position: absolute; top: 40px; left: ".$slide_img_left."px; max-width:".$slide_img_mxwidth."px;max-height:".$slide_img_mxheight."px;}

//#shop-page-wrap { ".$main_slider_background." min-width: ".$main_slider_width."px; margin:0; padding: 0; }

//.shop-slide { padding: 40px 30px 10px 30px; width:100%;max-width: ".$slide_width."px; float: left; position: relative;left:-30px;}
//.shop-slide { padding: 40px 30px 10px 30px; width:".$slide_width."px;float: left; position: relative;left:-30px;}

//.shop-slide h1 { font-family: Helvetica, Sans-Serif; font-size: 22px; letter-spacing: -1px; z-index: 10;position: relative;padding: 0;margin: auto;margin-left:-40px;margin-top: -40px;text-align:center;border-bottom:1px solid #eee;}
$content .="
<style type=\"text/css\" style=\"display: none !important;\">
#shop-page-wrap { ".$main_slider_background." min-width: 100%; margin:0; padding: 0; overflow: hidden; }

#shop-slider { background: ".$slide_background."; min-height: ".$slide_height."px; overflow: hidden; position: relative; margin: 0; width: ".$slider_width."px;display: inline-block;}

#shop-mover { min-width: 2880px; position: relative; min-height:".$slide_height."px;}

.shop-slide { padding: 40px 30px 10px 30px; width:".$slide_width."px;float: left; position: relative;left:-30px;}

.shop-slide h1 { line-height: 40px;font-family: Helvetica, Sans-Serif; font-size: 22px; letter-spacing: -1px; position: relative;padding: 0;margin: auto;margin-left:-40px;margin-top: -40px;text-align:center;border-bottom:1px solid #eee;}
.shop-slide p { display:inline-block; float:left;color: #999; font-size: 11px; line-height: 18px; text-align: left;width:200px;min-width: 200px;overflow:hidden;margin-top: 20px;}

.shop-slide_image {display:inline-block; float:left; margin-top: 20px; margin-right: ".$slide_img_right."; max-width:".$slide_img_mxwidth."px;max-height:".$slide_img_mxheight."px;}
.shop-slide_noimg {display:inline-block; float:left; margin-top: 20px;  margin-right: ".$slide_img_right."; max-width:".$slide_img_mxwidth."px;max-height:".$slide_img_mxheight."px;}

</style>

";

/*
$script="$(document).ready(function(){

$('.ow_narrow').width('0px');
$('.ow_wide').width('30%');

var shopslider=$('#shop-slider').width();
var shopslide=shopslider+10;
var shop_slide_img=".$slide_img_mxwidth.";
var shop_slide_p=(shopslide-shop_slide_img-60);


$('.shop-slide').width(shopslide);
$('.shop-slide p').width(shop_slide_p);
$('.shop-slide img').width(shop_slide_img);
$('.shop-slide_image').width(shop_slide_img);



});
";
OW::getDocument()->addOnloadScript($script);
*/

}else{//if not $boxes
    $content="";
}






/*
//        OW::getDocument()->addScript(OW_URL_HOME.'ow_static/plugins/shoppro/ext/jquery.thslide.js');
        $script  = "$(document).ready(function(){
                $('#any_id').thslide({
                itemOffset: 93,
                infiniteScroll: 1
            });
        });";
$content .="<script>
".$script."
</script>
";
*/
//        OW::getDocument()->addScriptDeclaration($script);
//        OW::getDocument()->addScript($script);
//        OW::getDocument()->addOnloadScript($script);

/*                                       
$from_config=$curent_url;
$from_config=str_replace("https://","",$from_config);
$from_config=str_replace("http://","",$from_config);
$trash=explode($from_config,$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);

//$url_detect=$trash[1];
$trash2=explode("?",$trash[1]);
$url_detect=$trash2[0];
//echo $url_detect;exit;

if ($url_detect[0]=="/") {
    $url_detect=substr($url_detect,1);
}
list($url_detect)=explode("/",$url_detect);

//echo $url_detect;exit;

//        if ($url_detect=="shop" OR $url_detect=="shoppro" OR $url_detect=="shoppro_adm" OR $url_detect=="basket" OR $url_detect=="order" OR $url_detect=="product"){
        if ($url_detect=="shop" OR $url_detect=="shoppro" OR $url_detect=="shoppro_adm" OR $url_detect=="basket" OR $url_detect=="order" OR $url_detect=="ordershop" OR $url_detect=="product"){
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
//                $content_menu .="<li style=\"list-style-position: inside;list-style-type: disc;\">";
                if ($is_admin){
                    $content_menu .="<li style=\"list-style-type:none;list-style-position: inside;\">";
                }else{
                    $content_menu .="<li style=\"list-style-position: inside;list-style-type: disc;\">";
                }

                if ($id_user>0 AND $is_admin){

                    $content_menu .="<a href=\"".$curent_url."shoppro_adm/del/".$value['id']."\" onclick=\"return confirm('Are you sure you want to delete?');\"   title=\"".OW::getLanguage()->text('shoppro', 'menu_delete_cat')."\">";
                    $content_menu .="<b style=\"color:#f00;\">[-]</b>";
                    $content_menu .="</a>";
//                    $content_menu .="&nbsp;|&nbsp;";
                    $content_menu .="<a href=\"".$curent_url."shoppro_adm/edit/".$value['id']."\" title=\"".OW::getLanguage()->text('shoppro', 'menu_edit_cat')."\">";
                    $content_menu .="<b style=\"color:#080;\">[*]</b>";
                    $content_menu .="</a>";
//                    $content_menu .="&nbsp;";
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
//                $content_menu .=stripslashes($value['name']);
                if (!$value['active']) $content_menu .="</i>";
                $content_menu .="</a>";

                $content_menu .="</li>";


            }

            if ($is_admin){
                $content .="<a href=\"".$curent_url."shoppro_adm/add/new\" title=\"".OW::getLanguage()->text('shoppro', 'menu_addnew_cat')."\">";
                $content .="<b style=\"color:#f00;\">[+]&nbsp;".OW::getLanguage()->text('shoppro', 'menu_addnew_cat')."</b>";
                $content .="</a>";
                $content .="<hr>";
            }

            if ($content_menu){


                $content .="<ul>".$content_menu."</ul>";
            }

        }else{
                $content  ="<script>\n";
                $content .="\$(document).ready(function(){\n";
                $content .="\$(\".index-SHOPPRO_CMP_MenuWidget\").empty().remove();\n";
                $content .="    });\n";
                $content .="</script>";
        }
*/
//$content ="<div class=\"clearfix\">".$content."</div>

$content .="
<div class=\"ow_box_toolbar_cont clearfix\">
    <div class=\"ow_box_toolbar ow_remark\">
        <span style=\"\" class=\"ow_nowrap\">
        <a href=\"".$curent_url."shop\">".OW::getLanguage()->text('shoppro', 'more')."</a>
        </span>
    </div>
    </div>";



//echo "sdfsdF";exit;
$xx=$_SERVER["REQUEST_URI"];

//http://www.writy.org/rita_str/index/customize


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

