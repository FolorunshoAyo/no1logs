@extends('user.layouts.app')
@section('title',__('Orders'))

@section('content')
    <div class="container-fluid px-3 user-service-list ">
        <div class="row my-3 justify-content-between mx-lg-5">
            <div class="col-md-12">
                <ol class="breadcrumb center-items">
                    <li><a href="{{route('user.home')}}">@lang('Home')</a></li>
                    <li class="active">@lang('Order List')</li>
                </ol>

                <div class="card my-3">
                    <div class="card-body">
                        <form action="{{ route('user.order.search') }}" method="get">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" name="order_id" value="{{@request()->order_id}}"
                                               class="form-control"
                                               placeholder="@lang('Order ID')">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" name="service" value="{{@request()->service}}"
                                               class="form-control get-service"
                                               placeholder="@lang('Service')">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select name="status" class="form-control">
                                            <option value="-1"
                                                    @if(@request()->status == '-1') selected @endif>@lang('All Status')</option>
                                            <option value="awaiting"
                                                    @if(@request()->status == 'awaiting') selected @endif>@lang('Awaiting')</option>
                                            <option value="pending"
                                                    @if(@request()->status == 'pending') selected @endif>@lang('Pending')</option>
                                            <option value="processing"
                                                    @if(@request()->status == 'processing') selected @endif>@lang('Processing')</option>
                                            <option value="progress"
                                                    @if(@request()->status == 'progress') selected @endif>@lang('In Progress')</option>
                                            <option value="completed"
                                                    @if(@request()->status == 'completed') selected @endif>@lang('Completed')</option>
                                            <option value="partial"
                                                    @if(@request()->status == 'partial') selected @endif>@lang('Partial')</option>
                                            <option value="canceled"
                                                    @if(@request()->status == 'canceled') selected @endif>@lang('Cancelled')</option>
                                            <option value="refunded"
                                                    @if(@request()->status == 'refunded') selected @endif>@lang('Refunded')</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="date_time" id="datepicker"/>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn waves-effect waves-light w-100 btn-primary"><i
                                                class="fas fa-search"></i> @lang('Search')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="row my-3 justify-content-between align-items-center mx-lg-5">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-body">

                        <div class="row justify-content-between align-items-start">
                            <div class="col-sm-12">
                                <div class="my-4">
                                    @php
                                        $lastSegment = collect(request()->segments())->last();
                                    @endphp
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a class="nav-link @if(Request::routeIs('user.order.index') || Request::routeIs('user.order.search') ) active @endif"
                                               href="{{ route('user.order.index') }}">@lang('All Orders')</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="nav-link  {{( $lastSegment == 'awaiting') ? 'active' : '' }}"
                                               href="{{ route('user.order.status.search',['awaiting']) }}">@lang('Awaiting')</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link {{( $lastSegment == 'pending') ? 'active' : '' }}"
                                               href="{{ route('user.order.status.search',['pending']) }}">@lang('Pending')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{( $lastSegment == 'processing') ? 'active' : '' }}"
                                               href="{{ route('user.order.status.search',['processing']) }}">@lang('Processing')</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link {{( $lastSegment == 'progress') ? 'active' : '' }}"
                                               href="{{ route('user.order.status.search',['progress']) }}">@lang('In progress')</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link  {{( $lastSegment == 'completed') ? 'active' : '' }}"
                                               href="{{ route('user.order.status.search',['completed']) }}">@lang('Completed')</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link {{( $lastSegment == 'partial') ? 'active' : '' }}"
                                               href="{{ route('user.order.status.search',['partial']) }}">@lang('Partial')</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link {{( $lastSegment == 'canceled') ? 'active' : '' }}"
                                               href="{{ route('user.order.status.search',['canceled']) }}">@lang('Canceled')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{( $lastSegment == 'refunded') ? 'active' : '' }}"
                                               href="{{ route('user.order.status.search',['refunded']) }}">@lang('Refunded')</a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>


                        <div class="table-responsive ">
                            <table class="categories-show-table table table-striped text-center ">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('Order ID')</th>
                                    <th scope="col" class="order-details-column text-left">@lang('Order Details')</th>
                                    <th scope="col">@lang('Price')</th>
                                    <th scope="col">@lang('Start Counter')</th>
                                    <th scope="col">@lang('Remains')</th>
                                    <th scope="col">@lang('Order AT')</th>
                                    <th scope="col">@lang('Status')</th>
                                    <th scope="col">@lang('More')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($orders as $key => $order)
                                    <tr>
                                        <td> {{$order->id}} </td>
                                        <td class="text-left">
                                            <h5>@lang(optional($order->service)->service_title)</h5>
                                            @lang('Link'): @lang($order->link)<br>
                                            @lang('Quantity'): @lang($order->quantity) <br>
                                        </td>
                                        <td>@lang($order->price) @lang(config('basic.currency'))</td>
                                        <td>@lang($order->start_counter?? 'N/A')</td>
                                        <td>@lang($order->remains ?? 'N/A' )</td>
                                        <td>@lang(dateTime($order->created_at, 'd/m/Y - h:i A' ))</td>

                                        <td>
                                            @if($order->status=='awaiting')
                                                <span
                                                    class="badge badge-pill badge-danger">{{trans('Awaiting')}}</span>
                                            @elseif($order->status == 'pending')
                                                <span
                                                    class="badge badge-pill badge-info">{{trans('Pending')}}</span>
                                            @elseif($order->status == 'processing')
                                                <span
                                                    class="badge badge-pill badge-info">{{trans('Processing')}}</span>
                                            @elseif($order->status == 'progress')
                                                <span
                                                    class="badge badge-pill badge-warning">{{trans('In progress')}}</span>
                                            @elseif($order->status == 'completed')
                                                <span
                                                    class="badge badge-pill badge-success">{{trans('Completed')}}</span>
                                            @elseif($order->status == 'partial')
                                                <span
                                                    class="badge badge-pill badge-warning">{{trans('Partial')}}</span>
                                            @elseif($order->status == 'canceled')
                                                <span
                                                    class="badge badge-pill badge-danger">{{trans('Canceled')}}</span>
                                            @elseif($order->status == 'refunded')
                                                <span
                                                    class="badge badge-pill badge-danger">{{trans('Refunded')}}</span>
                                            @endif

                                            @if(isset($order->refill_status) && ($order->refill_status != 'completed' || $order->refill_status != 'partial' || $order->refill_status != 'canceled' || $order->refill_status != 'refunded'))
                                                <p class="badge badge-pill badge-warning">{{trans('Refilling')}}</p>
                                            @endif
                                        </td>
                                        <td>

                                            @if(optional($order->service)->service_status == 1)
                                                <button type="button"
                                                        class="btn btn-sm btn-success orderBtn" data-toggle="modal"
                                                        data-target="#description" id="details"
                                                        data-service_id="{{$order->service_id}}"
                                                        data-servicetitle="{{optional($order->service)->service_title}}"
                                                        data-description="{{optional($order->service)->description}}"
                                                        title="@lang('Order')"
                                                >
                                                    <i class="fa fa-cart-plus"></i>
                                                </button>
                                            @endif

                                            @if($order->reason)
                                                <button type="button"
                                                        data-reason="{{$order->reason}}"
                                                        class="btn btn-sm btn-info infoBtn" data-toggle="modal"
                                                        data-target="#infoModal"
                                                        title="@lang('Reason')"
                                                ><i class="fa fa-info"></i>
                                                </button>
                                            @endif


                                            @if($order->status == 'completed' && 0 < $order->remains   && optional($order->service)->refill == 1 &&  ($order->refilled_at == null || Carbon\Carbon::parse($order->refilled_at) < Carbon\Carbon::now()->subHours(24)) && (!isset($order->refill_status)  || $order->refill_status == 'completed' || $order->refill_status == 'partial' || $order->refill_status == 'canceled' || $order->refill_status == 'refunded'))
                                                <button type="button"
                                                        data-toggle="modal"
                                                        data-target="#refillModal"
                                                        class="btn btn-sm btn-info refilOrderBtn"
                                                        data-route="{{ route('user.order.refill',[$order->id])}}"
                                                        title="@lang('Refill')">
                                                    <i class="fas fa-undo-alt"></i>
                                                </button>
                                            @endif

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center text-danger">@lang('No Data found')</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            {{ $orders->appends($_GET)->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="infoModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Note')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="info-reason"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn waves-effect waves-light btn-dark"
                            data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="description">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body" id="servicedescription">
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                    <a href="" type="submit" class="btn btn-primary order-now">@lang('Order Now')</a>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="refillModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Order Refill Confirm')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        ×
                    </button>
                </div>

                <div class="modal-body">
                    <p>@lang("Are you really want to refill this orders")</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('No')</span></button>
                    <form action="" method="post" id="refillConfirm">
                        @csrf
                        @method('put')

                        <button type="submit" class="btn btn-primary "><span>@lang('Yes')</span>
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        'use strict';
        $(document).on('click', '.infoBtn', function () {
            var modal = $('#infoModal');
            var id = $(this).data('service_id');
            var orderRoute = "{{route('user.order.create')}}" + '?serviceId=' + id;
            $('.order-now').attr('href', orderRoute);
            modal.find('.info-reason').html($(this).data('reason'));
        });

        $(document).on('click', '#details', function () {
            var title = $(this).data('servicetitle');
            var id = $(this).data('service_id');

            var orderRoute = "{{route('user.order.create')}}" + '?serviceId=' + id;
            $('.order-now').attr('href', orderRoute);

            var description = $(this).data('description');
            $('#title').text(title);
            $('#servicedescription').html(description);
        });

        $(document).on('click', '.refilOrderBtn', function () {
            let route = $(this).data('route');
            $('#refillConfirm').attr('action', route);
        });
    </script>
@endpush
