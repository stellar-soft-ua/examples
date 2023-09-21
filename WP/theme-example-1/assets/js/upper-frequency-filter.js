(function upperFilter($) {
    const taxes = [];
    let is_used = false;
    $(document).ready(function () {
        const post_type = $('#post_type').data('type');
        const product_category_name = $('#product_category_name').val();
        const impedance = $('#impedance').val();
        const data = {
            post_type: post_type,
            impedance: impedance,
            showIds: false
        };
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {"action": "load-upperfilter", term: data},
            success: function (response) {
                $(".products__list.load-more").html(response);
                bindEvents();
                // hidePrice();
                $("#loading-animation").hide();
                return false;
            }
        });

        $('.table-collapse').click(function (e) {
            e.preventDefault();
            if ($('.table-border').hasClass('expanded-table')) {
                $('.table-border').removeClass('expanded-table');
                $('.table-border').addClass('collapsed-table');
                $('.table-collapse').addClass('rotated-arrow');
            } else {
                $('.table-border').removeClass('collapsed-table');
                $('.table-border').addClass('expanded-table');
                $('.table-collapse').removeClass('rotated-arrow');
            }
        });

        $('.upperfilter__checkbox').click(function (e) {
            const clicked_element = $(this).prev()[0];
            $(this).toggleClass('checked');
            if ($('.upperfilter__table').find('.checked')[0] !== undefined) {
                const data = {
                    number_of_ports: clicked_element.getAttribute("data-port"),
                    upper_frequency: clicked_element.getAttribute("data-frequency"),
                    ext_type: clicked_element.getAttribute("data-ext-type"),
                    ext_variation: clicked_element.getAttribute("data-ext-variation"),
                    product_type: clicked_element.getAttribute("data-product-type"),
                    impedance: $('#impedance').val(),
                    itemId: clicked_element.getAttribute("id"),
                    showIds: true,
                    post_type: post_type,
                    product_category_name: product_category_name
                };
                getData(data);
            } else {
                const data = {
                    post_type: post_type,
                    showIds: false,
                    impedance: impedance
                };
                getAllProducts(data);
                is_used = false;
            }
        });

        $('.reset-btn').click(function (e) {
            e.preventDefault();
            const data = {
                post_type: post_type,
                showIds: false,
                impedance: impedance
            };
            resetProducts(data);
            is_used = false;
            $(".upperfilter__col input").prop("checked", false);
            $(".upperfilter__checkbox").removeClass("checked");
            $(".upper-tax-filter").prop("checked", false);

        });

        $('.upper-tax-filter').click(function (event) {
            const selecetd_taxonomy = $(this).attr('name');
            if ($(this).prop("checked")) {
                taxes.push(selecetd_taxonomy);
            } else {
                for (let i = taxes.length - 1; i >= 0; i--) {
                    if (taxes[i] === selecetd_taxonomy) {
                        taxes.splice(i, 1);
                    }
                }
            }
            checkProduct();
        });

        function getData(data) {
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {"action": "load-upperfilter", term: data},
                success: function (response) {
                    if (is_used) {
                        if ($('.products__list').find('#' + data.itemId)[0] !== undefined) {
                            $('.products__list').find('#' + data.itemId).remove();
                        } else {
                            $(".products__list.load-more").append(response);
                            var seen = {};
                            $('.products__list .product-preview').each(function() {
                                var txt = $(this).find('.product-preview__title').text();
                                if (seen[txt])
                                    $(this).remove();
                                else
                                    seen[txt] = true;
                            });
                        }
                    } else {
                        $(".products__list.load-more").html(response);
                        is_used = true;
                    }
                    bindEvents();
                    // hidePrice();
                    checkProduct();
                    checkReachTheEnd();
                    $("#loading-animation").hide();
                    return false;
                }
            });
        }

        function getAllProducts(data) {
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {"action": "load-upperfilter", term: data},
                success: function (response) {
                    $(".products__list.load-more").html(response);
                    bindEvents();
                    // hidePrice();
                    checkProduct();
                    $("#loading-animation").hide();
                    return false;
                }
            });
        }

        function resetProducts(data) {
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {"action": "load-upperfilter", term: data},
                success: function (response) {
                    $(".products__list.load-more").html(response);
                    bindEvents();
                    // hidePrice();
                    $("#loading-animation").hide();
                    return false;
                }
            });
        }

        window.onbeforeunload = function () {
            $(".upperfilter__col input").prop("checked", false);
            $(".upper-tax-filter").prop("checked", false);
        };

        function checkProduct() {
            $('.product-preview').hide();
            $('.product-preview').each(function () {
                const tax = $(this)[0].getAttribute("data-taxonomy");
                for (var i = 0; i < taxes.length; i++) {
                    if (tax.indexOf(taxes[i]) >= 0) {
                        $(this).show();
                    }
                }
            });
            if (taxes.length === 0) {
                $('.product-preview').show();
            }
        }

        function checkReachTheEnd() {
            if ($('.ias-noneleft').length > 0) {
                const end_container = $('.ias-noneleft').detach();
                $(".products__list.load-more").append(end_container);
            }
        }
    });
})(jQuery);
