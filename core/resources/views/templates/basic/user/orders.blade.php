@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="row justify-content-end mb-4">
        <div class="col-xl-4 col-md-6">
            <form action="">
                <div class="input-group">
                    <input type="text" name="search" class="form-control form--control" value="{{ request()->search }}"
                        placeholder="@lang('Search by Trx')">
                    <button class="input-group-text bg--base border-0 text--white">
                        <i class="las la-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table--responsive--md custom--table">
                    <thead>
                        <tr>
                            <th>@lang('Transaction')</th>
                            <th>@lang('Ordered At')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Quantity')</th>
                            <th>@lang('Details')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            @php
                                $qty = @$order->orderItems->count();
                                $perUnitPrice = @$order->orderItems->first()->price;
                                $walletOrder = $order->deposit ? false : true;
                            @endphp
                            @if ($walletOrder)
                                <tr>
                                    <td>
                                        <div class="td-wrapper">
                                            <span class="title d-block">Order from wallet</span>
                                            <a href="{{ route('user.wallet.history') }}" class="info text--base">
                                                View Wallet History
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-wrapper">
                                            {{ showDateTime($order->created_at) }}<br>{{ diffForHumans($order->created_at) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-wrapper">
                                            <span class="d-block">{{ $qty }} @lang('Qty') x
                                                {{ showAmount($perUnitPrice) }} {{ __($general->cur_text) }}</span>
                                            <span class="fw-bold">
                                                {{ showAmount($order->total_amount) }} {{ __($general->cur_text) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span>{{ @$order->orderItems->count() }}</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a class="action-btn btn btn--base btn--sm"
                                                href="{{ route('user.order.details', $order->id) }}">
                                                <i class="fa fa-desktop"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td>
                                        <div class="td-wrapper">
                                            <span class="title d-block">{{ $order->deposit->trx }}</span>
                                            <a href="{{ route('user.deposit.history', ['search' => $order->deposit->trx]) }}"
                                                class="info text--base">
                                                @lang('View Transaction Details')
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-wrapper">
                                            {{ showDateTime($order->created_at) }}<br>{{ diffForHumans($order->created_at) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-wrapper">
                                            <span class="d-block">{{ $qty }} @lang('Qty') x
                                                {{ showAmount($perUnitPrice) }} {{ __($general->cur_text) }}</span>
                                            <span class="fw-bold">
                                                {{ showAmount($order->total_amount) }} {{ __($general->cur_text) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span>{{ @$order->orderItems->count() }}</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a class="action-btn btn btn--base btn--sm"
                                                href="{{ route('user.order.details', $order->id) }}">
                                                <i class="fa fa-desktop"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ paginateLinks($orders) }}
        </div>
    </div>
    <div class="container mt-5">
        <h5 class="mt-4 mb-4 ">Watch Our Videos</h5>
        <div class="row g-4">
            <div class="col-md-6 mb-4">
                <div class="video-wrapper">
                    <iframe width="100%"
                        src="https://www.youtube.com/embed/R41_SXiMs8Q?si=6GOID4gr5zVcA1vo" title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <div class="caption mt-2">
                    <h5>How to login using cookies</h5>
                    <p>Fastest and easy way to access accounts that needs cookies to login</p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="video-wrapper">
                    <iframe width="100%"
                    src="https://www.youtube.com/embed/bddwDnWnw-E?si=nTThP8Xk4kmxLip1" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <div class="caption mt-2">
                    <h5>How to fund www.no1logs.com easily</h5>
                    <p>Easy and simple steps to login and fund or make purchase on no1logs</p>
                </div>
            </div>
        </div>
    </div>
@endsection
