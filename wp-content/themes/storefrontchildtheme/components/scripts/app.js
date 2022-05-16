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
        navWrap.css('top', textBox.height() + 31)
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