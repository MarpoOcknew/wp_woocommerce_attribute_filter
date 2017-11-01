jQuery(document).ready(function() {
    jQuery("#mp_wc_filter_menu_filter option").css("display", "none");

    jQuery("#mp_wc_filter_menu_attribute").change(function() {
        var category = jQuery("#mp_wc_filter_menu_category").val();
        var option = jQuery(this).find("option:selected").val();

        jQuery("#mp_wc_filter_menu_filter option").each(function(){
            if(jQuery(this).hasClass(option)) {
                jQuery(this).css("display", "block");
            } else {
                jQuery(this).css("display", "none");
            }
        });
    });

    jQuery("#mp_wc_filter_menu_filter").change(function() {
        var category = jQuery("#mp_wc_filter_menu_category").val();
        var option = jQuery("#mp_wc_filter_menu_attribute").find("option:selected").val();

        var filter = jQuery(this).val();
        var title = jQuery(this).find("option:selected").html();

        const url = "/shop?product_cat="+category+"&filter_"+option+"="+filter;

        jQuery("#menu-item-title").val(title);
        jQuery("#menu-item-url").val(url);
    });
});
