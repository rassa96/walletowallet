/*
 * Back Page
 * show pass
 * otp input
 * selectImages
 * fillterCheck
 * favoriteActive
 * clear text
 * tab slide
 * datePicker
 * changeValue
 * uploadFlie
 * Modal Second
 * optionLink
 * preloader
 */
(function ($) {
    "use strict";

    /* Back Page
     ------------------------------------------------------------------------------------- */
    var backPage = function () {
        $(".back-btn").on("click", function (e) {
            e.stopPropagation();
            e.preventDefault();
            window.history.go(-1);
        });
    };

    /* show pass
    ------------------------------------------------------------------------------------- */
    var showPass = function () {
        $(".show-pass1").on("click", function () {
            $(this).toggleClass("active");
            if ($(".password-field1").attr("type") == "password") {
                $(".password-field1").attr("type", "text");
            } else if ($(".password-field1").attr("type") == "text") {
                $(".password-field1").attr("type", "password");
            }
        });
        $(".show-pass2").on("click", function () {
            $(this).toggleClass("active");
            if ($(".password-field2").attr("type") == "password") {
                $(".password-field2").attr("type", "text");
            } else if ($(".password-field2").attr("type") == "text") {
                $(".password-field2").attr("type", "password");
            }
        });
    };

    /* otp input
    ------------------------------------------------------------------------------------- */
    var otpInput = function () {
        if ($(".digit-group").length > 0) {
            $(".digit-group")
                .find("input")
                .each(function () {
                    $(this).attr("maxlength", 1);
                    $(this).on("keyup", function (e) {
                        var valNum = $(this).val();
                        var parent = $($(this).parent());

                        if (e.keyCode === 8 || e.keyCode === 37) {
                            var prev = parent.find("input#" + $(this).data("previous"));

                            if (prev.length) {
                                $(prev).select();
                            }
                        } else if (
                            (e.keyCode >= 48 && e.keyCode <= 57) ||
                            (e.keyCode >= 65 && e.keyCode <= 90) ||
                            (e.keyCode >= 96 && e.keyCode <= 105) ||
                            e.keyCode === 39
                        ) {
                            var next = parent.find("input#" + $(this).data("next"));
                            if (!$.isNumeric(valNum)) {
                                $(this).val("");
                                return false;
                            }

                            if (next.length) {
                                $(next).select();
                            } else {
                                if (parent.data("autosubmit")) {
                                    parent.submit();
                                }
                            }
                        }
                    });
                });
        }
    };

    /* selectImages
    ------------------------------------------------------------------------------------- */
    var selectImages = function () {
        if ($(".image-select").length > 0) {
            const selectIMG = $(".image-select");

            selectIMG.find("option").each((idx, elem) => {
                const selectOption = $(elem);
                const imgURL = selectOption.attr("data-thumbnail");
                if (imgURL) {
                    selectOption.attr(
                        "data-content",
                        `<img src="${imgURL}" /> ${selectOption.text()}`
                    );
                }
            });
            selectIMG.selectpicker();
        }
    };

    /* fillterCheck
    ------------------------------------------------------------------------------------- */
    var fillterCheck = function () {
        $(".btn-fillter-active").on("click", function () {
            $(".fillter-item").hide();
            $(".fillter-item").filter(".fillter-active").show();
        });

        $(".btn-all").on("click", function () {
            $(".fillter-item").show();
        });

    };

    /* clear text
    ------------------------------------------------------------------------------------- */
    var clearInput = function () {
        $(".delect-btn").on("click", function () {
            $(".clear-ip").val("");
        });
    };

    /* tab slide 
    ------------------------------------------------------------------------------------- */

    var tabSlide = function () {
        $(".tab-slide").each(function () {

            var $wrap = $(this);
            var $items = $wrap.find("li");
            var $effect = $wrap.find(".item-slide-effect");

            function update($el) {
                $effect.css({
                    width: $el.outerWidth(),
                    transform: "translateX(" + $el.position().left + "px)"
                });
            }

            function waitForVisible(callback) {
                function check() {
                    if ($wrap.is(":visible") && $wrap.outerWidth() > 0) {
                        callback();
                    } else {
                        requestAnimationFrame(check);
                    }
                }
                check();
            }

            waitForVisible(function () {
                var $active = $items.filter(".active");
                if (!$active.length) $active = $items.first().addClass("active");
                update($active);
            });

            $items.on("click", function () {
                $items.removeClass("active");
                $(this).addClass("active");
                update($(this));
            });

            $(window).on("resize", function () {
                update($items.filter(".active"));
            });
        });
    };

    /* datePicker 
    ------------------------------------------------------------------------------------- */

    var datePicker = function () {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        if ($("#datepicker1").length > 0) {
            $("#datepicker1").datepicker({
                firstDay: 1,
                dateFormat: "dd/mm/yy",
                autoclose: true,
            });
        }
        if ($("#datepicker2").length > 0) {
            $("#datepicker2").datepicker({
                firstDay: 1,
                dateFormat: "dd/mm/yy",
            });
        }
        if ($("#datepicker3").length > 0) {
            $("#datepicker3").datepicker({
                firstDay: 1,
                dateFormat: "dd/mm/yy",
            });
        }
    };

    /* favoriteActive
    ------------------------------------------------------------------------------------- */

    var favoriteActive = function () {
        var $btnAll = $(".btn-all");
        var $btnFilter = $(".btn-fillter-active");
        var $items = $(".list-fillter-item .profile-contact");

        var showFavorites = function () {
            $items.hide();
            $items.filter(".fillter-active").show();
        };

        var showAll = function () {
            $items.show();
        };

        $btnAll.on("click", function (e) {
            e.preventDefault();
            $btnAll.addClass("active");
            $btnFilter.removeClass("active");
            showAll();
        });

        $btnFilter.on("click", function (e) {
            e.preventDefault();
            $btnFilter.addClass("active");
            $btnAll.removeClass("active");
            showFavorites();
        });

        if ($btnFilter.hasClass("active")) {
            showFavorites();
        } else {
            showAll();
        }

        $(".favorite-btn").on("click", function (e) {
            e.preventDefault();
            $(this).closest(".profile-contact").toggleClass("fillter-active");
        });

        $('.tf-btn-add-ticket').on('click', function (e) {
            e.preventDefault();
            $('.list-btn-ticket').toggleClass('active');
        });
    };

    /* changeValue
    ------------------------------------------------------------------------------------- */

    var changeValue = function () {
        $(".tag-money").on("click", function () {
            var val = $(this).text();
            var str = val.slice(1);
            $(".value_input").val(str);
        });
    };

    /* uploadFlie
    ------------------------------------------------------------------------------------- */

    var uploadFlie = function () {
        $(".btn-update").on("click", function (e) {
            document.getElementById("file-input").click();
        });
        if ($("#file-input").length) {
            document
                .getElementById("file-input")
                .addEventListener("change", function (event) {
                    var file = event.target.files[0];
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        var imgElement = document.getElementById("profile-img");
                        if (imgElement) {
                            imgElement.src = e.target.result;
                        }
                        var filename = document.getElementById("name-file");
                        if (filename) {
                            filename.textContent = file.name;
                        }
                    };

                    if (file) {
                        reader.readAsDataURL(file);
                    }
                });
        }
    };


    /* Modal Second
    ------------------------------------------------------------------------------------- */
    var clickModalSecond = function () {
        $(".btn-choose-page").click(function () {
            $("#modalPage").modal("show");
        });
        $(".btn-choose-component").click(function () {
            $("#modalComponent").modal("show");
        });
    };

    /* optionLink
    ------------------------------------------------------------------------------------- */

    var optionLink = function () {
        $(".option-link").on("click", function (e) {
            e.stopPropagation();
            e.preventDefault();
            window.location.href = $(this).data("url");
        });
    };

    /* handleProgress
    ------------------------------------------------------------------------------------- */

    var handleProgress = function () {
        $(".progress").each(function () {
            var progressValue = $(this).find(".value").data("progress");
            if (progressValue !== undefined) {
                $(this)
                    .find(".value")
                    .css("width", progressValue + "%");
            }
        });
        if ($(".modal-shopping-cart").length > 0) {
            $(".modal-shopping-cart").on("hide.bs.modal", function () {
                $(".tf-progress-bar .value").css("width", "0%");
            });
            $(".modal-shopping-cart").on("show.bs.modal", function () {
                setTimeout(function () {
                    var progressValue = $(".tf-progress-bar .value").data("progress");
                    $(".tf-progress-bar .value").css("width", progressValue + "%");
                }, 600);
            });
        }
    };

    /* changeVerifyAction
    ------------------------------------------------------------------------------------- */

    var changeVerifyAction = function () {
        $('input[name="proof-item"]').on('change', function (e) {
            var $form = $('#verify-form');
            var action = $(this).data('action');

            if (!action) return;

            $form.attr('action', action);
        });
    };

    /* amountSpinner
    ------------------------------------------------------------------------------------- */

    var amountSpinner = function () {
        var input = document.querySelector(".amount");
        var upBtn = document.querySelector(".amount-up");
        var downBtn = document.querySelector(".amount-down");

        if (!input || !upBtn || !downBtn) return;

        var step = 100;
        var min = 0;
        var currency = "USD";

        var parseMoney = function (value) {
            return Number(value.replace(/[^0-9.-]+/g, ""));
        };

        var formatMoney = function (value) {
            return value.toLocaleString("en-US", {
                style: "currency",
                currency: currency
            });
        };

        upBtn.onclick = function () {
            var current = parseMoney(input.value);
            current += step;
            input.value = formatMoney(current);
        };

        downBtn.onclick = function () {
            var current = parseMoney(input.value);
            current = Math.max(min, current - step);
            input.value = formatMoney(current);
        };
    };

    /* handleMessage
    ------------------------------------------------------------------------------------- */

    var handleMessage = function () {
        $(".btn-message").on("click", function () {
            var ipMessage = $(".val-message");
            var messValue = ipMessage.val();
            var currentTime = new Date();
            var hours = currentTime.getHours() >= 12 ? "PM" : "AM";
            var realTime =
                (currentTime.getHours() % 12) +
                ":" +
                currentTime.getMinutes() +
                " " +
                hours;

            var domMessage =
                '<div class="bubble bubble-me box-buble-me">' +
                '<div class="content">' +
                '<span class="time text-small">' +
                realTime +
                "</span>" +
                '<p class="text-item text-medium">' +
                messValue +
                "</p>" +
                "</div>" +
                "</div>";

            if (messValue.length > 0) {
                $(".chat-area").append(domMessage);
            }
            window.scrollTo(0, document.body.scrollHeight);
            ipMessage.val("");
        });
        $(".val-message").on("keydown", function (e) {
            if (e.key === "Enter" && !e.shiftKey) {
                e.preventDefault();
                $(".btn-message").click();
            }
        });

    };

    /* preloader 
    ------------------------------------------------------------------------------------- */
    var preloader = function () {
        setTimeout(function () {
            $(".preload").fadeOut("slow", function () {
                $(this).remove();
            });
        }, 500);
    };

    $(function () {
        backPage();
        showPass();
        otpInput();
        selectImages();
        fillterCheck();
        clearInput();
        tabSlide();
        datePicker();
        favoriteActive();
        changeValue();
        uploadFlie();
        clickModalSecond();
        optionLink();
        handleProgress();
        changeVerifyAction();
        amountSpinner();
        handleMessage();
        preloader();
    });
})(jQuery);
