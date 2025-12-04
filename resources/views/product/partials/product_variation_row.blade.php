
@if(!session('business.enable_price_tax')) 
    @php
        $default = 0;
        $class = 'hide';
    @endphp
@else
    @php
        $default = null;
        $class = '';
    @endphp
@endif

<tr class="variation_row">
    <td>
        <button type="button" class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline tw-dw-btn-error delete_complete_row">
            <i class="fa fa-trash"></i>
        </button>
    </td>

    <td>
        {!! Form::select('product_variation[' . $row_index . '][variation_template_id]', $variation_templates, null, [
            'class' => 'form-control input-sm variation_template',
            'required'
        ]) !!}
        <input type="hidden" class="row_index" value="{{ $row_index }}">

        <div class="form-group variation_template_values_div mt-15 hide">
            <label>@lang('lang_v1.select_variation_values')</label>
            {!! Form::select('product_variation[' . $row_index . '][variation_template_values][]', [], null, [
                'class' => 'form-control input-sm variation_template_values',
                'multiple',
                'style' => 'width: 100%;'
            ]) !!}
        </div>
    </td>

    <td>
        <table class="table table-condensed table-bordered blue-header variation_value_table">
            <thead>
                <tr>
                    <th width="12%">@lang('product.sku') @show_tooltip(__('tooltip.sub_sku'))</th>
                    <th width="15%">@lang('product.value')</th>
                    <th width="18%" class="{{ $class }}">@lang('product.default_purchase_price')
                        <br><small><i class="text-muted">@lang('product.exc_of_tax') / @lang('product.inc_of_tax')</i></small>
                    </th>
                    <th width="10%" class="{{ $class }}">@lang('product.profit_percent')</th>
                    <th width="18%" class="{{ $class }}">@lang('product.default_selling_price')
                        <br><small><i class="text-muted dsp_label"></i></small>
                    </th>
                    <th width="12%">@lang('lang_v1.variation_images')</th>
                    <th width="15%">Product Keywords</th>
                    <th width="5%">
                        <button type="button" class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline tw-dw-btn-accent add_variation_value_row">+</button>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="variation_value_row">
                    <td>
                        {!! Form::text('product_variation[' . $row_index . '][variations][0][sub_sku]', null, [
                            'class' => 'form-control input-sm'
                        ]) !!}
                    </td>
                    <td>
                        {!! Form::text('product_variation[' . $row_index . '][variations][0][value]', null, [
                            'class' => 'form-control input-sm variation_value_name',
                            'required'
                        ]) !!}
                    </td>
                    <td class="{{ $class }}">
                        <div class="input-group">
                            {!! Form::text('product_variation[' . $row_index . '][variations][0][default_purchase_price]', $default, [
                                'class' => 'form-control input-sm variable_dpp input_number',
                                'placeholder' => __('product.exc_of_tax'),
                                'required'
                            ]) !!}
                            <span class="input-group-addon"><i class="fa fa-arrow-right"></i></span>
                            {!! Form::text('product_variation[' . $row_index . '][variations][0][dpp_inc_tax]', $default, [
                                'class' => 'form-control input-sm variable_dpp_inc_tax input_number',
                                'placeholder' => __('product.inc_of_tax'),
                                'required'
                            ]) !!}
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default bg-white btn-flat apply-all btn-sm" 
                                        data-target-class=".variable_dpp_inc_tax" title="@lang('lang_v1.apply_all')">
                                    <i class="fas fa-check-double"></i>
                                </button>
                            </span>
                        </div>
                    </td>
                    <td class="{{ $class }}">
                        {!! Form::text('product_variation[' . $row_index . '][variations][0][profit_percent]', $profit_percent, [
                            'class' => 'form-control input-sm variable_profit_percent input_number',
                            'required'
                        ]) !!}
                    </td>
                    <td class="{{ $class }}">
                        {!! Form::text('product_variation[' . $row_index . '][variations][0][default_sell_price]', $default, [
                            'class' => 'form-control input-sm variable_dsp input_number',
                            'placeholder' => __('product.exc_of_tax'),
                            'required'
                        ]) !!}
                        {!! Form::hidden('product_variation[' . $row_index . '][variations][0][sell_price_inc_tax]', $default, [
                            'class' => 'variable_dsp_inc_tax'
                        ]) !!}
                    </td>
                    <td>
                        {!! Form::file('variation_images_' . $row_index . '_0[]', [
                            'class' => 'variation_images',
                            'accept' => 'image/*',
                            'multiple'
                        ]) !!}
                    </td>

                    <!-- NEW: product_keywords field for each variation -->
                    <td>
                        {!! Form::text('product_variation[' . $row_index . '][variations][0][product_keywords]', null, [
                            'class' => 'form-control input-sm',
                            'placeholder' => 'e.g. red shoe, summer 2025, leather'
                        ]) !!}
                    </td>

                    <td class="text-center">
                        <button type="button" class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline tw-dw-btn-error remove_variation_value_row">
                            <i class="fa fa-trash"></i>
                        </button>
                        <input type="hidden" class="variation_row_index" value="0">
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>