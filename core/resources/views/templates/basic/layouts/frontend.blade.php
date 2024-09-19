@extends($activeTemplate . 'layouts.app')

@push('style-lib')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/salert.css') }}">
@endpush

@push('style')
    <!-- SAlert INLINE CSS -->
    <style id="salert-main-css-inline-css" type="text/css">
        #salertWrapper .popup_template {
            background-color: #fff;

            border: 2px solid #e0e0e0;
            border-width: 2px;
            border-radius: 0px;

        }

        #salertWrapper .popup_position {
            width: 350px;
        }


        #salertWrapper .popup_position .salert-content-wrap {
            color: #000;
            font-size: 14px;
            text-transform: none;
        }

        #salertWrapper .popup_position img {
            float: ;
        }

        #salertWrapper .popup-item {
            padding: 10px;
        }

        @media (max-width: 767px) {
            #salertWrapper {
                display: block !important;
            }
        }

        #salertWrapper .popup_template {
            -webkit-box-shadow: 3px 5px 10px 1px rgba(0, 0, 0, 0.38);
            box-shadow: 3px 5px 10px 1px rgba(0, 0, 0, 0.38);
        }
    </style>
@endpush

@section('app')
    @include($activeTemplate . 'partials.header_top')
    @include($activeTemplate . 'partials.header_bottom')

    @if (request()->routeIs('home'))
        @include($activeTemplate . 'sections.banner')
    @endif

    @if (!request()->routeIs('home') && !request()->routeIs('product.details'))
        @include($activeTemplate . 'partials.breadcrumb')
    @endif

    @yield('content')

    <div id="salertWrapper">
        <div class="popup_position bottomRight">
            <div class="popup_box">
                <div class="popup_template animated clearfix" id="popup_template" style="display: none;">
                    <!-- Content will be loaded dynamically through ajax -->
                </div>
            </div>
        </div>
    </div>

    <!--<x-subscribe-modal />-->
    @include($activeTemplate . 'partials.footer')
@endsection
@push('script')
    <script type="text/javascript" id="salert-main-js-js-extra">
        /* <![CDATA[ */
        var salert_settings = {
            "ajax_url": "{{ route('product.order.popup') }}",
            "salert_popup_position": "bottomRight",
            "salert_popup_start_time": "5",
            "salert_popup_transition": "fadeInUp",
            "salert_popup_range_from": "10",
            "salert_popup_range_to": "20",
            "salert_popup_stay": "10"
        };
        /* ]]> */
    </script>
    <script type="text/javascript" src="{{ asset($activeTemplateTrue . 'js/salert.js') }}"></script>
@endpush
