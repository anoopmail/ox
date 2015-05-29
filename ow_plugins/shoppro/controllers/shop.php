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


class SHOPPRO_CTRL_Shop extends OW_ActionController
{

    private $curent_hash="";
    public function ajax_text() 
    {
        echo "Test ajax OK";



        exit;
    }

    public function ajaxx($params) 
    {
        $id_user = OW::getUser()->getId();//citent login user (uwner)
            $is_admin = OW::getUser()->isAdmin();//iss admin
        $curent_url=OW_URL_HOME;

        if ($id_user>0  AND isset($params['ss']) AND $params['ss']==substr(session_id(),4,6) AND isset($_GET['pid']) AND $_GET['pid']>0){
            $title=OW::getLanguage()->text('shoppro', 'subject_ask_product');
            if (isset($_GET['content']) AND $_GET['content']){
                $message= $_GET['content'];
            }else{
                $message=$title;
            }
            $from=$id_user;
            $query2 = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($_GET['pid'])."' LIMIT 1";
            $arrp2 = OW::getDbo()->queryForList($query2);
            $to=0;
            if (isset($arrp2[0]) AND strlen($arrp2[0]['id'])>0 AND isset($arrp2[0]['id_owner']) AND $arrp2[0]['id_owner']>0) {
                $to=$arrp2[0]['id_owner'];
            }
//echo $query2;
//print_r($arrp2);
//echo $from."--".$to;exit;
            if ($from>0 AND $to>0){
//                SHOPPRO_BOL_Service::getInstance()->add_to_mailbox($from,$to,$title,$message="",$datamessage="",$from_email="")
//echo "aaaaaaaaaaaa";            
                SHOPPRO_BOL_Service::getInstance()->add_to_mailbox($from,$to,$title,$message);
//echo "ddddddddd";            
//-----------------send email start
//if (OW::getConfig()->getValue('mailboxpro', 'use_external_email')=="1" AND $fromx){
/*
                $imap_setver=OW::getConfig()->getValue('mailboxpro', 'imap_server');
                $imap_login=OW::getConfig()->getValue('mailboxpro', 'imap_user');
                $imap_passwd=OW::getConfig()->getValue('mailboxpro', 'imap_password');
                $imap_port=OW::getConfig()->getValue('mailboxpro', 'imap_server_port');
                if (!$imap_port) $imap_port="";
                $imap_email=OW::getConfig()->getValue('mailboxpro', 'imap_email');
//                $servertype="imap";//  pop/imap
//            $servertype="pop";//  pop/imap
*/
                $recip_email="";
//                if ($imap_setver AND $imap_login AND $imap_passwd AND $imap_email){
//echo "--------".OW::getConfig()->getValue('base', 'site_email');
                if (OW::getConfig()->getValue('base', 'site_email') AND $to>0){

                        $sql="SELECT * FROM " . OW_DB_PREFIX. "base_user WHERE id='".addslashes($to)."' LIMIT 1";
                        $arra = OW::getDbo()->queryForList($sql);
//echo $sql;
                        if (isset($arra['0']['id']) AND $arra['0']['id']>0 AND isset($arra['0']['email']) AND $arra['0']['email']){
                            $recip_email=$arra['0']['email'];
                        }

                        $fromx="";
                            if ($recip_email){
                                $pattern = '/([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])'.'(([a-z0-9-])*([a-z0-9]))+' . '(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)/i';
                                preg_match ($pattern, $recip_email, $matches);
                                if (isset($matches[0]) AND $matches[0]){
                                    $fromx=$matches[0];
                                }
                            }

                    if ($recip_email AND $fromx){
//                            $remail=BOL_UserService::getInstance()->getDisplayName($to);
    //                        $remail=$remail."@".$remail;
                        $content_d=$message;
                        $subject=$title;

                        $mail = OW::getMailer()->createMail();
                        $mail->addRecipientEmail($recip_email);
//                        $mail->setSender($imap_email);
                        $mail->setSender(OW::getConfig()->getValue('base', 'site_email'));
                        $mail->setSubject($subject);
                        $mail->setTextContent($content_d);
                        $mail->setHtmlContent($content_d);
//                        $mail->setReplyTo (OW::getConfig()->getValue('base', 'site_email'));
                        $mail->setReplyTo ($recip_email);
                        OW::getMailer()->send($mail);
                    }
                }
//echo $recip_email;
//exit;
//}
//-----------------send esl end
            }//if ($from>0 AND $to>0){


/*
echo "SdfsdfsDF!!ss111";
print_r($params);
print_r($_GET);
exit;
*/
            //TODO SAVE MESSAGE!!
        }


        if (isset($_GET['burl']) AND $_GET['burl']=="mobile"){
            if (isset($_GET['pid']) AND $_GET['pid']>0){
                OW::getApplication()->redirect($curent_url."mobile/v2/option/shopzoom/".$_GET['pid']);
//                header("Location: ".$curent_url."mobile/v2/option/shopzoom/".$_GET['pid']);
//                die()
            }else{
                OW::getApplication()->redirect($curent_url."mobile/v2/option/shop");
//                header("Location: ".$curent_url."mobile/v2/option/shop");
//                die()
            }
        }else{
            OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'mesage_was_send'));
            if (isset($_GET['pid']) AND $_GET['pid']>0){
                OW::getApplication()->redirect($curent_url."product/".$_GET['pid']."/zoom/produkt.html");
            }else{
                OW::getApplication()->redirect($curent_url."shop");
            }
        }

        exit;
    }

    public function indexset($params)
    {
        if (isset($params['op'])){
            if ($params['op']=="grid-view"){
                $_SESSION['curent_view']="grid-view";
                OW::getApplication()->redirect($curent_url."shop");
            }else{
                $_SESSION['curent_view']="list-view";
            }
            OW::getApplication()->redirect($curent_url."shop");
        }
    }

    public function indextermofuse($params)
    {
        $content="";
        if (isset($params['idm']) AND $params['idm']>0){

            $query2 = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_seller WHERE is_owner='".addslashes($params['idm'])."' LIMIT 1";
            $arrp2 = OW::getDbo()->queryForList($query2);
            if (isset($arrp2[0]) AND strlen($arrp2[0]['termofuse'])>3) {
                $valuep2=$arrp2[0];
                $content .="<div class=\"ow_page clearfix for_html\">";
$content .="<table class=\"ow_table_1 ow_form\" cellspacing=\"0\" cellpadding=\"0\" style=\"border:0;width:100%;\" >";

$content .="<tr class=\"ow_tr_first\">
        <th class=\"ow_name ow_txtleft\">
            <span class=\"ow_section_icon ow_ic_star\">".OW::getLanguage()->text('shoppro', 'termofuse').":</span>
        </th>
</tr>";

$content .="<tr>";
$content .="<td>";
    $content .=stripslashes($valuep2['termofuse']);
$content .="</td>";
$content .="</tr>";

$content .="</table>";

                    
                "</div>";
            }else{
                $valuep2=array();
                $valuep2['termofuse']="";
                OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'member_hasnot_termofuse'));
                OW::getApplication()->redirect($curent_url."seller/setting");
                exit;
            }
        }else{
            OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'member_hasnot_termofuse'));
            OW::getApplication()->redirect($curent_url."seller/setting");
            exit;
        }
        $content=SHOPPRO_BOL_Service::getInstance()->make_tabs("shop",$content);
        $this->assign('content', $content);
    }

    public function indexgpc($params)//iframe
    {
        $id_user = OW::getUser()->getId();//citent login user (uwner)
            $is_admin = OW::getUser()->isAdmin();//iss admin
        $curent_url=OW_URL_HOME;
        $thenam=OW::getThemeManager()->getSelectedTheme()->getDto()->getName();
$contentlang="";
foreach (explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']) as $lang) {
    $pattern = '/^(?P<primarytag>[a-zA-Z]{2,8})'.
    '(?:-(?P<subtag>[a-zA-Z]{2,8}))?(?:(?:;q=)'.
    '(?P<quantifier>\d\.\d))?$/';

    $splits = array();

//    printf("Lang:,,%s''\n", $lang);
    if (preg_match($pattern, $lang, $splits)) {
//        print_r($splits);
        if (isset($splits[0])){
            $contentlang = $splits[0];
            break;
        }
//echo $splits[0];exit;
//    } else {
//        echo "\nno match\n";
    }
}

if (!$contentlang){
//    $contentlang="pl-PL";
    $contentlang="en-US";
}

        $charset="UTF-8";

echo "<"."!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"[ttcontentlang]\" dir=\"ltr\" style=\"min-width:auto;margin:auto;padding:auto;white-space:normal;\">
<head>
<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
<title>Page a6.pl</title>
<meta name=\"keywords\" content=\"a6.pl\" />
<meta name=\"description\" content=\"a6.pl\" />
<meta http-equiv=\"Content-type\" content=\"text/html; charset=".$charset."\" />
<meta http-equiv=\"Content-language\" content=\"".$contentlang."\" />

<link rel=\"stylesheet\" type=\"text/css\" href=\"".$curent_url."ow_static/plugins/base/css/ow.css\" media=\"all\" />

<link rel=\"stylesheet\" type=\"text/css\" href=\"".$curent_url."ow_static/themes/".OW::getConfig()->getValue('base', 'selectedTheme')."/base.css\" media=\"all\" />

<link rel=\"stylesheet\" type=\"text/css\" href=\"".$curent_url."ow_static/themes/".$thenam."/base.css\" media=\"all\" />

<script type=\"text/javascript\" src=\"".$curent_url."ow_static/plugins/base/js/jquery-1.7.1.min.js\"></script>
<script type=\"text/javascript\" src=\"".$curent_url."ow_static/plugins/startpage/ajaxfileupload.js\"></script>
<style  media=\"all\">
html,body{
    background-color: transparent;
    min-width: initial;
    max-width: initial;
    width:100%;
    height:auto;
    margin:auto;
    margin:10px;
}
body{
    background-color: transparent;
    background-image: initial;
    width:auto;
    margin:auto;
    padding:auto;
    min-width:0;
    margin:10px;
}

body, html {
    min-width: initial;
}

html {height:100%}
body {
margin:0;
height:100%;
overflow:hidden;
    margin:10px 20px 10px 10px;
}

#iframecontent{
    border:0;
    margin:0;
    padding:0;
    widtn:100%;
    height:auto;
    display:block;
}







.post_content ul, .body ul,.ow_content_html ul,.for_html ul{
    margin:auto;
    padding:21px;
    display: list-item;
    display-style: none;
}
.post_content ol, .body ol,.ow_content_html ol,.for_html ol{
    margin:auto;
    padding:21px;
    display: list-item;
    display-style: none;
}
.post_content li, .for_html li{
    list-style: disc;
    display: list-item;
}



.post_content ul li, .ow_content_html ul li,.for_html ul li{
    margin:auto;
    list-style: disc;
    display: list-item;
}
.post_content ol li,.ow_content_html ol li,.for_html ol li{
    margin:auto;
    list-style: decimal;
    display: list-item;
}


.ow_page .details .body ul li,.for_html ul li{
    margin:auto;
    list-style: disc;
    display: list-item;

}

.body ul li,.for_html ul li{
    margin:auto;
    list-style: disc;
    display: list-item;

}

.ow_content sup {
    vertical-align: top; font-size: 0.6em; 
}

sup {
    vertical-align: top; font-size: 0.6em; 
}










ul{
    margin:auto;
    padding:21px;
    display: list-item;
    display-style: none;
}
ol{
    margin:auto;
    padding:21px;
    display: list-item;
    display-style: none;
}
li{
    list-style: disc;
    display: list-item;
}





</style>


</head>
<body id=\"iframe-body\" >
<div id=\"iframecontent\" class=\"iframecontent\">
";

        $description="";
        if (isset($params['idp']) AND isset($params['ss']) AND $params['ss']==substr(session_id(),2,6) AND $params['idp']>0){
                if (isset($_GET['cl']) AND $_GET['cl']>0){
                    $curent_lang=$_GET['cl'];
                }else{
                    $curent_lang=SHOPPRO_BOL_Service::getInstance()->get_curect_lang_id();
                }
                $curent_lang_def=SHOPPRO_BOL_Service::getInstance()->get_system_lang_id();//default oxwall website language

                $query = "SELECT pr.*,prd.description_de, prdx.description_de as description_de_def FROM " . OW_DB_PREFIX. "shoppro_products pr 
                LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_description prd ON (prd.id_product_de=pr.id AND prd.id_lang_de='".addslashes($curent_lang)."')  
        LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_description prdx ON (prdx.id_product_de=pr.id AND prdx.id_lang_de='".addslashes($curent_lang_def)."')
                WHERE pr.id='".addslashes($params['idp'])."' LIMIT 1";
                $arrx = OW::getDbo()->queryForList($query);
                if (isset($arrx[0])){
                    $value=$arrx[0];
                }else{
                    $value=array();
                    $value['id']=0;
                }

                if ($value['id']>0){
                    if (isset($value['description_de']) AND $value['description_de']){
                        $description= stripslashes($value['description_de']);
                    }else if (isset($value['description_de_def']) AND $value['description_de_def']){
                        $description=stripslashes($value['description_de_def']);
                    }else{
                        $description= stripslashes($value['description']);
                    }      
                    if (OW::getConfig()->getValue('shoppro', 'admin_replace_btobr')==1){
                        $description=str_replace("\r\n","<br/>",$description);
                        $description=str_replace("\n","<br/>",$description);
                    }  
                    echo $description;
                }
        }else{
            echo "No found page!";
        }
        echo "</div>";
        echo "</body>";
        echo "</html>";
        exit;
    }

    public function indexsellersetting($params)
    {
        $content="";
        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();//iss admin
        $curent_url=OW_URL_HOME;
        if (!$id_user) {
            OW::getApplication()->redirect($curent_url."shop");
            exit;
        }

        if (isset($_POST['ac']) AND $_POST['ac']=="save_stat" AND isset($_POST['ss']) AND $_POST['ss']==substr(session_id(),5,7)){
            $sql="INSERT INTO " . OW_DB_PREFIX. "shoppro_seller (
                is_owner  ,      termofuse
            )VALUES(
                '".addslashes($id_user)."','".addslashes($_POST['f_termofuse'])."'
            ) ON DUPLICATE KEY UPDATE termofuse='".addslashes($_POST['f_termofuse'])."' ";
            OW::getDbo()->query($sql);

            OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'saved_succesfull'));
            OW::getApplication()->redirect($curent_url."seller/setting");
            exit;
        }


                    $query2 = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_seller WHERE is_owner='".addslashes($id_user)."' LIMIT 1";
                    $arrp2 = OW::getDbo()->queryForList($query2);
                    if (isset($arrp2[0])) {
                        $valuep2=$arrp2[0];
                    }else{
                        $valuep2=array();
                        $valuep2['termofuse']="";
                    }


        $content .="<form id=\"edform\" action=\"".$curent_url."seller/setting\" method=\"POST\" enctype=\"multipart/form-data\">";
//        $content .="<input type=\"hidden\" name=\"f\" value=\"".$_GET['f']."\">";
        $content .="<input type=\"hidden\" name=\"ss\" value=\"".substr(session_id(),5,7)."\">";
//        $content .="<input type=\"hidden\" name=\"id\" value=\"".$value['id']."\">";
//        $content .="<input type=\"hidden\" name=\"eid\" value=\"".$value['entityId']."\">";
        $content .="<input type=\"hidden\" name=\"ac\" value=\"save_stat\">";


        $content .="<table class=\"ow_table_1 ow_form\">";
/*
$content .="<tr class=\"ow_tr_first\">
        <th class=\"ow_name ow_txtleft\" colspan=\"2\">
        </th>
</tr>";
*/
        $content .="<tr>";
        $content .="<td class=\"ow_label\" valign=\"top\">";
        $content .=OW::getLanguage()->text('shoppro', 'termofuse').":";
        $content .="</td>";
        $content .="<td class=\"ow_value\" valign=\"top\">";
        $content .="<textarea class=\"html\" name=\"f_termofuse\" style=\"min-width:300px;min-height:300px;\">".stripslashes($valuep2['termofuse'])."</textarea>";
        $content .="</td>";
        $content .="</tr>";


        $content .="<tr>";
        $content .="<td colspan=\"2\">";
            $content .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"submit\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'save')."\" class=\"ow_ic_save ow_positive\">
                        </span>
                    </span>
                </div>
            </div>";
        $content .="</td>";
        $content .="</tr>";
        $content .="</table>";



        $content .="</form>";

        $content=SHOPPRO_BOL_Service::getInstance()->make_tabs("setting",$content);
        $this->assign('content', $content);
    }

	
    public function index($params)
    {
//	error_reporting(E_ALL);
//$this->assign('content', "asdfasfd");
if (!isset($params['optionadm'])) $params['optionadm']="";
if (!isset($params['options'])) $params['options']="";
if (!isset($params['option'])) $params['option']="";
if (!isset($params['caction'])) $params['caction']="";
if (!isset($params['idcat'])) $params['idcat']="";
if (!isset($params['download'])) $params['download']="";
if (!isset($params['prot'])) $params['prot']="";
if (!isset($params['optmy'])) $params['optmy']="";
//baynowcredits/:idproductbuycredits
if (!isset($params['idproductbuycredits'])) $params['idproductbuycredits']="";
if (!isset($params['idproductbuyfree'])) $params['idproductbuyfree']="";

$curent_lang=SHOPPRO_BOL_Service::getInstance()->get_curect_lang_id();


//-------------set def grid/list start



    if (OW::getConfig()->getValue('shoppro', 'defaut_view')=="grid-view-only"){
            $_SESSION['curent_view']="grid-view";
    }else if (OW::getConfig()->getValue('shoppro', 'defaut_view')=="list-view-only"){
            $_SESSION['curent_view']="list-view";
    }else if (!isset($_SESSION['curent_view'])){
        if (OW::getConfig()->getValue('shoppro', 'defaut_view')=="grid-view"){
            $_SESSION['curent_view']="grid-view";
        }else{//list-view
            $_SESSION['curent_view']="list-view";
        }
    }
//-------------set def grid/list start


//print_r($params);exit;
//if (!$params['optionadm'])

                    $id_user = OW::getUser()->getId();//citent login user (uwner)
                    $is_admin = OW::getUser()->isAdmin();//iss admin
                    $pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();
                    $pluginStaticURL =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesUrl();
                    $pluginStaticDir =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesDir();
                    $protectkey=substr(session_id(),1,5);
                    $curent_url = 'http';
                    if (isset($_SERVER["HTTPS"])) {$curent_url .= "s";}
                    $curent_url .= "://";
                    $curent_url .= $_SERVER["SERVER_NAME"]."/";
$curent_url=OW_URL_HOME;
                    $content="";

/*
echo substr(session_id(),5,7);
echo "------".$is_admin;
echo "<hr>";
print_r($_POST);
print_r($params);
//exit;
*/

//grid-view-only

    if (isset($_GET['shop_set_order'])){
        $_SESSION['shoplist_order']=$_GET['shop_set_order'];
    }else if (isset($_POST['shop_set_order'])){
        $_SESSION['shoplist_order']=$_POST['shop_set_order'];
    }


        if  (SHOPPRO_BOL_Service::getInstance()->check_acces()){
            $thru_role=true;
        }else{
            $thru_role=false;
        }

//        if ($is_admin AND isset($_POST['ac']) AND $_POST['ac']=="changestat" AND isset($params['options']) AND $params['options']=="changestat" AND $_POST['ss']==substr(session_id(),5,7)){
        if ($id_user AND isset($_POST['ac']) AND $_POST['ac']=="changestat"  AND isset($params['option']) AND $params['option']=="changestat" AND $_POST['ss']==substr(session_id(),5,7) AND $thru_role==true){
//echo "sss";exit; 
//print_r($_POST);exit;
//echo SHOPPRO_BOL_Service::getInstance()->isplugin('usercredits');

//--credits give start
//usercredits_action
    if (isset($_POST['give_credits']) AND $_POST['give_credits']>0 AND isset($_POST['eid']) AND $_POST['eid']>0 AND SHOPPRO_BOL_Service::getInstance()->isplugin('usercredits')){//classified
//        $content_ststus .=OW::getLanguage()->text('shoppro', 'credits_restore_to_mmber').": <input type=\"text\" name=\"give_credits\" value=\"".$price."\" style=\"width:65px;\"> ".OW::getLanguage()->text('shoppro', 'product_credits')." ".OW::getLanguage()->text('shoppro', 'tothismember');
//        SHOPPRO_BOL_Service::getInstance()->move_credits($from=0,$to=0,$add_to_user_for_sale=0);
//        $query2 = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($_POST['eid'])."' AND type_ads='2' LIMIT 1";//type 2 - sale by Credits
//        $query2 = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($_POST['eid'])."' AND type_ads='2' LIMIT 1";//type 2 - sale by Credits
        $query2 = "SELECT * FROM " . OW_DB_PREFIX. "base_billing_sale WHERE id='".addslashes($_POST['id'])."' LIMIT 1";//type 2 - sale by Credits
//echo $query2;
        $arrp2 = OW::getDbo()->queryForList($query2);
        if (isset($arrp2[0])) {
            $valuep2=$arrp2[0];
//            SHOPPRO_BOL_Service::getInstance()->move_credits($id_user=0,$valuep2['id_owner'],$_POST['give_credits']);
            SHOPPRO_BOL_Service::getInstance()->move_credits($id_user=0,$valuep2['userId'],$_POST['give_credits']);
        }
    }
//--credits give end
//exit;
            if (isset($_POST['id']) AND isset($_POST['eid']) AND isset($_POST['new_status']) AND $_POST['id']>0 AND $_POST['eid']>0 AND $_POST['new_status']){
                    if (!$is_admin){
                        $dd=" AND userId='".addslashes($id_user)."' ";
                    }else{
                        $dd="";
                    }
                    $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale SET status='".addslashes($_POST['new_status'])."' 
                        WHERE id='".addslashes($_POST['id'])."' LIMIT 1";
                    OW::getDbo()->query($query); 
                    OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'change_status_succesfull'));
            }else{
                    OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'change_status_error'));
            }

                if (isset($_POST['f'])){
                    OW::getApplication()->redirect($curent_url."ordershop/showorder?f=".$_POST['f']);
                }else{
                    OW::getApplication()->redirect($curent_url."ordershop/showorder");
                }
                exit;
        }else if (isset($params['option']) AND $params['option']=="changestat"){
            OW::getApplication()->redirect($curent_url."ordershop/showorder");
            exit;
        }
//echo "END";exit;

//print_r($params);exit;
/*
Array
(
    [idproduct] =&gt; 62
    [options] =&gt; block
    [optionadm] =&gt; 
    [option] =&gt; 
    [caction] =&gt; 
    [idcat] =&gt; 
    [download] =&gt; 
    [prot] =&gt; 
    [optmy] =&gt; 
    [idproductbuycredits] =&gt; 
    [idproductbuyfree] =&gt; 
)
*/

        if (isset($params['idproduct']) AND isset($params['options']) AND $params['idproduct']>0 AND ($params['options']=="block" OR $params['options']=="unblock") AND ($is_admn OR $id_user>0) AND isset($_GET['ss']) AND $_GET['ss']==substr(session_id(),3,2) AND isset($_GET['spr']) AND $_GET['spr']>0){
            if ($params['options']=="unblock"){
                $sql="UPDATE " . OW_DB_PREFIX. "base_billing_sale SET status='delivered' WHERE id='".addslashes($_GET['spr'])."' AND entityId='".addslashes($params['idproduct'])."' AND pluginKey='shoppro_product' LIMIT 1";
                OW::getDbo()->query($sql);
                OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'bay_change_order_status'));
                if (isset($_GET['f'])){
                    OW::getApplication()->redirect($curent_url."ordershop/showorder?f=".$_GET['f']);
                }else{
                    OW::getApplication()->redirect($curent_url."ordershop/showorder");
                }
            }else{
                $sql="UPDATE " . OW_DB_PREFIX. "base_billing_sale SET status='error' WHERE id='".addslashes($_GET['spr'])."' AND entityId='".addslashes($params['idproduct'])."' AND pluginKey='shoppro_product' LIMIT 1";
                OW::getDbo()->query($sql);
                OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'bay_change_order_status'));
                if (isset($_GET['f'])){
                    OW::getApplication()->redirect($curent_url."ordershop/showorder?f=".$_GET['f']);
                }else{
                    OW::getApplication()->redirect($curent_url."ordershop/showorder");
                }
            }
        }

//        if ($params['idproductbuycredits']!="" AND $id_user>0){//by for credits st
//        if ($params['idproductbuycredits']!=""  AND ($is_admin OR ($id_user>0 AND OW::getConfig()->getValue('shoppro', 'mode_membercanshell')==1))){//by for credits st
        if ($params['idproductbuycredits']!=""){//--------------------------------------------------------------------------------by for credits st
            if (!$id_user){
                $curent_full_url=$_SERVER["REQUEST_URI"];
//                OW::getApplication()->redirect($curent_url."sign-in?back-uri=".urlencode($curent_full_url));
                OW::getApplication()->redirect($curent_url."sign-in?back-uri=".$curent_full_url);

            }else{
                list($id_pr,$checkx)=explode("_",$params['idproductbuycredits']);
                $is_points=SHOPPRO_BOL_Service::getInstance()->isplugin('usercredits');
                if ($id_pr>0 AND $checkx==substr(session_id(),7,6) AND $is_points AND OW::getConfig()->getValue('shoppro', 'mode_membercanselingbypoints')==1){
//                echo "by credits start";

                    $query2 = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($id_pr)."' AND type_ads='2' LIMIT 1";//type 2 - sale by Credits
                    $arrp2 = OW::getDbo()->queryForList($query2);
                    if (isset($arrp2[0])) {
                        $valuep2=$arrp2[0];
                    }else{
                        $valuep2=array();
                        $valuep2['price']=0;
                        $valuep2['id']=0;
                        $valuep2['id_owner']=0;
                        $valuep2['items']=0;
                    }
                    if ($valuep2['items']<1){
                        OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'bay_error_notbayselproducts'));
                        OW::getApplication()->redirect($curent_url."shop");
                    }else if ($valuep2['id']>0 AND $valuep2['price']>0 AND $valuep2['id_owner']>0 AND $valuep2['id_owner']!=$id_user){
                        $query = "SELECT * FROM " . OW_DB_PREFIX. "usercredits_balance WHERE userId='".addslashes($id_user)."' LIMIT 1";
                        $arrp = OW::getDbo()->queryForList($query);
                        $valuep=$arrp[0];
                        if ($valuep['balance']>=$valuep2['price']){

                            $hash=md5(date("Y-m-d H:i:s"));
//$this->set_hash($hash);
//echo $_SESSION['last_hash']=;
//$_SESSION['last_hash']=$hash;
//$_SESSION['last_id_bay']=$entityId;
                            $timeStamp=strtotime(date('Y-m-d H:i:s'));
//echo "fsdfsdf";exit;
                            $query = "INSERT INTO " . OW_DB_PREFIX. "base_billing_sale  (
                                    id,  hash ,   pluginKey   ,    entityKey    ,   entityId  ,      entityDescription  ,     gatewayId ,      
                                userId,  transactionUid,  price ,  period , quantity        ,
                                totalAmount  ,   currency  ,      recurring  ,     status , timeStamp   ,    extraData
                            )VALUES(
                                '','".addslashes($hash)."','shoppro_product','".addslashes(mb_substr(stripslashes($valuep2['name']),0,50))."','".addslashes($valuep2['id'])."','".addslashes(mb_substr(stripslashes($valuep2['description']),0,255))."','2',
                                '".addslashes($id_user)."',NULL,'".addslashes($valuep2['price'])."',NULL,'1',
                                '".addslashes($valuep2['price'])."','-CR','0','processing','".addslashes($timeStamp)."',NULL
                            )";

                            $last_insert_id = OW::getDbo()->insert($query);
                            if ($last_insert_id>0){

//---dec ilosc start
                                $query = "UPDATE " . OW_DB_PREFIX. "shoppro_products SET items=items-1 WHERE id='".addslashes($valuep2['id'])."' LIMIT 1";
                                OW::getDbo()->query($query);
//---dec ilosc end x

SHOPPRO_BOL_Service::getInstance()->tonotyficat($valuep2['id_owner'],$valuep2['id'],"","shop-wasbuy","shoppro+member_was_buy_item_url","shoppro",stripslashes($valuep2['name']),$curent_url."product/".$valuep2['id']."/zoom/product.html");

//-------email start
/*
if (OW::getConfig()->getValue('shoppro', 'sel_notyfybyemail')==1 AND OW::getConfig()->getValue('base', 'site_email')){
//        $user = BOL_UserService::getInstance()->findUserById($id_user);
        $user = BOL_UserService::getInstance()->findUserById($valuep2['id_owner']);
        if ($user->email){
//            $dname=BOL_UserService::getInstance()->getDisplayName($id_user);
            $dname=BOL_UserService::getInstance()->getDisplayName($valuep2['id_owner']);
            $message="";
//            $message .=OW::getLanguage()->text('shoppro', 'notyfy_sel_message',array('username'=>$dname,'sitename'=>OW::getConfig()->getValue('base', 'site_name'),'siteurl'=>$curent_url.'product/'.$valuep2['id'].'/zoom/product.html'));
            $message .=OW::getLanguage()->text('shoppro', 'notyfy_sel_message',array('username'=>$dname,'sitename'=>OW::getConfig()->getValue('base', 'site_name'),'siteurl'=>$curent_url.'ordershop/showorder'));
//            $message .="--".$user->email;

            $mail = OW::getMailer()->createMail();
            $mail->addRecipientEmail($user->email);
            $mail->setSender(OW::getConfig()->getValue('base', 'site_email'));
            $mail->setSubject(OW::getLanguage()->text('shoppro', 'notyfy_sel_subject'));
            $mail->setTextContent($message);
            OW::getMailer()->send($mail);
        }
}
*/
if (OW::getConfig()->getValue('shoppro', 'sel_notyfybyemail')==1 AND OW::getConfig()->getValue('base', 'site_email')){
    $user = BOL_UserService::getInstance()->findUserById($valuep2['id_owner']);
    if ($user->email){
        $dname=BOL_UserService::getInstance()->getDisplayName($valuep2['id_owner']);
        $message =OW::getLanguage()->text('shoppro', 'notyfy_sel_message',array('username'=>$dname,'sitename'=>OW::getConfig()->getValue('base', 'site_name'),'siteurl'=>$curent_url.'ordershop/showorder'));
        $subject=OW::getLanguage()->text('shoppro', 'notyfy_sel_subject');
        SHOPPRO_BOL_Service::getInstance()->email_notyfication($valuep2['id_owner'],$subject,$message);
    }
}
//-------email end

//-------start
$add_to_user_for_sale=OW::getConfig()->getValue('shoppro', 'mode_membergepointsfrombaing');
if ($add_to_user_for_sale>0 AND SHOPPRO_BOL_Service::getInstance()->isplugin('usercredits')){
                                if ($id_user>0 AND $valuep2['id_owner']>0 AND $id_user!=$valuep2['id_owner']){
//echo "SdfsdF";exit;
                                    $query = "INSERT INTO " . OW_DB_PREFIX. "usercredits_balance (id ,   userId , balance)VALUES ('','".addslashes($id_user)."','".addslashes($add_to_user_for_sale)."') 
                                    ON DUPLICATE KEY UPDATE balance=balance+".addslashes($add_to_user_for_sale); 
                                    OW::getDbo()->insert($query);
//---log credits strat
                                    $query = "INSERT INTO " . OW_DB_PREFIX. "usercredits_log (
                                        id ,     userId,  actionId     ,   amount , logTimestamp
                                    )VALUES(
                                        '','".addslashes($id_user)."','23','".addslashes($add_to_user_for_sale)."','".addslashes($timeStamp)."'
                                    )";//recive:23
                                    OW::getDbo()->insert($query);
//---log credits end
                                }
//echo "eeeeeeeeeeeeeee";
}
//-------------end

//echo "sfsdfsdF";exit;

                                $query = "UPDATE " . OW_DB_PREFIX. "usercredits_balance SET balance=balance-".addslashes($valuep2['price'])." WHERE userId='".addslashes($id_user)."' LIMIT 1";
                                OW::getDbo()->query($query);
//                                $query = "UPDATE " . OW_DB_PREFIX. "usercredits_balance SET balance=balance+".addslashes($valuep2['price'])." WHERE userId='".addslashes($valuep2['id_owner'])."' LIMIT 1";
//                                OW::getDbo()->query($query);

                                $query = "INSERT INTO " . OW_DB_PREFIX. "usercredits_balance (id ,   userId , balance)VALUES ('','".addslashes($valuep2['id_owner'])."','".addslashes($valuep2['price'])."') 
                                    ON DUPLICATE KEY UPDATE balance=balance+".addslashes($valuep2['price']); 
                                OW::getDbo()->insert($query);



//---log credits strat
                                    $query = "INSERT INTO " . OW_DB_PREFIX. "usercredits_log (
                                        id ,     userId,  actionId     ,   amount , logTimestamp
                                    )VALUES(
                                        '','".addslashes($id_user)."','22','-".addslashes($valuep2['price'])."','".addslashes($timeStamp)."' 
                                    )";//send:22
                                    OW::getDbo()->insert($query);

                                    $query = "INSERT INTO " . OW_DB_PREFIX. "usercredits_log (
                                        id ,     userId,  actionId     ,   amount , logTimestamp
                                    )VALUES(
                                        '','".addslashes($valuep2['id_owner'])."','23','".addslashes($valuep2['price'])."','".addslashes($timeStamp)."' 
                                    )";//recive:23
                                    OW::getDbo()->insert($query);
//---log credits end


//----delete cart s
                                if (OW::getPluginManager()->isPluginActive('cart')){
//                                $sql="DELETE FROM " . OW_DB_PREFIX. "cart WHERE id_procuct='".addslashes($id_pr)."' AND id_owner='".addslashes($valuep2['id_owner'])."' LIMIT 1";
                                    $sql="DELETE FROM " . OW_DB_PREFIX. "cart WHERE id_procuct='".addslashes($id_pr)."' AND id_owner='".addslashes($id_user)."' LIMIT 1";
                                    OW::getDbo()->query($sql);
                                }
//echo $sql;exit;                                
//----delete cart e


                                OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'bay_succes_bycredits'));
                                OW::getApplication()->redirect($curent_url."basket/showbasket");
                            }else{
                                OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'bay_error_whilesavingtostore'));
//                        $content .="xxxx not enooght Cretits";
                                OW::getApplication()->redirect($curent_url."shop");
                            }
                        }else{
/*
var box = $('#subbox');
box.css('top',  200);
box.css('left', 300);     
$(document.body).append(box);
*/
//$script="alert('aa');";
// OW::getDocument()->addOnloadScript($script);
                        OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'bay_error_donothavecredits'));
//                        $content .="xxxx not enooght Cretits";
                        OW::getApplication()->redirect($curent_url."shop");
                        }
                    }else{
                        OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'bay_error_notbayselproducts'));
///                            $content .="xxxx dont bay self products";
                        OW::getApplication()->redirect($curent_url."shop");
                    }
//echo  $content;
//exit;
//info
//error
//
                }
            }//else is user
        }////by for credits en

//echo substr(session_id(),7,6);exit;
//        if ($params['idproductbuyfree']!="" AND ($is_admin OR ($id_user>0 AND OW::getConfig()->getValue('shoppro', 'mode_membercanshell')==1)) ){//by free product
        if ($params['idproductbuyfree']!=""){//============================================================================================================================by free product

            if (!$id_user){
                $curent_full_url=$_SERVER["REQUEST_URI"];
//                OW::getApplication()->redirect($curent_url."sign-in?back-uri=".urlencode($curent_full_url));
                OW::getApplication()->redirect($curent_url."sign-in?back-uri=".$curent_full_url);
            }else{
                list($id_pr,$checkx)=explode("_",$params['idproductbuyfree']);
//                $is_points=SHOPPRO_BOL_Service::getInstance()->isplugin('usercredits');

                if ($id_pr>0 AND $checkx==substr(session_id(),7,6) ){
                    $query2 = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($id_pr)."' AND price='0' LIMIT 1";//noprice

//echo "ss";
                    $arrp2 = OW::getDbo()->queryForList($query2);
                    if (isset($arrp2[0])) {
                        $valuep2=$arrp2[0];
                    }else{
                        $valuep2=array();
                        $valuep2['price']=0;
                        $valuep2['id']=0;
                        $valuep2['id_owner']=0;
                        $valuep2['items']=0;
                    }
                    if ($valuep2['items']<1){
                        OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'bay_error_item_wassaled'));
                        OW::getApplication()->redirect($curent_url."shop");
                    }else if ($valuep2['id']>0 AND $valuep2['price']==0 AND $valuep2['id_owner']>0 AND $valuep2['id_owner']!=$id_user){


                            $hash=md5(date("Y-m-d H:i:s"));
                            $timeStamp=strtotime(date('Y-m-d H:i:s'));
                            $query = "INSERT INTO " . OW_DB_PREFIX. "base_billing_sale  (
                                    id,  hash ,   pluginKey   ,    entityKey    ,   entityId  ,      entityDescription  ,     gatewayId ,      
                                userId,  transactionUid,  price ,  period , quantity        ,
                                totalAmount  ,   currency  ,      recurring  ,     status , timeStamp   ,    extraData
                            )VALUES(
                                '','".addslashes($hash)."','shoppro_product','".addslashes(mb_substr(stripslashes($valuep2['name']),0,50))."','".addslashes($valuep2['id'])."','".addslashes(mb_substr(stripslashes($valuep2['description']),0,255))."','2',
                                '".addslashes($id_user)."',NULL,'".addslashes($valuep2['price'])."',NULL,'1',
                                '".addslashes($valuep2['price'])."','PKT','0','processing','".addslashes($timeStamp)."',NULL
                            )";

                            $last_insert_id = OW::getDbo()->insert($query);
//echo "sss".$last_insert_id;exit;
                            if ($last_insert_id>0){

//---dec ilosc start
                                $query = "UPDATE " . OW_DB_PREFIX. "shoppro_products SET items=items-1 WHERE id='".addslashes($valuep2['id'])."' LIMIT 1";
                                OW::getDbo()->query($query);

//tonotyficat
//                                                       ($toowner,$last_id_comment,$timestamp,'status_comment','newsfeed-status_comment','newsfeed');
//                                                ($toowner=0,$idtype=0,$timestamp="",$status="status_comment",$act="newsfeed-status_comment",$plugin="newsfeed" )
//                                                    ($toowner=0,$idtype=0,$timestamp="",$status="status_comment",$act="newsfeed-status_comment",$plugin="newsfeed",$obj_title="...",$obj_url="" )
SHOPPRO_BOL_Service::getInstance()->tonotyficat($valuep2['id_owner'],$valuep2['id'],"","shop-wasbuy","shoppro+member_was_buy_item_url","shoppro",stripslashes($valuep2['name']),$curent_url."product/".$valuep2['id']."/zoom/product.html");
//-------------email start
/*
if (OW::getConfig()->getValue('shoppro', 'sel_notyfybyemail')==1 AND OW::getConfig()->getValue('base', 'site_email')){
//        $user = BOL_UserService::getInstance()->findUserById($id_user);
        $user = BOL_UserService::getInstance()->findUserById($valuep2['id_owner']);
        if ($user->email){
//            $dname=BOL_UserService::getInstance()->getDisplayName($id_user);
            $dname=BOL_UserService::getInstance()->getDisplayName($valuep2['id_owner']);
            $message="";
//            $message .=OW::getLanguage()->text('shoppro', 'notyfy_sel_message',array('username'=>$dname,'sitename'=>OW::getConfig()->getValue('base', 'site_name'),'siteurl'=>$curent_url.'product/'.$valuep2['id'].'/zoom/product.html'));
            $message .=OW::getLanguage()->text('shoppro', 'notyfy_sel_message',array('username'=>$dname,'sitename'=>OW::getConfig()->getValue('base', 'site_name'),'siteurl'=>$curent_url.'ordershop/showorder'));
//            $message .="--".$user->email;

            $mail = OW::getMailer()->createMail();
            $mail->addRecipientEmail($user->email);
            $mail->setSender(OW::getConfig()->getValue('base', 'site_email'));
            $mail->setSubject(OW::getLanguage()->text('shoppro', 'notyfy_sel_subject'));
            $mail->setTextContent($message);
            OW::getMailer()->send($mail);
        }
}
*/

if (OW::getConfig()->getValue('shoppro', 'sel_notyfybyemail')==1 AND OW::getConfig()->getValue('base', 'site_email')){
    $user = BOL_UserService::getInstance()->findUserById($valuep2['id_owner']);
    if ($user->email){
        $dname=BOL_UserService::getInstance()->getDisplayName($valuep2['id_owner']);
        $message =OW::getLanguage()->text('shoppro', 'notyfy_sel_message',array('username'=>$dname,'sitename'=>OW::getConfig()->getValue('base', 'site_name'),'siteurl'=>$curent_url.'ordershop/showorder'));
        $subject=OW::getLanguage()->text('shoppro', 'notyfy_sel_subject');
        SHOPPRO_BOL_Service::getInstance()->email_notyfication($valuep2['id_owner'],$subject,$message);
    }
}

//-------------email end

//---dec ilosc end
//-------start
$add_to_user_for_sale=OW::getConfig()->getValue('shoppro', 'mode_membergepointsfrombaing');
if ($add_to_user_for_sale>0 AND SHOPPRO_BOL_Service::getInstance()->isplugin('usercredits')){
//echo "fdsfSDF";exit;
                                if ($id_user>0 AND $valuep2['id_owner']>0 AND $id_user!=$valuep2['id_owner']){
                                    $query = "INSERT INTO " . OW_DB_PREFIX. "usercredits_balance (id ,   userId , balance)VALUES ('','".addslashes($id_user)."','".addslashes($add_to_user_for_sale)."') 
                                    ON DUPLICATE KEY UPDATE balance=balance+".addslashes($add_to_user_for_sale); 
                                    OW::getDbo()->insert($query);

//---log credits strat
                                    $query = "INSERT INTO " . OW_DB_PREFIX. "usercredits_log (
                                        id ,     userId,  actionId     ,   amount , logTimestamp
                                    )VALUES(
                                        '','".addslashes($id_user)."','23','".addslashes($add_to_user_for_sale)."','".addslashes($timeStamp)."'
                                    )";//recive:23
                                    OW::getDbo()->insert($query);
//---log credits end


                                }
}
//-------------end
//                                $query = "UPDATE " . OW_DB_PREFIX. "usercredits_balance SET balance=balance-".addslashes($valuep2['price'])." WHERE userId='".addslashes($id_user)."' LIMIT 1";
//                                OW::getDbo()->query($query);
//                                $query = "UPDATE " . OW_DB_PREFIX. "usercredits_balance SET balance=balance+".addslashes($valuep2['price'])." WHERE userId='".addslashes($valuep2['id_owner'])."' LIMIT 1";
//                                OW::getDbo()->query($query);
//                                if ($valuep2['price']>0){
                                if ($add_to_user_for_sale>0 AND SHOPPRO_BOL_Service::getInstance()->isplugin('usercredits')){
                                    OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'bay_succes_bycredits'));
                                }else{
                                    OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'bay_succes'));
                                }
                                OW::getApplication()->redirect($curent_url."basket/showbasket");
                            }else{
                                OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'bay_error_whilesavingtostore'));
                                OW::getApplication()->redirect($curent_url."shop");
                            }
                    }else{
                        OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'bay_error_notbayselproducts'));
                        OW::getApplication()->redirect($curent_url."shop");
                    }
                }
            }//else is user
        }//==================================================================================================================================================by free product end



/*
$from_config=$curent_url;
$from_config=str_replace("https://","",$from_config);
$from_config=str_replace("http://","",$from_config);
$trash=explode($from_config,$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);
$url_detect=$trash[1];
//print_r($trash);
//echo $url_detect;
*/
                    
//print_r($params);exit;
//shop/:download/:option
//shoppro_adm/:optionadm/:idcat
//print_r($params);
/*
Array
(
    [download] =&gt; download
    [option] =&gt; 8
    [optionadm] =&gt; 
    [options] =&gt; 
    [caction] =&gt; 
    [idcat] =&gt; 
)
*/
        if (OW::getConfig()->getValue('shoppro', 'mode_ads_approval') AND $is_admin){
//            $protect
            if (isset($_GET['allow'])){
                list($idd,$prot)=explode("_",$_GET['allow']);
                if ($prot==$protectkey AND $idd>0){
                    $sql="UPDATE " . OW_DB_PREFIX. "shoppro_products SET active='1' WHERE id='".addslashes($idd)."' LIMIT 1";
                    OW::getDbo()->query($sql);
                }
            }else if (isset($_GET['deny'])){
                list($idd,$prot)=explode("_",$_GET['deny']);
//echo $prot."--".$protectkey;
                if ($prot==$protectkey AND $idd>0){
                    $sql="UPDATE " . OW_DB_PREFIX. "shoppro_products SET active='0' WHERE id='".addslashes($idd)."' LIMIT 1";
                    OW::getDbo()->query($sql);
                }
            }else if (isset($_GET['del'])){
                list($idd,$prot)=explode("_",$_GET['del']);
                if ($prot==$protectkey AND $idd>0){
                    $sql="UPDATE " . OW_DB_PREFIX. "shoppro_products SET active='-1' WHERE id='".addslashes($idd)."' LIMIT 1";
                    OW::getDbo()->query($sql);
                }
            }
        }




//print_r($_GET);
//echo $sql;exit;
//        if (($params['download']=="download" AND $params['option']>0 AND $params['prot']) AND (($id_user>0 AND OW::getConfig()->getValue('shoppro', 'mode_sellfiles')==1) OR $is_admin) ){//download
        if (($params['download']=="download" AND $params['option']>0 AND $params['prot'])){//download
//echo "ss";exit;
//            if (!$id_user){
            if (!$id_user OR ($id_user>0 AND OW::getConfig()->getValue('shoppro', 'mode_sellfiles')!=1 AND !$is_admin) ){//download
                $curent_full_url=$_SERVER["REQUEST_URI"];
//                OW::getApplication()->redirect($curent_url."sign-in?back-uri=".urlencode($curent_full_url));
                OW::getApplication()->redirect($curent_url."sign-in?back-uri=".$curent_full_url);
            }else if ($params['prot']==substr(session_id(),3,10)){
//echo "ss";exit;
                $idproduct=$params['option'];
                if ($is_admin){
                    $add=" ";
                    $addbs="";
                }else {
//                    $add=" AND pr.id_owner='".addslashes($id_user)."' ";
                    $add=" bs.userId='".addslashes($id_user)."' AND ";
                    $addbs=" AND (bs.userId='".addslashes($id_user)."' OR pr.id_owner='".addslashes($id_user)."') ";
                }
//if ($valuex['id']>0 AND $valuex['id']==$value['id'] AND $valuex['file_attach'] AND $valuex['username'] AND ($is_admin OR $xprice==0 OR ($xprice>0 AND $valuex['id_owner']==$id_user))  ){
//                    LEFT JOIN " . OW_DB_PREFIX. "base_billing_sale bs ON (bs.entityId=pr.id AND bs.userId=pr.id_owner AND (bs.status='processing' OR bs.status='verified') ".$addbs.") 
                $query = "SELECT pr.*,bs.transactionUid, bs.status,bs.price as pricebs FROM " . OW_DB_PREFIX. "shoppro_products pr 
                    LEFT JOIN " . OW_DB_PREFIX. "base_billing_sale bs ON (bs.entityId=pr.id AND ".$add." (bs.status='processing' OR bs.status='verified' OR bs.status='delivered') )  
                    WHERE pr.id='".addslashes($idproduct)."' ".$addbs." LIMIT 1";

//echo $query;exit;
//echo "<br/>";
//exit;

                $arrxx = OW::getDbo()->queryForList($query);
                if (isset($arrxx[0])){
                    $valuex=$arrxx[0];
                }else{
                    $valuex=array();
                    $valuex['id']=0;
                }
                if ($valuex['id']>0 AND $valuex['id']==$idproduct){
//print_r($valuex);
//exit;
//echo $query;exit;
                    $hash=$valuex['file_attach'];
                    //$path_file="./ow_userfiles/plugins/shoppro/files/";
                    $pluginStaticDir =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesDir();
                    $path_file=$pluginStaticDir."files/";

                    $name_file="file_".$idproduct."_".$hash.".pack";
                    $ext=substr($name_file,-8);
                    $ext=substr($ext,0,3);

//echo $path_file.$name_file."---".is_file($path_file.$name_file);exit;

//print_r($valuex);
//exit;

//                    ($valuex['transactionUid'] AND $valuex['status']=="verified" AND ($valuex['price']*1)>0 )  OR (!$valuex['transactionUid'] AND $valuex['status']!="verified" AND ($valuex['price']*1)==0 AND !$valuex['pricebs'] AND !$valuex['pricebs'])

                    if (is_file($path_file.$name_file) AND 
                            ($id_user>0 AND $is_admin) OR 
                            (
                                (
                                    (($valuex['status']=="verified" OR $valuex['status']=="processing" OR $valuex['status']=="delivered") AND ($valuex['price']*1)>0) 
                                        OR 
                                    ((!$valuex['status'] OR $valuex['status']=="processing" OR $valuex['status']=="delivered") AND ($valuex['price']*1)<=0) 
                                )
                            )
                                OR
                            (
                                ($valuex['id_owner']==$id_user AND $id_user>0)
                            )
            
                        ){

                        $query = "UPDATE " . OW_DB_PREFIX. "shoppro_products SET 
                            count_downloads=count_downloads+1 
                        WHERE id='".addslashes($idproduct)."' LIMIT 1";
                        $res = OW::getDbo()->query($query);
//echo $query;exit;
                        $file="file_".date('Y-m-d_H-m-s').".".$ext;
                        header("Cache-Control: public");
                        header("Content-Description: File Transfer");
                        header("Content-Disposition: attachment; filename=".$file);
                        header("Content-Type: application/zip");
                        header("Content-Transfer-Encoding: binary");
                        readfile($path_file.$name_file);
                    }else{
//echo $path_file.$name_file."<br>";
//                    die('file not found1');
//                        OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'bay_error_donothavecredits'));
                        OW::getFeedback()->error('File not found');
                        OW::getApplication()->redirect($curent_url."shop");
                    }

                }else{
                        OW::getFeedback()->error('File not found');
                        OW::getApplication()->redirect($curent_url."shop");
                }
                exit;
            }else{
//                        OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'bay_error_donothavecredits'));
                OW::getFeedback()->error('File not found');
                OW::getApplication()->redirect($curent_url."shop");
            }
        }else if ((($params['optionadm']=="edit" AND $params['idcat']>0) OR ($params['optionadm']=="add" AND $params['idcat']=="new")) AND $is_admin AND $id_user>0){//edit dir
            $this->editcat($params);
        }else if ($params['optionadm']=="del" AND $params['idcat']>0 AND $is_admin AND $id_user>0){//del dir
//echo "sss";exit;
            $this->delcat($params);
//        }else if (($params['options']=="edit" AND $params['idproduct']>0) OR ($params['options']=="add" AND $params['idproduct']==0)  AND $id_user>0 AND $is_admin){//edit form
        }else if (
        (($params['options']=="edit" AND $params['idproduct']>0) OR ($params['options']=="add" AND $params['idproduct']==0))  AND 
        (($id_user>0 AND OW::getConfig()->getValue('shoppro', 'mode_membercanshell')==1) OR $is_admin) ){//edit form
            //$this->editpage($params);
//print_r($params);exit;
            $this->assign('content', SHOPPRO_BOL_Service::getInstance()->editpage($params));
        }else if ($params['options']=="zoom"){
            $this->zoom_product($params);
        }else if ($params['option']=="showbasket"){//each users
            $this->show_basket($params);
//            echo "BASKET..";
//        }else if ($params['option']=="showmyitems"){//show may items
//            $this->show_myitems($params);
//            echo "My items..";
        }else if ($params['option']=="showorder"){//admin
            $this->show_order($params);
//            echo "ORDERS..";
        }else{//-----------------------------------------zoom end
//print_r($params);
//print_r($_POST);
//exit;           
            if (($params['options']=="edit" OR $params['options']=="add")  AND !$id_user){
                OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'you_must_first_login'));
                OW::getApplication()->redirect($curent_url."sign-in?back-uri=shop");
                exit;
            }

//id    sort    active  name
//Array ( [caction] => update [cactionid] => 3 [ctitle] => Household goods [cactive] => 1 [submit] => Submit )

//Array ( [caction] => insert [ctitle] => aaa [cactive] => 1 [csort] => 0 [submit] => Submit )
if (!isset($_POST['caction'])) $_POST['caction']=""; 
            if (( ($_POST['caction']=="update" AND $_POST['cactionid']>0) OR $_POST['caction']=="insert") AND $id_user>0 AND $is_admin){//save cat
                    $active=$_POST['cactive'];
                    if (!$active) $active=0;
                    $name=$_POST['ctitle'];
                    $sort=$_POST['csort'];
                    if (!$sort) $sort=0;
                if ($_POST['caction']=="update"){

                    $query = "UPDATE " . OW_DB_PREFIX. "shoppro_categories SET 
                        active='".addslashes($active)."',
                        name='".addslashes($name)."',
                        sort='".addslashes($sort)."' 
                    WHERE id='".addslashes($_POST['cactionid'])."' LIMIT 1";
                    $res = OW::getDbo()->query($query);
                }else{
                            $query = "INSERT INTO " . OW_DB_PREFIX. "shoppro_categories (
                                id ,   sort  ,  active , name
                            )VALUES(
                                '','".addslashes($sort)."','".addslashes($active)."','".addslashes($name)."'
                            )";
                            $res = OW::getDbo()->insert($query);
                }
                OW::getApplication()->redirect($curent_url."shop");
            }
 
//            if (($params['options']=="editu" AND $params['idproduct']>0)OR ($params['options']=="edits" AND $params['idproduct']>0) OR ($params['options']=="adds" AND $params['idproduct']==0)  AND $id_user>0 AND $is_admin){//save
            if (
                (($params['options']=="editu" AND $params['idproduct']>0)OR ($params['options']=="edits" AND $params['idproduct']>0) OR ($params['options']=="adds" AND $params['idproduct']==0))  
                AND 
                (($id_user>0 AND OW::getConfig()->getValue('shoppro', 'mode_membercanshell')==1) OR $is_admin)
                ){//save
//print_r($_POST);exit;            
//print_r($_GET);
                $group_id=0;
                $cat_id=0;
                $pcat_arr=$_POST['pcat'];
                list($group_id,$cat_id)=explode("_",$pcat_arr);
                
                if (!$cat_id) $cat_id=0;

                $padstype=$_POST['padstype'];
                if (!$padstype) $padstype=0;


        $pcondition=$_POST['pcondition'];
        if (!$pcondition) $pcondition=0;
        $pclassifieds_type=$_POST['pclassifieds_type'];
        if (!$pclassifieds_type) $pclassifieds_type=0;
        $plocation=$_POST['plocation'];
        if (!$plocation) $plocation=" NULL ";
            else $plocation=" '".addslashes($plocation)."' ";

        $map_lat=$_POST['map_lat'];
        if (!$map_lat) $map_lat="";
        $map_lan=$_POST['map_lan'];
        if (!$map_lan) $map_lan="";

//---------------------------options NEW strat 1 - for update. below is for insert
    $fount_options=0;
    if (isset($_POST['f_price_type']) AND $_POST['f_price_type']=="option"){
//        if (isset($_POST['fopid_new']) AND $params['idproduct']>0){
        if (isset($_POST['fopid_new']) AND count($_POST['fopid_new'])>0){
            $cid_product=$params['idproduct'];
            $op_arr=$_POST['fopid_new'];            
//            for ($i=0;$i<count($op_arr);$i++){

//            $sql="DELETE FROM " . OW_DB_PREFIX. "shoppro_products_options WHERE id_product='".addslashes($cid_product)."' ";
//            OW::getDbo()->query($sql);

$addspr="";
if (!$is_admin){
    $addspr=" AND id_owner='".addslashes($id_user)."' ";
}
            for ($i=0;$i<10;$i++){
                if (isset($op_arr[$i]) AND $op_arr[$i]!="") $cid=$op_arr[$i];
                    else $cid=0;
//echo $cid."--";
                if ($cid!="" AND isset($_POST['fop_name_new'][$cid]) AND strlen($_POST['fop_name_new'][$cid])>1){
                    $n_name=$_POST['fop_name_new'][$cid];

                    if (isset($_POST['fop_price_new'][$cid])) $n_price=$_POST['fop_price_new'][$cid];
                        else $n_price=0;
                    $n_price=str_replace(",",".",$n_price);
                    if (!$n_price) $n_price=0;

                    if (isset($_POST['fop_items_new'][$cid]) AND $_POST['fop_items_new'][$cid]>0) $n_quty=$_POST['fop_items_new'][$cid];
                        else $n_quty=0;
                    if (isset($_POST['fop_unlimited_new'][$cid]) AND $_POST['fop_unlimited_new'][$cid]==1) $n_unlimited=1;
                        else $n_unlimited=0;
                    if (isset($_POST['fop_sort_new'][$cid]) AND $_POST['fop_sort_new'][$cid]>0) $n_sort=$_POST['fop_sort_new'][$cid];
                        else $n_sort=0;
                    if (isset($_POST['fop_currence_new'][$cid]) ) $n_currency=$_POST['fop_currence_new'][$cid];
                        else $n_currency="USD";
                    if (isset($_POST['fop_active_new'][$cid]) AND $_POST['fop_active_new'][$cid]==1) $n_active=1;
                        else $n_active=0;
                    $n_active=1;

                    $sql="INSERT INTO " . OW_DB_PREFIX. "shoppro_products_options (
                        id,     id_product,id_owner,    order_prod,name,
                        price, currence, items,unlimited,active
                    )VALUES(
                        '','".addslashes($cid_product)."','".addslashes($id_user)."','".addslashes($n_sort)."','".addslashes($n_name)."',
                        '".addslashes($n_price)."','".addslashes($n_currency)."','".addslashes($n_quty)."','".addslashes($n_unlimited)."','".addslashes($n_active)."'
                    )";
//print_r($_POST);
//echo $sql;exit;
//echo $sql."<hr>";
                    OW::getDbo()->insert($sql);


                    $fount_options++;
                }//if is name
            }
//exit;
        }//if fopid_new
//------------------------------------for update 1


        if (isset($_POST['fopid']) AND $params['idproduct']>0){
            $cid_product=$params['idproduct'];
            $op_arr=$_POST['fopid'];            

//            $sql="DELETE FROM " . OW_DB_PREFIX. "shoppro_products_options WHERE id_product='".addslashes($cid_product)."' ";
//            OW::getDbo()->query($sql);
$addspr="";
if (!$is_admin){
    $addspr=" AND id_owner='".addslashes($id_user)."' ";
}
            for ($i=0;$i<10;$i++){
                if (isset($op_arr[$i]) AND $op_arr[$i]>0) $cid=$op_arr[$i];
                    else $cid=0;
                if ($cid>0 AND isset($_POST['fop_name'][$cid]) AND strlen($_POST['fop_name'][$cid])>1){
                    $n_name=$_POST['fop_name'][$cid];
                    if (isset($_POST['fop_price'][$cid])) $n_price=$_POST['fop_price'][$cid];
                        else $n_price=0;
                    $n_price=str_replace(",",".",$n_price);
                    if (!$n_price) $n_price=0;
                    if (isset($_POST['fop_items'][$cid]) AND $_POST['fop_items'][$cid]>0) $n_quty=$_POST['fop_items'][$cid];
                        else $n_quty=0;
                    if (isset($_POST['fop_unlimited'][$cid]) AND $_POST['fop_unlimited'][$cid]==1) $n_unlimited=1;
                        else $n_unlimited=0;
                    if (isset($_POST['fop_sort'][$cid]) AND $_POST['fop_sort'][$cid]>0) $n_sort=$_POST['fop_sort'][$cid];
                        else $n_sort=0;
                    if (isset($_POST['fop_currence'][$cid]) ) $n_currency=$_POST['fop_currence'][$cid];
                        else $n_currency="USD";
                    if (isset($_POST['fop_active'][$cid]) AND $_POST['fop_active'][$cid]==1) $n_active=1;
                        else $n_active=0;
                    $n_active=1;

                    $sql="UPDATE " . OW_DB_PREFIX. "shoppro_products_options SET 
                        order_prod='".addslashes($n_sort)."',
                        name='".addslashes($n_name)."',
                        price='".addslashes($n_price)."', 
                        currence='".addslashes($n_currency)."', 
                        items='".addslashes($n_quty)."',
                        unlimited='".addslashes($n_unlimited)."',
                        active='".addslashes($n_active)."'
                    WHERE id='".addslashes($cid)."' ".$addspr." LIMIT 1";
//echo $sql."<hr>";
                    OW::getDbo()->query($sql);


                    $fount_options++;
                }else if ($cid>0){//if is name
//                    $sql="DELETE FROM " . OW_DB_PREFIX. "shoppro_products_options WHERE id_product='".addslashes($cid_product)."' AND id='".addslashes($cid)."' LIMIT 1";
                    $sql="DELETE FROM " . OW_DB_PREFIX. "shoppro_products_options WHERE id='".addslashes($cid)."' ".$addspr." LIMIT 1";
//echo $sql."<hr>";
                    OW::getDbo()->query($sql);
                }
            }
//exit;
        }//if fopid_new
    }else{//if (isset($_POST['f_price_type']) AND $_POST['f_price_type']=="option"){
        if ($params['idproduct']>0){
            $cid_product=$params['idproduct'];
$addspr="";
if (!$is_admin){
    $addspr=" AND id_owner='".addslashes($id_user)."' ";
}
            $sql="DELETE FROM " . OW_DB_PREFIX. "shoppro_products_options WHERE id_product='".addslashes($cid_product)."' ".$addspr." ";
            OW::getDbo()->query($sql);
        }
    }


//print_r($_POST);exit;
//---------------------------options NEW end




                $pthowlong="";
                
                if (isset($_POST['pthowlong'])) {
                    $pthowlong=$_POST['pthowlong'];
                }
                if (!$pthowlong OR ($pthowlong!=7 AND $pthowlong!=14 AND $pthowlong!=30 AND $pthowlong!=60 AND $pthowlong!=360)) $pthowlong=14;

                $timestamp=strtotime(date('Y-m-d H:i:s'));
$timeStamp=$timestamp;
                $todate_timestamp=$timestamp+($pthowlong*24*60*60);//24 hours=(60 * 60 * 24);
//if (OW::getConfig()->getValue('shoppro', 'mode_ads_approval') AND !$is_admin){
if (OW::getConfig()->getValue('shoppro', 'mode_ads_approval') AND !$is_admin){
    $add_approved=0;
//active
}else{
    $add_approved=1;
}

                
                $name=$_POST['ptitle'];
//                $name=str_replace("/","_",$name);
//                $name=str_replace("\\","_",$name);
                $name=mb_substr($name,0,255);

//---points update start
$update_point="";
$add_pointsa="";
$add_pointsb="";
$is_points=SHOPPRO_BOL_Service::getInstance()->isplugin('usercredits');
if (!OW::getConfig()->getValue('shoppro', 'mode_membercanpromotion')){
    $is_points=false;
}
$pbay_promotion="";
if (isset($_POST['pbay_promotion'])){
    $pbay_promotion=$_POST['pbay_promotion'];
}
//echo $is_points."--".$pbay_promotion;


$true_for_costsale=false;
$true_for_costsale_debituser=false;
$cost_for_sale=OW::getConfig()->getValue('shoppro', 'mode_membermastpaybyseling');
if ($cost_for_sale>0 AND $is_points AND $id_user>0 AND $params['options']!="editu" AND !$params['idproduct']>0){
    $query = "SELECT * FROM " . OW_DB_PREFIX. "usercredits_balance WHERE userId='".addslashes($id_user)."' LIMIT 1";
    $arrp = OW::getDbo()->queryForList($query);
    $valuep=$arrp[0];
    if ($valuep['balance']>=$cost_for_sale){
        if (isset($_POST['debit']) AND $_POST['debit']=="YES_".substr(session_id(),6,3)){
//            $query = "UPDATE " . OW_DB_PREFIX. "usercredits_balance SET balance=balance-".addslashes($pbay_promotion)." WHERE userId='".addslashes($id_user)."' LIMIT 1";
//            OW::getDbo()->query($query);
            $true_for_costsale_debituser=true;
            $true_for_costsale=true;
        }else{          
            $true_for_costsale=false;
        }
    }else{
        $true_for_costsale=false;
    }

//    $cost_for_sale=OW::getConfig()->getValue('shoppro', 'mode_membermastpaybyseling');
//    $content .="<input type=\"checkbox\" name=\"debit\" value=\"YES_".substr(session_id(),6,3)."\" />&nbsp;";
//    if ($cost_for_sale>0){
}else{
    $true_for_costsale=true;
}

//echo $true_for_costsale;exit;

if ($is_points AND $id_user>0 AND $pbay_promotion>0){

                    $query = "SELECT * FROM " . OW_DB_PREFIX. "usercredits_balance WHERE userId='".addslashes($id_user)."' LIMIT 1";
                    $arrp = OW::getDbo()->queryForList($query);
                    $valuep=$arrp[0];
                    if ($pbay_promotion>$valuep['balance']) $pbay_promotion=$valuep['balance'];
                    $update_point="sortt='".addslashes($pbay_promotion)."', ";
                    $add_pointsa=" ,sortt";
                    $add_pointsb=" ,'".addslashes($pbay_promotion)."' ";
}
//---points update end

                $price=$_POST['pprice'];
        $ppaypal_currency=$_POST['ppaypal_currency'];
                $price=str_replace(",",".",$price);
                if (isset($_POST['pdesc'])) $description=$_POST['pdesc'];
                    else $description="";
                $description=str_replace("'","\"",$description);

$pitems=$_POST['pitems'];
if (!$pitems) $pitems=1;

                $id_owner=$id_user;

                $paccount=$_POST['paccount'];

//                if ($paccount==1 AND !$paccount){//if not email then 
//                    $paccount=0;
//                }
//                if (!$paccount AND ($_FILES["selfile"]["error"] OR !$_FILES["selfile"]["tmp_name"] OR !$_FILES["selfile"]["name"]) AND $padstype==1){//if not email AND type SHOP then change to classifieds mode
                if (!$paccount AND $padstype==1){//if not email AND type SHOP then change to classifieds mode
                    $padstype=0;
                }
                $path_img=SHOPPRO_BOL_Service::getInstance()->get_plugin_dir('shoppro')."images/";
                $paccount_csc="";
                if (isset($_POST['paccount_csc'])){
                    $paccount_csc=$_POST['paccount_csc'];
                }
                if (!$paccount) $paccount=" NULL ";
                    else $paccount="'".addslashes($paccount)."'";
                if (!$paccount_csc) $paccount_csc=" NULL ";
                    else $paccount_csc="'".addslashes($paccount_csc)."'";

                if (isset($_POST['delimg']) AND $_POST['delimg']==1 AND $params['idproduct']>0){
//                    $path_img="./ow_userfiles/plugins/shoppro/images/";
                    $name_img="product_".$params['idproduct'].".jpg";
                    if (is_file($path_img.$name_img)){
                        unlink($path_img.$name_img);
                    }
                }

                for ($i=2;$i<11;$i++){
                    if (isset($_POST['delimg'.$i]) AND $_POST['delimg'.$i]==1 AND $params['idproduct']>0){
//                        $path_img="./ow_userfiles/plugins/shoppro/images/";
                        $name_img="product_".$params['idproduct']."_".$i.".jpg";
                        if (is_file($path_img.$name_img)){
                            unlink($path_img.$name_img);
                        }
                    }
                }
/*
                if ($_POST['delfile'] AND $params['idproduct']>0){
                    $path_file="./ow_userfiles/plugins/shoppro/images/";
                    $name_img="product_".$params['idproduct'].".jpg";
                    if (is_file($path_img.$name_img)){
                        unlink($path_img.$name_img);
                    }
                }
*/
                if (isset($_POST['delfile']) AND $_POST['delfile'] AND $params['idproduct']>0){
if (!$is_admin){
    $add=" AND id_owner='".addslashes($id_user)."' ";
}else{
    $add=" ";
}
                            $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($params['idproduct'])."' ".$add." LIMIT 1";
                            $arrxx = OW::getDbo()->queryForList($query);
                            $valuex=$arrxx[0];
                            if ($valuex['id']>0 AND $valuex['id']==$params['idproduct']){
                                $hash=$valuex['file_attach'];
                                $path_file=SHOPPRO_BOL_Service::getInstance()->get_plugin_dir('shoppro')."files/";
//                                $path_file="./ow_userfiles/plugins/shoppro/files/";
                                $name_file="file_".$params['idproduct']."_".$hash.".pack";
                                if (is_file($path_file.$name_file)){
                                    unlink($path_file.$name_file);
                                }
                                $query = "UPDATE " . OW_DB_PREFIX. "shoppro_products SET file_attach=NULL 
                                    WHERE id='".addslashes($params['idproduct'])."' ".$add." LIMIT 1";
                                $res = OW::getDbo()->query($query);
                            }
                }//end del file attachment for download


                    if ($params['options']=="editu" AND $params['idproduct']>0){
if (!$is_admin){
    $add=" AND id_owner='".addslashes($id_user)."' ";
}else{
    $add=" ";
}

            if (OW::getConfig()->getValue('shoppro', 'admin_replace_btobr')==1 AND !OW::getPluginManager()->isPluginActive('wysiwygeditor')){
                $description=SHOPPRO_BOL_Service::getInstance()->ntobr($description);
            }
//aronupdateproduct
//echo "fsdf";exit;
if (OW::getConfig()->getValue('shoppro', 'mode_ads_approval') AND !$is_admin){
    $ads_approval=" `active`='0',  ";
}else{
//    $ads_approval=" `active`='1',  ";
}
$timestamp_up=strtotime(date('Y-m-d H:i:s'));

        if ($fount_options>0){
            $add_op="`has_options`='1',";
        }else{
            $add_op="`has_options`='0',";
        }


$add_end_date="";
if (isset($_POST['pthowlong']) AND $_POST['pthowlong']>0 AND $pthowlong>0 AND $todate_timestamp>0) {
    $add_end_date="`publish_totime`='".addslashes($pthowlong)."',`to_date`='".addslashes($todate_timestamp)."',";
}

                            $query = "UPDATE " . OW_DB_PREFIX. "shoppro_products SET 
                                `cat_id`='".addslashes($cat_id)."',
                                `name`='".addslashes($name)."',
                                `price`='".addslashes($price)."', 
".$add_end_date."
has_multilanguage='1',
    `curency`='".addslashes($ppaypal_currency)."', 
".$ads_approval."
                                `description`='".addslashes($description)."',
                                `seler_account` = ".$paccount.", 
    ".$update_point."
".$add_op."
type_ads='".addslashes($padstype)."',
                                `seler_account_csc`=".$paccount_csc." ,
`condition`='".addslashes($pcondition)."',
`classifieds_type`='".addslashes($pclassifieds_type)."',
`location`= ".$plocation.",
`map_lat`= '".addslashes($map_lat)."',
`map_lan`= '".addslashes($map_lan)."',
`items`='".addslashes($pitems)."',
`date_modyfing`='".addslashes($timestamp_up)."' 

                            WHERE id='".addslashes($params['idproduct'])."' ".$add." LIMIT 1";

                            $res = OW::getDbo()->query($query);
//print_r($_POST);exit;
//---desc multi lang start

            if ($is_admin){
                $add=" 1 ";
            }else{
                $add=" status='active' ";
            }
            $sql = "SELECT * FROM " . OW_DB_PREFIX. "base_language WHERE ".$add;
            $arr = OW::getDbo()->queryForList($sql);
            $lp=0;
            foreach ( $arr as $value )
            {
                if (isset($_POST['pdesc'.$value['id']])){
                    $ddescc=$_POST['pdesc'.$value['id']];
                }else{
                    $ddescc="";
                }
                    $sql="INSERT INTO " . OW_DB_PREFIX. "shoppro_products_description (
                        id_product_de,id_lang_de,description_de
                    )VALUES(
                        '".addslashes($params['idproduct'])."','".addslashes($value['id'])."','".addslashes($ddescc)."'
                    ) ON DUPLICATE KEY UPDATE description_de='".addslashes($ddescc)."' ";
//echo $sql;exit;
                    OW::getDbo()->insert($sql);
                
            }
//---desc multi lang end



//----------------start
//print_r($_POST);
//print_r($params);exit;
//echo $query;exit;
//updated product
                $queryp = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($params['idproduct'])."' LIMIT 1";
                $arrxxp = OW::getDbo()->queryForList($queryp);
                $valuexp=$arrxxp[0];
                if ($valuexp['id']>0 AND $valuexp['id_owner']>0){
                        SHOPPRO_BOL_Service::getInstance()->tonotyfitoallclients($params['idproduct'],$valuexp['id_owner']);
                }
//SHOPPRO_BOL_Service::getInstance()->tonotyficat($valuep2['id_owner'],$valuep2['id'],"","shop-wasbuy","shoppro+member_was_buy_item_url","shoppro",stripslashes($valuep2['name']),$curent_url."product/".$valuep2['id']."/zoom/product.html");
//----------------end


//---del update points start
if ($is_points AND $id_user>0 AND $pbay_promotion>0){
//echo "SdfsdfS";exit;
            $query = "UPDATE " . OW_DB_PREFIX. "usercredits_balance SET balance=balance-".addslashes($pbay_promotion)." WHERE userId='".addslashes($id_user)."' LIMIT 1";
            OW::getDbo()->query($query);
//---log credits strat
                                    $query = "INSERT INTO " . OW_DB_PREFIX. "usercredits_log (
                                        id ,     userId,  actionId     ,   amount , logTimestamp
                                    )VALUES(
                                        '','".addslashes($id_user)."','22','-".addslashes($pbay_promotion)."','".addslashes($timeStamp)."'
                                    )";//recive:22
                                    OW::getDbo()->insert($query);
//---log credits end



}
//---del points end

//--------wall start
                                if (OW::getConfig()->getValue('shoppro', 'publish_updateproduct_onwall')){
//                                    $action_name="Added new product to shop";
                                    $action_name=OW::getLanguage()->text('shoppro', 'config_publish_updateproduct_onwall_infotect');
                                    $title_post=$name." ".$description;
                                    $last_insert_id=$params['idproduct'];
if (!$name) $name="index";
$seo_title=$name;
$seo_title=$this->make_seo_url($seo_title,100);
                                    $url_to_ads=$curent_url."product/".$params['idproduct']."/zoom/".$seo_title.".html";
                                    $this->add_to_wall($last_insert_id,$action_name, $url_to_ads,$title_post);
                                }
//--------wall end

//echo $_FILES["imgfile"]["tmp_name"];
//----------------image upload
                                $path_img=SHOPPRO_BOL_Service::getInstance()->get_plugin_dir('shoppro')."images/";
                                if (!$_FILES["imgfile"]["error"] AND $_FILES["imgfile"]["tmp_name"]){
//                                    $path_img="./ow_userfiles/plugins/shoppro/images/";    
                                    $name_img="product_".$params['idproduct'].".jpg";
//echo $path_img.$name_img;
                                    if (!is_dir($path_img)){
                                        mkdir($path_img);
                                    }
                                    SHOPPRO_BOL_Service::getInstance()->corect_exif($_FILES["imgfile"]["tmp_name"]);//corect orienatation
                                    copy($_FILES["imgfile"]["tmp_name"],$path_img.$name_img);
//                                        SHOPPRO_BOL_Service::getInstance()->file_copy($_FILES["imgfile".$i]["tmp_name"],$path_img.$name_img);
                                    unlink($_FILES["imgfile"]["tmp_name"]);
                                }

                                for ($i=2;$i<11;$i++){
                                    if (!$_FILES["imgfile".$i]["error"] AND $_FILES["imgfile".$i]["tmp_name"]){
//                                        $path_img="./ow_userfiles/plugins/shoppro/images/";
                                        $name_img="product_".$params['idproduct']."_".$i.".jpg";
                                        if (!is_dir($path_img)){
                                            mkdir($path_img);
                                        }
                                        SHOPPRO_BOL_Service::getInstance()->corect_exif($_FILES["imgfile".$i]["tmp_name"]);//corect orienatation
                                        copy($_FILES["imgfile".$i]["tmp_name"],$path_img.$name_img);
//                                        SHOPPRO_BOL_Service::getInstance()->file_copy($_FILES["imgfile".$i]["tmp_name"],$path_img.$name_img);
                                        unlink($_FILES["imgfile".$i]["tmp_name"]);
                                    }
                                }


//----------------file upload

                                if (!$_FILES["selfile"]["error"] AND $_FILES["selfile"]["tmp_name"] AND $_FILES["selfile"]["name"]){
//--get old tsrat
$file_to_download="";
$hash_to_download="";
                            if ($params['idproduct']>0){
                                if (!$is_admin){
                                    $add=" AND id_owner='".addslashes($id_user)."' ";
                                }else{
                                    $add=" ";
                                }
                                $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($params['idproduct'])."' ".$add." LIMIT 1";
                                $arrxx = OW::getDbo()->queryForList($query);
                                $valuex=$arrxx[0];
                                if ($valuex['id']>0 AND $valuex['id']==$params['idproduct']){
                                    $hash=$valuex['file_attach'];
//                                    $path_file="./ow_userfiles/plugins/shoppro/files/";
                                    $path_file=SHOPPRO_BOL_Service::getInstance()->get_plugin_dir('shoppro')."files/";
                                    $name_file="file_".$params['idproduct']."_".$hash.".pack";
                                    if (is_file($path_file.$name_file)){
                                        $file_to_download=$name_file;
                                        $hash_to_download=$hash;
                                    }
                                }
                            }
//--get ole end


                                    $ext=substr($_FILES["selfile"]["name"], -3);
//                                    $ext="jpg";
//                                    $path_img="./ow_userfiles/plugins/shoppro/files/";
                                    $path_img=SHOPPRO_BOL_Service::getInstance()->get_plugin_dir('shoppro')."files/";

                                    if (strlen($file_to_download)>5 AND $hash_to_download){
                                        $hash=$hash_to_download;
                                        $name_img=$file_to_download;
                                    }else{
                                        $hash=md5(date('Y-m-d H:i:s')).".".$ext;
                                        $name_img="file_".$params['idproduct']."_".$hash.".pack";
                                    }
//echo $path_img.$name_img;
//                                    if (!is_dir("./ow_userfiles/plugins/shoppro/files/")){
//                                        mkdir("./ow_userfiles/plugins/shoppro/files/");
//                                    }
                                    if (is_file($path_img.$name_img)){
                                        unlink($path_img.$name_img);
                                    }
                                    if (copy($_FILES["selfile"]["tmp_name"],$path_img.$name_img)){
                                            $query = "UPDATE " . OW_DB_PREFIX. "shoppro_products SET 
                                                file_attach='".addslashes($hash)."' 
                                            WHERE id='".addslashes($params['idproduct'])."' ".$add." LIMIT 1";
                                            $res = OW::getDbo()->query($query);
                                    }
                                    unlink($_FILES["selfile"]["tmp_name"]);
                                }


//------------------end file





                    }else if ($true_for_costsale==true){
$timestamp_up=strtotime(date('Y-m-d H:i:s'));
        if ($fount_options>0){
            $add_op_n="`has_options`,";
            $add_op_v="'1',";
        }else{
            $add_op_n="`has_options`,";
            $add_op_v="'0',";
        }
                            $query = "INSERT INTO " . OW_DB_PREFIX. "shoppro_products (
                                `id`, `cat_id`, `id_owner`,`name`, `price`, `curency`,`active`, `description`, `seler_account`, `seler_account_csc` ".$add_pointsa." 
                                ,`publish_totime`,`to_date`,
                                `type_ads`,
                                `condition`,`classifieds_type`,`location`,
map_lat,map_lan,
                                `items`,
`date_modyfing`,
has_multilanguage,
".$add_op_n."
`date_add` 
                            )VALUES(
                                '','".addslashes($cat_id)."','".addslashes($id_owner)."','".addslashes($name)."','".addslashes($price)."','".addslashes($ppaypal_currency)."','".addslashes($add_approved)."','".addslashes($description)."',".$paccount.",".$paccount_csc." ".$add_pointsb." 
                                ,'".addslashes($pthowlong)."','".addslashes($todate_timestamp)."',
                                '".addslashes($padstype)."',
                                '".addslashes($pcondition)."','".addslashes($pclassifieds_type)."', ".$plocation.",
'".addslashes($map_lat)."','".addslashes($map_lan)."',
                                '".addslashes($pitems)."',
'".addslashes($timestamp_up)."',
'1',
".$add_op_v."
'".addslashes($timestamp_up)."' 
                            )";
                            //WHERE active='1' ORDER BY name";
                            $last_insert_id_ac = OW::getDbo()->insert($query);

                            if ($last_insert_id_ac>0){

//---desc multi lang start

            if ($is_admin){
                $add=" 1 ";
            }else{
                $add=" status='active' ";
            }
            $sql = "SELECT * FROM " . OW_DB_PREFIX. "base_language WHERE ".$add;
            $arr = OW::getDbo()->queryForList($sql);
            $lp=0;
            foreach ( $arr as $value )
            {
                if (isset($_POST['pdesc'.$value['id']])){
                    $ddescc=$_POST['pdesc'.$value['id']];
                }else{
                    $ddescc="";
                }
                    $sql="INSERT INTO " . OW_DB_PREFIX. "shoppro_products_description (
                        id_product_de,id_lang_de,description_de
                    )VALUES(
                        '".addslashes($last_insert_id_ac)."','".addslashes($value['id'])."','".addslashes($ddescc)."'
                    ) ON DUPLICATE KEY UPDATE description_de='".addslashes($ddescc)."' ";
                    OW::getDbo()->insert($sql);
                
            }
//---desc multi lang end



//---------------------------options NEW strat 2 - for insert onlye. for update is abow
    $fount_options=0;
    if (isset($_POST['f_price_type']) AND $_POST['f_price_type']=="option"){
        if (isset($_POST['fopid_new']) AND count($_POST['fopid_new'])>0 AND $last_insert_id_ac>0){
            $cid_product=$last_insert_id_ac;
            $op_arr=$_POST['fopid_new'];            
//print_r($op_arr);


            $addspr="";
            if (!$is_admin){
                $addspr=" AND id_owner='".addslashes($id_user)."' ";
            }

            for ($i=0;$i<10;$i++){
                if (isset($op_arr[$i]) AND $op_arr[$i]!="") $cid=$op_arr[$i];
                    else $cid=0;
//echo $cid."--";
                if ($cid!="" AND isset($_POST['fop_name_new'][$cid]) AND strlen($_POST['fop_name_new'][$cid])>1){
                    $n_name=$_POST['fop_name_new'][$cid];

                    if (isset($_POST['fop_price_new'][$cid])) $n_price=$_POST['fop_price_new'][$cid];
                        else $n_price=0;
                    $n_price=str_replace(",",".",$n_price);
                    if (!$n_price) $n_price=0;

                    if (isset($_POST['fop_items_new'][$cid]) AND $_POST['fop_items_new'][$cid]>0) $n_quty=$_POST['fop_items_new'][$cid];
                        else $n_quty=0;
                    if (isset($_POST['fop_unlimited_new'][$cid]) AND $_POST['fop_unlimited_new'][$cid]==1) $n_unlimited=1;
                        else $n_unlimited=0;
                    if (isset($_POST['fop_sort_new'][$cid]) AND $_POST['fop_sort_new'][$cid]>0) $n_sort=$_POST['fop_sort_new'][$cid];
                        else $n_sort=0;
                    if (isset($_POST['fop_currence_new'][$cid]) ) $n_currency=$_POST['fop_currence_new'][$cid];
                        else $n_currency="USD";
                    if (isset($_POST['fop_active_new'][$cid]) AND $_POST['fop_active_new'][$cid]==1) $n_active=1;
                        else $n_active=0;
                    $n_active=1;

                    $sql="INSERT INTO " . OW_DB_PREFIX. "shoppro_products_options (
                        id,     id_product,id_owner,    order_prod,name,
                        price, currence, items,unlimited,active
                    )VALUES(
                        '','".addslashes($cid_product)."','".addslashes($id_user)."','".addslashes($n_sort)."','".addslashes($n_name)."',
                        '".addslashes($n_price)."','".addslashes($n_currency)."','".addslashes($n_quty)."','".addslashes($n_unlimited)."','".addslashes($n_active)."'
                    )";
//print_r($_POST);
//echo $sql;exit;
//echo $sql."<hr>";
                    OW::getDbo()->insert($sql);
                    $fount_options++;
                }//if is name
            }
//exit;
        }//if fopid_new
    }
//print_r($_POST);exit;
//------------------------------------for update 2




//---del points
if ($true_for_costsale_debituser==true){
//echo "sdfsdf";exit;
    $query = "UPDATE " . OW_DB_PREFIX. "usercredits_balance SET balance=balance-".addslashes($cost_for_sale)." WHERE userId='".addslashes($id_user)."' LIMIT 1";
    OW::getDbo()->query($query);

//---log credits strat
                                    $query = "INSERT INTO " . OW_DB_PREFIX. "usercredits_log (
                                        id ,     userId,  actionId     ,   amount , logTimestamp
                                    )VALUES(
                                        '','".addslashes($id_user)."','22','-".addslashes($cost_for_sale)."','".addslashes($timeStamp)."'
                                    )";//send:22
                                    OW::getDbo()->insert($query);
//---log credits end


}
//---del add new points start
if ($is_points AND $id_user>0 AND $pbay_promotion>0){
//echo "sfsdf";exit;
    $query = "UPDATE " . OW_DB_PREFIX. "usercredits_balance SET balance=balance-".addslashes($pbay_promotion)." WHERE userId='".addslashes($id_user)."' LIMIT 1";
    OW::getDbo()->query($query);
//---log credits strat
                                    $query = "INSERT INTO " . OW_DB_PREFIX. "usercredits_log (
                                        id ,     userId,  actionId     ,   amount , logTimestamp
                                    )VALUES(
                                        '','".addslashes($id_user)."','22','-".addslashes($pbay_promotion)."','".addslashes($timeStamp)."'
                                    )";//send:22
                                    OW::getDbo()->insert($query);
//---log credits end

}
//---del points end




//--------wall start
                                if (OW::getConfig()->getValue('shoppro', 'publish_newproduct_onwall')){
                                    $action_name=OW::getLanguage()->text('shoppro', 'config_publish_newproduct_onwall_infotect');
                                    $title_post=$name." ".$description;
                                    $last_insert_id=$last_insert_id_ac;
if (!$name) $name="index";
$seo_title=$name;
$seo_title=$this->make_seo_url($seo_title,100);
                                    $url_to_ads=$curent_url."product/".$last_insert_id."/zoom/".$seo_title.".html";
                                    $this->add_to_wall($last_insert_id,$action_name, $url_to_ads,$title_post);
                                }
//--------wall end



//$upload_true=FANPAGE_BOL_Service::getInstance()->image_copy_resize($_FILES['f_header_'.$id_user.'_default_file']['tmp_name'],FANPAGE_BOL_Service::getInstance()->get_plugin_dir('fanpage')."header_".$id_user."_default.jpg",false,1024,400);
//                                FANPAGE_BOL_Service::getInstance()->file_delete(FANPAGE_BOL_Service::getInstance()->get_plugin_dir('fanpage')."header_".$id_user."_default.jpg");

//----------------image upload
                                $path_img=SHOPPRO_BOL_Service::getInstance()->get_plugin_dir('shoppro')."images/";
                                if (!$_FILES["imgfile"]["error"] AND $_FILES["imgfile"]["tmp_name"]){
//                                    $path_img="./ow_userfiles/plugins/shoppro/images/";
                                    $name_img="product_".$last_insert_id_ac.".jpg";
                                    if (!is_dir($path_img)){
                                        mkdir($path_img);
                                    }
//                                    if (!is_dir("./ow_userfiles/plugins/shoppro/images/")){
//                                        mkdir("./ow_userfiles/plugins/shoppro/images/");
//                                    }
                                    SHOPPRO_BOL_Service::getInstance()->corect_exif($_FILES["imgfile"]["tmp_name"]);//corect orienatation
                                    copy($_FILES["imgfile"]["tmp_name"],$path_img.$name_img);
//                                    SHOPPRO_BOL_Service::getInstance()->file_copy($_FILES["imgfile".$i]["tmp_name"],$path_img.$name_img);
                                    unlink($_FILES["imgfile"]["tmp_name"]);
                                }

                                for ($i=2;$i<11;$i++){
                                    if (!$_FILES["imgfile".$i]["error"] AND $_FILES["imgfile".$i]["tmp_name"]){
//                                        $path_img="./ow_userfiles/plugins/shoppro/images/";
                                        $name_img="product_".$last_insert_id_ac."_".$i.".jpg";
                                        if (!is_dir($path_img)){
                                            mkdir($path_img);
                                        }
                                        if (is_file($path_img.$name_img)){
                                            SHOPPRO_BOL_Service::getInstance()->file_delete($path_img.$name_img);
                                        }
//                                        copy($_FILES["imgfile".$i]["tmp_name"],$path_img.$name_img);
                                            SHOPPRO_BOL_Service::getInstance()->corect_exif($_FILES["imgfile".$i]["tmp_name"]);//corect orienatation
                                        SHOPPRO_BOL_Service::getInstance()->file_copy($_FILES["imgfile".$i]["tmp_name"],$path_img.$name_img);
                                        unlink($_FILES["imgfile".$i]["tmp_name"]);
                                    }
                                }
//----------------file upload
                                if (!$_FILES["selfile"]["error"] AND $_FILES["selfile"]["tmp_name"]){
                                    $path_img=SHOPPRO_BOL_Service::getInstance()->get_plugin_dir('shoppro')."files/";

                                    $ext=substr($_FILES["selfile"]["name"], -3);
                                    $hash=md5(date('Y-m-d H:i:s')).".".$ext;
//                                    $path_img="./ow_userfiles/plugins/shoppro/files/";
                                    $name_img="file_".$last_insert_id_ac."_".$hash.".pack";

//echo $path_img.$name_img;
//                                    if (!is_dir("./ow_userfiles/plugins/shoppro/")){
//                                        mkdir("./ow_userfiles/plugins/shoppro/");
//                                    }
                                    if (!is_dir($path_img)){
                                        mkdir($path_img);
                                    }
                                    if (is_file($path_img.$name_img)){
                                        unlink($path_img.$name_img);
                                    }

//                                    if (copy($_FILES["selfile"]["tmp_name"],$path_img.$name_img)){
//                                        SHOPPRO_BOL_Service::getInstance()->corect_exif($_FILES["imgfile".$i]["tmp_name"]);//corect orienatation
                                    if (SHOPPRO_BOL_Service::getInstance()->file_copy($_FILES["selfile"]["tmp_name"],$path_img.$name_img)){
                                        $query = "UPDATE " . OW_DB_PREFIX. "shoppro_products SET 
                                            file_attach='".addslashes($hash)."' 
                                        WHERE id='".addslashes($last_insert_id_ac)."' LIMIT 1";
                                        $res = OW::getDbo()->query($query);
                                    }
                                    unlink($_FILES["selfile"]["tmp_name"]);
                                }
//------------------end file
                            }

                    }//end update
//                echo "SAVE TODO...";


//echo $params['idproduct'];
//print_r($_POST);
//exit;








//                OW::getApplication()->redirect($curent_url."shop");
                if (isset($_POST['wtype']) AND $_POST['wtype']=="form_mobi"){
                    OW::getApplication()->redirect($curent_url."mobile/v2/option/shop");
                }else{
                    OW::getApplication()->redirect($curent_url."shopmy/show");
                }
                exit;
            }





            if ($params['options']=="del" AND $params['idproduct']>0 AND 
                (($id_user>0 AND OW::getConfig()->getValue('shoppro', 'mode_membercanshell')==1) OR $is_admin)
                ){

                        SHOPPRO_BOL_Service::getInstance()->delete_product($params,"shop");
//                    form_mobi
/*
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

                            }
                        //----------------------------delete comments
                            


//                echo "DELETE TODO...";

                if (isset($_POST['wtype']) AND $_POST['wtype']=="form_mobi"){
                    OW::getApplication()->redirect($curent_url."mobile/v2/option/shop");
                    exit;
                }
*/
            }
            
//=========================================================================================================================================================================================
//=========================================================================================================================================================================================
//=========================================================================================================================================================================================
            $this->setPageTitle(OW::getLanguage()->text('shoppro', 'index_page_title')); //title menu
            $this->setPageHeading(OW::getLanguage()->text('shoppro', 'index_page_heading')); //title page


//        $this->doPay("2.2","terowy produkt 1","Opis produktu",1);


                    $products ="";
$add_where="";
//$add_where="";
//print_r($params);
//print_r($_GET);

$approval=" pr.active='1' ";
if (isset($params['option']) AND ($params['option']=="approval"  OR (isset($_GET['approval']) AND $_GET['approval']=="only"))AND $is_admin){
    if ($is_admin AND OW::getConfig()->getValue('shoppro', 'mode_ads_approval')){
        $approval=" pr.active='0' ";
    }
}
//$approval="";
                    $myitems_add="";
                    if ($params['optmy']=="show" OR (isset($_GET['my']) AND $_GET['my']=="show")){
                        if (!$id_user){
                            $curent_full_url=$_SERVER["REQUEST_URI"];
//                            OW::getApplication()->redirect($curent_url."sign-in?back-uri=".urlencode($curent_full_url));
                            OW::getApplication()->redirect($curent_url."sign-in?back-uri=".$curent_full_url);
                        }
//                        $myitems_add=" id_owner='".addslashes($id_user)."' AND ";
                        $myitems_add=" pr.id_owner='".addslashes($id_user)."' ";
            $approval="";
                    }

if ($approval){
    if ($add_where) $add_where .=" AND ";
    $add_where .=$approval;
}
if ($myitems_add){
    if ($add_where) $add_where .=" AND ";
    $add_where .=$myitems_add;
}

$idcat=0;
if ($params['idcat']>0 OR (isset($_GET['cat']) AND $_GET['cat']>0) ){
    if ($params['idcat']>0) $idcat=$params['idcat'];
    else $idcat=$_GET['cat'];

    if ($idcat>0){
        if ($add_where) $add_where .=" AND ";
        $add_where .=" (pr.cat_id='".addslashes($idcat)."') ";
    }
}

$is_points=SHOPPRO_BOL_Service::getInstance()->isplugin('usercredits');
if (!$is_points AND !$is_admin){
    if ($id_user>0){
        if ($add_where) $add_where .=" AND ";
        $add_where .=" (pr.type_ads!='2' OR pr.id_owner='".addslashes($id_user)."') ";
    }else{
        if ($add_where) $add_where .=" AND ";
        $add_where .=" (pr.type_ads!='2') ";
    }
}


if (!$is_admin){
    if ($add_where) $add_where .=" AND ";
    $add_where .=" (pr.items>0 OR pr.id_owner='".addslashes($id_user)."') ";
}

if (!$add_where) $add_where =" pr.id>'0' ";

//ukryj wygasle
    $timestampP=strtotime(date('Y-m-d H:i:s'));
//    $add_where .=" (pr.to_date='0' OR pr.to_date IS NULL OR pr.to_date>='".addslashes($timestampP)."' OR pr.id_owner='".addslashes($id_user)."')  ";
//    $add_where .=" (pr.to_date='0' OR pr.to_date IS NULL OR pr.to_date>='".addslashes($timestampP)."')  ";

//SHOW PR NOT OLD ARDS:-------------------------
if (OW::getConfig()->getValue('shoppro', 'hide_timeout_product')==1){
    if ($add_where) $add_where .=" AND ";
    $add_where .=" (pr.to_date='0' OR pr.to_date IS NULL OR pr.to_date>='".addslashes($timestampP)."' OR pr.publish_totime='360')  ";
}
//SHOW PR NOT OLD ARDS:-------------------------


    if ($add_where) $add_where .=" AND ";
    $add_where .=" (pr.has_options='0' OR ((po.items>'0' OR po.unlimited='1') AND po.active='1') ) ";

    



//-------------------page start A
    $perpage_max=OW::getConfig()->getValue('shoppro', 'mode_perpage');
    if (!$perpage_max OR $perpage_max==0) $perpage_max=30;
    if (isset($_GET['page'])){
        $curent_page=($_GET['page']-1);
        if (!$curent_page) $curent_page=0;
    }else{
        $curent_page=0;
    }

    $prev_page=$curent_page-1;
    if ($prev_page<0) $prev_page=0;
    $next_page=$curent_page+1;
    $add_limit=($curent_page*$perpage_max);
    if (!$add_limit) $add_limit=0;
    $pagination="";

//        $query = "SELECT COUNT(*) as allp,po.items as po_items, po.unlimited as po_unlimited, po.active as po_active   FROM " . OW_DB_PREFIX. "shoppro_products pr 
//        $query = "SELECT COUNT(*) as allp,po.items as poitems, po.unlimited as pounlimited, po.active as poactive  FROM " . OW_DB_PREFIX. "shoppro_products pr 
//            LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_options po ON (po.id_product=pr.id AND (po.items>'0' OR po.unlimited='1') AND po.active='1' )  
//        WHERE ".$add_where." GROUP BY po.id";
/*
        $query = "SELECT COUNT(*) as allp FROM " . OW_DB_PREFIX. "shoppro_products pr 
            LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_options po ON (po.id_product=pr.id AND (po.items>'0' OR po.unlimited='1') AND po.active='1' )  
        WHERE ".$add_where." ";


        $query = "SELECT COUNT(
CASE
WHEN (po.id_product=pr.id AND (po.items>'0' OR po.unlimited='1') AND po.active='1' ) THEN 1 ELSE 0 
END
            ) as allp FROM " . OW_DB_PREFIX. "shoppro_products pr 
            LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_options po ON (po.id_product=pr.id AND (po.items>'0' OR po.unlimited='1') AND po.active='1' )  
        WHERE ".$add_where." ";
*/
        $query = "SELECT pr.id as allp FROM " . OW_DB_PREFIX. "shoppro_products pr
            LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_options po ON (po.id_product=pr.id AND (po.items>'0' OR po.unlimited='1') AND po.active='1' )
        WHERE ".$add_where." GROUP BY pr.id";



//echo $query;exit;
        $arrx = OW::getDbo()->queryForList($query);
        if (isset($arrx[0])){
            $aaitem=$arrx[0];
//            $all_items=$aaitem['allp'];
            $all_items=count($arrx);
        }else{
            $all_items=0;
        }
//-------------------page end A



    $shop_order="";
//    $shop_order=" pr.sortt DESC,pr.date_modyfing DESC,pr.id DESC, pr.name ";
    if (isset($_SESSION['shoplist_order']) AND $_SESSION['shoplist_order']=="nameasc"){
        $shop_order="pr.name ASC";
    }else if (isset($_SESSION['shoplist_order']) AND $_SESSION['shoplist_order']=="namedesc"){
        $shop_order="pr.name DESC";

    }else if (isset($_SESSION['shoplist_order']) AND $_SESSION['shoplist_order']=="dataasc"){
        $shop_order="pr.date_modyfing ASC";
    }else if (isset($_SESSION['shoplist_order']) AND $_SESSION['shoplist_order']=="datadesc"){
        $shop_order="pr.date_modyfing DESC";

    }else if (isset($_SESSION['shoplist_order']) AND $_SESSION['shoplist_order']=="popasc"){
        $shop_order="pr.count_view ASC";
    }else if (isset($_SESSION['shoplist_order']) AND $_SESSION['shoplist_order']=="popdesc"){
        $shop_order="pr.count_view DESC";
    }else{

        $shop_order=" pr.sortt DESC,pr.date_modyfing DESC,pr.id DESC, pr.name ";
    }


//$query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE ".$add_where." ORDER BY sortt DESC,date_modyfing DESC,id DESC, name LIMIT ".$add_limit.",".$perpage_max;
//echo $query;exit;

//                            if ($params['idcat']>0){
//aron select multilanguage
//$curent_lang
$curent_lang_def=SHOPPRO_BOL_Service::getInstance()->get_system_lang_id();//default oxwall website language
//base_language_id=5
//print_r($_SESSION);
//print_r($_COOKIE);
//exit;

                            if ($idcat>0){
//                                $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE cat_id='".addslashes($params['idcat'])."' AND ".$add_where." ORDER BY sortt DESC,name LIMIT ".$add_limit.",".$perpage_max;
                                $query = "SELECT pr.*,prd.*,prdx.description_de as description_de_def, po.items as poitems, po.unlimited as pounlimited, po.active as poactive FROM " . OW_DB_PREFIX. "shoppro_products pr 
                                LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_description prd ON (prd.id_product_de=pr.id AND prd.id_lang_de='".addslashes($curent_lang)."')  
                LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_description prdx ON (prdx.id_product_de=pr.id AND prdx.id_lang_de='".addslashes($curent_lang_def)."')  
                                    LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_options po ON (po.id_product=pr.id AND (po.items>'0' OR po.unlimited='1') AND po.active='1' )  
                                WHERE ".$add_where." GROUP BY pr.id ORDER BY ".$shop_order." LIMIT ".$add_limit.",".$perpage_max;
                            }else{
                                $query = "SELECT pr.*,prd.*,prdx.description_de as description_de_def,po.items as poitems, po.unlimited as pounlimited, po.active as poactive FROM " . OW_DB_PREFIX. "shoppro_products pr 
                                LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_description prd ON (prd.id_product_de=pr.id AND prd.id_lang_de='".addslashes($curent_lang)."')  
                LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_description prdx ON (prdx.id_product_de=pr.id AND prdx.id_lang_de='".addslashes($curent_lang_def)."')  
                                    LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_options po ON (po.id_product=pr.id AND (po.items>'0' OR po.unlimited='1') AND po.active='1' )  
                                WHERE ".$add_where." GROUP BY pr.id ORDER BY ".$shop_order." LIMIT ".$add_limit.",".$perpage_max;
                            }
//echo $query;exit;

//                                    LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_options po ON (po.id_product=pr.id AND (po.items>0 OR po.unlimited=1) AND po.active=1 )  
//bu.username
////                                        $query = "SELECT sp.*, bu.username FROM " . OW_DB_PREFIX. "shoppro_products sp 
    //                                            LEFT JOIN " . OW_DB_PREFIX. "base_user bu ON (bu.id=sp.id_owner) 
    //                                            WHERE sp.id='".addslashes($value['id'])."' LIMIT 1";

//echo $query;exit;
//echo $query;
                            $arrx = OW::getDbo()->queryForList($query);
/*
<table class="ow_table_1 ow_stdmargin ow_forum">
    <tbody>
    <tr>
        <th class="ow_name"><span id="section-1">General</span></th>
        <th class="ow_topics">Tematy</th>
        <th class="ow_replies">Odpowiedzi</th>
        <th class="ow_author">Ostatnia Odpowiedź</th>
    </tr>
        <tr class="ow_alt1">
        <td class="ow_name">
            <a href="http://test.a6.pl/forum/1"><b>General Chat</b></a>
            <div class="ow_small">Just about anything</div>
                    </td>
        <td class="ow_topics">2</td>
        <td class="ow_replies">0</td>
        <td class="ow_txtleft ow_small">
                    <div class="ow_reply_info">
                <span class="ow_nowrap ow_icon_control ow_ic_user">
                    <a href="http://test.a6.pl/user/aron">Aron</a>
                </span> ·
                <span class="ow_nowrap ow_remark">Sie 19</span>
            </div>
            W <a href="http://test.a6.pl/forum/topic/2?page=1#post-2">topic 2a aron</a>
                </td>
    </tr>
        <tr><td colspan="3"></td></tr>
</tbody></table>
*/

                            $pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();
//                            $pluginStaticURL =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesUrl();
                            $pluginStaticURL =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesUrl();
                            //$pluginDir =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesDir();
//                            $pluginStaticDir =OW::getPluginManager()->getPlugin('shoppro')->getStaticDir();
                            $pluginStaticDir =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesDir();
//echo $pluginStaticDir;exit;
                            $curent=1;
                            $curent_revers=2;
//                            $is_items=






//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------main loop
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                            $product_grid="";



                            foreach ( $arrx as $value ) {
                                $dname=BOL_UserService::getInstance()->getDisplayName($value['id_owner']);
                                $uurl=BOL_UserService::getInstance()->getUserUrl($value['id_owner']);
                                $uimg=BOL_AvatarService::getInstance()->getAvatarUrl($value['id_owner']);

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
                                $seo_title=$this->make_seo_url($seo_title,100);
//----tems for table
                                $products .="<tr class=\"ow_alt".$curent."\" style=\"\">";

//-----avatar on products list start ------------------------------------------------------------------------------------------------------------------- start
                                if (!OW::getConfig()->getValue('shoppro', 'hide_seller_avatar_onthelist')){

                                    $products .="<td style=\"width:100px;text-align:center;\" nowrap=\"nowrap\" valign=\"top\">";
                                    $products .="<div class=\"ow_my_avatar_widget clearfix\">";
                                    if ($uimg){
                                        $products .="<div class=\"ow_alt".$curent_revers." ow_center clearfix\" style=\"text-align:center;\">";
                                        $products .=OW::getLanguage()->text('shoppro', 'product_table_seler').": ";
                                        $products .="</div>";
    
                                        $products .="<div class=\"ow_center ow_my_avatar_img clearfix\" style=\"text-align:center;margin-top:10px;\">";
                                            $products .="<div class=\"ow_avatar\">";
                                                $products .="<a href=\"".$uurl."\" style=\"display:inline-block;color:#008;font-size:14px;font-weight:bold;\">";
                                                $products .="<img src=\"".$uimg."\" title=\"".$dname."\"  >";
                                                $products .="</a>";
                                            $products .="</div>";
                                        $products .="</div>";

                                        $products .="<div class=\"ow_ipc_headerx clearfix\" style=\"text-align:center;\">";
                                            $products .="<div class=\"ow_my_avatar_cont\">
                                                <a href=\"".$uurl."\" class=\"ow_my_avatar_username\">
                                                <span>".$dname."</span>
                                                </a>
                                            </div>";
                                        $products .="</div>";

                                    }else{
                                        $products .="<div class=\"ow_alt".$curent_revers." ow_center clearfix\" style=\"text-align:center;\">";
                                        $products .=OW::getLanguage()->text('shoppro', 'product_table_seler').": ";
                                        $products .="</div>";
                                        $products .="<div class=\"ow_center ow_my_avatar_img clearfix\" style=\"text-align:center;margin-top:10px;\">";
                                            $products .="<div class=\"ow_avatar\">";
                                                $products .="<a href=\"".$uurl."\" style=\"\">";
                                                $products .="<img src=\"".$curent_url."ow_static/themes/".OW::getConfig()->getValue('base', 'selectedTheme')."/images/no-avatar.png\" title=\"".OW::getLanguage()->text('search', 'index_hasnotimage')."\"  >";
                                                $products .="</a>";
                                            $products .="</div>";
                                        $products .="</div>";
    
                                        $products .="<div class=\"ow_ipc_headerx clearfix\" style=\"text-align:center;\">";
                                            $products .="<div class=\"ow_my_avatar_cont\">
                                            <a href=\"".$uurl."\" class=\"ow_my_avatar_username\">
                                            <span>".$dname."</span>
                                            </a>
                                            </div>";
                                        $products .="</div>";
                                    }
                                    $products .="</div>";


                                    if ($value['items']<1 AND ($value['type_ads']==1 OR $value['type_ads']==2)){
                                        $products .="<div class=\"clearfix ow_red ow_center\">";
                                        $products .=OW::getLanguage()->text('shoppro', 'bay_error_item_wassaled');
                                        $products .="</div>";
                                    }



                                    if (OW::getConfig()->getValue('shoppro', 'mode_ads_approval') AND isset($params['option']) AND ($params['option']=="approval"  OR (isset($_GET['approval']) AND $_GET['approval']=="only")) AND $is_admin){



                                        $products .="<ul class=\"ow_bl clearfix ow_small ow_stdmargin ow_center\">
                                            <li>
                                            <a href=\"".$curent_url."ordershop/approval?allow=".$value['id']."_".$protectkey."\" class=\"ow_mild_green\" rel=\"nofollow\">
                                                ".OW::getLanguage()->text('shoppro', 'product_table_doapprov')."
                                            </a>
                                            </li>

                                            <li>
                                            <a href=\"".$curent_url."ordershop/approval?del=".$value['id']."_".$protectkey."\" class=\"ow_mild_red\" rel=\"nofollow\">
                                                ".OW::getLanguage()->text('shoppro', 'product_table_del')."
                                            </a>
                                            </li>
                                            </ul>";
                                    }else if (OW::getConfig()->getValue('shoppro', 'mode_ads_approval') AND $is_admin){
                                        if ($value['active']==1){
                                            $products .="<ul class=\"ow_bl clearfix ow_small ow_stdmargin ow_center\">
                                            <li>
                                            <a href=\"".$curent_url."ordershop/approval?deny=".$value['id']."_".$protectkey."\" class=\"ow_mild_red\" rel=\"nofollow\">
                                                ".OW::getLanguage()->text('shoppro', 'product_table_disapprov')."
                                            </a>
                                            </li>
                                            </ul>";
                                        }
                                    }//else


                                    if ($id_user>0 AND $value['id_owner']==$id_user AND ($params['optmy']=="show" OR (isset($_GET['my']) AND $_GET['my']=="show"))){
                                            $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;\">";
                                            if ($value['items']<1){
                                                $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
                                                $products .=OW::getLanguage()->text('shoppro', 'bay_error_item_wassaled');
                                                $products .="</div>";
                                            }else if ($value['active']==1){
                                                $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#080;\">";
                                                $products .=OW::getLanguage()->text('shoppro', 'product_table_active');
                                                $products .="</div>";
                                            }else if ($value['active']==-1){
                                                $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
                                                $products .=OW::getLanguage()->text('shoppro', 'product_table_deleted');
                                                $products .="</div>";
                                            }else{
                                                $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
                                                $products .=OW::getLanguage()->text('shoppro', 'product_table_moderation');
                                                $products .="</div>";
                                            }
                                            $products .="</div>";
                                    }

                                    $products .="</td>";

                                }//if (!OW::getConfig()->getValue('shoppro', 'hide_seller_avatar_onthelist')){
//-----avatar on products list end ------------------------------------------------------------------------------------------------------------------- end





                            $products .="<td valign=\"top\" style=\"word-wrap:break-word;width: 100%;margin: auto;\">";
                                $products .="<div id=\"product_".$value['id']."\" class=\"products_tocart clearfix\" style=\"word-wrap:break-word;margin-top:20px;\">";//============================================================== start product

                                    $products .="<div class=\"ow_alt\" clearfix\" style=\"word-wrap:break-word;margin-bottom:20px;\">";
                                        $products .="<h2 class=\"listing-header\">";
                                            $products .="<a href=\"".$curent_url."product/".$value['id']."/zoom/".$seo_title.".html\" alt=\"".stripslashes($value['name'])."\" style=\"font-weight:bold;margin:4px;\">";

                                                if (OW::getConfig()->getValue('shoppro', 'max_product_title_chars')>0){
                                                    $max_chars=OW::getConfig()->getValue('shoppro', 'max_product_title_chars');
                                                    $products .= mb_substr(stripslashes($value['name']),0,$max_chars);
                                                    if (strlen(stripslashes($value['name']))>$max_chars) $products .="...";
                                                }else{
                                                    $products .= stripslashes($value['name']);
                                                }
                                            $products .="</a>";
                                        $products .="</h2>";
                                    $products .="</div>";


                                    if ($product_image AND $product_image_url){
                                        $products .="<a href=\"".$curent_url."product/".$value['id']."/zoom/".$seo_title.".html\" alt=\"".stripslashes($value['name'])."\">";
                                        $products .= "<img src=\"".$product_image_url."\" border=\"0\" width=\"100px\" title=\"".stripslashes($value['name'])."\" align=\"left\" style=\"margin:8px;\">";
                                        $products .="</a>";
                                    }


                                    if (OW::getConfig()->getValue('shoppro', 'max_product_desc_chars')>0){
                                        $max_chars=OW::getConfig()->getValue('shoppro', 'max_product_title_chars');
                                        if ($value['description_de']){
                                            $description=stripslashes($value['description_de']);
                                        }else if ($value['description_de_def']){
                                            $description=stripslashes($value['description_de_def']);
                                        }else{
                                            $description=stripslashes($value['description']);
                                        }
                                        $description = SHOPPRO_BOL_Service::getInstance()->clear_text($description);
                                        $pr = SHOPPRO_BOL_Service::getInstance()->crop_html2($description,$max_chars);
                                        if (strlen(stripslashes($value['name']))>$max_chars) $pr .="...";
                                        $products .=SHOPPRO_BOL_Service::getInstance()->brtospace($pr);
                                    }else{
                                        if ($value['description_de']){
                                            $description=stripslashes($value['description_de']);
                                        }else if ($value['description_de_def']){
                                            $description=stripslashes($value['description_de_def']);
                                        }else{
                                            $description=stripslashes($value['description']);
                                        }
                                        $description = SHOPPRO_BOL_Service::getInstance()->clear_text($description);
                                        $pr = SHOPPRO_BOL_Service::getInstance()->crop_html2($description,255);
                                        $products .=SHOPPRO_BOL_Service::getInstance()->brtospace($pr);
                                    }

                                    //more
                                    if (!OW::getConfig()->getValue('shoppro', 'hide_more_button_onproductlist')){
                                        $products .="<div style=\"margin:0 10px 0 10px;display:inline-block;\">
                                            <a class=\"ow_lbutton\" href=\"".$curent_url."product/".$value['id']."/zoom/".$seo_title.".html\" alt=\"".stripslashes($value['name'])."\">".OW::getLanguage()->text('base', 'more')."</a>
                                        </div>";
                                    }



                                    $products .="<div class=\"clearfix\" style=\"display:inline-block;width:100%;float:left;text-align:left;font-size:12px;margin:10px\">";

                                    if (OW::getConfig()->getValue('shoppro', 'hide_seller_avatar_onthelist') && !OW::getConfig()->getValue('shoppro', 'hide_seller_small_icon')){
                                        $products .="<img border=\"0\" style=\"vertical-align:text-bottom;\" src=\"".$pluginStaticURL2."user.png\">&nbsp;".$dname;
                                    }



                                    if (!OW::getConfig()->getValue('shoppro', 'hide_product_small_details')){

                                        if (OW::getConfig()->getValue('shoppro', 'turn_on_ciew_couter')==1 OR (OW::getConfig()->getValue('shoppro', 'turn_on_ciew_couter')==2 AND (($value['id_owner']==$id_user AND $id_user>0) OR $is_admin))  ){
                                            if (OW::getConfig()->getValue('shoppro', 'hide_seller_avatar_onthelist') && !OW::getConfig()->getValue('shoppro', 'hide_seller_small_icon')){
                                                $products .=", ";   
                                            }
                                            $products .="<i>".OW::getLanguage()->text('shoppro', 'count_view')."</i>:&nbsp;";
                                            $products .="<b>".$value['count_view']."</b>";
                            
                                        }

                                        if (!OW::getConfig()->getValue('shoppro', 'hide_condition') AND $value['condition']>0){
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

                                        if (!OW::getConfig()->getValue('shoppro', 'hide_wanted_avaiable') AND $value['type_ads']==0){
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

                                        if (!OW::getConfig()->getValue('shoppro', 'hide_location') AND $value['location']){
                                            if ($value['classifieds_type'] OR $value['condition']>0) $products .=", ";
                                            $products .="<i>".OW::getLanguage()->text('shoppro', 'product_location')."</i>:&nbsp;";
                                            $loc=str_replace("'","",stripslashes($value['location']));
                                            $loc=str_replace("\r\n","",$loc);
                                            $loc=str_replace("\r","",$loc);
                                            $loc=str_replace("\n","",$loc);
                                            $loc=str_replace("\t","",$loc);
                                            $loc=str_replace(" ","+",$loc);
//                                            $products .="<b><a href=\"https://maps.google.com/maps?tab=wl&q=".$loc."\" target=\"_blank\">".mb_substr(stripslashes($value['location']),0,20)."</a></b>";
                                            $products .="<b><a href=\"//maps.google.com/maps?tab=wl&q=".$loc."\" target=\"_blank\">".mb_substr(stripslashes($value['location']),0,20)."</a></b>";
                                        }

                                        if (!OW::getConfig()->getValue('shoppro', 'hide_map_lat_lon') AND $value['map_lat']!="" AND $value['map_lan']){
                                            $products .=", <i>".OW::getLanguage()->text('shoppro', 'map')."</i>:&nbsp;";
                                            $loc=$value['map_lat'].",".$value['map_lan'];
//                                            $products .="<b><a href=\"http://maps.google.com/maps?tab=wl&q=".$loc."\" target=\"_blank\">".OW::getLanguage()->text('shoppro', 'show_location')."</a></b>";
                                            $products .="<b><a href=\"//maps.google.com/maps?tab=wl&q=".$loc."\" target=\"_blank\">".OW::getLanguage()->text('shoppro', 'show_location')."</a></b>";
                                        }
                                    }else{//if (!OW::getConfig()->getValue('shoppro', 'hide_product_small_details')){
                                        if (OW::getConfig()->getValue('shoppro', 'turn_on_ciew_couter')==1 OR (OW::getConfig()->getValue('shoppro', 'turn_on_ciew_couter')==2 AND (($value['id_owner']==$id_user AND $id_user>0) OR $is_admin))  ){
                                            $products .="<i>".OW::getLanguage()->text('shoppro', 'count_view')."</i>:&nbsp;";
                                            $products .="<b>".$value['count_view']."</b>";
                                        }
                                    }
                                    $products .="</div>";
                                $products .="</div>";//============================================================================================================================================================================================== end product 


                            $products .="</td>";





                            if ($value['id_owner']==$id_user AND $id_user>0){
                                $bg="border-right:2px solid #FF8888;";
                            }else{
                                $bg="";
                            }
                            $table ="";

                            $products .="<td style=\"width:100px;text-align:center;".$bg."\" valign=\"top\">";

//aronlist aron list bay aron bay1
                            //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------pay by credit 1
                            //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------pay by credit
                            //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------pay by credit
//echo OW::getConfig()->getValue('shoppro', 'mode_membercanselingbypoints')."--".$value['type_ads']."--".$value['price'];exit;

//                            if (OW::getConfig()->getValue('shoppro', 'mode_membercanselingbypoints')==1 AND $value['type_ads']==2 AND $value['price']>0){//-----------------------------------------------------------------pay by credit
                            if ($value['type_ads']==2 AND $value['price']>0){//-----------------------------------------------------------------pay by credit
                                $products .=SHOPPRO_BOL_Service::getInstance()->thene_credits($value);
                                $product_grid .=SHOPPRO_BOL_Service::getInstance()->thene_product($value,"credits");
                            //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------pay by paypal SHOP 2
                            //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------pay by paypal SHOP
                            //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------pay by paypal SHOP
                            }else if ((strlen($value['seler_account'])>6 OR (OW::getConfig()->getValue('shoppro', 'mode_payment')=="przelewy24" AND $value['seler_account']>0)) AND $value['type_ads']==1 AND $value['price']>0){//----shop
                                $products .=SHOPPRO_BOL_Service::getInstance()->thene_shop($value);
                                $product_grid .=SHOPPRO_BOL_Service::getInstance()->thene_product($value,"shop");
                            //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- free 3
                            //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- free
                            //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- free
                            }else if (!$value['price'] OR $value['price']==0){//---------------------------------------------------------------------------------------------------------free
                                $products .=SHOPPRO_BOL_Service::getInstance()->thene_free($value);
                                $product_grid .=SHOPPRO_BOL_Service::getInstance()->thene_product($value,"free");
                            //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- Classifieds 4
                            //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- Classifieds
                            //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- Classifieds
                            }else if (strlen($value['seler_account'])<7 OR $value['type_ads']==0 OR (OW::getConfig()->getValue('shoppro', 'mode_payment')=="przelewy24" AND $value['seler_account']>0)){//--------------clasifid
                                $products .=SHOPPRO_BOL_Service::getInstance()->thene_classifieds($value);
                                $product_grid .=SHOPPRO_BOL_Service::getInstance()->thene_product($value,"classified");
                            }//end types seling
                            //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- Classifieds
                            //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- END
                            //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- END Classifieds



                            if ($is_admin OR ( ($id_user>0 AND OW::getConfig()->getValue('shoppro', 'mode_membercanshell')==1) AND $value['id_owner']==$id_user)){

                                if ($table){
                                    //    $products .="<br/>";
                                }else{
                                    //    $products .="<br/><br/>";
                                }


                                $products .=SHOPPRO_BOL_Service::getInstance()->make_file_downloadurl($value,"id");//download owned file


                                $products .="<div class=\"ow_center\" style=\"margin:auto;text-align:center;display:inline-block;margin-top:10px;\">";

                                    $products .="<span style=\"\" class=\"ow_nowrap\">
                                    <a href=\"".$curent_url."product/".$value['id']."/edit\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_edit')."\">
                                        <img src=\"".$pluginStaticURL2."edit_section2.gif\" style=\"border:0;\">
                                    </a>
                                    </span>";

                                    $products .="<span style=\"\" class=\"ow_nowrap\">
                                    <a onclick=\"return confirm('Are you sure you want to delete?');\" href=\"".$curent_url."product/".$value['id']."/del\">
                                        <img src=\"".$pluginStaticURL2."erase3.gif\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_delete')."\" style=\"border:0;\">
                                    </a>
                                    </span>";

                                $products .="</div>";

                            }//if admin


                            if (OW::getConfig()->getValue('shoppro', 'turn_on_commntsandrate')){
                                if ((!$id_user OR $value['id_owner']==$id_user) AND !$is_admin){
                                    $products .=SHOPPRO_BOL_Service::getInstance()->make_rate($value['id'],"shop","shoppro","",true);//rate small
                                }else{
                                    $products .=SHOPPRO_BOL_Service::getInstance()->make_rate($value['id'],"shop","shoppro","",false);//rate small
                                }
                            }

                            $products .="</td>";
                        $products .="</tr>";






                        //space
                        $products .="<tr>";
                        $products .="<td colspan=\"3\" style=\"height:3px;\">";
//                        $products .="&nbsp;";
                        $products .="</td>";
                        $products .="</tr>";





                                $curent++;
                                if ($curent>2){
                                    $curent=1;
                                }
                                $curent_revers++;
                                if ($curent_revers>2){
                                    $curent_revers=1;
                                }
//echo "sdfsdfSDf";exit;
                            }//foreach        
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------main loop end
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------













            $menu=$this->make_menu($params['idcat']);
            if (($menu OR $is_admin )AND (OW::getConfig()->getValue('shoppro', 'mode')==0 OR !OW::getConfig()->getValue('shoppro', 'mode') )){
                $content .="<div style=\"display:inline-block;width:98%;margin:auto;\" >";//ZZZ zisednaru AAA

    	            $content .="<div style=\"position:relative;float:right;display:inline-block;width:23%;\">";
                        $content .="<div class=\"ow_dnd_widget index-BASE_CMP_MenuWidget\" style=\"width:205px;;margin:auto;\">
                            <div class=\"ow_box_cap ow_dnd_configurable_component clearfix\" >
                                <div class=\"ow_box_cap_right\">
                                    <div class=\"ow_box_cap_body\">
                                        <h3 class=\"ow_ic_shop\">".OW::getLanguage()->text('shoppro', 'product_table_category')."</h3>
                                    </div>
                                </div>
                            </div>
    
                            <div class=\"ow_box ow_stdmargin clearfix index-BASE_CMP_MenuWidget ow_break_word\" style=\"\">
                                <div class=\"ow_my_avatar_widget\">
                                    <div class=\"clearfix\">
                                        ".$menu."
                                    </div>
                                </div>
                                <div class=\"ow_box_bottom_left\"></div>
                                <div class=\"ow_box_bottom_right\"></div>
                                <div class=\"ow_box_bottom_body\"></div>
                                <div class=\"ow_box_bottom_shadow\"></div>
                            </div>
                        </div>";
                    $content .="</div>";

                $main_width="74%";//610px
            }else{
                $content .="<div style=\"display:inline-block;width:100%;margin:auto;\" >";//bes zisednaru AAA
                $main_width="100%";
            }


//-----------main start
//		$content .="<div class=\"clearfix\" style=\"display:inline-block;position:relative;float:left;margin:auto;width:".$main_width.";\">";
		$content .="<div class=\"clearfix\">";

//    if (OW::getConfig()->getValue('shoppro', 'defaut_view')=="grid-view-only"){
//            $_SESSION['curent_view']="grid-view";
//    }else if (OW::getConfig()->getValue('shoppro', 'defaut_view')=="list-view-only"){
//            $_SESSION['curent_view']="list-view";


                if (OW::getConfig()->getValue('shoppro', 'defaut_view')=="grid-view-only" OR (isset($_SESSION['curent_view']) AND $_SESSION['curent_view']=="grid-view" AND $product_grid) ){//-------------------grid view
                                $content .="<ul id=\"products\" class=\"thumbnails js-products\" itemscope itemtype=\"http://schema.org/ItemList\">";
                                $content .=$product_grid;
                                $content .="</ul>";
                }else{//-------------------------------------------------------------------------------------------list view
//                                $content .="<table style=\"width:100%;margin:auto;\">";
                                $content .="<table style=\"margin:auto;\" class=\"ow_table\">";
                		if ($products){
		    	            $content .=$products;
				}else{
                                    $content .="<tr>";
                                    $content .="<td colspan=\"4\">";
                                    $content .=OW::getLanguage()->text('shoppro', 'product_not_found');
                                    $content .="</td>";
                                    $content .="</tr>";
                                }
                                $content .="</table>";
                }//-----------------------------------------------------------------------------------------------list view end

		$content .="</div>";
//-----------main end


	$content .="</div>";


//-----tlo
$content .="<div id=\"shop_overlay\" class=\"shop_dialog_overlay\"></div>";

/*
//-------------------page start B
$url_pages="";
if ($idcat>0){
    if ($url_pages) $url_pages .="&";
    $url_pages .="cat=".$idcat;
}

if ($params['optmy']=="show" OR (isset($_GET['my']) AND $_GET['my']=="show")){
    if ($url_pages) $url_pages .="&";
    $url_pages .="my=show";
}

if (isset($params['option']) AND ($params['option']=="approval" OR (isset($_GET['approval']) AND $_GET['approval']=="only")) AND $is_admin){
    if ($is_admin AND OW::getConfig()->getValue('shoppro', 'mode_ads_approval')){
        if ($url_pages) $url_pages .="&";
        $url_pages .="approval=only";
    }
}

if ($idcat>0){
    $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_categories WHERE id='".addslashes($idcat)."' LIMIT 1";
    $arrp = OW::getDbo()->queryForList($query);
    if (isset($arrp[0])){
        $valuep=$arrp[0];
    }else{
        $valuep=array();
    }
    $pagination .="<div style=\"float:left;\">";
    $pagination .=OW::getLanguage()->text('shoppro', 'product_path');
    $pagination .=" : ";
    $pagination .="<a style=\"width:100%;\" class=\"ow_lbutton ow_alt1 \" href=\"".$curent_url."shop\" >";
    $pagination .=OW::getLanguage()->text('shoppro', 'product_showfromaallcategory');
    $pagination .="</a>";
    $pagination .=" / ";
    $pagination .="<a style=\"width:100%;\" class=\"ow_lbutton ow_alt1 \" href=\"".$curent_url."shop?".$url_pages."\" >";
    $pagination .=stripslashes($valuep['name']);
    $pagination .="</a>";
    $pagination .="</div>";
}

if ($url_pages) $url_pages ="&".$url_pages;


//    $pagination .="<a style=\"width:100%;\" class=\"ow_smallmargin ow_ic_left_arrow\" href=\"#\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_prev')."\">xxx</a>";
//--b start
//    $pagination .="<div class=\"ow_stdmargin  clearfix\" >";
//    $pagination .="<a style=\"width:35px;height:25px;display:inline-block;background-position: center center;\" class=\"ow_add_content ow_ic_left_arrow ow_center\" href=\"#\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_prev')."\"></a>";
//    $pagination .="</div>";
//--b end


    $pagination .="<div class=\"clearfix\" >";

$pagination .="<table style=\"float:right;\"  style=\"\">";
$pagination .="<tr>";
$pagination .="<td style=\"width:45px;height:20px;\">";
if ($curent_page>0){
//    $pagination .="<a style=\"width:100%;\" class=\"ow_add_content ow_alt1 ow_ic_left_arrow\" href=\"".$curent_url."shop?page=".$prev_page.$url_pages."\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_prev')."\"></a>";
//--b start
    $pagination .="<div class=\"ow_stdmargin  clearfix\"  style=\"height:15px;margin-bottom:30px;padding:0;\">";
    $pagination .="<a style=\"padding: 5px;margin:5px;width:45px;height:25px;display:inline-block;background-position: center center;\" class=\"ow_add_content ow_ic_left_arrow\" href=\"".$curent_url."shop?page=".$prev_page.$url_pages."\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_prev')."\"></a>";
    $pagination .="</div>";
//--b end
}else{
//    $pagination .="<a style=\"width:100%;\" disabled=\"true\" class=\"ow_add_content ow_alt2 ow_ic_left_arrow\" href=\"#\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_prev')."\"></a>";
//--b start
    $pagination .="<div class=\"ow_stdmargin  clearfix\"  style=\"height:15px;margin-bottom:30px;padding:0;\">";
    $pagination .="<a style=\"padding: 5px;margin:5px;width:45px;height:25px;display:inline-block;background-position: center center;\" class=\"ow_add_content ow_ic_left_arrow ow_center\" href=\"#\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_prev')."\"></a>";
    $pagination .="</div>";
//--b end
}



$pagination .="</td>";

$pagination .="<td style=\"min-width:5px;height:20px;text-align:center;padding:0 5px 10px 5px;vertical-align: middle;\" valign=\"middle\">";
$pagination .="-".($curent_page+1)."-";
$pagination .="</td>";

$pagination .="<td style=\"width:45px;height:20px;\">";
if ($products){
//    $pagination .="<a style=\"width:100%;\" class=\"ow_add_content ow_alt1 ow_ic_right_arrow\" href=\"".$curent_url."shop?page=".$next_page.$url_pages."\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_next')."\"></a>";
//--b start
    $pagination .="<div class=\"ow_stdmargin  clearfix\" style=\"height:15px;margin-bottom:30px;padding:0;\">";
    $pagination .="<a style=\"padding: 5px;margin:5px;width:45px;height:25px;display:inline-block;background-position: center center;\" class=\"ow_add_content ow_ic_right_arrow\" href=\"".$curent_url."shop?page=".$next_page.$url_pages."\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_next')."\"></a>";
    $pagination .="</div>";
//--b end
}else{
//    $pagination .="<a style=\"width:100%;\" class=\"ow_add_content ow_alt1 ow_ic_right_arrow\" href=\"#\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_next')."\"></a>";
//--b start
    $pagination .="<div class=\"ow_stdmargin  clearfix\"  style=\"height:15px;margin-bottom:30px;padding:0;\">";
    $pagination .="<a style=\"padding: 5px;margin:5px;width:45px;height:25px;display:inline-block;background-position: center center;\" class=\"ow_add_content ow_ic_right_arrow\" href=\"#\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_next')."\"></a>";
    $pagination .="</div>";
//--b end
}

$pagination .="</td>";
$pagination .="</tr>";
$pagination .="</table>";

    $pagination .="</div>";
//-------------------page end B
*/


$orderby="";

$orderby .="<div class=\"clearfix\">";


if (OW::getConfig()->getValue('shoppro', 'defaut_view')!="grid-view-only" AND OW::getConfig()->getValue('shoppro', 'defaut_view')!="list-view-only"){
    $orderby .="<div class=\"ow_left \" style=\"\">";

        $orderby .="<div class=\"ow_left\" style=\"margin:0 5px;\">";
            $orderby .="<a href=\"".$curent_url."shop/set/list-view\">";
            $orderby .="<img src=\"".$pluginStaticURL2."ext/view-list.png\">";
            $orderby .="</a>";
        $orderby .="</div>";

        $orderby .="<div class=\"ow_left\" style=\"margin:0 5px;\">";
            $orderby .="<a href=\"".$curent_url."shop/set/grid-view\">";
            $orderby .="<img src=\"".$pluginStaticURL2."ext/view-grid.png\">";
            $orderby .="</a>";
        $orderby .="</div>";
    
    $orderby .="</div>";
}


$orderby .="<div class=\"ow_left\">";
$orderby .="<select id=\"shop_main_order\" url=\"".$curent_url."shop\">";

if (!isset($_SESSION['shoplist_order'])) $_SESSION['shoplist_order']="";


if ( (isset($_SESSION['shoplist_order']) AND $_SESSION['shoplist_order']=="default") OR (!isset($_SESSION['shoplist_order'])) ) $sel=" SELECTED ";
    else $sel="";
$orderby .="<option ".$sel." value=\"default\">".OW::getLanguage()->text('shoppro', 'order_defaults')."</option>";

if ( (isset($_SESSION['shoplist_order']) AND $_SESSION['shoplist_order']=="nameasc") ) $sel=" SELECTED ";
    else $sel="";
$orderby .="<option ".$sel." value=\"nameasc\">".OW::getLanguage()->text('shoppro', 'order_name_asc')."</option>";
if (isset($_SESSION['shoplist_order']) AND $_SESSION['shoplist_order']=="namedesc") $sel=" SELECTED ";
    else $sel="";
$orderby .="<option ".$sel." value=\"namedesc\">".OW::getLanguage()->text('shoppro', 'order_name_desc')."</option>";

if (isset($_SESSION['shoplist_order']) AND $_SESSION['shoplist_order']=="dataasc") $sel=" SELECTED ";
    else $sel="";
$orderby .="<option ".$sel." value=\"dataasc\">".OW::getLanguage()->text('shoppro', 'order_data_asc')."</option>";
if (isset($_SESSION['shoplist_order']) AND $_SESSION['shoplist_order']=="datadesc") $sel=" SELECTED ";
    else $sel="";
$orderby .="<option ".$sel." value=\"datadesc\">".OW::getLanguage()->text('shoppro', 'order_data_desc')."</option>";

if (isset($_SESSION['shoplist_order']) AND $_SESSION['shoplist_order']=="popasc") $sel=" SELECTED ";
    else $sel="";
$orderby .="<option ".$sel." value=\"popasc\">".OW::getLanguage()->text('shoppro', 'order_popularity_asc')."</option>";
if (isset($_SESSION['shoplist_order']) AND $_SESSION['shoplist_order']=="popdesc") $sel=" SELECTED ";
    else $sel="";
$orderby .="<option ".$sel." value=\"popdesc\">".OW::getLanguage()->text('shoppro', 'order_popularity_desc')."</option>";
$orderby .="</select>";
$orderby .="</div>";




$orderby .="</div>";



//$curent_url."shop?page=".$next_page.$url_pages."
//makePagination($page = 1, $totalitems, $limit = 15, $adjacents = 1, $targetpage = "/", $pagestring = "?page=")
if (!isset($url_pages)) $url_pages="";
if ($idcat>0){
    $pagination=SHOPPRO_BOL_Service::getInstance()->makePagination(($curent_page+1), $all_items, OW::getConfig()->getValue('shoppro', 'mode_perpage'), 1, $curent_url."shoppro/".$idcat."?".$url_pages,"&page=","right",$orderby);
    $pagination_bottom=SHOPPRO_BOL_Service::getInstance()->makePagination(($curent_page+1), $all_items, OW::getConfig()->getValue('shoppro', 'mode_perpage'), 1, $curent_url."shoppro/".$idcat."?".$url_pages,"&page=","right");
}else{
    $pagination=SHOPPRO_BOL_Service::getInstance()->makePagination(($curent_page+1), $all_items, OW::getConfig()->getValue('shoppro', 'mode_perpage'), 1, $curent_url."shop?".$url_pages,"&page=","right",$orderby);
    $pagination_bottom=SHOPPRO_BOL_Service::getInstance()->makePagination(($curent_page+1), $all_items, OW::getConfig()->getValue('shoppro', 'mode_perpage'), 1, $curent_url."shop?".$url_pages,"&page=","right");
}



        if ($products){
            $content=$pagination.$content.$pagination_bottom;
//            $content=$pagination.$orderby.$content.$pagination.$orderby;
        }else{
            $content=$pagination.$content;
//            $content=$pagination.$orderby.$content;
        }



//------------bottom products list
//--------------------popup start

            $content .=SHOPPRO_BOL_Service::getInstance()->make_popup_inquire_dialog("myModal");
//--------------------popup end POWTORZONE NA LISCIE BEZ ZOOMA


//--top start
//print_r($params);
//optmy
        if (isset($params['option']) AND ($params['option']=="approval" OR (isset($_GET['approval']) AND $_GET['approval']=="only")) AND $is_admin){
            $content_t=SHOPPRO_BOL_Service::getInstance()->make_tabs("approval",$content);
        }else if ( (isset($params['optmy']) AND $params['optmy']=="show") OR (isset($_GET['my']) AND $_GET['my']=="show") ){
            $content_t=SHOPPRO_BOL_Service::getInstance()->make_tabs("myitems",$content);
        }else{
            $content_t=SHOPPRO_BOL_Service::getInstance()->make_tabs("shop",$content);
        }
//--top end

                        

//            $this->assign('content', $pagination.$content_t);    
            $this->assign('content', $content_t);    
        }//else //-----------------------------------------zoom end
//echo "dddd";exit; 
    }

    public function indexinq($params)
    {
        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();
$curent_url=OW_URL_HOME;                     
            
/*
        <form action=\"".$curent_url."shop/inquire\" method=\"POST\">
                        <input type=\"hidden\" name=\"ss\" value=\"".substr(session_id(),2,6)."\">
                        <input type=\"hidden\" name=\"idp\" id=\"idp\" value=\"0\">
                        <input type=\"hidden\" name=\"idu\" id=\"idu\" value=\"0\">
                        <input type=\"hidden\" name=\"ac\" value=\"send_message\">
*/


//        if (isset($_POST['ss']) AND $_POST['ss']==

                if ($id_user>0 AND isset($_POST['ss']) AND $_POST['ss']==substr(session_id(),2,6) AND isset($_POST['idu']) AND isset($_POST['idp']) AND isset($_POST['tit']) AND isset($_POST['cont']) AND $_POST['idu']>0 AND $_POST['idp']>0){
                    $for_user=$_POST['idu'];
                    
                    if ($for_user>0){
                        $title="";
                        if ($_POST['tit']) $title=$_POST['tit'];
                        $message="";
                        if ($_POST['cont']) $message=$_POST['cont'];
                        SHOPPRO_BOL_Service::getInstance()->add_to_mailbox($id_user,$for_user,$title,$message,strtotime(date('Y-m-d H:i:s')),"");
//email_notyfication
                        SHOPPRO_BOL_Service::getInstance()->email_notyfication($for_user,$title,$message);

                        OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'message_was_send'));
                        OW::getApplication()->redirect($curent_url."product/".$_POST['idp']."/zoom/index.html");
                        exit;
                    }else{
                        OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'messge_was_not_send'));
                        OW::getApplication()->redirect($curent_url."sign-in?back-uri=product/".$_POST['idp']."/zoom/index.html");
                        exit;
                    }
                }else{
                    if (!$id_user){
                        OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'messge_was_not_send'));                
                        if ($_POST['idp']>0){
                            OW::getApplication()->redirect($curent_url."sign-in?back-uri=product/".$_POST['idp']."/zoom/index.html");
                        }else{
                            OW::getApplication()->redirect($curent_url."sign-in?back-uri=shop");
                        }
                    }else{
                        OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'messge_was_not_send'));                
                        if ($_POST['idp']>0){
                            OW::getApplication()->redirect($curent_url."product/".$_POST['idp']."/zoom/index.html");
                        }else{
                            OW::getApplication()->redirect($curent_url."shop");
                        }
                    }
                    exit;            
                }

    }




//showorder
    public function show_order($params) //--------------for admin
    {
//echo "order";
        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();
$curent_url=OW_URL_HOME;                         

//add to test
        if (!$id_user){
//            $content =OW::getLanguage()->text('shoppro', 'product_not_found');
//            $content_t=SHOPPRO_BOL_Service::getInstance()->make_tabs("admin",$content);
//            $this->assign('content', $content_t);
            OW::getApplication()->redirect($curent_url."sign-in?back-uri=shop");
            return;
        }
/*
$from_config=$curent_url;
$from_config=str_replace("https://","",$from_config);
$from_config=str_replace("http://","",$from_config);
$trash=explode($from_config,$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);
$url_detect=$trash[1];
//print_r($trash);
//echo $url_detect;
*/

//echo "sss";exit;

//----paging param start A
$paging="";
$per_page=OW::getConfig()->getValue('shoppro', 'mode_perpage');
if (!$per_page) $per_page=20;

$add_paramurl="";
$add_fortabulr="";
if (isset($_GET['f'])){
    if ($add_paramurl) $add_paramurl .="&";
    $add_paramurl .="f=".$_GET['f'];
}

if (isset($_GET['qstat'])){
    if ($add_paramurl) $add_paramurl .="&";
    $add_paramurl .="qstat=".$_GET['qstat'];

    $add_fortabulr="&qstat=".$_GET['qstat'];
}
//if ($add_paramurl) $add_paramurl ="&".$add_paramurl;

        $start_form=0;
        if (isset($_GET['page'])){
            $curent_page=($_GET['page']-1);
        }else{
            $curent_page=0;
        }
if (!$curent_page) $curent_page=0;
//echo $curent_page;exit;

        $start_form=($curent_page*$per_page);
        if (!$start_form) $start_form=0;

        $prev_page=$curent_page-1;
        if ($prev_page<0) $prev_page=0;
//----paging param end A


        $content="";
        $table="";

        if ($curent_page>0){
            $limit=" ".$start_form.",".$per_page;
        }else{
            $limit=" ".$per_page;
        }

        if (($id_user>0 AND OW::getConfig()->getValue('shoppro', 'mode_membercanshell')==1) OR $is_admin){
            if ($is_admin){
                $add="";
            }else{
                $add=" AND prod.id_owner='".addslashes($id_user)."' ";
            }
$add_ff="";            
if (isset($_GET['f'])){
//'init','prepared','verified','delivered','processing','error'

    if ($_GET['f']=="init") $add_ff=" AND saletable.status='init' ";
    else if ($_GET['f']=="all") $add_ff=" ";
    else if ($_GET['f']=="prepared") $add_ff=" AND saletable.status='prepared' ";
    else if ($_GET['f']=="verified") $add_ff=" AND saletable.status='verified' ";
    else if ($_GET['f']=="delivered") $add_ff=" AND saletable.status='delivered' ";
    else if ($_GET['f']=="processing") $add_ff=" AND saletable.status='processing' ";
    else if ($_GET['f']=="error") $add_ff=" AND saletable.status='error' ";
    else $add_ff=" AND saletable.status='processing' ";
}else{
//    $add_ff=" AND saletable.status='processing' ";
    $add_ff=" ";
}

if (isset($_GET['qstat'])){
    $add_query="";
    $add_query .=" AND (userss.username LIKE '".addslashes($_GET['qstat'])."' OR LOWER(userss.username) LIKE '".addslashes(strtolower($_GET['qstat']))."' ";
    $add_query .=" OR (userssquestion.questionName='realname' AND (userssquestion.textValue LIKE '".addslashes($_GET['qstat'])."' OR LOWER(userssquestion.textValue) LIKE '".addslashes(strtolower($_GET['qstat']))."') ) ";
    $add_query .=") ";
}else{
    $add_query="";
}
//$pluginStaticDir =OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();
//$pluginStaticDir =OW::getPluginManager()->getPlugin('shoppro')->getStaticDir();



//------
            $query = "SELECT COUNT(*) as alli FROM " . OW_DB_PREFIX. "base_billing_sale saletable 
            LEFT JOIN " . OW_DB_PREFIX. "shoppro_products prod ON (prod.id=saletable.entityId) 

            LEFT JOIN " . OW_DB_PREFIX. "base_user userss ON (userss.id=saletable.userId) 
            LEFT JOIN " . OW_DB_PREFIX. "base_question_data userssquestion ON (userssquestion.userId=userss.id AND questionName='realname') 
            WHERE saletable.pluginKey='shoppro_product' ".$add_ff." ".$add." ".$add_query;
            $arrx = OW::getDbo()->queryForList($query);
            if (isset($arrx[0])){
                $alli=$arrx[0];
                $all_items=$alli['alli'];
            }else{
                $all_items=0;
            }
//echo $all_items;exit;
//------
//echo $all_items;exit;

            $query = "SELECT saletable.*, userss.username, prod.id_owner,userssquestion.textValue, prod.type_ads FROM " . OW_DB_PREFIX. "base_billing_sale saletable 
            LEFT JOIN " . OW_DB_PREFIX. "shoppro_products prod ON (prod.id=saletable.entityId) 

            LEFT JOIN " . OW_DB_PREFIX. "base_user userss ON (userss.id=saletable.userId) 
            LEFT JOIN " . OW_DB_PREFIX. "base_question_data userssquestion ON (userssquestion.userId=userss.id AND questionName='realname') 
            WHERE saletable.pluginKey='shoppro_product' ".$add_ff." ".$add." ".$add_query." ORDER BY timeStamp DESC,status DESC,userId LIMIT ".$limit;
//echo $query;           exit;
            $arrx = OW::getDbo()->queryForList($query);
            $curent=1;
            $curent_revers=2;
            $pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();
            $pluginStaticURL =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesUrl();
            $pluginStaticDir =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesDir();
            $lp=0;
            foreach ( $arrx as $value ) {
                $lp=$lp+1;
                $product_image="ow_userfiles/plugins/shoppro/images/product_".$value['entityId'].".jpg";
                $pimage="product_".$value['entityId'].".jpg";
                if (is_file($pluginStaticDir."images/".$pimage)){
                    $product_image=$curent_url.$product_image;
                }else{
                    $product_image="";
                }
if (!isset($value['has_options'])) $value['has_options']=0;


                $show_status_for_user=false;
                if ($value['status']=="verified"){
                    $color="#080";
                    $show_status_for_user=true;
                }else if ($value['status']=="delivered"){
                    $color="#080";
                    $show_status_for_user=true;
                }else if ($value['status']=="processing"){
                    $color="#993300";
                    $show_status_for_user=true;
                }else{
                    $color="#f00";
                    $show_status_for_user=true;
                }

                if ($show_status_for_user){



                    $table .="<tr class=\"ow_alt".$curent."\" >";
                    $table .="<td>";
//                    $table .=$value['id']."_".$value['entityId']."_".$value['id_owner'].")&nbsp;";
//                    $table .=$lp.")&nbsp;";
                    $table .="&nbsp;";
                    
                    $table .= "<a href=\"".$curent_url."product/".$value['entityId']."/zoom/item.html\">";
                    $table .= "<strong>".$value['entityKey']."</strong>";
                    $table .= "</a>";
if (!$value['id_owner'] AND $is_admin){
                    $table .= "<string style=\"color:#f00;\">&nbsp;&nbsp;".OW::getLanguage()->text('shoppro', 'product_was_deleted')."</strong>";
}
                    $table .="</td>";

                    $table .="<td style=\"text-align:right;\">";
//                        $table .= "<strong>".date('d-m-Y h:i',$value['timeStamp'])."</strong>";
//                    $table .= "<strong>".date('d-m-Y',$value['timeStamp'])."</strong>";
                    $table .="<strong>".UTIL_DateTime::formatDate((int) $value['timeStamp'])."</strong>";
                    $table .="</td>";
                    $table .="</tr>";



                    $table .="<tr>";
                    $table .="<td colspan=\"2\">";
//                        $table .="<div style=\"float:right;width:auto;min-height:150px;border:1px solid #ddd;\">";
                        $table .="<div class=\"ow_alt1\" style=\"float:right;width:auto;min-width:180px;min-height:60px;\">";
/*
'init','prepared','verified','delivered','processing','error'
'init', 'przygotowany "," sprawdzone "," dostarczone "," przetwarzanie "," b��d "
*/



                            $table .="<table style=\"width:100%;margin:auto;border:0;\">";

                            $table .="<tr>";
                            $table .="<td style=\"text-align:right;\">";
                            $table .= "<b>".OW::getLanguage()->text('shoppro', 'product_table_username').":</b>";
                            $table .="</td>";
                            $table .="<td>";
                            $table .="<a href=\"".$curent_url."user/".$value['username']."\">";
                            $table .= "&nbsp;<b>".$value['username']."</b>";
                            $table .="</a>";
                            $table .="</td>";
                            $table .="</tr>";


                            $table .="<tr>";
                            $table .="<td style=\"text-align:right;\">";
                            $table .="<b>".OW::getLanguage()->text('shoppro', 'product_order_status').":</b>";
                            $table .="</td>";
                            $table .="<td>";
                            $table .="&nbsp;<b style=\"color:".$color.";\">".$value['status']."</b>";
                            $table .="</td>";
                            $table .="</tr>";
    
                            $table .="<tr>";
                            $table .="<td style=\"text-align:right;\">";
                            $table .= "<b>".OW::getLanguage()->text('shoppro', 'product_table_price').":</b>";
                            $table .="</td>";
                            $table .="<td>";
                            $table .= "&nbsp;<b>".number_format($value['totalAmount'], 2, ',', ' ')."</b> ".$value['currency'];
                            $table .="</td>";
                            $table .="</tr>";

                            $table .="<tr>";
                            $table .="<td colspan=\"2\" style=\"text-align:center;\">";

                            $table .="<div class=\"ow_center ow_alt2\" style=\"margin:auto;text-align:left;display:block;margin-top:10px;\">";
                                if (isset($_GET['f'])) $ff="&f=".$_GET['f'];
                                    else $ff="";
                                if ($value['status']=="error"){
//                                    $table .="<a style=\"border:2px solid #080;padding:0;margin:0 5px 0;width:35px;height:35px;display:inline-block;background-position: center center;\" class=\"ow_add_content ow_ic_ok\" href=\"".$curent_url."product/".$value['entityId']."/unblock?ss=".substr(session_id(),3,2)."&spr=".$value['id'].$ff."\" title=\"".OW::getLanguage()->text('shoppro', 'product_accepted')."\"  onclick=\"return confirm('".OW::getLanguage()->text('shoppro', 'question_aprove_payment')."');\"></a>";
                                    $table .="<a href=\"".$curent_url."product/".$value['entityId']."/unblock?ss=".substr(session_id(),3,2)."&spr=".$value['id'].$ff."\" title=\"".OW::getLanguage()->text('shoppro', 'product_accepted')."\"  onclick=\"return confirm('".OW::getLanguage()->text('shoppro', 'question_aprove_payment')."');\">";
//$table .="<img src=\"".$pluginStaticURL2."ok.gif\" style=\"border:0;padding:0;margin:0;\">";
//$table .="<img src=\"".$pluginStaticURL2."check.gif\" style=\"border:0;padding:0;margin:0;\">";
//$table .="<img src=\"".$pluginStaticURL2."ok4.gif\" style=\"border:0;padding:0;margin:0;\">";
//$table .="<img src=\"".$pluginStaticURL2."plus2.gif\" style=\"border:0;padding:0;margin:0;margin-right:5px;\">";
$table .="<img src=\"".$pluginStaticURL2."plus_section2.gif\" style=\"border:0;padding:0;margin:0;margin-right:5px;\">";
                                    $table .="</a>";
                                }else{
                                    if ($value['status']!="delivered"){
//                                        $table .="<a style=\"border:2px solid #080;padding:0;margin:0 5px 0;width:35px;height:35px;display:inline-block;background-position: center center;\" class=\"ow_add_content ow_ic_ok\" href=\"".$curent_url."product/".$value['entityId']."/unblock?ss=".substr(session_id(),3,2)."&spr=".$value['id'].$ff."\" title=\"".OW::getLanguage()->text('shoppro', 'product_accepted')."\"  onclick=\"return confirm('".OW::getLanguage()->text('shoppro', 'question_aprove_payment')."');\"></a>";
                                        $table .="<a href=\"".$curent_url."product/".$value['entityId']."/unblock?ss=".substr(session_id(),3,2)."&spr=".$value['id'].$ff."\" title=\"".OW::getLanguage()->text('shoppro', 'product_accepted')."\"  onclick=\"return confirm('".OW::getLanguage()->text('shoppro', 'question_aprove_payment')."');\">";
//$table .="<img src=\"".$pluginStaticURL2."ok.gif\" style=\"border:0;padding:0;margin:0;\">";
//$table .="<img src=\"".$pluginStaticURL2."check.gif\" style=\"border:0;padding:0;margin:0;\">";
//$table .="<img src=\"".$pluginStaticURL2."ok4.gif\" style=\"border:0;padding:0;margin:0;\">";
$table .="<img src=\"".$pluginStaticURL2."plus_section2.gif\" style=\"border:0;padding:0;margin:0;margin-right:5px;\">";
                                    $table .="</a>";
                                    }
//                                    $table .="<a style=\"border:2px solid #f00;padding:0;margin:0;width:35px;height:35px;display:inline-block;background-position: center center;\" class=\"ow_add_content ow_ic_delete\" href=\"".$curent_url."product/".$value['entityId']."/block?ss=".substr(session_id(),3,2)."&spr=".$value['id'].$ff."\" title=\"".OW::getLanguage()->text('shoppro', 'product_notaccepted')."\"  onclick=\"return confirm('".OW::getLanguage()->text('shoppro', 'qestion_anuluj_payment')."');\"></a>";
                                    $table .="<a href=\"".$curent_url."product/".$value['entityId']."/block?ss=".substr(session_id(),3,2)."&spr=".$value['id'].$ff."\" title=\"".OW::getLanguage()->text('shoppro', 'product_notaccepted')."\"  onclick=\"return confirm('".OW::getLanguage()->text('shoppro', 'qestion_anuluj_payment')."');\">";
//$table .="<img src=\"".$pluginStaticURL2."delete.gif\" style=\"border:0;padding:0;margin:0;\">";
//$table .="<img src=\"".$pluginStaticURL2."off.gif\" style=\"border:0;padding:0;margin:0;\">";
//$table .="<img src=\"".$pluginStaticURL2."button_cancel.gif\" style=\"border:0;padding:0;margin:0;\">";
$table .="<img src=\"".$pluginStaticURL2."remove.png\" style=\"border:0;padding:0;margin:0;margin-right:5px;\">";
                                    $table .="</a>";
                                }

//$table .="<a href=\"".$curent_url."product/".$value['entityId']."/block?ss=".substr(session_id(),3,2)."&spr=".$value['id'].$ff."\" title=\"".OW::getLanguage()->text('shoppro', 'product_notaccepted')."\"  onclick=\"return confirm('".OW::getLanguage()->text('shoppro', 'qestion_anuluj_payment')."');\">";
//$table .="<img src=\"".$pluginStaticURL2."remove.png\" style=\"border:0;padding:0;margin:0;margin-right:5px;\">";
//$table .="</a>";
//---pop tart 1

//-----------------------------------ffff start
$content_ststus="";
$content_ststus .="<form action=\"".$curent_url."ordershop/changestat\" method=\"POST\">";
if (isset($_GET['f'])){
    $content_ststus .="<input type=\"hidden\" name=\"f\" value=\"".$_GET['f']."\">";
}
if (isset($_GET['page'])){
    $content_ststus .="<input type=\"hidden\" name=\"page\" value=\"".$_GET['page']."\">";
}
$content_ststus .="<input type=\"hidden\" name=\"ss\" value=\"".substr(session_id(),5,7)."\">";
$content_ststus .="<input type=\"hidden\" name=\"id\" value=\"".$value['id']."\">";
$content_ststus .="<input type=\"hidden\" name=\"eid\" value=\"".$value['entityId']."\">";
$content_ststus .="<input type=\"hidden\" name=\"ac\" value=\"changestat\">";

$content_ststus .="<div class=\"\">";
$content_ststus .=OW::getLanguage()->text('shoppro', 'product_curent_status').": ";
if (!$value['id_owner'] AND $is_admin){
    $content_ststus .= "<string style=\"color:#f00;\">&nbsp;&nbsp;".OW::getLanguage()->text('shoppro', 'product_was_deleted')."</strong>";
}else{
    if ($value['status']=="init") $content_ststus .=OW::getLanguage()->text('shoppro', 'product_status_init');
    else if ($value['status']=="prepared") $content_ststus .=OW::getLanguage()->text('shoppro', 'product_status_prepared');
    else if ($value['status']=="verified") $content_ststus .=OW::getLanguage()->text('shoppro', 'product_status_verified');
    else if ($value['status']=="delivered") $content_ststus .=OW::getLanguage()->text('shoppro', 'product_status_delivered');
    else if ($value['status']=="processing") $content_ststus .=OW::getLanguage()->text('shoppro', 'product_status_processing');
    else if ($value['status']=="error") $content_ststus .=OW::getLanguage()->text('shoppro', 'product_status_error');
}
$content_ststus .="</div>";
$content_ststus .="<br/>";



if (!$value['id_owner'] AND $is_admin){
}else{
    $content_ststus .=OW::getLanguage()->text('shoppro', 'change_status_to').": ";
    $content_ststus .="<select name=\"new_status\">";
// 'init','prepared','verified','delivered','processing','error'
    if ($value['status']=="init") $sel=" selected ";
        else $sel="";
    $content_ststus .="<option ".$sel." value=\"init\">".OW::getLanguage()->text('shoppro', 'product_status_init')."</option>";
    if ($value['status']=="prepared") $sel=" selected ";
        else $sel="";
    $content_ststus .="<option ".$sel." value=\"prepared\">".OW::getLanguage()->text('shoppro', 'product_status_prepared')."</option>";
    if ($value['status']=="verified") $sel=" selected ";
        else $sel="";
    $content_ststus .="<option ".$sel." value=\"verified\">".OW::getLanguage()->text('shoppro', 'product_status_verified')."</option>";
    if ($value['status']=="delivered") $sel=" selected ";
        else $sel="";
    $content_ststus .="<option ".$sel." value=\"delivered\">".OW::getLanguage()->text('shoppro', 'product_status_delivered')."</option>";
    if ($value['status']=="processing") $sel=" selected ";
        else $sel="";
    $content_ststus .="<option ".$sel." value=\"processing\">".OW::getLanguage()->text('shoppro', 'product_status_processing')."</option>";
    if ($value['status']=="error") $sel=" selected ";
        else $sel="";
    $content_ststus .="<option ".$sel." value=\"error\">".OW::getLanguage()->text('shoppro', 'product_status_error')."</option>";
    $content_ststus .="</select>";

    if ($value['type_ads']==2 AND SHOPPRO_BOL_Service::getInstance()->isplugin('usercredits')){//classified
        $content_ststus .="<br/>";
        $content_ststus .="<br/>";
        $price=$value['price'];
        if (!$price) $price="0";
            else $price=round($price);
//        if ($price>0){
//        $content_ststus .="(".OW::getLanguage()->text('shoppro', 'last_cost_incredits').": ".$price." ".OW::getLanguage()->text('shoppro', 'product_credits').")<br/>";
        $content_ststus .="<i>".OW::getLanguage()->text('shoppro', 'last_cost_incredits')."</i>: <b>".$price."</b><br/>";
        $content_ststus .=OW::getLanguage()->text('shoppro', 'credits_restore_to_mmber').": <input type=\"text\" name=\"give_credits\" value=\"0\" style=\"width:65px;\"> ".OW::getLanguage()->text('shoppro', 'product_credits')." ".OW::getLanguage()->text('shoppro', 'tothismember');
    }


    $content_ststus .="<br/>";
    $content_ststus .="<br/>";

            $content_ststus .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"submit\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'product_save_new_status')."\" class=\"ow_ic_save ow_positive\">
                        </span>
                    </span>
                </div>
            </div>";
}
//$content_ststus .="<a href=\"".$curent_url."product/".$value['entityId']."/block?ss=".substr(session_id(),3,2)."&spr=".$value['id'].$ff."\" title=\"".OW::getLanguage()->text('shoppro', 'product_notaccepted')."\"  onclick=\"return confirm('".OW::getLanguage()->text('shoppro', 'qestion_anuluj_payment')."');\">";
//$content_ststus .="<img src=\"".$pluginStaticURL2."remove.png\" style=\"border:0;padding:0;margin:0;margin-right:5px;\">";
//$content_ststus .="</a>";



$content_ststus .="</form>";

//------------------------------------fff end

//( $id="",$url="" ,$button_type="submit",$button_position="center",$title_bsubmit="Submit", $title="",$content="",$title_header="Info" 
if (!$value['id_owner'] AND $is_admin){
    $kay_submit="";
}else{
    $kay_submit=OW::getLanguage()->text('shoppro', 'product_save_new_status');
}
$kay_submit="";

//---pop start 2

$table .=SHOPPRO_BOL_Service::getInstance()->make_popup_window(
"",
$curent_url."baynowcredits/".$value['id']."_".substr(session_id(),7,6),
"button",
"center",
"edit_section2.gif",
OW::getLanguage()->text('shoppro', 'product_table_change_status'),
$kay_submit,
'',
$content_ststus,
OW::getLanguage()->text('shoppro', 'product_table_change_status'),
"image"
,$value['has_options'],$value['id']
);
//OW::getLanguage()->text('shoppro', 'product_table_select_new_status'),
//OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits'),
//---pop end 2


                            $table .="</div>";
                            $table .="</td>";
                            $table .="</tr>";


                            $link_download =SHOPPRO_BOL_Service::getInstance()->make_file_downloadurl($value);
                        if ($link_download){
                            $table .="<tr>";
                            $table .="<td colspan=\"2\" style=\"text-align:center;\">";


                            $table .="<div class=\"ow_center\" style=\"margin:auto;text-align:center;display:block;margin-top:10px;\">";
                            $table .=$link_download;
                            $table .="</div>";

                            $table .="</td>";
                            $table .="</tr>";
                        }
    
                            $table .="</table>";

                        $table .="</div>";

                        if ($product_image){
                            $table .="<img src=\"".$product_image."\" border=\"0\" width=\"100px\" align=\"left\" style=\"margin:10px;\">";
                        }
                        $table .=stripslashes($value['entityDescription']);




                    $table .="</td>";
                    $table .="</tr>";


                        $table .="<tr>";
                        $table .="<td colspan=\"2\" style=\"height:10px;\">";
//                        $table .="&nbsp;";
                        $table .="</td>";
                        $table .="</tr>";




                                $curent++;
                                if ($curent>2){
                                    $curent=1;
                                }
                                $curent_revers++;
                                if ($curent_revers>2){
                                    $curent_revers=1;
                                }




                }//if show for user
            }//foreach



//----------------------------------------------filter start
//if (isset($_GET['page'])){
//}
// 'init','prepared','verified','delivered','processing','error'


if (isset($_GET['f'])){
    $content .="<input type=\"hidden\" name=\"f\" value=\"".$_GET['f']."\">";
}


//----------search start
$content .="<div class=\"ow_right\">";
                $content .="<form method=\"GET\" action=\"".$curent_url."ordershop/showorder\" style=\"margin:auto;padding:0;display:inline-block;\">";

                    $content .="<div class=\"ow_left\">";

if (isset($_GET['f'])){
    $content .="<input type=\"hidden\" name=\"f\" value=\"".$_GET['f']."\">";
}
if (!isset($_GET['qstat'])) $_GET['qstat']="";

                        $content .="<table>";
                        $content .="<tr>";
                        $content .="<td style=\"vertical-align: middle;\">";
                        $content .=OW::getLanguage()->text('shoppro', 'search_by_buyer').": ";
                        $content .="</td><td>";
                        $content .="<input type=\"text\" name=\"qstat\" value=\"".$_GET['qstat']."\">";
                        $content .="</td><td>";





//                $content .="<input type=\"submit\" name=\"search\" value=\"\">&nbsp;";
                    $content .="<div class=\"ow_right\">&nbsp;&nbsp;";
//            $content .="<div class=\"clearfix ow_submit ow_smallmargin\">";
//                $content .="<div class=\"ow_left\">";
                    $content .="<span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"submit\" name=\"ok\" value=\"".OW::getLanguage()->text('base', 'user_search_submit_button_label')."\" class=\"ow_ic_lens ow_positive\">
                        </span>
                    </span>";
//                $content .="</div>";
//            $content .="</div>";
                    $content .="</div>";




                        $content .="</td>";
                        $content .="</tr>";
                        $content .="</table>";

                    $content .="</div>";

                $content .="</form>";

$content .="</div>";
                $content .="<br/>";
$content .="<br/>&nbsp;";
//----------search end

        $content .="<div class=\"clearfix ow_smallmargin\">";

                $content .="<table style=\"min-width:650px;display:table;margin:auto;margin-top:-10px;padding:0px;padding-bottom:20px;float:left;\">";
                $content .="<tr>";
                $content .="<td>";
                $content .="<b>".OW::getLanguage()->text('shoppro', 'product_filter_status').":</b>";
                $content .="</td>";

//                if (isset($_GET['f'])){
//                    if (!isset($_GET['f']) OR $_GET['f']=="all") {
//                    if ($_GET['f']=="all") {
                    if ((isset($_GET['f']) AND $_GET['f']=="all")  OR !isset($_GET['f'])) {
                        $ff="ow_ic_down_arrow";
//                        $ico="*&nbsp;";
                        $ico="<img src=\"".$pluginStaticURL2."right12.gif\" style=\"border:0;padding:0;margin:0;mrgin-left:-5px;\">";
                    }else {
                        $ff="ow_ic_files";
                        $ico="";
                    }
                    $content .="<td class=\"\" style=\"display:inline-block;\">";
                    $content .="<a class=\"ow_lbutton \" href=\"".$curent_url."ordershop/showorder?f=all".$add_fortabulr."\">".$ico.OW::getLanguage()->text('shoppro', 'product_show_all')."</a>&nbsp;";
                    $content .="</td>";
//                }

/*
    if ($value['status']=="init") $content_ststus .=OW::getLanguage()->text('shoppro', 'product_status_init');//
    else if ($value['status']=="prepared") $content_ststus .=OW::getLanguage()->text('shoppro', 'product_status_prepared');
    else if ($value['status']=="verified") $content_ststus .=OW::getLanguage()->text('shoppro', 'product_status_verified');
    else if ($value['status']=="delivered") $content_ststus .=OW::getLanguage()->text('shoppro', 'product_status_delivered');//
    else if ($value['status']=="processing") $content_ststus .=OW::getLanguage()->text('shoppro', 'product_status_processing');//
    else if ($value['status']=="error") $content_ststus .=OW::getLanguage()->text('shoppro', 'product_status_error');//
}
*/


                if (isset($_GET['f']) AND $_GET['f']=="error") {
                    $ff="ow_ic_down_arrow";
//                    $ico="*&nbsp;";
                    $ico="<img src=\"".$pluginStaticURL2."right12.gif\" style=\"border:0;padding:0;margin:0;mrgin-left:-5px;\">";
                }else { 
                    $ff="ow_ic_files";
                    $ico="";
                }
                $content .="<td class=\"\" style=\"display:inline-block;width:auto;\">";
                $content .="<a  class=\"ow_lbutton \"  href=\"".$curent_url."ordershop/showorder?f=error".$add_fortabulr."\">".$ico.OW::getLanguage()->text('shoppro', 'product_status_error')."</a>&nbsp;";
                $content .="</td>";

                if (isset($_GET['f']) AND $_GET['f']=="init") {
                    $ff="ow_ic_down_arrow";
//                    $ico="*&nbsp;";
                    $ico="<img src=\"".$pluginStaticURL2."right12.gif\" style=\"border:0;padding:0;margin:0;mrgin-left:-5px;\">";
                }else {
                    $ff="ow_ic_files";
                    $ico="";
                }
                $content .="<td class=\"\" style=\"display:inline-block;width:auto;\">";
//                $content .="<span class=\"".$ff."\" style=\"position:relative;width:16px;height:32px;display:inline-block;background-position:left bottom; background-repeat: no-repeat;border:1px solid #f00;\"></span>";
                $content .="<a class=\"ow_lbutton \" href=\"".$curent_url."ordershop/showorder?f=init".$add_fortabulr."\">";
//                $content .="<span class=\"".$ff."\" style=\"width:16px;height:32px;display:inline-block;background-position:left bottom; background-repeat: no-repeat;border:1px solid #f00;\"></span>";
                $content .=$ico.OW::getLanguage()->text('shoppro', 'product_status_init')."</a>&nbsp;";
                $content .="</td>";

//--------add start
                if ((isset($_GET['f']) AND $_GET['f']=="prepared") ) {
                    $ff="ow_ic_down_arrow";
//                    $ico="*&nbsp;";
                    $ico="<img src=\"".$pluginStaticURL2."right12.gif\" style=\"border:0;padding:0;margin:0;mrgin-left:-5px;\">";
                }else {
                    $ff="ow_ic_files";
                    $ico="";
                }
                $content .="<td class=\"\" style=\"display:inline-block;width:auto;\">";
                $content .="<a  class=\"ow_lbutton \" href=\"".$curent_url."ordershop/showorder?f=prepared".$add_fortabulr."\">".$ico.OW::getLanguage()->text('shoppro', 'product_status_prepared')."</a>&nbsp;";
                $content .="</td>";


                if ((isset($_GET['f']) AND $_GET['f']=="verified") ) {
                    $ff="ow_ic_down_arrow";
//                    $ico="*&nbsp;";
                    $ico="<img src=\"".$pluginStaticURL2."right12.gif\" style=\"border:0;padding:0;margin:0;mrgin-left:-5px;\">";
                }else {
                    $ff="ow_ic_files";
                    $ico="";
                }
                $content .="<td class=\"\" style=\"display:inline-block;width:auto;\">";
                $content .="<a  class=\"ow_lbutton \" href=\"".$curent_url."ordershop/showorder?f=verified".$add_fortabulr."\">".$ico.OW::getLanguage()->text('shoppro', 'product_status_verified')."</a>&nbsp;";
                $content .="</td>";
//---------add end




/*
                if (isset($_GET['f']) AND $_GET['f']=="prepared") $ff="ow_ic_down_arrow";
                    else  $ff="ow_ic_files";
                $content .="<td class=\"ow_add_content ".$ff." \" style=\"display:inline-block;\">";
                $content .="<a href=\"".$curent_url."ordershop/showorder?f=prepared\">prepared</a>&nbsp;";
                $content .="</td>";
                if (isset($_GET['f']) AND $_GET['f']=="verified") $ff="ow_ic_down_arrow";
                    else  $ff="ow_ic_files";
                $content .="<td class=\"ow_add_content ".$ff."\" style=\"display:inline-block;\">";
                $content .="<a href=\"".$curent_url."ordershop/showorder?f=verified\">verified</a>&nbsp;";
                $content .="</td>";
*/

//                if ((isset($_GET['f']) AND $_GET['f']=="processing") OR !isset($_GET['f']) ) {
                if ((isset($_GET['f']) AND $_GET['f']=="processing") ) {
                    $ff="ow_ic_down_arrow";
//                    $ico="*&nbsp;";
                    $ico="<img src=\"".$pluginStaticURL2."right12.gif\" style=\"border:0;padding:0;margin:0;mrgin-left:-5px;\">";
                }else {
                    $ff="ow_ic_files";
                    $ico="";
                }
                $content .="<td class=\"\" style=\"display:inline-block;width:auto;\">";
                $content .="<a  class=\"ow_lbutton \" href=\"".$curent_url."ordershop/showorder?f=processing".$add_fortabulr."\">".$ico.OW::getLanguage()->text('shoppro', 'product_status_processing')."</a>&nbsp;";
                $content .="</td>";

                if (isset($_GET['f']) AND $_GET['f']=="delivered") {
                    $ff="ow_ic_down_arrow";
//                    $ico="*&nbsp;";
                    $ico="<img src=\"".$pluginStaticURL2."right12.gif\" style=\"border:0;padding:0;margin:0;mrgin-left:-5px;\">";
                }else {
                    $ff="ow_ic_files";
                    $ico="";
                }
                $content .="<td class=\"\" style=\"display:inline-block;width:auto;\">";
                $content .="<a  class=\"ow_lbutton \" href=\"".$curent_url."ordershop/showorder?f=delivered".$add_fortabulr."\">".$ico.OW::getLanguage()->text('shoppro', 'product_status_delivered')."</a>&nbsp;";
                $content .="</td>";
/*
                $content .="<td class=\"\" style=\"display:inline-block;width:auto;\">";

                $content .="<form method=\"GET\" action=\"".$curent_url."ordershop/showorder\" style=\"margin:auto;padding:0;display:inline-block;\">";

                    $content .="<div class=\"ow_left\">";

if (isset($_GET['f'])){
    $content .="<input type=\"hidden\" name=\"f\" value=\"".$_GET['f']."\">";
}

                        $content .="<input type=\"text\" name=\"qstat\" value=\"".$_GET['qstat']."\">";
                    $content .="</div>";


//                $content .="<input type=\"submit\" name=\"search\" value=\"\">&nbsp;";
                    $content .="<div class=\"ow_right\">&nbsp;&nbsp;";
//            $content .="<div class=\"clearfix ow_submit ow_smallmargin\">";
                $content .="<div class=\"ow_left\">";
                    $content .="<span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"submit\" name=\"ok\" value=\"".OW::getLanguage()->text(OW::getLanguage()->text('base', 'user_search_submit_button_label'))."\" class=\"ow_ic_lens ow_positive\">
                        </span>
                    </span>";
                $content .="</div>";
//            $content .="</div>";
                    $content .="</div>";
                $content .="</form>";
                $content .="</td>";

                $content .="</tr>";
*/
                $content .="</table>";
    $content .="</div>";



//----------------------------------------------filter end


//$curent_url."shop?page=".$next_page.$url_pages."
//makePagination($page = 1, $totalitems, $limit = 15, $adjacents = 1, $targetpage = "/", $pagestring = "?page=")
if (!$add_paramurl) $add_paramurl="pc=1";
//                $paging=SHOPPRO_BOL_Service::getInstance()->makePagination(($curent_page+1), $all_items, OW::getConfig()->getValue('shoppro', 'mode_perpage'), 1, $curent_url."showorder?".$url_pages,"&page=");
                $paging=SHOPPRO_BOL_Service::getInstance()->makePagination(($curent_page+1), $all_items, OW::getConfig()->getValue('shoppro', 'mode_perpage'), 1, $curent_url."ordershop/showorder?".$add_paramurl,"&page=");

            if ($table){
                $content .="<div id=\"shop_overlay\" class=\"shop_dialog_overlay\"></div>";
//----paging param start B
//                $paging=$this->pagination_status($curent_page,$prev_page,($curent_page+1),"showorder",$add_paramurl);
                $content .=$paging;
//----paging param end B
                $content .="<table style=\"width:100%;margin:auto;\">".$table."</table>";
//----paging param start B
                $content .=$paging;
//----paging param end B
            }else{
//----paging param start B
                if ($curent_page) {
//                    $paging=$this->pagination_status($curent_page,$prev_page,($curent_page+1),"showorder",$add_paramurl);
                    $content .=$paging;
                }
//----paging param end B
//                $content .=OW::getLanguage()->text('shoppro', 'product_table_noitems');
                $content .="<div class=\"ow_nocontent\">";
                $content .=OW::getLanguage()->text('shoppro', 'product_table_noitems');
                $content .="</div>";
            }
$content .="<div id=\"shop_overlay\" class=\"shop_dialog_overlay\"></div>";

            
            $content_t=SHOPPRO_BOL_Service::getInstance()->make_tabs("admin",$content);

//$content .="Order";
            $this->assign('content', $content_t);
        }else{//if is admin
            OW::getApplication()->redirect($curent_url."shop");
        }
    }



    public function pagination_status($curent_page=0,$prev_page=0,$next_page=0,$module="",$url_pages=""){
        $pagination ="";


    if (isset($module)){
    $pagination .="<div class=\"clearfix\" >";

if (isset($_GET['f'])){
    $url_pages .="&f=".$_GET['f'];
}

$pagination .="<table style=\"float:right;\"  style=\"\">";
$pagination .="<tr>";
$pagination .="<td style=\"width:45px;height:20px;\">";
if ($prev_page>0){
//    $pagination .="<a style=\"width:100%;\" class=\"ow_add_content ow_alt1 ow_ic_left_arrow\" href=\"".$curent_url."shop?page=".$prev_page.$url_pages."\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_prev')."\"></a>";
//--b start
    $pagination .="<div class=\"ow_stdmargin  clearfix\"  style=\"height:15px;margin-bottom:30px;padding:0;\">";
    $pagination .="<a style=\"padding: 5px;margin:5px;width:45px;height:25px;display:inline-block;background-position: center center;\" class=\"ow_add_content ow_ic_left_arrow\" href=\"".$curent_url.$module."?page=".$prev_page.$url_pages."\" title=\"".OW::getLanguage()->text('search', 'product_table_prev')."\"></a>";
    $pagination .="</div>";
//--b end
}else{
//    $pagination .="<a style=\"width:100%;\" disabled=\"true\" class=\"ow_add_content ow_alt2 ow_ic_left_arrow\" href=\"#\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_prev')."\"></a>";
//--b start
    $pagination .="<div class=\"ow_stdmargin  clearfix\"  style=\"height:15px;margin-bottom:30px;padding:0;\">";
    $pagination .="<a style=\"padding: 5px;margin:5px;width:45px;height:25px;display:inline-block;background-position: center center;\" class=\"ow_add_content ow_ic_left_arrow ow_center\" href=\"".$curent_url.$module."?page=0".$url_pages."\" title=\"".OW::getLanguage()->text('search', 'product_table_prev')."\"></a>";
    $pagination .="</div>";
//--b end
}



$pagination .="</td>";

$pagination .="<td style=\"min-width:5px;height:20px;text-align:center;padding:0 5px 10px 5px;vertical-align: middle;\" valign=\"middle\">";
$pagination .="-".($curent_page+1)."-";
$pagination .="</td>";

$pagination .="<td style=\"width:45px;height:20px;\">";
if ($next_page>0){
//    $pagination .="<a style=\"width:100%;\" class=\"ow_add_content ow_alt1 ow_ic_right_arrow\" href=\"".$curent_url."shop?page=".$next_page.$url_pages."\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_next')."\"></a>";
//--b start
    $pagination .="<div class=\"ow_stdmargin  clearfix\" style=\"height:15px;margin-bottom:30px;padding:0;\">";
    $pagination .="<a style=\"padding: 5px;margin:5px;width:45px;height:25px;display:inline-block;background-position: center center;\" class=\"ow_add_content ow_ic_right_arrow\" href=\"".$curent_url.$module."?page=".$next_page.$url_pages."\" title=\"".OW::getLanguage()->text('search', 'product_table_next')."\"></a>";
    $pagination .="</div>";
//--b end
}else{
//    $pagination .="<a style=\"width:100%;\" class=\"ow_add_content ow_alt1 ow_ic_right_arrow\" href=\"#\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_next')."\"></a>";
//--b start
    $pagination .="<div class=\"ow_stdmargin  clearfix\"  style=\"height:15px;margin-bottom:30px;padding:0;\">";
    $pagination .="<a style=\"padding: 5px;margin:5px;width:45px;height:25px;display:inline-block;background-position: center center;\" class=\"ow_add_content ow_ic_right_arrow\" href=\"#\" title=\"".OW::getLanguage()->text('search', 'product_table_next')."\"></a>";
    $pagination .="</div>";
//--b end
}

$pagination .="</td>";
$pagination .="</tr>";
$pagination .="</table>";

    $pagination .="</div>";
        }//if $module

        return $pagination;
    }





//showbasket
    public function show_basket($params) //--------------------------for user
    {
//echo "basket";
        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();
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

$paging="";
$per_page=OW::getConfig()->getValue('shoppro', 'mode_perpage');
if (!$per_page) $per_page=20;
$add_paramurl="";
$add_fortabulr="";


        $start_form=0;
        if (isset($_GET['page'])){
            $curent_page=($_GET['page']-1);
        }else{
            $curent_page=0;
        }
if (!$curent_page) $curent_page=0;
//echo $curent_page;
        $start_form=($curent_page*$per_page);
        if (!$start_form) $start_form=0;

        $prev_page=$curent_page-1;
        if ($prev_page<0) $prev_page=0;


        $content="";
        $table="";

        if ($curent_page>0){
            $limit=" ".$start_form.",".$per_page;
        }else{
            $limit=" ".$per_page;
        }


        if ($id_user>0){

            $only_verified=" ";
//            if ($is_admin){
//                $only_verified=" ";
//            }else{
//                $only_verified=" AND ((saletable.status='verified' AND saletable.transactionUid IS NOT NULL) OR  saletable.status='init' OR  saletable.status='prepared' OR  saletable.status='processing' OR saletable.status='delivered') ";
//            }
            

            if (isset($_GET['f'])){
//'init','prepared','verified','delivered','processing','error'
/*
                if ($_GET['f']=="init") $filter=" AND saletable.status='init' ";
                else if ($_GET['f']=="error") $filter=" AND saletable.status='error' ";
                else if ($_GET['f']=="processing") $filter=" AND saletable.status='processing' ";
                else if ($_GET['f']=="delivered") $filter=" AND saletable.status='delivered' ";
                else $filter="";
*/
    if ($_GET['f']=="init") $filter=" AND saletable.status='init' ";
    else if ($_GET['f']=="all") $filter=" ";
    else if ($_GET['f']=="prepared") $filter=" AND saletable.status='prepared' ";
    else if ($_GET['f']=="verified") $filter=" AND saletable.status='verified' ";
    else if ($_GET['f']=="delivered") $filter=" AND saletable.status='delivered' ";
    else if ($_GET['f']=="processing") $filter=" AND saletable.status='processing' ";
    else if ($_GET['f']=="error") $filter=" AND saletable.status='error' ";
    else $filter=" AND saletable.status='processing' ";
            }else{
                $filter="";
            }





//---
            $query = "SELECT COUNT(*) as alli FROM " . OW_DB_PREFIX. "base_billing_sale saletable 
            LEFT JOIN " . OW_DB_PREFIX. "base_user userss ON (userss.id=saletable.userId) 
            WHERE saletable.userId='".addslashes($id_user)."' AND saletable.pluginKey='shoppro_product' ".$only_verified." ".$filter;

            $arrx = OW::getDbo()->queryForList($query);
            if (isset($arrx[0])){
                $allit=$arrx[0];
                $all_items=$allit['alli'];
            }else{
                $all_items=0;
            }
//---


            $query = "SELECT saletable.*, userss.username FROM " . OW_DB_PREFIX. "base_billing_sale saletable 
            LEFT JOIN " . OW_DB_PREFIX. "base_user userss ON (userss.id=saletable.userId) 
            WHERE saletable.userId='".addslashes($id_user)."' AND saletable.pluginKey='shoppro_product' ".$only_verified." ".$filter."  
            ORDER BY timeStamp DESC,status DESC 
            LIMIT ".$limit;

/*
            $query = "SELECT saletable.*, userss.username,saletable2.status as statusok,saletable2.id as idok FROM " . OW_DB_PREFIX. "base_billing_sale saletable 
            LEFT JOIN " . OW_DB_PREFIX. "base_user userss ON (userss.id=saletable.userId) 

            LEFT JOIN (SELECT id,status,entityId FROM " . OW_DB_PREFIX. "base_billing_sale ORDER BY entityId DESC LIMIT 1) saletable2 on (saletable2.entityId=saletable.entityId AND saletable2.id=saletable.id) 


            WHERE saletable.userId='".addslashes($id_user)."' AND saletable.pluginKey='shoppro_product' ".$only_verified." 
            GROUP BY entityId 
            ORDER BY entityId,`saletable`.`status` DESC, timeStamp DESC,status DESC 
            LIMIT ".$limit;
*/
//echo $query;exit;
            $pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();
            $pluginStaticURL =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesUrl();
            $pluginStaticDir =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesDir();

            $curent=1;
            $curent_revers=2;
            $arrx = OW::getDbo()->queryForList($query);
            foreach ( $arrx as $value ) {

                $product_image="ow_userfiles/plugins/shoppro/images/product_".$value['entityId'].".jpg";
                if (is_file("./".$product_image)){
                    $product_image=$curent_url.$product_image;
                }else{
                    $product_image="";
                }

                $button_paynow  ="<a href=\"".$curent_url."baynow/".$value['entityId']."\" alt=\"".OW::getLanguage()->text('shoppro', 'product_table_paynow')."\">";
//                $button_paynow .="<div style=\"border:1px solid #ddd;width:100px;height:40px;float:right;text-align:center;\">";
//                $button_paynow .="<div style=\"margin-top:10px;display:block;\">";
//                $button_paynow .="<b>".OW::getLanguage()->text('shoppro', 'product_table_paynow')."</b>";
//                $button_paynow .="</div>";
//                $button_paynow .="</div>";

                $button_paynow .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"button\" name=\"dosave\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_paynow')."\" class=\"ow_ic_cart ow_positive\">
                        </span>
                    </span>
                </div>
            </div>";

                $button_paynow .="</a>";


                $show_status_for_user=false;
                if ($value['status']=="verified"){
                    $color="#080";
                    $button="";
                    $show_status_for_user=true;
                }else if ($value['status']=="processing"){
//                    $color="#993300";
                    $color="#080";
                    $button="";
                    $show_status_for_user=true;
                }else if ($value['status']=="error"){
                    $color="#f00";
                    $button=$button_paynow;
                    $show_status_for_user=true;
                }else{
		    $color="#000";
                    $button="";
                    $show_status_for_user=true;
                }

                if ($show_status_for_user){



                    $table .="<tr class=\"ow_alt".$curent."\" >";
                    $table .="<th class=\"ow_alt".$curent."\" style=\"text-align:left;\">";
//                    $table .=$value['id'].")&nbsp;";
                    $table .= "<strong>".$value['entityKey']."</strong>";
                    $table .="</th>";

                    $table .="<th class=\"ow_alt".$curent."\" style=\"text-align:right;\">";
//                        $table .= "<strong>".date('d-m-Y h:i',$value['timeStamp'])."</strong>";
//                    $table .= "<strong>".date('d-m-Y',$value['timeStamp'])."</strong>";
                    $table .="<strong>".UTIL_DateTime::formatDate((int) $value['timeStamp'])."</strong>";

                    $table .="</th>";
                    $table .="</tr>";



                    $table .="<tr class=\"ow_alt".$curent."\">";
                    $table .="<td colspan=\"2\">";
//                        $table .="<div style=\"float:right;width:auto;height:100px;border:1px solid #ddd;\">";
//                        $table .="<div style=\"float:right;width:auto;height:100px;\">";
                        $table .="<div style=\"float:right;text-align:center;display:block;margin:0px;min-height:100px;\">";
/*
'init','prepared','verified','delivered','processing','error'
'init', 'przygotowany "," sprawdzone "," dostarczone "," przetwarzanie "," b��d "
*/



                            $table .="<table>";

                            $table .="<tr  class=\"ow_alt".$curent_revers."\">";
                            $table .="<td style=\"text-align:right;\">";
                            $table .="<b>".OW::getLanguage()->text('shoppro', 'product_table_username').":</b>";
                            $table .="</td>";
                            $table .="<td>";
                            $table .="<a href=\"".$curent_url."user/".$value['username']."\">";
                            $table .="&nbsp;<b>".$value['username']."</b>";
                            $table .="</a>";
                            $table .="</td>";
                            $table .="</tr>";


                            $table .="<tr  class=\"ow_alt".$curent_revers."\">";
                            $table .="<td style=\"text-align:right;\">";
                            $table .="<b>".OW::getLanguage()->text('shoppro', 'product_order_status').":</b>";
                            $table .="</td>";
                            $table .="<td>";
//                            $table .="&nbsp;<b style=\"color:".$color.";\">".$value['status']."</b>";
                            if ($value['status']=="verified" OR $value['status']=="processing"){ 
                                $table .="&nbsp;<b style=\"color:".$color.";\">OK</b>";
                            }else{
                                $table .="&nbsp;<b style=\"color:".$color.";\">".$value['status']."</b>";
                            }

                            $table .="</td>";
                            $table .="</tr>";
    
                            $table .="<tr  class=\"ow_alt".$curent_revers."\">";
                            $table .="<td style=\"text-align:right;\">";
                            $table .= "<b>".OW::getLanguage()->text('shoppro', 'product_table_price').":</b>";
                            $table .="</td>";
                            $table .="<td>";
                            $table .= "&nbsp;<b>".number_format($value['totalAmount'], 2, ',', ' ')."</b> ".$value['currency'];
                            $table .="</td>";
                            $table .="</tr>";





                            $table .="<tr  class=\"ow_alt".$curent_revers."\">";
                            $table .="<td style=\"text-align:center;\" colspan=\"2\">";
                            $table .=$button;
                            $table .="</td>";
                            $table .="</tr>";

                            $link_download =SHOPPRO_BOL_Service::getInstance()->make_file_downloadurl($value);
                        if ($link_download){
                            $table .="<tr>";
                            $table .="<td colspan=\"2\" style=\"text-align:center;\">";


                            $table .="<div class=\"ow_center\" style=\"margin:auto;text-align:center;display:block;margin-top:10px;\">";
                            $table .=$link_download;
                            $table .="</div>";

                            $table .="</td>";
                            $table .="</tr>";
                        }






    
                            $table .="</table>";

                        $table .="</div>";

                        if ($product_image){
                            $table .="<img src=\"".$product_image."\" border=\"0\" width=\"100px\" align=\"left\" style=\"margin:10px;\">";
                        }
                        $table .=$value['entityDescription'];


//-----------file start
/*
                        if (OW::getConfig()->getValue('shoppro', 'mode_sellfiles')==1 AND $value['entityId']>0){

                        $table .="<div style=\"display:block;width:100%;margin:auto;\">";


                                if (!$is_admin){
                                    $add=" bs.userId='".addslashes($id_user)."' AND ";
                                    $addbs=" AND bs.userId='".addslashes($id_user)."' ";
                                }else{
                                    $add=" ";
                                    $addbs="";
                                }
//                                    LEFT JOIN " . OW_DB_PREFIX. "base_user bu ON (bu.id=pr.id_owner) 
                                $query = "SELECT pr.*,bu.username,bs.transactionUid, bs.status,bs.price as pricebs FROM " . OW_DB_PREFIX. "shoppro_products pr 
                                    LEFT JOIN " . OW_DB_PREFIX. "base_billing_sale bs ON ( bs.entityId=pr.id AND ".$add." (bs.status='processing' OR bs.status='verified') )  
                                    LEFT JOIN " . OW_DB_PREFIX. "base_user bu ON (bu.id=pr.id_owner) 
                                    WHERE pr.id='".addslashes($value['entityId'])."' ".$addbs." LIMIT 1";

                                $arrxx = OW::getDbo()->queryForList($query);
                                $valuex=$arrxx[0];

//----show download file
//echo $query;exit;
//echo $valuex['id']."--".$value['entityId'];
//exit;
                                if ($valuex['id']>0 AND $valuex['id']==$value['entityId'] AND $valuex['file_attach'] AND $valuex['username']){
//echo $valuex['id']."--".$value['entityId']."<hr>";
//echo "afdf";
                                    $hash=$valuex['file_attach'];
                                    $path_file="./ow_userfiles/plugins/shoppro/files/";
                                    $name_file="file_".$value['entityId']."_".$hash.".pack";
                                    $table .="<table>";
                                    if (is_file($path_file.$name_file)){
//$table .="IS FILE!!!";
//                                        unlink($path_file.$name_file);
                                        $protect=substr(session_id(),3,10);
                                        $table .="<tr class=\"ow_alt".$curent_revers."\" >";
                                        $table .="<td style=\"text-align:right;\">";
                                        $table .= "<b>".OW::getLanguage()->text('shoppro', 'product_table_filefordownload').":</b>";
                                        $table .="</td>";
                                        $table .="<td>";
                                        $table .= "&nbsp;";
                                        $table .="<a href=\"".$curent_url."shop/download/".$value['entityId']."/".$protect."\">";
                                        $table .= "<b style=\"color:#00f;text-decoration:underline;\">".OW::getLanguage()->text('shoppro', 'product_table_filefordownload_download')."</b>";
                                        $table .="</a>";
                                        $table .="</td>";
                                        $table .="</tr>";
                                    }else{
//$table .="NOT FILE!!!";
                                        $table .="<tr class=\"ow_alt".$curent_revers."\">";
                                        $table .="<td style=\"text-align:right;\">";
                                        $table .= "<b>".OW::getLanguage()->text('shoppro', 'product_table_filefordownload').":</b>";
                                        $table .="</td>";
                                        $table .="<td>";
                                        $table .= "&nbsp;";
                                        $table .="<a href=\"".$curent_url."user/".$valuex['username']."\">";
                                        $table .= "<b style=\"color:#00f\">".OW::getLanguage()->text('shoppro', 'product_table_filefordownload_notexist')."</b>";
                                        $table .="</a>";
                                        $table .="</td>";
                                        $table .="</tr>";
                                    }
                                    $table .="</table>";
//                                    $query = "UPDATE " . OW_DB_PREFIX. "shoppro_products SET file_attach=NULL 
//                                        WHERE id='".addslashes($params['idproduct'])."' ".$add." LIMIT 1";
//                                    $res = OW::getDbo()->query($query);
                                }
                        $table .="</div>";
                            }
*/
//-----------file end

                        $table .="</td>";
                        $table .="</tr>";



                        $table .="<tr>";
                        $table .="<td colspan=\"2\" style=\"height:10px;\">";
//                        $table .="&nbsp;";
                        $table .="</td>";
                        $table .="</tr>";




                                $curent++;
                                if ($curent>2){
                                    $curent=1;
                                }
                                $curent_revers++;
                                if ($curent_revers>2){
                                    $curent_revers=1;
                                }




                }//if show for user
    

            }//foreach



//----------------------------------------------filter start
//if (isset($_GET['page'])){
//}
// 'init','prepared','verified','delivered','processing','error'


if (isset($_GET['f'])){
    $content .="<input type=\"hidden\" name=\"f\" value=\"".$_GET['f']."\">";
}

                $content .="<table style=\"min-width:650px;display:table;margin:auto;margin-top:-10px;padding:0px;padding-bottom:20px;float:left;\">";
                $content .="<tr>";
                $content .="<td>";
                $content .="<b>".OW::getLanguage()->text('shoppro', 'product_filter_status').":</b>";
                $content .="</td>";

//                if (isset($_GET['f'])){
//                    if (!isset($_GET['f']) OR $_GET['f']=="all") {
                    if ((isset($_GET['f']) AND $_GET['f']=="all")  OR !isset($_GET['f'])) {
                        $ff="ow_ic_down_arrow";
//                        $ico="*&nbsp;";
                        $ico="<img src=\"".$pluginStaticURL2."right12.gif\" style=\"border:0;padding:0;margin:0;mrgin-left:-5px;\">";
                    }else {
                        $ff="ow_ic_files";
                        $ico="";
                    }
                    $content .="<td class=\"\" style=\"display:inline-block;\">";
                    $content .="<a class=\"ow_lbutton \" href=\"".$curent_url."basket/showbasket?f=all".$add_fortabulr."\">".$ico.OW::getLanguage()->text('shoppro', 'product_show_all')."</a>&nbsp;";
                    $content .="</td>";
//                }


                if (isset($_GET['f']) AND $_GET['f']=="error") {
                    $ff="ow_ic_down_arrow";
//                    $ico="*&nbsp;";
                    $ico="<img src=\"".$pluginStaticURL2."right12.gif\" style=\"border:0;padding:0;margin:0;mrgin-left:-5px;\">";
                }else { 
                    $ff="ow_ic_files";
                    $ico="";
                }
                $content .="<td class=\"\" style=\"display:inline-block;width:auto;\">";
                $content .="<a  class=\"ow_lbutton \"  href=\"".$curent_url."basket/showbasket?f=error".$add_fortabulr."\">".$ico."error</a>&nbsp;";
                $content .="</td>";

                if (isset($_GET['f']) AND $_GET['f']=="init") {
                    $ff="ow_ic_down_arrow";
//                    $ico="*&nbsp;";
                    $ico="<img src=\"".$pluginStaticURL2."right12.gif\" style=\"border:0;padding:0;margin:0;mrgin-left:-5px;\">";
                }else {
                    $ff="ow_ic_files";
                    $ico="";
                }
                $content .="<td class=\"\" style=\"display:inline-block;width:auto;\">";
//                $content .="<span class=\"".$ff."\" style=\"position:relative;width:16px;height:32px;display:inline-block;background-position:left bottom; background-repeat: no-repeat;border:1px solid #f00;\"></span>";
                $content .="<a class=\"ow_lbutton \" href=\"".$curent_url."basket/showbasket?f=init".$add_fortabulr."\">";
//                $content .="<span class=\"".$ff."\" style=\"width:16px;height:32px;display:inline-block;background-position:left bottom; background-repeat: no-repeat;border:1px solid #f00;\"></span>";
                $content .=$ico."init</a>&nbsp;";
                $content .="</td>";


//--------add start
                if ((isset($_GET['f']) AND $_GET['f']=="prepared") ) {
                    $ff="ow_ic_down_arrow";
//                    $ico="*&nbsp;";
                    $ico="<img src=\"".$pluginStaticURL2."right12.gif\" style=\"border:0;padding:0;margin:0;mrgin-left:-5px;\">";
                }else {
                    $ff="ow_ic_files";
                    $ico="";
                }
                $content .="<td class=\"\" style=\"display:inline-block;width:auto;\">";
                $content .="<a  class=\"ow_lbutton \" href=\"".$curent_url."basket/showbasket?f=prepared".$add_fortabulr."\">".$ico.OW::getLanguage()->text('shoppro', 'product_status_prepared')."</a>&nbsp;";
                $content .="</td>";


                if ((isset($_GET['f']) AND $_GET['f']=="verified") ) {
                    $ff="ow_ic_down_arrow";
//                    $ico="*&nbsp;";
                    $ico="<img src=\"".$pluginStaticURL2."right12.gif\" style=\"border:0;padding:0;margin:0;mrgin-left:-5px;\">";
                }else {
                    $ff="ow_ic_files";
                    $ico="";
                }
                $content .="<td class=\"\" style=\"display:inline-block;width:auto;\">";
                $content .="<a  class=\"ow_lbutton \" href=\"".$curent_url."basket/showbasket?f=verified".$add_fortabulr."\">".$ico.OW::getLanguage()->text('shoppro', 'product_status_verified')."</a>&nbsp;";
                $content .="</td>";
//---------add end

/*
                if (isset($_GET['f']) AND $_GET['f']=="prepared") $ff="ow_ic_down_arrow";
                    else  $ff="ow_ic_files";
                $content .="<td class=\"ow_add_content ".$ff." \" style=\"display:inline-block;\">";
                $content .="<a href=\"".$curent_url."ordershop/showorder?f=prepared\">prepared</a>&nbsp;";
                $content .="</td>";
                if (isset($_GET['f']) AND $_GET['f']=="verified") $ff="ow_ic_down_arrow";
                    else  $ff="ow_ic_files";
                $content .="<td class=\"ow_add_content ".$ff."\" style=\"display:inline-block;\">";
                $content .="<a href=\"".$curent_url."ordershop/showorder?f=verified\">verified</a>&nbsp;";
                $content .="</td>";
*/

                if (isset($_GET['f']) AND $_GET['f']=="processing" ) {
                    $ff="ow_ic_down_arrow";
//                    $ico="*&nbsp;";
                    $ico="<img src=\"".$pluginStaticURL2."right12.gif\" style=\"border:0;padding:0;margin:0;mrgin-left:-5px;\">";
                }else {
                    $ff="ow_ic_files";
                    $ico="";
                }
                $content .="<td class=\"\" style=\"display:inline-block;width:auto;\">";
                $content .="<a  class=\"ow_lbutton \" href=\"".$curent_url."basket/showbasket?f=processing".$add_fortabulr."\">".$ico."processing</a>&nbsp;";
                $content .="</td>";

                if (isset($_GET['f']) AND $_GET['f']=="delivered") {
                    $ff="ow_ic_down_arrow";
//                    $ico="*&nbsp;";
                    $ico="<img src=\"".$pluginStaticURL2."right12.gif\" style=\"border:0;padding:0;margin:0;mrgin-left:-5px;\">";
                }else {
                    $ff="ow_ic_files";
                    $ico="";
                }
                $content .="<td class=\"\" style=\"display:inline-block;width:auto;\">";
                $content .="<a  class=\"ow_lbutton \" href=\"".$curent_url."basket/showbasket?f=delivered".$add_fortabulr."\">".$ico."delivered</a>&nbsp;";
                $content .="</td>";
/*
                $content .="<td class=\"\" style=\"display:inline-block;width:auto;\">";

                $content .="<form method=\"GET\" action=\"".$curent_url."ordershop/showorder\" style=\"margin:auto;padding:0;display:inline-block;\">";

                    $content .="<div class=\"ow_left\">";

if (isset($_GET['f'])){
    $content .="<input type=\"hidden\" name=\"f\" value=\"".$_GET['f']."\">";
}

                        $content .="<input type=\"text\" name=\"qstat\" value=\"".$_GET['qstat']."\">";
                    $content .="</div>";


//                $content .="<input type=\"submit\" name=\"search\" value=\"\">&nbsp;";
                    $content .="<div class=\"ow_right\">&nbsp;&nbsp;";
                        $content .="<span class=\"ow_button ow_ic_lens ow_positive\">
                            <span>
                                <input type=\"submit\" value=\"".OW::getLanguage()->text('base', 'user_search_submit_button_label')."\" class=\"ow_ic_lens ow_positive\">
                            </span>
                        </span>";
                    $content .="</div>";
                $content .="</form>";
                $content .="</td>";
*/
                $content .="</tr>";

                $content .="</table><br/>&nbsp;";


//----------------------------------------------filter end


//$curent_url."shop?page=".$next_page.$url_pages."
//makePagination($page = 1, $totalitems, $limit = 15, $adjacents = 1, $targetpage = "/", $pagestring = "?page=")
if (!$add_paramurl) $add_paramurl="pc=1";
//                $paging=SHOPPRO_BOL_Service::getInstance()->makePagination(($curent_page+1), $all_items, OW::getConfig()->getValue('shoppro', 'mode_perpage'), 1, $curent_url."showorder?".$url_pages,"&page=");
//                $paging=SHOPPRO_BOL_Service::getInstance()->makePagination(($curent_page+1), $all_items, OW::getConfig()->getValue('shoppro', 'mode_perpage'), 1, $curent_url."ordershop/showorder?".$add_paramurl,"&page=");
                $paging=SHOPPRO_BOL_Service::getInstance()->makePagination(($curent_page+1), $all_items, OW::getConfig()->getValue('shoppro', 'mode_perpage'), 1, $curent_url."basket/showbasket?".$add_paramurl,"&page=");




            if ($table){
//----paging param start B
//                $paging=$this->pagination_status($curent_page,$prev_page,($curent_page+1),"showbasket",$add_paramurl);
                $content .=$paging;
//----paging param end B
                $content .="<table style=\"width:100%;margin:auto;\">".$table."</table>";
//----paging param start B
                $content .=$paging;
//----paging param end B

            }else{
//                $content .=OW::getLanguage()->text('shoppro', 'product_table_noitems');
//----paging param start B
                if ($curent_page) {
//                    $paging=$this->pagination_status($curent_page,$prev_page,($curent_page),"showbasket",$add_paramurl);
                    $content .=$paging;
                }
                $content .="<div class=\"ow_nocontent\">";
                $content .=OW::getLanguage()->text('shoppro', 'product_table_noitems');
                $content .="</div>";
                
//----paging param end B
            }
//$content .="Bascet";
            
            $content_t=SHOPPRO_BOL_Service::getInstance()->make_tabs("basket",$content);

            $this->assign('content', $content_t);
        }else{//if is user
            OW::getApplication()->redirect($curent_url."shop");
        }
    }	
	



/*
    public function show_myitems($params) //--------------------------for user - SHOW MY ITEMS
    {
//echo "basket";
        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();
                    $curent_url = 'http';
                    if (isset($_SERVER["HTTPS"])) {$curent_url .= "s";}
                    $curent_url .= "://";
                    $curent_url .= $_SERVER["SERVER_NAME"]."/";
$curent_url=OW_URL_HOME;                                        



        $content="";
        $table="";

        if ($id_user>0){

            $only_verified=" AND ((saletable.status='verified' AND saletable.transactionUid IS NOT NULL) OR  saletable.status='error' OR  saletable.status='prepared' OR  saletable.status='processing') ";

            $query = "SELECT saletable.*, userss.username FROM " . OW_DB_PREFIX. "base_billing_sale saletable 
            LEFT JOIN " . OW_DB_PREFIX. "base_user userss ON (userss.id=saletable.userId) 
            WHERE saletable.userId='".addslashes($id_user)."' AND saletable.pluginKey='shoppro_product' ".$only_verified." ORDER BY status DESC,timeStamp DESC";
//echo 	$query ;		
            $curent=1;
            $curent_revers=2;
            $arrx = OW::getDbo()->queryForList($query);
            foreach ( $arrx as $value ) {

                $product_image="ow_userfiles/plugins/shoppro/images/product_".$value['entityId'].".jpg";
                if (is_file("./".$product_image)){
                    $product_image=$curent_url.$product_image;
                }else{
                    $product_image="";
                }

                $button_paynow  ="<a href=\"".$curent_url."baynow/".$value['entityId']."\" alt=\"".OW::getLanguage()->text('shoppro', 'product_table_paynow')."\">";
                $button_paynow .="<div style=\"border:1px solid #ddd;width:100px;height:40px;float:right;text-align:center;\">";
                $button_paynow .="<div style=\"margin-top:10px;display:block;\">";
                $button_paynow .="<b>".OW::getLanguage()->text('shoppro', 'product_table_paynow')."</b>";
                $button_paynow .="</div>";
                $button_paynow .="</div>";
                $button_paynow .="</a>";


                $show_status_for_user=false;
                if ($value['status']=="verified"){
                    $color="#080";
                    $button="";
                    $show_status_for_user=true;
                }else if ($value['status']=="processing"){
//                    $color="#993300";
                    $color="#080";
                    $button="";
                    $show_status_for_user=true;
                }else if ($value['status']=="error"){
                    $color="#f00";
                    $button=$button_paynow;
                    $show_status_for_user=true;
                }else{
					$color="#000";
                    $button="";
                    $show_status_for_user=true;
                }

                if ($show_status_for_user){



                    $table .="<tr class=\"ow_alt".$curent."\" >";
                    $table .="<th class=\"ow_alt".$curent."\" style=\"text-align:left;\">";
//                    $table .=$value['id'].")&nbsp;";
                    $table .= "<strong>".$value['entityKey']."</strong>";
                    $table .="</th>";

                    $table .="<th class=\"ow_alt".$curent."\" style=\"text-align:right;\">";
//                        $table .= "<strong>".date('d-m-Y h:i',$value['timeStamp'])."</strong>";
                    $table .= "<strong>".date('d-m-Y',$value['timeStamp'])."</strong>";
                    $table .="</th>";
                    $table .="</tr>";



                    $table .="<tr class=\"ow_alt".$curent."\">";
                    $table .="<td colspan=\"2\">";
//                        $table .="<div style=\"float:right;width:auto;height:100px;border:1px solid #ddd;\">";
                        $table .="<div style=\"float:right;width:auto;height:100px;\">";



                            $table .="<table>";

                            $table .="<tr  class=\"ow_alt".$curent_revers."\">";
                            $table .="<td style=\"text-align:right;\">";
                            $table .= "<b>".OW::getLanguage()->text('shoppro', 'product_table_username').":</b>";
                            $table .="</td>";
                            $table .="<td>";
                            $table .="<a href=\"".$curent_url."user/".$value['username']."\">";
                            $table .= "&nbsp;<b>".$value['username']."</b>";
                            $table .="</a>";
                            $table .="</td>";
                            $table .="</tr>";


                            $table .="<tr  class=\"ow_alt".$curent_revers."\">";
                            $table .="<td style=\"text-align:right;\">";
                            $table .="<b>".OW::getLanguage()->text('shoppro', 'product_order_status').":</b>";
                            $table .="</td>";
                            $table .="<td>";
//                            $table .="&nbsp;<b style=\"color:".$color.";\">".$value['status']."</b>";
                            if ($value['status']=="verified" OR $value['status']=="processing"){ 
                                $table .="&nbsp;<b style=\"color:".$color.";\">OK</b>";
                            }else{
                                $table .="&nbsp;<b style=\"color:".$color.";\">".$value['status']."</b>";
                            }

                            $table .="</td>";
                            $table .="</tr>";
    
                            $table .="<tr  class=\"ow_alt".$curent_revers."\">";
                            $table .="<td style=\"text-align:right;\">";
                            $table .= "<b>".OW::getLanguage()->text('shoppro', 'product_table_price').":</b>";
                            $table .="</td>";
                            $table .="<td>";
                            $table .= "&nbsp;<b>".number_format($value['totalAmount'], 2, ',', ' ')."</b> ".$value['currency'];
                            $table .="</td>";
                            $table .="</tr>";




    
                            $table .="<tr  class=\"ow_alt".$curent_revers."\">";
                            $table .="<td style=\"text-align:center;\" colspan=\"2\">";
                            $table .=$button;
                            $table .="</td>";
                            $table .="</tr>";






    
                            $table .="</table>";

                        $table .="</div>";

                        if ($product_image){
                            $table .="<img src=\"".$product_image."\" border=\"0\" width=\"100px\" align=\"left\" style=\"margin:10px;\">";
                        }
                        $table .=$value['entityDescription'];


//-----------file start
                        if (OW::getConfig()->getValue('shoppro', 'mode_sellfiles')==1 AND $value['entityId']>0){

                        $table .="<div style=\"display:block;width:100%;margin:auto;\">";
//                                if (!$is_admin){
//                                    $add=" AND sp.id_owner='".addslashes($id_user)."' ";
//                                }else{
//                                    $add=" ";
//                                }
                                    $add=" ";

                                $query = "SELECT sp.*, bu.username FROM " . OW_DB_PREFIX. "shoppro_products sp 
                                        LEFT JOIN " . OW_DB_PREFIX. "base_user bu ON (bu.id=sp.id_owner) 
                                        WHERE sp.id='".addslashes($value['entityId'])."' ".$add." LIMIT 1";
                                $arrxx = OW::getDbo()->queryForList($query);
                                $valuex=$arrxx[0];
//echo $query;exit;
//echo $valuex['id']."--".$value['entityId'];
//exit;
                                if ($valuex['id']>0 AND $valuex['id']==$value['entityId'] AND $valuex['file_attach'] AND $valuex['username']){
//echo $valuex['id']."--".$value['entityId']."<hr>";
//echo "afdf";
                                    $hash=$valuex['file_attach'];
                                    $path_file="./ow_userfiles/plugins/shoppro/files/";
                                    $name_file="file_".$value['entityId']."_".$hash.".pack";
                                    $table .="<table>";
                                    if (is_file($path_file.$name_file)){
//$table .="IS FILE!!!";
//                                        unlink($path_file.$name_file);
                                        $protect=substr(session_id(),3,10);
                                        $table .="<tr class=\"ow_alt".$curent_revers."\" >";
                                        $table .="<td style=\"text-align:right;\">";
                                        $table .= "<b>".OW::getLanguage()->text('shoppro', 'product_table_filefordownload').":</b>";
                                        $table .="</td>";
                                        $table .="<td>";
                                        $table .= "&nbsp;";
                                        $table .="<a href=\"".$curent_url."shop/download/".$value['entityId']."/".$protect."\">";
                                        $table .= "<b style=\"color:#00f;text-decoration:underline;\">".OW::getLanguage()->text('shoppro', 'product_table_filefordownload_download')."</b>";
                                        $table .="</a>";
                                        $table .="</td>";
                                        $table .="</tr>";
                                    }else{
//$table .="NOT FILE!!!";
                                        $table .="<tr class=\"ow_alt".$curent_revers."\">";
                                        $table .="<td style=\"text-align:right;\">";
                                        $table .= "<b>".OW::getLanguage()->text('shoppro', 'product_table_filefordownload').":</b>";
                                        $table .="</td>";
                                        $table .="<td>";
                                        $table .= "&nbsp;";
                                        $table .="<a href=\"".$curent_url."user/".$valuex['username']."\">";
                                        $table .= "<b style=\"color:#00f\">".OW::getLanguage()->text('shoppro', 'product_table_filefordownload_notexist')."</b>";
                                        $table .="</a>";
                                        $table .="</td>";
                                        $table .="</tr>";
                                    }
                                    $table .="</table>";
//                                    $query = "UPDATE " . OW_DB_PREFIX. "shoppro_products SET file_attach=NULL 
//                                        WHERE id='".addslashes($params['idproduct'])."' ".$add." LIMIT 1";
//                                    $res = OW::getDbo()->query($query);
                                }
                        $table .="</div>";
                            }
//-----------file end

                        $table .="</td>";
                        $table .="</tr>";



                        $table .="<tr>";
                        $table .="<td colspan=\"2\" style=\"height:10px;\">";
//                        $table .="&nbsp;";
                        $table .="</td>";
                        $table .="</tr>";




                                $curent++;
                                if ($curent>2){
                                    $curent=1;
                                }
                                $curent_revers++;
                                if ($curent_revers>2){
                                    $curent_revers=1;
                                }




                }//if show for user
    

            }//foreach



            if ($table){
                $content .="<table style=\"width:100%;margin:auto;\">".$table."</table>";
            }else{
                $content .=OW::getLanguage()->text('shoppro', 'product_table_noitems');
            }
//$content .="Bascet";
            
            $content_t=SHOPPRO_BOL_Service::getInstance()->make_tabs("basket",$content);

            $this->assign('content', $content_t);
        }else{//if is user
            OW::getApplication()->redirect($curent_url."shop");
        }
    }	
	
*/











    




//shoppro_adm/edit/1
    public function editcategory($params) 
    {
//echo shop/editc/substr(session_id(),3,3);exit;
        $id_user = OW::getUser()->getId();//citent login user (uwner)
        $is_admin = OW::getUser()->isAdmin();
$curent_url=OW_URL_HOME;                                        
        $content="";
        if (isset($params['ss']) AND $params['ss']) $prid=$params['ss'];
            else $prid="";

        if ($prid!=substr(session_id(),3,3) OR !$is_admin){
            OW::getApplication()->redirect($curent_url."shop");
            exit;
        }


        if ($is_admin AND isset($_POST['ac']) AND $_POST['ac']=="save" AND isset($_POST['ss']) AND $_POST['ss']==substr(session_id(),2,7)){
//print_r($_POST);exit;
//---new
            $new_subcat="";
            $new_title="";
            $new_order=0;
            $new_active=0;
            if (isset($_POST['new_subcat']) AND $_POST['new_subcat']) $new_subcat=$_POST['new_subcat'];
            if (isset($_POST['new_order']) AND $_POST['new_order']) $new_order=$_POST['new_order'];
            if (!$new_order) $new_order=0;
            list($gr,$cat)=explode("_",$new_subcat);
            if (!$gr) $gr=0;
            if (!$cat) $cat=0;
            if (isset($_POST['new_title']) AND $_POST['new_title']) $new_title=$_POST['new_title'];
            if (isset($_POST['new_active']) AND $_POST['new_active']) $new_active=$_POST['new_active'];
            if ($new_active!=1) $new_active=0;


//------groups new start
            $new_cat_array=array();
            $sql = "SELECT * FROM " . OW_DB_PREFIX. "base_language ORDER BY `order` ";
            $arr = OW::getDbo()->queryForList($sql);
            $lp=0;
            $was_old_lang=0;
            $last_name="";
            $was_added=0;
            $new_id=0;
            $new_title="";
//print_r($_POST);exit;
            foreach ( $arr as $value )
            {

                if (isset($_POST['new_title'][0][$value['id']])){
                    $new_title=$_POST['new_title'][0][$value['id']];
                }
//echo $new_title;
//                $new_cat_array[]
                if (!$was_added){//-----------------------------
                if (isset($_POST['new_title'][0][$value['id']])){
                    if ($gr=="new" AND $cat=="group" AND ($new_title OR $last_name)){
                        if (!$last_name AND $new_title){
                            $last_name=$new_title;
                        }
                        $sql="INSERT INTO " . OW_DB_PREFIX. "shoppro_catgroups (
                            idc , idc2  ,   id_lang_ccat   ,     sortc  , activec, namec
                        )VALUES(
                            '','0',NULL,'".addslashes($new_order)."','".addslashes($new_active)."','".addslashes($new_title)."'
                        )";
                       $new_id=OW::getDbo()->insert($sql);                
                        $was_added=1;
//echo "GROUP: ".$sql;
                    }else if ($gr>0 AND ($new_title OR $last_name)){
                        if (!$last_name AND $new_title){
                            $last_name=$new_title;
                        }
                        $sql="INSERT INTO " . OW_DB_PREFIX. "shoppro_categories (
                            id , id2  ,   id_cgroup  ,     id_lang_cat    , sort ,   active , name
                        )VALUES(
                            '','".addslashes($cat)."','".addslashes($gr)."',NULL,'".addslashes($new_order)."','".addslashes($new_active)."','".addslashes($new_title)."'
                        )";
                        $new_id=OW::getDbo()->insert($sql);
                        $was_added=1;
//echo "CAT: ".$sql;
                    }
                }
                }//if (!$was_added){//-----------------------------
//exit;
                if ($new_id>0){
                    if ($gr=="new" AND $cat=="group" AND ($new_title OR $last_name)){
                                $sql="INSERT INTO " . OW_DB_PREFIX. "shoppro_catgroups_description (
                                    id_product_gr,id_lang_gr,description_gr
                                )VALUES(
                                    '".addslashes($new_id)."','".addslashes($value['id'])."','".addslashes($new_title)."'
                                ) ON DUPLICATE KEY UPDATE description_gr='".addslashes($new_title)."' ";
                                OW::getDbo()->insert($sql);
                    }else if ($gr>0 AND ($new_title OR $last_name)){
                                $sql="INSERT INTO " . OW_DB_PREFIX. "shoppro_categories_description (
                                    id_product_cat,id_lang_cat,description_cat
                                )VALUES(
                                    '".addslashes($new_id)."','".addslashes($value['id'])."','".addslashes($new_title)."'
                                ) ON DUPLICATE KEY UPDATE description_cat='".addslashes($new_title)."' ";
                                OW::getDbo()->insert($sql);
                    }
//echo $sql;
                }

            }//foreach
//exit;
//---groups new end
//print_r($_POST);exit;
                    $fidc=array();
                    if (isset($_POST['fidc'])) $fidc=$_POST['fidc'];
                    $factivec_tab=array();
                    $ftitlec_tab=array();
                    $forderc_tab=array();
                    $fdeletec_tab=array();
                    if (isset($_POST['factivec'])) $factivec_tab=$_POST['factivec'];
                    if (isset($_POST['ftitlec'])) $ftitlec_tab=$_POST['ftitlec'];
                    if (isset($_POST['forderc'])) $forderc_tab=$_POST['forderc'];
                    if (isset($_POST['fdeletec'])) $fdeletec_tab=$_POST['fdeletec'];
                    //----update
                    if (is_array($fidc) AND count($fidc)>0){
/*
                        for ($i=0;$i<count($fidc);$i++){
                            $cidc=$fidc[$i];
                            $namec=$ftitlec_tab[$cidc];
                            if ($namec) {
                                $act=$factivec_tab[$cidc];
                                if ($act!=1) $act=0;
                                $sort=$forderc_tab[$cidc];
                                if (!$sort>0) $sort=0;
                                $sql="UPDATE " . OW_DB_PREFIX. "shoppro_catgroups SET 
                                    sortc='".addslashes($sort)."' ,   
                                    activec='".addslashes($act)."' , 
                                    namec='".addslashes($namec)."' 
                                WHERE idc='".addslashes($cidc)."' LIMIT 1";
                                OW::getDbo()->query($sql);
                            }//if name
                        }//for
*/
//---groups update start
            $new_cat_array=array();
            $sql = "SELECT * FROM " . OW_DB_PREFIX. "base_language ORDER BY `order` ";
            $arr = OW::getDbo()->queryForList($sql);
            $lp=0;
            $was_old_lang=0;
            $last_name="";
            $first=1;
            foreach ( $arr as $value )
            {
//                $new_cat_array[]
                for ($i=0;$i<count($fidc);$i++){
                    $cidc=$fidc[$i];
//echo $cidc;
                    if (isset($_POST['ftitle_gr'][$cidc][$value['id']])){
                        $namec=$_POST['ftitle_gr'][$cidc][$value['id']];
                            if ($namec) {
                                $act=$factivec_tab[$cidc];
                                if ($act!=1) $act=0;
                                $sort=$forderc_tab[$cidc];
                                if (!$sort>0) $sort=0;

                                if ($first){
                                    $sql="UPDATE " . OW_DB_PREFIX. "shoppro_catgroups SET 
                                        sortc='".addslashes($sort)."' ,   
                                        activec='".addslashes($act)."' , 
                                        namec='".addslashes($namec)."' 
                                    WHERE idc='".addslashes($cidc)."' LIMIT 1";
                                    OW::getDbo()->query($sql);
//echo $sql;    
                                    $first=0;
                                }

                                $sql="INSERT INTO " . OW_DB_PREFIX. "shoppro_catgroups_description (
                                    id_product_gr,id_lang_gr,description_gr
                                )VALUES(
                                    '".addslashes($cidc)."','".addslashes($value['id'])."','".addslashes($namec)."'
                                ) ON DUPLICATE KEY UPDATE description_gr='".addslashes($namec)."' ";
                                OW::getDbo()->insert($sql);
//echo $sql;

                            }//if name
                        
                    }
                }//for

            }//foreach
//exit;
//---groups update end

                    }//update end

                    //---del
                    if (is_array($fdeletec_tab) AND count($fdeletec_tab)>0){
                        for ($i=0;$i<count($fdeletec_tab);$i++){
                            $delid=$fdeletec_tab[$i];
                            if ($delid>0){
                                $sql="DELETE FROM " . OW_DB_PREFIX. "shoppro_catgroups WHERE idc='".addslashes($delid)."' LIMIT 1";
                                OW::getDbo()->query($sql);

                                $sql="DELETE FROM " . OW_DB_PREFIX. "shoppro_catgroups_description WHERE id_product_gr='".addslashes($delid)."' ";
                                OW::getDbo()->query($sql);

                                //---move categories to first other start
                                $sql="SELECT * FROM " . OW_DB_PREFIX. "shoppro_catgroups ORDER BY activec DESC";
                                $arrx = OW::getDbo()->queryForList($sql);
                                if (isset($arrx[0]) AND $arrx[0]['idc']>0){
                                    $valueb=$arrx[0];
                                    $sql="UPDATE " . OW_DB_PREFIX. "shoppro_categories SET id_cgroup='".addslashes($valueb['idc'])."' WHERE id_cgroup='".addslashes($delid)."' ";
                                    OW::getDbo()->query($sql);
                                }
                                //---move categories to first other end
                            }
                        }
                    }
//---categry start
                    $fid=array();
                    if (isset($_POST['fid'])) $fid=$_POST['fid'];
                    $fgroupid_tab=array();
                    $factive_tab=array();
                    $fcat2_tab=array();
                    $ftitle_tab=array();
                    $fsort_tab=array();
                    $fdelete_tab=array();
                    if (isset($_POST['fgroupid'])) $fgroupid_tab=$_POST['fgroupid'];
                    if (isset($_POST['factive'])) $factive_tab=$_POST['factive'];
                    if (isset($_POST['fcat2'])) $fcat2_tab=$_POST['fcat2'];
                    if (isset($_POST['ftitle'])) $ftitle_tab=$_POST['ftitle'];
                    if (isset($_POST['fsort'])) $fsort_tab=$_POST['fsort'];
                    if (isset($_POST['fdelete'])) $fdelete_tab=$_POST['fdelete'];

                    //--upadte
                    if (is_array($fid) AND count($fid)>0){
/*
                        for ($i=0;$i<count($fid);$i++){
                            $mid=$fid[$i];
                            $gr=$fgroupid_tab[$mid];
                            $name=$ftitle_tab[$mid];
                            if ($mid>0 AND $gr>0 AND $name){
                                $id2=$fcat2_tab[$mid];
                                if (!$id2) $id2=0;
                                $sort=$fsort_tab[$mid];
                                if (!$sort>0) $sort=0;
                                $act=$factive_tab[$mid];
                                if ($act!=1) $act=0;
                                
                                $sql="UPDATE " . OW_DB_PREFIX. "shoppro_categories SET 
                                    id2='".addslashes($id2)."',
                                    id_cgroup='".addslashes($gr)."',
                                    sort='".addslashes($sort)."',
                                    active='".addslashes($act)."',
                                    name='".addslashes($name)."' 
                                WHERE id='".addslashes($mid)."' LIMIT 1";
//                                    id_lang_cat='".addslashes()."',
                                OW::getDbo()->query($sql);
                            }
                        }
*/

//---groups update start
            $new_cat_array=array();
            $sql = "SELECT * FROM " . OW_DB_PREFIX. "base_language ORDER BY `order` ";
            $arr = OW::getDbo()->queryForList($sql);
            $lp=0;
            $was_old_lang=0;
            $last_name="";
            $first=1;
            foreach ( $arr as $value )
            {

//                $new_cat_array[]
                for ($i=0;$i<count($fid);$i++){
                    $mid=$fid[$i];
                    if (isset($_POST['ftitle_cat'][$mid][$value['id']])){

                            $gr=$fgroupid_tab[$mid];
                            $name=$_POST['ftitle_cat'][$mid][$value['id']];
//echo "<hr>".$name."---".$mid."<br>";
                            if ($mid>0 AND $gr>0 AND $name){
                                $id2=$fcat2_tab[$mid];
                                if (!$id2) $id2=0;
                                $sort=$fsort_tab[$mid];
                                if (!$sort>0) $sort=0;
                                $act=$factive_tab[$mid];
                                if ($act!=1) $act=0;

//                                if ($first){//to nie dziala do zmainy kategorii 2014
                                    $sql="UPDATE " . OW_DB_PREFIX. "shoppro_categories SET 
                                        id2='".addslashes($id2)."',
                                        id_cgroup='".addslashes($gr)."',
                                        sort='".addslashes($sort)."',
                                        active='".addslashes($act)."',
                                        name='".addslashes($name)."' 
                                    WHERE id='".addslashes($mid)."' LIMIT 1";
//                                    id_lang_cat='".addslashes()."',
                                    OW::getDbo()->query($sql);
//echo $sql;
                                    $first=0;
//                                }
                                

                                $sql="INSERT INTO " . OW_DB_PREFIX. "shoppro_categories_description (
                                    id_product_cat,id_lang_cat,description_cat
                                )VALUES(
                                    '".addslashes($mid)."','".addslashes($value['id'])."','".addslashes($name)."'
                                ) ON DUPLICATE KEY UPDATE description_cat='".addslashes($name)."' ";
                                OW::getDbo()->insert($sql);
//echo $sql;

                            }//if name
                        
                    }
                }//for

            }//foreach
//print_r($_POST);
///exit;
//---groups update end


                    }//end cat
                    //--delete
                    if (is_array($fdelete_tab) AND count($fdelete_tab)>0){
                        for ($i=0;$i<count($fdelete_tab);$i++){
                            $delid=$fdelete_tab[$i];
                            if ($delid>0){
                                $sql="DELETE FROM " . OW_DB_PREFIX. "shoppro_categories WHERE id='".addslashes($delid)."' LIMIT 1";
                                OW::getDbo()->query($sql);

                                $sql="DELETE FROM " . OW_DB_PREFIX. "shoppro_categories_description WHERE id_product_cat='".addslashes($delid)."' ";
                                OW::getDbo()->query($sql);

                                //---move product to first other start
                                $sql="SELECT * FROM " . OW_DB_PREFIX. "shoppro_categories ORDER BY active DESC";
                                $arrx = OW::getDbo()->queryForList($sql);
                                if (isset($arrx[0]) AND $arrx[0]['id']>0){
                                    $valueb=$arrx[0];
                                    $sql="UPDATE " . OW_DB_PREFIX. "shoppro_products SET cat_id='".addslashes($valueb['id'])."' WHERE cat_id='".addslashes($delid)."' ";
                                    OW::getDbo()->query($sql);
                                }
                                //---move product to first other end
                            }
                        }
                    }

//----end category end

            OW::getApplication()->redirect($curent_url."shop/editc/".substr(session_id(),3,3));
            exit;
        }else if (isset($_POST['ac']) AND $_POST['ac']=="save"){
            OW::getApplication()->redirect($curent_url."shop/editc/".substr(session_id(),3,3));
            exit;
        }

        
        
        $content.="<form name=\"bb\" method=\"POST\" action=\"".$curent_url."shop/editc/".substr(session_id(),3,3)."\">";

            $content.="<input type=\"hidden\" name=\"ss\" value=\"".substr(session_id(),2,7)."\">";
            $content.="<input type=\"hidden\" name=\"ac\" value=\"save\">";
            $content.="<table class=\"ow_table_1 ow_form ow_stdmargin\">";


        $content.="<tr>";



            $content.="<tr>";
            $content.="<td colspan=\"5\">";
            $content.="</td>";
            $content.="</tr>";

            $content.="<tr style=\"background-color:#080;\">";
            $content.="<td colspan=\"5\">";
            $content.="<select name=\"new_subcat\">";
//            $content.="<option value=\"new_group\">-- [GROUP] ".OW::getLanguage()->text('shoppro', 'make_new_group')." --</option>";
            $content.="<option value=\"new_group\">[+] [NEW GROUP] </option>";
$cc=0;
if (isset($_GET['c']) AND $_GET['c']>0){
    $cc=$_GET['c'];
}
//            $content.=SHOPPRO_BOL_Service::getInstance()->make_menu_editcat($cc,$c_language);
            $content.=SHOPPRO_BOL_Service::getInstance()->make_product_edit_category(0,'editc');
            $content.="<option value=\"\" disabled></option>";
            $content.="</select>";
            $content.="</td>";
            $content.="</tr>";

            $content.="<tr style=\"background-color:#080;\">";

                    $content.="<td style=\"text-align:center;\">New";
                    $content.="</td>";

                    $content.="<td style=\"text-align:center;\">";
                    $content.="<input checked type=\"checkbox\" name=\"new_active\" value=\"1\">";
                    $content.="</td>";





                    $content.="<td class=\"ow_value\">";

//                    $content.="<input type=\"text\" name=\"new_title\" value=\"\">";
                    $content.=SHOPPRO_BOL_Service::getInstance()->edit_inputtext_lang_groups("new_title",0,0);//multilanguage


                    $content.="</td>";

                    $content.="<td class=\"ow_value\" style=\"text-align:center;\">";
                    $content.="<input type=\"text\" name=\"new_order\" value=\"0\">";
                    $content.="</td>";

                    $content.="<td style=\"text-align:right;\">---";
                    $content.="</td>";
                $content.="</tr>";



            $content.="<tr>";
            $content.="<td colspan=\"5\">";
            $content .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_right\">
                    <span class=\"ow_button\">
                        <span class=\"ow_positive\">
                            <input type=\"submit\" value=\"Save\" name=\"".OW::getLanguage()->text('shoppro', 'save')."\" class=\"ow_ic_save ow_positive\">
                        </span>
                    </span>
                </div>
            </div>";
            $content.="</td>";
            $content.="</tr>";


/*
            $content.="<tr>";
                    $content.="<th>";
                    $content.=OW::getLanguage()->text('shoppro', 'cat_active');
                    $content.="</th>";

                    $content.="<th>";
                    $content.=OW::getLanguage()->text('shoppro', 'cat_cat');
                    $content.="</th>";
                    $content.="<th>";
                    $content.=OW::getLanguage()->text('shoppro', 'cat_fsubcat');
                    $content.="</th>";

                    $content.="<th>";
                    $content.=OW::getLanguage()->text('shoppro', 'cat_title');
                    $content.="</th>";
                    $content.="<th>";
                    $content.=OW::getLanguage()->text('shoppro', 'cat_order');
                    $content.="</th>";
                    $content.="<th>";
                    $content.=OW::getLanguage()->text('shoppro', 'cat_delete');
                    $content.="</th>";
                $content.="</tr>";
*/
            
                $contentx =SHOPPRO_BOL_Service::getInstance()->make_cat_edit();
            if ($contentx){
            $content.=$contentx;
            $content.="<tr>";
            $content.="<td colspan=\"5\">";
            $content .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\"ow_positive\">
                            <input type=\"submit\" value=\"Save\" name=\"".OW::getLanguage()->text('shoppro', 'save')."\" class=\"ow_ic_save ow_positive\">
                        </span>
                    </span>
                </div>
            </div>";
            $content.="</td>";
            $content.="</tr>";
            }


            $content.="<tr>";
            $content.="<td colspan=\"5\">";
            $content.="<i>".OW::getLanguage()->text('shoppro', 'info_editcategory')."</i>";
            $content.="</td>";
            $content.="</tr>";


            $content.="</table>";

        $content.="</form>";
        $content_t=SHOPPRO_BOL_Service::getInstance()->make_tabs("editc",$content);
        $this->assign('content', $content_t);
    }





	


	
	
	
    public function doPay($price=0,$ProductKey="",$desctiptionproduct="",$packid=1)
    {

//$adapter = new BILLINGPAYPAL_CLASS_PaypalAdapter();
//$adapter ->setBusiness('zaron@grafnet.pl');

$id_user = OW::getUser()->getId();//citent login user (uwner)

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

        //---adresy url
        $gateway_url=$curent_url."billing-paypal/order";//billing module
        $gateway_key="billingpaypal";//constans from biling module
    
        //----dane do transakcji
//        $price=1;//cena
//        $packid=1;//id uslugi z bazy jakichs uslug
//        $ProductKey="nazwa_produktu_101";//$ProductKey="user_credits_pack";
//        $desctiptionproduct="Opis produktu";//description product
        $userId=$id_user;//id usera kt�ry dokonuje transakcji
//=-=--=--=-=--=-=-=-=-=-=-=-=-
/*
            $p = new paypal_class;             // initiate an instance of the class
            $p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
print_r($_POST);
print_r($_GET);
echo "ss";
exit;
*/
//------------------------start create


            $billingService = BOL_BillingService::getInstance();
        // create pack product adapter object
            //$productAdapter = new USERCREDITS_CLASS_UserCreditsPackProductAdapter();

            // sale object
            $sale = new BOL_BillingSale();
            $sale->pluginKey = 'shoppro_product';
//            $sale->entityDescription = $creditService->getPackTitle($pack->price, $pack->credits);
            $sale->entityDescription = $desctiptionproduct;
//            $sale->entityKey = $productAdapter->getProductKey();
            $sale->entityKey = $ProductKey;
//            $sale->entityId = $pack->id;
            $sale->entityId = $packid;
//            $sale->price = floatval($pack->price);
            $sale->price = floatval($price);
            $sale->period = null;
            $sale->userId = $userId ? $userId : 0;
            $sale->recurring = 0;

//            $sale->business = "gosia@a6.pl";

//            $saleId = $billingService->initSale($sale, $values['gateway']['key']);
            $saleId = $billingService->initSale($sale, $gateway_key);

            if ( $saleId ){
                // sale Id is temporarily stored in session
                $billingService->storeSaleInSession($saleId);

                //$billingService->setSessionBackUrl($productAdapter->getProductOrderUrl());
				$billingService->setSessionBackUrl(OW::getRouter()->urlForRoute('usercredits.buy_credits'));
				
				

                // redirect to gateway form page
//                OW::getApplication()->redirect($values['gateway']['url']);
                OW::getApplication()->redirect($gateway_url);
            }else{
                echo "ERROR prepere sale product.....";
            }
//------------------------end create
    }



//---------------------------------------------------------------------------------------------------paypal run (first start) START with options
    public function doPayNew($row=array(),$valueo=array())
    {
        $content="";
 $curent_full_url=$_SERVER["REQUEST_URI"];
//        $curent_url = 'http';
//        if (isset($_SERVER["HTTPS"])) {$curent_url .= "s";}
//        $curent_url .= "://";
//        $curent_url .= $_SERVER["SERVER_NAME"]."/";
$curent_url=OW_URL_HOME;                                        
$has_option=0;
$entityDescription="";
/*
$from_config=$curent_url;
$from_config=str_replace("https://","",$from_config);
$from_config=str_replace("http://","",$from_config);
$trash=explode($from_config,$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);
$url_detect=$trash[1];
//print_r($trash);
//echo $url_detect;
*/

        $id_user = OW::getUser()->getId();//citent login user (uwner)
//echo "==============".$row['id']."=========".$id_user;
//exit;

        if (
                ((isset($valueo['id']) AND $valueo['id']>0) AND ($row['id']>0 AND $id_user>0 AND $row['seler_account'] AND $valueo['price']>0 AND $row['name'] AND $valueo['currence']))
            OR 
                ((!isset($valueo['id']) OR !$valueo['id']) AND ($row['id']>0 AND $id_user>0 AND $row['seler_account'] AND $row['price']>0 AND $row['name'] AND $row['curency']))
        ){  

            if ((isset($valueo['id']) AND $valueo['id']>0) AND ($row['id']>0 AND $id_user>0 AND $row['seler_account'] AND $valueo['price']>0 AND $row['name'] AND $valueo['currence'])){
//echo "fdsFS";exit;
//echo $valueo['price'];exit;
                $has_option=1;
                $row['price']=$valueo['price'];
                $row['curency']=$valueo['currence'];
//    print_r($row);exit;
            }else{
                $has_option=0;
            }
        
//print_r($valueo);
//    print_r($row);exit;
/*
Array
(
    [id] => 2
    [cat_id] => 2
    [id_owner] => 1
    [name] => dsfsdf
    [price] => 22.00
    [active] => 1
    [file_attach] => 
    [description] => sdfsdf
    [seler_account] => 
    [seler_account_csc] => 
)
*/
            $p = new paypal_class;             // initiate an instance of the class
            $p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
//            $p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
//$row['seler_account']="test@a6.pl";

if ($has_option==1 AND isset($valueo['name']) AND $valueo['name']){ 
    $entityDescription .=mb_substr($this->remove_html(stripslashes($valueo['name'])),0,120)."; ";
}

            $entityKey=stripslashes($row['name']);//name
//            $entityDescription=mb_substr($this->remove_html($entityKey." ".stripslashes($row['description']) ),0,200);//title and desctiption
            if ($entityKey){
                $entityDescription .=mb_substr($this->remove_html($entityKey),0,255);//title and desctiption
            }else{
                $entityDescription .=mb_substr($this->remove_html($entityKey." ".stripslashes($row['description']) ),0,255);//title and desctiption
            }

//show URL in product name
//$entityDescription .=" (URL: ".$curent_url.")";


//echo $entityDescription;exit;
            $entityId=$row['id'];//id product
            $price=$row['price'];//price
            $quantity="1";//quantity
            $totalAmount=$price;//totalAmount
//            $currency="USD";//currency
            $currency=stripslashes($row['curency']);//currency


            $this_script_shopurl =$curent_url."shop";
            $this_script =$curent_url."shopbuynow/back/";
$this_script_ipn =$curent_url."shopipn/back/";
            $hash=md5(date("Y-m-d H:i:s"));
//$this->set_hash($hash);
//echo $_SESSION['last_hash']=;
$_SESSION['last_hash']=$hash;
$_SESSION['last_id_bay']=$entityId;

            $pluginKey="shoppro_product";//plugin name
            $status_start="init";//status start
            $timeStamp=strtotime(date('Y-m-d H:i:s'));

                $query = "INSERT INTO " . OW_DB_PREFIX. "base_billing_sale  (
                    id,  hash ,   pluginKey   ,    entityKey    ,   entityId  ,      entityDescription  ,     gatewayId ,      
                    userId,  transactionUid,  price ,  period , quantity        ,
                    totalAmount  ,   currency  ,      recurring  ,     status , timeStamp   ,    extraData
                )VALUES(
                    '','".addslashes($hash)."','".addslashes($pluginKey)."','".addslashes($entityKey)."','".addslashes($entityId)."','".addslashes($entityDescription)."','2',
                    '".addslashes($id_user)."',NULL,'".addslashes($price)."',NULL,'".addslashes($quantity)."',
                    '".addslashes($totalAmount)."','".addslashes($currency)."','0','".addslashes($status_start)."','".addslashes($timeStamp)."',NULL
                )";

                $last_insert_id = OW::getDbo()->insert($query);
            if ($last_insert_id>0){

                                  $p->add_field('charset', 'utf-8');
                                  $p->add_field('bn', 'PP-BuyNowBF');
                                  $p->add_field('no_note', '1');

                                  $p->add_field('business', stripslashes($row['seler_account']));
                                  $p->add_field('currency_code', $currency);//USD, GBD, PLN,...

                                  $p->add_field('shopping_url', $this_script_shopurl);
                                  $p->add_field('return', $this_script.'?action=success&p='.$entityId.'&pr='.$last_insert_id.'&ss='.substr(session_id(),4,6));
                                  $p->add_field('cancel_return', $this_script.'?action=cancel&p='.$entityId.'&pr='.$last_insert_id.'&ss='.substr(session_id(),4,6));
//                  $p->add_field('notify_url', $this_script.'?action=ipn&p='.$entityId.'&pr='.$last_insert_id.'&ss='.substr(session_id(),4,6));
                  $p->add_field('notify_url', $this_script_ipn.'?action=ipn&p='.$entityId.'&pr='.$last_insert_id.'&ss='.substr(session_id(),4,6));

                                  $p->add_field('custom', $hash);

                                  $p->add_field('item_name', $entityDescription);
                                  $p->add_field('item_number', $entityId);
                                  $p->add_field('quantity', $quantity);
                                  $p->add_field('amount', $totalAmount);
/*
//----logi
$fp = fopen('LOG_SHOP_data.txt', 'a');
fwrite($fp, print_r($p,1));
fclose($fp);
*/
                                  $p->submit_paypal_post(); // submit the fields to paypal

                    exit;        
//                OW::getApplication()->redirect($curent_url."shopbuynow/proced");
//$id_user                
            }else{
                OW::getApplication()->redirect($curent_url."shopbuynow/productnotfound");
            }


        }else if (!$id_user){
//            OW::getApplication()->redirect($curent_url."sign-in?back-uri=".urlencode($curent_full_url));
            if (!$curent_full_url) $curent_full_url=$_SERVER["REQUEST_URI"];
            OW::getApplication()->redirect($curent_url."sign-in?back-uri=".$curent_full_url);
        }else{
            OW::getApplication()->redirect($curent_url."shop");
        }


        OW::getApplication()->redirect($curent_url."shop");
        exit;
    }	
//---------------------------------------------------------------------------------------------------paypal run (first start) END














    public function indexbuynow($params) //return payment
    {

        $content="";
                    $curent_url = 'http';
                    if (isset($_SERVER["HTTPS"])) {$curent_url .= "s";}
                    $curent_url .= "://";
                    $curent_url .= $_SERVER["SERVER_NAME"]."/";
$curent_url=OW_URL_HOME;                                        

//echo "ssS";exit;
        if (OW::getConfig()->getValue('shoppro', 'mode_payment')=="pay24"){//------------------------------------------pay24

$fp = fopen('LOG_SHOP_data_PAY24.PL.txt', 'a');
fwrite($fp, "\n---------PAY24.PL----\n");
fwrite($fp, print_r($p,1));
fwrite($fp, "\n");
fwrite($fp, print_r($_POST,1));
fwrite($fp, "\n");
fwrite($fp, print_r($_GET,1));
fwrite($fp, "\n");
fwrite($fp, print_r($params,1));
fclose($fp);

                                            OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'TODO'));
                                            $content = OW::getLanguage()->text('shoppro', 'TODO');
                                            OW::getApplication()->redirect($curent_url."shop");

        }else if (OW::getConfig()->getValue('shoppro', 'mode_payment')=="przelewy24"){//------------------------------------------przelewy24

            if (isset($params['option'])){
                list($par,$idp_tmp)=explode("-",$params['option']);
                list($idb,$idp)=explode("_",$idp_tmp);

                $idb=($idb*1);
                $idp=($idp*1);
//                list($idp)=explode("?",$idp);

                if ($idp>0 AND $idb>0){

                    $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE active='1' AND id='".addslashes($idp)."' LIMIT 1";
                    $arrx = OW::getDbo()->queryForList($query);
                    $value=$arrx[0];
                    
                    $query = "SELECT * FROM " . OW_DB_PREFIX. "base_billing_sale WHERE id='".addslashes($idb)."' AND entityId='".addslashes($idp)."' LIMIT 1";
                    $arrz = OW::getDbo()->queryForList($query);
                    $valuez=$arrz[0];


//                    if (isset($value['id']) AND $value['id']>0 AND $value['seler_account'] AND $value['seler_account_csc']){
                    if (isset($value['id']) AND $value['id']>0 AND $value['seler_account']){
//accept-65?data=b3
//---------------------------------startA
                        if ($par=="accept"){//--------------------------------------------------------------accept
//p24_weryfikuj($p24_id_sprzedawcy, $p24_session_id, $p24_order_id, $p24_kwota="")
//                             Przelewy24::redirectToPayment($post_array,true);
$price=$value['price'];
//$price=str_replace(".","",$price);
//$price=str_replace(",","",$price);
$price=$price*100;          

$p_hash=md5(substr(session_id(),2,6).'-'.$value['id_owner'].'-'.$valuez['userId']);       


/*           
$p24_id_sprzedawcy=$value['seler_account'];
//$p24_session_id=substr(session_id(),2,6).'-'.$last_insert_id.'-'.$value['id_owner'].'-'.$id_user.'|'.time(),//$opistr,//$sid,
$p24_session_id=$p_hash;
$p24_order_id=$valuez['id'];
$p24_kwota=$price;
*/

$p24_id_sprzedawcy=$value['seler_account'];
//$p24_session_id=substr(session_id(),2,6).'-'.$last_insert_id.'-'.$value['id_owner'].'-'.$id_user.'|'.time(),//$opistr,//$sid,
$p24_session_id=$_POST['p24_session_id'];
$p24_order_id=$_POST['p24_order_id'];
$p24_kwota=$price;

                            $resultpay= Przelewy24::p24_weryfikuj($p24_id_sprzedawcy, $p24_session_id, $p24_order_id, $p24_kwota);

                            if($resultpay[0] == "TRUE") {
                              // transakcja prawidłowa
                                            $timeStamp=strtotime(date('Y-m-d H:i:s'));
                                            $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                                            timeStamp='".addslashes($timeStamp)."',
                                            status='verified' 
                                            WHERE id='".addslashes($idb)."' AND entityId='".addslashes($idp)."' AND hash='".addslashes($p_hash)."' AND status!='verified' LIMIT 1";
                                            OW::getDbo()->query($query);

                                            OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'payment_accepted_was_successful'));
                                            OW::getApplication()->redirect($curent_url."basket/showbasket");                                        
                            }else {
                              // transakcja błędna
                              // $WYNIK[1] - kod błędu
                              // $WYNIK[2] - opis
                                            $timeStamp=strtotime(date('Y-m-d H:i:s'));
                                            $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                                            timeStamp='".addslashes($timeStamp)."',
                                            status='error' 
                                            WHERE id='".addslashes($idb)."' AND entityId='".addslashes($idp)."' AND hash='".addslashes($p_hash)."' AND status!='verified' LIMIT 1";
                                            OW::getDbo()->query($query);

                                            OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'error_payment'));
                                            $content = OW::getLanguage()->text('shoppro', 'error_payment');
                                            OW::getApplication()->redirect($curent_url."shop");
                            }

                        }else if ($par=="cancel"){//--------------------------------------------------------cancel
                            if ($idb>0 AND $idp>0){
                                            $timeStamp=strtotime(date('Y-m-d H:i:s'));
                                            $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                                            timeStamp='".addslashes($timeStamp)."',
                                            status='error' 
                                            WHERE id='".addslashes($idb)."' AND entityId='".addslashes($idp)."' AND status='init' LIMIT 1";
                                            OW::getDbo()->query($query);
                            }
                            OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'payment_canceled'));
                            OW::getApplication()->redirect($curent_url."basket/showbasket");
                        }else{//----------------------------------------------------------------------------erro
                            if ($idb>0 AND $idp>0){
                                            $timeStamp=strtotime(date('Y-m-d H:i:s'));
                                            $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                                            timeStamp='".addslashes($timeStamp)."',
                                            status='error' 
                                            WHERE id='".addslashes($idb)."' AND entityId='".addslashes($idp)."' AND status='init' LIMIT 1";
                                            OW::getDbo()->query($query);
                            }
                                OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'error_payment'));
                                $content = OW::getLanguage()->text('shoppro', 'error_payment');
                                OW::getApplication()->redirect($curent_url."basket/showbasket");
                        }
//----------------------------------endA
                    }else{//if (isset($value['id']) AND $value['id']>0 AND $value['seler_account'] AND $value['seler_account_csc']){
                                OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'error_payment'));
                                $content = OW::getLanguage()->text('shoppro', 'error_payment');
                                OW::getApplication()->redirect($curent_url."basket/showbasket");
                    }
                }else {//if ($idp>0 AND $idb>0){
                                OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'error_payment'));
                                $content = OW::getLanguage()->text('shoppro', 'error_payment');
                                OW::getApplication()->redirect($curent_url."basket/showbasket");
                }

            }else{//if param corect
                                OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'error_payment'));
                                $content = OW::getLanguage()->text('shoppro', 'error_payment');
                                OW::getApplication()->redirect($curent_url."basket/showbasket");
            }
        }else if (OW::getConfig()->getValue('shoppro', 'mode_payment')=="webtopay"){//---------------------------------webtopay B) 2call back for platnośćc
/*
Status:
0 - payment not committed
1 - payment was successful
2 - payment order accepted, but still not committed
3 - additional payment information
*/

//echo "ssss";exit;

//[option] => accept-11,
            if (isset($params['option'])){
                list($par,$idp_tmp)=explode("-",$params['option']);
                list($idb,$idp)=explode("_",$idp_tmp);
                $idb=($idb*1);
                $idp=($idp*1);
//                list($idp)=explode("?",$idp);

                if ($idp>0 AND $idb>0){

                    $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE active='1' AND id='".addslashes($idp)."' LIMIT 1";
                    $arrx = OW::getDbo()->queryForList($query);
                    $value=$arrx[0];
                    
                    $query = "SELECT * FROM " . OW_DB_PREFIX. "base_billing_sale WHERE id='".addslashes($idb)."' AND entityId='".addslashes($idp)."' LIMIT 1";
                    $arrz = OW::getDbo()->queryForList($query);
                    $valuez=$arrz[0];


                    if (isset($value['id']) AND $value['id']>0 AND $value['seler_account'] AND $value['seler_account_csc']){
//accept-65?data=b3
                        if ($par=="accept"){//--------------------------------------------------------------accept
                            if (isset($_GET['data']) AND isset($_GET['ss1'])){
                                $ss1 = md5($_GET['data'] . $value['seler_account']);

                                    $params = array();
                                    parse_str(base64_decode(strtr($_GET['data'], array('-' => '+', '_' => '/'))), $params);

                                if ($_GET['ss1']==$ss1){
                                    $p_hash=$valuez['hash'];
                                    $p_transid=$valuez['id'];            
                                }else{
                                    $p_hash="";
                                    $p_transid="";
                                }


                                if ($p_hash!="" AND $p_transid>0){

                                    $confirm_data=false;
                                    if (
                                        $params['amount']==str_replace(".","",substr($valuez['totalAmount'],0,-1)) AND $params['amount']==str_replace(".","",$value['price']) AND 
                                        $params['currency']==$valuez['currency'] AND $params['currency']==$value['curency'] AND                                         
                                        $params['orderid']==$valuez['id'] AND $idb==$valuez['id'] AND 
                                        $idp==$value['id'] AND $idp==$valuez['entityId']
                                    ){
                                        $confirm_data=true;
                                    }

                                    if ($confirm_data){
                                        if ($params['status']=="0"){//0 - payment not committed
                                            OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'payment_accepted_not_committed'));
                                            OW::getApplication()->redirect($curent_url."basket/showbasket");
                                        }else if ($params['status']=="1"){//1 - payment was successful
                                            $timeStamp=strtotime(date('Y-m-d H:i:s'));
                                            $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                                            timeStamp='".addslashes($timeStamp)."',
                                            status='verified' 
                                            WHERE id='".addslashes($idb)."' AND entityId='".addslashes($idp)."' AND hash='".addslashes($p_hash)."' AND status!='verified' LIMIT 1";
                                            OW::getDbo()->query($query);

                                            OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'payment_accepted_was_successful'));
                                            OW::getApplication()->redirect($curent_url."basket/showbasket");                                        
                                        }else if ($params['status']=="2"){//2 - payment order accepted, but still not committed
                                            $timeStamp=strtotime(date('Y-m-d H:i:s'));
                                            $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                                            timeStamp='".addslashes($timeStamp)."',
                                            status='processing' 
                                            WHERE id='".addslashes($idb)."' AND entityId='".addslashes($idp)."' AND hash='".addslashes($p_hash)."' AND status!='verified' LIMIT 1";
                                            OW::getDbo()->query($query);

                                            OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'payment_accepted_but_not_committed'));
                                            OW::getApplication()->redirect($curent_url."basket/showbasket");

                                        }else if ($params['status']=="3"){//3 - additional payment information
                                            OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'payment_accepted_additional_payment_information'));
                                            OW::getApplication()->redirect($curent_url."shop");
                                        }else{
                                            $timeStamp=strtotime(date('Y-m-d H:i:s'));
                                            $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                                            timeStamp='".addslashes($timeStamp)."',
                                            status='error' 
                                            WHERE id='".addslashes($idb)."' AND entityId='".addslashes($idp)."' AND hash='".addslashes($p_hash)."' AND status!='verified' LIMIT 1";
                                            OW::getDbo()->query($query);

                                            OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'error_payment'));
                                            $content = OW::getLanguage()->text('shoppro', 'error_payment');
                                            OW::getApplication()->redirect($curent_url."shop");
                                        }
                                        OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'payment_accepted'));
                                        OW::getApplication()->redirect($curent_url."basket/showbasket");
                                    }else{
                                            $timeStamp=strtotime(date('Y-m-d H:i:s'));
                                            $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                                            timeStamp='".addslashes($timeStamp)."',
                                            status='error' 
                                            WHERE id='".addslashes($idb)."' AND entityId='".addslashes($idp)."' AND hash='".addslashes($p_hash)."' AND status!='verified' LIMIT 1";
                                            OW::getDbo()->query($query);

                                        OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'error_payment'));
                                        $content = OW::getLanguage()->text('shoppro', 'error_payment');
                                        OW::getApplication()->redirect($curent_url."basket/showbasket");

                                    }
                                }else{
                                            $timeStamp=strtotime(date('Y-m-d H:i:s'));
                                            $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                                            timeStamp='".addslashes($timeStamp)."',
                                            status='error' 
                                            WHERE id='".addslashes($idb)."' AND entityId='".addslashes($idp)."' AND hash='".addslashes($p_hash)."' AND status!='verified' LIMIT 1";
                                            OW::getDbo()->query($query);

                                    OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'error_payment'));
                                    $content = OW::getLanguage()->text('shoppro', 'error_payment');
                                    OW::getApplication()->redirect($curent_url."basket/showbasket");

                                }
                            }else{
                                            $timeStamp=strtotime(date('Y-m-d H:i:s'));
                                            $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                                            timeStamp='".addslashes($timeStamp)."',
                                            status='error' 
                                            WHERE id='".addslashes($idb)."' AND entityId='".addslashes($idp)."' AND hash='".addslashes($p_hash)."' AND status!='verified' LIMIT 1";
                                            OW::getDbo()->query($query);

                                OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'error_payment'));
                                $content = OW::getLanguage()->text('shoppro', 'error_payment');
                                OW::getApplication()->redirect($curent_url."basket/showbasket");

                            }
                        }else if ($par=="cancel"){//----------------------------------------------------------cancel

//print_r($_GET);
//print_r($_POST);
///exit;
//                            $ss1 = md5($_GET['data'].$value['seler_account']);
//                            if ($_GET['ss1']==$ss1){
/*
                            if (1==1){
                                $params = array();
                                parse_str(base64_decode(strtr($_GET['data'], array('-' => '+', '_' => '/'))), $params);
//us    e $params
//----aaastart

$p_hash=$valuez['hash'];
$p_transid=$valuez['id'];
$confirm_data=false;
                                if ($p_hash!="" AND $p_transid>0){
                                    if (
                                        $params['amount']==str_replace(".","",$valuez['totalAmount']) AND $params['amount']==str_replace(".","",$value['price']) AND 
                                        $params['currency']==$valuez['currency'] AND $params['currency']==$value['curency'] AND                                         
                                        $params['orderid']==$valuez['id'] AND $idb==$valuez['id'] AND 
                                        $idp==$value['id'] AND $idp==$valuez['entityId']
                                    ){
                                        $confirm_data=true;
                                    }


////'init','prepared','verified','delivered','processing','error'
                                    if ($confirm_data){
                                            $timeStamp=strtotime(date('Y-m-d H:i:s'));
                                            $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                                            timeStamp='".addslashes($timeStamp)."',
                                            status='error' 
                                            WHERE id='".addslashes($idb)."' AND entityId='".addslashes($idp)."' AND hash='".addslashes($p_hash)."' AND status!='verified' LIMIT 1";
                                            OW::getDbo()->query($query);
                                    }
                                }
//----aaaend
                            }//if ss1 == get
*/
                            if ($idb>0 AND $idp>0){
                                            $timeStamp=strtotime(date('Y-m-d H:i:s'));
                                            $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                                            timeStamp='".addslashes($timeStamp)."',
                                            status='error' 
                                            WHERE id='".addslashes($idb)."' AND entityId='".addslashes($idp)."' AND status='init' LIMIT 1";
                                            OW::getDbo()->query($query);
                            }
                            OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'payment_canceled'));
                            OW::getApplication()->redirect($curent_url."basket/showbasket");
                        }else if ($par=="callback"){//--------------------------------------------------------callback - A) tutaj zaczynam platnosc
//------check start
    $self_url =$curent_url."shopbuynow/";

$orderid=$value['id'];
$country='PL';
$price=$value['price'];
$price=str_replace(".","",$price);
$price=str_replace(",","",$price);

        $post_array=array(
            'projectid'     => $value['seler_account_csc'],
            'sign_password' => $value['seler_account']
        );


//print_r($post_array);exit;
    try {
//        $request = WebToPay::redirectToPayment($post_array);
        $response = WebToPay::checkResponse($_GET, $post_array);


            $ss1 = md5($_GET['data'].$value['seler_account']);

            if ($_GET['ss1']==$ss1){
                            $params = array();
                            parse_str(base64_decode(strtr($_GET['data'], array('-' => '+', '_' => '/'))), $params);
//use $params
    if ($params['ss1']==$ss1){
        if ($response['test'] !== '0') {
//            echo "OK";
            echo "Testing, real payment was not made";
            exit;
        }else if ($response['type'] !== 'macro'){
//            echo "OK";
            echo "Only macro payment callbacks are accepted";
            exit;
        }else{
            $orderId = $response['orderid'];
            $amount = $response['amount'];
            $currency = $response['currency'];
            if ($orderId==$orderid AND $amount==$price AND $currency==$value['curency']){
                echo "OK";
                exit;
            }else{
                echo "ERROR";
                exit;
            }
        }
    }else{
        echo "ERROR";
        exit;
    }

        }else{
            echo "ERROR";
            exit;
        }
    } catch (WebToPayException $e) {
    // handle exception
//        OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'error_payment_detect'));
        echo get_class($e) . ': ' . $e->getMessage();
        exit;
//        $content = OW::getLanguage()->text('shoppro', 'error_payment_detect');
    }

//-----check edn
//                            OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'error_payment_detect'));
                            exit;
                        }//-----------------------------------------------------------------------------------------------end else callback 
                    }else{//callback
                        OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'bay_error_item_wassaled'));
///////                        OW::getApplication()->redirect($curent_url."shop");
                        $content = OW::getLanguage()->text('shoppro', 'error_payment_detect');
                    }
                }else{//if (isset($value['id']) AND $value['id']>0){
                    OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'error_payment_detect'));
                    $content = OW::getLanguage()->text('shoppro', 'error_payment_detect');
                }
            }else{//if ($idp>0){
//                OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'error_payment_detect'));
                OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'error_payment_detect'));
//                OW::getApplication()->redirect($curent_url."shop");
                $content = OW::getLanguage()->text('shoppro', 'error_payment_detect');
            }

            $this->assign('content', $content);


        }else{//-------------------------------------------------------------------------------------------------------paypal

//echo "fdsF";exit;

$p = new paypal_class;
$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
//$p->host = 'www.paypal.com';
/*
$fp = fopen('LOG_SHOP_data.txt', 'a');
fwrite($fp, "\n---------pppppppppppppppppppppp----\n");
fwrite($fp, print_r($p,1));
fwrite($fp, "\n");
fwrite($fp, print_r($_POST,1));
fwrite($fp, "\n");
fwrite($fp, print_r($_GET,1));
fclose($fp);
*/


//        $content="oo";
// echo "sdgsdG";
//exit;
//        $content .=print_r($_POST,1);
//        $content .=print_r($_GET,1);
//        $content .=print_r($params,1);
//        $content .=print_r($_SESSION,1);

//if (isset($_GET['p']) AND $_GET['p']==$_SESSION['last_id_bay'] AND $_SESSION['last_hash']){
if (isset($_GET['p']) AND $_GET['p']==$_SESSION['last_id_bay'] AND $_GET['ss']==substr(session_id(),4,6)){
    $p_hash=$_SESSION['last_hash'];
    $p_temnumber=$_SESSION['last_id_bay'];
}else{
    $p_hash="";
    $p_temnumber="";
}
$_SESSION['last_id_bay']="";
$_SESSION['last_hash']="";
//        $this->assign('content', $content);
//echo "dfsdF".$_GET['action'];exit;
//echo "fsf";exit;

                        switch ($_GET['action']) {    

case 'process':      // Process and order...

/*
$fp = fopen('LOG_SHOP_data.txt', 'a');
fwrite($fp, "\n---------PROCESS START1----\n");
fwrite($fp, "IPN: ".$p->validate_ipn());
fwrite($fp, "\n---------PROCESS START2----\n");
fwrite($fp, print_r($_POST,1));
fwrite($fp, "\n");
fwrite($fp, print_r($_GET,1));
fwrite($fp, "\n---------PROCESS END----\n");
fclose($fp);
*/

/*
$fp = fopen('LOG_SHOP_data.txt', 'a');
fwrite($fp, "\n---------back:---PROCCES----\n");
fwrite($fp, print_r($_POST,1));
fwrite($fp, "\n");
fwrite($fp, print_r($_GET,1));
fclose($fp);
*/    
//---add transactionUid='".addslashes($p_transid)."',

//----add transactionUid strat
//        $p_hash=$_POST['custom'];
//        $p_transid=$_POST['txn_id'];
//        $p_temnumber=$_POST['item_number'];
        if (isset($_POST['custom'])) $p_hash=$_POST['custom'];
            else $p_hash="";
        if (isset($_POST['txn_id'])) $p_transid=$_POST['txn_id'];
            else $p_transid="";
        if (isset($_POST['item_number'])) $p_temnumber=$_POST['item_number'];
            else $p_temnumber="";


        if ($p_hash!="" AND $p_temnumber>0 AND $p_transid){
//            $timeStamp=strtotime(date('Y-m-d H:i:s'));
            $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
            transactionUid='".addslashes($p_transid)."', 
            status='processing' 
            WHERE hash='".addslashes($p_hash)."' AND entityId='".addslashes($p_temnumber)."' AND (transactionUid IS NULL OR !transactionUid) LIMIT 1";
            $arr = OW::getDbo()->query($query);                    
        }else if ($p_hash!="" AND $p_temnumber>0){
//            $timeStamp=strtotime(date('Y-m-d H:i:s'));
            $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
            status='processing' 
            WHERE hash='".addslashes($p_hash)."' AND entityId='".addslashes($p_temnumber)."' LIMIT 1";
            $arr = OW::getDbo()->query($query);                    
        }
//----add transactionUid end

break;
/*
                           case 'process':      // Process and order...
                            if ($last_insert_id>0){
                                  $p->add_field('charset', 'utf-8');
                                  $p->add_field('bn', 'PP-BuyNowBF');
                                  $p->add_field('no_note', '1');

                                  $p->add_field('business', 'aron@grafnet.pl');
                                  $p->add_field('currency_code', $currency);//USD, GBD

                                  $p->add_field('shopping_url', $this_script_shopurl);
                                  $p->add_field('return', $this_script.'?action=success');
                                  $p->add_field('cancel_return', $this_script.'?action=cancel');
                                  $p->add_field('notify_url', $this_script.'?action=ipn');

                                  $p->add_field('custom', $hash);

                                  $p->add_field('item_name', $entityDescription);
                                  $p->add_field('item_number', $entityId);
                                  $p->add_field('quantity', $quantity);
                                  $p->add_field('amount', $totalAmount);

                                  $p->submit_paypal_post(); // submit the fields to paypal
                            }else{
                                $this->redirect($curent_url.'pay/result/errorproduct');
                            }
//      $p->dump_fields();      // for debugging, output a table of all the fields
                            
                          break;
*/
      
                          case 'success':      // Order was successful...
//echo $p_hash."--".$p_temnumber."--".print_r($_GET,1)."---".print_r($_SESSION,1);exit;   

/*
//if ($p->validate_ipn()) {
$fp = fopen('LOG_SHOP_data.txt', 'a');
fwrite($fp, "\n---------SUCCES START1----\n");
fwrite($fp, "IPN: ".$p->validate_ipn());
fwrite($fp, "\n---------SUCCES START2----\n");
fwrite($fp, print_r($_POST,1));
fwrite($fp, "\n");
fwrite($fp, print_r($_GET,1));
fwrite($fp, "\n---------SUCCES END----\n");
fclose($fp);
//}
*/

//----add transactionUid strat
//        $p_hash=$_POST['custom'];
//        $p_transid=$_POST['txn_id'];
//        $p_temnumber=$_POST['item_number'];
        if (isset($_POST['custom'])) $p_hash=$_POST['custom'];
            else $p_hash="";
        if (isset($_POST['txn_id'])) $p_transid=$_POST['txn_id'];
            else $p_transid="";
        if (isset($_POST['item_number'])) $p_temnumber=$_POST['item_number'];
            else $p_temnumber="";


        if ($p_hash!="" AND $p_temnumber>0 AND $p_transid){
//            $timeStamp=strtotime(date('Y-m-d H:i:s'));
            $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
            transactionUid='".addslashes($p_transid)."' 
            WHERE hash='".addslashes($p_hash)."' AND entityId='".addslashes($p_temnumber)."' AND (transactionUid IS NULL OR !transactionUid) LIMIT 1";
            $arr = OW::getDbo()->query($query);                    
        }
//----add transactionUid end


//$p_hash=$_POST['custom'];
//$p_transid=$_POST['txn_id'];
//$p_temnumber=$_POST['item_number'];
/*
        if (isset($_POST['custom'])) $p_hash=$_POST['custom'];
            else $p_hash="";
        if (isset($_POST['txn_id'])) $p_transid=$_POST['txn_id'];
            else $p_transid="";
        if (isset($_POST['item_number'])) $p_temnumber=$_POST['item_number'];
            else $p_temnumber="";
*/
                                if ($p_hash!="" AND $p_temnumber>0){

$timeStamp=strtotime(date('Y-m-d H:i:s'));


//---search file start
                    $new_stat="processing";
                    $query = "SELECT * FROM " . OW_DB_PREFIX. "base_billing_sale WHERE hash='".addslashes($p_hash)."' AND entityId='".addslashes($p_temnumber)."' AND status!='delivered' LIMIT 1";
                    $arrc = OW::getDbo()->queryForList($query);
                    if (isset($arrc[0])){
                        $valuec=$arrc[0];
                        if ($valuec['userId']>0){
                            $query2 = "SELECT file_attach,id,id_owner FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($p_temnumber)."' AND active='1' LIMIT 1";
                            $arrc2 = OW::getDbo()->queryForList($query2);
                            if (isset($arrc2[0])){
                                $valuec2=$arrc2[0];
                                if ($valuec2['id_owner']>0 AND $valuec['entityId']==$valuec2['id']){
                                    if (isset($valuec2['file_attach']) AND strlen($valuec2['file_attach'])>3){//-----is sale file
                                        $new_stat="delivered";
                                    }
                                }
                            }
                        }
                    }

/*
$fp = fopen('LOG_SHOP_data.txt', 'a');
fwrite($fp, "\n---------SUCCES START1----\n");
//fwrite($fp, "IPN: ".$p->validate_ipn());
fwrite($fp, "\n---------SUCCES START2----\n");
fwrite($fp, print_r($_POST,1));
fwrite($fp, "\n");
fwrite($fp, print_r($_GET,1));
fwrite($fp, "\n");
fwrite($fp, $query);
fwrite($fp, "\n");
fwrite($fp, $query2);
fwrite($fp, "\n---------SUCCES END----\n");
fclose($fp);
*/
//---search file end
                                    $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                                    timeStamp='".addslashes($timeStamp)."',
                                    status='".addslashes($new_stat)."' 
                                    WHERE hash='".addslashes($p_hash)."' AND entityId='".addslashes($p_temnumber)."' AND status!='delivered' LIMIT 1";

//echo $query;exit;
/*
$fp = fopen('LOG_SHOP_data.txt', 'a');
fwrite($fp, "\n---------back:---sussec----\n");
fwrite($fp, $query);
fwrite($fp, "\n");
fwrite($fp, print_r($_POST,1));
fwrite($fp, "\n");
fwrite($fp, print_r($_GET,1));
fclose($fp);
*/


                                    $arr = OW::getDbo()->query($query);                    
//----endil start
if (OW::getConfig()->getValue('shoppro', 'sel_notyfybyemail')==1 AND OW::getConfig()->getValue('base', 'site_email')){

                    $query = "SELECT * FROM " . OW_DB_PREFIX. "base_billing_sale WHERE hash='".addslashes($p_hash)."' AND entityId='".addslashes($p_temnumber)."' AND status!='verified' LIMIT 1";
                    $arrc = OW::getDbo()->queryForList($query);
                    if (isset($arrc[0])){
                        $valuec=$arrc[0];
                        if ($valuec['userId']>0){

                            $query2 = "SELECT id_owner FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($p_temnumber)."' AND active='1' LIMIT 1";
                            $arrc2 = OW::getDbo()->queryForList($query2);
                            if (isset($arrc2[0])){
                                $valuec2=$arrc2[0];
                                if ($valuec2['id_owner']>0 AND $valuec['userId']!=$valuec2['id_owner']){

    $user = BOL_UserService::getInstance()->findUserById($valuec2['id_owner']);
    if ($user->email){
        $dname=BOL_UserService::getInstance()->getDisplayName($valuec2['id_owner']);
        $message =OW::getLanguage()->text('shoppro', 'notyfy_sel_message',array('username'=>$dname,'sitename'=>OW::getConfig()->getValue('base', 'site_name'),'siteurl'=>$curent_url.'ordershop/showorder'));
        $subject=OW::getLanguage()->text('shoppro', 'notyfy_sel_subject');
        SHOPPRO_BOL_Service::getInstance()->email_notyfication($valuec2['id_owner'],$subject,$message);
    }
                                }
                            }

                        }
                    }
}
//----endil end

//-------start
$add_to_user_for_sale=OW::getConfig()->getValue('shoppro', 'mode_membergepointsfrombaing');
if ($add_to_user_for_sale>0 AND SHOPPRO_BOL_Service::getInstance()->isplugin('usercredits')){
//echo "sdfsdfSDF";exit;
                    $query = "SELECT * FROM " . OW_DB_PREFIX. "base_billing_sale WHERE hash='".addslashes($p_hash)."' AND entityId='".addslashes($p_temnumber)."' AND status!='verified' LIMIT 1";
                    $arrc = OW::getDbo()->queryForList($query);
                    if (isset($arrc[0])){
                        $valuec=$arrc[0];
                        if ($valuec['userId']>0){
                            $query2 = "SELECT id_owner FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($p_temnumber)."' AND active='1' LIMIT 1";
                            $arrc2 = OW::getDbo()->queryForList($query2);
                            if (isset($arrc2[0])){
                                $valuec2=$arrc2[0];
                                if ($valuec2['id_owner']>0 AND $valuec['userId']!=$valuec2['id_owner']){
                                    $query = "INSERT INTO " . OW_DB_PREFIX. "usercredits_balance (id ,   userId , balance)VALUES ('','".addslashes($valuec['userId'])."','".addslashes($add_to_user_for_sale)."') 
                                    ON DUPLICATE KEY UPDATE balance=balance+".addslashes($add_to_user_for_sale); 
//                            $query = "UPDATE " . OW_DB_PREFIX. "usercredits_balance SET balance=balance+".addslashes($add_to_user_for_sale)." WHERE userId='".addslashes($valuec['userId'])."' LIMIT 1";
                                    OW::getDbo()->insert($query);
//---log credits strat
                                    $query = "INSERT INTO " . OW_DB_PREFIX. "usercredits_log (
                                        id ,     userId,  actionId     ,   amount , logTimestamp
                                    )VALUES(
                                        '','".addslashes($valuec['userId'])."','23','".addslashes($add_to_user_for_sale)."','".addslashes($timeStamp)."'
                                    )";//recive:23
                                    OW::getDbo()->insert($query);
//---log credits end

                                }
                            }
                        }
                    }
}
//-------------end


//                                $this->redirect($curent_url.'pay/result/success');
                                    $content .=  "<h3>".OW::getLanguage()->text('shoppro', 'bay_result_succesfull')."</h3>";
                                    $content .=  "<br/><a href=\"".OW_URL_HOME."basket/showbasket\">";
                                    $content .=  "<span class=\"ow_button ow_ic_back ow_ic_review\"><span><input type=\"button\" value=\"".OW::getLanguage()->text('base', 'pages_back')."\" id=\"btn-add-review\" class=\"ow_ic_back ow_ic_review\"></span></span>";
                                    $content .=  "</a>";
                                }else{
/*
$fp = fopen('LOG_SHOP_data.txt', 'a');
fwrite($fp, "\n---------back:---sussec bez chash!!!!!!!!----\n");
fwrite($fp, "hash:".$p_hash);
fwrite($fp, "\n");
fwrite($fp, "number:".$p_temnumber);
fwrite($fp, "\n");
fwrite($fp, print_r($_POST,1));
fwrite($fp, "\n");
fwrite($fp, print_r($_GET,1));
fclose($fp);
*/

//                                $cintent .="<h3>Thank you for your order.</h3>";
                                    $content .=  "<h3>".OW::getLanguage()->text('shoppro', 'bay_result_succesfull')."</h3>";
                                    $content .=  "<h3>".OW::getLanguage()->text('shoppro', 'bay_result_succes_noinform')."</h3>";
                                    $content .=  "<br/><a href=\"".OW_URL_HOME."shop\">";
                                    $content .=  "<span class=\"ow_button ow_ic_back ow_ic_review\"><span><input type=\"button\" value=\"".OW::getLanguage()->text('base', 'pages_back')."\" id=\"btn-add-review\" class=\"ow_ic_back ow_ic_review\"></span></span>";
                                    $content .=  "</a>";
                                }
      
                          break;
      
                          case 'cancel':       // Order was canceled...

//SHOPPRO_BOL_Service::getInstance()->tonotyficat($value['id_owner'],$params['idproduct'],"","shop-wasbuy","shoppro+member_was_buy_item_url","shoppro",stripslashes($value['name']),$curent_url."product/".$params['idproduct']."/zoom/product.html");

                                if ($p_hash!="" AND $p_temnumber>0){
//----add transactionUid strat
/*
        if (isset($_POST['custom'])) $p_hash=$_POST['custom'];
            else $p_hash="";
        if (isset($_POST['txn_id'])) $p_transid=$_POST['txn_id'];
            else $p_transid="";
        if (isset($_POST['item_number'])) $p_temnumber=$_POST['item_number'];
            else $p_temnumber="";
        if ($p_hash!="" AND $p_temnumber>0 AND $p_transid){
//            $timeStamp=strtotime(date('Y-m-d H:i:s'));
            $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
            transactionUid='".addslashes($p_transid)."' 
            WHERE hash='".addslashes($p_hash)."' AND entityId='".addslashes($p_temnumber)."' AND (transactionUid IS NULL OR !transactionUid) LIMIT 1";
            $arr = OW::getDbo()->query($query);                    
        }
*/
//----add transactionUid end

//$p_hash=$_POST['custom'];
//$p_transid=$_POST['txn_id'];
//$p_temnumber=$_POST['item_number'];
/*
        if (isset($_POST['custom'])) $p_hash=$_POST['custom'];
            else $p_hash="";
        if (isset($_POST['txn_id'])) $p_transid=$_POST['txn_id'];
            else $p_transid="";
        if (isset($_POST['item_number'])) $p_temnumber=$_POST['item_number'];
            else $p_temnumber="";
*/

                                    $timeStamp=strtotime(date('Y-m-d H:i:s'));
                                    $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                                    timeStamp='".addslashes($timeStamp)."',
                                    status='error' 
                                    WHERE hash='".addslashes($p_hash)."' AND entityId='".addslashes($p_temnumber)."' AND status='init'  LIMIT 1";

/*
$fp = fopen('LOG_SHOP_data.txt', 'a');
fwrite($fp, "\n---------back:---camcel----\n");
fwrite($fp,  $query);
fwrite($fp, "\n");
fwrite($fp, "number:".$p_temnumber);
fwrite($fp, "\n");
fwrite($fp, print_r($_POST,1));
fwrite($fp, "\n");
fwrite($fp, print_r($_GET,1));
fclose($fp);
*/
//echo "s--------".$query."--------s";
                                    $arr = OW::getDbo()->query($query);                    
//                                $this->redirect($curent_url.'pay/result/cancel');
//                                }else if (isset($_GET['ss']) AND $_GET['ss']==substr(session_id(),4,6) AND isset($_GET['p']) AND $_GET['p']>0 AND isset($_GET['pr']) AND $_GET['pr']>0){
                                }else if ($_GET['ss']==substr(session_id(),4,6) AND $_GET['p']>0 AND $_GET['pr']>0){
                                    $timeStamp=strtotime(date('Y-m-d H:i:s'));
                                    $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                                    timeStamp='".addslashes($timeStamp)."', 
                                    status='error' 
                                    WHERE id='".addslashes($_GET['pr'])."' AND entityId='".addslashes($_GET['p'])."' AND status='init'  LIMIT 1";
//echo $query;
                                    $arr = OW::getDbo()->query($query);
                                }

//echo $_GET['ss']."--".substr(session_id(),4,6)."--".$_GET['p']."--".$_GET['pr'];
//exit;
//                                $content .="<h3>The order was canceled.</h3>";

/*
$fp = fopen('LOG_SHOP_data.txt', 'a');
fwrite($fp, "\n---------back:---camcel BAZ HASH !!!!!!----\n");
fwrite($fp, "hash:".$p_hash);
fwrite($fp, "\n");
fwrite($fp, "number:".$p_temnumber);
fwrite($fp, "\n");
fwrite($fp, print_r($_POST,1));
fwrite($fp, "\n");
fwrite($fp, print_r($_GET,1));
fclose($fp);
*/
//echo isset($_GET['ss'])."--".substr(session_id(),4,6)."--".$_GET['ss'];
//echo isset($_GET['p'])."---".$_GET['p'];
//print_r($_POST);
//print_r($_GET);
//exit;
                                $content .=  "<h3>".OW::getLanguage()->text('shoppro', 'bay_result_canceled')."</h3>";
                                    $content .=  "<br/><a href=\"".OW_URL_HOME."shop\">";
                                    $content .=  "<span class=\"ow_button ow_ic_back ow_ic_review\"><span><input type=\"button\" value=\"".OW::getLanguage()->text('base', 'pages_back')."\" id=\"btn-add-review\" class=\"ow_ic_back ow_ic_review\"></span></span>";
                                    $content .=  "</a>";

                          break;
      
                          case 'ipn':          // Paypal is calling page for IPN validation...

/*
//echo "ddD";exit;
$fp = fopen('LOG_SHOP_data.txt', 'a');
fwrite($fp, "\n---------IPN START1----\n");
fwrite($fp, "\n---------IPN START2----\n");
fwrite($fp, print_r($_POST,1));
fwrite($fp, "\n");
fwrite($fp, print_r($_GET,1));
fwrite($fp, "\n");
fwrite($fp, print_r($_SESSION,1));
fwrite($fp, "\n---------IPN END----\n");
fclose($fp);
*/

//----add transactionUid strat
//        $p_hash=$_POST['custom'];
//        $p_transid=$_POST['txn_id'];
//        $p_temnumber=$_POST['item_number'];
        if (isset($_POST['custom'])) $p_hash=$_POST['custom'];
            else $p_hash="";
        if (isset($_POST['txn_id'])) $p_transid=$_POST['txn_id'];
            else $p_transid="";
        if (isset($_POST['item_number'])) $p_temnumber=$_POST['item_number'];
            else $p_temnumber="";

        if ($p_hash!="" AND $p_temnumber>0 AND $p_transid){
//            $timeStamp=strtotime(date('Y-m-d H:i:s'));
            $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
            transactionUid='".addslashes($p_transid)."' 
            WHERE hash='".addslashes($p_hash)."' AND entityId='".addslashes($p_temnumber)."' AND (transactionUid IS NULL OR !transactionUid) LIMIT 1";
            $arr = OW::getDbo()->query($query);                    
        }
//----add transactionUid end

$timeStamp=strtotime(date('Y-m-d H:i:s'));
//$p_hash=$_POST['custom'];
//$p_transid=$_POST['txn_id'];
//$p_temnumber=$_POST['item_number'];
/*
        if (isset($_POST['custom'])) $p_hash=$_POST['custom'];
            else $p_hash="";
        if (isset($_POST['txn_id'])) $p_transid=$_POST['txn_id'];
            else $p_transid="";
        if (isset($_POST['item_number'])) $p_temnumber=$_POST['item_number'];
            else $p_temnumber="";
*/

//$p_status=$_POST['payment_status'];

                                if ($p->validate_ipn()) {
                                    if ($p_hash!="" AND $p_temnumber>0){
                                        $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                                            timeStamp='".addslashes($timeStamp)."', 
                                            status='verified' 
                                        WHERE hash='".addslashes($p_hash)."' AND entityId='".addslashes($p_temnumber)."' AND (status='init' OR status='error') LIMIT 1";

/*
$fp = fopen('LOG_SHOP_data.txt', 'a');
fwrite($fp, "\n---------back:---IPN----\n");
fwrite($fp, $query);
fwrite($fp, "\n");
fwrite($fp, print_r($_POST,1));
fwrite($fp, "\n");
fwrite($fp, print_r($_GET,1));
fclose($fp);
*/

                                        $arr = OW::getDbo()->query($query); 
                                    }

//                                    $content .=  "<h3>An instant payment notification was successfully recieved</h3>";
                                    $content .=  "<h3>".OW::getLanguage()->text('shoppro', 'bay_result_ipn_corect')."</h3>";
                                    $content .=  "<br/><a href=\"".OW_URL_HOME."shop\">";
                                    $content .=  "<span class=\"ow_button ow_ic_back ow_ic_review\"><span><input type=\"button\" value=\"".OW::getLanguage()->text('base', 'pages_back')."\" id=\"btn-add-review\" class=\"ow_ic_back ow_ic_review\"></span></span>";
                                    $content .=  "</a>";
                                }else{

/*
$fp = fopen('LOG_SHOP_data.txt', 'a');
fwrite($fp, "\n---------back:---IPN NOT VALID----\n");
fwrite($fp, $query);
fwrite($fp, "\n");
fwrite($fp, print_r($_POST,1));
fwrite($fp, "\n");
fwrite($fp, print_r($_GET,1));
fclose($fp);
*/

                                }
exit;
                          break;
                    }// switch (

                $this->assign('content', $content);
                
//                OW::getApplication()->redirect($curent_url."shop");


        }//else paypal //---------------------------------------------------------------------------------paypal end

    }






    public function write_log($content="",$file="")
    {
        $fp = fopen('LOGS_XXX.txt', 'a');
        fwrite($fp, "\n--------------------------------------------------DATA start----------\n");
        fwrite($fp, "\n".$content."\n");
        fwrite($fp, "\n--------------------------------------------------DATA end------------\n");
        fclose($fp);
    }





    public function shopipnpaypal($params) //------------------------------------------this working now!! PAYPAL BACK VERYFY
    {
//$this->write_log('\nSTART IPN!!!!!\n');

//        $working_mode="sandbox";
        $working_mode="paypal";
        $id_user = OW::getUser()->getId();
        $curent_url=OW_URL_HOME;
        $content="";
        $timeStamp=strtotime(date('Y-m-d H:i:s'));

        if (isset($_POST['custom']) AND $_POST['custom']){
            if (isset($_POST['custom']) AND $_POST['custom'] AND isset($_POST['verify_sign']) AND $_POST['verify_sign']){
                if (isset($_POST['custom'])) $p_hash=$_POST['custom'];
                    else $p_hash="";
                if (isset($_POST['txn_id'])) $p_transid=$_POST['txn_id'];
                    else $p_transid="";
                if (isset($_POST['item_number'])) $p_temnumber=$_POST['item_number'];
                    else $p_temnumber="";

                if ($p_hash!="" AND $p_temnumber>0 AND $p_transid){
                    $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                    transactionUid='".addslashes($p_transid)."', 
                    status='processing' 
                    WHERE hash='".addslashes($p_hash)."' AND entityId='".addslashes($p_temnumber)."' AND (transactionUid IS NULL OR !transactionUid) LIMIT 1";
                    $arr = OW::getDbo()->query($query);                    
                }else if ($p_hash!="" AND $p_temnumber>0){
                    $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                    status='processing' 
                    WHERE hash='".addslashes($p_hash)."' AND entityId='".addslashes($p_temnumber)."' LIMIT 1";
                    $arr = OW::getDbo()->query($query);                    
                }
            }

//$this->write_log('\nSTART IPN!!!!!\n');
//$this->write_log(print_r($_POST,1));

            // read the post from PayPal system and add 'cmd'
            $req = 'cmd=_notify-validate';
            foreach ($_POST as $key => $value) {
                $value = urlencode(stripslashes($value));
                $req .= "&$key=$value";
            }
            // post back to PayPal system to validate
            $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
            if ($working_mode=="sandbox"){
                $header .= "Host: www.sandbox.paypal.com\r\n";
            }else{
                $header .= "Host: www.paypal.com\r\n";
            }
            $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

            if ($working_mode=="sandbox"){
                $fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 250);
            }else{
                $fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
            }

            if (!$fp) {
                    // HTTP ERROR
/*
                    $sql="UPDATE " . OW_DB_PREFIX. "cart_temp SET 
                        status_cart='http_error' 
                    WHERE verify_sign='".addslashes($_POST['custom'])."' AND id='".addslashes($_POST['invoice'])."' LIMIT 1";
                    OW::getDbo()->query($sql);
*/
            } else {
                fputs ($fp, $header . $req);
                while (!feof($fp)) {
                    $res = fgets ($fp, 1024);
                    if (strcmp ($res, "VERIFIED") == 0) {
                        // PAYMENT VALIDATED & VERIFIED!
                        $is_ok=true;

                        if (!$p_hash OR $p_hash="") $is_ok=false;
                        if (!$p_transid OR $p_transid="") $is_ok=false;
                        if (!$p_temnumber OR $p_temnumber="") $is_ok=false;
/*
                        if (!isset($PREPOST['mident']) OR !$PREPOST['mident'] OR $PREPOST['mident']=="0" OR $_POST['custom']!=$PREPOST['mident']){
                            $is_ok=false;
                        }else{
                            if (!isset($_POST['mc_currency']) OR $_POST['mc_currency']!=$PREPOST['cur']) $is_ok=false;
                            if (!isset($_POST['mc_gross']) OR $_POST['mc_gross']!=$PREPOST_DETAIL['total_amout']) $is_ok=false;
                        }
*/                    

                        if ($is_ok){//--------------------------------corect finished salle
                                    $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                                    timeStamp='".addslashes($timeStamp)."',
                                    status='delivered' 
                                    WHERE hash='".addslashes($p_hash)."' AND entityId='".addslashes($p_temnumber)."' AND status!='delivered' LIMIT 1";
                            OW::getDbo()->query($query);
//--------update other start
//----endil start
if (OW::getConfig()->getValue('shoppro', 'sel_notyfybyemail')==1 AND OW::getConfig()->getValue('base', 'site_email')){

                    $query = "SELECT * FROM " . OW_DB_PREFIX. "base_billing_sale WHERE hash='".addslashes($p_hash)."' AND entityId='".addslashes($p_temnumber)."' AND status!='verified' LIMIT 1";
                    $arrc = OW::getDbo()->queryForList($query);
                    if (isset($arrc[0])){
                        $valuec=$arrc[0];
                        if ($valuec['userId']>0){

                            $query2 = "SELECT id_owner FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($p_temnumber)."' AND active='1' LIMIT 1";
                            $arrc2 = OW::getDbo()->queryForList($query2);
                            if (isset($arrc2[0])){
                                $valuec2=$arrc2[0];
                                if ($valuec2['id_owner']>0 AND $valuec['userId']!=$valuec2['id_owner']){

    $user = BOL_UserService::getInstance()->findUserById($valuec2['id_owner']);
    if ($user->email){
        $dname=BOL_UserService::getInstance()->getDisplayName($valuec2['id_owner']);
        $message =OW::getLanguage()->text('shoppro', 'notyfy_sel_message',array('username'=>$dname,'sitename'=>OW::getConfig()->getValue('base', 'site_name'),'siteurl'=>$curent_url.'ordershop/showorder'));
        $subject=OW::getLanguage()->text('shoppro', 'notyfy_sel_subject');
        SHOPPRO_BOL_Service::getInstance()->email_notyfication($valuec2['id_owner'],$subject,$message);
    }
                                }
                            }

                        }
                    }
}
//----endil end

//-------start
$add_to_user_for_sale=OW::getConfig()->getValue('shoppro', 'mode_membergepointsfrombaing');
if ($add_to_user_for_sale>0 AND SHOPPRO_BOL_Service::getInstance()->isplugin('usercredits')){
//echo "Sdfsdfsdf";exit;
                    $query = "SELECT * FROM " . OW_DB_PREFIX. "base_billing_sale WHERE hash='".addslashes($p_hash)."' AND entityId='".addslashes($p_temnumber)."' AND status!='verified' LIMIT 1";
                    $arrc = OW::getDbo()->queryForList($query);
                    if (isset($arrc[0])){
                        $valuec=$arrc[0];
                        if ($valuec['userId']>0){
                            $query2 = "SELECT id_owner FROM " . OW_DB_PREFIX. "shoppro_products WHERE id='".addslashes($p_temnumber)."' AND active='1' LIMIT 1";
                            $arrc2 = OW::getDbo()->queryForList($query2);
                            if (isset($arrc2[0])){
                                $valuec2=$arrc2[0];
                                if ($valuec2['id_owner']>0 AND $valuec['userId']!=$valuec2['id_owner']){
                                    $query = "INSERT INTO " . OW_DB_PREFIX. "usercredits_balance (id ,   userId , balance)VALUES ('','".addslashes($valuec['userId'])."','".addslashes($add_to_user_for_sale)."') 
                                    ON DUPLICATE KEY UPDATE balance=balance+".addslashes($add_to_user_for_sale); 
//                            $query = "UPDATE " . OW_DB_PREFIX. "usercredits_balance SET balance=balance+".addslashes($add_to_user_for_sale)." WHERE userId='".addslashes($valuec['userId'])."' LIMIT 1";
                                    OW::getDbo()->insert($query);
//---log credits strat
                                    $query = "INSERT INTO " . OW_DB_PREFIX. "usercredits_log (
                                        id ,     userId,  actionId     ,   amount , logTimestamp
                                    )VALUES(
                                        '','".addslashes($valuec['userId'])."','23','".addslashes($add_to_user_for_sale)."','".addslashes($timeStamp)."'
                                    )";//recive:23
                                    OW::getDbo()->insert($query);
//---log credits end

                                }
                            }
                        }
                    }
}
//-------------end
//--------update other end

                        }else{//--------------------------------------error salle
                            $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                                    timeStamp='".addslashes($timeStamp)."',
                                    status='error' 
                                    WHERE hash='".addslashes($p_hash)."' AND entityId='".addslashes($p_temnumber)."' AND status!='delivered' LIMIT 1";
                            OW::getDbo()->query($query);
                        }
                    }else if (strcmp ($res, "INVALID") == 0) {
                        // PAYMENT INVALID & INVESTIGATE MANUALY!
                            $query = "UPDATE " . OW_DB_PREFIX. "base_billing_sale  SET 
                                    timeStamp='".addslashes($timeStamp)."',
                                    status='error' 
                                    WHERE hash='".addslashes($p_hash)."' AND entityId='".addslashes($p_temnumber)."' AND status!='delivered' LIMIT 1";
                            OW::getDbo()->query($query);
                    }
                }
                fclose ($fp);
            }
        }
        exit;
        $this->assign('content', $content);

    }


















	//--------------------------1 click byanow
    public function baynow($params) 
    { 
        $content="";
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

        if (isset($_GET['poption']) AND $_GET['poption']>0){
            $has_option=1;
            $has_option_val=$_GET['poption'];
        }else{
            $has_option=0;
            $has_option_val=0;
        }

        $id_user = OW::getUser()->getId();//citent login user (uwner)
        if ($params['idproduct']>0 AND $id_user>0){
            $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE active='1' AND id='".addslashes($params['idproduct'])."' LIMIT 1";
            $arrx = OW::getDbo()->queryForList($query);
            if (isset($arrx[0])) {
                $value=$arrx[0];
            }else {
                $value['items']=0;
                $value['id']=0;
                $value['has_options']=0;
            }

//echo "aaaaa".$value['items'];exit;
            if ($value['items']<1){
                OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'bay_error_item_wassaled'));
                OW::getApplication()->redirect($curent_url."shop");
                exit;
            }else if ($value['id']>0){

                if ($value['has_options']==1 AND $has_option==1 AND $has_option_val>0){
                    $queryo = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products_options WHERE id_product='".addslashes($params['idproduct'])."' AND id='".addslashes($has_option_val)."' AND active='1' AND (unlimited='1' OR (unlimited='0' AND items>0)) LIMIT 1";
                    $arrxo = OW::getDbo()->queryForList($queryo);
                    if (isset($arrxo[0])){
                        $valueo=$arrxo[0];
                    }else{
                        OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'bay_error_item_hasnot_options'));
                        OW::getApplication()->redirect($curent_url."shop");
                        exit;
                    }
                }else{
                    $valueo=array();
                    $valueo['id']=0;
                }

//------------------------------------------------if free product and download start
            if ($value['id']>0 AND (!$value['price'] OR $value['price']==0) AND strlen($value['file_attach'])>3 AND $value['items']>0){
                $entityKey=stripslashes($value['name']);//name
//                $entityDescription=mb_substr($this->remove_html($entityKey." ".stripslashes($value['description']) ),0,200);//title and desctiption
                if ($entityKey){
                    $entityDescription=mb_substr($this->remove_html($entityKey),0,255);//title and desctiption
                }else{
                    $entityDescription=mb_substr($this->remove_html($entityKey." ".stripslashes($value['description']) ),0,255);//title and desctiption
                }
//echo $entityDescription;exit;
                $entityId=$value['id'];//id product
                $price=$value['price'];//price
                $quantity="1";//quantity
                $totalAmount=$price;//totalAmount
//            $c        urrency="USD";//currency
                $currency=stripslashes($value['curency']);//currency


                $this_script_shopurl =$curent_url."shop";
                $this_script =$curent_url."shopbuynow/back/";

//                $hash=md5(date("Y-m-d H:i:s"));
$hash_time=time();
$hash=md5(substr(session_id(),2,6).'-'.$value['id_owner'].'-'.$id_user);
//$this->set_hash($hash);
//echo $_SESSION['last_hash']=;
$_SESSION['last_hash']=$hash;
$_SESSION['last_id_bay']=$entityId;

                $pluginKey="shoppro_product";//plugin name
//                $status_start="init";//status start
                $status_start="delivered";//status start
                $timeStamp=strtotime(date('Y-m-d H:i:s'));

                $query = "INSERT INTO " . OW_DB_PREFIX. "base_billing_sale  (
                    id,  hash ,   pluginKey   ,    entityKey    ,   entityId  ,      entityDescription  ,     gatewayId ,      
                    userId,  transactionUid,  price ,  period , quantity        ,
                    totalAmount  ,   currency  ,      recurring  ,     status , timeStamp   ,    extraData
                )VALUES(
                    '','".addslashes($hash)."','".addslashes($pluginKey)."','".addslashes($entityKey)."','".addslashes($entityId)."','".addslashes($entityDescription)."','2',
                    '".addslashes($id_user)."',NULL,'".addslashes($price)."',NULL,'".addslashes($quantity)."',
                    '".addslashes($totalAmount)."','".addslashes($currency)."','0','".addslashes($status_start)."','".addslashes($timeStamp)."',NULL
                )";

                $last_insert_id = OW::getDbo()->insert($query);
                if ($last_insert_id>0){
                    OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'bay_succes'));
                    OW::getApplication()->redirect($curent_url."basket/showbasket");
                }else{
                    OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'bay_error_whilesavingtostore'));
                    OW::getApplication()->redirect($curent_url."shop");
                }
                
            }
//------------------------------------------------if free product and download end


//---dec ilosc start
                if ($has_option==1 AND $valueo['id']>0){
                    $query2 = "UPDATE " . OW_DB_PREFIX. "shoppro_products_options SET items=items-1 WHERE id_product='".addslashes($params['idproduct'])."' AND id='".addslashes($has_option_val)."' AND unlimited='0' AND active='1' LIMIT 1";
                    $res2=OW::getDbo()->query($query2);
                }else{
                    $query2 = "UPDATE " . OW_DB_PREFIX. "shoppro_products SET items=items-1 WHERE id='".addslashes($params['idproduct'])."' LIMIT 1";
                    $res2=OW::getDbo()->query($query2);
                }
                
//                echo "---".$value['price'];exit;

SHOPPRO_BOL_Service::getInstance()->tonotyficat($value['id_owner'],$value['id'],"","shop-wasbuy","shoppro+member_was_buy_item_url","shoppro",stripslashes($value['name']),$curent_url."product/".$value['id']."/zoom/product.html");





//tonotyficat
//                                                       ($toowner,$last_id_comment,$timestamp,'status_comment','newsfeed-status_comment','newsfeed');
//                                                ($toowner=0,$idtype=0,$timestamp="",$status="status_comment",$act="newsfeed-status_comment",$plugin="newsfeed" )
//                                                    ($toowner=0,$idtype=0,$timestamp="",$status="status_comment",$act="newsfeed-status_comment",$plugin="newsfeed",$obj_title="...",$obj_url="" )
////////TODO SHOPPRO_BOL_Service::getInstance()->tonotyficat($valuep2['id_owner'],$valuep2['id'],"","shop-wasbuy","shoppro+member_was_buy_item_url","shoppro",addslashes(mb_substr(stripslashes($valuep2['name']),0,50)),$curent_url."product/".$valuep2['id']."/zoom/product.html");
//-----------email start
/*
if (OW::getConfig()->getValue('shoppro', 'sel_notyfybyemail')==1 AND OW::getConfig()->getValue('base', 'site_email')){
//        $user = BOL_UserService::getInstance()->findUserById($id_user);
        $user = BOL_UserService::getInstance()->findUserById($value['id_owner']);
        if ($user->email){
//            $dname=BOL_UserService::getInstance()->getDisplayName($id_user);
            $dname=BOL_UserService::getInstance()->getDisplayName($value['id_owner']);
            $message="";
//            $message .=OW::getLanguage()->text('shoppro', 'notyfy_sel_message',array('username'=>$dname,'sitename'=>OW::getConfig()->getValue('base', 'site_name'),'siteurl'=>$curent_url.'product/'.$params['idproduct'].'/zoom/product.html'));
            $message .=OW::getLanguage()->text('shoppro', 'notyfy_sel_message',array('username'=>$dname,'sitename'=>OW::getConfig()->getValue('base', 'site_name'),'siteurl'=>$curent_url.'ordershop/showorder'));
//            $message .="--".$user->email;

            $mail = OW::getMailer()->createMail();
            $mail->addRecipientEmail($user->email);
            $mail->setSender(OW::getConfig()->getValue('base', 'site_email'));
            $mail->setSubject(OW::getLanguage()->text('shoppro', 'notyfy_sel_subject'));
            $mail->setTextContent($message);
            OW::getMailer()->send($mail);
        }
}
*/
/*
if (OW::getConfig()->getValue('shoppro', 'sel_notyfybyemail')==1 AND OW::getConfig()->getValue('base', 'site_email')){
    $user = BOL_UserService::getInstance()->findUserById($valuep2['id_owner']);
    if ($user->email){
        $dname=BOL_UserService::getInstance()->getDisplayName($valuep2['id_owner']);
        $message =OW::getLanguage()->text('shoppro', 'notyfy_sel_message',array('username'=>$dname,'sitename'=>OW::getConfig()->getValue('base', 'site_name'),'siteurl'=>$curent_url.'ordershop/showorder'));
        $subject=OW::getLanguage()->text('shoppro', 'notyfy_sel_subject');
        SHOPPRO_BOL_Service::getInstance()->email_notyfication($valuep2['id_owner'],$subject,$message);
    }
}
*/
//----email end

//---dec ilosc end
//                $this->doPay($value['price'],stripslashes($value['name']),stripslashes($value['name'])."; ".stripslashes($value['description']),$value['id']);
//mode_payment==webtopay


                //=============================================================================================================================================================================================================
                if (OW::getConfig()->getValue('shoppro', 'mode_payment')=="pay24"){//------------------------------------------pay24
//                    $this->doPayNew($value);
                    OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'notsupporteduet'));
                    OW::getApplication()->redirect($curent_url."shop");
                //=============================================================================================================================================================================================================
                }else if (OW::getConfig()->getValue('shoppro', 'mode_payment')=="przelewy24"){//------------------------------------przelewy24.pl
//print_r($value);
//echo "sss";exit;
//print_r($value);exit;
//                    if ($value['seler_account'] AND $value['seler_account_csc']){
                    if ($value['seler_account']){
                        $self_url =$curent_url."shopbuynow/";

//----------przelewy24 start
//------A) 1start shoping start
/*
            $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE active='1' AND id='".addslashes($params['idproduct'])."' LIMIT 1";
            $arrx = OW::getDbo()->queryForList($query);
            $value=$arrx[0];
*/

            if ($value['items']<1 OR !$value['id']){
                OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'bay_error_item_wassaled'));
                OW::getApplication()->redirect($curent_url."shop");
            }else{

                $entityKey=stripslashes($value['name']);//name
//                $entityDescription=mb_substr($this->remove_html($entityKey." ".stripslashes($value['description']) ),0,200);//title and desctiption
                if ($entityKey){
                    $entityDescription=mb_substr($this->remove_html($entityKey),0,255);//title and desctiption
                }else{
                    $entityDescription=mb_substr($this->remove_html($entityKey." ".stripslashes($value['description']) ),0,255);//title and desctiption
                }
//echo $entityDescription;exit;
                $entityId=$value['id'];//id product
                $price=$value['price'];//price
                $quantity="1";//quantity
                $totalAmount=$price;//totalAmount
//            $c        urrency="USD";//currency
                $currency=stripslashes($value['curency']);//currency


                $this_script_shopurl =$curent_url."shop";
                $this_script =$curent_url."shopbuynow/back/";

//                $hash=md5(date("Y-m-d H:i:s"));
$hash_time=time();
$hash=md5(substr(session_id(),2,6).'-'.$value['id_owner'].'-'.$id_user);
//$this->set_hash($hash);
//echo $_SESSION['last_hash']=;
$_SESSION['last_hash']=$hash;
$_SESSION['last_id_bay']=$entityId;

                $pluginKey="shoppro_product";//plugin name
                $status_start="init";//status start
                $timeStamp=strtotime(date('Y-m-d H:i:s'));

                $query = "INSERT INTO " . OW_DB_PREFIX. "base_billing_sale  (
                    id,  hash ,   pluginKey   ,    entityKey    ,   entityId  ,      entityDescription  ,     gatewayId ,      
                    userId,  transactionUid,  price ,  period , quantity        ,
                    totalAmount  ,   currency  ,      recurring  ,     status , timeStamp   ,    extraData
                )VALUES(
                    '','".addslashes($hash)."','".addslashes($pluginKey)."','".addslashes($entityKey)."','".addslashes($entityId)."','".addslashes($entityDescription)."','2',
                    '".addslashes($id_user)."',NULL,'".addslashes($price)."',NULL,'".addslashes($quantity)."',
                    '".addslashes($totalAmount)."','".addslashes($currency)."','0','".addslashes($status_start)."','".addslashes($timeStamp)."',NULL
                )";

                $last_insert_id = OW::getDbo()->insert($query);
                if ($last_insert_id>0){

//---dec ilosc start
                $query2 = "UPDATE " . OW_DB_PREFIX. "shoppro_products SET items=items-1 WHERE id='".addslashes($entityId)."' LIMIT 1";
                $res2=OW::getDbo()->query($query2);


$orderid=$last_insert_id;
$country='EN';
$price=$value['price'];
//$price=str_replace(".","",$price);
//$price=str_replace(",","",$price);
$price=$price*100;
//echo $query2;exit;


$customer="Klient";
$address="a";
$address_postcode="s";
$address_city="dd";
$customer_email="test@test.pl";
//                'p24_session_id'=> substr(session_id(),2,6).'-'.$last_insert_id.'-'.$value['id_owner'].'-'.$id_user.'|'.time(),//$opistr,//$sid,
//                'p24_session_id'=> $hash.'|'.$hash_time,//$opistr,//$sid,
    $post_array=array(
                'p24_session_id'=> $hash.'|'.$hash_time,//$opistr,//$sid,
                'p24_id_sprzedawcy'=>$value['seler_account'],
                'p24_kwota'=>$price,
                'p24_opis'=> $entityDescription,
                'p24_klient'=>$customer,
                'p24_adres'=>$address,
                'p24_kod'=>$address_postcode,
                'p24_miasto'=>$address_city,
                'p24_language'=>'PL',
                'p24_kraj'=>'PL',
                'p24_email'=>$customer_email,
                'p24_return_url_ok' => $self_url.'accept-'.$orderid."_".$entityId,
                'p24_return_url_error' => $self_url.'cancel-'.$orderid."_".$entityId
        );

/*
    $post_array=array(
                'z24_id_sprzedawcy'=>'16964',
                'z24_crc'=>'b370f49b',
                'z24_return_url'=>$self_url.'accept-'.$orderid."_".$entityId,
                'z24_language'=>'PL',
                'z24_nazwa'=>$entityDescription,
                'z24_opis'=>$entityDescription,
                'z24_kwota'=>$price*100
        );
*/

//wwwwwww

$request = Przelewy24::redirectToPayment($post_array,true);
//print_r($post_array);exit;
/*
//print_r($post_array);exit;
    try {

        $request = WebToPay::redirectToPayment($post_array);
//print_r($request);
//echo $request;exit;
    } catch (WebToPayException $e) {
    // handle exception
//print_r($e);exit;
    }
*/
                }else{
                    OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'unknow_error'));
                    OW::getApplication()->redirect($curent_url."shop");
                }
            }//if found product
//------A) 1start shoping end
//---------przelewy24 end
                    }else{
//                    $this->doPayNew($value);
                        OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'notsupporteduet'));
                        OW::getApplication()->redirect($curent_url."shop");
                    }

                //=============================================================================================================================================================================================================
                }else if (OW::getConfig()->getValue('shoppro', 'mode_payment')=="webtopay"){//---------------------------------webtopay
//                    $this->doPayNew($value);

if ($value['seler_account'] AND $value['seler_account_csc']){
    $s = substr(strtolower($_SERVER['SERVER_PROTOCOL']), 0,
                strpos($_SERVER['SERVER_PROTOCOL'], '/'));

    if (!empty($_SERVER["HTTPS"])) {
        $s .= ($_SERVER["HTTPS"] == "on") ? "s" : "";
    }

    $s .= '://'.$_SERVER['HTTP_HOST'];

    if (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '80') {
        $s .= ':'.$_SERVER['SERVER_PORT'];
    }

    $s .= dirname($_SERVER['SCRIPT_NAME']);
//    $self_url =$curent_url."shopbuynow/:option";
    $self_url =$curent_url."shopbuynow/";



//------A) 1start shoping start
/*
            $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_products WHERE active='1' AND id='".addslashes($params['idproduct'])."' LIMIT 1";
            $arrx = OW::getDbo()->queryForList($query);
            $value=$arrx[0];
*/
            if ($value['items']<1 OR !$value['id']){
                OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'bay_error_item_wassaled'));
                OW::getApplication()->redirect($curent_url."shop");
            }else{

                $entityKey=stripslashes($value['name']);//name
//                $entityDescription=mb_substr($this->remove_html($entityKey." ".stripslashes($value['description']) ),0,200);//title and desctiption
                if ($entityKey){
                    $entityDescription=mb_substr($this->remove_html($entityKey),0,255);//title and desctiption
                }else{
                    $entityDescription=mb_substr($this->remove_html($entityKey." ".stripslashes($value['description']) ),0,255);//title and desctiption
                }
//echo $entityDescription;exit;
                $entityId=$value['id'];//id product
                $price=$value['price'];//price
                $quantity="1";//quantity
                $totalAmount=$price;//totalAmount
//            $c        urrency="USD";//currency
                $currency=stripslashes($value['curency']);//currency


                $this_script_shopurl =$curent_url."shop";
                $this_script =$curent_url."shopbuynow/back/";

                $hash=md5(date("Y-m-d H:i:s"));
//$this->set_hash($hash);
//echo $_SESSION['last_hash']=;
$_SESSION['last_hash']=$hash;
$_SESSION['last_id_bay']=$entityId;

                $pluginKey="shoppro_product";//plugin name
                $status_start="init";//status start
                $timeStamp=strtotime(date('Y-m-d H:i:s'));

                $query = "INSERT INTO " . OW_DB_PREFIX. "base_billing_sale  (
                    id,  hash ,   pluginKey   ,    entityKey    ,   entityId  ,      entityDescription  ,     gatewayId ,      
                    userId,  transactionUid,  price ,  period , quantity        ,
                    totalAmount  ,   currency  ,      recurring  ,     status , timeStamp   ,    extraData
                )VALUES(
                    '','".addslashes($hash)."','".addslashes($pluginKey)."','".addslashes($entityKey)."','".addslashes($entityId)."','".addslashes($entityDescription)."','2',
                    '".addslashes($id_user)."',NULL,'".addslashes($price)."',NULL,'".addslashes($quantity)."',
                    '".addslashes($totalAmount)."','".addslashes($currency)."','0','".addslashes($status_start)."','".addslashes($timeStamp)."',NULL
                )";

                $last_insert_id = OW::getDbo()->insert($query);
                if ($last_insert_id>0){

//---dec ilosc start
                $query2 = "UPDATE " . OW_DB_PREFIX. "shoppro_products SET items=items-1 WHERE id='".addslashes($entityId)."' LIMIT 1";
                $res2=OW::getDbo()->query($query2);


$orderid=$last_insert_id;
$country='EN';
$price=$value['price'];
$price=str_replace(".","",$price);
$price=str_replace(",","",$price);
//echo $query2;exit;
    $post_array=array(
            'projectid'     => $value['seler_account_csc'],
            'sign_password' => $value['seler_account'],
            'orderid'       => $orderid,
            'amount'        => $price,
            'currency'      => $value['curency'],
            'country'       => $country,
            'accepturl'     => $self_url.'accept-'.$orderid."_".$entityId,
            'cancelurl'     => $self_url.'cancel-'.$orderid."_".$entityId,
            'callbackurl'   => $self_url.'callback-'.$orderid."_".$entityId,

'version'=>'1.6',
'paytext'=>'akfsdk sdkb 3424 dsfsdlkfnsdlkf',

'p_firstname'=>'name',
'p_lastname'=>'lst name',
'p_email'=>'email',

'personcode'=>'id_user',

            'test'          => 1,
        );

//print_r($post_array);exit;
    try {

        $request = WebToPay::redirectToPayment($post_array);
//print_r($request);
//echo $request;exit;
    } catch (WebToPayException $e) {
    // handle exception
//print_r($e);exit;
    }

                }else{
                    OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'unknow_error'));
                    OW::getApplication()->redirect($curent_url."shop");
                }
            }//if found product
//------A) 1start shoping end
/*

'lang'=>'PL',
'payment'=>'',
*/




}else{

    OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'notfoundseleraccount'));
    OW::getApplication()->redirect($curent_url."shop");
}



//                    OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'notsupporteduet'));
//                    OW::getApplication()->redirect($curent_url."shop");


                //=============================================================================================================================================================================================================
                }else{//-------------------------------------------------------------------------------------------------------paypal
                    $this->doPayNew($value,$valueo);
                }

            }
        }else{
///sign-in?back-uri=photo%252Fupload%252Findex

            $curent_full_url=$_SERVER["REQUEST_URI"];
//echo $curent_full_url;exit;
//            OW::getApplication()->redirect($curent_url."sign-in?back-uri=".urlencode($curent_full_url));
            OW::getApplication()->redirect($curent_url."sign-in?back-uri=".$curent_full_url);
        }
    }








    public function zoom_product($params) 
    { 

        $content="";
        $products="";
$bg="";
$table ="";
$curent_revers=1;
        if ($params['idproduct']>0){

                $id_user = OW::getUser()->getId();//citent login user (uwner)
                    $is_admin = OW::getUser()->isAdmin();//iss admin
                    $pluginStaticURL2=OW::getPluginManager()->getPlugin('shoppro')->getStaticUrl();
                    $pluginStaticURL =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesUrl();
                    $pluginStaticDir =OW::getPluginManager()->getPlugin('shoppro')->getUserFilesDir();
                    $protectkey=substr(session_id(),1,5);
                    $curent_url = 'http';
                    if (isset($_SERVER["HTTPS"])) {$curent_url .= "s";}
                    $curent_url .= "://";
                    $curent_url .= $_SERVER["SERVER_NAME"]."/";
$curent_url=OW_URL_HOME;                     

$curent_lang=SHOPPRO_BOL_Service::getInstance()->get_curect_lang_id();
//echo $curent_lang;exit;
/*
$from_config=$curent_url;
$from_config=str_replace("https://","",$from_config);
$from_config=str_replace("http://","",$from_config);
$trash=explode($from_config,$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);
$url_detect=$trash[1];
//print_r($trash);
//echo $url_detect;
*/
//echo "sdfsdf";exit;
$add_where="";
if (!$is_admin){
//    if ($add_where) $add_where .=" AND ";
    $add_where .=" AND  (pr.items>0 OR pr.id_owner='".addslashes($id_user)."') ";
}

$curent_lang_def=SHOPPRO_BOL_Service::getInstance()->get_system_lang_id();//default oxwall website language

                if ($id_user>0 AND $is_admin>0 AND $is_admin){
                    $query = "SELECT pr.*,prd.description_de as description_de, prdx.description_de as description_de_def FROM " . OW_DB_PREFIX. "shoppro_products pr 
                    LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_description prd ON (prd.id_product_de=pr.id AND prd.id_lang_de='".addslashes($curent_lang)."')  
                LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_description prdx ON (prdx.id_product_de=pr.id AND prdx.id_lang_de='".addslashes($curent_lang_def)."')
                    WHERE pr.id='".addslashes($params['idproduct'])."' ".$add_where." LIMIT 1";
                }else{
                    $query = "SELECT pr.*,prd.description_de as description_de, prdx.description_de as description_de_def FROM " . OW_DB_PREFIX. "shoppro_products pr 
                    LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_description prd ON (prd.id_product_de=pr.id AND prd.id_lang_de='".addslashes($curent_lang)."')  
                LEFT JOIN " . OW_DB_PREFIX. "shoppro_products_description prdx ON (prdx.id_product_de=pr.id AND prdx.id_lang_de='".addslashes($curent_lang_def)."')
                    WHERE pr.id='".addslashes($params['idproduct'])."' AND (pr.active='1' OR pr.id_owner='".addslashes($id_user)."') ".$add_where."  LIMIT 1";
                }
                $arrx = OW::getDbo()->queryForList($query);

//echo $query;exit;
                if (isset($arrx[0])){
                    $value=$arrx[0];
                }else{
                    $value=array();
                    $value['id']=0;
                }

                if ($value['id']>0){
//echo "fsdF";exit;
                            $dname=BOL_UserService::getInstance()->getDisplayName($value['id_owner']);
                            $uurl=BOL_UserService::getInstance()->getUserUrl($value['id_owner']);
                            $uimg=BOL_AvatarService::getInstance()->getAvatarUrl($value['id_owner']);


                                $product_image="ow_userfiles/plugins/shoppro/images/product_".$value['id'].".jpg";
                                if (is_file("./".$product_image)){
                                    $product_image=$curent_url.$product_image;
                                }else{
//                                    $product_image=$curent_url."ow_userfiles/plugins/shoppro/noimage.jpg";
                                    $product_image="";
                                }

$seo_title=stripslashes($value['name']);
$seo_title=$this->make_seo_url($seo_title,100);

                                $products .="<table style=\"width:99%;margin:auto;\">";
                                $products .="<tr class=\"ow_alt1\">";

                                if ($product_image){
//                                    $products .="<td style=\"width:100px;border-bottom:1px solid #ddd;\" nowrap=\"nowrap\" valign=\"top\">";
                                    $products .="<td class=\"ow_alt1\" style=\"width:100%;margin:auto;\" valign=\"top\">";
                                $products .="<div style=\"display:inline-block;float:left; min-width:330px; border:1px solid:#f00;\">";
                                    $products .="<a href=\"".$product_image."\" rel=\"prettyPhoto[pp_gal]\" title=\"\">";
                                    $products .= "<img src=\"".$product_image."\" border=\"0\" width=\"300px\" title=\"".stripslashes($value['name'])."\" align=\"left\" style=\"margin:10px;\">";
                                    $products .="</a>";
                                $products .="</div>";
//                                    $products .="</td>";
                                }else{
//                                    $products .="<td style=\"width:0px;border-bottom:1px solid #ddd;\" nowrap=\"nowrap\" valign=\"top\">";
                                    $products .="<td class=\"ow_alt1\" style=\"width:100%;margin:auto;\"  valign=\"top\">";
//                                    $products .="</td>";
                                }
                                
//                                $products .="<td style=\"border-bottom:1px solid #ddd;\" valign=\"top\">";
/*
if (OW::getConfig()->getValue('shoppro', 'max_product_desc_chars')>0){
    $max_chars=OW::getConfig()->getValue('shoppro', 'max_product_title_chars');
    if ($value['description_de']){
        $description=SHOPPRO_BOL_Service::getInstance()->html2txt(stripslashes($value['description_de']));
    }else{
        $description=SHOPPRO_BOL_Service::getInstance()->html2txt(stripslashes($value['description']));
    }
    $pr = mb_substr($description,0,$max_chars);
    if (strlen(stripslashes($value['name']))>$max_chars) $pr .="...";
    $products .=SHOPPRO_BOL_Service::getInstance()->brtospace($pr);
}else{
        if ($value['description_de']){
            $description=SHOPPRO_BOL_Service::getInstance()->html2txt(stripslashes($value['description_de']));
        }else{
            $description=SHOPPRO_BOL_Service::getInstance()->html2txt(stripslashes($value['description']));
        }
    $pr = mb_substr($description,0,255);
    $products .=SHOPPRO_BOL_Service::getInstance()->brtospace($pr);
}
*/

//TODO IFRAME ADD

        $mode_show_content="iframe";//normal

        $max_content_height=OW::getConfig()->getValue('shoppro', 'max_height_zoom_description');
        if (!$max_content_height OR $max_content_height<300) $max_content_height=900;


        if (isset($value['description_de']) AND $value['description_de']){
//echo "dddd".$value['description_de'];exit;
            if ($mode_show_content=="normal"){
                $description=SHOPPRO_BOL_Service::getInstance()->html2txt(stripslashes($value['description_de']));
            }else{
                $description="<iframe onload=\"insertIt();\" id=\"shopmaincontentproduct\" width=\"100%\" height=\"".$max_content_height."px\" src=\"".$curent_url."ordershop/gpc/page/".$params['idproduct']."/".substr(session_id(),2,6)."?cl=".$curent_lang."\"></iframe>";
            }
//            $description=SHOPPRO_BOL_Service::getInstance()->html2txt(stripslashes($value['description_de']));
//            $description="<iframe id=\"shopmaincontentproduct\" width=\"100%\" height=\"auto\" src=\"".$curent_url."ordershop/gpc/page/".$params['idproduct']."/".substr(session_id(),2,6)."\"></iframe>";
//            $description=stripslashes($value['description_de']);
        }else if (isset($value['description_de_def']) AND $value['description_de_def']){
            if ($mode_show_content=="normal"){
                $description=SHOPPRO_BOL_Service::getInstance()->html2txt(stripslashes($value['description_de_def']));
            }else{
                $description="<iframe onload=\"insertIt();\" id=\"shopmaincontentproduct\" width=\"100%\" height=\"".$max_content_height."px\" src=\"".$curent_url."ordershop/gpc/page/".$params['idproduct']."/".substr(session_id(),2,6)."?cl=".$curent_lang."\"></iframe>";
            }
        }else{
            if ($mode_show_content=="normal"){
                $description=SHOPPRO_BOL_Service::getInstance()->html2txt(stripslashes($value['description']));
            }else{
                $description="<iframe onload=\"insertIt();\" id=\"shopmaincontentproduct\" width=\"100%\" height=\"".$max_content_height."px\" src=\"".$curent_url."ordershop/gpc/page/".$params['idproduct']."/".substr(session_id(),2,6)."?cl=".$curent_lang."\"></iframe>";
            }
//            $description=SHOPPRO_BOL_Service::getInstance()->html2txt(stripslashes($value['description']));
//            $description="<iframe id=\"shopmaincontentproduct\" width=\"100%\" height=\"auto\" src=\"".$curent_url."ordershop/gpc/page/".$params['idproduct']."/".substr(session_id(),2,6)."\"></iframe>";
//                $description=stripslashes($value['description']);
        }

        if ($mode_show_content=="normal" AND OW::getConfig()->getValue('shoppro', 'admin_replace_btobr')==1){
            $description=str_replace("\r\n","<br/>",$description);
            $description=str_replace("\n","<br/>",$description);
        }

                                $products .= $description;

//----info start ZOOM - moved to right column
/*
                    $products .="<div class=\"clearfix\" style=\"display:inline-block;width:100%;float:left;text-align:left;font-size:12px;margin:10px\">";
//                    $products .="<hr/>";



                    if ($value['condition']!=""){
//                        if ($value['location']) $products .=", ";
//                        $products .=OW::getLanguage()->text('shoppro', 'product_condition').": ".stripslashes($value['condition']);
                        $products .="<i>".OW::getLanguage()->text('shoppro', 'product_condition')."</i>:&nbsp;";
                        if ($value['condition']==0){
                            $products .="<b>".OW::getLanguage()->text('shoppro', 'product_condition_na')."</b>";
                        }else if ($value['condition']==1){
                            $products .="<b>".OW::getLanguage()->text('shoppro', 'product_condition_new')."</b>";
                        }else if ($value['condition']==2){
                            $products .="<b>".OW::getLanguage()->text('shoppro', 'product_condition_used')."</b>";
                        }
                    }

//$products .="--".$value['type_ads']."--".$value['classifieds_type']."--";
//                    if ($value['classifieds_type']>0 AND $value['type_ads']=="0"){
                    if ($value['classifieds_type']>0 AND $value['type_ads']=="0"){
                        $products .="<i>".OW::getLanguage()->text('shoppro', 'product_type_classifieds')."</i>:&nbsp;";
                        if ($value['classifieds_type']==1){
                            $products .="<b>".OW::getLanguage()->text('shoppro', 'product_available')."</b>";
                        }else if ($value['classifieds_type']==2){
                            $products .="<b>".OW::getLanguage()->text('shoppro', 'product_wanted')."</b>";
                        }
                    }




                    if ($value['type_ads']==0){
                        if ($value['classifieds_type']==1){
                            if ($value['location'] OR $value['condition']>0) $products .=", ";
//                            $products .=OW::getLanguage()->text('shoppro', 'product_type_classifieds').": ".stripslashes($value['classifieds_type']);
                            $products .="<i>".OW::getLanguage()->text('shoppro', 'product_type_classifieds')."</i>: ";
                            $products .="<b>".OW::getLanguage()->text('shoppro', 'product_available')."</b>";
                        }else if ($value['classifieds_type']==2){
                            if ($value['location'] OR $value['condition']) $products .=", ";
                            $products .="<i>".OW::getLanguage()->text('shoppro', 'product_type_classifieds')."</i>:&nbsp;";
                            $products .="<b>".OW::getLanguage()->text('shoppro', 'product_wanted')."</b>";
                        }
                    }

                    if ($value['location']){
                        if ($value['classifieds_type'] OR $value['condition']>0) $products .=", ";
//                        $products .=OW::getLanguage()->text('shoppro', 'product_location').": ".mb_substr(stripslashes($value['location']),0,20);
                        $products .="<i>".OW::getLanguage()->text('shoppro', 'product_location')."</i>:&nbsp;";
//                        $products .="<b>".mb_substr(stripslashes($value['location']),0,20)."</b>";
                        $loc=str_replace("'","",stripslashes($value['location']));
                        $loc=str_replace("\r\n","",$loc);
                        $loc=str_replace("\r","",$loc);
                        $loc=str_replace("\n","",$loc);
                        $loc=str_replace("\t","",$loc);
                        $loc=str_replace(" ","+",$loc);
                        $products .="<b><a href=\"https://maps.google.com/maps?tab=wl&q=".$loc."\" target=\"_blank\">".mb_substr(stripslashes($value['location']),0,20)."</a></b>";
                    }

                    if ($value['map_lat']!="" AND $value['map_lan']){
//                        if ($value['location']) $products .=", ";
//                        $products .=OW::getLanguage()->text('shoppro', 'product_condition').": ".stripslashes($value['condition']);
                        $products .=", <i>".OW::getLanguage()->text('shoppro', 'map')."</i>:&nbsp;";
                        $loc=$value['map_lat'].",".$value['map_lan'];
                            $products .="<b><a href=\"http://maps.google.com/maps?tab=wl&q=".$loc."\" target=\"_blank\">".OW::getLanguage()->text('shoppro', 'show_location')."</a></b>";
                    }

                    $products .="</div>";
*/
//----info end

//---g start
                $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"width:100%;float:right;text-align:center;font-size:14px;display:block;margin:4px;\">";
/*
                $product_image="ow_userfiles/plugins/shoppro/images/product_".$value['id'].".jpg";
                if (is_file("./".$product_image)){
                    $product_image=$curent_url.$product_image;
//                    $products .="<a href=\"".$product_image."\" rel=\"prettyPhoto[pp_gal]\" title=\"You can add caption to pictures.\">";
                    $products .="<a href=\"".$product_image."\" rel=\"prettyPhoto[pp_gal]\" title=\"Zoom...\">";
                    $products .="<img src=\"".$product_image."\" width=\"60\" height=\"60\" alt=\"\" />";
                    $products .="</a>";
                }
*/
                for ($i=2;$i<11;$i++){
                    $product_image="ow_userfiles/plugins/shoppro/images/product_".$value['id']."_".$i.".jpg";
                    if (is_file("./".$product_image)){
                        $product_image=$curent_url.$product_image;
//                        $products .="<a href=\"".$product_image."\" rel=\"prettyPhoto[pp_gal]\" title=\"You can add caption to pictures.\">";
                        $products .="<div style=\"display:inline-block;padding:0;height:60px;width:60px;margin-right:5px;border:1px solid #555;\">";
                        $products .="<a href=\"".$product_image."\" rel=\"prettyPhoto[pp_gal]\" title=\"\">";
                        $products .="<img src=\"".$product_image."\" width=\"60px\" height=\"60px\" alt=\"\" />";
                        $products .="</a>";
//                        $products .=" ";
                        $products .="</div>";
                    }
                }

//                $products .='<a href="http://test.a6.pl/ow_userfiles/plugins/shoppro/images/product_6.jpg" rel="prettyPhoto[pp_gal]" title="You can add caption to pictures."><img src="http://test.a6.pl/ow_userfiles/plugins/shoppro/images/product_6.jpg" width="60" height="60" alt="Red round shape" /></a>
//                <a href="http://test.a6.pl/ow_userfiles/plugins/shoppro/images/product_6.jpg" rel="prettyPhoto[pp_gal]"><img src="http://test.a6.pl/ow_userfiles/plugins/shoppro/images/product_6.jpg" width="60" height="60" alt="Nice building" /></a>';
                $products .="</div>";
//---g end



                                $products .="</td>";
//class="clearfix ow_alt2"









//-----button bought on zoom and profile
//--------------------------------------------------------------------start klawisza kup i profilu na zoomie




//                               $products .="<td class=\"ow_alt2\" style=\"width:55px;text-align:center;".$bg.";display:block;float:right;\" valign=\"top\" >";
                            $products .="<td class=\"ow_alt2\" style=\"min-width:155px;text-align:center;".$bg.";display:block;float:right;\" valign=\"top\" >";






                            if (OW::getConfig()->getValue('shoppro', 'mode_membercanselingbypoints')==1 AND $value['type_ads']==2 AND $value['price']>0){//------------------------------------------------------pay by credit ZOOM2
                                $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"width:100%;float:right;text-align:center;font-size:14px;display:block;margin:0px;\">";
//                                $products .= "<strong>".$value['price']."<span style=\"font-size:8px;\">&nbsp;".$value['curency']."</span></strong>";
                                $products .= "<strong>".$value['price']."<span style=\"font-size:8px;\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_credits')."</span></strong>";
                                $products .="</div>";
//                                $products .="<br/>";

                                if (OW::getConfig()->getValue('shoppro', 'show_quty_inproduct')){
                                    $products .="<br/>&nbsp;";
//                                    $qty="(".$value['items']."".OW::getLanguage()->text('shoppro', 'short_qty').")";
                                    $products .="(".$value['items']." ".OW::getLanguage()->text('shoppro', 'short_qty').")";
                                }

                                $products .="<br/>&nbsp;";

//                                if ($value['items']<1){
//                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
//                                    $products .=OW::getLanguage()->text('shoppro', 'bay_error_item_wassaled');
//                                    $products .="</div>";
                                if ($value['active']==-1){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
                                    $products .=OW::getLanguage()->text('shoppro', 'product_table_deleted');
                                    $products .="</div>";
                                }else if ($value['active']!=1){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
                                    $products .=OW::getLanguage()->text('shoppro', 'product_table_moderation');
                                    $products .="</div>";
                                }else if (!$id_user OR $value['id_owner']!=$id_user){
//                                    $products .="<a href=\"".$curent_url."baynowcredits/".$value['id']."_".substr(session_id(),7,6)."\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits')."\" onclick=\"return confirm('".OW::getLanguage()->text('shoppro', 'product_table_confirm_paycredit').": ".round($value['price'],0)." ".OW::getLanguage()->text('shoppro', 'product_credits')."');\" >";
//                                    $products .="<div class=\"ow_center\"><span class=\"ow_button ow_ic_star ow_positive\"><span>
//                                    <input type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_bayusingcreditspay')."\" class=\"ow_ic_star ow_positive\" ></span></span></div>";
/*
            $products .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"submit\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_bayusingcreditspay')."\" class=\"ow_ic_star ow_positive\">
                        </span>
                    </span>
                </div>
            </div>";
*/

//---pop tart 1zoom
//( $id="",$url="" ,$button_type="submit",$button_position="center",$title_bsubmit="Submit", $title="",$content="",$title_header="Info" 
if (!SHOPPRO_BOL_Service::getInstance()->is_cart()){//aronz_credit

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

/*
$products .="<div id=\"shop_dialog_d1\" dial=\"d1\" class=\"shop_dialog\">
        <table style=\"width: 100%; border: 0px;\" cellpadding=\"3\" cellspacing=\"0\">
            <tr>
                <td class=\"shop_dialog_title\">&nbsp;".OW::getLanguage()->text('shoppro', 'confirm_buyaction')."</td>
                <td class=\"shop_dialog_title align_right\">
                    <a href=\"#\" id=\"shop_btnClose\" class=\"shop_btnClose\" dial=\"d1\">".OW::getLanguage()->text('shoppro', 'close_popup')."</a>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan=\"2\" style=\"padding-left: 15px;\">
                    <b>".OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information')."</b>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan=\"2\" style=\"padding-left: 15px;\">
                    <div id=\"brands\">
                    ".OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description')."
                    </div>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan=\"2\" style=\"text-align: center;\">
                    <input id=\"shop_btnCancel\" class=\"shop_btnCancel ow_ic_delete\" dial=\"d1\" type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" title=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" />
                    <input id=\"shop_btnSubmit\" class=\"shop_btnSubmit ow_ic_cart\" type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_confirm_baynow')."\" url=\"".$curent_url."baynowcredits/".$value['id']."_".substr(session_id(),7,6)."\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits')."\"  onclick=\"return confirm('".OW::getLanguage()->text('shoppro', 'product_table_confirm_paycredit').": ".round($value['price'],0)." ".OW::getLanguage()->text('shoppro', 'product_credits')."');\" />
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
";
            $products .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"button\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_baynow')."\" class=\"ow_ic_cart ow_positive shop_btnDialog\" dial=\"d1\">
                        </span>
                    </span>
                </div>
            </div>";
//d1
*/
//---pop end 1zoom


//                                    $products .="</a>";
//                                    <input type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits')."\" class=\"ow_ic_star ow_positive\" ></span></span></div>";
                                }else{
                                    $products .="<div class=\"ow_center\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits')."</div>";
                                }


                            }else if (strlen($value['seler_account'])>6 AND $value['type_ads']==1 AND $value['price']>0){//---------------------------------------------------------------------------------------------shop ZOOM2

                        if (!$value['has_options']){
//                                $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"width:100%;float:right;text-align:center;display:block;margin:0px;\">";
                                $products .="<div class=\"ow_alt\" clearfix\" style=\"width:100%;float:right;text-align:center;display:block;margin:0px;\">";
//                                    $products .="<div style=\"text-align:center;display:block;font-size:16px;;margin:8px;\">";
                                    $products .="<strong style=\"font-size:16px;\">".$value['price']."<span style=\"font-size:9px;\">&nbsp;".$value['curency']."</span></strong>";
//                                    $products .="</div>";
                                $products .="</div>";

                                if (OW::getConfig()->getValue('shoppro', 'show_quty_inproduct')){
                                    $products .="<br/>&nbsp;";
//                                    $qty="(".$value['items']."".OW::getLanguage()->text('shoppro', 'short_qty').")";
                                    $products .="(".$value['items']." ".OW::getLanguage()->text('shoppro', 'short_qty').")";
                                }

                                $products .="<br/>&nbsp;";
                        }


/*
                                $products .="<a href=\"".$curent_url."baynow/".$value['id']."\" alt=\"".OW::getLanguage()->text('shoppro', 'product_table_baynow')."\">";
//                                $products .= OW::getLanguage()->text('shoppro', 'product_table_baynow');
                                $products .="<div style=\"border:1px solid #ddd;width:100px;height:40px;float:right;text-align:center;\">";
                                    $products .="<div style=\"margin-top:10px;display:block;\">";
                                        $products .= "<b>".OW::getLanguage()->text('shoppro', 'product_table_baynow')."</b>";
                                    $products .="</div>";
                                $products .="</div>";
                                $products .="</a>";
*/

//                                if ($value['items']<1){
//                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
//                                    $products .=OW::getLanguage()->text('shoppro', 'bay_error_item_wassaled');
//                                    $products .="</div>";
                                if ($value['active']==-1){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
                                    $products .=OW::getLanguage()->text('shoppro', 'product_table_deleted');
                                    $products .="</div>";
                                }else if ($value['active']!=1){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
                                    $products .=OW::getLanguage()->text('shoppro', 'product_table_moderation');
                                    $products .="</div>";
                                }else if (!$id_user OR $value['id_owner']!=$id_user){
//                                    $products .="<a href=\"".$curent_url."baynow/".$value['id']."\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_baynow')."\" >";
//                                    $products .="<div class=\"ow_center\"><span class=\"ow_button ow_ic_cart ow_positive\"><span>
//                                    <input type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_baynow')."\" class=\"ow_ic_cart ow_positive\" ></span></span></div>";

/*
            $products .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"submit\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_baynow')."\" class=\"ow_ic_cart ow_positive\">
                        </span>
                    </span>
                </div>
            </div>";
*/

//---pop tart 2zoom
//( $id="",$url="" ,$button_type="submit",$button_position="center",$title_bsubmit="Submit", $title="",$content="",$title_header="Info" 
//$products .="fgsdfsfsdF";
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

    //make_acccartbutton($idp=0,$ido=0,$title="",$desc="",$amout=1,$proce=0)
    $products .=SHOPPRO_BOL_Service::getInstance()->make_acccartbutton(
    $value['id'],$value['id_owner'],$value['name'],$value['description'],1,$value['price'],$value['curency'],'shop',$value['has_options'],$value['id']
);

}//else
/*
$products .="<div id=\"shop_dialog_d2\" dial=\"d2\" class=\"shop_dialog\">
        <table style=\"width: 100%; border: 0px;\" cellpadding=\"3\" cellspacing=\"0\">
            <tr>
                <td class=\"shop_dialog_title\">&nbsp;".OW::getLanguage()->text('shoppro', 'confirm_buyaction')."</td>
                <td class=\"shop_dialog_title align_right\">
                    <a href=\"#\" id=\"shop_btnClose\" class=\"shop_btnClose\" dial=\"d2\">".OW::getLanguage()->text('shoppro', 'close_popup')."</a>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan=\"2\" style=\"padding-left: 15px;\">
                    <b>".OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information')."</b>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan=\"2\" style=\"padding-left: 15px;\">
                    <div id=\"brands\">
                    ".OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description')."
                    </div>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan=\"2\" style=\"text-align: center;\">
                    <input id=\"shop_btnCancel\" class=\"shop_btnCancel ow_ic_delete\" dial=\"d2\" type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" title=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" />
                    <input id=\"shop_btnSubmit\" class=\"shop_btnSubmit ow_ic_cart\" type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_confirm_baynow')."\" url=\"".$curent_url."baynow/".$value['id']."\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits')."\"  onclick=\"return confirm('".OW::getLanguage()->text('shoppro', 'product_table_confirm_paycredit').": ".round($value['price'],0)." ".OW::getLanguage()->text('shoppro', 'product_table_baynow')."');\" />
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
";
//                                    $products .="<a href=\"".$curent_url."baynow/".$value['id']."\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_baynow')."\" >";
            $products .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"button\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_baynow')."\" class=\"ow_ic_cart ow_positive shop_btnDialog\" dial=\"d2\">
                        </span>
                    </span>
                </div>
            </div>";
//d2
*/
//---pop end 2zoom


//                                    $products .="</a>";                            
                                }else{
                                    $products .="<div class=\"ow_center\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_table_add_type_shop')."</div>";
                                }

                            }else if (!$value['price'] OR $value['price']==0){//----------------------------------------------------------------------------------------------------------------------------------------free ZOOM2

//                                $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"width:100%;float:right;text-align:center;display:block;margin:0px;\">";
                                $products .="<div class=\"ow_alt\" clearfix\" style=\"width:100%;float:right;text-align:center;display:block;margin:0px;\">";
//                                    $products .="<div style=\"text-align:center;display:block;font-size:16px;;margin:8px;\">";

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
                                $products .="<br/>&nbsp;";


                                if (!$id_user OR $value['id_owner']!=$id_user){
//                                $products .="<a href=\"".$curent_url."baynowproduct/".$value['id']."_".substr(session_id(),7,6)."\" alt=\"".OW::getLanguage()->text('shoppro', 'product_table_baynow')."\" >";
//                            $products .="<div class=\"ow_center\"><span class=\"ow_button ow_ic_cart ow_positive\"><span>
//                            <input type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_baynow')."\" class=\"ow_ic_cart ow_positive\" ></span></span></div>";

/*
            $products .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"submit\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_baynow')."\" class=\"ow_ic_cart ow_positive\">
                        </span>
                    </span>
                </div>
            </div>";
*/

//---pop tart 3zoom
//( $id="",$url="" ,$button_type="submit",$button_position="center",$title_bsubmit="Submit", $title="",$content="",$title_header="Info" 
/*
$products .=SHOPPRO_BOL_Service::getInstance()->make_popup_window(
"",
$curent_url."baynowproduct/".$value['id']."_".substr(session_id(),7,6),
"button",
"center",
OW::getLanguage()->text('shoppro', 'product_table_baynow'),
OW::getLanguage()->text('shoppro', 'product_table_baynow'),
OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information'),
OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description'),
OW::getLanguage()->text('shoppro', 'product_table_baynow'),
"",
SHOPPRO_BOL_Service::getInstance()->make_thermofuse($value['id_owner'])
,$value['has_options'],$value['id']
);
*/

if (strlen($value['file_attach'])>3){//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------file download
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
,$value['has_options'],$value['id']
);
//$products .=$value['file_attach']."--";
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
//$products .="fgsdfsfsdF".$value['has_options'];
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
        }//if
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
//$products .=$value['file_attach']."--".$uurl;
}

/*
$products .="<div id=\"shop_dialog_d3\" dial=\"d3\" class=\"shop_dialog\">
        <table style=\"width: 100%; border: 0px;\" cellpadding=\"3\" cellspacing=\"0\">
            <tr>
                <td class=\"shop_dialog_title\">&nbsp;".OW::getLanguage()->text('shoppro', 'confirm_buyaction')."</td>
                <td class=\"shop_dialog_title align_right\">
                    <a href=\"#\" id=\"shop_btnClose\" class=\"shop_btnClose\" dial=\"d3\">".OW::getLanguage()->text('shoppro', 'close_popup')."</a>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan=\"2\" style=\"padding-left: 15px;\">
                    <b>".OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information')."</b>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan=\"2\" style=\"padding-left: 15px;\">
                    <div id=\"brands\">
                    ".OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description')."
                    </div>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan=\"2\" style=\"text-align: center;\">
                    <input id=\"shop_btnCancel\" class=\"shop_btnCancel ow_ic_delete\" dial=\"d3\" type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" title=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" />
                    <input id=\"shop_btnSubmit\" class=\"shop_btnSubmit ow_ic_cart\" type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_confirm_baynow')."\" url=\"".$curent_url."baynowproduct/".$value['id']."_".substr(session_id(),7,6)."\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits')."\"  onclick=\"return confirm('".OW::getLanguage()->text('shoppro', 'product_table_confirm_paycredit').": ".round($value['price'],0)." ".OW::getLanguage()->text('shoppro', 'product_table_baynow')."');\" />
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
";
//                                $products .="<a href=\"".$curent_url."baynowproduct/".$value['id']."_".substr(session_id(),7,6)."\" alt=\"".OW::getLanguage()->text('shoppro', 'product_table_baynow')."\" >";
            $products .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"button\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_baynow')."\" class=\"ow_ic_cart ow_positive shop_btnDialog\" dial=\"d3\">
                        </span>
                    </span>
                </div>
            </div>";
//d3
*/
//---pop end 3zoom


//                                $products .="</a>";                            
                                }else{
                                    $products .="<div class=\"ow_center\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_table_add_type_classified')."</div>";
                                }

/*
                                $products .="<div style=\"display:block;width:100%;margin:auto;text-align:center;\">";
                                $products .= "<b style=\"color:#080;\">".OW::getLanguage()->text('shoppro', 'product_table_product_free')."</b>";

//-----------file start
                                $table ="";
//echo "sdfsdF".OW::getConfig()->getValue('shoppro', 'mode_sellfiles');
                                if (OW::getConfig()->getValue('shoppro', 'mode_sellfiles')==1 AND $id_user>0){
                                        $query = "SELECT sp.*, bu.username FROM " . OW_DB_PREFIX. "shoppro_products sp 
                                                LEFT JOIN " . OW_DB_PREFIX. "base_user bu ON (bu.id=sp.id_owner) 
                                                WHERE sp.id='".addslashes($value['id'])."' LIMIT 1";
                                        $arrxxx = OW::getDbo()->queryForList($query);
                                        $valuex=$arrxxx[0];
                                        $xprice=($valuex['price']*1);

                                        if ($valuex['id']>0 AND $valuex['id']==$value['id'] AND $valuex['file_attach'] AND $valuex['username'] AND ($is_admin OR $xprice==0 OR ($xprice>0 AND $valuex['id_owner']==$id_user))  ){
                                            $hash=$valuex['file_attach'];
                                            $path_file="./ow_userfiles/plugins/shoppro/files/";
                                            $name_file="file_".$valuex['id']."_".$hash.".pack";
                                            if (is_file($path_file.$name_file)){
                                                $protect=substr(session_id(),3,10);
                                                $table .="<br/>";
                                                $table .="<a href=\"".$curent_url."shop/download/".$value['id']."/".$protect."\">";
                                                $table .= "<b style=\"text-decoration:underline;\">".OW::getLanguage()->text('shoppro', 'product_table_filefordownload_download')."</b>";
                                                $table .="</a>";
                                                if ($value['id_owner']==$id_user AND $id_user>0){
                                                    $table .="<br/><span style=\"font-size:8px;\">(".OW::getLanguage()->text('shoppro', 'product_table_wasdownloaded').": ".$valuex['count_downloads'].")</span>";
                                                }
                                            }else{
                                                $table .="<br/>";
                                                $table .="<a href=\"".$curent_url."user/".$valuex['username']."\">";
                                                $table .= "<b >".OW::getLanguage()->text('shoppro', 'product_table_filefordownload_notexist')."</b>";
                                                $table .="</a>";
                                            }
                                        }

//                                        $table .="</div>";
$table .="-------------";
                                }else if (OW::getConfig()->getValue('shoppro', 'mode_sellfiles')==1 AND !$id_user){
                                    $protect=substr(session_id(),3,10);
                                    $table .="<div style=\"display:block;width:100%;margin:auto;text-align:center;\">";
//                                    $table .="<a href=\"".$curent_url."sign-in?back-uri=".urlencode("http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"])."\">";
                                    $table .="<a href=\"".$curent_url."sign-in?back-uri=".urlencode("shop/download/".$value['id']."/".$protect)."\">";
                                    $table  .= "<b >".OW::getLanguage()->text('shoppro', 'product_loginfirst')."</b>";
                                    $table .="</a>";
                                    $table .="</div>";
                                }
                                $products .=$table;
                                $products .="</div>";
                                $products .="<br/>";
*/
//-----------file end
                            }else if (strlen($value['seler_account'])<7 OR $value['type_ads']==0){//---------------------------------------------------------------------------------------------------------------classified ZOOM2
//                                $products .= "<b style=\"color:#f00;\">".OW::getLanguage()->text('shoppro', 'product_error_noforsale')."</b>";
//                                $products .= "<b style=\"color:#f00;\">".OW::getLanguage()->text('shoppro', 'product_error_noforsale')."cc</b>";
//$products .="<a class=\"ow_add_content ow_ic_comment\" href=\"http://test.a6.pl/groups/create\">";
//$products .=OW::getLanguage()->text('shoppro', 'product_classifieds');
//$products .= "</a>";
/*
$products .= "<div class=\"ow_box_cap ow_dnd_configurable_component clearfix\">
    <div class=\"ow_box_cap_right\">
        <div class=\"ow_box_cap_body\">
            <h3 class=\"ow_ic_add\">Add New</h3>
        </div>
    </div>
</div>";
*/
//$products .= "<a class=\"ow_lbutton\" href=\"http://test.a6.pl/news/sidebar_4/nation_says_goodbye_to_moonwalker_neil_armstrong.html\">Moreg dfg dfg dfg dsf hdf dfsh fdh df a</a>";



                                if ($value['price']>0){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;font-size:14px;margin:0px;\">";
                                    $products .= "<strong>".$value['price']."<span style=\"font-size:8px;\">&nbsp;".$value['curency']."</span></strong>";
                                    $products .="</div>";
                                }
/*
$products .= "<div class=\"ow_alt".$curent_revers."\" clearfix\"=\"\" style=\"text-align:center;\">";
//$products .="<a href=\"http://test.a6.pl/user/".$value['id_owner']."\" style=\"display:inline;font-size:14px;font-weight:bold;\" title=\"".OW::getLanguage()->text('shoppro', 'product_classifieds_title')."\" alt=\"".OW::getLanguage()->text('shoppro', 'product_classifieds_title')."\">";
$products .="<a href=\"".$uurl."\" style=\"display:inline;font-size:14px;font-weight:bold;\" title=\"".OW::getLanguage()->text('shoppro', 'product_classifieds_title')."\" alt=\"".OW::getLanguage()->text('shoppro', 'product_classifieds_title')."\">";
$products .= OW::getLanguage()->text('shoppro', 'product_classifieds');
$products .= "</a>";
$products .="</div>";
$products .="<br/>";
*/
                                if (!$id_user OR $value['id_owner']!=$id_user){
//                                    $products .="<a href=\"".$uurl."\" title=\"".OW::getLanguage()->text('shoppro', 'product_classifieds')."\" >";
//                                    $products .="<div class=\"ow_center\"><span class=\"ow_button ow_ic_mail ow_positive\"><span>
//                                    <input type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_contactseler')."\" class=\"ow_ic_mail ow_positive\" ></span></span></div>";
/*
            $products .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"submit\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_contactseler')."\" class=\"ow_ic_mail ow_positive\">
                        </span>
                    </span>
                </div>
            </div>";
*/

//---pop tart 4zoom
//( $id="",$url="" ,$button_type="submit",$button_position="center",$title_bsubmit="Submit", $title="",$content="",$title_header="Info" 

if (!SHOPPRO_BOL_Service::getInstance()->is_cart()){

//OW::getLanguage()->text('shoppro', 'product_table_contactseler'),
//OW::getLanguage()->text('shoppro', 'product_classifiedss'),
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
,$value['has_options'],$value['id']
);

}else{
    if (SHOPPRO_BOL_Service::getInstance()->is_cart()){
        $products .=SHOPPRO_BOL_Service::getInstance()->make_acccartbutton(
            $value['id'],$value['id_owner'],$value['name'],$value['description'],1,$value['price'],$value['curency'],'clasifid',$value['has_options'],$value['id']
        );
    }
}//else

/*
$products .="<div id=\"shop_dialog_d4\" dial=\"d4\" class=\"shop_dialog\">
        <table style=\"width: 100%; border: 0px;\" cellpadding=\"3\" cellspacing=\"0\">
            <tr>
                <td class=\"shop_dialog_title\">&nbsp;".OW::getLanguage()->text('shoppro', 'confirm_buyaction')."</td>
                <td class=\"shop_dialog_title align_right\">
                    <a href=\"#\" id=\"shop_btnClose\" class=\"shop_btnClose\" dial=\"d4\">".OW::getLanguage()->text('shoppro', 'close_popup')."</a>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan=\"2\" style=\"padding-left: 15px;\">
                    <b>".OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_information')."</b>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan=\"2\" style=\"padding-left: 15px;\">
                    <div id=\"brands\">
                    ".OW::getLanguage()->text('shoppro', 'product_confirm_buy_action_description')."
                    </div>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan=\"2\" style=\"text-align: center;\">
                    <input id=\"shop_btnCancel\" class=\"shop_btnCancel ow_ic_delete\" dial=\"d4\" type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" title=\"".OW::getLanguage()->text('shoppro', 'product_confirm_cancel')."\" />
                    <input id=\"shop_btnSubmit\" class=\"shop_btnSubmit ow_ic_cart\" type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_confirm_baynow')."\" url=\"".$uurl."\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits')."\"  onclick=\"return confirm('".OW::getLanguage()->text('shoppro', 'product_table_confirm_paycredit').": ".round($value['price'],0)." ".OW::getLanguage()->text('shoppro', 'product_classifieds')."');\" />
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
";
//                                    $products .="<a href=\"".$uurl."\" title=\"".OW::getLanguage()->text('shoppro', 'product_classifieds')."\" >";
            $products .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"button\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_baynow')."\" class=\"ow_ic_cart ow_positive shop_btnDialog\" dial=\"d4\">
                        </span>
                    </span>
                </div>
            </div>";
//d4
*/
//---pop end 4zoom

//                                    $products .="</a>";
                                }else{
                                    $products .="<div class=\"ow_center\">&nbsp;".OW::getLanguage()->text('shoppro', 'product_table_add_type_classified')."</div>";
                                }



                            }//end types seling













/*

                            if (OW::getConfig()->getValue('shoppro', 'mode_membercanselingbypoints')==1 AND $value['type_ads']==2 AND $value['price']>0){//pay by credit
                                $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;font-size:14px;margin:10px;\">";
                                $products .= "<strong>".$value['price']."<span style=\"font-size:8px;\">&nbsp;".$value['curency']."</span></strong>";
                                $products .="</div>";

                                if ($value['active']==-1){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
                                    $products .=OW::getLanguage()->text('shoppro', 'product_table_deleted');
                                    $products .="</div>";
                                }else if ($value['active']!=1){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
                                    $products .=OW::getLanguage()->text('shoppro', 'product_table_moderation');
                                    $products .="</div>";
                                }else{
                                    $products .="<a href=\"".$curent_url."baynowcredits/".$value['id']."_".substr(session_id(),7,6)."\" alt=\"".OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits')."\" >";
                                    $products .="<div class=\"ow_center\"><span class=\"ow_button ow_ic_cart ow_positive\"><span>
                                    <input type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_bayusingcredits')."\" class=\"ow_ic_cart ow_positive\" ></span></span></div>";
                                    $products .="</a>";
                                }


                            }else if (strlen($value['seler_account'])>6 AND $value['type_ads']==1 AND $value['price']>0){//shop
                                $products .="<div style=\"width:100%;float:right;text-align:center;display:block;\">";
                                    $products .="<div style=\"text-align:center;display:block;font-size:16px;\">";
                                    $products .="<strong>".$value['price']."<span style=\"font-size:8px;\">&nbsp;".$value['curency']."</span></strong>";
                                    $products .="</div>";
                                $products .="</div>";
                                $products .="<br/>";

                                $products .="<a href=\"".$curent_url."baynow/".$value['id']."\" alt=\"".OW::getLanguage()->text('shoppro', 'product_table_baynow')."\" >";
                            $products .="<div class=\"ow_center\"><span class=\"ow_button ow_ic_cart ow_positive\"><span>
                            <input type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_baynow')."\" class=\"ow_ic_cart ow_positive\" ></span></span></div>";
                                $products .="</a>";                            

                            }else if (!$value['price'] OR $value['price']==0){

                                $products .="<div style=\"display:block;width:100%;margin:auto;text-align:center;\">";
                                $products .= "<b style=\"color:#080;\">".OW::getLanguage()->text('shoppro', 'product_table_product_free')."</b>";
//-----------file start
                                $table ="";
//echo "sdfsdF".OW::getConfig()->getValue('shoppro', 'mode_sellfiles');
                                if (OW::getConfig()->getValue('shoppro', 'mode_sellfiles')==1 AND $id_user>0){
                                        $query = "SELECT sp.*, bu.username FROM " . OW_DB_PREFIX. "shoppro_products sp 
                                                LEFT JOIN " . OW_DB_PREFIX. "base_user bu ON (bu.id=sp.id_owner) 
                                                WHERE sp.id='".addslashes($value['id'])."' LIMIT 1";
//echo $query;
                                        $arrxxx = OW::getDbo()->queryForList($query);
                                        $valuex=$arrxxx[0];
                                        $xprice=($valuex['price']*1);
//print_r($valuex);
                                        if ($valuex['id']>0 AND $valuex['id']==$value['id'] AND $valuex['file_attach'] AND $valuex['username'] AND ($is_admin OR $xprice==0 OR ($xprice>0 AND $valuex['id_owner']==$id_user))  ){
                                            $hash=$valuex['file_attach'];
                                            $path_file="./ow_userfiles/plugins/shoppro/files/";
                                            $name_file="file_".$valuex['id']."_".$hash.".pack";
//echo $path_file.$name_file;
                                            if (is_file($path_file.$name_file)){
                                                $protect=substr(session_id(),3,10);
                                                $table .="<br/>";
//                                                $table .= "<b>".OW::getLanguage()->text('shoppro', 'product_table_filefordownload').":</b>";
//                                                $table .="<br/>";
//                                                $table .= "&nbsp;";
                                                $table .="<a href=\"".$curent_url."shop/download/".$value['id']."/".$protect."\">";
                                                $table .= "<b style=\"color:#00f;text-decoration:underline;\">".OW::getLanguage()->text('shoppro', 'product_table_filefordownload_download')."</b>";
                                                $table .="</a>";
                                                if ($value['id_owner']==$id_user AND $id_user>0){
                                                    $table .="<br/><span style=\"font-size:8px;\">(".OW::getLanguage()->text('shoppro', 'product_table_wasdownloaded').": ".$valuex['count_downloads'].")</span>";
                                                }
                                            }else{
                                                $table .="<br/>";
//                                                $table .= "<b>".OW::getLanguage()->text('shoppro', 'product_table_filefordownload').":</b>";
//                                                $table .="<br/>";
//                                                $table .= "&nbsp;";
                                                $table .="<a href=\"".$curent_url."user/".$valuex['username']."\">";
                                                $table .= "<b style=\"color:#00f\">".OW::getLanguage()->text('shoppro', 'product_table_filefordownload_notexist')."</b>";
                                                $table .="</a>";
                                            }
                                        }
//                                      $table .="</div>";
                                        
                                }else if (OW::getConfig()->getValue('shoppro', 'mode_sellfiles')==1 AND !$id_user){
                                    $protect=substr(session_id(),3,10);
                                    $table .="<div style=\"display:block;width:100%;margin:auto;text-align:center;\">";
//                                    $table .="<a href=\"".$curent_url."sign-in?back-uri=".urlencode("http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"])."\">";
                                    $table .="<a href=\"".$curent_url."sign-in?back-uri=".urlencode("shop/download/".$value['id']."/".$protect)."\">";
                                    $table  .= "<b style=\"color:#f00;\">".OW::getLanguage()->text('shoppro', 'product_loginfirst')."</b>";
                                    $table .="</a>";
                                    $table .="</div>";
                                }
                                $products .=$table;
                                $products .="</div>";
//-----------file end
                            }else if (strlen($value['seler_account'])<7){
//                                $products .= "<b style=\"color:#f00;\">".OW::getLanguage()->text('shoppro', 'product_error_noforsale')."</b>";
//                                $products .= "<b style=\"color:#f00;\">".OW::getLanguage()->text('shoppro', 'product_loginfirst')."</b>";

                                if ($value['price']>0){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;font-size:14px;margin:10px;\">";
                                    $products .= "<strong>".$value['price']."<span style=\"font-size:8px;\">&nbsp;".$value['curency']."</span></strong>";
                                    $products .="</div>";
                                }

$products .= "<div class=\"ow_alt".$curent_revers."\" clearfix\"=\"\" style=\"text-align:center;\">
<a href=\"http://test.a6.pl/user/gosia\" style=\"display:inline;font-size:14px;font-weight:bold;\" title=\"".OW::getLanguage()->text('shoppro', 'product_classifieds_title')."\" alt=\"".OW::getLanguage()->text('shoppro', 'product_classifieds_title')."\">";
$products .= OW::getLanguage()->text('shoppro', 'product_classifieds');
$products .= "</a>
</div>";
$products .="<br/>";
                            }
*/


                            $products .="<div style=\"display:block;width:100%;margin:auto;text-align:center;margin-top:5px;\">";


if (!OW::getConfig()->getValue('shoppro', 'hide_seller_avatar_onthelist')){
                                if ($uimg){
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;\">";
                                        $products .=OW::getLanguage()->text('shoppro', 'product_table_seler').": ";
                                    $products .="</div>";
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;\">";
                                        $products .="<a href=\"".$uurl."\" style=\"display:inline;font-size:14px;font-weight:bold;\">";
                                        $products .="<img src=\"".$uimg."\" title=\"".$dname."\" width=\"45px\" style=\"border:0;margin:10px;align:left;display:inline;\" align=\"center\" >";
                                        $products .="</a>";
                                    $products .="</div>";
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;\">";
                                        $products .="<a href=\"".$uurl."\" style=\"display:inline;font-size:14px;font-weight:bold;\">";
                                        $products .=$dname;
                                        $products .="</a>";
                                    $products .="</div>";

                                }else{
                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;\">";
                                        $products .=OW::getLanguage()->text('shoppro', 'product_table_seler').": ";
                                    $products .="</div>";

                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;\">";
                                        $products .="<a href=\"".$uurl."\" style=\"display:inline;font-size:14px;font-weight:bold;\">";
                                        $products .="<img src=\"".$curent_url."ow_static/themes/".OW::getConfig()->getValue('base', 'selectedTheme')."/images/no-avatar.png\" title=\"".OW::getLanguage()->text('search', 'index_hasnotimage')."\" width=\"45px\" style=\"border:0;margin:10px;align:left;display:inline;\" align=\"center\" >";
                                        $products .="</a>";
                                    $products .="</div>";

                                    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;\">";
                                        $products .="<a href=\"".$uurl."\" style=\"display:inline;font-size:14px;font-weight:bold;\">";
                                        $products .=$dname;
                                        $products .="</a>";
                                    $products .="</div>";
                                }
}//OW::getConfig()->getValue('shoppro', 'hide_seller_avatar_onthelist')

if ($is_admin OR ( ($id_user>0 AND OW::getConfig()->getValue('shoppro', 'mode_membercanshell')==1) AND $value['id_owner']==$id_user)){

if ($id_user>0 AND $value['id_owner']==$id_user){
    $products .="<hr/>";
//    $products .="<a class=\"ow_add_content ow_alt".$curent_revers." ow_ic_ok\" href=\"".$curent_url."product/".$value['id']."/edit\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_active')."\">".OW::getLanguage()->text('shoppro', 'product_table_active')."</a>";
//    $products .="<a class=\"ow_add_content ow_alt".$curent_revers." ow_ic_ok\" href=\"".$curent_url."product/".$value['id']."/edit\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_moderation')."\">".OW::getLanguage()->text('shoppro', 'product_table_moderation')."</a>";
    $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;\">";
    if ($value['items']<1){
        $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
        $products .=OW::getLanguage()->text('shoppro', 'bay_error_item_wassaled');
        $products .="</div>";
    }else if ($value['active']==1){
        $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#080;\">";
        $products .=OW::getLanguage()->text('shoppro', 'product_table_active');
        $products .="</div>";
    }else if ($value['active']==-1){
        $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
        $products .=OW::getLanguage()->text('shoppro', 'product_table_deleted');
        $products .="</div>";
    }else{
        $products .="<div class=\"ow_alt".$curent_revers."\" clearfix\" style=\"text-align:center;color:#f00;\">";
        $products .=OW::getLanguage()->text('shoppro', 'product_table_moderation');
        $products .="</div>";
    }
    $products .="</div>";
}





    $products .="<div style=\"display:block;width:100%;margin:auto;text-align:center;margin-top:5px;\">";
/*
//$products .="<div class=\"clearfix\" style=\"text-align:center;\">";
//if (OW::getConfig()->getValue('shoppro', 'mode_ads_approval') AND isset($params['option']) AND $params['option']=="approval" AND $is_admin){
if (OW::getConfig()->getValue('shoppro', 'mode_ads_approval') AND $is_admin AND $value['active']==1){
    if ($value['active']==1){
        $products .="<a href=\"".$curent_url."ordershop/approval?deny=".$value['id']."_".$protectkey."\" style=\"display:inline;color:#008;font-size:14px;font-weight:bold;\">";
        $products .="<span class=\"ow_button ow_ic_deleteX ow_positive\"><span><input type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_disapprov')."\" class=\"ow_ic_delete ow_positive\"></span></span>";
        $products .="</a>";
    }
}else if (OW::getConfig()->getValue('shoppro', 'mode_ads_approval') AND $is_admin AND $value['active']!=1){
    $products .="<a href=\"".$curent_url."ordershop/approval?allow=".$value['id']."_".$protectkey."\" style=\"display:inline;color:#008;font-size:14px;font-weight:bold;\">";
//    $products .="<span class=\"ow_button ow_ic_okx ow_positive\"><span><input type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_doapprov')."\" class=\"ow_ic_ok ow_positive\"></span></span>";
    $products .="<span class=\"ow_button ow_ic_okX ow_positive\"><span><input type=\"button\" value=\"\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_doapprov')."\" class=\"ow_ic_ok ow_positive\"></span></span>";
    $products .="</a>";

    $products .="<a href=\"".$curent_url."ordershop/approval?del=".$value['id']."_".$protectkey."\" style=\"display:inline;color:#008;font-size:14px;font-weight:bold;\">";
//    $products .="<span class=\"ow_button ow_ic_deletex ow_positive\"><span><input type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_del')."\" class=\"ow_ic_delete ow_positive\"></span></span>";
    $products .="<span class=\"ow_button ow_ic_deleteX ow_positive\"><span><input type=\"button\" value=\"\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_del')."\" class=\"ow_ic_delete ow_positive\"></span></span>";
    $products .="</a>";

}
*/



if (OW::getConfig()->getValue('shoppro', 'mode_ads_approval') AND $is_admin AND $value['active']==1){
    if ($value['active']==1){
/*
        $products .="<a href=\"".$curent_url."ordershop/approval?deny=".$value['id']."_".$protectkey."\" style=\"display:inline;color:#008;font-size:14px;font-weight:bold;\">";
        $products .="<span class=\"ow_button ow_ic_deletex ow_positive\"><span><input type=\"button\" value=\"".OW::getLanguage()->text('shoppro', 'product_table_disapprov')."\" class=\"ow_ic_delete ow_positive\"></span></span>";
        $products .="</a>";
*/
    $products .="<ul class=\"ow_bl clearfix ow_small ow_stdmargin ow_center\">
            <li>
            <a href=\"".$curent_url."ordershop/approval?deny=".$value['id']."_".$protectkey."\" class=\"ow_mild_red\" rel=\"nofollow\">
                ".OW::getLanguage()->text('shoppro', 'product_table_disapprov')."
            </a>
        </li>

    </ul>";

    }
}else if (OW::getConfig()->getValue('shoppro', 'mode_ads_approval') AND $is_admin AND $value['active']!=1){

$products .="<ul class=\"ow_bl clearfix ow_small ow_stdmargin ow_center\">
            <li>
            <a href=\"".$curent_url."ordershop/approval?allow=".$value['id']."_".$protectkey."\" class=\"ow_mild_green\" rel=\"nofollow\">
                ".OW::getLanguage()->text('shoppro', 'product_table_doapprov')."
            </a>
        </li>
            <li>
            <a href=\"".$curent_url."ordershop/approval?del=".$value['id']."_".$protectkey."\" class=\"ow_mild_red\" rel=\"nofollow\">
                ".OW::getLanguage()->text('shoppro', 'product_table_del')."
            </a>
        </li>

    </ul>";


}





    $products .="</div>";
//if ($id_user>0 AND $value['id_owner']==$id_user AND $params['optmy']=="show"){

}//admin





                            $products .="</div>";

$products .="<div class=\"ow_center\" style=\"margin:auto;text-align:center;margin-top:3px;text-align:center;display:inline-block;\">";
                                if ($is_admin OR ( ($id_user>0 AND OW::getConfig()->getValue('shoppro', 'mode_membercanshell')==1) AND $value['id_owner']==$id_user)){
if ($table){
    $products .="<hr/>";
}else{
//    $products .="<br/>";
}


//    $pagination .="<div class=\"ow_stdmargin  clearfix\" >";
//    $pagination .="<a style=\"width:35px;height:25px;display:inline-block;background-position: center center;\" class=\"ow_add_content ow_ic_right_arrow\" href=\"".$curent_url."shop?page=".$next_page.$url_pages."\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_next')."\"></a>";
//    $pagination .="</div>";

//$products .="<a class=\"ow_add_content ow_alt".$curent_revers." ow_ic_write\" href=\"".$curent_url."product/".$value['id']."/edit\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_edit')."\"></a>";
//$products .="<a class=\"ow_add_content ow_alt".$curent_revers." ow_ic_delete\" href=\"".$curent_url."product/".$value['id']."/del\" onclick=\"return confirm('Are you sure you want to delete?');\"  title=\"".OW::getLanguage()->text('shoppro', 'product_table_delete')."\"></a>";


//    $products .="<div class=\"ow_stdmargin  clearfix\" style=\"display:inline-block;margin-right:3px;\">";
//    $products .="<a style=\"width:20px;height:20px;display:inline-block;background-position: center center;\" class=\"ow_add_content ow_ic_write\" href=\"".$curent_url."product/".$value['id']."/edit\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_edit')."\"></a>";
///    $products .="<a style=\"padding:0;margin:0;margin-right:5px;width:35px;height:35px;display:inline-block;background-position: center center;\" class=\"ow_add_content ow_ic_write\" href=\"".$curent_url."product/".$value['id']."/edit\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_edit')."\"></a>";
//    $products .="</div>";

//    $products .="<div class=\"ow_stdmargin  clearfix\" style=\"display:inline-block;\" >";
///    $products .="<a style=\"padding:0;margin:0;width:35px;height:35px;display:inline-block;background-position: center center;\"  class=\"ow_add_content ow_ic_delete\" href=\"".$curent_url."product/".$value['id']."/del\" onclick=\"return confirm('Are you sure you want to delete?');\"  title=\"".OW::getLanguage()->text('shoppro', 'product_table_delete')."\"></a>";
//  $products .="<a style=\"padding:0;margin:0;width:35px;height:35px;display:inline-block;background-position: center center;\"  class=\"ow_add_content ow_ic_delete\" href=\"".$curent_url."product/".$value['id']."/del\" onclick=\"return confirm('Are you sure you want to delete?');\"  title=\"".OW::getLanguage()->text('shoppro', 'product_table_delete')."\"></a>";
//    $products .="</div>";




        $products .="<span style=\"\" class=\"ow_nowrap\">
            <a href=\"".$curent_url."product/".$value['id']."/edit\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_edit')."\">
                <img src=\"".$pluginStaticURL2."edit_section2.gif\" style=\"border:0;\">
            </a>
        </span>";
        $products .="<span style=\"\" class=\"ow_nowrap\">
            <a onclick=\"return confirm('Are you sure you want to delete?');\" href=\"".$curent_url."product/".$value['id']."/del\">
                <img src=\"".$pluginStaticURL2."erase3.gif\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_delete')."\" style=\"border:0;\">
            </a>
        </span>";

$products .="<div class=\"clearfix\" style=\"margin-top:10px;\">";
$products .=SHOPPRO_BOL_Service::getInstance()->make_file_downloadurl($value,"id");//download owned file
$products .="</div>";

$products .="</div>";

//$products .=SHOPPRO_BOL_Service::getInstance()->make_file_downloadurl($value,"id");//download owned file
/*
//                                    $products .="&nbsp;|&nbsp;";
                                    $products .="<a href=\"".$curent_url."product/".$value['id']."/del\" onclick=\"return confirm('Are you sure you want to delete?');\"  title=\"".OW::getLanguage()->text('shoppro', 'product_table_delete')."\">";
                                    $products .= "[-]";
                                    $products .="</a>";
                                    $products .="&nbsp;|&nbsp;";
                                    $products .="<a href=\"".$curent_url."product/".$value['id']."/edit\" title=\"".OW::getLanguage()->text('shoppro', 'product_table_edit')."\">";
                                    $products .= "[*]";
                                    $products .="</a>";
*/
                                }
$products .="</div>";




//----info start ZOOM - moved to right column
if (!OW::getConfig()->getValue('shoppro', 'hide_product_small_details')){
                    $tablex="";
                    $products .="<div class=\"clearfix\" style=\"display:inline-block;width:100%;float:left;text-align:left;font-size:12px;margin:10px\">";
//                    $products .="<hr/>";


//if (OW::getConfig()->getValue('shoppro', 'hide_seller_avatar_onthelist') && !OW::getConfig()->getValue('shoppro', 'hide_seller_small_icon')){
//                    $products .="<img border=\"0\" style=\"vertical-align:text-bottom;\" src=\"".$pluginStaticURL2."user.png\">&nbsp;".$dname;
//}


                    if (OW::getConfig()->getValue('shoppro', 'turn_on_ciew_couter')==1 OR (OW::getConfig()->getValue('shoppro', 'turn_on_ciew_couter')==2 AND (($value['id_owner']==$id_user AND $id_user>0) OR $is_admin) ) ){
                        $tablex .="<tr>";
                        $tablex .="<td style=\"white-space: nowrap;font-size:11px;text-align:right;\">";
                        $tablex .="<i>".OW::getLanguage()->text('shoppro', 'count_view')."</i>:&nbsp;";
                        $tablex .="</td><td style=\"white-space: nowrap;font-size:11px;\">";
                        $tablex .="<b>".$value['count_view']."</b>";
                        $tablex .="</td>";
                        $tablex .="</tr>";
                    }



                    if ($value['condition']!=""){
                        $tablex .="<tr>";
                        $tablex .="<td style=\"white-space: nowrap;font-size:11px;text-align:right;\">";
//                        if ($value['location']) $products .=", ";
//                        $products .=OW::getLanguage()->text('shoppro', 'product_condition').": ".stripslashes($value['condition']);
                        $tablex .="<i>".OW::getLanguage()->text('shoppro', 'product_condition')."</i>:&nbsp;";
                        $tablex .="</td><td style=\"white-space: nowrap;font-size:11px;\">";
                        if ($value['condition']==0){
                            $tablex .="<b>".OW::getLanguage()->text('shoppro', 'product_condition_na')."</b>";
                        }else if ($value['condition']==1){
                            $tablex .="<b>".OW::getLanguage()->text('shoppro', 'product_condition_new')."</b>";
                        }else if ($value['condition']==2){
                            $tablex .="<b>".OW::getLanguage()->text('shoppro', 'product_condition_used')."</b>";
                        }
//                        $products .="<br/>";
                        $tablex .="</td>";
                        $tablex .="</tr>";
                    }

/*
//$products .="--".$value['type_ads']."--".$value['classifieds_type']."--";
//                    if ($value['classifieds_type']>0 AND $value['type_ads']=="0"){
                    if ($value['classifieds_type']>0 AND $value['type_ads']=="0"){
                        $tablex .="<tr>";
                        $tablex .="<td style=\"white-space: nowrap;font-size:11px;text-align:right;\">";
                        $tablex .="<i>".OW::getLanguage()->text('shoppro', 'product_type_classifieds')."</i>:&nbsp;";
                        $tablex .="</td><td style=\"white-space: nowrap;font-size:11px;\">";
                        if ($value['classifieds_type']==1){
                            $tablex .="<b>".OW::getLanguage()->text('shoppro', 'product_available')."</b>";
                        }else if ($value['classifieds_type']==2){
                            $tablex .="<b>".OW::getLanguage()->text('shoppro', 'product_wanted')."</b>";
                        }
                        $tablex .="</td>";
                        $tablex .="</tr>";
                    }
*/
                     if ($value['type_ads']==0){
                        if ($value['classifieds_type']==1){
                            $tablex .="<tr>";
                            $tablex .="<td style=\"white-space: nowrap;font-size:11px;text-align:right;\">";
//                            if ($value['location'] OR $value['condition']>0) $products .=", ";
//                            $products .=OW::getLanguage()->text('shoppro', 'product_type_classifieds').": ".stripslashes($value['classifieds_type']);
                            $tablex .="<i>".OW::getLanguage()->text('shoppro', 'product_type_classifieds')."</i>: ";
                            $tablex .="</td><td style=\"white-space: nowrap;font-size:11px;\">";
                            $tablex .="<b>".OW::getLanguage()->text('shoppro', 'product_available')."</b>";
                            $tablex .="</td>";
                            $tablex .="</tr>";
                        }else if ($value['classifieds_type']==2){
                            $tablex .="<tr>";
                            $tablex .="<td style=\"white-space: nowrap;font-size:11px;text-align:right;\">";
//                            if ($value['location'] OR $value['condition']) $products .=", ";
                            $tablex .="<i>".OW::getLanguage()->text('shoppro', 'product_type_classifieds')."</i>:&nbsp;";
                            $tablex .="</td><td style=\"white-space: nowrap;font-size:11px;\">";
                            $tablex .="<b>".OW::getLanguage()->text('shoppro', 'product_wanted')."</b>";
                            $tablex .="</td>";
                            $tablex .="</tr>";
                        }
//                        $products .="<br/>";
                    }

                    if ($value['location']){
                        $tablex .="<tr>";
                        $tablex .="<td style=\"white-space: nowrap;font-size:11px;text-align:right;\">";
//                        if ($value['classifieds_type'] OR $value['condition']>0) $products .=", ";
//                        $products .=OW::getLanguage()->text('shoppro', 'product_location').": ".mb_substr(stripslashes($value['location']),0,20);
                        $tablex .="<i>".OW::getLanguage()->text('shoppro', 'product_location')."</i>:&nbsp;";
                        $tablex .="</td><td style=\"white-space: nowrap;font-size:11px;\">";
//                        $products .="<b>".mb_substr(stripslashes($value['location']),0,20)."</b>";
                        $loc=str_replace("'","",stripslashes($value['location']));
                        $loc=str_replace("\r\n","",$loc);
                        $loc=str_replace("\r","",$loc);
                        $loc=str_replace("\n","",$loc);
                        $loc=str_replace("\t","",$loc);
                        $loc=str_replace(" ","+",$loc);
                        $tablex .="<b><a href=\"https://maps.google.com/maps?tab=wl&q=".$loc."\" target=\"_blank\">".mb_substr(stripslashes($value['location']),0,20)."</a></b>";
//                        $products .="<br/>";
                        $tablex .="</td>";
                        $tablex .="</tr>";
                    }

                    if ($value['map_lat']!="" AND $value['map_lan']){
                        $tablex .="<tr>";
                        $tablex .="<td style=\"white-space: nowrap;font-size:11px;text-align:right;\">";
//                        if ($value['location']) $products .=", ";
//                        $products .=OW::getLanguage()->text('shoppro', 'product_condition').": ".stripslashes($value['condition']);
                        $tablex .="<i>".OW::getLanguage()->text('shoppro', 'map')."</i>:&nbsp;";
                        $tablex .="</td><td style=\"white-space: nowrap;font-size:11px;\">";
                        $loc=$value['map_lat'].",".$value['map_lan'];
                            $tablex .="<b><a href=\"http://maps.google.com/maps?tab=wl&q=".$loc."\" target=\"_blank\">".OW::getLanguage()->text('shoppro', 'show_location')."</a></b>";
//                        $products .="<br/>";
                        $tablex .="</td>";
                        $tablex .="</tr>";
                    }
                
                    if ($tablex){
                        $products .="<table>".$tablex."</table>";
                    }

                    $products .="</div>";
}else{//if if (!OW::getConfig()->getValue('shoppro', 'hide_product_small_details')){

                    if (OW::getConfig()->getValue('shoppro', 'turn_on_ciew_couter')==1 OR (OW::getConfig()->getValue('shoppro', 'turn_on_ciew_couter')==2 AND (($value['id_owner']==$id_user AND $id_user>0) OR $is_admin) ) ){

                        $tablex="";
                        $products .="<div class=\"clearfix\" style=\"display:inline-block;width:100%;float:left;text-align:left;font-size:12px;margin:10px\">";

                        $tablex .="<tr>";
                        $tablex .="<td style=\"white-space: nowrap;font-size:11px;text-align:right;\">";
                        $tablex .="<i>".OW::getLanguage()->text('shoppro', 'count_view')."</i>:&nbsp;";
                        $tablex .="</td><td style=\"white-space: nowrap;font-size:11px;\">";
                        $tablex .="<b>".$value['count_view']."</b>";
                        $tablex .="</td>";
                        $tablex .="</tr>";

                        if ($tablex){
                            $products .="<table>".$tablex."</table>";
                        }
                        $products .="</div>";
                    }

}
//----info end



                            $products .="</td>";
//--------------------------------------------------------------------koniec klawisza kup i profilu na zoomie








                                $products .="</tr>";
                                $products .="</table>";

//-----tlo
$products .="<div id=\"shop_overlay\" class=\"shop_dialog_overlay\"></div>";


//---------------aaaa
/*
        $allow_comments = true;
//        $owner=$link->getUserId();
        $owner=$value['id_owner'];
//        $id_pos=$link->getId();
        $id_pos=$value['id'];

        $cmpParams = new BASE_CommentsParams('shoppro', 'shop');
        $cmpParams->setEntityId($id_pos)
            ->setOwnerId($owner)
            ->setDisplayType(1)
            ->setAddComment($allow_comments);

        echo $this->addComponent('comments', new BASE_CMP_Comments($cmpParams));
*/
/*
$params = new BASE_CommentsParams('base', 'sardar');
$params->setEntityId(2);
$params->setCommentCountOnPage(5);
echo $this->addComponent('comments', new BASE_CMP_Comments($params));
echo $this->addComponent('rate', new BASE_CMP_Rate('blog', 1, 1, 1));
*/
/*
$cmtParams = new BASE_CommentsParams('video', 'video_comments');
        $cmtParams->setEntityId($id);
        $cmtParams->setOwnerId($contentOwner);
        $cmtParams->setDisplayType(2);
        $videoCmts = new BASE_CMP_Comments($cmtParams);
        $this->addComponent('comments', $videoCmts);
//echo $commentService->findCommentedEntityCount('blog-post');
//echo  BOL_CommentService::getInstance()->findCommentCountForEntityList('links',$cmtParams);
*/
//---------------aaaaa


//=====todo show menu in zoom mode start
/*
            if (OW::getConfig()->getValue('shoppro', 'mode')==0 OR !OW::getConfig()->getValue('shoppro', 'mode')){
                $content .="<div style=\"display:inline-block;width:98%;margin:auto;\" >";//ZZZ zisednaru AAA
                $menu=$this->make_menu($params['idcat']);
//    	        $content .="<div style=\"position:relative;float:right;border:1px solid #ddd;display:inline-block;width:180px;\">";
//    	        $content .="<div style=\"position:relative;float:right;display:inline-block;width:180px;\">";
    	        $content .="<div style=\"position:relative;float:right;display:inline-block;width:23%;\">";
//                $content .=$menu;

$content .="<div class=\"ow_dnd_widget index-BASE_CMP_MyAvatarWidget\" style=\"width:205px;;margin:auto;\">
    <div class=\"ow_box_cap ow_dnd_configurable_component clearfix\" >
        <div class=\"ow_box_cap_right\">
            <div class=\"ow_box_cap_body\">
                <h3 class=\"ow_ic_shop\">".OW::getLanguage()->text('shoppro', 'product_table_category')."</h3>
            </div>
        </div>
    </div>
    
    <div class=\"ow_box ow_stdmargin clearfix index-BASE_CMP_MyAvatarWidget ow_no_cap ow_break_word\" style=\"\">
        <div class=\"ow_my_avatar_widget\">
            <div class=\"ow_left\">
".$menu."
            </div>
        </div>
        <div class=\"ow_box_bottom_left\"></div>
        <div class=\"ow_box_bottom_right\"></div>
        <div class=\"ow_box_bottom_body\"></div>
        <div class=\"ow_box_bottom_shadow\"></div>
    </div>
</div>";




                $content .="</div>";
//                $main_width="74%";
//            }else{
                $content .="<div style=\"display:inline-block;width:100%;margin:auto;\" >";//bes zisednaru AAA
                $main_width="100%";
            }
//=====todo show menu in zoom mode end

*/









//                    $content .="<div class=\"ow_stdmargin\" style=\"display:inline-block;width:100%;margin:auto;\">".$products."</div>";
//                    $content .=$products;
        $content .="<div id=\"product_".$value['id']."\" class=\"products_tocart clearfix\" style=\"word-wrap:break-word;\">";
//                    $content .="<div class=\"ow_content_html\">".$products."</div>";
                    $content .="<div class=\"ow_content\" style=\"word-wrap:break-word;\">".$products."</div>";
        $content .="</div>";





                $this->setPageTitle(stripslashes($value['name'])); //title menu
//                $this->setPageHeading(stripslashes($value['name'])." (".OW::getLanguage()->text('shoppro', 'product_table_price').": ".$value['price'].")"); //title page
                $this->setPageHeading(stripslashes($value['name'])); //title page


                if (OW::getConfig()->getValue('shoppro', 'turn_on_commntsandrate') AND isset($params['idproduct']) AND $params['idproduct']>0 AND $params['idproduct']==$value['id']){
//                    OW::getDocument()->addScript(OW_URL_HOME.'ow_static/plugins/shoppro/extr/jquery.raty.min.js');
                    //if ($value['id_owner']==$id_user AND $id_user>0){
                     if ((!$id_user OR $value['id_owner']==$id_user) AND !$is_admin){
                        $content .=SHOPPRO_BOL_Service::getInstance()->make_comment_form($params['idproduct'],"shop","product/".$value['id']."/zoom/product_details.html",true,true,20,"shoppro",true);
                    }else{
                        $content .=SHOPPRO_BOL_Service::getInstance()->make_comment_form($params['idproduct'],"shop","product/".$value['id']."/zoom/product_details.html",true,true,20,"shoppro",false);
                    }
                }

        $content_t=SHOPPRO_BOL_Service::getInstance()->make_tabs("zoomproduct",$content);

//resize iframe product content
$add_script="
    var h =$('#shopmaincontentproduct').contents().find('#iframecontent').height();
    $('#shopmaincontentproduct').css('height',h + 25 + 'px');

";
        OW::getDocument()->addOnloadScript($add_script);

$add_script="
<script>
function insertIt() {
var h =$('#shopmaincontentproduct').contents().find('#iframecontent').height();
$('#shopmaincontentproduct').css('height',h + 25 + 'px');
}
</script>
";
        OW::getDocument()->appendBody($add_script);

//echo "SDfsdF";exit;
//------------at end of zoom start   bottom products list POWTORZONE NA ZOOMIE
//--------------------popup start
            $content_t .=SHOPPRO_BOL_Service::getInstance()->make_popup_inquire_dialog("myModal");
//--------------------popup end
//------------at end of zoom end


                if (OW::getConfig()->getValue('shoppro', 'turn_on_ciew_couter')>0 ){//add count view
                    SHOPPRO_BOL_Service::getInstance()->inc_view($value['id']);
                }


                $this->assign('content', $content_t);
            }else{

                OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'product_not_found_orwaitingforaprove'));
                $this->assign('content', OW::getLanguage()->text('shoppro', 'product_not_found'));
            }
        }else{

            $this->assign('content', OW::getLanguage()->text('shoppro', 'product_not_found'));
        }


    }
	




    public function delcat($params)
    {
        $content="";
                    $id_user = OW::getUser()->getId();//citent login user (uwner)
                    $is_admin = OW::getUser()->isAdmin();//iss admin

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

            if ($is_admin AND $id_user>0){//edit dir
                if ($params['optionadm']=="del" AND $params['idcat']>0){
                    $query = "DELETE FROM " . OW_DB_PREFIX. "shoppro_categories WHERE id='".addslashes($params['idcat'])."' LIMIT 1";
                    $arr = OW::getDbo()->query($query);
                    $query = "UPDATE " . OW_DB_PREFIX. "shoppro_products SET cat_id='0' WHERE cat_id='".addslashes($params['idcat'])."' ";
                    $arr = OW::getDbo()->query($query);
                    
                }

            }

//            $this->assign('content', $content);
            OW::getApplication()->redirect($curent_url."shop");
    }

	
    public function editcat($params)
    {
        $content="";
                    $id_user = OW::getUser()->getId();//citent login user (uwner)
                    $is_admin = OW::getUser()->isAdmin();//iss admin


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

            if (!$is_admin OR !$id_user>0){//edit dir
                OW::getApplication()->redirect($curent_url."shop");
            }
$value['id']="";
        $ctitle="";
        $active=0;
        $csort=0;
$csub=0;
$cgroup=0;
            if ($params['optionadm']=="edit" AND $params['idcat']>0){
                $query = "SELECT * FROM " . OW_DB_PREFIX. "shoppro_categories WHERE id='".addslashes($params['idcat'])."' LIMIT 1";
                $arr = OW::getDbo()->queryForList($query);
                $value=$arr[0];
                $ctitle=stripslashes($value['name']);
                $active=$value['active'];
                $csort=$value['sort'];
                $csub=$value['id2'];
                $cgroup=$value['id_cgroup'];
            }

        $content .="<div class=\"clearfix ow_alt2\">";
//        $content .="<form>";
//            $content .="<form action=\"".$curent_url."product/".$params['idproduct']."/adds\" method=\"POST\" enctype=\"multipart/form-data\">";
            $content .="<form action=\"".$curent_url."shop\" method=\"POST\" >";
        if ($value['id']>0){
            $content .="<input type=\"hidden\" name=\"caction\" value=\"update\">";
            $content .="<input type=\"hidden\" name=\"cactionid\" value=\"".$value['id']."\">";
        }else{
            $content .="<input type=\"hidden\" name=\"caction\" value=\"insert\">";
        }
        

        $content .="<table>";

            $content .="<tr>";

            $content .="<td align=\"right\" valign=\"top\" colspan=\"2\">";
//            $content .="<input type=\"submit\" name=\"submit\" value=\"Submit\" />";
            $content .="<a href=\"".$curent_url."shop\">";
            $content .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_left\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"button\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'goback')."\" class=\"ow_ic_left_arrow ow_positive\">
                        </span>
                    </span>
                </div>
            </div>";
            $content .="</a>";
            $content .="</td>";
            $content .="</tr>";

        $content .="<tr>";
        $content .="<td>";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'product_table_group').":</b>";
        $content .="</td>";
        $content .="<td>";
        $content .="<select name=\"cgroup\">";
            $content .=SHOPPRO_BOL_Service::getInstance()->make_group_li($cgroup,'li');
//        $content .="<input type=\"text\" name=\"ctitle\" value=\"".$ctitle."\">";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";


        $content .="<tr>";
        $content .="<td>";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'product_table_category').":</b>";
        $content .="</td>";
        $content .="<td>";
        $content .="<input type=\"text\" name=\"ctitle\" value=\"".$ctitle."\">";
        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td>";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'product_table_subcategory').":</b>";
        $content .="</td>";
        $content .="<td>";
        $content .="<select name=\"csub\">";
//$group_id=0,$first_time=true,$type="html",$selected=0,$id_langcat=0,$content="",$id2=0,$zone=0
            $content .=SHOPPRO_BOL_Service::getInstance()->make_menu_ul($cgroup,true,'li',$csub);
//        $content .="<input type=\"text\" name=\"ctitle\" value=\"".$ctitle."\">";
        $content .="</select>";
        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td>";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'product_table_active').":</b>";
        $content .="</td>";
        $content .="<td>";
        if ($active){
            $sel=" checked ";
        }else{
            $sel=" ";
        }
        $content .="<input ".$sel." type=\"checkbox\" name=\"cactive\" value=\"1\">";
        $content .="</td>";
        $content .="</tr>";

        $content .="<tr>";
        $content .="<td>";
        $content .="<b>".OW::getLanguage()->text('shoppro', 'product_table_sort').":</b>";
        $content .="</td>";
        $content .="<td>";
        $content .="<input type=\"text\" name=\"csort\" value=\"".$csort."\">";
        $content .="</td>";
        $content .="</tr>";


            $content .="<tr>";
            $content .="<td valign=\"top\">";
            $content .="</td>";
            $content .="<td align=\"right\" valign=\"top\">";
//            $content .="<input type=\"submit\" name=\"submit\" value=\"Submit\" />";
            $content .="<div class=\"clearfix ow_submit ow_smallmargin\">
                <div class=\"ow_center\">
                    <span class=\"ow_button\">
                        <span class=\" ow_positive\">
                            <input type=\"submit\" name=\"ok\" value=\"".OW::getLanguage()->text('shoppro', 'config_save')."\" class=\"ow_ic_save ow_positive\">
                        </span>
                    </span>
                </div>
            </div>";
            $content .="</td>";
            $content .="</tr>";


        $content .="</table>";
        $content .="</form>";
        $content .="</div>";

            $this->assign('content', $content);
    }
	
	
	
	
	public function make_menu($selected=0)
	{
	           $content="";
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


if ($url_detect[0]=="/") {
    $url_detect=substr($url_detect,1);
}
list($url_detect)=explode("/",$url_detect);


//print_r($trash);
//echo $url_detect;

		
        if ($url_detect=="shop" OR $url_detect=="shopmy" OR $url_detect=="shoppro" OR $url_detect=="shoppro_adm" OR $url_detect=="basket" OR $url_detect=="order" OR $url_detect=="ordershop" OR $url_detect=="product"){
//        if (1==1){

            $content =SHOPPRO_BOL_Service::getInstance()->make_menu($selected);
/*
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
*/
        }else{
            $content  ="<script>\n";
            $content .="\$(document).ready(function(){\n";
            $content .="\$(\".index-SHOPPRO_CMP_MenuWidget\").empty().remove();\n";
            $content .="    });\n";
            $content .="</script>";
        }
		return $content;
	}
	
    public function make_seo_url($name,$lengthtext=100)
    {
        $seo_sep="-";//- or _
        $seo_title=stripslashes($name);
        $seo_title=str_ireplace($seo_sep," ",$seo_title);
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

        $seo_title=str_ireplace("  "," ",$seo_title);
        $seo_title=str_ireplace(" ",$seo_sep,$seo_title);
        $seo_title=str_ireplace("/","",$seo_title);
        $seo_title=str_ireplace("?",$seo_sep,$seo_title);
        $seo_title=str_ireplace("#",$seo_sep,$seo_title);
        $seo_title=str_ireplace("=",$seo_sep,$seo_title);
        $seo_title=str_ireplace("=",$seo_sep,$seo_title);
        $seo_title=str_ireplace("&amp;",$seo_sep,$seo_title);

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
	
public function remove_html($string) { 
    
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
 	
	
/*
    public function add_to_wall($last_insert_id=0,$action_name="",$url_to_ads="",$title_post="", $action_key="")
    {
        $id_user = OW::getUser()->getId();//citent login user (uwner)
        if ($id_user AND $title_post){
            SHOPPRO_BOL_Service::getInstance()->tonewsfeed("create",$title_post);
        }
    }
*/
	
	
//    public function add_to_wallOLLLLLLD($last_insert_id=0,$action_name="",$url_to_ads="",$title_post="", $action_key="")
    public function add_to_wall($last_insert_id=0,$action_name="",$url_to_ads="",$title_post="", $action_key="")
    {
//---------------------------------feed start
        $id_user = OW::getUser()->getId();//citent login user (uwner)
                    $curent_url = 'http';
                    if (isset($_SERVER["HTTPS"])) {$curent_url .= "s";}
                    $curent_url .= "://";
                    $curent_url .= $_SERVER["SERVER_NAME"]."/";
$curent_url=OW_URL_HOME;                                        

$action_name=SHOPPRO_BOL_Service::getInstance()->html2txt($action_name);
$title_post=SHOPPRO_BOL_Service::getInstance()->html2txt($title_post);

/*
$from_config=$curent_url;
$from_config=str_replace("https://","",$from_config);
$from_config=str_replace("http://","",$from_config);
$trash=explode($from_config,$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);
$url_detect=$trash[1];
//print_r($trash);
//echo $url_detect;
*/
                    $is_ok=false;

//                if ($last_insert_id>0){
            if ($id_user AND $action_name AND ($url_to_ads AND $title_post) AND $last_insert_id>0){
//                    $timestamp=strtotime(date('Y-m-d',time()));
                    $timestamp=strtotime(date('Y-m-d H:i:s'));
/*
$xx=date('Y-m-d H:i:s');
echo $xx;
echo "<hr>";
echo UTIL_DateTime::parseDate($xx);
echo "<hr>";
print_r(UTIL_DateTime::parseDate($xx,UTIL_DateTime::MYSQL_DATETIME_DATE_FORMAT));
//if ( !UTIL_Validator::isDateValid($date[UTIL_DateTime::PARSE_DATE_MONTH], $date[UTIL_DateTime::PARSE_DATE_DAY], $date[UTIL_DateTime::PARSE_DATE_YEAR]) )
exit;
*/
//OW::getConfig()->getValue('base', 'date_field_format');
/*
$xx=date('Y-m-d H:i:s');
echo $xx;
if (OW::getConfig()->getValue('base', 'site_timezone')){
    ini_set('date.timezone', OW::getConfig()->getValue('base', 'site_timezone'));
//    echo OW::getConfig()->getValue('base', 'site_timezone');
}
echo "<hr>";
$xx=date('Y-m-d H:i:s');
echo $xx;
exit;
*/

//                    $subject="Added a new page";//from param
//                    $url_to_ads=$curent_url."html/".$id_user."/".$last_insert_id."/index.html";//from param

                    $title_post_lenght=255;
                    if ($action_key) {
                        $entityType=$action_key;//ident in wall!!!!!!!!!!!
                    }else{
                        $entityType="shoppro_add_product";//ident in wall!!!!!!!!!!!
                    }
                    $pluginKey="shoppro";//plugin key!!!!!

//                    $curent_url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
                    $array_toolbar[0]=array("href" => $url_to_ads, "label" => "URL");
                    $array=array(
                        "time" => "".$timestamp."",
                        "ownerId" => "".$id_user."",
                        "string" => "".mb_substr($action_name,0,$title_post_lenght)."",
                        "content" => "<a href=\"".$url_to_ads."\">".$url_to_ads."</a>\r\n<div class=\"ow_remark\" style=\"paddig-top: 4px\">".mb_substr($title_post,0,$title_post_lenght)."</div>",
                        "view" => array("iconClass" => "ow_ic_link"),
                        "toolbar" => array_values($array_toolbar)
                    );
                    $datadata=json_encode($array);

                    //------check for exist start
                    $query = "SELECT * FROM " . OW_DB_PREFIX. "newsfeed_action  WHERE entityId='".addslashes($last_insert_id)."' AND entityType='".addslashes($entityType)."' AND pluginKey='".addslashes($pluginKey)."' LIMIT 1";
                    $arrx = OW::getDbo()->queryForList($query);
                    if (isset($arrx[0])){
                        $value=$arrx[0];
                    }else{
                        $value['id']="";
                    }
                    if (!$value['id']){
//                        $uniquer_prefix=OW::getConfig()->getValue('shoppro', 'mode_uniquer_prefix');
                        $uniquer_prefix="_".md5(date('Y-m-d-H-m-s'));
                    }else{
                        $uniquer_prefix="";
                    }
                    //------check for exist end
//                if (!$value['id']){
                    $query = "INSERT INTO " . OW_DB_PREFIX. "newsfeed_action  (
                        id ,     entityId ,       entityType ,     pluginKey   ,    data
                    )VALUES(
                        '','".addslashes($last_insert_id)."','".addslashes($entityType.$uniquer_prefix)."','".addslashes($pluginKey)."','".addslashes($datadata)."'
                    )";
//echo "(1)".$query;
                    $last_insert_id_a = OW::getDbo()->insert($query);
                    if ($last_insert_id_a>0){
                        $query = "INSERT INTO " . OW_DB_PREFIX. "newsfeed_action_set  (
                            id , actionId ,       userId,  timestamp
                        )VALUES(
                            '','".addslashes($last_insert_id_a)."','".addslashes($id_user)."','".addslashes($timestamp)."'
                        )";
                        $last_insert_id_as = OW::getDbo()->insert($query);
                        if ($last_insert_id_as>0){
                            $query = "INSERT INTO " . OW_DB_PREFIX. "newsfeed_activity  (
                                id ,     activityType,    activityId ,     userId  ,data ,   actionId  ,      timeStamp ,      privacy ,visibility    ,  status
                            )VALUES(
                                '','create','1','".addslashes($id_user)."','[]','".addslashes($last_insert_id_a)."','".addslashes($timestamp)."','everybody','15','active'
                            )";
                            $last_insert_id_ac = OW::getDbo()->insert($query);
                            if ($last_insert_id_ac>0){
                                $query = "INSERT INTO " . OW_DB_PREFIX. "newsfeed_action_feed  (
                                    id , feedType ,feedId , activityId
                                )VALUES(
                                    '','user','1','".addslashes($last_insert_id_ac)."'
                                )";
                                $last_insert_id_af = OW::getDbo()->insert($query);
                                if (!$last_insert_id_af){
                                    $query="DELETE FROM " . OW_DB_PREFIX. "newsfeed_action WHERE id='".addslashes($last_insert_id_a)."' LIMIT 1";
                                    $arr = OW::getDbo()->query($query); 
                                    $query="DELETE FROM " . OW_DB_PREFIX. "newsfeed_action_set WHERE id='".addslashes($last_insert_id_as)."' LIMIT 1";
                                    $arr = OW::getDbo()->query($query); 
                                    $query="DELETE FROM " . OW_DB_PREFIX. "newsfeed_activity WHERE id='".addslashes($last_insert_id_ac)."' LIMIT 1";
                                    $arr = OW::getDbo()->query($query); 
                                }else{
                                    $is_ok=true;
                                }
                            }else{
                                $query="DELETE FROM " . OW_DB_PREFIX. "newsfeed_action WHERE id='".addslashes($last_insert_id_a)."' LIMIT 1";
                                $arr = OW::getDbo()->query($query); 
                                $query="DELETE FROM " . OW_DB_PREFIX. "newsfeed_action_set WHERE id='".addslashes($last_insert_id_as)."' LIMIT 1";
                                $arr = OW::getDbo()->query($query); 
                            }

                        }else{//end 2
                            $query="DELETE FROM " . OW_DB_PREFIX. "newsfeed_action WHERE id='".addslashes($last_insert_id_a)."' LIMIT 1";
                            $arr = OW::getDbo()->query($query); 
                        }
                    }//end1
//                }//if (!$value['id']){
            }
            return $is_ok;
//---------------------------------getInsertId

    }//func	
	
	
	
	
	
	
	
	
	
	
	
	
    public function sent()
    {
	
        $dept = null;

        if ( OW::getSession()->isKeySet('shoppro.dept') )
        {
            $dept = OW::getSession()->get('shoppro.dept');
            OW::getSession()->delete('shoppro.dept');
        }
        else
        {
            $this->redirectToAction('index');
        }

        $feedback = $this->text('shoppro', 'message_sent', ( $dept === null ) ? null : array('dept' => $dept));
        $this->assign('feedback', $feedback);

    }


    public function indexsavecommnt($params)
    {
        $curent_url=OW_URL_HOME;
        $id_user = OW::getUser()->getId();
        if (!$id_user){
            OW::getFeedback()->error(OW::getLanguage()->text('shoppro', 'you_must_first_login'));
            OW::getApplication()->redirect($curent_url."sign-in?back-uri=shop");
            exit;
        }
        //shop/commentdel/:idevent/:entityId/:pluginkey/:ss
        //shop/commentdel/:opt/:idevent/:entityId/:pluginkey/:ss
        if (isset($params['opt']) AND isset($params['idevent']) AND isset($params['entityId']) AND isset($params['pluginkey']) AND isset($params['ss']) AND $params['opt']=="del" AND $params['ss']==substr(session_id(),2,5) AND $params['idevent']>0 AND $params['entityId']>0 AND $params['pluginkey']){
            $sql="SELECT * FROM " . OW_DB_PREFIX. "base_comment_entity WHERE pluginKey='".addslashes($params['pluginkey'])."' AND entityId='".addslashes($params['entityId'])."' LIMIT 1";
            $arrx = OW::getDbo()->queryForList($sql);
            if (isset($arrx[0]) AND $arrx[0]['id']>0){

                $sql="DELETE FROM " . OW_DB_PREFIX. "base_comment WHERE commentEntityId='".addslashes($arrx[0]['id'])."' AND id='".addslashes($params['idevent'])."' LIMIT 1";
                OW::getDbo()->query($sql);

                //check exist comment
                $sql="SELECT * FROM " . OW_DB_PREFIX. "base_comment WHERE commentEntityId='".addslashes($arrx[0]['id'])."' LIMIT 1";
                $arrxc = OW::getDbo()->queryForList($sql);
                if (!isset($arrxc[0]) OR !$arrxc[0]['id']){
                    $sql="DELETE FROM " . OW_DB_PREFIX. "base_comment_entity WHERE pluginKey='".addslashes($params['pluginkey'])."' AND entityId='".addslashes($params['entityId'])."' LIMIT 1";
                    OW::getDbo()->query($sql);
                }
            }
            OW::getApplication()->redirect($curent_url."product/".$params['entityId']."/zoom/product_details.html");
            exit;
        }


        $event_type="";
        $idevent=0;
        $return_url="shop";
        $pluginkey="shoppro";
        if (isset($params['idevent'])) $idevent=$params['idevent'];
        if (isset($params['event_type'])) $event_type=$params['event_type'];
        if (isset($params['return_url'])) $return_url=$params['return_url'];
        if (isset($params['pluginkey'])) $pluginkey=$params['pluginkey'];

        if (isset($_POST['conetnt'])) $conetnt=$_POST['conetnt'];
            else $conetnt="";
        if ($idevent>0 AND $event_type AND $conetnt){
            SHOPPRO_BOL_Service::getInstance()->save_comment($conetnt,$idevent,$event_type,$pluginkey,$return_url);
        }
        if ($idevent>0){
            OW::getApplication()->redirect($curent_url."product/".$idevent."/zoom/product_commented.html");
        }else{
            OW::getApplication()->redirect($curent_url."shop");
        }
        exit;
    }

    public function indexsaverate($params)
    {
        $curent_url=OW_URL_HOME;
        if (isset($_POST['ss'])) $ss=$_POST['ss'];
            else $ss="";

        $id_user = OW::getUser()->getId();
        if (!$id_user OR $ss!=substr(session_id(),3,5)){
            if (!$id_user){
            }
            echo "error";
            exit;
        }

        $event_type="";
        $idevent=0;
        $return_url="shop";
        $pluginkey="shoppro";
        if (isset($params['idevent'])) $idevent=$params['idevent'];
        if (isset($params['event_type'])) $event_type=$params['event_type'];
        if (isset($params['score'])) $score=$params['score'];
            else $score=0;
        if (isset($params['pluginkey'])) $pluginkey=$params['pluginkey'];

        if ($idevent>0 AND $event_type AND $score!=""){
            SHOPPRO_BOL_Service::getInstance()->save_rate($score,$idevent,$event_type,$pluginkey,$return_url);
        }
        exit;
    }




    private function text( $prefix, $key, array $vars = null )
    {
        return OW::getLanguage()->text($prefix, $key, $vars);
    }
}



class paypal_class {
    
   var $last_error;                 // holds the last error encountered
   
   var $ipn_log;                    // bool: log IPN results to text file?
   var $ipn_log_file;               // filename of the IPN log
   var $ipn_response;               // holds the IPN response from paypal   
   var $ipn_data = array();         // array contains the POST values for IPN
   
   var $fields = array();           // array holds the fields to submit to paypal

   
   function paypal_class() {
       
      // initialization constructor.  Called when class is created.
      
//      $this->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
    $this->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';

//$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
//$p->host = 'www.paypal.com';
      
      $this->last_error = '';
      
      $this->ipn_log_file = 'ipn_log.txt';
      $this->ipn_log = true;
      $this->ipn_response = '';
      
      // populate $fields array with a few default values.  See the paypal
      // documentation for a list of fields and their data types. These defaul
      // values can be overwritten by the calling script.

      $this->add_field('rm','2');           // Return method = POST
      $this->add_field('cmd','_xclick'); 
      
   }
   
   function add_field($field, $value) {
      
      // adds a key=>value pair to the fields array, which is what will be 
      // sent to paypal as POST variables.  If the value is already in the 
      // array, it will be overwritten.
      
      $this->fields["$field"] = $value;
   }

   function submit_paypal_post() {
 
      // this function actually generates an entire HTML page consisting of
      // a form with hidden elements which is submitted to paypal via the 
      // BODY element's onLoad attribute.  We do this so that you can validate
      // any POST vars from you custom form before submitting to paypal.  So 
      // basically, you'll have your own form which is submitted to your script
      // to validate the data, which in turn calls this function to create
      // another hidden form and submit to paypal.
 
      // The user will briefly see a message on the screen that reads:
      // "Please wait, your order is being processed..." and then immediately
      // is redirected to paypal.

//$header .="POST /cgi-bin/webscr HTTP/1.1\r\n";
//$header .="Content-Type: application/x-www-form-urlencoded\r\n";
//$header .="Host: www.paypal.com\r\n";

//header('Content-Type: application/x-www-form-urlencoded');
//aron22
//header('Host: www.paypal.com');

      echo "<html>\n";
      echo "<head><title>Processing Payment...</title></head>\n";
      echo "<body onLoad=\"document.form.submit();\">\n";
      echo "<center><h3>Please wait, your order is being processed...</h3></center>\n";
      echo "<form method=\"post\" name=\"form\" action=\"".$this->paypal_url."\">\n";

      foreach ($this->fields as $name => $value) {
         echo "<input type=\"hidden\" name=\"$name\" value=\"$value\">";
      }
 
      echo "</form>\n";
      echo "</body></html>\n";
    exit;
   }
   
   function validate_ipn() {



      // parse the paypal URL
      $url_parsed=parse_url($this->paypal_url);        
//print_r($url_parsed);
      // generate the post string from the _POST vars aswell as load the
      // _POST vars into an arry so we can play with them from the calling
      // script.
      $post_string = '';    
      foreach ($_POST as $field=>$value) { 
         $this->ipn_data[$field] = $value;
         $post_string .= $field.'='.urlencode($value).'&'; 
      }
      $post_string.="cmd=_notify-validate"; // append ipn command

      // open the connection to paypal
      $fp = fsockopen($url_parsed['host'],"80",$err_num,$err_str,30); 
//echo "--".$fp;
//echo "afdsF";
      if(!$fp) {
          
         // could not open the connection.  If loggin is on, the error message
         // will be in the log.
         $this->last_error = "fsockopen error no. $errnum: $errstr";
         $this->log_ipn_results(false);       

         return false;
         
      } else { 
 
         // Post the data back to paypal
         fputs($fp, "POST ".$url_parsed['path']." HTTP/1.1\r\n");
//         fputs($fp, "POST /cgi-bin/webscr HTTP/1.1\r\n"); //from email
         fputs($fp, "Content-Type: application/x-www-form-urlencoded\r\n"); 
         fputs($fp, "Host: ".$url_parsed['host']."\r\n");
//         fputs($fp, "Host: www.paypal.com\r\n"); //form email

         fputs($fp, "Content-length: ".strlen($post_string)."\r\n"); 
         fputs($fp, "Connection: close\r\n\r\n"); 
         fputs($fp, $post_string . "\r\n\r\n"); 

         // loop through the response from the server and append to variable
         while(!feof($fp)) { 
            $this->ipn_response .= fgets($fp, 1024); 
//echo 
         } 
//$this->ipn_response;
         fclose($fp); // close connection

      }

/*
$fp = fopen('LOG_SHOP_data.txt', 'a');
fwrite($fp, "\n---------IPN RESPONSE START1----\n");
//fwrite($fp, "IPN: ".$p->validate_ipn());
fwrite($fp, "\n----------IPN RESPONSE START2----\n");
fwrite($fp, print_r($_POST,1));
fwrite($fp, "\n");
fwrite($fp, print_r($_GET,1));
fwrite($fp, "\n-------------\n");
fwrite($fp, print_r($_SESSION,1));
fwrite($fp, "\n-------------\n");
fwrite($fp, $this->ipn_response);
fwrite($fp, "\n----------IPN RESPONSE END----\n");
fclose($fp);

*/
      
//echo $this->ipn_response;exit;
      if (eregi("VERIFIED",$this->ipn_response)) {


  
         // Valid IPN transaction.
         $this->log_ipn_results(true);
         return true;       
         
      } else {
  
         // Invalid IPN transaction.  Check the log for details.
         $this->last_error = 'IPN Validation Failed.';
         $this->log_ipn_results(false);   
         return false;
         
      }
      
   }
   
   function log_ipn_results($success) {
       
      if (!$this->ipn_log) return;  // is logging turned off?
      
      // Timestamp
      $text = '['.date('m/d/Y g:i A').'] - '; 
      
      // Success or failure being logged?
      if ($success) $text .= "SUCCESS!\n";
      else $text .= 'FAIL: '.$this->last_error."\n";
      
      // Log the POST variables
      $text .= "IPN POST Vars from Paypal:\n";
      foreach ($this->ipn_data as $key=>$value) {
         $text .= "$key=$value, ";
      }
 
      // Log the response from the paypal server
      $text .= "\nIPN Response from Paypal Server:\n ".$this->ipn_response;
      
      // Write to log
      $fp=fopen($this->ipn_log_file,'a');
      fwrite($fp, $text . "\n\n"); 

      fclose($fp);  // close file
   }

   function dump_fields() {
 
      // Used for debugging, this function will output all the field/value pairs
      // that are currently defined in the instance of the class using the
      // add_field() function.
      
      echo "<h3>paypal_class->dump_fields() Output:</h3>";
      echo "<table width=\"95%\" border=\"1\" cellpadding=\"2\" cellspacing=\"0\">
            <tr>
               <td bgcolor=\"black\"><b><font color=\"white\">Field Name</font></b></td>
               <td bgcolor=\"black\"><b><font color=\"white\">Value</font></b></td>
            </tr>"; 
      
      ksort($this->fields);
      foreach ($this->fields as $key => $value) {
         echo "<tr><td>$key</td><td>".urldecode($value)."&nbsp;</td></tr>";
      }
 
      echo "</table><br>"; 
   }



}  


















//---------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------przelewy24.pl
//---------------------------------------------------------------------------------------------------------------------------------------
class Przelewy24 {
//    const PAY_URL = 'https://sklep.przelewy24.pl/zakup.php';
    const PAY_URL = 'https://secure.przelewy24.pl';

    public static function redirectToPayment($data, $exit = false) {

        if (OW::getConfig()->getValue('shoppro', 'mode_payment')!="przelewy24"){
            OW::getFeedback()->info(OW::getLanguage()->text('shoppro', 'error'));
            OW::getApplication()->redirect($curent_url."shop");
        }

//    $url = self::PAY_URL . '?' . http_build_query($data);
    $url = self::PAY_URL. '?s=' . substr(session_id(),4,10);
//print_r($data);exit;

$p24_session_id=$data['p24_session_id'];
$p24_merchant=$data['p24_id_sprzedawcy'];
$p24_amount=$data['p24_kwota'];
$p24_desc=$data['p24_opis'];
$p24_klient=$data['p24_klient'];
$p24_adress=$data['p24_adres'];
$p24_postcode=$data['p24_kod'];
$p24_city=$data['p24_miasto'];
$p24_country=$data['p24_kraj'];
$p24_mail=$data['p24_email'];
$p24_language=$data['p24_language'];
$continueurl=$data['p24_return_url_ok'];
$callbackurl=$data['p24_return_url_error'];

$output = "<div style=\"display:none;\"><form id=\"przelewy24Form\" name=\"przelewy24Form\" action=\"".$url."\" method=\"post\">
    <input type=\"hidden\" name=\"p24_session_id\" value=\"".$p24_session_id."\" />
    <input type=\"hidden\" name=\"p24_id_sprzedawcy\" value=\"".$p24_merchant."\" />
    <input type=\"hidden\" name=\"p24_kwota\" value=\"".$p24_amount."\" />   
    <input type=\"hidden\" name=\"p24_opis\" value=\"".iconv("UTF-8","ISO-8859-2",$p24_desc)."\" />
    <input type=\"hidden\" name=\"p24_klient\" value=\"".iconv("UTF-8","ISO-8859-2",$p24_klient)."\" />
    <input type=\"hidden\" name=\"p24_adres\" value=\"".iconv("UTF-8","ISO-8859-2",$p24_adress)."\" />    
    <input type=\"hidden\" name=\"p24_kod\" value=\"".$p24_postcode."\" />
    <input type=\"hidden\" name=\"p24_miasto\" value=\"".iconv("UTF-8","ISO-8859-2",$p24_city)."\" />
    <input type=\"hidden\" name=\"p24_kraj\" value=\"".$p24_country."\" />
    <input type=\"hidden\" name=\"p24_email\" value=\"".$p24_mail."\" />
    <input type=\"hidden\" name=\"p24_language\" value=\"".$p24_language."\" />
    <input type=\"hidden\" name=\"p24_return_url_ok\" value=\"".$continueurl."\" />
    <input type=\"hidden\" name=\"p24_return_url_error\" value=\"".$callbackurl."\" />
    <input type=\"submit\" value=\"Pay\" />
</form></div>";

echo $output;
echo "<script language=\"javascript\" type=\"text/javascript\">document.getElementById('przelewy24Form').submit();</script>";

        printf(
            'Redirecting to <a href="%s">%s</a>. Please wait.',
            htmlentities($url, ENT_QUOTES, 'UTF-8'),
            htmlentities($url, ENT_QUOTES, 'UTF-8')
        );

        if ($exit) {
            exit();
        }
/*
        $url_parsed_host="secure.przelewy24.pl";
        $url_parsed_path="index.php";

      // parse the paypal URL
//      $url_parsed=parse_url($this->paypal_url);

      // generate the post string from the _POST vars aswell as load the
      // _POST vars into an arry so we can play with them from the calling
      // script.
      $post_string = '';    
      foreach ($data as $field=>$value) { 
         $post_string .= $field.'='.urlencode($value).'&'; 
      }
      $post_string.="cmd=_notify-validate"; // append ipn command

      // open the connection to paypal
      $fp = fsockopen($url_parsed_host,"80",$err_num,$err_str,30); 
      if(!$fp) {
          
         // could not open the connection.  If loggin is on, the error message
         // will be in the log.
echo "Error socket";
exit;
         return false;
         
      } else { 
 
         // Post the data back to paypal
         fputs($fp, "POST $url_parsed_path HTTP/1.1\r\n");
//         fputs($fp, "POST /cgi-bin/webscr HTTP/1.1\r\n"); //from email
         fputs($fp, "Content-Type: application/x-www-form-urlencoded\r\n"); 
//         fputs($fp, "Host: $url_parsed[host]\r\n");
         fputs($fp, "Host: $url_parsed_host\r\n"); //form email

         fputs($fp, "Content-length: ".strlen($post_string)."\r\n"); 
         fputs($fp, "Connection: close\r\n\r\n"); 
         fputs($fp, $post_string . "\r\n\r\n"); 

        $back ="";
         // loop through the response from the server and append to variable
         while(!feof($fp)) { 
            $back .= fgets($fp, 1024); 
         } 

         fclose($fp); // close connection
      }
echo "--------".$back ;exit;
*/


/*
//        $request = self::buildRequest($data);
        unset($data['sign_password']);
        unset($data['projectid']);

        $request = $data;

        $url = self::PAY_URL . '?' . http_build_query($request);
//echo $url;exit;

        $url = preg_replace('/[\r\n]+/is', '', $url);
        if (headers_sent()) {
            echo '<script type="text/javascript">window.location = "' . addslashes($url) . '";</script>';
        } else {
            header("Location: $url", true);
        }
        printf(
            'Redirecting to <a href="%s">%s</a>. Please wait.',
            htmlentities($url, ENT_QUOTES, 'UTF-8'),
            htmlentities($url, ENT_QUOTES, 'UTF-8')
        );
        if ($exit) {
            exit();
        }
*/




    }//function




public static function p24_weryfikuj($p24_id_sprzedawcy, $p24_session_id, $p24_order_id, $p24_kwota="") 
{
    $P = array(); $RET = array();
    $url = "https://secure.przelewy24.pl/transakcja.php";
    $P[] = "p24_id_sprzedawcy=".$p24_id_sprzedawcy;
    $P[] = "p24_session_id=".$p24_session_id;
    $P[] = "p24_order_id=".$p24_order_id;
    $P[] = "p24_kwota=".$p24_kwota;
    $user_agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST,1);
    if(count($P)) curl_setopt($ch, CURLOPT_POSTFIELDS,join("&",$P));
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
    curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
    $result=curl_exec ($ch);
    curl_close ($ch);
    $T = explode(chr(13).chr(10),$result);  
    $ret = false;
    foreach($T as $line){
      $line = ereg_replace("[\n\r]","",$line);
      if($line != "RESULT" and !$res) continue;
      if($res)$RET[] = $line;
      else $res = true; 
    }
       return $RET;
}


}//class




//---------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------webtopay
//---------------------------------------------------------------------------------------------------------------------------------------


class WebToPay {

    /**
     * WebToPay Library version.
     */
    const VERSION = '1.6';

    /**
     * Server URL where all requests should go.
     */
    const PAY_URL = 'https://www.mokejimai.lt/pay/';

    /**
     * Server URL where we can get XML with payment method data.
     */
    const XML_URL = 'https://www.mokejimai.lt/new/api/paymentMethods/';

    /**
     * SMS answer url.
     */
    const SMS_ANSWER_URL = 'https://www.mokejimai.lt/psms/respond/';

    /**
     * Builds request data array.
     *
     * This method checks all given data and generates correct request data
     * array or raises WebToPayException on failure.
     *
     * Possible keys:
     * https://www.mokejimai.lt/makro_specifikacija.html
     *
     * @param  array $data Information about current payment request
     *
     * @return array
     *
     * @throws WebToPayException on data validation error
     */
    public static function buildRequest($data) {
        if (!isset($data['sign_password']) || !isset($data['projectid'])) {
            throw new WebToPayException('sign_password or projectid is not provided');
        }
        $password = $data['sign_password'];
        $projectId = $data['projectid'];
        unset($data['sign_password']);
        unset($data['projectid']);

        $factory = new WebToPay_Factory(array('projectId' => $projectId, 'password' => $password));
        $requestBuilder = $factory->getRequestBuilder();
        return $requestBuilder->buildRequest($data);
    }


    /**
     * Builds request and redirects user to payment window with generated request data
     *
     * Possible array keys are described here:
     * https://www.mokejimai.lt/makro_specifikacija.html
     *
     * @param  array   $data Information about current payment request.
     * @param  boolean $exit if true, exits after sending Location header; default false
     *
     * @throws WebToPayException on data validation error
     */
    public static function redirectToPayment($data, $exit = false) {
        $request = self::buildRequest($data);
        $url = self::PAY_URL . '?' . http_build_query($request);
        $url = preg_replace('/[\r\n]+/is', '', $url);
        if (headers_sent()) {
            echo '<script type="text/javascript">window.location = "' . addslashes($url) . '";</script>';
        } else {
            header("Location: $url", true);
        }
        printf(
            'Redirecting to <a href="%s">%s</a>. Please wait.',
            htmlentities($url, ENT_QUOTES, 'UTF-8'),
            htmlentities($url, ENT_QUOTES, 'UTF-8')
        );
        if ($exit) {
            exit();
        }
    }

    /**
     * Builds repeat request data array.
     *
     * This method checks all given data and generates correct request data
     * array or raises WebToPayException on failure.
     *
     * Method accepts single parameter $data of array type. All possible array
     * keys are described here:
     * https://www.mokejimai.lt/makro_specifikacija.html
     *
     * @param  array $data Information about current payment request
     *
     * @return array
     *
     * @throws WebToPayException on data validation error
     */
    public static function buildRepeatRequest($data) {
        if (!isset($data['sign_password']) || !isset($data['projectid']) || !isset($data['orderid'])) {
            throw new WebToPayException('sign_password, projectid or orderid is not provided');
        }
        $password = $data['sign_password'];
        $projectId = $data['projectid'];
        $orderId = $data['orderid'];

        $factory = new WebToPay_Factory(array('projectId' => $projectId, 'password' => $password));
        $requestBuilder = $factory->getRequestBuilder();
        return $requestBuilder->buildRepeatRequest($orderId);
    }

    /**
     * Returns payment url. Argument is same as lang parameter in request data
     *
     * @param  string $language
     * @return string $url
     */
    public static function getPaymentUrl($language = 'LIT') {
        $url = self::PAY_URL;
        if ($language != 'LIT') {
            $url = str_replace('mokejimai.lt', 'webtopay.com', $url);
        }
        return $url;
    }

    /**
     * Parses response from WebToPay server and validates signs.
     *
     * This function accepts both micro and macro responses.
     *
     * First parameter usualy should be $_GET array.
     *
     * Description about response can be found here:
     * makro: https://www.mokejimai.lt/makro_specifikacija.html
     * mikro: https://www.mokejimai.lt/mikro_mokejimu_specifikacija_SMS.html
     *
     * If response is not correct, WebToPayException will be raised.
     *
     * @param array $response Response array
     * @param array $userData
     *
     * @return array
     *
     * @throws WebToPayException
     */
    public static function checkResponse($query, $userData = array()) {
        $projectId = isset($userData['projectid']) ? $userData['projectid'] : null;
        $password = isset($userData['sign_password']) ? $userData['sign_password'] : null;
        $logFile = isset($userData['log']) ? $userData['log'] : null;

        try {
            $data = self::validateAndParseData($query, $projectId, $password);
            if ($data['type'] == 'macro' && $data['status'] != 1) {
                throw new WebToPayException('Expected status code 1');
            }

            if ($logFile) {
                self::log('OK', http_build_query($data), $logFile);
            }
            return $data;

        } catch (WebToPayException $exception) {
            if ($logFile) {
                self::log('ERR', $exception . "\nQuery: " . http_build_query($query), $logFile);
            }
            throw $exception;
        }
    }

    /**
     * Parses request (query) data and validates its signature.
     *
     * @param array   $query        usually $_GET
     * @param integer $projectId
     * @param string  $password
     *
     * @return array
     *
     * @throws WebToPayException
     */
    public static function validateAndParseData(array $query, $projectId, $password) {
        $factory = new WebToPay_Factory(array('projectId' => $projectId, 'password' => $password));
        $validator = $factory->getCallbackValidator();
        $data = $validator->validateAndParseData($query);
        return $data;
    }

    /**
     * Sends SMS answer
     *
     * @param array $userData
     *
     * @throws WebToPayException
     */
    public static function smsAnswer($userData) {
        if (!isset($userData['id']) || !isset($userData['msg']) || !isset($userData['sign_password'])) {
            throw new WebToPay_Exception_Validation('id, msg and sign_password are required');
        }

        $smsId = $userData['id'];
        $text = $userData['msg'];
        $password = $userData['sign_password'];
        $logFile = isset($userData['log']) ? $userData['log'] : null;

        try {

            $factory = new WebToPay_Factory(array('password' => $password));
            $factory->getSmsAnswerSender()->sendAnswer($smsId, $text);

            if ($logFile) {
                self::log('OK', 'SMS ANSWER ' . $smsId . ' ' . $text, $logFile);
            }

        } catch (WebToPayException $e) {
            if ($logFile) {
                self::log('ERR', 'SMS ANSWER ' . $e, $logFile);
            }
            throw $e;
        }

    }


    /**
     * Gets available payment methods for project. Gets methods min and max amounts in specified currency.
     *
     * @param integer $projectId
     * @param string  $currency
     *
     * @return WebToPay_PaymentMethodList
     *
     * @throws WebToPayException
     */
    public static function getPaymentMethodList($projectId, $currency = 'LTL') {
        $factory = new WebToPay_Factory(array('projectId' => $projectId));
        return $factory->getPaymentMethodListProvider()->getPaymentMethodList($currency);
    }

    /**
     * Logs to file. Just skips logging if file is not writeable
     *
     * @param string $type
     * @param string $msg
     * @param string $logfile
     */
    protected static function log($type, $msg, $logfile) {
        $fp = @fopen($logfile, 'a');
        if (!$fp) {
            return false;
        }

        $logline = array(
            $type,
            isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '-',
            date('[Y-m-d H:i:s O]'),
            'v' . self::VERSION . ':',
            $msg
        );

        $logline = implode(' ', $logline)."\n";
        fwrite($fp, $logline);
        fclose($fp);

        // clear big log file
        if (filesize($logfile) > 1024 * 1024 * pi()) {
            copy($logfile, $logfile.'.old');
            unlink($logfile);
        }
    }
}




/**
 * Base exception class for all exceptions in this library
 */
class WebToPayException extends Exception {

    /**
     * Missing field.
     */
    const E_MISSING = 1;

    /**
     * Invalid field value.
     */
    const E_INVALID = 2;

    /**
     * Max length exceeded.
     */
    const E_MAXLEN = 3;

    /**
     * Regexp for field value doesn't match.
     */
    const E_REGEXP = 4;

    /**
     * Missing or invalid user given parameters.
     */
    const E_USER_PARAMS = 5;

    /**
     * Logging errors
     */
    const E_LOG = 6;

    /**
     * SMS answer errors
     */
    const E_SMS_ANSWER = 7;

    /**
     * Macro answer errors
     */
    const E_STATUS = 8;

    /**
     * Library errors - if this happens, bug-report should be sent; also you can check for newer version
     */
    const E_LIBRARY = 9;

    /**
     * Errors in remote service - it returns some invalid data
     */
    const E_SERVICE = 10;

    /**
     * @var string|boolean
     */
    protected $fieldName = false;

    /**
     * Sets field which failed
     *
     * @param string $fieldName
     */
    public function setField($fieldName) {
        $this->fieldName = $fieldName;
    }

    /**
     * Gets field which failed
     *
     * @return string|boolean false
     */
    public function getField() {
        return $this->fieldName;
    }
}

/**
 * Class to hold information about payment method
 */
class WebToPay_PaymentMethod {
    /**
     * Assigned key for this payment method
     *
     * @var string
     */
    protected $key;

    /**
     * Logo url list by language. Usually logo is same for all languages, but exceptions exist
     *
     * @var array
     */
    protected $logoList;

    /**
     * Title list by language
     *
     * @var array
     */
    protected $titleTranslations;

    /**
     * Default language to use for titles
     *
     * @var string
     */
    protected $defaultLanguage;

    /**
     * Constructs object
     *
     * @param string  $key
     * @param integer $minAmount
     * @param integer $maxAmount
     * @param string  $currency
     * @param array   $logoList
     * @param array   $titleTranslations
     * @param string  $defaultLanguage
     */
    public function __construct(
        $key, $minAmount, $maxAmount, $currency, array $logoList = array(), array $titleTranslations = array(),
        $defaultLanguage = 'lt'
    ) {
        $this->key = $key;
        $this->minAmount = $minAmount;
        $this->maxAmount = $maxAmount;
        $this->currency = $currency;
        $this->logoList = $logoList;
        $this->titleTranslations = $titleTranslations;
        $this->defaultLanguage = $defaultLanguage;
    }

    /**
     * Sets default language for titles.
     * Returns itself for fluent interface
     *
     * @param string $language
     *
     * @return WebToPay_PaymentMethod
     */
    public function setDefaultLanguage($language) {
        $this->defaultLanguage = $language;
        return $this;
    }

    /**
     * Gets default language for titles
     *
     * @return string
     */
    public function getDefaultLanguage() {
        return $this->defaultLanguage;
    }

    /**
     * Get assigned payment method key
     *
     * @return string
     */
    public function getKey() {
        return $this->key;
    }

    /**
     * Gets logo url for this payment method. Uses specified language or default one.
     * If logotype is not found for specified language, null is returned.
     *
     * @param string [Optional] $languageCode
     *
     * @return string|null
     */
    public function getLogoUrl($languageCode = null) {
        if ($languageCode !== null && isset($this->logoList[$languageCode])) {
            return $this->logoList[$languageCode];
        } elseif (isset($this->logoList[$this->defaultLanguage])) {
            return $this->logoList[$this->defaultLanguage];
        } else {
            return null;
        }
    }

    /**
     * Gets title for this payment method. Uses specified language or default one.
     *
     * @param string [Optional] $languageCode
     *
     * @return string
     */
    public function getTitle($languageCode = null) {
        if ($languageCode !== null && isset($this->titleTranslations[$languageCode])) {
            return $this->titleTranslations[$languageCode];
        } elseif (isset($this->titleTranslations[$this->defaultLanguage])) {
            return $this->titleTranslations[$this->defaultLanguage];
        } else {
            return $this->key;
        }
    }

    /**
     * Checks if this payment method can be used for specified amount.
     * Throws exception if currency checked is not the one, for which payment method list was downloaded.
     *
     * @param integer $amount
     * @param string  $currency
     *
     * @return boolean
     *
     * @throws WebToPayException
     */
    public function isAvailableForAmount($amount, $currency) {
        if ($this->currency !== $currency) {
            throw new WebToPayException(
                'Currencies does not match. You have to get payment types for the currency you are checking. Given currency: '
                    . $currency . ', available currency: ' . $this->currency
            );
        }
        return (
            ($this->minAmount === null || $amount >= $this->minAmount)
            && ($this->maxAmount === null || $amount <= $this->maxAmount)
        );
    }

    /**
     * Returns min amount for this payment method. If no min amount is specified, returns empty string.
     *
     * @return string
     */
    public function getMinAmountAsString() {
        return $this->minAmount === null ? '' : ($this->minAmount . ' ' . $this->currency);
    }

    /**
     * Returns max amount for this payment method. If no max amount is specified, returns empty string.
     *
     * @return string
     */
    public function getMaxAmountAsString() {
        return $this->maxAmount === null ? '' : ($this->maxAmount . ' ' . $this->currency);
    }
}


/**
 * Class with all information about available payment methods for some project, optionally filtered by some amount.
 */
class WebToPay_PaymentMethodList {
    /**
     * Holds available payment countries
     *
     * @var WebToPay_PaymentMethodCountry[]
     */
    protected $countries;

    /**
     * Default language for titles
     *
     * @var string
     */
    protected $defaultLanguage;

    /**
     * Project ID, to which this method list is valid
     *
     * @var integer
     */
    protected $projectId;

    /**
     * Currency for min and max amounts in this list
     *
     * @var string
     */
    protected $currency;

    /**
     * If this list is filtered for some amount, this field defines it
     *
     * @var integer
     */
    protected $amount;

    /**
     * Constructs object
     *
     * @param integer $projectId
     * @param string  $currency              currency for min and max amounts in this list
     * @param string  $defaultLanguage
     * @param integer $amount                null if this list is not filtered by amount
     */
    public function __construct($projectId, $currency, $defaultLanguage = 'lt', $amount = null) {
        $this->projectId = $projectId;
        $this->countries = array();
        $this->defaultLanguage = $defaultLanguage;
        $this->currency = $currency;
        $this->amount = $amount;
    }

    /**
     * Sets default language for titles.
     * Returns itself for fluent interface
     *
     * @param string $language
     *
     * @return WebToPay_PaymentMethodList
     */
    public function setDefaultLanguage($language) {
        $this->defaultLanguage = $language;
        foreach ($this->countries as $country) {
            $country->setDefaultLanguage($language);
        }
        return $this;
    }

    /**
     * Gets default language for titles
     *
     * @return string
     */
    public function getDefaultLanguage() {
        return $this->defaultLanguage;
    }

    /**
     * Gets project ID for this payment method list
     *
     * @return integer
     */
    public function getProjectId() {
        return $this->projectId;
    }

    /**
     * Gets currency for min and max amounts in this list
     *
     * @return string
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * Gets whether this list is already filtered for some amount
     *
     * @return boolean
     */
    public function isFiltered() {
        return $this->amount !== null;
    }

    /**
     * Returns available countries
     *
     * @return WebToPay_PaymentMethodCountry[]
     */
    public function getCountries() {
        return $this->countries;
    }

    /**
     * Adds new country to payment methods. If some other country with same code was registered earlier, overwrites it.
     * Returns added country instance
     *
     * @param WebToPay_PaymentMethodCountry $country
     *
     * @return WebToPay_PaymentMethodCountry
     */
    public function addCountry(WebToPay_PaymentMethodCountry $country) {
        return $this->countries[$country->getCode()] = $country;
    }

    /**
     * Gets country object with specified country code. If no country with such country code is found, returns null.
     *
     * @param string $countryCode
     *
     * @return null|WebToPay_PaymentMethodCountry
     */
    public function getCountry($countryCode) {
        return isset($this->countries[$countryCode]) ? $this->countries[$countryCode] : null;
    }

    /**
     * Returns new payment method list instance with only those payment methods, which are available for provided
     * amount.
     * Returns itself, if list is already filtered and filter amount matches the given one.
     *
     * @param integer $amount
     * @param string  $currency
     *
     * @return WebToPay_PaymentMethodList
     *
     * @throws WebToPayException    if this list is already filtered and not for provided amount
     */
    public function filterForAmount($amount, $currency) {
        if ($currency !== $this->currency) {
            throw new WebToPayException(
                'Currencies do not match. Given currency: ' . $currency . ', currency in list: ' . $this->currency
            );
        }
        if ($this->isFiltered()) {
            if ($this->amount === $amount) {
                return $this;
            } else {
                throw new WebToPayException('This list is already filtered, use unfiltered list instead');
            }
        } else {
            $list = new WebToPay_PaymentMethodList($this->projectId, $currency, $this->defaultLanguage, $amount);
            foreach ($this->getCountries() as $country) {
                $country = $country->filterForAmount($amount, $currency);
                if (!$country->isEmpty()) {
                    $list->addCountry($country);
                }
            }
            return $list;
        }
    }

    /**
     * Loads countries from given XML node
     *
     * @param SimpleXMLElement $xmlNode
     */
    public function fromXmlNode($xmlNode) {
        foreach ($xmlNode->country as $countryNode) {
            $titleTranslations = array();
            foreach ($countryNode->title as $titleNode) {
                $titleTranslations[(string) $titleNode->attributes()->language] = (string) $titleNode;
            }
            $this->addCountry($this->createCountry((string) $countryNode->attributes()->code, $titleTranslations))
                ->fromXmlNode($countryNode);
        }
    }

    /**
     * Method to create new country instances. Overwrite if you have to use some other country subtype.
     *
     * @param string $countryCode
     * @param array  $titleTranslations
     */
    protected function createCountry($countryCode, array $titleTranslations = array()) {
        return new WebToPay_PaymentMethodCountry($countryCode, $titleTranslations, $this->defaultLanguage);
    }
}

/**
 * Sends answer to SMS payment if it was not provided with response to callback
 */
class WebToPay_SmsAnswerSender {

    /**
     * @var string
     */
    protected $password;

    /**
     * @var WebToPay_WebClient
     */
    protected $webClient;

    /**
     * Constructs object
     *
     * @param string             $password
     * @param WebToPay_WebClient $webClient
     */
    public function __construct($password, WebToPay_WebClient $webClient) {
        $this->password = $password;
        $this->webClient = $webClient;
    }

    /**
     * Sends answer by sms ID get from callback. Answer can be send only if it was not provided
     * when responding to callback
     *
     * @param integer $smsId
     * @param string  $text
     *
     * @throws WebToPayException
     */
    public function sendAnswer($smsId, $text) {
        $content = $this->webClient->get(WebToPay::SMS_ANSWER_URL, array(
            'id' => $smsId,
            'msg' => $text,
            'transaction' => md5($this->password . '|' . $smsId),
        ));
        if (strpos($content, 'OK') !== 0) {
            throw new WebToPayException(
                sprintf('Error: %s', $content),
                WebToPayException::E_SMS_ANSWER
            );
        }
    }
}


/**
 * Raised on validation error in passed data when building the request
 */
class WebToPay_Exception_Validation extends WebToPayException {

    public function __construct($message, $code = null, $field = null, $previousException = null) {
        parent::__construct($message, $code, $previousException);
        if ($field) {
            $this->setField($field);
        }
    }
}

/**
 * Raised if configuration is incorrect
 */
class WebToPay_Exception_Configuration extends WebToPayException {

}


/**
 * Raised on error in callback
 */
class WebToPay_Exception_Callback extends WebToPayException {

}

/**
 * Parses and validates callbacks
 */
class WebToPay_CallbackValidator {

    /**
     * @var WebToPay_Sign_SignCheckerInterface
     */
    protected $signer;

    /**
     * @var WebToPay_Util
     */
    protected $util;

    /**
     * @var integer
     */
    protected $projectId;

    /**
     * Constructs object
     *
     * @param integer                            $projectId
     * @param WebToPay_Sign_SignCheckerInterface $signer
     * @param WebToPay_Util                      $util
     */
    public function __construct($projectId, WebToPay_Sign_SignCheckerInterface $signer, WebToPay_Util $util) {
        $this->signer = $signer;
        $this->util = $util;
        $this->projectId = $projectId;
    }

    /**
     * Parses callback parameters from query parameters and checks if sign is correct.
     * Request has parameter "data", which is signed and holds all callback parameters
     *
     * @param array $requestData
     *
     * @return array Parsed callback parameters
     *
     * @throws WebToPayException
     */
    public function validateAndParseData(array $requestData) {
        if (!$this->signer->checkSign($requestData)) {
            throw new WebToPay_Exception_Callback('Invalid sign parameters');
        }

        if (!isset($requestData['data'])) {
            throw new WebToPay_Exception_Callback('"data" parameter not found');
        }
        $data = $requestData['data'];

        $queryString = $this->util->decodeSafeUrlBase64($data);
        $request = $this->util->parseHttpQuery($queryString);

        if (!isset($request['projectid'])) {
            throw new WebToPay_Exception_Callback(
                'Project ID not provided in callback',
                WebToPayException::E_INVALID
            );
        }

        if ((string) $request['projectid'] !== (string) $this->projectId) {
            throw new WebToPay_Exception_Callback(
                sprintf('Bad projectid: %s, should be: %s', $request['projectid'], $this->projectId),
                WebToPayException::E_INVALID
            );
        }

        if (!isset($request['type']) || !in_array($request['type'], array('micro', 'macro'))) {
            $micro = (
                isset($request['to'])
                && isset($request['from'])
                && isset($request['sms'])
            );
            $request['type'] = $micro ? 'micro' : 'macro';
        }

        return $request;
    }

    /**
     * Checks data to have all the same parameters provided in expected array
     *
     * @param array $data
     * @param array $expected
     *
     * @throws WebToPayException
     */
    public function checkExpectedFields(array $data, array $expected) {
        foreach ($expected as $key => $value) {
            $passedValue = isset($data[$key]) ? $data[$key] : null;
            if ($passedValue != $value) {
                throw new WebToPayException(
                    sprintf('Field %s is not as expected (expected %s, got %s)', $key, $value, $passedValue)
                );
            }
        }
    }
}

/**
 * Builds and signs requests
 */
class WebToPay_RequestBuilder {

    /**
     * @var string
     */
    protected $projectPassword;

    /**
     * @var WebToPay_Util
     */
    protected $util;

    /**
     * @var integer
     */
    protected $projectId;

    /**
     * Constructs object
     *
     * @param integer       $projectId
     * @param string        $projectPassword
     * @param WebToPay_Util $util
     */
    public function __construct($projectId, $projectPassword, WebToPay_Util $util) {
        $this->projectId = $projectId;
        $this->projectPassword = $projectPassword;
        $this->util = $util;
    }

    /**
     * Builds request data array.
     *
     * This method checks all given data and generates correct request data
     * array or raises WebToPayException on failure.
     *
     * @param  array $data information about current payment request
     *
     * @return array
     *
     * @throws WebToPayException
     */
    public function buildRequest($data) {
        $this->validateRequest($data, self::getRequestSpec());
        $data['version'] = WebToPay::VERSION;
        $data['projectid'] = $this->projectId;
        unset($data['repeat_request']);
        return $this->createRequest($data);
    }

    /**
     * Builds repeat request data array.
     *
     * This method checks all given data and generates correct request data
     * array or raises WebToPayException on failure.
     *
     * @param  array $data information about current repeated payment request
     *
     * @return array
     *
     * @throws WebToPayException
     */
    public function buildRepeatRequest($orderId) {
        $data['orderid'] = $orderId;
        $data['version'] = WebToPay::VERSION;
        $data['projectid'] = $this->projectId;
        $data['repeat_request'] = '1';
        return $this->createRequest($data);
    }

    /**
     * Checks data to be valid by passed specification
     *
     * @param  array $data
     *
     * @throws WebToPay_Exception_Validation
     */
    protected function validateRequest($data, $specs) {
        foreach ($specs as $spec) {
            list($name, $maxlen, $required, $regexp) = $spec;
            if ($required && !isset($data[$name])) {
                throw new WebToPay_Exception_Validation(
                    sprintf("'%s' is required but missing.", $name),
                    WebToPayException::E_MISSING,
                    $name
                );
            }

            if (!empty($data[$name])) {
                if ($maxlen && strlen($data[$name]) > $maxlen) {
                    throw new WebToPay_Exception_Validation(sprintf(
                        "'%s' value is too long (%d), %d characters allowed.",
                        $name,
                        strlen($data[$name]),
                        $maxlen
                    ), WebToPayException::E_MAXLEN, $name);
                }

                if ($regexp !== ''  && !preg_match($regexp, $data[$name])) {
                    throw new WebToPay_Exception_Validation(
                        sprintf("'%s' value '%s' is invalid.", $name, $data[$name]),
                        WebToPayException::E_REGEXP,
                        $name
                    );
                }
            }
        }
    }

    /**
     * Makes request data array from parameters, also generates signature
     *
     * @param array $request
     *
     * @return array
     */
    protected function createRequest(array $request) {
        $data = $this->util->encodeSafeUrlBase64(http_build_query($request));
        return array(
            'data' => $data,
            'sign' => md5($data . $this->projectPassword),
        );
    }

    /**
     * Returns specification of fields for request.
     *
     * Array structure:
     *   name      â request item name
     *   maxlen    â max allowed value for item
     *   required  â is this item is required
     *   regexp    â regexp to test item value
     *
     * @return array
     */
    protected static function getRequestSpec() {
        return array(
            array('orderid',       40,  true,  ''),
            array('accepturl',     255, true,  ''),
            array('cancelurl',     255, true,  ''),
            array('callbackurl',   255, true,  ''),
            array('lang',          3,   false, '/^[a-z]{3}$/i'),
            array('amount',        11,  false, '/^\d+$/'),
            array('currency',      3,   false, '/^[a-z]{3}$/i'),
            array('payment',       20,  false, ''),
            array('country',       2,   false, '/^[a-z_]{2}$/i'),
            array('paytext',       255, false, ''),
            array('p_firstname',   255, false, ''),
            array('p_lastname',    255, false, ''),
            array('p_email',       255, false, ''),
            array('p_street',      255, false, ''),
            array('p_city',        255, false, ''),
            array('p_state',       20,  false, ''),
            array('p_zip',         20,  false, ''),
            array('p_countrycode', 2,   false, '/^[a-z]{2}$/i'),
            array('test',          1,   false, '/^[01]$/'),
            array('time_limit',    19,  false, '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/'),
        );
    }
}

/**
 * Sign checker which checks SS1 signature. SS1 does not depend on SSL functions
 */
class WebToPay_Sign_SS1SignChecker implements WebToPay_Sign_SignCheckerInterface {

    /**
     * @var string
     */
    protected $projectPassword;

    /**
     * Constructs object
     *
     * @param string $projectPassword
     */
    public function __construct($projectPassword) {
        $this->projectPassword = $projectPassword;
    }

    /**
     * Check for SS1, which is not depend on openssl functions.
     *
     * @param  array  $response
     * @param  string $password
     *
     * @return boolean
     *
     * @throws WebToPay_Exception_Callback
     */
    public function checkSign(array $request) {
        if (!isset($request['data']) || !isset($request['ss1'])) {
            throw new WebToPay_Exception_Callback('Not enough parameters in callback. Possible version mismatch');
        }

        return md5($request['data'] . $this->projectPassword) === $request['ss1'];
    }
}

/**
 * Interface for sign checker
 */
interface WebToPay_Sign_SignCheckerInterface {

    /**
     * Checks whether request is signed properly
     *
     * @param array $request
     *
     * @return boolean
     */
    public function checkSign(array $request);
}

/**
 * Checks SS2 signature. Depends on SSL functions
 */
class WebToPay_Sign_SS2SignChecker implements WebToPay_Sign_SignCheckerInterface {

    /**
     * @var string
     */
    protected $publicKey;

    /**
     * @var WebToPay_Util
     */
    protected $util;

    /**
     * Constructs object
     *
     * @param string        $publicKey
     * @param WebToPay_Util $util
     */
    public function __construct($publicKey, WebToPay_Util $util) {
        $this->publicKey = $publicKey;
        $this->util = $util;
    }

    /**
     * Checks signature
     *
     * @param array $request
     *
     * @return boolean
     *
     * @throws WebToPay_Exception_Callback
     */
    public function checkSign(array $request) {
        if (!isset($request['data']) || !isset($request['ss2'])) {
            throw new WebToPay_Exception_Callback('Not enough parameters in callback. Possible version mismatch');
        }

        $ss2 = $this->util->decodeSafeUrlBase64($request['ss2']);
        $ok = openssl_verify($request['data'], $ss2, $this->publicKey);
        return $ok === 1;
    }
}

/**
 * Creates objects. Also caches to avoid creating several instances of same objects
 */
class WebToPay_Factory {

    /**
     * @var array
     */
    protected $configuration;

    /**
     * @var WebToPay_WebClient
     */
    protected $webClient = null;

    /**
     * @var WebToPay_CallbackValidator
     */
    protected $callbackValidator = null;

    /**
     * @var WebToPay_RequestBuilder
     */
    protected $requestBuilder = null;

    /**
     * @var WebToPay_Sign_SignCheckerInterface
     */
    protected $signer = null;

    /**
     * @var WebToPay_SmsAnswerSender
     */
    protected $smsAnswerSender = null;

    /**
     * @var WebToPay_PaymentMethodListProvider
     */
    protected $paymentMethodListProvider = null;

    /**
     * @var WebToPay_Util
     */
    protected $util = null;

    /**
     * Constructs object.
     * Configuration keys: projectId, password
     * They are required only when some object being created needs them,
     *     if they are not found at that moment - exception is thrown
     *
     * @param array $configuration
     */
    public function __construct(array $configuration = array()) {
        $this->configuration = $configuration;
    }

    /**
     * Creates or gets callback validator instance
     *
     * @return WebToPay_CallbackValidator
     *
     * @throws WebToPay_Exception_Configuration
     */
    public function getCallbackValidator() {
        if ($this->callbackValidator === null) {
            if (!isset($this->configuration['projectId'])) {
                throw new WebToPay_Exception_Configuration('You have to provide project ID');
            }
            $this->callbackValidator = new WebToPay_CallbackValidator(
                $this->configuration['projectId'],
                $this->getSigner(),
                $this->getUtil()
            );
        }
        return $this->callbackValidator;
    }

    /**
     * Creates or gets request builder instance
     *
     * @throws WebToPay_Exception_Configuration
     *
     * @return WebToPay_RequestBuilder
     */
    public function getRequestBuilder() {
        if ($this->requestBuilder === null) {
            if (!isset($this->configuration['password'])) {
                throw new WebToPay_Exception_Configuration('You have to provide project password to sign request');
            }
            if (!isset($this->configuration['projectId'])) {
                throw new WebToPay_Exception_Configuration('You have to provide project ID');
            }
            $this->requestBuilder = new WebToPay_RequestBuilder(
                $this->configuration['projectId'],
                $this->configuration['password'],
                $this->getUtil()
            );
        }
        return $this->requestBuilder;
    }

    /**
     * Creates or gets SMS answer sender instance
     *
     * @throws WebToPay_Exception_Configuration
     *
     * @return WebToPay_SmsAnswerSender
     */
    public function getSmsAnswerSender() {
        if ($this->smsAnswerSender === null) {
            if (!isset($this->configuration['password'])) {
                throw new WebToPay_Exception_Configuration('You have to provide project password');
            }
            $this->smsAnswerSender = new WebToPay_SmsAnswerSender(
                $this->configuration['password'],
                $this->getWebClient()
            );
        }
        return $this->smsAnswerSender;
    }

    /**
     * Creates or gets payment list provider instance
     *
     * @throws WebToPay_Exception_Configuration
     *
     * @return WebToPay_PaymentMethodListProvider
     */
    public function getPaymentMethodListProvider() {
        if ($this->paymentMethodListProvider === null) {
            if (!isset($this->configuration['projectId'])) {
                throw new WebToPay_Exception_Configuration('You have to provide project ID');
            }
            $this->paymentMethodListProvider = new WebToPay_PaymentMethodListProvider(
                $this->configuration['projectId'],
                $this->getWebClient()
            );
        }
        return $this->paymentMethodListProvider;
    }

    /**
     * Creates or gets signer instance. Chooses SS2 signer if openssl functions are available, SS1 in other case
     *
     * @throws WebToPay_Exception_Configuration
     *
     * @return WebToPay_Sign_SignCheckerInterface
     */
    protected function getSigner() {
        if ($this->signer === null) {
            if (function_exists('openssl_pkey_get_public')) {
                $webClient = $this->getWebClient();
                $publicKey = $webClient->get('http://downloads.webtopay.com/download/public.key');
                if (!$publicKey) {
                    throw new WebToPayException('Cannot download public key from WebToPay website');
                }
                $this->signer = new WebToPay_Sign_SS2SignChecker($publicKey, $this->getUtil());
            } else {
                if (!isset($this->configuration['password'])) {
                    throw new WebToPay_Exception_Configuration(
                        'You have to provide project password if OpenSSL is unavailable'
                    );
                }
                $this->signer = new WebToPay_Sign_SS1SignChecker($this->configuration['password']);
            }
        }
        return $this->signer;
    }

    /**
     * Creates or gets web client instance
     *
     * @throws WebToPay_Exception_Configuration
     *
     * @return WebToPay_WebClient
     */
    protected function getWebClient() {
        if ($this->webClient === null) {
            $this->webClient = new WebToPay_WebClient();
        }
        return $this->webClient;
    }

    /**
     * Creates or gets util instance
     *
     * @throws WebToPay_Exception_Configuration
     *
     * @return WebToPay_Util
     */
    protected function getUtil() {
        if ($this->util === null) {
            $this->util = new WebToPay_Util();
        }
        return $this->util;
    }
}


/**
 * Payment method configuration for some country
 */
class WebToPay_PaymentMethodCountry {
    /**
     * @var string
     */
    protected $countryCode;

    /**
     * Holds available payment types for this country
     *
     * @var WebToPay_PaymentMethodGroup[]
     */
    protected $groups;

    /**
     * Default language for titles
     *
     * @var string
     */
    protected $defaultLanguage;

    /**
     * Translations array for this country. Holds associative array of country title by language codes.
     *
     * @var array
     */
    protected $titleTranslations;

    /**
     * Constructs object
     *
     * @param string $countryCode
     * @param string $defaultLanguage
     */
    public function __construct($countryCode, $titleTranslations, $defaultLanguage = 'lt') {
        $this->countryCode = $countryCode;
        $this->defaultLanguage = $defaultLanguage;
        $this->titleTranslations = $titleTranslations;
        $this->groups = array();
    }

    /**
     * Sets default language for titles.
     * Returns itself for fluent interface
     *
     * @param string $language
     *
     * @return WebToPay_PaymentMethodCountry
     */
    public function setDefaultLanguage($language) {
        $this->defaultLanguage = $language;
        foreach ($this->groups as $group) {
            $group->setDefaultLanguage($language);
        }
        return $this;
    }

    /**
     * Gets title of the group. Tries to get title in specified language. If it is not found or if language is not
     * specified, uses default language, given to constructor.
     *
     * @param string [Optional] $languageCode
     *
     * @return string
     */
    public function getTitle($languageCode = null) {
        if ($languageCode !== null && isset($this->titleTranslations[$languageCode])) {
            return $this->titleTranslations[$languageCode];
        } elseif (isset($this->titleTranslations[$this->defaultLanguage])) {
            return $this->titleTranslations[$this->defaultLanguage];
        } else {
            return $this->countryCode;
        }
    }

    /**
     * Gets default language for titles
     *
     * @return string
     */
    public function getDefaultLanguage() {
        return $this->defaultLanguage;
    }

    /**
     * Gets country code
     *
     * @return string
     */
    public function getCode() {
        return $this->countryCode;
    }

    /**
     * Adds new group to payment methods for this country.
     * If some other group was registered earlier with same key, overwrites it.
     * Returns given group
     *
     * @param WebToPay_PaymentMethodGroup $group
     *
     * @return WebToPay_PaymentMethodGroup
     */
    public function addGroup(WebToPay_PaymentMethodGroup $group) {
        return $this->groups[$group->getKey()] = $group;
    }

    /**
     * Gets group object with specified group key. If no group with such key is found, returns null.
     *
     * @param string $groupKey
     *
     * @return null|WebToPay_PaymentMethodGroup
     */
    public function getGroup($groupKey) {
        return isset($this->groups[$groupKey]) ? $this->groups[$groupKey] : null;
    }

    /**
     * Returns payment method groups registered for this country.
     *
     * @return WebToPay_PaymentMethodGroup[]
     */
    public function getGroups() {
        return $this->groups;
    }

    /**
     * Gets payment methods in all groups
     *
     * @return WebToPay_PaymentMethod[]
     */
    public function getPaymentMethods() {
        $paymentMethods = array();
        foreach ($this->groups as $group) {
            $paymentMethods = array_merge($paymentMethods, $group->getPaymentMethods());
        }
        return $paymentMethods;
    }

    /**
     * Returns new country instance with only those payment methods, which are available for provided amount.
     *
     * @param integer $amount
     * @param string  $currency
     *
     * @return WebToPay_PaymentMethodCountry
     */
    public function filterForAmount($amount, $currency) {
        $country = new WebToPay_PaymentMethodCountry($this->countryCode, $this->titleTranslations, $this->defaultLanguage);
        foreach ($this->getGroups() as $group) {
            $group = $group->filterForAmount($amount, $currency);
            if (!$group->isEmpty()) {
                $country->addGroup($group);
            }
        }
        return $country;
    }

    /**
     * Returns whether this country has no groups
     *
     * @return boolean
     */
    public function isEmpty() {
        return count($this->groups) === 0;
    }

    /**
     * Loads groups from given XML node
     *
     * @param SimpleXMLElement $countryNode
     */
    public function fromXmlNode($countryNode) {
        foreach ($countryNode->payment_group as $groupNode) {
            $key = (string) $groupNode->attributes()->key;
            $titleTranslations = array();
            foreach ($groupNode->title as $titleNode) {
                $titleTranslations[(string) $titleNode->attributes()->language] = (string) $titleNode;
            }
            $this->addGroup($this->createGroup($key, $titleTranslations))->fromXmlNode($groupNode);
        }
    }

    /**
     * Method to create new group instances. Overwrite if you have to use some other group subtype.
     *
     * @param string $groupKey
     * @param array  $translations
     *
     * @return WebToPay_PaymentMethodGroup
     */
    protected function createGroup($groupKey, array $translations = array()) {
        return new WebToPay_PaymentMethodGroup($groupKey, $translations, $this->defaultLanguage);
    }
}

/**
 * Utility class
 */
class WebToPay_Util {

    /**
     * Decodes url-safe-base64 encoded string
     * Url-safe-base64 is same as base64, but + is replaced to - and / to _
     *
     * @param string $encodedText
     *
     * @return string
     */
    public function decodeSafeUrlBase64($encodedText) {
        return base64_decode(strtr($encodedText, array('-' => '+', '_' => '/')));
    }

    /**
     * Encodes string to url-safe-base64
     * Url-safe-base64 is same as base64, but + is replaced to - and / to _
     *
     * @param string $text
     *
     * @return string
     */
    public function encodeSafeUrlBase64($text) {
        return strtr(base64_encode($text), array('+' => '-', '/' => '_'));
    }

    /**
     * Parses HTTP query to array
     *
     * @param string $query
     *
     * @return array
     */
    public function parseHttpQuery($query) {
        $params = array();
        parse_str($query, $params);
        if (get_magic_quotes_gpc()) {
            $params = $this->stripSlashesRecursively($params);
        }
        return $params;
    }

    /**
     * Strips slashes recursively, so this method can be used on arrays with more than one level
     *
     * @param mixed $data
     *
     * @return mixed
     */
    protected function stripSlashesRecursively($data) {
        if (is_array($data)) {
            $result = array();
            foreach ($data as $key => $value) {
                $result[stripslashes($key)] = $this->stripSlashesRecursively($value);
            }
            return $result;
        } else {
            return stripslashes($data);
        }
    }
}

/**
 * Simple web client
 */
class WebToPay_WebClient {

    /**
     * Gets page contents by specified URI. Adds query data if provided to the URI
     * Ignores status code of the response and header fields
     *
     * @param string $uri
     * @param array  $queryData
     *
     * @return string
     *
     * @throws WebToPayException
     */
    public function get($uri, array $queryData = array()) {
        if (count($queryData) > 0) {
            $uri .= strpos($uri, '?') === false ? '?' : '&';
            $uri .= http_build_query($queryData);
        }
        $url = parse_url($uri);
        if ('https' == $url['scheme']) {
            $host = 'ssl://'.$url['host'];
            $port = 443;
        } else {
            $host = $url['host'];
            $port = 80;
        }

        $fp = fsockopen($host, $port, $errno, $errstr, 30);
        if (!$fp) {
            throw new WebToPayException(sprintf('Cannot connect to %s', $uri), WebToPayException::E_INVALID);
        }

        if(isset($url['query'])) {
            $data = $url['path'].'?'.$url['query'];
        } else {
            $data = $url['path'];
        }

        $out = "GET " . $data . " HTTP/1.0\r\n";
        $out .= "Host: ".$url['host']."\r\n";
        $out .= "Connection: Close\r\n\r\n";

        $content = '';

        fwrite($fp, $out);
        while (!feof($fp)) $content .= fgets($fp, 8192);
        fclose($fp);

        list($header, $content) = explode("\r\n\r\n", $content, 2);

        return trim($content);
    }
}

/**
 * Wrapper class to group payment methods. Each country can have several payment method groups, each of them
 * have one or more payment methods.
 */
class WebToPay_PaymentMethodGroup {
    /**
     * Some unique (in the scope of country) key for this group
     *
     * @var string
     */
    protected $groupKey;

    /**
     * Translations array for this group. Holds associative array of group title by country codes.
     *
     * @var array
     */
    protected $translations;

    /**
     * Holds actual payment methods
     *
     * @var WebToPay_PaymentMethod[]
     */
    protected $paymentMethods;

    /**
     * Default language for titles
     *
     * @var string
     */
    protected $defaultLanguage;

    /**
     * Constructs object
     *
     * @param string $groupKey
     * @param array  $translations
     */
    public function __construct($groupKey, array $translations = array(), $defaultLanguage = 'lt') {
        $this->groupKey = $groupKey;
        $this->translations = $translations;
        $this->defaultLanguage = $defaultLanguage;
        $this->paymentMethods = array();
    }

    /**
     * Sets default language for titles.
     * Returns itself for fluent interface
     *
     * @param string $language
     *
     * @return WebToPay_PaymentMethodGroup
     */
    public function setDefaultLanguage($language) {
        $this->defaultLanguage = $language;
        foreach ($this->paymentMethods as $paymentMethod) {
            $paymentMethod->setDefaultLanguage($language);
        }
        return $this;
    }

    /**
     * Gets default language for titles
     *
     * @return string
     */
    public function getDefaultLanguage() {
        return $this->defaultLanguage;
    }

    /**
     * Gets title of the group. Tries to get title in specified language. If it is not found or if language is not
     * specified, uses default language, given to constructor.
     *
     * @param string [Optional] $languageCode
     *
     * @return string
     */
    public function getTitle($languageCode = null) {
        if ($languageCode !== null && isset($this->translations[$languageCode])) {
            return $this->translations[$languageCode];
        } elseif (isset($this->translations[$this->defaultLanguage])) {
            return $this->translations[$this->defaultLanguage];
        } else {
            return $this->groupKey;
        }
    }

    /**
     * Returns group key
     *
     * @return string
     */
    public function getKey() {
        return $this->groupKey;
    }

    /**
     * Returns available payment methods for this group
     *
     * @return WebToPay_PaymentMethod[]
     */
    public function getPaymentMethods() {
        return $this->paymentMethods;
    }


    /**
     * Adds new payment method for this group.
     * If some other payment method with specified key was registered earlier, overwrites it.
     * Returns given payment method
     *
     * @param WebToPay_PaymentMethod $paymentMethod
     *
     * @return WebToPay_PaymentMethod
     */
    public function addPaymentMethod(WebToPay_PaymentMethod $paymentMethod) {
        return $this->paymentMethods[$paymentMethod->getKey()] = $paymentMethod;
    }

    /**
     * Gets payment method object with key. If no payment method with such key is found, returns null.
     *
     * @param string $key
     *
     * @return null|WebToPay_PaymentMethod
     */
    public function getPaymentMethod($key) {
        return isset($this->paymentMethods[$key]) ? $this->paymentMethods[$key] : null;
    }

    /**
     * Returns new group instance with only those payment methods, which are available for provided amount.
     *
     * @param integer $amount
     * @param string  $currency
     *
     * @return WebToPay_PaymentMethodGroup
     */
    public function filterForAmount($amount, $currency) {
        $group = new WebToPay_PaymentMethodGroup($this->groupKey, $this->translations, $this->defaultLanguage);
        foreach ($this->getPaymentMethods() as $paymentMethod) {
            if ($paymentMethod->isAvailableForAmount($amount, $currency)) {
                $group->addPaymentMethod($paymentMethod);
            }
        }
        return $group;
    }

    /**
     * Returns whether this group has no payment methods
     *
     * @return boolean
     */
    public function isEmpty() {
        return count($this->paymentMethods) === 0;
    }

    /**
     * Loads payment methods from given XML node
     *
     * @param SimpleXMLElement $groupNode
     */
    public function fromXmlNode($groupNode) {
        foreach ($groupNode->payment_type as $paymentTypeNode) {
            $key = (string) $paymentTypeNode->attributes()->key;
            $titleTranslations = array();
            foreach ($paymentTypeNode->title as $titleNode) {
                $titleTranslations[(string) $titleNode->attributes()->language] = (string) $titleNode;
            }
            $logoTranslations = array();
            foreach ($paymentTypeNode->logo_url as $logoNode) {
                if ((string) $logoNode !== '') {
                    $logoTranslations[(string) $logoNode->attributes()->language] = (string) $logoNode;
                }
            }
            $minAmount = null;
            $maxAmount = null;
            $currency = null;
            if (isset($paymentTypeNode->min)) {
                $minAmount = (int) $paymentTypeNode->min->attributes()->amount;
                $currency = (string) $paymentTypeNode->min->attributes()->currency;
            }
            if (isset($paymentTypeNode->max)) {
                $maxAmount = (int) $paymentTypeNode->max->attributes()->amount;
                $currency = (string) $paymentTypeNode->max->attributes()->currency;
            }
            $this->addPaymentMethod($this->createPaymentMethod(
                $key, $minAmount, $maxAmount, $currency, $logoTranslations, $titleTranslations
            ));
        }
    }

    /**
     * Method to create new payment method instances. Overwrite if you have to use some other subclass.
     *
     * @param string $key
     * @param array  $logoList
     * @param array  $titleTranslations
     *
     * @return WebToPay_PaymentMethod
     */
    protected function createPaymentMethod(
        $key, $minAmount, $maxAmount, $currency, array $logoList = array(), array $titleTranslations = array()
    ) {
        return new WebToPay_PaymentMethod(
            $key, $minAmount, $maxAmount, $currency, $logoList, $titleTranslations, $this->defaultLanguage
        );
    }
}

/**
 * Loads data about payment methods and constructs payment method list object from that data
 * You need SimpleXML support to use this feature
 */
class WebToPay_PaymentMethodListProvider {

    /**
     * @var integer
     */
    protected $projectId;

    /**
     * @var WebToPay_WebClient
     */
    protected $webClient;

    /**
     * Holds constructed method lists by currency
     *
     * @var WebToPay_PaymentMethodList[]
     */
    protected $methodListCache = array();

    /**
     * Constructs object
     *
     * @param integer            $projectId
     * @param WebToPay_WebClient $webClient
     *
     * @throws WebToPayException if SimpleXML is not available
     */
    public function __construct($projectId, WebToPay_WebClient $webClient) {
        $this->projectId = $projectId;
        $this->webClient = $webClient;
        if (!function_exists('simplexml_load_string')) {
            throw new WebToPayException('You have to install libxml to use payment methods API');
        }
    }

    /**
     * Gets payment method list for specified currency
     *
     * @param string $currency
     *
     * @return WebToPay_PaymentMethodList
     *
     * @throws WebToPayException
     */
    public function getPaymentMethodList($currency) {
        if (!isset($this->methodListCache[$currency])) {
            $xmlAsString = $this->webClient->get(WebToPay::XML_URL . $this->projectId . '/currency:' . $currency);
            $useInternalErrors = libxml_use_internal_errors(false);
            $rootNode = simplexml_load_string($xmlAsString);
            libxml_clear_errors();
            libxml_use_internal_errors($useInternalErrors);
            if (!$rootNode) {
                throw new WebToPayException('Unable to load XML from remote server');
            }
            $methodList = new WebToPay_PaymentMethodList($this->projectId, $currency);
            $methodList->fromXmlNode($rootNode);
            $this->methodListCache[$currency] = $methodList;
        }
        return $this->methodListCache[$currency];
    }
}
