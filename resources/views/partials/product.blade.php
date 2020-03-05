<!-- ROW PRODUCTS -->
<div class="row">
    <div class="col-sm-12">
        <div id="productsBox" class="user-data m-b-30">
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
                        <th data-field="slt" data-sortable="true" data-formatter="nameFormatter">SL-Reference (days)</th>
                        <th data-field="storage_t" data-sortable="true">Storage T (&#8451;)</th>
                        <th data-field="description" data-sortable="true">Description</th>
                        <th data-field="id" data-box="productsBox" data-formatter="btnFormatter"></th>
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
                            <label for="product-input-slt" class="form-control-label">SL-Reference *</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="number" min="0" step="0.01" id="product-input-slt" name="product-input-slt" placeholder="13.56" class="form-control" required>
                            <small class="form-text text-muted">Insert a number of product shelf life at recommended temperature in days.</small>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3 text-right">
                            <label for="product-input-storage-min" class="form-control-label">Storage T *</label>
                        </div>
                        <div class="col-12 col-sm-2">
                            <input type="number" step="0.1" id="product-input-storage-min" name="product-input-storage-min" placeholder="min" class="form-control" required>
                        </div>
                        <div class="col-12 col-sm-2">
                            <input type="number" step="0.1" id="product-input-storage-max" name="product-input-storage-max" placeholder="max" class="form-control" required>
                        </div>
                        <div class="col-12 offset-sm-3 col-sm-12">
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