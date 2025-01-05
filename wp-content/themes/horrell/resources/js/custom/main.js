/**
 * Main JS File
 *
 * cspell: ignore horrell ptype
 */
(function ($) {
    var COMMON = {
        init: function () {
            this.cacheDOM();

            $(window).on("resize", this.reCalcOnResize.bind(this));
        },
        cacheDOM: function () {
            this.$body = $("body");
            this.windowWidth = $(window).width();
        },
        reCalcOnResize: function () {
            this.windowWidth = $(window).width();
        },
    };

    var mainNavigation = {
        //script for main navigation customization
        init: function () {
            this.$mainNavContainer = $("#site-navigation");
            this.$menuToggler = this.$mainNavContainer.find(".menu-toggle");
            this.$mainMenuContainer = this.$mainNavContainer.find(
                ".menu-main-menu-container"
            );
            this.$mainMenu = this.$mainNavContainer.find("#primary-menu");
            this.$menuToggler.on("click", this.toggleMenu.bind(this));
            // this.dropdownMenu();
        },
        toggleMenu: function (e) {
            // e.preventDefault();
            $("body").toggleClass("menu-opened");
            this.$mainMenuContainer.slideToggle();
            this.$mainMenuContainer.find(".sub-menu").slideUp();
        },
    };

    var slickSlider = {
        // initiation of slick slider
        init: function () {
            this.bannerSlider();
            this.propertyImageSlider();
        },
        bannerSlider: function () {
            $(".banner-img-slider").slick({
                infinite: true,
                dots: false,
                arrows: false,
            });
        },
        propertyImageSlider: function () {
            $(".property-image-slider").slick({
                infinite: true,
                dots: true,
                arrows: true,
            });
        },
    };

    var sortForm = function () {
        //sort by form customization (property listing page)
        var sortType = $(".sort-form #p_type"); // either sale or lease
        sortType.on("change", function () {
            // based on change in select type, show/hide options in "select sort option"
            var sortVal = $(this).val();
            if (sortVal == 0) return;
            if (sortVal === "lease") {
                $("#sorting-lease").removeClass("disabled").show();
                $("#sorting-sale").hide();
            }
            if (sortVal === "sale") {
                $("#sorting-sale").removeClass("disabled").show();
                $("#sorting-lease").hide();
            }
        });
    };

    var advancedSearch = function () {
        // handler script for advanced search form
        // Pop up Open
        $(".form-popup-btn > a").on("click", function (e) {
            e.preventDefault();
            $(".advanced-search-popup").addClass("opened");
            $("body").addClass("overflow-hidden");
        });

        //popup close
        $(".advanced-search-popup .close-btn").on("click", function (e) {
            e.preventDefault();
            $(".advanced-search-popup").removeClass("opened");
            $("body").removeClass("overflow-hidden");
        });

        // Toggle Sale or Lease Type
        $('.sale-lease-selector input[name="p_offer_type"]').on(
            "change",
            function () {
                // on change of tab "for sale" or "for lease", show/hide certain fields
                var type = $(this).val();
                if (type === "lease") {
                    $(".lease-keyword, .min-rental,.max-rental").show();
                    $(".min-sale, .max-sale").hide();
                } else {
                    $(".lease-keyword, .min-rental,.max-rental").hide();
                    $(".min-sale, .max-sale").show();
                }
            }
        );

        // Close advanced search form if "esc" key is pressed
        $(document).on("keydown", function (e) {
            if (e.keyCode != 27) return;
            e.preventDefault();
            $(".advanced-search-popup").removeClass("opened");
            $("body").removeClass("overflow-hidden");
        });
    };

    //Save Listing icon Toggle
    var saveListingIconToggle = function () {
        $("body").on("click", ".save-listing-btn", function (e) {
            //on click of save listing icon, add the property to saved listings using ajax
            e.preventDefault();
            let property_id = $(this).attr("id");
            let current_element = $(this);
            $.ajax({
                type: "post",
                dataType: "json",
                url: horrell_obj.ajax_url,
                data: {
                    property_id: property_id,
                    action: "save_listing",
                    nonce: horrell_obj.nonce_ajax,
                },
                success: function (response) {
                    if (
                        response &&
                        response.saved_listing &&
                        response.saved_listing == true
                    ) {
                        if (current_element.hasClass("no-reload")) {
                            current_element.toggleClass("saved");
                            if (response.saved_status == 0) {
                                current_element
                                    .children("span")
                                    .html("Save Listing");
                            } else {
                                current_element
                                    .children("span")
                                    .html("Listing Saved");
                            }
                        } else {
                            location.reload();
                        }
                        $(".underlined span").html(response.list_count); // update saved listing count in header
                    }
                },
            });
        });
    };

    //Remove border from last page number
    var pagination = function () {
        var pageNumberWrapper = $(".pagination-wrapper");
        var pageNumbers = $(".pagination-wrapper .page-numbers");
        if (pageNumbers.length == 0) {
            pageNumberWrapper.css("margin", "0");
            pageNumberWrapper.children().hide();
        }
        pageNumbers.each(function (i) {
            if ($(this).hasClass("next")) {
                $(this).prev().css("border", "none");
            }
        });
    };

    //smooth scroll
    var smoothScroll = function () {
        // set scroll position  to 0 if url has hash
        if (window.location.hash) {
            scroll(0, 0);
            setTimeout(function () {
                scroll(0, 0);
            }, 1);
        }
        $('a[href*="#"]:not([href="#"])').on("click", function (e) {
            if (
                location.pathname.replace(/^\//, "") ==
                this.pathname.replace(/^\//, "") &&
                location.hostname == this.hostname
            ) {
                e.preventDefault();
                var elementToScroll = $(this.hash);
                if ($(elementToScroll).length == 0) return;
                var elementOffset = $(elementToScroll).offset().top;
                $("html,body").animate(
                    {
                        scrollTop: elementOffset,
                    },
                    1000
                );
            }
        });

        if (window.location.hash) {
            $("html,body").animate(
                {
                    scrollTop: $(window.location.hash).offset().top,
                },
                1000
            );
        }
    };

    var stickyPropertiesHeader = function () {
        const tableHeader = $('.table-header');
        if (!tableHeader.length) {
            return;
        }

        let scrollTop = $(window).scrollTop();
        let offsetTop = tableHeader.offset().top;
        let headerWidth = $('.properties-list .item-list').innerWidth();
        let headerHeight = tableHeader.innerHeight();

        $(window).on('resize', () => {
            offsetTop = tableHeader.offset().top;
            headerWidth = $('.properties-list .item-list').innerWidth()
            tableHeader.css('width', headerWidth + 'px');

            if (window.innerWidth <= 1180) {
                tableHeader.css('left', (-1 * $('.properties-listing').scrollLeft() + 'px'));
            } else {
                tableHeader.css('left', 'auto');
            }
        })

        $(window).on('scroll', () => {
            scrollTop = $(window).scrollTop();
            if (scrollTop > offsetTop) {
                tableHeader.css({
                    'width': headerWidth + 'px',
                    'position': 'fixed',
                    'top': '0'
                });
                tableHeader.parent().css('padding-top', headerHeight + 'px');
            } else {
                tableHeader.removeAttr('style');
                tableHeader.parent().css('padding-top', 0);
            }
        })


        $('.properties-listing').on('scroll', () => {
            if (window.innerWidth <= 1180) {
                tableHeader.css('left', (-1 * $('.properties-listing').scrollLeft() + 'px'));
            } else {
                tableHeader.css('left', 'auto');

            }
        })
    }

    $(function () {
        COMMON.init();
        mainNavigation.init();
        slickSlider.init();
        sortForm();
        advancedSearch();
        saveListingIconToggle();
        pagination();
        smoothScroll();
        stickyPropertiesHeader();
    });
})(jQuery);

//scripts to be run when document is ready
jQuery(document).ready(function ($) {
    if (!$("#related-properties").length) {
        // In property/space detail page, hide the related properties link if the property do not have any related properties.
        $(".related-property-btn.related-properties-link").hide();
    }
    /*
    (open)
     property listings : jquery scripts
    */
    let current_page = 2; // content for the first page is already loaded, thus set 2.
    var is_property_loading = false; // Flag to prevent multiple requests
    let data = {
        action: "load_properties_by_ajax",
        nonce: horrell_obj.nonce_ajax,
        limits: 10, // number of posts to be loaded on ajax call.
        offset: 10, // offset to be set 10, index [0-9] has already loaded in first page.
        ptype: "", // by default set property type as empty
        get_params: horrell_obj.get_params, // collect all the parameters from the URL (in case of advanced search and sorting, the search/sorting parameters are already set so, fetch all those parameters from the URL)
    };
    $(window).on("scroll", function (e) {
        //ajax to be run on click of load more button (properties listing page)
        if (!$("body").hasClass("post-type-archive")) {
            // return if it is not property archive page
            return;
        }
        e.preventDefault(); // preventing from submitting.
        if (is_property_loading) return; // Don't load more if a request is already in progress
        is_property_loading = true;
        $(".properties-listing .ajax-loader").show(); // show the loading icon until the response is received
        let searchParams = new URLSearchParams(window.location.search);
        if (searchParams.has("offset")) {
            // since the offset parameter changes in every request(without loading the page), we must get offset using JS rather than using PHP
            data.offset = searchParams.get("offset"); // offset for the next ajax request
            current_page = parseInt(data.offset / 10) + 1; // current page to be set dynamically based on offset parameter in URL.
        }
        if (searchParams.has("ptype")) {
            data.ptype = searchParams.get("ptype");
        }
        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: horrell_obj.ajax_url,
            data: data,
            success: function (response) {
                if (
                    response &&
                    response.content &&
                    !jQuery.isEmptyObject(response.content)
                ) {
                    // on ajax responses, change the content and handle accordingly.
                    $(".properties-listing .properties-list").append(
                        response.content
                    ); // append the newly fetched listings to the bottom.
                    current_page += 1; // change current page for pagination. after success the change the page number by 1.
                    let offset =
                        (parseInt(current_page) - 1) * parseInt(data.limits); // set the offset accordingly.
                    const url = new URL(window.location);
                    url.searchParams.set("offset", offset); //change the offset value in the URL parameter
                    window.history.pushState({}, "", url);
                    $(".ajax-loader").hide();
                    if (response.is_last) {
                        // if the response has fetched the last page of the pagination, hide the load more button.
                        $(".properties-listing .load-more-btn").hide();
                    }
                    is_property_loading = false;
                }
            },
        });
    });

    let sort_value = $('select[name="p_offer_type"]').val(); // after the document has loaded, hide show specific option in "Sort By" form.
    if (sort_value === "lease") {
        $("#sorting-lease").removeClass("disabled").show();
        $("#sorting-sale").hide();
    } else if (sort_value === "sale") {
        $("#sorting-sale").removeClass("disabled").show();
        $("#sorting-lease").hide();
    } else {
        $("#sale").hide();
    }
    /*
   (close)
    property listings : jquery scripts
   */

    /*
    (open)
     saved listing page : jquery scripts
    */

    $(".pdf-download").on("click", function () {
        //function to download the merged PDFs in saved listing page
        $("#download-pdf-form").trigger("submit");
    });

    $("form.saved-listing-email-form").validate({
        //add the validation rules to send email form, (saved listings)
        rules: {
            verify_captcha: {
                equalTo: "#generated_captcha",
            },
        },
        messages: {
            verify_captcha: {
                equalTo: "Please enter the same value again.",
            },
        },
    });

    $("form.saved-listing-email-form").on("submit", function (e) {
        e.preventDefault();
        if (!$(this).valid()) return false; // if form validation is false, do stop the process
        $.ajax({
            type: "post",
            dataType: "json",
            url: horrell_obj.ajax_url,
            data: {
                action: "save_listing_send_mail",
                nonce: horrell_obj.nonce_ajax,
                form_data: $(this).serialize(),
            },
            success: function (response) {
                if (typeof response.status != "undefined" && response.status) {
                    //on success status, show the popup regarding success message
                    $("#sent_email_message").html(response.message);
                    $("#emailModal").modal("hide");
                    $("#messageModal").modal("show");
                    $("form.saved-listing-email-form").trigger("reset");
                } else {
                    $("#sent_email_message").html(
                        "Failed to send the Email. Please try again!"
                    ); //on failure status, show the popup regarding failure message
                    $("#emailModal").modal("hide");
                    $("#messageModal").modal("show");
                }
            },
            error: function (xhr, status, error) {
                $("#sent_email_message").html(
                    "Failed to send the Email. Please try again!"
                );
            },
        });
    });
    $("form.saved-listing-email-form #clear_form").on("click", function (e) {
        // functionality to reset form
        e.preventDefault();
        $("form.saved-listing-email-form").trigger("reset");
    });

    let selected_p_offer_type = getURLParameter("p_offer_type");
    if (
        typeof selected_p_offer_type != "undefined" &&
        selected_p_offer_type == "lease"
    ) {
        //if selected_p_offer_type is lease trigger the change in advanced search form, to hide sales related fields
        $("input[name='p_offer_type']").trigger("change");
    }

    window.addEventListener("load", function () {
        // on submission of the advanced search form, filter out the fields that are empty.
        let forms = $("form.advanced-search-form");
        for (let form of forms) {
            form.addEventListener("formdata", function (event) {
                let formData = event.formData;
                for (let [name, value] of Array.from(formData.entries())) {
                    if (value === "") formData.delete(name);
                }
            });
        }
    });

    let selected_sort_type = getURLParameter("p_offer_type");
    if (
        typeof selected_sort_type != "undefined" &&
        (selected_sort_type == "lease" || selected_sort_type == "sale")
    ) {
        $(".sort-form #p_type").trigger("change"); //if sorting parameter is already set trigger the change in select field(p_type)
    }

    $(".sort-form").on("submit", function (e) {
        // on sorting form submit, filter out the specific fields.
        let sort_type = $(".sort-form select[name='p_offer_type']").val();
        if (
            typeof sort_type === "undefined" ||
            (sort_type !== "lease" && sort_type !== "sale")
        )
            return false;
        sort_type == "lease"
            ? $("#sorting-sale").remove() //if sort by lease, remove elements(inputs) associated to sale
            : $("#sorting-lease").remove(); //if sort by sale, remove elements(inputs) associated to lease
        return true;
    });

    function getURLParameter(sParam) {
        //function to return the GET parameter from the URL
        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split("&");
        for (var i = 0; i < sURLVariables.length; i++) {
            var sParameterName = sURLVariables[i].split("=");
            if (sParameterName[0] == sParam) {
                return sParameterName[1];
            }
        }
    }

    $("form.advanced-search-form").on("submit", function (e) {
        // form validation for the advanced search form
        let min_sale_price = parseInt(
            $('form.advanced-search-form input[name="min_sale_price"]').val()
        );
        let max_sale_price = parseInt(
            $('form.advanced-search-form input[name="max_sale_price"]').val()
        );
        if (!isNaN(min_sale_price) && !isNaN(max_sale_price)) {
            if (max_sale_price <= min_sale_price) {
                alert("Max Sale Price must be higher than Min Sale Price.");
                return false;
            }
        }
        let min_rental_price = parseInt(
            $('form.advanced-search-form input[name="min_rental_price"]').val()
        );
        let max_rental_price = parseInt(
            $('form.advanced-search-form input[name="max_rental_price"]').val()
        );
        if (!isNaN(min_rental_price) && !isNaN(max_rental_price)) {
            if (max_rental_price <= min_rental_price) {
                alert("Max Rental Price must be higher than Min Rental Price.");
                return false;
            }
        }
        let min_space_area = parseInt(
            $('form.advanced-search-form input[name="min_space_area"]').val()
        );
        let max_space_area = parseInt(
            $('form.advanced-search-form input[name="max_space_area"]').val()
        );
        if (!isNaN(min_space_area) && !isNaN(max_space_area)) {
            if (max_space_area <= min_space_area) {
                alert("Max Sq Ft must be higher than Min Sq ft.");
                return false;
            }
        }
        let min_lot_size = parseFloat(
            $('form.advanced-search-form input[name="min_lot_size"]').val()
        );
        let max_lot_size = parseFloat(
            $('form.advanced-search-form input[name="max_lot_size"]').val()
        );
        if (!isNaN(min_lot_size) && !isNaN(max_lot_size)) {
            if (max_lot_size <= min_lot_size) {
                alert("Max Acreage must be higher than Min Acreage Price.");
                return false;
            }
        }

        let p_offer_type = $(
            "input[type='radio'][name='p_offer_type']:checked"
        ).val();

        if (p_offer_type == "lease") {
            //if lease parameters are set, remove the fields relevant to sales.
            $('input[name="max_sale_price"]').remove();
            $('input[name="min_sale_price"]').remove();
        } else {
            //if sale parameters are set, remove the fields relevant to sales.
            $('input[name="max_rental_price"]').remove();
            $('input[name="min_rental_price"]').remove();
        }
        return true;
    });

    $("select#property_layout_view").on("change", function () {
        let view_option = $(this).val();
        if ("list" == view_option) {
            $("section.properties-listing .container div.properties-list")
                .addClass("layout-list")
                .removeClass("layout-grid")
                .trigger("change");
            $('.grid-sort-form').hide();
            $(".layout-sort-form input[name='layout_view']").val('list');
        } else {
            $("section.properties-listing .container div.properties-list")
                .addClass("layout-grid")
                .removeClass("layout-list")
                .trigger("change");
            $('.grid-sort-form').show();
            $(".layout-sort-form input[name='layout_view']").val('grid');
        }
        const url = new URL(window.location);
        url.searchParams.set("layout_view", view_option); //change the offset value in the URL parameter
        url.searchParams.delete("sort_by"); //remove the parameter sort_by from URL
        // url.searchParams.delete("p_offer_type"); //remove the parameter p_offer_type from URL
        window.location.href = url;
        // window.history.pushState({}, "", url);
    });
    /*
    (close)
    saved listing page
    */


    let sort_form = $('.layout-list .table-header form');
    $('input[type=radio][name=sort_by][class=list-view-sort]').on('change', function () {
        let sortby = $(this).val();
        if (typeof (sortby) != 'undefined') { // in order to show the corresponding sorting options, when switching from list to grid.
            if ('sale_price asc' == sortby || 'sale_price desc' == sortby) {
                $(this).append('<input type="hidden" name="p_offer_type" value="sale">');
            }
            if ('actual_rental_rate asc' == sortby || 'actual_rental_rate desc' == sortby) {
                $(this).append('<input type="hidden" name="p_offer_type" value="lease">');
            }
        }
        $('.layout-list .table-header form').submit();
    });
    const table = $('.properties-list .table-header');
    const dropdowns = table.find('.has-dropdown');

    // Toggle Dropdown.
    dropdowns.on('click', function () {
        $(this).toggleClass('active');
        dropdowns.not(this).removeClass('active');
    });

    // Toggle Checked Class for label.
    dropdowns.each(function () {
        const dropdown = $(this);
        const inputs = dropdown.find('input');
        inputs.on('change', function () {
            inputs.parent().removeClass('checked');
            if ($(this).is(':checked')) {
                $(this).parent().addClass('checked');
            }
        })
    });
});
