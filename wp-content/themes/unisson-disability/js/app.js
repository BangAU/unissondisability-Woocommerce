var $=jQuery,win=$(window);function bannerSlider(){const e=$(".homebanner-slider"),s=e.parents(".homebanner-slider-wrap"),n=s.find(".homebanner-slider-navwrap"),o=n.find(".num");e.on("init reInit beforeChange",function(e,s,t,i){let a=$(s.$slides[i]).find(".text");991<$(window).width()&&n.css("top",a.height()+31);i=(i||0)+1;o.html("<span>"+i+"</span>/"+s.slideCount)}),e.slick({dots:!1,infinite:!0,speed:300,slidesToShow:1,adaptiveHeight:!0,prevArrow:$(".slidenav-prev"),nextArrow:$(".slidenav-next")})}function customDropdown(){$(".custom-dropdown").each(function(){const t=$(this),e=t.find(".custom-dropdown-btn").eq(0),i=t.find(".custom-dropdown-list").eq(0);e.click(function(){t.hasClass("toggled")?i.slideUp("fast",function(){t.removeClass("toggled")}):(t.addClass("toggled"),i.slideDown())}),$(document).mouseup(function(e){var s=t;s.is(e.target)||0!==s.has(e.target).length||(i.slideUp(),t.removeClass("toggled"))})})}function customCheckboxDropdown(){$(".checkbox-dropdown").each(function(){const e=$(this),s=e.find(".checkbox-dropdown-btn").eq(0),t=s.find("input"),i=e.find(".checkbox-dropdown-list").eq(0),a=i.find("input");i.length?(t.is(":checked")?(e.addClass("open"),i.slideDown()):(e.removeClass("open"),i.slideUp(),a.prop("checked",!1)),s.click(function(){console.log("btn obj clicked"),t.is(":checked")?(e.addClass("open"),i.slideDown(),a.prop("checked",!0)):(e.removeClass("open"),i.slideUp(),a.prop("checked",!1))})):e.addClass("no-list")})}function megamenu(){$(".megamenu").each(function(){const t=$(this),i=t.parents("li"),e=i.children("a");i.addClass("has-megamenu"),991<$(window).width()?i.click(function(e){e.preventDefault(),$(this).hasClass("open")?($(this).removeClass("open"),t.slideUp()):($(this).addClass("open"),t.slideDown())}):e.click(function(e){e.preventDefault(),$(this).hasClass("open")?($(this).removeClass("open"),t.slideUp()):($(this).addClass("open"),t.slideDown())}),$(document).mouseup(function(e){var s=i;s.is(e.target)||0!==s.has(e.target).length||(s.removeClass("open"),t.slideUp())})})}function sidemenuToggle(){$(".menu-toggle").click(function(){const e=$(this),s=$(".sidemenu");s.hasClass("toggled")?(s.removeClass("toggled"),e.removeClass("menu-open"),$("html").css("overflowY","")):(s.addClass("toggled"),e.addClass("menu-open"),$("html").css("overflowY","hidden"))})}function productsecSlider(){$(".productsec--media").each(function(){const e=$(this),a=e.find(".productsec--media-primary-slider"),s=a.siblings(".slider-navwrap"),t=s.find(".slidenav-prev"),i=s.find(".slidenav-next"),n=s.find(".num"),o=e.find(".productsec--media-secondary-slider"),l=o.siblings(".slider-navwrap"),c=l.find(".slidenav-prev"),d=l.find(".slidenav-next"),r=l.find(".num");a.on("init reInit afterChange",function(e,s,t,i){s.$slides.length<3&&a.addClass("less-slides");t=(t||0)+1;n.html("<span>"+t+"</span>/"+s.slideCount)}),o.on("init reInit afterChange",function(e,s,t,i){s.$slides.length<3&&o.addClass("less-slides");t=(t||0)+1;r.html("<span>"+t+"</span>/"+s.slideCount)}),a.slick({dots:!1,infinite:!1,speed:300,slidesToShow:1,prevArrow:t,nextArrow:i,asNavFor:o}),o.slick({dots:!1,nav:!1,infinite:!1,slidesToShow:3,slidesToScroll:1,speed:300,margin:25,focusOnSelect:!0,prevArrow:c,nextArrow:d,asNavFor:a})})}function productNum(){$(".product--num").each(function(){const e=$(this).find(".product--num-minus"),s=$(this).find(".product--num-plus"),t=$(this).find(".product--num-input");let i=parseInt(t.attr("max")),a;i=i||100,e.click(function(){a=parseInt(t.val()),a<=1?t.val("1"):t.val(a-1)}),s.click(function(){a=parseInt(t.val()),a>=i?t.val(i):t.val(a+1)})})}function customTabs(){$(".customtab").each(function(){$(this).find(".customtab--nav-list li").removeClass("active"),$(this).find(".customtab--nav-list li:first-child").addClass("active"),$(this).find(".customtab--content .customtab--content-item").removeClass("active"),$(this).find(".customtab--content .customtab--content-item:first-child").addClass("active")}),$(".customtab--nav-list li").click(function(e){e.preventDefault();const s=$(this).find("a").attr("href"),t=$(this),i=t.siblings(),a=$('.customtab--content-item[data-id="'+s+'"]');t.hasClass("active")||($(window).width()<992&&($(this).parents(".customtab--nav").find(".customtab--nav-preview .customtab--nav-active").text($(this).text()),$(this).parents(".customtab--nav").find(".customtab--nav-list").slideUp(function(){$(this).parents(".customtab--nav").find(".customtab--nav-preview").removeClass("open"),$(this).parents(".customtab--nav").find(".customtab--nav-list").removeClass("open")})),i.removeClass("active"),a.siblings().slideUp(function(){a.siblings().removeClass("active")}),t.addClass("active"),a.slideDown(function(){a.addClass("active")}),console.log(s),console.log($('.customtab--content-item[data-id="'+s+'"]')))}),$(".customtab--nav-preview").click(function(){const e=$(this).siblings(".customtab--nav-list");$(this).hasClass("open")?($(this).removeClass("open"),e.slideUp(function(){e.removeClass("open")})):($(this).addClass("open"),e.slideDown(function(){e.addClass("open")}))}),$(document).mouseup(function(e){var s=$(".customtab--nav-list");s.is(e.target)||0!==s.has(e.target).length||(s.removeClass("open"),s.siblings(".customtab--nav-preview").removeClass("open"))})}function customAccord(){$(".customaccord--item-header").click(function(){const e=$(this),s=$(this).parents(".customaccord--item"),t=$(this).siblings(".customaccord--item-body"),i=s.siblings(),a=i.find(".customaccord--item-body");s.hasClass("active")?t.slideUp(function(){s.removeClass("active")}):a.slideUp(function(){i.removeClass("active"),t.slideDown(function(){s.addClass("active")}),$("html, body").animate({scrollTop:e.offset().top-60},200)})})}function accessibility(){var e;$(".accessibility-row li").click(function(){setTimeout(function(){$(".slick-slider")[0].slick.refresh(),$(".programfilter-listing").isotope("reloadItems").isotope()},150)}),$(".accessibility-row .smaller-text").addClass("min"),$(".accessibility-row .larger-text").click(function(e){e.preventDefault();var s,e=parseInt($("html").css("font-size"));e<13&&($.cookie("font-size",s=e+1),e=e+1+"px",$("html").css("font-size",e),$(".accessibility-row .smaller-text").removeClass("min"),11==s?($(this).parent("li").removeClass(" smallest medium large"),$(this).parent("li").addClass(" smallest"),$(this).addClass("enabled")):12==s?($(this).parent("li").removeClass(" smallest medium large"),$(this).parent("li").addClass(" medium"),$(this).addClass("enabled")):13==s&&($(this).parent("li").removeClass(" smallest medium large"),$(this).parent("li").addClass("large"),$(this).addClass("max enabled")))}),$(".accessibility-row .smaller-text").click(function(e){e.preventDefault();var s,e=parseInt($("html").css("font-size"));console.log(e),10<e&&($.cookie("font-size",s=e-1),e=e-1+"px",$("html").css("font-size",e),$(".accessibility-row .larger-text").removeClass("max"),12==s?($(".accessibility-row .larger-text").parent("li").removeClass(" smallest medium large"),$(".accessibility-row .larger-text").parent("li").addClass(" medium"),$(".accessibility-row .larger-text").addClass("enabled")):11==s?($(".accessibility-row .larger-text").parent("li").removeClass(" smallest medium large"),$(".accessibility-row .larger-text").parent("li").addClass(" smallest"),$(".accessibility-row .larger-text").addClass("enabled")):10==s&&($(this).addClass("min"),$(".accessibility-row .larger-text").parent("li").removeClass(" smallest medium large"),$(".accessibility-row .larger-text").removeClass("enabled")))}),$(".accessibility-row .dyslexic-font").click(function(e){e.preventDefault(),$(this).hasClass("enabled")?($.cookie("dyslexic-font",0),$("body").removeClass("font-dyslexic"),$(this).removeClass("enabled")):($.cookie("dyslexic-font",1),$("body").addClass("font-dyslexic"),$(this).addClass("enabled"))}),$(".accessibility-row .high-contrast a").click(function(e){e.preventDefault(),$(this).hasClass("enabled")?($.cookie("high-contrast",0),$("body").removeClass("high-contrast"),$(this).removeClass("enabled")):($.cookie("high-contrast",1),$("body").addClass("high-contrast"),$(this).addClass("enabled"))}),$.cookie("high-contrast")&&(1==$.cookie("high-contrast")?($("body").addClass("high-contrast"),$(".accessibility-row.high-contrast a").addClass("enabled")):($("body").removeClass("high-contrast"),$(".accessibility-row.high-contrast a").removeClass("enabled"))),$.cookie("dyslexic-font")&&(1==$.cookie("dyslexic-font")?($("body").addClass("font-dyslexic"),$(".accessibility-row .dyslexic-font").addClass("enabled")):($("body").removeClass("font-dyslexic"),$(".accessibility-row .dyslexic-font").removeClass("enabled"))),$.cookie("font-size")&&($(".accessibility-row .smaller-text").removeClass("min"),$(".accessibility-row .larger-text").removeClass("max"),(e=$.cookie("font-size"))<=13&&10<=e&&(fspx=e+"px",$("html").css("font-size",fspx),13==e&&($(".accessibility-row .larger-text").addClass("max enabled"),$(".accessibility-row .larger-text").parent("li").addClass("large")),12==e&&($(".accessibility-row .larger-text").addClass("enabled"),$(".accessibility-row .larger-text").parent("li").addClass("medium")),11==e&&($(".accessibility-row .larger-text").addClass("enabled"),$(".accessibility-row .larger-text").parent("li").addClass("smallest")),10==e&&$(".accessibility-row .smaller-text").addClass("min"))),$(".accessibility-reset .btn-reset").click(function(e){e.preventDefault(),console.log("reset pressed"),$(".accessibility-row li").removeClass(),$(".accessibility-row .smaller-text").removeClass("min"),$(".accessibility-row .smaller-text").addClass("min"),$(".accessibility-row .larger-text").removeClass("smallest medium large enabled max"),$(".accessibility-row .dyslexic-font").removeClass("enabled disabled"),$(".accessibility-row.high-contrast a").removeClass("enabled disabled"),$("body").removeClass("high-contrast font-dyslexic"),$("html").css("font-size","10px"),$.cookie("high-contrast",0),$.cookie("dyslexic-font",0),$.cookie("font-size","10")})}function attendeeCheckbox(){$(".order-pages .Attendee-group .funding-type-radio").each(function(e){const s=$(this).find('input[type="radio"]');console.log(s),s.prop("name",s.attr("name")+e)})}function preventClick(){$("#gtranslate_selector").parents("a").removeAttr("href")}function dataGridInit(){datagrid({currentPage:0,pageSize:6,pagesRange:4}),$("#clear-filters").click(function(){$(".sortby select").prop("selectedIndex",0),$(".homefilter-selects input:checked").trigger("click")})}function filterScroll(){0<$(".homefilter").length&&-1<window.location.href.indexOf("page/")&&$("html, body").animate({scrollTop:$(".homefilter").offset().top-60},200)}document.addEventListener("DOMContentLoaded",function(){bannerSlider(),customDropdown(),customCheckboxDropdown(),megamenu(),sidemenuToggle(),productsecSlider(),productNum(),customTabs(),customAccord(),accessibility(),preventClick(),attendeeCheckbox(),filterScroll()}),win.on("resize",function(){}),AOS.init({once:!0}),jQuery(document).ready(function(e){var s=window.location.href;"login"==(s=(s=s.split("/"))[s.length-2])&&e("#customer_login .u-column2").remove(),"register"==s&&e("#customer_login .u-column1").remove()}),$(document).ready(function(){$(".self_manage_funding_text").hide(),$(".plan-managed-funding-text").hide(),$(".ndia-managed-funding-text").hide(),$('input:radio[name="_funding_type_radio_1"]').change(function(){$(this).is(":checked")&&"Self_managed"==$(this).val()?($(".self_manage_funding_text").show(),$(".plan-managed-funding-text").hide(),$(".ndia-managed-funding-text").hide()):$(this).is(":checked")&&"Plan_managed"==$(this).val()?($(".self_manage_funding_text").hide(),$(".plan-managed-funding-text").show(),$(".ndia-managed-funding-text").hide()):$(this).is(":checked")&&"Ndia_managed"==$(this).val()&&($(".self_manage_funding_text").hide(),$(".plan-managed-funding-text").hide(),$(".ndia-managed-funding-text").show())})});