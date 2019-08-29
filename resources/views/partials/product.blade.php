<!-- ROW PRODUCTS -->
<div class="row">
    <div class="col-sm-12">
        <div class="user-data m-b-30">
            <h3 class="title-3 m-b-30">
                <i class="fab fa-flickr"></i>Products

                <button class="au-btn au-btn-icon au-btn--green au-btn--small pull-right">
                    <i class="zmdi zmdi-plus"></i>add product
                </button>
            </h3>
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
    });
</script>
@endsection