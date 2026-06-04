if ($(".tf-swiper").length > 0) {
    $(".tf-swiper").each(function () {
        var $swiper = $(this);

        var spacing = Number($swiper.data("space-between")) || 0;
        var preview = Number($swiper.data("preview")) || 1;
        var tablet = Number($swiper.data("tablet")) || 1;
        var desktop = Number($swiper.data("desktop")) || 1;

        var direction = $swiper.data("direction") || "horizontal";
        var effect = $swiper.data("effect") || "slide";

        var reverse = $swiper.data("reverse") === true;

        var cardsOffset = Number($swiper.data("cards-offset")) || 8;
        var cardsRotate = Number($swiper.data("cards-rotate")) || 0;

        new Swiper(this, {
            slidesPerView: preview,
            loop: false,
            spaceBetween: spacing,
            direction: direction,
            effect: effect,

            touchRatio: (direction === "vertical" && reverse) ? -1 : 1,

            observer: true,
            observeParents: true,

            pagination: {
                el: $swiper.find(".swiper-pagination")[0],
                clickable: true,
            },

            fadeEffect: {
                crossFade: true,
            },

            cubeEffect: {
                shadow: false,
            },

            coverflowEffect: {
                rotate: 30,
                stretch: 0,
                depth: 120,
                modifier: 1,
                slideShadows: false,
            },

            flipEffect: {
                slideShadows: false,
            },

            cardsEffect: {
                perSlideOffset: cardsOffset,
                perSlideRotate: cardsRotate,
                slideShadows: false,
            },

            breakpoints: {
                768: {
                    slidesPerView: tablet,
                },
                1024: {
                    slidesPerView: desktop,
                },
            },
        });
    });
}



if ($(".tf-swiper2").length > 0) {
    var spacing = $(".tf-swiper2").data("space-between");
    var preview = $(".tf-swiper2").data("preview");
    var tablet = $(".tf-swiper2").data("tablet");
    var desktop = $(".tf-swiper2").data("desktop");
    var initial_slide = $(".tf-swiper2").data("initial-slide");
    var swiper4 = new Swiper(".tf-swiper2", {
        speed: 1500,
        initialSlide: initial_slide,
        slidesPerView: preview,
        loop: false,
        spaceBetween: spacing,
        observer: true,
        observeParents: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            1024: {
                slidesPerView: desktop,
            },
            768: {
                slidesPerView: tablet,
            },
        },
    });
}
