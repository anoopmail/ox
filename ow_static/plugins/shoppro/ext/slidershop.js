var delayLength = 6000;//1000 = 1 SECOND
	
function doMove(panelWidth, tooFar) {
	var leftValue = $("#shop-mover").css("left");
	
	// Fix for IE
	if (leftValue == "auto") { leftValue = 0; };
	
	var movement = parseFloat(leftValue, 10) - panelWidth;
	
	if (movement == tooFar) {
            $("#shop-mover").hide();
                $("#shop-mover").animate({
			"left": 0
		});
            $("#shop-mover").show();
	}
	else {
        	$("#shop-mover").animate({
			"left": movement
		});
	}


}

$(function(){


var shop_page_wrap=$('#shop-page-wrap').width();
var shopslider=shop_page_wrap;
$('#shop-slider').width(shopslider);
//        alert(shopslider+'---'+$('#shop-slider').width());
var shopslide=shopslider-10;
var shop_slide_img=$('.shop-slide #img').width();
//alert(shop_slide_img);
if (!shop_slide_img || shop_slide_img==undefined) shop_slide_img=10;
var shop_slide_p=(shopslide-shop_slide_img-30);
//alert(shopslider+'----'+shop_slide_img+'---60===='+shop_slide_p);
$('.shop-slide').width(shopslide);
$('.shop-slide p').width(shop_slide_p);
//alert(shopslider+'----'+shop_slide_img+'---60===='+shop_slide_p);


    var $slide1 = $("#slide-1");

	var panelWidth = $slide1.css("width");
	var panelPaddingLeft = $slide1.css("paddingLeft");
	var panelPaddingRight = $slide1.css("paddingRight");

	panelWidth = parseFloat(panelWidth, 10);
	panelPaddingLeft = parseFloat(panelPaddingLeft, 10);
	panelPaddingRight = parseFloat(panelPaddingRight, 10);

	panelWidth = panelWidth + panelPaddingLeft + panelPaddingRight;

	var numPanels = $(".shop-slide").length;
	var tooFar = -(panelWidth * numPanels);
	var totalMoverwidth = numPanels * panelWidth;
	$("#shop-mover").css("width", totalMoverwidth);

	sliderIntervalID = setInterval(function(){
		doMove(panelWidth, tooFar);
	}, delayLength);

	$("#shop-slider .shop-slide").click(function(){
            if ($(this).attr('murl')!=undefined){
                window.location = $(this).attr('murl'); 
            }
	});
});
