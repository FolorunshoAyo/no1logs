@extends('admin.layouts.app')

@section('panel')
    <div class="row gy-4 mt-2">
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="2" icon="fas fa-hand-holding-usd" icon_style="false" title="Full-time API profits"
                value="{{ $general->cur_sym }}{{ showAmount($widget['full_time_profits']) }}" color="primary" />
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="2" icon="fas fa-hand-holding-usd" icon_style="false" title="{{ $currentMonth }} API profit"
                value="{{ $general->cur_sym }}{{ showAmount($widget['monthly_profits']) }}" color="success" />
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="2" icon="fas fa-hand-holding-usd" icon_style="false" title="API profits for the week"
                value="{{ $general->cur_sym }}{{ showAmount($widget['weekly_profits']) }}" color="warning" />
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="2" icon="fas fa-hand-holding-usd" icon_style="false" title="API profits today"
                value="{{ $general->cur_sym }}{{ showAmount($widget['daily_profits']) }}" color="danger" />
        </div><!-- dashboard-w1 end -->
    </div><!-- row end-->

    <div class="row mb-none-30 mt-30">
        <div class="col-xl-12 mb-30">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="las la-cogs mr-1"></i> API Configuration
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.api.update.general-settings') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Status</label>
                                <select class="form-control" name="status_connect_api">
                                    <option {{ $general->status_connect_api === 1 ? 'selected' : '' }} value="1">ON
                                    </option>
                                    <option {{ $general->status_connect_api === 0 ? 'selected' : '' }} value="0">OFF
                                    </option>
                                </select>
                                <i style="font-size: 12px; margin-top: 5px;">ON/OFF API product connection function.</i>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Default Category and Product status when connecting to API</label>
                                <select class="form-control" name="default_api_product_status">
                                    <option {{ $general->default_api_product_status === 1 ? 'selected' : '' }}
                                        value="1">Show</option>
                                    <option {{ $general->default_api_product_status === 0 ? 'selected' : '' }}
                                        value="0">Hide</option>
                                </select>
                                <i class="lh-1" style="font-size: 12px; margin-top: 5px;">If you select Hidden, the
                                    products when you connect to the default API will be hidden
                                    from the website.</i>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-60 mt-5">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-header flex align-items-center justify-content-between d-flex flex-wrap">
                    <h4 class="card-title mb-1">
                        <i class="las la-network-wired mr-1"></i> API List
                    </h4>
                    <div class="d-flex flex-wrap gap-2 align-items-center breadcrumb-plugins">
                        <x-search-form placeholder="API Domain / Username / Password" />
                        <a href="{{ route('admin.api.new') }}" class="btn btn--primary">
                            <i class="las la-plus-circle mr-2"></i>
                            Add Website API
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Domain</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Token</th>
                                    <th>API Currency</th>
                                    <th>Balance</th>
                                    <th>Status</th>
                                    <th>Operation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sn = 1;
                                @endphp
                                @forelse($apiProviderData as $apiProvider)
                                    <tr>
                                        <td>
                                            {{ $sn }}
                                        </td>

                                        <td>
                                            {{ $apiProvider->domain }}
                                        </td>

                                        <td>
                                            {{ $apiProvider->username }}
                                        </td>

                                        <td>
                                            {{ maskHalfText($apiProvider->password) }}
                                        </td>

                                        <td>
                                            {{ strLimit($apiProvider->token) }}
                                        </td>

                                        <td>
                                            {{ $apiProvider->base_currency }}
                                        </td>

                                        <td>
                                            {{ showAmount($apiProvider->balance) }} {{ __($general->cur_text) }}
                                        </td>

                                        <td>
                                            @php echo $apiProvider->statusBadge; @endphp
                                        </td>

                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline--primary dropdown-toggle"
                                                    id="actionButton" data-bs-toggle="dropdown">
                                                    <i class="las la-ellipsis-v"></i>@lang('Action')
                                                </button>
                                                <div class="dropdown-menu p-0">
                                                    <a href="{{ route('admin.api.detail', $apiProvider->id) }}?tab=edit"
                                                        class="dropdown-item">
                                                        <i class="la la-pencil"></i> @lang('Edit')
                                                    </a>
                                                    <a href="javascript:void(0)" class="dropdown-item confirmationBtn"
                                                        data-action="{{ route('admin.api.delete', $apiProvider->id) }}"
                                                        data-question="Are you sure to remove this API? Doing this would delete all API products and its categories from the site.">
                                                        <i class="la la-eye-slash"></i> Remove
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                    @php
                                        $sn++;
                                    @endphp
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($apiProviderData->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($apiProviderData) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection
