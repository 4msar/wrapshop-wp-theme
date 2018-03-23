jQuery(document).ready(function($){
	$(document).ready(function(){
        // Get the form fields and hidden div
        var checkbox = $("#_customize-input-product_category");
        var hidden = $("#customize-control-shop_categories_in_shoppage");
        hidden.hide();

        checkbox.change(function() {
            if (checkbox.is(':checked')) {
            hidden.show();
//            alert('Show');
            } else {
            hidden.hide();
            }
        });
        if (checkbox.is(':checked')) {
        hidden.show();
//            alert('Show');
        } else {
        hidden.hide();
        }
    });
});