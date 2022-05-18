var $ = jQuery;
var win = $(window);

'use strict';

document.addEventListener('DOMContentLoaded', function () {
    // call functions here
    bannerSlider()
    // custom dropdown
    customDropdown()
    // megamenu
    megamenu()
    // toggle sidemenu
    sidemenuToggle()

    productsecSlider()

    productNum()
});

//function called on window resize
win.on('resize', function () {});


/*****  Declare your functions here  ********/
AOS.init({
    once: true,
});

function bannerSlider() {
    const slider = $('.homebanner-slider'),
        sliderWrap = slider.parents('.homebanner-slider-wrap'),
        navWrap = sliderWrap.find('.homebanner-slider-navwrap'),
        $num = navWrap.find('.num');

    $('.homebanner-slider').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        adaptiveHeight: true,
        prevArrow: $('.slidenav-prev'),
        nextArrow: $('.slidenav-next'),
    }).on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
        let textBox = $(slick.$slides[currentSlide]).find('.text');
        if ($(window).width() > 991) {
            navWrap.css('top', textBox.height() + 31)
        }
        // console.log(textBox)
        // console.log(currentSlide)
        var i = (currentSlide ? currentSlide : 0) + 1;
        $num.html('<span>' + i + '</span>/' + slick.slideCount);
    });
}

function customDropdown() {
    $('.custom-dropdown').each(function () {
        const $this = $(this),
            btnObj = $this.find('.custom-dropdown-btn'),
            listObj = $this.find('.custom-dropdown-list');

        btnObj.click(function () {
            if ($this.hasClass('toggled')) {
                $this.removeClass('toggled');
                listObj.slideUp()
            } else {
                $this.addClass('toggled');
                listObj.slideDown()
            }
        })

        $(document).mouseup(function (e) {
            var container = $this;

            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                listObj.slideUp();
                $this.removeClass('toggled')
            }
        });
    })
}

function megamenu() {
    $('.megamenu').each(function () {
        const $this = $(this),
            parentList = $this.parents('li');

        parentList.addClass('has-megamenu');

        parentList.click(function (event) {
            event.preventDefault()
            if ($(this).hasClass('open')) {
                $(this).removeClass('open');
                $this.slideUp();
            } else {
                $(this).addClass('open');
                $this.slideDown();
            }
        })

        $(document).mouseup(function (e) {
            var container = parentList;

            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.removeClass('open');
                $this.slideUp()
            }
        });
    })
}

function sidemenuToggle() {
    $('.menu-toggle').click(function () {
        const $this = $(this),
            sideMenu = $('.sidemenu');

        if (sideMenu.hasClass('toggled')) {
            sideMenu.removeClass('toggled');
            $this.removeClass('menu-open');
            $('html').css('overflowY', '')
        } else {
            sideMenu.addClass('toggled')
            $this.addClass('menu-open')
            $('html').css('overflowY', 'hidden')
        }
    })
}

function productsecSlider() {
    $('.productsec--media').each(function () {
        const $this = $(this);

        const sliderPrimary = $this.find('.productsec--media-primary-slider'),
            primaryNavWrap = sliderPrimary.siblings('.slider-navwrap'),
            primaryNavPrev = primaryNavWrap.find('.slidenav-prev'),
            primaryNavNext = primaryNavWrap.find('.slidenav-next'),
            $num = primaryNavWrap.find('.num');

        const sliderSecondary = $this.find('.productsec--media-secondary-slider');

        // console.log(sliderSecondary)

        sliderPrimary.slick({
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            prevArrow: primaryNavPrev,
            nextArrow: primaryNavNext,
            asNavFor: sliderSecondary
        }).on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
            let textBox = $(slick.$slides[currentSlide]).find('.text');
            // if ($(window).width() > 991) {
            //     navWrap.css('top', textBox.height() + 31)
            // }
            var i = (currentSlide ? currentSlide : 0) + 1;
            $num.html('<span>' + i + '</span>/' + slick.slideCount);
        });

        sliderSecondary.slick({
            dots: false,
            nav: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            infinite: true,
            speed: 300,
            margin: 25,
            focusOnSelect: true,
            asNavFor: sliderPrimary
        });
    })
}

function productNum() {
    $('.product--num').each(function () {
        const minus = $(this).find('.product--num-minus'),
            plus = $(this).find('.product--num-plus'),
            inputObj = $(this).find('.product--num-input');

        let minVal = 1,
            maxVal = parseInt(inputObj.attr('max')),
            currentVal;

        if (!maxVal) {
            maxVal = 100
        }

        minus.click(function () {
            currentVal = parseInt(inputObj.val());

            if (currentVal <= 1) {
                inputObj.val('1')
            } else {
                inputObj.val(currentVal - 1)
            }
        })

        plus.click(function () {
            currentVal = parseInt(inputObj.val());

            if (currentVal >= maxVal) {
                inputObj.val(maxVal)
            } else {
                inputObj.val(currentVal + 1)
            }
        })

        console.log(currentVal)

    })
}