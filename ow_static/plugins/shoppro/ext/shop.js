$(document).ready(function (){


    $("#shop_main_order").change(function() {
//        alert( this.value ); // or $(this).val()
        $(location).attr('href',$(this).attr('url')+'?shop_set_order='+this.value);
    });


var shop_curent_button=0;
var shop_curent_button_poption=0;
            $(".shop_btnShowDialog").click(function (e)
            {
                shop_ShowDialog($(this).attr('dial'),false);
                e.preventDefault();
            });

$(".shop_btnDialog").click(function (e){
                shop_ShowDialog($(this).attr('dial'),false);

//                shop_set_curent_button_option_set($(this).attr('has_option'),$('#p_option_'+$(this).attr('dial')).val());
//alert('clock:'+$('#p_option_'+$(this).attr('dial')).val());
            shop_curent_button=$(this).attr('has_option');
            shop_curent_button_poption=$('#p_option_'+$(this).attr('dial')).val();


                e.preventDefault();
});

            $("#shop_btnShowModal").click(function (e)
            {
                shop_ShowDialog($(this).attr('dial'),true);
                e.preventDefault();
            });

            $(".shop_btnClose").click(function (e)
            {
                shop_HideDialog($(this).attr('dial'));
                e.preventDefault();
            });

$(".shop_btnCancel").click(function (e)
            {
                shop_HideDialog($(this).attr('dial'));
                e.preventDefault();
});

            $(".shop_btnSubmit").click(function (e)
            {

                if (shop_curent_button==1 && shop_curent_button_poption>0){
//alert($(this).attr('url')+'?poption='+shop_curent_button_poption+'--'+shop_curent_button);
//return false;
                    $(location).attr('href',$(this).attr('url')+'?poption='+shop_curent_button_poption);
                }else{
//alert($(this).attr('url')+'--'+shop_curent_button);
//return false;
                    $(location).attr('href',$(this).attr('url'));
                }
                shop_HideDialog($(this).attr('dial'));
                e.preventDefault();
            });


            $(".shop_btnSubmit_mail").click(function (e)
            {

                $(location).attr('href',$(this).attr('url')+'?poption='+shop_curent_button_poption+'&burl='+$(this).attr('burl')+'&pid='+$(this).attr('pid')+'&content='+$('textarea#mail_content').val());
                shop_HideDialog($(this).attr('dial'));
                e.preventDefault();
            });



});

        function shop_ShowDialog(did,modal)
        {
            $("#shop_overlay").show();
            $("#shop_dialog_"+did).fadeIn(300);

            if (modal)
            {
                $("#shop_overlay").unbind("click");
            }
            else
            {
                $("#shop_overlay").click(function (e)
                {
                    shop_HideDialog(did);
                });
            }
        }

        function shop_HideDialog(did)
        {
            $("#shop_overlay").hide();
            $("#shop_dialog_"+did).fadeOut(300);
        } 
        
