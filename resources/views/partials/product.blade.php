<!-- ROW PRODUCTS -->
<div class="row">
    <div class="col-sm-12">
        <div class="user-data m-b-30">
            <h3 class="title-3 m-b-30">
                <i class="fab fa-flickr"></i>Products

                <button class="au-btn au-btn-icon au-btn--green au-btn--small pull-right" data-toggle="modal" data-target="#addProductModal">
                    <i class="zmdi zmdi-plus"></i>add product
                </button>
            </h3>

            <div class="table-responsive table-data">
                <table id="products-table" data-classes="table table-hover" data-toggle="table" data-sortable="true" data-sort-class="table-active" data-pagination="true" data-page-size="5" data-url="{{ route('products') }}">
                    <thead>
                    <tr>
                        <th data-field="name" data-sortable="true">Name</th>
                        <th data-field="slt" data-sortable="true">SLT</th>
                        <th data-field="storage_t" data-sortable="true">Storage T (interval)</th>
                        <th data-field="description" data-sortable="true">Description</th>
                        <th data-field="id" data-formatter="btnFormatter"></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- modal add product -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <form id="addProductForm" action="{{ route('products.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal" _lpchecked="1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Add new product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col col-md-3 text-right">
                            <label for="product-input-name" class="form-control-label">Name *</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="product-input-name" name="product-input-name" placeholder="Fish Orada" class="form-control" required>
                            <input type="hidden" id="product-input-id" name="product-input-id">
                            @csrf
                            <small class="form-text text-muted">Insert a small name of product.</small>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3 text-right">
                            <label for="product-input-slt" class="form-control-label">SLT *</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="number" min="0" step="0.01" id="product-input-slt" name="product-input-slt" placeholder="13.56" class="form-control" required>
                            <small class="form-text text-muted">Insert a decimal number of product shell lifetime.</small>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3 text-right">
                            <label for="product-input-storage" class="form-control-label">Storage T *</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="product-input-storage" name="product-input-storage" placeholder="4-5" class="form-control" required>
                            <small class="form-text text-muted">Insert a interval of storage temparature in Celzium - min, max.</small>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3 text-right">
                            <label for="product-input-desc" class="form-control-label">Description</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <textarea name="product-input-desc" id="product-input-desc" rows="4" placeholder="Content..." class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-12">
                            <div class="alert alert-danger m-b-0 d-none" role="alert"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnCancelProductFrom" type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
                    <button id="btnSaveProductForm" type="submit" class="btn btn-success"><i class="fa fa-dot-circle-o"></i> Save</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- end modal add product -->


@section('scripts')
<script type="application/javascript" defer>

    var doAjax_params_default = {
        'url': null,
        'requestType': "POST",
        'contentType': 'application/json',
        'headers': { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },
        'dataType': 'json',
        'data': {},
        'beforeSendCallbackFunction': null,
        'successCallbackFunction': null,
        'completeCallbackFunction': null,
        'errorCallBackFunction': null
    };

    function doAjax(doAjax_params) {

        var url = doAjax_params['url'];
        var requestType = doAjax_params['requestType'];
        var contentType = doAjax_params['contentType'];
        var headers = doAjax_params['headers'];
        var dataType = doAjax_params['dataType'];
        var data = doAjax_params['data'];
        var beforeSendCallbackFunction = doAjax_params['beforeSendCallbackFunction'];
        var successCallbackFunction = doAjax_params['successCallbackFunction'];
        var completeCallbackFunction = doAjax_params['completeCallbackFunction'];
        var errorCallBackFunction = doAjax_params['errorCallBackFunction'];

        jQuery.ajax({
            url: url,
            type: requestType,
            contentType: contentType,
            processData: false,
            headers: headers,
            dataType: dataType,
            data: data,
            xhr: function(){
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        jQuery('.progress.header-progress .progress-bar').css({
                            width: percentComplete * 100 + '%'
                        });
                        if (percentComplete === 1) {
                            jQuery('.progress.header-progress .progress-bar').addClass('hide');
                        }
                    }
                }, false);
                xhr.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        jQuery('.progress.header-progress .progress-bar').css({
                            width: percentComplete * 100 + '%'
                        });
                    }
                }, false);
                return xhr;
            },
            beforeSend: function(jqXHR, settings) {
                if (typeof beforeSendCallbackFunction === "function") {
                    beforeSendCallbackFunction();
                }
            },
            success: function(data, textStatus, jqXHR) {
                if (typeof successCallbackFunction === "function") {
                    successCallbackFunction(data);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if (typeof errorCallBackFunction === "function") {
                    errorCallBackFunction(jqXHR);
                }

            },
            complete: function(jqXHR, textStatus) {
                if (typeof completeCallbackFunction === "function") {
                    completeCallbackFunction();
                }
            }
        });
    }

    function btnFormatter(value) {
        $html = '<div class="table-data-feature">';
            $html += '<button class="item btnItemEdit" data-toggle="tooltip" data-placement="top" title="Edit" data-original-title="Edit" data-product-id="' + value + '">';
                $html += '<i class="zmdi zmdi-edit"></i>';
            $html += '</button>';
            $html += '<button class="item btnItemDelete" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" data-product-id="' + value + '">';
                $html += '<i class="zmdi zmdi-delete"></i>';
            $html += '</button>';
        $html += '</div>';

        return $html;
    }

    jQuery( document ).ready( function( jQuery ) {

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
                storage_t: jQuery('#product-input-storage').val()
            };

            if(id != '') tempData.id = id;

            params['url'] = "{{ route('products.store') }}";
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
                    jQuery("body").animate({ scrollTop: 0 }, "slow");
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
        jQuery("body").on('click', "button.btnItemDelete", function(){
            var id = jQuery(this).data("product-id");
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
                    jQuery("body").animate({ scrollTop: 0 }, "slow");
                    jQuery('#products-table').bootstrapTable('refresh');
                    console.log(data);
                }
            };
            params['errorCallBackFunction'] = function( jqXHR ){
                // todo error print
                jQuery('#settingsAlertBox .alert').text(jqXHR.responseText);
                jQuery('#settingsAlertBox .alert').removeClass('d-none');
                console.log(jqXHR);
            };
            doAjax(params);
        });

        // EDIT PRODUCT
        jQuery("body").on('click', "button.btnItemEdit", function(){
            jQuery('#addProductModal').modal('toggle');
            jQuery('#addProductModal .modal-title').text('Edit product');

            var id = jQuery(this).data("product-id");
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
                    jQuery('#product-input-id').val(id);
                    jQuery('#product-input-name').val(data.details.name);
                    jQuery('#product-input-slt').val(data.details.slt);
                    jQuery('#product-input-desc').val(data.details.description);
                    jQuery('#product-input-storage').val(data.details.storage_t);
                }
            };
            params['errorCallBackFunction'] = function( jqXHR ){
                // todo error print
                jQuery('#settingsAlertBox .alert').text(jqXHR.responseText);
                jQuery('#settingsAlertBox .alert').removeClass('d-none');
                console.log(jqXHR);
            };
            doAjax(params);
        });


    });
</script>
@endsection