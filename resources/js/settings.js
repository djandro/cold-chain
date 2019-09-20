/**
 * Created by sixnqq on 4. 09. 2019.
 */

jQuery( document ).ready( function( jQuery ) {

    // P R O D U C T S
    jQuery('#addProductModal').on('hidden.bs.modal', function (e) {
        jQuery('#addProductModal .modal-title').text('Add new product');
        jQuery("#addProductForm").trigger('reset');
        jQuery('#product-input-id').val('');
    });

    // ADD PRODUCT
    jQuery('#addProductForm').on('submit', function(e) {
        e.preventDefault();
        jQuery('.progress.header-progress .progress-bar').removeAttr('style');
        var id = jQuery('#product-input-id').val();
        var params = jQuery.extend({}, doAjax_params_default);

        var tempData = {
            name: jQuery('#product-input-name').val(),
            slt: jQuery('#product-input-slt').val(),
            description: jQuery('#product-input-desc').val(),
            storage_t_min: jQuery('#product-input-storage-min').val(),
            storage_t_max: jQuery('#product-input-storage-max').val()
        };

        if(id != '') tempData.id = id;

        params['url'] = "/api/products/store";
        params['data'] = JSON.stringify(tempData);

        params['successCallbackFunction'] = function( data ) {
            if (data.fail) {
                // todo print failed data
                console.log(data.fail);
            }
            else if(data.status == '200'){
                // print success
                jQuery("#btnCancelProductFrom").trigger('click');
                jQuery("#addProductForm").trigger('reset');
                jQuery('#product-input-id').val('');
                jQuery('#successBoxAlert .successText').text("You successfully save data with ID " + data.details.id);
                jQuery("#successBoxAlert").removeClass('d-none').addClass('show');
                jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                jQuery('#products-table').bootstrapTable('refresh');
                console.log(data);
            }
        };
        params['errorCallBackFunction'] = function( jqXHR ){
            // todo error print
            jQuery('#addProductForm .alert').text(jqXHR.responseText);
            jQuery('#addProductForm .alert').removeClass('d-none');
            console.log(jqXHR);
        };
        doAjax(params);
    });

    // DELETE PRODUCT
    jQuery("#productsBox").on('click', "button.btnItemDelete", function(){
        var id = jQuery(this).data("item-id");
        console.log(jQuery(this));
        var params = jQuery.extend({}, doAjax_params_default);
        params['url'] = "/api/products/delete/"+id;
        params['requestType'] = 'DELETE';
        params['data'] = JSON.stringify({
            "id": id
        });
        params['successCallbackFunction'] = function( data ) {
            if (data.fail) {
                // todo print failed data
                console.log(data.fail);
            }
            else if(data.status == '200'){
                // print success
                jQuery('#successBoxAlert .successText').text("You successfully delete data with ID " + data.id);
                jQuery("#successBoxAlert").removeClass('d-none').addClass('show');
                jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                jQuery('#products-table').bootstrapTable('refresh');
                console.log(data);
            }
        };
        params['errorCallBackFunction'] = function( jqXHR ){
            // todo error print
            jQuery('#errorAlertBox').text(jqXHR.responseText);
            jQuery('#errorAlertBox').removeClass('d-none');
            console.log(jqXHR);
        };
        doAjax(params);
    });

    // EDIT PRODUCT
    jQuery("#productsBox").on('click', "button.btnItemEdit", function(){
        jQuery('#addProductModal').modal('toggle');
        jQuery('#addProductModal .modal-title').text('Edit product');

        var id = jQuery(this).data("item-id");
        var params = jQuery.extend({}, doAjax_params_default);

        params['url'] = "/api/products/edit/"+id;
        params['requestType'] = "GET";
        params['successCallbackFunction'] = function( data ) {
            if (data.fail) {
                // todo print failed data
                console.log(data.fail);
            }
            else if(data.status == '200'){
                // print success
                var storage_t = data.details.storage_t.split(';');
                jQuery('#product-input-id').val(id);
                jQuery('#product-input-name').val(data.details.name);
                jQuery('#product-input-slt').val(data.details.slt);
                jQuery('#product-input-desc').val(data.details.description);
                jQuery('#product-input-storage-min').val(storage_t[0]);
                jQuery('#product-input-storage-max').val(storage_t[1]);
            }
        };
        params['errorCallBackFunction'] = function( jqXHR ){
            // todo error print
            jQuery('#errorAlertBox').text(jqXHR.responseText);
            jQuery('#errorAlertBox').removeClass('d-none');
            console.log(jqXHR);
        };
        doAjax(params);
    });

    // L O C A T I O N S
    jQuery('#addLocationModal').on('hidden.bs.modal', function (e) {
        jQuery('#addProductModal .modal-title').text('Add new location');
        jQuery("#addLocationForm").trigger('reset');
        jQuery('#location-input-id').val('');
    });

    // ADD Location
    jQuery('#addLocationForm').on('submit', function(e) {
        e.preventDefault();
        jQuery('.progress.header-progress .progress-bar').removeAttr('style');
        var id = jQuery('#location-input-id').val();
        var params = jQuery.extend({}, doAjax_params_default);

        var tempData = {
            name: jQuery('#location-input-name').val(),
            color: jQuery('#location-input-color').val(),
            description: jQuery('#location-input-desc').val(),
            t_alert_min: jQuery('#location-input-t_alert_min').val(),
            t_alert_max: jQuery('#location-input-t_alert_max').val()
        };

        if(id != '') tempData.id = id;

        params['url'] = "/api/locations/store";
        params['data'] = JSON.stringify(tempData);

        params['successCallbackFunction'] = function( data ) {
            if (data.fail) {
                // todo print failed data
                console.log(data.fail);
            }
            else if(data.status == '200'){
                // print success
                jQuery("#btnCancelLocationFrom").trigger('click');
                jQuery("#addLocationForm").trigger('reset');
                jQuery('#location-input-id').val('');
                jQuery('#successBoxAlert .successText').text("You successfully save data with ID " + data.details.id);
                jQuery("#successBoxAlert").removeClass('d-none').addClass('show');
                jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                jQuery('#locations-table').bootstrapTable('refresh');
                console.log(data);
            }
        };
        params['errorCallBackFunction'] = function( jqXHR ){
            // todo error print
            jQuery('#addLocationForm .alert').text(jqXHR.responseText);
            jQuery('#addLocationForm .alert').removeClass('d-none');
            console.log(jqXHR);
        };
        doAjax(params);
    });

    // DELETE LOCATION
    jQuery("#locationsBox").on('click', "button.btnItemDelete", function(){
        var id = jQuery(this).data("item-id");
        console.log(jQuery(this));
        var params = jQuery.extend({}, doAjax_params_default);
        params['url'] = "/api/locations/delete/"+id;
        params['requestType'] = 'DELETE';
        params['data'] = JSON.stringify({
            "id": id
        });
        params['successCallbackFunction'] = function( data ) {
            if (data.fail) {
                // todo print failed data
                console.log(data.fail);
            }
            else if(data.status == '200'){
                // print success
                jQuery('#successBoxAlert .successText').text("You successfully delete data with ID " + data.id);
                jQuery("#successBoxAlert").removeClass('d-none').addClass('show');
                jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                jQuery('#locations-table').bootstrapTable('refresh');
                console.log(data);
            }
        };
        params['errorCallBackFunction'] = function( jqXHR ){
            // todo error print
            jQuery('#errorAlertBox').text(jqXHR.responseText);
            jQuery('#errorAlertBox').removeClass('d-none');
            console.log(jqXHR);
        };
        doAjax(params);
    });

    // EDIT LOCATION
    jQuery("#locationsBox").on('click', "button.btnItemEdit", function(){
        jQuery('#addLocationModal').modal('toggle');
        jQuery('#addLocationModal .modal-title').text('Edit location');

        var id = jQuery(this).data("item-id");
        var params = jQuery.extend({}, doAjax_params_default);

        params['url'] = "/api/locations/edit/"+id;
        params['requestType'] = "GET";
        params['successCallbackFunction'] = function( data ) {
            if (data.fail) {
                // todo print failed data
                console.log(data.fail);
            }
            else if(data.status == '200'){
                // print success
                var storage_t = data.details.storage_t.split(';');
                jQuery('#location-input-id').val(id);
                jQuery('#location-input-name').val(data.details.name);
                jQuery('#location-input-desc').val(data.details.description);
                jQuery('#location-input-color').val(data.details.color);
                jQuery('#location-input-t_alert_min').val(storage_t[0]);
                jQuery('#location-input-t_alert_max').val(storage_t[1]);
            }
        };
        params['errorCallBackFunction'] = function( jqXHR ){
            // todo error print
            jQuery('#errorAlertBox').text(jqXHR.responseText);
            jQuery('#errorAlertBox').removeClass('d-none');
            console.log(jqXHR);
        };
        doAjax(params);
    });
});