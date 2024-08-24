@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-12">
            <div class="row gy-4">

                <div class="col-lg-6 col-md-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--primary">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-wallet"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $general->cur_sym }}{{ showAmount($totalEarnings) }}</h3>
                            <p class="text-white">API Earnings</p>
                        </div>
                        {{-- <a href="{{ route('admin.api.order.list') }}" class="widget-two__btn">@lang('View All')</a> --}}
                    </div>
                </div>
                <!-- dashboard-w1 end -->

                <div class="col-lg-6 col-md-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--15">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-shopping-cart"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $totalOrder }}</h3>
                            <p class="text-white">API Orders</p>
                        </div>
                        {{-- <a href="{{ route('admin.api.order.list') }}" class="widget-two__btn">@lang('View All')</a> --}}
                    </div>
                </div>

            </div>

            <div class="d-flex flex-wrap gap-3 mt-4">
                <div class="flex-fill">
                    <a href="{{ route('admin.api.detail', $apiProvider->id) }}?tab=edit"
                        class="btn {{ $currTab === 'edit' ? 'btn--primary' : 'btn-outline--primary' }} btn--shadow w-100 btn-lg">
                        <i class="las la-edit"></i>Edit API
                    </a>
                </div>

                <div class="flex-fill">
                    <a href="{{ route('admin.api.detail', $apiProvider->id) }}?tab=categories"
                        class="btn {{ $currTab === 'categories' ? 'btn--secondary' : 'btn-outline--secondary' }} btn--shadow w-100 btn-lg">
                        <i class="las la-list"></i>Category Management
                    </a>
                </div>

                <div class="flex-fill">
                    <a href="{{ route('admin.api.detail', $apiProvider->id) }}?tab=products"
                        class="btn {{ $currTab === 'products' ? 'btn--success' : 'btn-outline--success' }} btn--shadow w-100 btn-lg">
                        <i class="las la-box"></i>Product Management
                    </a>
                </div>

                <div class="flex-fill">
                    <a href="{{ route('admin.api.detail', $apiProvider->id) }}?tab=orders"
                        class="btn {{ $currTab === 'orders' ? 'btn--warning' : 'btn-outline--warning' }} btn--shadow w-100 btn-lg">
                        <i class="las la-shopping-cart"></i>Order Management
                    </a>
                </div>
            </div>

            @if ($currTab === "edit")
                <div class="card mt-30">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit connection <a
                                href="{{ $apiProvider->domain }}" target="blank">{{ $apiProvider->domain }}</a></h5>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.api.update',[$apiProvider->id])}}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Domain</label>
                                        <input type="text" class="form-control" placeholder="e.g. https://no1logs.com/"
                                            name="domain" value="{{ $apiProvider->domain }}" readonly/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>API Type</label>
                                        <select name="type" class="form-control" disabled>
                                            <option @if ($apiProvider->type == 'no1logs') selected @endif value="no1logs">No1Logs
                                                API</option>
                                            <option @if ($apiProvider->type == 'CMSNT') selected @endif value="CMSNT">SHOPCLONE5
                                                & SHOPCLONE6 CMSNT</option>
                                        </select>
                                        <input type="hidden" name="type" value="{{ $apiProvider->type }}" />
                                    </div>
                                </div>
                            </div>

                            @if ($apiProvider->type === 'no1logs')
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="mb-2">No1logs API Config</h6>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>API Token/Key</label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter the token in the API section of your No1logs dashboard"
                                                name="token" value="{{ $apiProvider->token }}"/>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="mb-2">SHOPCLONE5 & SHOPCLONE6 CMSNT API Config</h6>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Login Username </label>
                                            <input type="text" class="form-control" placeholder="Enter your login name"
                                                value="{{ $apiProvider->username }}" name="username" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Password')</label>
                                            <input type="text" class="form-control" placeholder="Enter your login password"
                                                name="password" value="{{ $apiProvider->password }}" />
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Automatically update prices</label>
                                        <select name="status_update_ck" class="form-control">
                                            <option @if ($apiProvider->status_update_ck == '1') selected @endif value="1">YES</option>
                                            <option @if ($apiProvider->status_update_ck == '0') selected @endif value="0">No</option>
                                        </select>
                                        <i class="lh-1" style="font-size: 12px; margin-top: 5px;">Select No and the system
                                            will stop updating prices according to the API</i>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Price Increase Percentage</label>
                                        <input type="text" class="form-control" value="{{ $apiProvider->ck_connect_api }}" placeholder="Enter Price Increase Percentage"
                                            name="ck_connect_api" />
                                        <i class="lh-1" style="font-size: 12px; margin-top: 5px;">The system will
                                            automatically increase the API product price by 20%, set to 0 if you want the
                                            selling price to be the same as the original website price.</i>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Automatically update product names</label>
                                        <select name="auto_rename_api" class="form-control">
                                            <option @if ($apiProvider->auto_rename_api == '1') selected @endif value="1">YES</option>
                                            <option @if ($apiProvider->auto_rename_api == '0') selected @endif value="0">No</option>
                                        </select>
                                        <i class="lh-1" style="font-size: 12px; margin-top: 5px;">If you select yes, the
                                            system will automatically update the product name and product description according
                                            to the API (please turn it off if you want to rename the product name on
                                            request).</i>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Current Balance</label>
                                        <input type="text" class="form-control" value="{{ $general->curr_sym }} {{ showAmount($apiProvider->balance) }}"
                                            name="balance" readonly />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>API Base Currency</label>
                                        <input type="text" class="form-control" value="{{ $apiProvider->base_currency }}"
                                            name="base_currency" readonly />
                                        <i class="lh-1" style="font-size: 12px; margin-top: 5px;">This simply represents the base currency retrievd from the API (converted to your site's currency if neccessary)</i>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option @if ($apiProvider->status == '1') selected @endif value="1">YES</option>
                                            <option @if ($apiProvider->status == '0') selected @endif value="0">No</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            @elseif($currTab === "categories")
                <div class="card mt-30 b-radius--10 bg--transparent shadow-none">
                    <div class="card-body p-0">
                        <div class="table-responsive--sm table-responsive">
                            <table class="table--light style--two table bg-white">
                                <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse($allData as $data)
                                        <tr>
                                            <td>
                                                <span class="fw-bold">{{ __($data->name) }}</span>
                                            </td>
                                            <td> 
                                            @php echo $data->statusBadge; @endphp
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline--primary dropdown-toggle" id="actionButton" data-bs-toggle="dropdown">
                                                        <i class="las la-ellipsis-v"></i>@lang('Action')
                                                    </button>
                                                    <div class="dropdown-menu p-0">
                                                        <a href="javascript:void(0)" class="dropdown-item editBtn" data-data="{{ $data }}">
                                                            <i class="la la-pencil"></i> @lang('Edit')
                                                        </a>
                                                        @if($data->status == Status::ENABLE)
                                                            <a href="javascript:void(0)" 
                                                                class="dropdown-item confirmationBtn"
                                                                data-action="{{ route('admin.category.status', $data->id) }}"
                                                                data-question="@lang('Are you sure to disable this item?')">
                                                                <i class="la la-eye-slash"></i> @lang('Disable')
                                                            </a>
                                                        @else
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-item confirmationBtn"
                                                                data-action="{{ route('admin.category.status', $data->id) }}"
                                                                data-question="@lang('Are you sure to enable this item?')">
                                                                <i class="la la-eye"></i> @lang('Enable')
                                                            </a>
                                                        @endif 
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table><!-- table end -->
                        </div>
                    </div>
                    @if ($allData->hasPages())
                        <div class="card-footer py-4">
                            {{ paginateLinks($allData) }}
                        </div>
                    @endif
                </div>
            @elseif($currTab === "products")
                <div class="card mt-30 b-radius--10 bg--transparent shadow-none">
                    <div class="card-body p-0">
                        <div class="table-responsive--sm table-responsive">
                            <table class="table--light style--two table bg-white">
                                <thead>
                                <tr>
                                    <th>@lang('Name | Category')</th>
                                    <th>@lang('Price | Cost')</th>
                                    <th>@lang('In Stock')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse($allData as $data)
                                        <tr>
                                            <td>
                                                <span class="d-block">Original Product Name: {{ strLimit($data->name_api, 50) }}</span>
                                                <span class="d-block">Product Name: <span class="fw-bold">{{ strLimit($data->name, 50) }}</span></span>
                                                <span class="small d-block">Category: {{ __(@$data->category->name) }}</span>
                                            </td>
                                            <td> 
                                                <span class="d-block">Selling Price: <span class="fw-bold">{{ showAmount($data->price) }} {{ __($general->cur_text) }}</span></span>
                                                <span class="d-block">API Price: {{ showAmount($data->api_price) }} {{ __($general->cur_text) }}</span>
                                            </td>
                                            <td>
                                                <span class="bg--primary px-2 rounded text--white">
                                                    {{ showAmount(@$data->api_stock, 0) }}
                                                </span>
                                            </td>
                                            <td> 
                                            @php echo $data->statusBadge; @endphp
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline--primary dropdown-toggle" id="actionButton" data-bs-toggle="dropdown">
                                                        <i class="las la-ellipsis-v"></i>@lang('Action')
                                                    </button>
                                                    <div class="dropdown-menu p-0">
                                                        <a href="{{ route('admin.product.form', $data->id) }}" class="dropdown-item">
                                                            <i class="la la-pencil"></i> @lang('Edit')
                                                        </a>
                                                        @if($data->status == Status::ENABLE)
                                                            <a href="javascript:void(0)" class="dropdown-item confirmationBtn"
                                                                data-action="{{ route('admin.product.status', $data->id) }}"
                                                                data-question="@lang('Are you sure to disable this item?')">
                                                                <i class="la la-eye-slash"></i> @lang('Disable')
                                                            </a>
                                                        @else
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-item confirmationBtn"
                                                                data-action="{{ route('admin.product.status', $data->id) }}"
                                                                data-question="@lang('Are you sure to enable this item?')">
                                                                <i class="la la-eye"></i> @lang('Enable')
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table><!-- table end -->
                        </div>
                    </div>
                    @if ($allData->hasPages())
                        <div class="card-footer py-4">
                            {{ paginateLinks($allData) }}
                        </div>
                    @endif
                </div>
            @else
                <div class="mt-3">
                    {{-- <div class="show-filter mb-3 text-end"> --}}
                    <div class="mb-3 text-end">
                        <button type="button" class="btn btn-outline--primary showFilterBtn btn-sm"><i class="las la-filter"></i> @lang('Filter')</button>
                    </div>
                    <div class="card responsive-filter-card mb-4" style="display: none;">
                        <div class="card-body">
                            <form action="">
                                <div class="d-flex flex-wrap gap-4">
                                    <div class="flex-grow-1">
                                        <label>@lang('Username')</label>
                                        <input type="text" name="search" value="{{ request()->search }}" class="form-control">
                                    </div>
                                    <div class="flex-grow-1">
                                        <label>@lang('Date')</label>
                                        <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Start date - End date')" autocomplete="off" value="{{ request()->date }}">
                                    </div>
                                    <div class="flex-grow-1 align-self-end">
                                        <button class="btn btn--primary w-100 h-45"><i class="fas fa-filter"></i> @lang('Filter')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card b-radius--10 ">
                        <div class="card-body p-0">
                            <div class="table-responsive--sm table-responsive">
                                <table class="table table--light style--two">
                                    <thead>
                                        <tr>
                                            <th>@lang('User')</th>
                                            <th>@lang('Payment Trx | Info')</th>
                                            <th>@lang('Ordered At')</th>
                                            <th>@lang('Amount')</th>
                                            <th>@lang('Quantity')</th>
                                            <th>@lang('Status')</th>
                                            <th>@lang('Details')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($allData as $data)
                                            @php 
                                                $qty = @$data->orderItems->count();
                                                $perUnitPrice = @$data->orderItems->first()->price;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <span class="fw-bold">{{ $data->user->fullname }}</span>
                                                    <br>
                                                    <span class="small"> <a href="{{ appendQuery('search',$data->user->username) }}"><span>@</span>{{ $data->user->username }}</a> </span>
                                                </td>
            
                                                <td>
                                                    <div>
                                                        @if(isset($data->wallet->trx))
                                                            <span class="d-block">Transaction Code: {{ $data->wallet->trx }}</span>
                                                        @endif
                                                        @if(isset($data->wallet->api_trx_id))
                                                            <span class="d-block">API Transaction Code: {{ $data->wallet->api_trx_id }}</span>
                                                        @endif
                                                        <span class="d-block">Product: {{ $data->orderItems->firstItem()->product->name }}</span>
                                                        <span class="d-block">Product: {{ $data->orderItems->firstItem()->product->name }}</span>
                                                    </div>
                                                </td>
            
                                                <td>
                                                    {{ showDateTime($data->created_at) }}<br>{{ diffForHumans($data->created_at) }}
                                                </td>
            
                                                <td class="budget">
                                                    <span class="d-block">{{ $qty }} @lang('Qty') x {{ showAmount($perUnitPrice) }} {{ __($general->cur_text) }}</span>
                                                    <span class="fw-bold">
                                                        Payment: {{showAmount($data->total_amount)}} {{ __($general->cur_text) }}
                                                    </span>
                                                    @php
                                                        $apiCost = $data->orderItems->firstItem()->product->api_price * $qty;
                                                        $priceChange = $apiCost - $data->total_amount
                                                    @endphp
                                                    <span class="fw-bold">
                                                        API Cost: {{ showAmount($apiCost)}} {{ __($general->cur_text) }}
                                                    </span>
                                                    @if($apiCost > $data->total_amount)
                                                    <span class="fw-bold text-success">
                                                        Profit: {{ showAmount(($priceChange))}} {{ __($general->cur_text) }}
                                                    </span>
                                                    @else
                                                    <span class="fw-bold text-danger">
                                                        Loss: {{ showAmount(($priceChange))}} {{ __($general->cur_text) }}
                                                    </span>
                                                    @endif
                                                </td>
            
                                                <td>
                                                    {{ $qty }}
                                                </td>
            
                                                <td>
                                                    @php echo $data->statusBadge; @endphp
                                                </td>
            
                                                <td>
                                                    <a href="{{ route('admin.report.order.details', $data->id) }}" class="btn btn-sm btn-outline--primary">
                                                        <i class="las la-desktop"></i> @lang('Details')
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty 
                                            <tr>
                                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                            </tr>
                                        @endforelse
            
                                </tbody>
                            </table><!-- table end -->
                        </div>
                    </div>
                    @if($allData->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($allData) }}
                    </div>
                    @endif
                </div><!-- card end -->
            @endif

        </div>
    </div>

    <x-confirmation-modal />
    
    {{-- EDIT MODAL --}} 
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">@lang('Update Category')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form class="form-horizontal" method="post" action="{{ route('admin.category.update') }}">
                    @csrf
                    <input type="hidden" name="id" required>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input type="text" class="form-control edit_name" name="name" required autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
<style>
    .table-responsive {
        background: transparent;
        min-height: 300px;
    }
    .dropdown-toggle::after {
        display: inline-block;
        margin-left: 0.255em;
        vertical-align: 0.255em;
        content: "";
        border-top: 0.3em solid;
        border-right: 0.3em solid transparent;
        border-bottom: 0;
        border-left: 0.3em solid transparent;
    }                             
</style>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{asset('assets/admin/css/vendor/datepicker.min.css')}}">
@endpush


@push('script-lib')
  <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($){
            "use strict";  

            $('.editBtn').on('click', function () {
                var modal = $('#editModal');
                var data = $(this).data('data');

                modal.find('input[name=id]').val(data.id);
                modal.find('input[name=name]').val(data.name);

                modal.modal('show');
            });

            if(!$('.datepicker-here').val()){
                $('.datepicker-here').datepicker();
            }
        })(jQuery);
    </script>
@endpush
