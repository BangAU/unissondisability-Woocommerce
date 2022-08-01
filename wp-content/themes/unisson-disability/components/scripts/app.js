var $ = jQuery;
var win = $(window);

("use strict");

document.addEventListener("DOMContentLoaded", function () {
  // call functions here
  bannerSlider();
  // custom dropdown
  customDropdown();
  customCheckboxDropdown();
  // megamenu
  megamenu();
  // toggle sidemenu
  sidemenuToggle();

  productsecSlider();

  productNum();

  customTabs();

  customAccord();

  accessibility();

  // isotopeInitv3()

  preventClick();

  // dataGridInit()

  attendeeCheckbox();

  filterScroll();

  fundingType();

  splitAccount();
});

//function called on window resize
win.on("resize", function () {});

/*****  Declare your functions here  ********/
AOS.init({
  once: true,
});

function bannerSlider() {
  const slider = $(".homebanner-slider"),
    sliderWrap = slider.parents(".homebanner-slider-wrap"),
    navWrap = sliderWrap.find(".homebanner-slider-navwrap"),
    $num = navWrap.find(".num");

  slider.on(
    "init reInit beforeChange",
    function (event, slick, currentSlide, nextSlide) {
      let textBox = $(slick.$slides[nextSlide]).find(".text");
      if ($(window).width() > 991) {
        navWrap.css("top", textBox.height() + 31);
      }

      // console.log('Text Box', textBox)
      // console.log('Current Slide', currentSlide)
      // console.log('Next Slide', nextSlide)

      var i = (nextSlide ? nextSlide : 0) + 1;
      $num.html("<span>" + i + "</span>/" + slick.slideCount);
    }
  );

  slider.slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    adaptiveHeight: true,
    prevArrow: $(".slidenav-prev"),
    nextArrow: $(".slidenav-next"),
  });
}

function customDropdown() {
  $(".custom-dropdown").each(function () {
    const $this = $(this),
      btnObj = $this.find(".custom-dropdown-btn").eq(0),
      listObj = $this.find(".custom-dropdown-list").eq(0);

    btnObj.click(function () {
      if ($this.hasClass("toggled")) {
        listObj.slideUp("fast", function () {
          $this.removeClass("toggled");
        });
      } else {
        $this.addClass("toggled");
        listObj.slideDown();
      }
    });

    $(document).mouseup(function (e) {
      var container = $this;

      // if the target of the click isn't the container nor a descendant of the container
      if (!container.is(e.target) && container.has(e.target).length === 0) {
        listObj.slideUp();
        $this.removeClass("toggled");
      }
    });
  });
}

function customCheckboxDropdown() {
  $(".checkbox-dropdown").each(function () {
    const $this = $(this),
      btnObj = $this.find(".checkbox-dropdown-btn").eq(0),
      btnCheckbox = btnObj.find("input"),
      listObj = $this.find(".checkbox-dropdown-list").eq(0),
      childCheckbox = listObj.find("input");

    if (!listObj.length) {
      $this.addClass("no-list");
      return;
    }

    if (btnCheckbox.is(":checked")) {
      $this.addClass("open");
      listObj.slideDown();
    } else {
      $this.removeClass("open");
      listObj.slideUp();
      childCheckbox.prop("checked", false);
    }

    btnObj.click(function () {
      console.log("btn obj clicked");
      if (btnCheckbox.is(":checked")) {
        $this.addClass("open");
        listObj.slideDown();
        childCheckbox.prop("checked", true);
      } else {
        $this.removeClass("open");
        listObj.slideUp();
        childCheckbox.prop("checked", false);
      }
    });

    // btnObj.click(function () {
    //     if ($this.hasClass('toggled')) {
    //         listObj.slideUp('fast', function () {
    //             $this.removeClass('toggled');
    //         })
    //     } else {
    //         $this.addClass('toggled');
    //         listObj.slideDown()
    //     }
    // })

    // $(document).mouseup(function (e) {
    //     var container = $this;

    //     // if the target of the click isn't the container nor a descendant of the container
    //     if (!container.is(e.target) && container.has(e.target).length === 0) {
    //         listObj.slideUp();
    //         $this.removeClass('toggled')
    //     }
    // });
  });
}

function megamenu() {
  $(".megamenu").each(function () {
    const $this = $(this),
      parentList = $this.parents("li"),
      parentListLink = parentList.children("a");

    parentList.addClass("has-megamenu");

    if ($(window).width() > 991) {
      parentList.click(function (event) {
        event.preventDefault();
        if ($(this).hasClass("open")) {
          $(this).removeClass("open");
          $this.slideUp();
        } else {
          $(this).addClass("open");
          $this.slideDown();
        }
      });
    } else {
      parentListLink.click(function (event) {
        event.preventDefault();
        if ($(this).hasClass("open")) {
          $(this).removeClass("open");
          $this.slideUp();
        } else {
          $(this).addClass("open");
          $this.slideDown();
        }
      });
    }

    $(document).mouseup(function (e) {
      var container = parentList;

      // if the target of the click isn't the container nor a descendant of the container
      if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.removeClass("open");
        $this.slideUp();
      }
    });
  });
}

function sidemenuToggle() {
  $(".menu-toggle").click(function () {
    const $this = $(this),
      sideMenu = $(".sidemenu");

    if (sideMenu.hasClass("toggled")) {
      sideMenu.removeClass("toggled");
      $this.removeClass("menu-open");
      $("html").css("overflowY", "");
    } else {
      sideMenu.addClass("toggled");
      $this.addClass("menu-open");
      $("html").css("overflowY", "hidden");
    }
  });
}

function productsecSlider() {
  $(".productsec--media").each(function () {
    const $this = $(this);

    const primarySlider = $this.find(".productsec--media-primary-slider"),
      primaryNavWrap = primarySlider.siblings(".slider-navwrap"),
      primaryNavPrev = primaryNavWrap.find(".slidenav-prev"),
      primaryNavNext = primaryNavWrap.find(".slidenav-next"),
      $primaryNum = primaryNavWrap.find(".num");

    const secondarySlider = $this.find(".productsec--media-secondary-slider"),
      secondaryNavWrap = secondarySlider.siblings(".slider-navwrap"),
      secondaryNavPrev = secondaryNavWrap.find(".slidenav-prev"),
      secondaryNavNext = secondaryNavWrap.find(".slidenav-next"),
      $secondaryNum = secondaryNavWrap.find(".num");

    let maximumSecondarySlides = 3;

    // console.log('Slider Secondary:', secondarySlider)
    // console.log('Secondary Nav Wrap:', secondaryNavWrap)
    // console.log('Secondary Nav Prev:', secondaryNavPrev)
    // console.log('Secondary Nav Next:', secondaryNavNext)
    // console.log('Num:', $num)

    primarySlider.on(
      "init reInit afterChange",
      function (event, slick, currentSlide, prevSlide) {
        if (slick.$slides.length < maximumSecondarySlides) {
          // primaryNavPrev.hide()
          // primaryNavNext.hide()
          primarySlider.addClass("less-slides");
        }

        // console.log('currentSlide', currentSlide);
        // console.log('prevSlide', prevSlide);

        var i = (currentSlide ? currentSlide : 0) + 1;
        $primaryNum.html("<span>" + i + "</span>/" + slick.slideCount);
      }
    );

    secondarySlider.on(
      "init reInit afterChange",
      function (event, slick, currentSlide, prevSlide) {
        if (slick.$slides.length < maximumSecondarySlides) {
          // secondaryNavPrev.hide()
          // secondaryNavNext.hide()
          secondarySlider.addClass("less-slides");
        }

        // console.log('currentSlide', currentSlide);
        // console.log('prevSlide', prevSlide);

        var i = (currentSlide ? currentSlide : 0) + 1;
        $secondaryNum.html("<span>" + i + "</span>/" + slick.slideCount);
      }
    );

    primarySlider.slick({
      dots: false,
      // loop: true,
      infinite: false,
      speed: 300,
      slidesToShow: 1,
      // draggable: false,
      prevArrow: primaryNavPrev,
      nextArrow: primaryNavNext,
      asNavFor: secondarySlider,
    });

    secondarySlider.slick({
      dots: false,
      nav: false,
      // loop: true,
      infinite: false,
      slidesToShow: maximumSecondarySlides,
      slidesToScroll: 1,
      speed: 300,
      margin: 25,
      focusOnSelect: true,
      // centerMode: true,
      prevArrow: secondaryNavPrev,
      nextArrow: secondaryNavNext,
      asNavFor: primarySlider,
    });
  });
}

function productNum() {
  $(".product--num").each(function () {
    const minus = $(this).find(".product--num-minus"),
      plus = $(this).find(".product--num-plus"),
      inputObj = $(this).find(".product--num-input");

    let minVal = 1,
      maxVal = parseInt(inputObj.attr("max")),
      currentVal;

    if (!maxVal) {
      maxVal = 100;
    }

    minus.click(function () {
      currentVal = parseInt(inputObj.val());

      if (currentVal <= 1) {
        inputObj.val("1");
      } else {
        inputObj.val(currentVal - 1);
      }
    });

    plus.click(function () {
      currentVal = parseInt(inputObj.val());

      if (currentVal >= maxVal) {
        inputObj.val(maxVal);
      } else {
        inputObj.val(currentVal + 1);
      }
    });

    // console.log(currentVal)
  });
}

function customTabs() {
  $(".customtab").each(function () {
    $(this).find(".customtab--nav-list li").removeClass("active");
    $(this).find(".customtab--nav-list li:first-child").addClass("active");

    $(this)
      .find(".customtab--content .customtab--content-item")
      .removeClass("active");
    $(this)
      .find(".customtab--content .customtab--content-item:first-child")
      .addClass("active");
  });

  $(".customtab--nav-list li").click(function (event) {
    event.preventDefault();

    const targetID = $(this).find("a").attr("href"),
      parentList = $(this),
      parentSiblings = parentList.siblings(),
      targetBody = $('.customtab--content-item[data-id="' + targetID + '"]');

    if (parentList.hasClass("active")) {
      return;
    }

    if ($(window).width() < 992) {
      $(this)
        .parents(".customtab--nav")
        .find(".customtab--nav-preview .customtab--nav-active")
        .text($(this).text());
      $(this)
        .parents(".customtab--nav")
        .find(".customtab--nav-list")
        .slideUp(function () {
          $(this)
            .parents(".customtab--nav")
            .find(".customtab--nav-preview")
            .removeClass("open");
          $(this)
            .parents(".customtab--nav")
            .find(".customtab--nav-list")
            .removeClass("open");
        });
    }

    parentSiblings.removeClass("active");
    targetBody.siblings().slideUp(function () {
      targetBody.siblings().removeClass("active");
    });

    parentList.addClass("active");
    targetBody.slideDown(function () {
      targetBody.addClass("active");
    });

    console.log(targetID);
    console.log($('.customtab--content-item[data-id="' + targetID + '"]'));
  });

  $(".customtab--nav-preview").click(function () {
    const navLists = $(this).siblings(".customtab--nav-list");

    if ($(this).hasClass("open")) {
      $(this).removeClass("open");
      navLists.slideUp(function () {
        navLists.removeClass("open");
      });
    } else {
      $(this).addClass("open");
      navLists.slideDown(function () {
        navLists.addClass("open");
      });
    }
  });

  $(document).mouseup(function (e) {
    var container = $(".customtab--nav-list");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) {
      container.removeClass("open");
      container.siblings(".customtab--nav-preview").removeClass("open");
    }
  });
}

function customAccord() {
  $(".customaccord--item-header").click(function () {
    const $this = $(this),
      parentObj = $(this).parents(".customaccord--item"),
      bodyObj = $(this).siblings(".customaccord--item-body"),
      siblingItems = parentObj.siblings(),
      otherBodyObjs = siblingItems.find(".customaccord--item-body");

    if (parentObj.hasClass("active")) {
      bodyObj.slideUp(function () {
        parentObj.removeClass("active");
      });
    } else {
      otherBodyObjs.slideUp(function () {
        siblingItems.removeClass("active");
        bodyObj.slideDown(function () {
          parentObj.addClass("active");
        });
        $("html, body").animate(
          {
            scrollTop: $this.offset().top - 60,
          },
          200
        );
      });
    }
  });
}

function accessibility() {
  $(".accessibility-row li").click(function () {
    setTimeout(function () {
      $(".slick-slider")[0].slick.refresh();
      $(".programfilter-listing").isotope("reloadItems").isotope();
    }, 150);
  });

  // function to hide/show the accesssibility menu when clicking on the button
  // $('.button-accessibility').click(function (ev) {
  //     ev.preventDefault();
  //     if (!$(this).hasClass('clicked')) {
  //         $(this).addClass('clicked');
  //         $(this).closest('.accessibility-bar').find('.accessibility-list').fadeIn(200);
  //     } else {
  //         $(this).removeClass('clicked');
  //         $(this).closest('.accessibility-bar').find('.accessibility-list').fadeOut(200);
  //     }
  // });

  // new logic to change the font size for accessibility
  $(".accessibility-row .smaller-text").addClass("min");
  $(".accessibility-row .larger-text").click(function (ev) {
    ev.preventDefault();
    var fontCheck = 0;
    var fontSize = parseInt($("html").css("font-size"));
    // console.log(fontSize);
    if (fontSize < 13) {
      fontCheck = fontSize + 1;
      $.cookie("font-size", fontCheck);
      fontSize = fontSize + 1 + "px";
      $("html").css("font-size", fontSize);
      $(".accessibility-row .smaller-text").removeClass("min");
      // if conditions to be applied when it reaches the largest font size
      if (fontCheck == 11) {
        $(this).parent("li").removeClass(" smallest medium large");
        $(this).parent("li").addClass(" smallest");
        $(this).addClass("enabled");
      } else if (fontCheck == 12) {
        $(this).parent("li").removeClass(" smallest medium large");
        $(this).parent("li").addClass(" medium");
        $(this).addClass("enabled");
      } else if (fontCheck == 13) {
        $(this).parent("li").removeClass(" smallest medium large");
        $(this).parent("li").addClass("large");
        // add disabled class to gray out in css
        $(this).addClass("max enabled");
      }
    }
  });

  $(".accessibility-row .smaller-text").click(function (ev) {
    ev.preventDefault();
    var fontCheck = 0;
    var fontSize = parseInt($("html").css("font-size"));
    console.log(fontSize);
    if (fontSize > 10) {
      fontCheck = fontSize - 1;
      $.cookie("font-size", fontCheck);
      fontSize = fontSize - 1 + "px";
      $("html").css("font-size", fontSize);
      $(".accessibility-row .larger-text").removeClass("max");
      // if conditions to be applied when it reaches the least font size
      if (fontCheck == 12) {
        $(".accessibility-row .larger-text")
          .parent("li")
          .removeClass(" smallest medium large");
        $(".accessibility-row .larger-text").parent("li").addClass(" medium");
        $(".accessibility-row .larger-text").addClass("enabled");
      } else if (fontCheck == 11) {
        $(".accessibility-row .larger-text")
          .parent("li")
          .removeClass(" smallest medium large");
        $(".accessibility-row .larger-text").parent("li").addClass(" smallest");
        $(".accessibility-row .larger-text").addClass("enabled");
      } else if (fontCheck == 10) {
        // add disabled class to gray out in css
        $(this).addClass("min");
        $(".accessibility-row .larger-text")
          .parent("li")
          .removeClass(" smallest medium large");
        $(".accessibility-row .larger-text").removeClass("enabled");
      }
    }
  });

  $(".accessibility-row .dyslexic-font").click(function (ev) {
    ev.preventDefault();
    if ($(this).hasClass("enabled")) {
      $.cookie("dyslexic-font", 0);
      $("body").removeClass("font-dyslexic");
      $(this).removeClass("enabled");
    } else {
      $.cookie("dyslexic-font", 1);
      $("body").addClass("font-dyslexic");
      $(this).addClass("enabled");
    }
  });

  $(".accessibility-row .high-contrast a").click(function (ev) {
    ev.preventDefault();
    if ($(this).hasClass("enabled")) {
      $.cookie("high-contrast", 0);
      $("body").removeClass("high-contrast");
      $(this).removeClass("enabled");
    } else {
      $.cookie("high-contrast", 1);
      $("body").addClass("high-contrast");
      $(this).addClass("enabled");
    }
  });

  if (!!$.cookie("high-contrast")) {
    var hc = $.cookie("high-contrast");
    if (hc == 1) {
      $("body").addClass("high-contrast");
      $(".accessibility-row.high-contrast a").addClass("enabled");
    } else {
      $("body").removeClass("high-contrast");
      $(".accessibility-row.high-contrast a").removeClass("enabled");
    }
  }

  if (!!$.cookie("dyslexic-font")) {
    var df = $.cookie("dyslexic-font");
    if (df == 1) {
      $("body").addClass("font-dyslexic");
      $(".accessibility-row .dyslexic-font").addClass("enabled");
    } else {
      $("body").removeClass("font-dyslexic");
      $(".accessibility-row .dyslexic-font").removeClass("enabled");
    }
  }

  if (!!$.cookie("font-size")) {
    $(".accessibility-row .smaller-text").removeClass("min");
    $(".accessibility-row .larger-text").removeClass("max");
    var fs = $.cookie("font-size");
    if (fs <= 13 && fs >= 10) {
      fspx = fs + "px";
      $("html").css("font-size", fspx);
      // if conditions to be applied when it reaches the largest font size
      if (fs == 13) {
        // add disabled class to gray out in css
        $(".accessibility-row .larger-text").addClass("max enabled");
        $(".accessibility-row .larger-text").parent("li").addClass("large");
      }
      if (fs == 12) {
        $(".accessibility-row .larger-text").addClass("enabled");
        $(".accessibility-row .larger-text").parent("li").addClass("medium");
      }
      if (fs == 11) {
        $(".accessibility-row .larger-text").addClass("enabled");
        $(".accessibility-row .larger-text").parent("li").addClass("smallest");
      }
      if (fs == 10) {
        // add disabled class to gray out in css
        $(".accessibility-row .smaller-text").addClass("min");
      }
    }
  }

  //reset all the accessibility options including the cookies
  $(".accessibility-reset .btn-reset").click(function (ev) {
    ev.preventDefault();
    console.log("reset pressed");
    $(".accessibility-row li").removeClass();
    $(".accessibility-row .smaller-text").removeClass("min");
    $(".accessibility-row .smaller-text").addClass("min");
    $(".accessibility-row .larger-text").removeClass(
      "smallest medium large enabled max"
    );
    $(".accessibility-row .dyslexic-font").removeClass("enabled disabled");
    $(".accessibility-row.high-contrast a").removeClass("enabled disabled");
    $("body").removeClass("high-contrast font-dyslexic");
    $("html").css("font-size", "10px");
    //reset all of the cookies
    $.cookie("high-contrast", 0);
    $.cookie("dyslexic-font", 0);
    $.cookie("font-size", "10");
    //reset google translate
    // $('#\\:1\\.container').contents().find('#\\:1\\.restore').click();
  });
}

function attendeeCheckbox() {
  $(".order-pages .Attendee-group .funding-type-radio").each(function (index) {
    const radio = $(this).find('input[type="radio"]');
    console.log(radio);
    radio.prop("name", radio.attr("name") + index);
  });
}

function preventClick() {
  $("#gtranslate_selector").parents("a").removeAttr("href");
}

function dataGridInit() {
  datagrid({
    currentPage: 0,
    pageSize: 6,
    pagesRange: 4,
    // deepLink: true
  });

  // $('.homefilter .pagination').click(function () {
  //     $('html, body').animate({
  //         scrollTop: $('.homefilter').offset().top
  //     }, 1000)
  // })

  $("#clear-filters").click(function () {
    // $('.homefilter-selects input').prop('checked', false);
    $(".sortby select").prop("selectedIndex", 0);
    $(".homefilter-selects input:checked").trigger("click");
  });
}

function filterScroll() {
  if ($(".homefilter").length > 0) {
    if (window.location.href.indexOf("page/") > -1) {
      $("html, body").animate(
        {
          scrollTop: $(".homefilter").offset().top - 60,
        },
        200
      );
    }
  }
}

function splitAccount() {
  var url = window.location.href;
  url = url.split("/");
  url = url[url.length - 2];
  if (url == "login") {
    $("#customer_login .u-column2").remove(); //Remove Registration Div
  }
  if (url == "register") {
    $("#customer_login .u-column1").remove(); // Remove Login Div
  }
}

function fundingType() {
  $(".self_manage_funding_text").hide();
  $(".plan-managed-funding-text").hide();
  $(".ndia-managed-funding-text").hide();

  $(".input-radio").each(function () {
    var $that = $(this);
    $that.change(function () {
      console.log("skdjf");
      var $closest = $that.closest(".Attendee-group");
      if ($that.is(":checked") && $that.val() == "Self_managed") {
        $closest.find(".self_manage_funding_text").show();
        $closest.find(".plan-managed-funding-text").hide();
        $closest.find(".ndia-managed-funding-text").hide();
      } else if ($that.is(":checked") && $that.val() == "Plan_managed") {
        $closest.find(".self_manage_funding_text").hide();
        $closest.find(".plan-managed-funding-text").show();
        $closest.find(".ndia-managed-funding-text").hide();
      }
      // FINISH FROM HERE
      else if ($that.is(":checked") && $that.val() == "Ndia_managed") {
        $closest.find(".self_manage_funding_text").hide();
        $closest.find(".plan-managed-funding-text").hide();
        $closest.find(".ndia-managed-funding-text").show();
      }
    });
  });
}
