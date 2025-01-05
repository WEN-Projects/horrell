(function ($) {
    $(document).ready(function () {
        // on change of properties categories(Property Type - taxonomy terms), reflect the changes to the ACF fields(Property Type)
        $('#taxonomy-property_categories input').on('change', function () {
            let selected_property_categories = $('#taxonomy-property_categories input:checked');
            let selected_value_arr = [];
            selected_property_categories.each(function () {
                let checkbox_value = $(this).val();
                switch (checkbox_value) {
                    case "163" :
                        selected_value_arr.push("industrial");
                        break;
                    case "3" :
                        selected_value_arr.push("land");
                        break;
                    case "5" :
                        selected_value_arr.push("retail");
                        break;
                    case "4" :
                        selected_value_arr.push("office");
                        break;
                    default:
                        break;
                }
            });
            $(('#acf-field_644b6d6f85d94')).val(selected_value_arr).trigger("change");
        });
        // on change of properties categories(Property Offer Type - taxonomy terms), reflect the changes to the ACF field(For)
        $('#taxonomy-property_sale_type input').on('change', function () {
            console.log('test');
            let property_sale_type = $('#taxonomy-property_sale_type input:checked');
            let selected_value_arr = [];
            property_sale_type.each(function () {
                let checkbox_value = $(this).val();
                switch (checkbox_value) {
                    case "9" :
                        selected_value_arr.push("lease");
                        break;
                    case "8" :
                        selected_value_arr.push("sale");
                        break;
                    default:
                        break;
                }
            });
            $(('#acf-field_644b6d4085d93')).val(selected_value_arr).trigger("change");
        });
        $('#property_sale_type-9 label input').on('change', function () {
            if ($(this).is(':checked')) {
                $('a[data-key="field_64490571ba9d1"]').trigger('click');
            }
        });
        $('#property_sale_type-8 label input').on('change', function () {
            if ($(this).is(':checked')) {
                $('a[data-key="field_644b553cba474"]').trigger('click');
            }
        });
    });
})(jQuery);