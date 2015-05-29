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


OW::getRouter()->addRoute(new OW_Route('shoppro.index', 'shop', "SHOPPRO_CTRL_Shop", 'index'));
OW::getRouter()->addRoute(new OW_Route('shoppro.indexmy', 'shopmy/:optmy', "SHOPPRO_CTRL_Shop", 'index'));

OW::getRouter()->addRoute(new OW_Route('shoppro.setoption', 'shop/set/:op', "SHOPPRO_CTRL_Shop", 'indexset'));

OW::getRouter()->addRoute(new OW_Route('shoppro.inquire', 'shop/inquire', "SHOPPRO_CTRL_Shop", 'indexinq'));
OW::getRouter()->addRoute(new OW_Route('shoppro.admin', 'admin/plugins/shoppro', "SHOPPRO_CTRL_Admin", 'dept'));


OW::getRouter()->addRoute(new OW_Route('shoppro.index2', 'product/:idproduct', "SHOPPRO_CTRL_Shop", 'index'));
OW::getRouter()->addRoute(new OW_Route('shoppro.index3', 'product/:idproduct/:options', "SHOPPRO_CTRL_Shop", 'index'));
OW::getRouter()->addRoute(new OW_Route('shoppro.index4', 'product/:idproduct/:options/:title', "SHOPPRO_CTRL_Shop", 'index'));
OW::getRouter()->addRoute(new OW_Route('shoppro.index5', 'shoppro_adm/:optionadm/:idcat', "SHOPPRO_CTRL_Shop", 'index'));
OW::getRouter()->addRoute(new OW_Route('shoppro.index6', 'shoppro/:idcat', "SHOPPRO_CTRL_Shop", 'index'));
OW::getRouter()->addRoute(new OW_Route('shoppro.termofuse', 'shoppro/termofuse/:idm', "SHOPPRO_CTRL_Shop", 'indextermofuse'));
OW::getRouter()->addRoute(new OW_Route('shoppro.sellerseting', 'seller/setting', "SHOPPRO_CTRL_Shop", 'indexsellersetting'));
OW::getRouter()->addRoute(new OW_Route('shoppro.index7', 'shoppro/:idcat/:title', "SHOPPRO_CTRL_Shop", 'index'));
OW::getRouter()->addRoute(new OW_Route('shoppro.baynow', 'baynow/:idproduct', "SHOPPRO_CTRL_Shop", 'baynow'));
OW::getRouter()->addRoute(new OW_Route('shoppro.baynowcredits', 'baynowcredits/:idproductbuycredits', "SHOPPRO_CTRL_Shop", 'index'));
OW::getRouter()->addRoute(new OW_Route('shoppro.baynowfreeproduct', 'baynowproduct/:idproductbuyfree', "SHOPPRO_CTRL_Shop", 'index'));
OW::getRouter()->addRoute(new OW_Route('shoppro.basket', 'basket/:option', "SHOPPRO_CTRL_Shop", 'index'));
OW::getRouter()->addRoute(new OW_Route('shoppro.ordershop', 'ordershop/:option', "SHOPPRO_CTRL_Shop", 'index'));
OW::getRouter()->addRoute(new OW_Route('shoppro.gpc', 'ordershop/gpc/page/:idp/:ss', "SHOPPRO_CTRL_Shop", 'indexgpc'));

OW::getRouter()->addRoute(new OW_Route('shoppro.editcategory', 'shop/editc/:ss', "SHOPPRO_CTRL_Shop", 'editcategory'));
OW::getRouter()->addRoute(new OW_Route('shoppro.aj', 'shop/sm/:ss', "SHOPPRO_CTRL_Shop", 'ajaxx'));

OW::getRouter()->addRoute(new OW_Route('shoppro.orderdownload', 'shop/:download/:option/:prot', "SHOPPRO_CTRL_Shop", 'index'));

OW::getRouter()->addRoute(new OW_Route('shoppro.buynowstatus', 'shopbuynow/:option', "SHOPPRO_CTRL_Shop", 'indexbuynow'));
OW::getRouter()->addRoute(new OW_Route('shoppro.buynowbackipn', 'shopipn/:option', "SHOPPRO_CTRL_Shop", 'shopipnpaypal'));//new ipn

OW::getRouter()->addRoute(new OW_Route('shoppro.indexsavecommnt', 'shop/comment/:idevent/:event_type/:pluginkey/:return_url', "SHOPPRO_CTRL_Shop", 'indexsavecommnt'));
OW::getRouter()->addRoute(new OW_Route('shoppro.indexsaverate', 'shop/rate/:idevent/:event_type/:pluginkey/:score', "SHOPPRO_CTRL_Shop", 'indexsaverate'));
OW::getRouter()->addRoute(new OW_Route('shoppro.indexdelcomment', 'shop/commentdel/:opt/:idevent/:entityId/:pluginkey/:ss', "SHOPPRO_CTRL_Shop", 'indexsavecommnt'));



/*
    $cmpService = BOL_ComponentAdminService::getInstance();
    $widget = $cmpService->addWidget('SHOPPRO_CMP_IndexSliderd', false);
    $placeWidget = $cmpService->addWidgetToPlace($widget, BOL_ComponentAdminService::PLACE_DASHBOARD);
    $cmpService->addWidgetToPosition($placeWidget, BOL_ComponentAdminService::SECTION_RIGHT,0);
*/


/*
function shoppro_handler_after_install( BASE_CLASS_EventCollector $event )
{
    if ( count(SHOPPRO_BOL_Service::getInstance()->getDepartmentList()) < 1 )
    {
        $url = OW::getRouter()->urlForRoute('shoppro.admin');
        $event->add(OW::getLanguage()->text('shoppro', 'after_install_notification', array('url' => $url)));
    }
}


OW::getEventManager()->bind('admin.add_admin_notification', 'shoppro_handler_after_install');
*/

$config = OW::getConfig();
if ( !$config->configExists('shoppro', 'hide_timeout_product') ){
    $config->addConfig('shoppro', 'hide_timeout_product', "1", '');
}

/*
$config = OW::getConfig();
if ( !$config->configExists('shoppro', 'comments_require_aproved') ){
    $config->addConfig('shoppro', 'comments_require_aproved', "0", '');
}
if ( !$config->configExists('shoppro', 'turn_on_ciew_couter') ){
    $config->addConfig('shoppro', 'turn_on_ciew_couter', "1", '');
}
*/

/*
$config = OW::getConfig();
if ( !$config->configExists('shoppro', 'hide_seller_avatar_onthelist') ){
    $config->addConfig('shoppro', 'hide_seller_avatar_onthelist', "1", '');
}
if ( !$config->configExists('shoppro', 'hide_product_small_details') ){
    $config->addConfig('shoppro', 'hide_product_small_details', "1", '');
}
if ( !$config->configExists('shoppro', 'hide_seller_small_icon') ){
    $config->addConfig('shoppro', 'hide_seller_small_icon', "1", '');
}
if ( !$config->configExists('shoppro', 'hide_more_button_onproductlist') ){
    $config->addConfig('shoppro', 'hide_more_button_onproductlist', "1", '');
}
if ( !$config->configExists('shoppro', 'max_height_zoom_description') ){
    $config->addConfig('shoppro', 'max_height_zoom_description', "900", '');
}
*/



/*
$authorization = OW::getAuthorization();
$groupName = 'shoppro';
$authorization->deleteGroup($groupName);
$authorization->addGroup($groupName);
$authorization->addAction($groupName, 'addshopproduct',true);
$authorization->addAction($groupName, 'addclassifieds',true);
*/

function shoppro_add_auth_labels( BASE_CLASS_EventCollector $event )
{
    $language = OW::getLanguage();
    $event->add(
        array(
            'shoppro' => array(
                'label' => $language->text('shoppro', 'auth_group_label'),
                'actions' => array(
                    'addshopproduct' => $language->text('shoppro', 'auth_action_label_addshopproduct'),
                    'addclassifieds' => $language->text('shoppro', 'auth_action_label_addclassifieds')
                )
            )
        )
    );
}
OW::getEventManager()->bind('admin.add_auth_labels', 'shoppro_add_auth_labels');


/*
function shoppro_ads_enabled( BASE_EventCollector $event )
{
    $event->add('shoppro');
}

OW::getEventManager()->bind('ads.enabled_plugins', 'shoppro_ads_enabled');
//OW::getRequestHandler()->addCatchAllRequestsExclude('base.suspended_user', 'SHOPPRO_CTRL_Shop');
*/


//function shoppro_set_credits_action_tool( BASE_CLASS_EventCollector $event )
function shoppro_set_credits_action_tool( )
{
    $curent_url=OW_URL_HOME;
    $test_url=str_replace($curent_url,"",$_SERVER['REQUEST_URI']);


    if (!SHOPPRO_BOL_Service::getInstance()->isplugin('usercredits')){
        OW::getConfig()->saveConfig('shoppro', 'mode_membercanpromotion', '0');
        OW::getConfig()->saveConfig('shoppro', 'mode_membercanselingbypoints', '0');
    }

//return;
//print_r($_GET);exit;
//print_r($test_url);exit;
///base/ajax-loader/component/?cmpClass=BASE_CMP_CommentsForm&r=0.3987639790866524
//[params] => ["photo_comments",4,1,"photo",1,null,"photo_comments44660","comments-photo_comments44660","comment-add-photo_comments44660"]
//Array( [cmpClass] => BASE_CMP_CommentsForm [r] => 0.24048256338573992)

$param_stop=false;
if (strpos($test_url,"ajax-loader")!==false) $param_stop=true;
else if (strpos($test_url,"base/")!==false) $param_stop=true;
else if (strpos($test_url,"/component/")!==false) $param_stop=true;
//else if (strpos($test_url,"base/")!==false) $param_stop=true;
if (OW::getRequest()->isPost() OR OW::getRequest()->isAjax() OR $param_stop==true){
    return;
}
//exit;
//echo "--".OW::getUser()->isAuthorized('fanpage');
//    if ( !OW::getUser()->isAuthorized('fanpage') ){return;}
    
//    $params = $event->getParams();
//print_r($params);
//    if ( empty($params['userId']) ){return;}
    
//    $linkId = 'fp' . rand(10, 1000000);
//    $user = BOL_UserService::getInstance()->getUserName((int)$params['userId']);

//    $script  = "<link rel=\"stylesheet\" href=\"".OW_URL_HOME."ow_userfiles/plugins/shoppro/prettyPhoto.css\" type=\"text/css\" media=\"screen\" title=\"prettyPhoto main stylesheet\" charset=\"utf-8\" />";
//    $script .= "<script src=\"".OW_URL_HOME."ow_userfiles/plugins/shoppro/jquery.prettyPhoto.js\" type=\"text/javascript\" charset=\"utf-8\"></script>";
//$script = "alert('aa');";
//    OW::getDocument()->addOnloadScript($script);
//echo OW_URL_HOME.'ow_userfiles/plugins/shoppro/jquery.prettyPhoto.js';exit;

//        OW::getDocument()->addScript(OW_URL_HOME.'ow_userfiles/plugins/shoppro/jquery.prettyPhoto.js');
//        OW::getDocument()->addStyleSheet(OW_URL_HOME.'ow_userfiles/plugins/shoppro/prettyPhoto.css');
        OW::getDocument()->addScript(OW_URL_HOME.'ow_static/plugins/shoppro/jquery.prettyPhoto.js');
        OW::getDocument()->addStyleSheet(OW_URL_HOME.'ow_static/plugins/shoppro/prettyPhoto.css');

        OW::getDocument()->addScript(OW_URL_HOME.'ow_static/plugins/shoppro/ext/shop.js');
        OW::getDocument()->addStyleSheet(OW_URL_HOME.'ow_static/plugins/shoppro/ext/shop.css');


        OW::getDocument()->addScript(OW_URL_HOME.'ow_static/plugins/shoppro/x/jSelect.js');
        OW::getDocument()->addStyleSheet(OW_URL_HOME.'ow_static/plugins/shoppro/x/jselect.css');


//mnu
        OW::getDocument()->addScript(OW_URL_HOME.'ow_static/plugins/shoppro/m/json2.js');
//        OW::getDocument()->addStyleSheet(OW_URL_HOME.'ow_static/plugins/shoppro/m/main.css');//make dynamic

        OW::getDocument()->addScript(OW_URL_HOME.'ow_static/plugins/shoppro/m/jquery.collapse.js');
        OW::getDocument()->addScript(OW_URL_HOME.'ow_static/plugins/shoppro/m/jquery.collapse_storage.js');
        OW::getDocument()->addScript(OW_URL_HOME.'ow_static/plugins/shoppro/m/jquery.collapse_cookie_storage.js');

        OW::getDocument()->addScript(OW_URL_HOME.'ow_static/plugins/shoppro/extr/jquery.raty.min.js');
        OW::getDocument()->addStyleSheet(OW_URL_HOME.'ow_static/plugins/shoppro/extr/raty.css');


        OW::getDocument()->addScript(OW_URL_HOME.'ow_static/plugins/shoppro/ask/jquery.reveal.js');
        OW::getDocument()->addStyleSheet(OW_URL_HOME.'ow_static/plugins/shoppro/ask/reveal.css');




//        OW::getDocument()->addScript(OW_URL_HOME.'ow_static/plugins/shoppro/ext/slider.js');
            $curent_url=OW_URL_HOME;

        $scriptadd="";
        if (OW::getPluginManager()->isPluginActive('cart')){
            $pluginStaticURL2=OW::getPluginManager()->getPlugin('cart')->getStaticUrl();
            $last_add="";
            $last_add .="<tr>";
            $last_add .="<td style=\"padding:1px;padding:0;\" valign=\"middle\">";
            $last_add .="<div style=\"overflow: hidden;text-align: left;max-width:122px;max-height:18px;\">";
            $last_add .="<a href=\"".$curent_url."product/'+idp+'/zoom/index.html\" title=\"'+ptitle+'\" style=\"padding: 0 2px 0 2px;margin: 0;line-height: 18px;font-weight:bold;font-size:12px;\" >'+ptitle+'</a>";
//            $last_add .="'+poption+'; '+ptitle+'";
            $last_add .="</div>";
            $last_add .="</td>";
            $last_add .="<td>";
            $last_add .="'+amout+'";
            $last_add .="</td>";
            $last_add .="<td>";
            $last_add .="'+price+'";
            $last_add .="</td>";
            $last_add .="<td>";
            $last_add .="'+curency+'";
            $last_add .="</td>";
            $last_add .="<td>";
            $last_add .="[+]";
            $last_add .="</td>";
            $last_add .="</tr>";

            $last_addw="";
/*
            $last_addw .="<tr>";
            $last_addw .="<td>";
            $last_addw .="'+ptitle+'";
            $last_addw .="</td>";
            $last_addw .="<td>";
            $last_addw .="'+amout+'";
            $last_addw .="</td>";
            $last_addw .="<td>";
            $last_addw .="'+price+'";
            $last_addw .="</td>";
            $last_addw .="<td>";
            $last_addw .="'+curency+'";
            $last_addw .="</td>";
            $last_addw .="<td>";
            $last_addw .="[+]";
            $last_addw .="</td>";
            $last_addw .="</tr>";
*/
            $last_addw .="<tr class=\"ow_alt1\">";
            $last_addw .="<td colspan=\"6\" style=\"padding:1px;padding:0;\" valign=\"middle\">";
//            $last_addw .="<div style=\"overflow: hidden;text-align: left;\">";
//            $last_addw .="<a href=\"".$curent_url."product/'+idp+'/zoom/index.html\" style=\"padding: 0 2px 0 2px;margin: 0;line-height: 18px;\">";

            $last_addw .="<div style=\"overflow: hidden;text-align: left;max-width:122px;max-height:18px;\">";
            $last_addw .="<a href=\"".$curent_url."product/'+idp+'/zoom/index.html\" title=\"'+ptitle+'\" style=\"padding: 0 2px 0 2px;margin: 0;line-height: 18px;font-weight:bold;font-size:12px;\">";
            $last_addw .="'+ptitle+'";
//            $last_addw .="'+poption+'; '+ptitle+'";
            $last_addw .="</a>";
            $last_addw .="</div>";
            $last_addw .="</td>";
            $last_addw .="</tr>";


            $last_addw .="<tr class=\"ow_alt1\">";
            $last_addw .="<td style=\"paddingx:1px;width:100%;mrgin:auto;\" valign=\"middle\">";
            $last_addw .="</td>";
            $last_addw .="<td style=\"paddingx:1px;text-align:right;padding:0;\" valign=\"middle\">";
            $last_addw .="'+amout+'";
            $last_addw .="</td>";
$last_addw .="<td style=\"paddingx:1px;text-align:center;padding:0 2px 0 2px;\" valign=\"middle\" align=\"center\">";
$last_addw .="x";
$last_addw .="</td>";
$last_addw .="<td style=\"paddingx:1px;font-size:12px;text-align:right;padding:0;\" valign=\"middle\">";
$last_addw .="'+price+'";
$last_addw .="</td>";
$last_addw .="<td style=\"text-align:right;paddingx:1px;width:auto;font-size:9px;font-weight:normal;padding:0;\" class=\"\" valign=\"middle\">";
$last_addw .="'+curency+'";
$last_addw .="</td>";
$last_addw .="<td valign=\"middle\" style=\"paddingx:0;\">";
//$last_addw .="<div class=\"cart_del\" style=\"float:right;display:inline;\" idi=\"'+idp+'\">";
//$last_addw .="<img src=\"".$pluginStaticURL2."delete.gif\" style=\"border:0;\" title=\"".OW::getLanguage()->text('cart', 'delete_item')."\">";
//$last_addw .="</div>";
$last_addw .="</div>";
$last_addw .="</td>";
$last_addw .="</tr>";



$redirectTo = OW::getRequest()->getRequestUri();


$button_not_empty="<div class=\"ow_box_toolbar_cont clearfix\">
<div class=\"ow_box_toolbar ow_remark\">
        <span style=\"\" class=\"ow_nowrap\">
        <a href=\"".$curent_url."cart\">".OW::getLanguage()->text('cart', 'view_cart')."</a>
        </span>
</div>
</div>";

$button_not_empty=str_replace("'","",$button_not_empty);
$button_not_empty=str_replace("\r\n","",$button_not_empty);
$button_not_empty=str_replace("\r","",$button_not_empty);
$button_not_empty=str_replace("\n","",$button_not_empty);


$button_not_empty_c="<div class=\"ow_console_dropdown_cont\">
<a href=\"".$curent_url."cart\">
    <div class=\"ow_center\" style=\"width:100%;min-width:250px;margin:auto;padding:0;\"><div class=\"ow_center\">".OW::getLanguage()->text('cart', 'view_cart')."</div></div>
</a>
</div>";


$button_not_empty_c=str_replace("'","",$button_not_empty_c);
$button_not_empty_c=str_replace("\r\n","",$button_not_empty_c);
$button_not_empty_c=str_replace("\r","",$button_not_empty_c);
$button_not_empty_c=str_replace("\n","",$button_not_empty_c);

$scriptadd .="
//    $('select').jSelect({dropwidth:'100%',listwidth:'500px',editable:true});
//    $('.p_sel_option').jSelect({dropwidth:'100%',listwidth:'300px',editable:true});
    $('.p_sel_option').jSelect({dropwidth:'100%',listwidth:'220px',editable:true});
";



            $scriptadd .="$('.shop_addtocart').click(function() {
                    var ptitle=$(this).attr('ptitle');
                var idp=$(this).attr('idp');
                var ido=$(this).attr('ido');
                    var desc=$(this).attr('desc');
                var amout=$(this).attr('amout');
                    var price=$(this).attr('price');
var has_option=$('#p_option_'+idp).val();
                    var curency=$(this).attr('curency');
                var product_type=$(this).attr('product_type');
                var ccount=parseInt($('.shop_cart_main_count span>.OW_ConsoleItemCounterNumber').html());
                if (ccount==undefined || ccount==null || ccount==''){
                    ccount=0;
                }
var product_option_id=0;
var product_option_price=0;
var product_option_cur='';

if (has_option>0 && $('#opt_'+idp+'_'+has_option+'_id').val()==has_option && $('#opt_'+idp+'_'+has_option+'_price').val()>0 && $('#opt_'+idp+'_'+has_option+'_currence').val()){
    product_option_id=$('#opt_'+idp+'_'+has_option+'_id').val();
    product_option_price=$('#opt_'+idp+'_'+has_option+'_price').val();
    product_option_cur=$('#opt_'+idp+'_'+has_option+'_currence').val();

    ptitle=$('#opt_'+idp+'_'+has_option+'_name').val()+'; '+ptitle;
    desc=product_option_id+'; '+desc;
    price=product_option_price;
    curency=product_option_cur;
}
//alert($('#opt_'+idp+'_'+has_option+'_id').val());
//alert($('#opt_'+idp+'_'+has_option+'_price').val());
//alert($('#opt_'+idp+'_'+has_option+'_currence').val());
//alert($('#opt_'+idp+'_'+has_option+'_name').val());
//alert(has_option);
                $('#product_'+idp).animate_from_to('.shop_cart_main_count');



                ccount=ccount+1;
$('.shop_cart_main_count #cart_show_count').css('display','inline-block');
$('#cart_bottom_button').html('');


//alert($('.shop_cart_main_count span>.OW_ConsoleItemCounter').css('display'));
//                $('#cart_console_items').append('".$last_add."');
//                $('.shop_cart_main_count span>.OW_ConsoleItemCounterNumber').html(ccount);
//                $('.shop_cart_main_count span>.OW_ConsoleItemCounterPlace').removeClass('ow_count_active');
//                $('.shop_cart_main_count span>.OW_ConsoleItemCounterPlace').addClass('ow_count_active');


        $.ajax({  
          type: 'POST',
          url: '".OW_URL_HOME."cart/check/add',  
          data: { 'ss':'".substr(session_id(),3,6)."','ptitle': ptitle, 'idp': idp, 'ido': ido,'desc':desc, 'amout':amout, 'price':price, 'curency':curency,'product_type':product_type,'product_option':has_option,'product_option_id':product_option_id,'product_option_cur':product_option_cur,'product_option_price':product_option_price},  
          dataType: 'json',
//            processData: false,
          success: function(data) {
//alert(data);
                if (data!=null && data['status']=='OK'){
//                    window.location.href='".OW_URL_HOME.$redirectTo."';
//                    alert('".str_replace("'","",OW::getLanguage()->text('cart', 'add_tocart_succesfull'))."');

                    $('#cart_console_items').append('".$last_add."');
                    $('.shop_cart_main_count span>.OW_ConsoleItemCounterNumber').html(ccount);
                    $('.shop_cart_main_count span>.OW_ConsoleItemCounterPlace').removeClass('ow_count_active');
                    $('.shop_cart_main_count span>.OW_ConsoleItemCounterPlace').addClass('ow_count_active');

                    $('#cart_console_items_w').append('".$last_addw."');
//                    $('#cart_info_button_empty').replaceWith('".$button_not_empty."');

                    $('#cart_info_button_empty').html('".$button_not_empty."');

                    $('#cart_bottom_button').replaceWith('".$button_not_empty_c."');
//alert('sssxx11');

                }else if (data!=null){
                    alert(data['text']+': 2011');
                }else{
                    alert('".str_replace("'","",OW::getLanguage()->text('cart', 'error_while_connecting_to_sercer')).": 10null');
                }
            }, error: function() {
                alert('".str_replace("'","",OW::getLanguage()->text('cart', 'error_while_connecting_to_sercer')).": 11error');
            },
            fail: function() { alert('error'); }
        });  




                return false;
            });
        ";
        }else{//if cart end

$scriptadd .="
//    $('select').jSelect({dropwidth:'100%',listwidth:'500px',editable:true});
    $('.p_sel_option').jSelect({dropwidth:'100%',listwidth:'300px',editable:true});


            $('.shop_btnSubmit_mail').click(function (e)
            {
//                if (shop_curent_button==1 && shop_curent_button_poption>0){
                    $(location).attr('href',$(this).attr('url')+'?poption='+shop_curent_button_poption+'&burl='+$(this).attr('burl')+'&pid='+$(this).attr('pid')+'&content='+$('textarea#mail_content').val());
//                }else{
//                    $(location).attr('href',$(this).attr('url'));
//                }

    return false;
                shop_HideDialog($(this).attr('dial'));
                e.preventDefault();
            });

";



        }

/*
$scriptadd .="
    $('.shop_btnSubmit').click(function() {
        return false;;
        alert('sdfsdf');

    });
";
*/
        $script  = "$(document).ready(function(){

                $(\"a[rel^='prettyPhoto']\").prettyPhoto({
                    modal: false,
                    animationSpeed: 'normal', /* fast/slow/normal */
                    opacity: 0.80, /* Value between 0 and 1 */
                    showTitle: true /* true/false */

                });
            ".$scriptadd."
        });";


$script .="$(document).ready(function(){
        $('#css3-animated-example').collapse({
          accordion: true,
            persist: true,
          open: function() {
            this.addClass('open');
            this.css({ height: this.children().outerHeight() });
          },
          close: function() {
            this.css({ height: '0px' });
            this.removeClass('open');
          }
        });

        $('.index-SHOPPRO_CMP_MenuWidget').css('padding-left','0');
        $('.index-SHOPPRO_CMP_MenuWidget').css('padding-right','0');

});
";

/*

*/


//        OW::getDocument()->addScriptDeclaration($script);
//        OW::getDocument()->addScript($script);
        OW::getDocument()->addOnloadScript($script);


}
//OW::getEventManager()->bind(BASE_CMP_ProfileActionToolbar::EVENT_NAME, 'shoppro_set_credits_action_tool');
//OW::getEventManager()->bind('core.app_init', 'shoppro_set_credits_action_tool');
OW::getEventManager()->bind('core.finalize', 'shoppro_set_credits_action_tool');


//        $mailx= BOL_MailService::getInstance();
/*
        $mail_setting_list = array(
            'sender' => array("aron@grafnet.pl", "aron name")
        );
        $mailx->addListToQueue($mail_setting_list);

        $mailx->send($mail);   
*/

