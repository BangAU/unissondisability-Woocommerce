var $=jQuery,win=$(window);function bannerSlider(){const e=$(".homebanner-slider"),t=e.parents(".homebanner-slider-wrap"),n=t.find(".homebanner-slider-navwrap"),o=n.find(".num");e.on("init reInit beforeChange",function(e,t,s,i){let a=$(t.$slides[i]).find(".text");991<$(window).width()&&n.css("top",a.height()+31);i=(i||0)+1;o.html("<span>"+i+"</span>/"+t.slideCount)}),e.slick({dots:!1,infinite:!0,speed:300,slidesToShow:1,adaptiveHeight:!0,prevArrow:$(".slidenav-prev"),nextArrow:$(".slidenav-next")})}function customDropdown(){$(".custom-dropdown").each(function(){const s=$(this),e=s.find(".custom-dropdown-btn").eq(0),i=s.find(".custom-dropdown-list").eq(0);e.click(function(){s.hasClass("toggled")?i.slideUp("fast",function(){s.removeClass("toggled")}):(s.addClass("toggled"),i.slideDown())}),$(document).mouseup(function(e){var t=s;t.is(e.target)||0!==t.has(e.target).length||(i.slideUp(),s.removeClass("toggled"))})})}function customCheckboxDropdown(){$(".checkbox-dropdown").each(function(){const e=$(this),t=e.find(".checkbox-dropdown-btn").eq(0),s=t.find("input"),i=e.find(".checkbox-dropdown-list").eq(0),a=i.find("input");i.length?(s.is(":checked")?(e.addClass("open"),i.slideDown()):(e.removeClass("open"),i.slideUp(),a.prop("checked",!1)),t.click(function(){console.log("btn obj clicked"),s.is(":checked")?(e.addClass("open"),i.slideDown()):(e.removeClass("open"),i.slideUp(),a.prop("checked",!1))})):e.addClass("no-list")})}function megamenu(){$(".megamenu").each(function(){const s=$(this),i=s.parents("li");i.addClass("has-megamenu"),i.click(function(e){e.preventDefault(),$(this).hasClass("open")?($(this).removeClass("open"),s.slideUp()):($(this).addClass("open"),s.slideDown())}),$(document).mouseup(function(e){var t=i;t.is(e.target)||0!==t.has(e.target).length||(t.removeClass("open"),s.slideUp())})})}function sidemenuToggle(){$(".menu-toggle").click(function(){const e=$(this),t=$(".sidemenu");t.hasClass("toggled")?(t.removeClass("toggled"),e.removeClass("menu-open"),$("html").css("overflowY","")):(t.addClass("toggled"),e.addClass("menu-open"),$("html").css("overflowY","hidden"))})}function productsecSlider(){$(".productsec--media").each(function(){const e=$(this),t=e.find(".productsec--media-primary-slider"),s=e.find(".productsec--media-secondary-slider"),a=s.siblings(".slider-navwrap"),i=a.find(".slidenav-prev"),n=a.find(".slidenav-next"),o=a.find(".num");t.on("init reInit beforeChange",function(e,t,s,i){t.$slides.length<3&&a.hide();s=(s||0)+1;o.html("<span>"+s+"</span>/"+t.slideCount)}),t.slick({dots:!1,infinite:!0,speed:300,slidesToShow:1,asNavFor:s}),s.slick({dots:!1,nav:!1,loop:!0,slidesToShow:3,slidesToScroll:1,infinite:!0,speed:300,margin:25,focusOnSelect:!0,prevArrow:i,nextArrow:n,asNavFor:t})})}function productNum(){$(".product--num").each(function(){const e=$(this).find(".product--num-minus"),t=$(this).find(".product--num-plus"),s=$(this).find(".product--num-input");let i=parseInt(s.attr("max")),a;i=i||100,e.click(function(){a=parseInt(s.val()),a<=1?s.val("1"):s.val(a-1)}),t.click(function(){a=parseInt(s.val()),a>=i?s.val(i):s.val(a+1)})})}function customTabs(){$(".customtab").each(function(){$(this).find(".customtab--nav-list li").removeClass("active"),$(this).find(".customtab--nav-list li:first-child").addClass("active"),$(this).find(".customtab--content .customtab--content-item").removeClass("active"),$(this).find(".customtab--content .customtab--content-item:first-child").addClass("active")}),$(".customtab--nav-list li").click(function(e){e.preventDefault();const t=$(this).find("a").attr("href"),s=$(this),i=s.siblings(),a=$('.customtab--content-item[data-id="'+t+'"]');s.hasClass("active")||($(window).width()<992&&($(this).parents(".customtab--nav").find(".customtab--nav-preview .customtab--nav-active").text($(this).text()),$(this).parents(".customtab--nav").find(".customtab--nav-list").slideUp(function(){$(this).parents(".customtab--nav").find(".customtab--nav-preview").removeClass("open"),$(this).parents(".customtab--nav").find(".customtab--nav-list").removeClass("open")})),i.removeClass("active"),a.siblings().slideUp(function(){a.siblings().removeClass("active")}),s.addClass("active"),a.slideDown(function(){a.addClass("active")}),console.log(t),console.log($('.customtab--content-item[data-id="'+t+'"]')))}),$(".customtab--nav-preview").click(function(){const e=$(this).siblings(".customtab--nav-list");$(this).hasClass("open")?($(this).removeClass("open"),e.slideUp(function(){e.removeClass("open")})):($(this).addClass("open"),e.slideDown(function(){e.addClass("open")}))}),$(document).mouseup(function(e){var t=$(".customtab--nav-list");t.is(e.target)||0!==t.has(e.target).length||(t.removeClass("open"),t.siblings(".customtab--nav-preview").removeClass("open"))})}function customAccord(){$(".customaccord--item-header").click(function(){const e=$(this).parents(".customaccord--item"),t=$(this).siblings(".customaccord--item-body"),s=e.siblings(),i=s.find(".customaccord--item-body");e.hasClass("active")?t.slideUp(function(){e.removeClass("active")}):i.slideUp(function(){s.removeClass("active"),t.slideDown(function(){e.addClass("active")}),$("html, body").animate({scrollTop:t.offset().top-60},250)})})}function accessibility(){var e;$(".accessibility-row .smaller-text").addClass("min"),$(".accessibility-row .larger-text").click(function(e){e.preventDefault();var t,e=parseInt($("html").css("font-size"));console.log(e),e<13&&($.cookie("font-size",t=e+1),e=e+1+"px",$("html").css("font-size",e),$(".accessibility-row .smaller-text").removeClass("min"),11==t?($(this).parent("li").removeClass(" smallest medium large"),$(this).parent("li").addClass(" smallest"),$(this).addClass("enabled")):12==t?($(this).parent("li").removeClass(" smallest medium large"),$(this).parent("li").addClass(" medium"),$(this).addClass("enabled")):13==t&&($(this).parent("li").removeClass(" smallest medium large"),$(this).parent("li").addClass("large"),$(this).addClass("max enabled")))}),$(".accessibility-row .smaller-text").click(function(e){e.preventDefault();var t,e=parseInt($("html").css("font-size"));console.log(e),10<e&&($.cookie("font-size",t=e-1),e=e-1+"px",$("html").css("font-size",e),$(".accessibility-row .larger-text").removeClass("max"),12==t?($(".accessibility-row .larger-text").parent("li").removeClass(" smallest medium large"),$(".accessibility-row .larger-text").parent("li").addClass(" medium"),$(".accessibility-row .larger-text").addClass("enabled")):11==t?($(".accessibility-row .larger-text").parent("li").removeClass(" smallest medium large"),$(".accessibility-row .larger-text").parent("li").addClass(" smallest"),$(".accessibility-row .larger-text").addClass("enabled")):10==t&&($(this).addClass("min"),$(".accessibility-row .larger-text").parent("li").removeClass(" smallest medium large"),$(".accessibility-row .larger-text").removeClass("enabled")))}),$(".accessibility-row .dyslexic-font").click(function(e){e.preventDefault(),$(this).hasClass("enabled")?($.cookie("dyslexic-font",0),$("body").removeClass("font-dyslexic"),$(this).removeClass("enabled")):($.cookie("dyslexic-font",1),$("body").addClass("font-dyslexic"),$(this).addClass("enabled"))}),$(".accessibility-row .high-contrast a").click(function(e){e.preventDefault(),$(this).hasClass("enabled")?($.cookie("high-contrast",0),$("body").removeClass("high-contrast"),$(this).removeClass("enabled")):($.cookie("high-contrast",1),$("body").addClass("high-contrast"),$(this).addClass("enabled"))}),$.cookie("high-contrast")&&(1==$.cookie("high-contrast")?($("body").addClass("high-contrast"),$(".accessibility-row.high-contrast a").addClass("enabled")):($("body").removeClass("high-contrast"),$(".accessibility-row.high-contrast a").removeClass("enabled"))),$.cookie("dyslexic-font")&&(1==$.cookie("dyslexic-font")?($("body").addClass("font-dyslexic"),$(".accessibility-row .dyslexic-font").addClass("enabled")):($("body").removeClass("font-dyslexic"),$(".accessibility-row .dyslexic-font").removeClass("enabled"))),$.cookie("font-size")&&($(".accessibility-row .smaller-text").removeClass("min"),$(".accessibility-row .larger-text").removeClass("max"),(e=$.cookie("font-size"))<=13&&10<=e&&(fspx=e+"px",$("html").css("font-size",fspx),13==e&&($(".accessibility-row .larger-text").addClass("max enabled"),$(".accessibility-row .larger-text").parent("li").addClass("large")),12==e&&($(".accessibility-row .larger-text").addClass("enabled"),$(".accessibility-row .larger-text").parent("li").addClass("medium")),11==e&&($(".accessibility-row .larger-text").addClass("enabled"),$(".accessibility-row .larger-text").parent("li").addClass("smallest")),10==e&&$(".accessibility-row .smaller-text").addClass("min"))),$(".accessibility-reset .btn-reset").click(function(e){e.preventDefault(),console.log("reset pressed"),$(".accessibility-row li").removeClass(),$(".accessibility-row .smaller-text").removeClass("min"),$(".accessibility-row .smaller-text").addClass("min"),$(".accessibility-row .larger-text").removeClass("smallest medium large enabled max"),$(".accessibility-row .dyslexic-font").removeClass("enabled disabled"),$(".accessibility-row.high-contrast a").removeClass("enabled disabled"),$("body").removeClass("high-contrast font-dyslexic"),$("html").css("font-size","10px"),$.cookie("high-contrast",0),$.cookie("dyslexic-font",0),$.cookie("font-size","10"),$("#\\:1\\.container").contents().find("#\\:1\\.restore").click()})}function isotopeInitv3(){var n,o,l,s,c,d,t,r,m,u,h;function f(e){t=e;var s=n,i=[];$(".pagination li").removeClass("active"),$(".pagination li:nth-child("+e+")").addClass("active"),o.each(function(e,t){t.checked&&(s+="*"!=r?"."+t.value:"",i.push(s))}),m=i.length?i.join(""):"*";e=t.toString();e=m+="."+e,l.isotope({filter:e})}function i(){var e,t,s,i,a;e=l.children(n).length,Math.ceil(e/c),s=t=1,i=n,a=[],o.each(function(e,t){t.checked&&(i+="*"!=r?"."+t.value:"",a.push(i))}),m=a.length?a.join(""):"*",l.children(m).each(function(){c<t&&(s++,t=1),wordPage=s.toString();var e=$(this).attr("class").split(" ");e[e.length-1].length<4?($(this).removeClass(),e.pop(),e.push(wordPage),e=e.join(" "),$(this).addClass(e)):$(this).addClass(wordPage),t++}),d=s,function(){var e=0==$("."+h).length?$('<ul class="'+h+'"></ul>'):$("."+h);if(e.html(""),1<d){for(var t=0;t<d;t++){var s=$('<li href="javascript:void(0);" class="pager" data-page="'+(t+1)+'"></li>');s.html(t+1),s.click(function(){f($(this).eq(0).attr(u))}),s.appendTo(e)}$('<li class="prev"></li><li class="next"></li>').appendTo(e),$(".pagination .prev").click(function(){var t,e=$(this).siblings(".pager");e.first().hasClass("active")||(e.each(function(e){$(this).hasClass("active")&&(t=e+1)}),f(t-1),$("html, body").animate({scrollTop:$(".programfilter").offset().top},1e3))}),$(".pagination .next").click(function(){var t,e=$(this).siblings(".pager");e.last().hasClass("active")||(e.each(function(e){$(this).hasClass("active")&&(t=e+1)}),f(t+1),$("html, body").animate({scrollTop:$(".homefilter").offset().top},1e3))})}l.after(e)}();$(".homefilter .pagination .pager").click(function(){$("html, body").animate({scrollTop:$(".homefilter").offset().top},1e3)})}$(".programfilter-listing").length&&(n=".homefilter-item",o=$(".homefilter-selects .checkbox input"),l=$(".programfilter-listing").isotope({itemSelector:n,getSortData:{ascending:".heading-title",descending:".heading-title",priceLow:function(e){e=$(e).find(".price-num").text().replace(/[^0-9]/g,"");return parseInt(e)},priceHigh:function(e){e=$(e).find(".price-num").text().replace(/[^0-9]/g,"");return parseInt(e)}}}),console.log(o),$(".sortby .custom-dropdown").on("click","button",function(){const e=$(this).parents(".custom-dropdown"),t=(e.find("button"),e.find(".preview-text"));var s=$(this).attr("data-sort-value"),i=$(this).attr("data-sort-direction");l.isotope({sortBy:s,sortAscending:"asc"==i}),t.text($(this).text())}),s=[[767,6]],c=function(){for(var e=6,t=0;t<s.length;t++)if($(window).width()<=s[t][0]){e=s[t][1];break}return e}(),t=d=1,r="*",m="",u="data-page",h="pagination",i(),f(1),o.change(function(){var e=$(this).attr("data-filter");r=e,i(),f(1)}),$("#clear-filters").click(function(){l.isotope({filter:"*",sortBy:""}),$(".sortby .custom-dropdown-btn .preview-text").text($(".sortby .custom-dropdown-list li:first-child button").text()),o.each(function(e,t){t.checked&&(t.checked=null)}),r="*",i(),f(1)}))}function preventClick(){$("#gtranslate_selector").parents("a").removeAttr("href")}function loginRegister(){var e=window.location.href;"login"==(e=(e=e.split("/"))[e.length-2])&&$("#customer_login .u-column2").remove(),"register"==e&&$("#customer_login .u-column1").remove()}function fundingType(){$(".self_manage_funding_text").hide(),$(".plan-managed-funding-text").hide(),$(".ndia-managed-funding-text").hide(),$(".input-radio").each(function(){var t=$(this);t.change(function(){console.log("skdjf");var e=t.closest(".Attendee-group");t.is(":checked")&&"Self_managed"==t.val()?(e.find(".self_manage_funding_text").show(),e.find(".plan-managed-funding-text").hide(),e.find(".ndia-managed-funding-text").hide()):t.is(":checked")&&"Plan_managed"==t.val()?(e.find(".self_manage_funding_text").hide(),e.find(".plan-managed-funding-text").show(),e.find(".ndia-managed-funding-text").hide()):t.is(":checked")&&"Ndia_managed"==t.val()&&(e.find(".self_manage_funding_text").hide(),e.find(".plan-managed-funding-text").hide(),e.find(".ndia-managed-funding-text").show())})})}document.addEventListener("DOMContentLoaded",function(){bannerSlider(),customDropdown(),customCheckboxDropdown(),megamenu(),sidemenuToggle(),productsecSlider(),productNum(),customTabs(),customAccord(),accessibility(),isotopeInitv3(),preventClick(),loginRegister(),fundingType()}),win.on("resize",function(){}),AOS.init({once:!0});