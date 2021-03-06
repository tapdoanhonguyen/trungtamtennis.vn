<!-- BEGIN: main -->
<div id="category">

    <!-- BEGIN: displays -->
    <div class="form-group form-inline pull-right">
        <label class="control-label">{LANG.displays_product}</label>
        <select name="sort" id="sort" class="form-control input-sm" onchange="nv_chang_price();">
            <!-- BEGIN: sorts -->
                <option value="{key}" {se}> {value}</option>
            <!-- END: sorts -->
        </select>
        <label class="control-label">{LANG.title_viewnum}</label>
        <select name="viewtype" id="viewtype" class="form-control input-sm" onchange="nv_chang_viewtype();">
            <!-- BEGIN: viewtype -->
                <option value="{VIEWTYPE.key}" {VIEWTYPE.selected}> {VIEWTYPE.value}</option>
            <!-- END: viewtype -->
        </select>
    </div>
    <div class="clear">&nbsp;</div>
    <!-- END: displays -->

	<!-- BEGIN: grid_rows -->
    <div class="col-sm-12 col-md-{num}">
        <div class="thumbnail">
            <div style="height: {height}px">
                <a href="{link_pro}" title="{title_pro}"><img src="{img_pro}" alt="{title_pro}" <!-- BEGIN: tooltip_js -->data-content='{intro}' data-rel="tooltip" data-img="{img_pro}"<!-- END: tooltip_js -->class="img-thumbnail" style="border:0;max-height:{height}px;max-width:{width}px;"></a>
            </div>
            <div class="info_pro">
            	<!-- BEGIN: discounts -->
            	<span class="label label-danger">-{PRICE.discount_percent}{PRICE.discount_unit}</span>
            	<!-- END: discounts -->
            	<!-- BEGIN: point -->
            	<span class="label label-info" title="{point_note}">+{point}</span>
            	<!-- END: point -->
            	<!-- BEGIN: gift -->
            	<span class="label label-success">+<em class="fa fa-gift fa-lg">&nbsp;</em></span>
            	<!-- END: gift -->
            </div>
            <div class="caption text-center">
                <h3><a href="{link_pro}" title="{title_pro}">{title_pro0}</a></h3>

                <!-- BEGIN: adminlink -->
                <p>{ADMINLINK}</p>
                <!-- END: adminlink -->

				<!-- BEGIN: price -->
				<p class="price">
                    <!-- BEGIN: discounts -->
                    <span class="money">{PRICE.sale_format} {PRICE.unit}</span>
                    <span class="discounts_money">{PRICE.price_format} {PRICE.unit}</span>
                    <!-- END: discounts -->

					<!-- BEGIN: no_discounts -->
					<span class="money">{PRICE.price_format} {PRICE.unit}</span>
					<!-- END: no_discounts -->
				</p>
				<!-- END: price -->

                <!-- BEGIN: contact -->
                <p class="price">
                    {LANG.detail_pro_price}: <span class="money">{LANG.price_contact}</span>
                </p>
                <!-- END: contact -->
            </div>
        </div>
    </div>
	<!-- END: grid_rows -->
	<div class="clearfix">
	</div>
	<div class="text-center">
		{pages}
	</div>
</div>

<!-- BEGIN: modal_loaded -->
<div class="modal fade" id="idmodals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">{LANG.add_product}</h4>
			</div>
			<div class="modal-body">
				<em class="fa fa-spinner fa-spin">&nbsp;</em>
			</div>
		</div>
	</div>
</div>
<!-- END: modal_loaded -->

<div class="msgshow" id="msgshow">
</div>
<!-- END: main -->
