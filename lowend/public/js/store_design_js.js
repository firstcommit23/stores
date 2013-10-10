$(document).ready(init);


	function init()
	{
		/* editor title click sliding */
		$(".slidheader h3").toggle(function(e){
			e.preventDefault();
			$(this).siblings().slideUp();
		},function(e){
			e.preventDefault();
			$(this).siblings().slideDown();
		});

		/* logo delete btn click event */
		$("#logoDeleteBtn").click(function(){
			$("#logo_img").empty();
			$("#logo_img").prepend('<img src="" alt="logo" style="display: none;" >');
			store_logo = "";
		});

		/* editor title open/hide */
		$('.openSlidmenu').click(function() {
			$("#slidmenu").animate({
				width: 'toggle'},300);
			});

		/* editor show/hide btn click event*/
		$(".trigger").click(function(){
			$(".panel").toggle("fast");
			$(this).toggleClass("active");
			return false;
		});

		/* preview category dropdown mouseover event */
		$('.btn_dropdown').on({
		      'mouseenter':function(){
		        $(this).find('.dropdown').fadeIn(100);
		      },
		      'mouseleave':function(){
		        $(this).find('.dropdown').fadeOut(100);
		      }
		});



		/* initialization */
		setLayoutStyle(store_layout);
		setStoreNameFontColor(store_name_text_color);
		setMenuFontColor(menu_text_color);
		setItemFontColor(item_text_color);
		setPriceFontColor(price_text_color);
		item_hover(display_price);
		toggle_frame(display_frame);




	}

	function setStoreNameFontColor(color)
	{
		$(".shop_title").css({"color":color});
		store_name_text_color = color;
	}

	function setMenuFontColor(color)
	{
	$(".shop_menu a").css({"color":"null"});
		$(".shop_menu a").css({"color":color});
		menu_text_color = color;
	}

	function setItemFontColor(color)
	{
		$(".name").css({"color":"null"});
		$(".name").css({"color":color});
		item_text_color = color;
	}

	function setPriceFontColor(color)
	{
		$(".price").css({"color":color});
		price_text_color = color;
	}

	function setBackgroundColor(color)
	{
		$("body").css("background-image", "url(null)");
		$("body").css({"background-color":color});
	}

	function setBackgroundImg($file_name)
	{
		$('body').css({'background-repeat': 'repeat'});
		$("body").css({"background-color": "null"});
		$("body").css({"background-image":"url('" + $file_name + "')"});
	}

	function setLayoutStyle(style)
	{
		$("#layout_pattern").removeClass().addClass(style);
		store_layout = style;
	}

	function ajaxFileUpload()
	{
		$.ajaxFileUpload
		(
			{
				dataType: 'json',
				url:'/fileupload',
				data : $("#form").serialize(),
				type: "post",
				secureuri:false,
				fileElementId:'fileToUpload',

				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert(data.error);
						}else
						{
							$("body").css({"background-image":"url('upload/temp/" + data.file_name + "')"});
						}
					}
				},

				error: function (data, status, e)
				{
					alert(e);
				}



			}
		)
		return false;
	}

	function ajaxLogoUpload()
	{
		$.ajaxFileUpload
		(
			{
				dataType: 'json',
				url:'/filelogoupload',
				data : $("#logoForm").serialize(),
				type: "post",
				secureuri:false,
				fileElementId:'LogoToUpload',

				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert(data.error);
						}else
						{
							store_logo = data.file_name;
							$("#logo_img").empty();
							$("#logo_img").prepend('<img alt="logo" src="upload/temp/'  + data.file_name + '" />');

						}
					}
				},

				error: function (data, status, e)
				{
					alert(e);
				}

			}
		)
		return false;
	}

	function toggle_frame(state) {
		if(state =='Y') {
			$('.items').css({'background': '#ffffff'});
			display_frame = 'N';
			$("#display_frame_state").text("ON");
		} else {
			$('.items').css({'background': 'none'});
			display_frame = 'Y';
			$("#display_frame_state").text("OFF");
		}
	}


function item_hover(flag){
	if(flag =='Y'){
		$('#item_list').removeClass('hover_style');
		$('.items').each(function(){
			$(this).unbind('mouseenter').unbind('mouseleave');
			$(this).find('.data').css({
				'display':'block',
				'opacity':1
			});
		});
		display_price = 'N';
		$("#display_item_state").text("ON");
	}else{
		$('#item_list').addClass('hover_style');
		$('.items').each(function(){
			$(this).find('.data').css({'display':'none'});
			$(this).bind('mouseenter',function(){
				$(this).find('.data').fadeIn(200);
			}).bind('mouseleave',function(){
				$(this).find('.data').fadeOut(200);
			});
		});
		display_price = 'Y';
		$("#display_item_state").text("OFF");
	}
}

function background_repeat(state){
	if(state) {
		$('body').css({'background-repeat': 'no-repeat'});
	} else {
		$('body').css({'background-repeat': 'repeat'});
	}

	background_original_repeat = !background_original_repeat;


}
function change_active_element(self, target_selector) {
	$(target_selector).removeClass('active');
	$(self).addClass('active');
}

/* file upload image plugin */

(function($){$.fn.filestyle=function(options){var settings={width:250};if(options){$.extend(settings,options);};return this.each(function(){var self=this;var wrapper=$("<div>").css({"width":settings.imagewidth+"px","height":settings.imageheight+"px","background":"url("+settings.image+") 0 0 no-repeat","background-position":"right","display":"inline","position":"absolute","overflow":"hidden"});var filename=$('<input class="file">').addClass($(self).attr("class")).css({"display":"inline","width":settings.width+"px"});$(self).before(filename);$(self).wrap(wrapper);$(self).css({"position":"relative","height":settings.imageheight+"px","width":settings.width+"px","display":"inline","cursor":"pointer","opacity":"0.0"});if($.browser.mozilla){if(/Win/.test(navigator.platform)){$(self).css("margin-left","-142px");}else{$(self).css("margin-left","-168px");};}else{$(self).css("margin-left",settings.imagewidth-settings.width+"px");};$(self).bind("change",function(){filename.val($(self).val());});});};})(jQuery);

$("input[type=file]").filestyle({
    image: "/images/setup.png",
    imageheight : 22,
    imagewidth : 82,
    width : 250
});

/* file upload image plugin */