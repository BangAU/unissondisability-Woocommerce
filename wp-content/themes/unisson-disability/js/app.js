var $=jQuery,win=$(window);function bannerSlider(){const e=$(".homebanner-slider"),s=e.parents(".homebanner-slider-wrap"),a=s.find(".homebanner-slider-navwrap"),o=a.find(".num");e.on("init reInit beforeChange",function(e,s,t,i){let n=$(s.$slides[i]).find(".text");991<$(window).width()&&a.css("top",n.height()+31);i=(i||0)+1;o.html("<span>"+i+"</span>/"+s.slideCount)}),e.slick({dots:!1,infinite:!0,speed:300,slidesToShow:1,adaptiveHeight:!0,prevArrow:$(".slidenav-prev"),nextArrow:$(".slidenav-next")})}function customDropdown(){$(".custom-dropdown").each(function(){const t=$(this),e=t.find(".custom-dropdown-btn").eq(0),i=t.find(".custom-dropdown-list").eq(0);e.click(function(){t.hasClass("toggled")?i.slideUp("fast",function(){t.removeClass("toggled")}):(t.addClass("toggled"),i.slideDown())}),$(document).mouseup(function(e){var s=t;s.is(e.target)||0!==s.has(e.target).length||(i.slideUp(),t.removeClass("toggled"))})})}function customCheckboxDropdown(){$(".checkbox-dropdown").each(function(){const e=$(this),s=e.find(".checkbox-dropdown-btn").eq(0),t=s.find("input"),i=e.find(".checkbox-dropdown-list").eq(0),n=i.find("input");i.length?(t.is(":checked")?(e.addClass("open"),i.slideDown()):(e.removeClass("open"),i.slideUp(),n.prop("checked",!1)),s.click(function(){console.log("btn obj clicked"),t.is(":checked")?(e.addClass("open"),i.slideDown()):(e.removeClass("open"),i.slideUp(),n.prop("checked",!1))})):e.addClass("no-list")})}function megamenu(){$(".megamenu").each(function(){const t=$(this),i=t.parents("li"),e=i.children("a");i.addClass("has-megamenu"),991<$(window).width()?i.click(function(e){e.preventDefault(),$(this).hasClass("open")?($(this).removeClass("open"),t.slideUp()):($(this).addClass("open"),t.slideDown())}):e.click(function(e){e.preventDefault(),$(this).hasClass("open")?($(this).removeClass("open"),t.slideUp()):($(this).addClass("open"),t.slideDown())}),$(document).mouseup(function(e){var s=i;s.is(e.target)||0!==s.has(e.target).length||(s.removeClass("open"),t.slideUp())})})}function sidemenuToggle(){$(".menu-toggle").click(function(){const e=$(this),s=$(".sidemenu");s.hasClass("toggled")?(s.removeClass("toggled"),e.removeClass("menu-open"),$("html").css("overflowY","")):(s.addClass("toggled"),e.addClass("menu-open"),$("html").css("overflowY","hidden"))})}function productsecSlider(){$(".productsec--media").each(function(){const e=$(this),n=e.find(".productsec--media-primary-slider"),s=n.siblings(".slider-navwrap"),t=s.find(".slidenav-prev"),i=s.find(".slidenav-next"),a=s.find(".num"),o=e.find(".productsec--media-secondary-slider"),l=o.siblings(".slider-navwrap"),c=l.find(".slidenav-prev"),d=l.find(".slidenav-next"),r=l.find(".num");n.on("init reInit afterChange",function(e,s,t,i){s.$slides.length<3&&n.addClass("less-slides");t=(t||0)+1;a.html("<span>"+t+"</span>/"+s.slideCount)}),o.on("init reInit afterChange",function(e,s,t,i){s.$slides.length<3&&o.addClass("less-slides");t=(t||0)+1;r.html("<span>"+t+"</span>/"+s.slideCount)}),n.slick({dots:!1,infinite:!1,speed:300,slidesToShow:1,prevArrow:t,nextArrow:i,asNavFor:o}),o.slick({dots:!1,nav:!1,infinite:!1,slidesToShow:3,slidesToScroll:1,speed:300,margin:25,focusOnSelect:!0,prevArrow:c,nextArrow:d,asNavFor:n})})}function productNum(){$(".product--num").each(function(){const e=$(this).find(".product--num-minus"),s=$(this).find(".product--num-plus"),t=$(this).find(".product--num-input");let i=parseInt(t.attr("max")),n;i=i||100,e.click(function(){n=parseInt(t.val()),n<=1?t.val("1"):t.val(n-1)}),s.click(function(){n=parseInt(t.val()),n>=i?t.val(i):t.val(n+1)})})}function customTabs(){$(".customtab").each(function(){$(this).find(".customtab--nav-list li").removeClass("active"),$(this).find(".customtab--nav-list li:first-child").addClass("active"),$(this).find(".customtab--content .customtab--content-item").removeClass("active"),$(this).find(".customtab--content .customtab--content-item:first-child").addClass("active")}),$(".customtab--nav-list li").click(function(e){e.preventDefault();const s=$(this).find("a").attr("href"),t=$(this),i=t.siblings(),n=$('.customtab--content-item[data-id="'+s+'"]');t.hasClass("active")||($(window).width()<992&&($(this).parents(".customtab--nav").find(".customtab--nav-preview .customtab--nav-active").text($(this).text()),$(this).parents(".customtab--nav").find(".customtab--nav-list").slideUp(function(){$(this).parents(".customtab--nav").find(".customtab--nav-preview").removeClass("open"),$(this).parents(".customtab--nav").find(".customtab--nav-list").removeClass("open")})),i.removeClass("active"),n.siblings().slideUp(function(){n.siblings().removeClass("active")}),t.addClass("active"),n.slideDown(function(){n.addClass("active")}),console.log(s),console.log($('.customtab--content-item[data-id="'+s+'"]')))}),$(".customtab--nav-preview").click(function(){const e=$(this).siblings(".customtab--nav-list");$(this).hasClass("open")?($(this).removeClass("open"),e.slideUp(function(){e.removeClass("open")})):($(this).addClass("open"),e.slideDown(function(){e.addClass("open")}))}),$(document).mouseup(function(e){var s=$(".customtab--nav-list");s.is(e.target)||0!==s.has(e.target).length||(s.removeClass("open"),s.siblings(".customtab--nav-preview").removeClass("open"))})}function customAccord(){$(".customaccord--item-header").click(function(){const e=$(this),s=$(this).parents(".customaccord--item"),t=$(this).siblings(".customaccord--item-body"),i=s.siblings(),n=i.find(".customaccord--item-body");s.hasClass("active")?t.slideUp(function(){s.removeClass("active")}):n.slideUp(function(){i.removeClass("active"),t.slideDown(function(){s.addClass("active")}),$("html, body").animate({scrollTop:e.offset().top-60},200)})})}function accessibility(){var e;$(".accessibility-row li").click(function(){setTimeout(function(){$(".slick-slider")[0].slick.refresh(),$(".programfilter-listing").isotope("reloadItems").isotope()},150)}),$(".accessibility-row .smaller-text").addClass("min"),$(".accessibility-row .larger-text").click(function(e){e.preventDefault();var s,e=parseInt($("html").css("font-size"));e<13&&($.cookie("font-size",s=e+1),e=e+1+"px",$("html").css("font-size",e),$(".accessibility-row .smaller-text").removeClass("min"),11==s?($(this).parent("li").removeClass(" smallest medium large"),$(this).parent("li").addClass(" smallest"),$(this).addClass("enabled")):12==s?($(this).parent("li").removeClass(" smallest medium large"),$(this).parent("li").addClass(" medium"),$(this).addClass("enabled")):13==s&&($(this).parent("li").removeClass(" smallest medium large"),$(this).parent("li").addClass("large"),$(this).addClass("max enabled")))}),$(".accessibility-row .smaller-text").click(function(e){e.preventDefault();var s,e=parseInt($("html").css("font-size"));console.log(e),10<e&&($.cookie("font-size",s=e-1),e=e-1+"px",$("html").css("font-size",e),$(".accessibility-row .larger-text").removeClass("max"),12==s?($(".accessibility-row .larger-text").parent("li").removeClass(" smallest medium large"),$(".accessibility-row .larger-text").parent("li").addClass(" medium"),$(".accessibility-row .larger-text").addClass("enabled")):11==s?($(".accessibility-row .larger-text").parent("li").removeClass(" smallest medium large"),$(".accessibility-row .larger-text").parent("li").addClass(" smallest"),$(".accessibility-row .larger-text").addClass("enabled")):10==s&&($(this).addClass("min"),$(".accessibility-row .larger-text").parent("li").removeClass(" smallest medium large"),$(".accessibility-row .larger-text").removeClass("enabled")))}),$(".accessibility-row .dyslexic-font").click(function(e){e.preventDefault(),$(this).hasClass("enabled")?($.cookie("dyslexic-font",0),$("body").removeClass("font-dyslexic"),$(this).removeClass("enabled")):($.cookie("dyslexic-font",1),$("body").addClass("font-dyslexic"),$(this).addClass("enabled"))}),$(".accessibility-row .high-contrast a").click(function(e){e.preventDefault(),$(this).hasClass("enabled")?($.cookie("high-contrast",0),$("body").removeClass("high-contrast"),$(this).removeClass("enabled")):($.cookie("high-contrast",1),$("body").addClass("high-contrast"),$(this).addClass("enabled"))}),$.cookie("high-contrast")&&(1==$.cookie("high-contrast")?($("body").addClass("high-contrast"),$(".accessibility-row.high-contrast a").addClass("enabled")):($("body").removeClass("high-contrast"),$(".accessibility-row.high-contrast a").removeClass("enabled"))),$.cookie("dyslexic-font")&&(1==$.cookie("dyslexic-font")?($("body").addClass("font-dyslexic"),$(".accessibility-row .dyslexic-font").addClass("enabled")):($("body").removeClass("font-dyslexic"),$(".accessibility-row .dyslexic-font").removeClass("enabled"))),$.cookie("font-size")&&($(".accessibility-row .smaller-text").removeClass("min"),$(".accessibility-row .larger-text").removeClass("max"),(e=$.cookie("font-size"))<=13&&10<=e&&(fspx=e+"px",$("html").css("font-size",fspx),13==e&&($(".accessibility-row .larger-text").addClass("max enabled"),$(".accessibility-row .larger-text").parent("li").addClass("large")),12==e&&($(".accessibility-row .larger-text").addClass("enabled"),$(".accessibility-row .larger-text").parent("li").addClass("medium")),11==e&&($(".accessibility-row .larger-text").addClass("enabled"),$(".accessibility-row .larger-text").parent("li").addClass("smallest")),10==e&&$(".accessibility-row .smaller-text").addClass("min"))),$(".accessibility-reset .btn-reset").click(function(e){e.preventDefault(),console.log("reset pressed"),$(".accessibility-row li").removeClass(),$(".accessibility-row .smaller-text").removeClass("min"),$(".accessibility-row .smaller-text").addClass("min"),$(".accessibility-row .larger-text").removeClass("smallest medium large enabled max"),$(".accessibility-row .dyslexic-font").removeClass("enabled disabled"),$(".accessibility-row.high-contrast a").removeClass("enabled disabled"),$("body").removeClass("high-contrast font-dyslexic"),$("html").css("font-size","10px"),$.cookie("high-contrast",0),$.cookie("dyslexic-font",0),$.cookie("font-size","10")})}function isotopeInitv3(){var a,o,l,t,c,d,s,r,m,h,u;function f(e){s=e;var t=a,i=[];$(".pagination li").removeClass("active"),$(".pagination li:nth-child("+e+")").addClass("active"),o.each(function(e,s){s.checked&&(t+="*"!=r?"."+s.value:"",i.push(t))}),m=i.length?i.join(""):"*";e=s.toString();e=m+="."+e,l.isotope({filter:e})}function i(){var e,s,t,i,n;e=l.children(a).length,Math.ceil(e/c),t=s=1,i=a,n=[],o.each(function(e,s){s.checked&&(i+="*"!=r?"."+s.value:"",n.push(i))}),m=n.length?n.join(""):"*",l.children(m).each(function(){c<s&&(t++,s=1),wordPage=t.toString();var e=$(this).attr("class").split(" ");e[e.length-1].length<4?($(this).removeClass(),e.pop(),e.push(wordPage),e=e.join(" "),$(this).addClass(e)):$(this).addClass(wordPage),s++}),d=t,function(){var e=0==$("."+u).length?$('<ul class="'+u+'"></ul>'):$("."+u);if(e.html(""),1<d){for(var s=0;s<d;s++){var t=$('<li href="javascript:void(0);" class="pager" data-page="'+(s+1)+'"></li>');t.html(s+1),t.click(function(){f($(this).eq(0).attr(h))}),t.appendTo(e)}$('<li class="prev"></li><li class="next"></li>').appendTo(e),$(".pagination .prev").click(function(){var s,e=$(this).siblings(".pager");e.first().hasClass("active")||(e.each(function(e){$(this).hasClass("active")&&(s=e+1)}),f(s-1),$("html, body").animate({scrollTop:$(".programfilter").offset().top},1e3))}),$(".pagination .next").click(function(){var s,e=$(this).siblings(".pager");e.last().hasClass("active")||(e.each(function(e){$(this).hasClass("active")&&(s=e+1)}),f(s+1),$("html, body").animate({scrollTop:$(".homefilter").offset().top},1e3))})}l.after(e)}();$(".homefilter .pagination .pager").click(function(){$("html, body").animate({scrollTop:$(".homefilter").offset().top},1e3)})}$(".programfilter-listing").length&&(a=".homefilter-item",o=$(".homefilter-selects .checkbox input"),l=$(".programfilter-listing").isotope({itemSelector:a,getSortData:{ascending:".heading-title",descending:".heading-title",priceLow:function(e){e=$(e).find(".price-num").text().replace(/[^0-9]/g,"");return parseInt(e)},priceHigh:function(e){e=$(e).find(".price-num").text().replace(/[^0-9]/g,"");return parseInt(e)}}}),console.log(o),$(".sortby .custom-dropdown").on("click","button",function(){const e=$(this).parents(".custom-dropdown"),s=(e.find("button"),e.find(".preview-text"));var t=$(this).attr("data-sort-value"),i=$(this).attr("data-sort-direction");l.isotope({sortBy:t,sortAscending:"asc"==i}),s.text($(this).text())}),t=[[767,6]],c=function(){for(var e=6,s=0;s<t.length;s++)if($(window).width()<=t[s][0]){e=t[s][1];break}return e}(),s=d=1,r="*",m="",h="data-page",u="pagination",i(),f(1),o.change(function(){var e=$(this).attr("data-filter");r=e,i(),f(1)}),$("#clear-filters").click(function(){l.isotope({filter:"*",sortBy:""}),$(".sortby .custom-dropdown-btn .preview-text").text($(".sortby .custom-dropdown-list li:first-child button").text()),o.each(function(e,s){s.checked&&(s.checked=null)}),r="*",i(),f(1)}))}function preventClick(){$("#gtranslate_selector").parents("a").removeAttr("href")}function loginRegister(){var e=window.location.href;"login"==(e=(e=e.split("/"))[e.length-2])&&$("#customer_login .u-column2").remove(),"register"==e&&$("#customer_login .u-column1").remove()}function fundingType(){$(".self_manage_funding_text").hide(),$(".plan-managed-funding-text").hide(),$(".ndia-managed-funding-text").hide(),$(".input-radio").each(function(){var s=$(this);s.change(function(){console.log("skdjf");var e=s.closest(".Attendee-group");s.is(":checked")&&"Self_managed"==s.val()?(e.find(".self_manage_funding_text").show(),e.find(".plan-managed-funding-text").hide(),e.find(".ndia-managed-funding-text").hide()):s.is(":checked")&&"Plan_managed"==s.val()?(e.find(".self_manage_funding_text").hide(),e.find(".plan-managed-funding-text").show(),e.find(".ndia-managed-funding-text").hide()):s.is(":checked")&&"Ndia_managed"==s.val()&&(e.find(".self_manage_funding_text").hide(),e.find(".plan-managed-funding-text").hide(),e.find(".ndia-managed-funding-text").show())})})}document.addEventListener("DOMContentLoaded",function(){bannerSlider(),customDropdown(),customCheckboxDropdown(),megamenu(),sidemenuToggle(),productsecSlider(),productNum(),customTabs(),customAccord(),accessibility(),isotopeInitv3(),preventClick(),loginRegister(),fundingType()}),win.on("resize",function(){}),AOS.init({once:!0});