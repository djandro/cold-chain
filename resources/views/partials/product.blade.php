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

            <div class="sufee-alert alert with-close alert-success alert-dismissible fade d-none" id="successBoxAlert">
                <span class="badge badge-pill badge-success">Success</span>
                You successfully save product data with ID {ID}.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>

            <div class="table-responsive table-data">
                <table id="products-table" data-classes="table table-hover" data-toggle="table" data-sortable="true" data-sort-class="table-active" data-pagination="true" data-url="{{ route('products') }}">
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
    <form id="addProductForm" action="{{ route('products') }}" method="post" enctype="multipart/form-data" class="form-horizontal" _lpchecked="1">
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
                            <label for="product-input-name" class="form-control-label">Name</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="product-input-name" name="product-input-name" placeholder="Fish Orada" class="form-control">
                            @csrf
                            <small class="form-text text-muted">Insert a small name of product.</small>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3 text-right">
                            <label for="product-input-slt" class="form-control-label">SLT</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="number" min="0" id="product-input-slt" name="product-input-slt" placeholder="13.56" class="form-control">
                            <small class="form-text text-muted">Insert a decimal number of product shell lifetime.</small>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3 text-right">
                            <label for="product-input-storage" class="form-control-label">Storage T</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="product-input-storage" name="product-input-storage" placeholder="4-5" class="form-control">
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

    function btnFormatter(value) {
        $html = '<div class="table-data-feature">';
            $html += '<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" data-product-id="' + value + '">';
                $html += '<i class="zmdi zmdi-edit"></i>';
            $html += '</button>';
            $html += '<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" data-product-id="' + value + '">';
                $html += '<i class="zmdi zmdi-delete"></i>';
            $html += '</button>';
        $html += '</div>';

        return $html;
    }

    jQuery( document ).ready( function( jQuery ) {
        jQuery('#products-table').bootstrapTable({
            //todo
        });

        jQuery('#addProductForm').on('submit', function(e) {
            e.preventDefault();
            var test = new AjaxSettings();
            jQuery('.progress.header-progress .progress-bar').removeAttr('style');
            var params = jQuery.extend({}, test.doAjax_params_default);
            params['url'] = "{{ route('products') }}";
            params['data'] = JSON.stringify({

                name: jQuery('#product-input-name').val(),
                slt: jQuery('#product-input-slt').val(),
                description: jQuery('#product-input-desc').val(),
                storage_t: jQuery('#product-input-storage').val()

            });
            params['successCallbackFunction'] = function( data ) {
                if (data.fail) {
                    // todo print failed data
                    console.log(data.fail);
                }
                else if(data.status == '200'){
                    // print success
                    jQuery("#btnCancelProductFrom").trigger('click');
                    jQuery('#successBoxAlert').html(jQuery('#successBoxAlert').html().replace(/{ID}/g, data.details.id));
                    jQuery("#successBoxAlert").removeClass('d-none').addClass('show');
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

    });
</script>
@endsection