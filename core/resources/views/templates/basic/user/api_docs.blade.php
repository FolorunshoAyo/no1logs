@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="container"> 
        <div class="row my-3">
            <div class="col-md-12">
                <div class="card api-details">
                    <h5 class="card-title text-white d-flex align-items-center justify-content-between">@lang('API Key')
                        <button type="button" class="btn btn-secondary btn-sm  text-white generateBtn">@lang('Generate Key')</button>
                    </h5>
                    <div class="card-body">
                        <div class="form-group content">
                            <h6 class="font-weight-bold mb-1">@lang('API KEY')</h6>
                            <div class="input-group">
                                <input type="text" value="{{ $api_token }}"
                                    class="form-control form-control-lg api-token" id="referralURL" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text copytext copyBoard" id="copyBoard">
                                        <i class="fa fa-copy"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--API DETAILS-->
    <div class="container ">
        <div class="row">
            <div class="col-md-12">
                <div class="card api-details">
                    <h5 class="card-title text-white">API DETAILS</h5>
                    <div class="card-body content">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6>@lang('API URL')</h6>
                                <p>{{ route('api.index') }}</p>
                            </div>
                            <div class="col-sm-12">
                                <h6>@lang('API KEY')</h6>
                                <p>
                                    @lang('Your API Key')
                                </p>
                            </div>
                            <div class="col-sm-12">
                                <h6>@lang('RESPONSE FORMAT')</h6>
                                <p>@lang('JSON')</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- VIEW PRODUCTS -->
    <div class="container ">
        <div class="row">
            <div class="col-md-12">
                <div class="card api-details mb-0">
                    <h5 class="card-title text-white">GET ALL PRODUCTS</h5>
                    <div class="card-body content">
                        <div class="row">
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">@lang('URL')</h6>
                                <p>{{ route('api.products') }}</p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">HTTP METHOD</h6>
                                <p>
                                    GET
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">api_token</h6>
                                <p>Your Api Key (required)</p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">search</h6>
                                <p>For Filtering(optional)</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="api-code mt-2 mb-5">
                    <p class="text-success">//Example response</p>
                    <pre class="text-white">
[
    {
        "id": 17,
        "name": "EUROPE FACEBOOK",
        "products": [
            {
                "id": 15,
                "name": "European countries 🇨🇦🇩🇪🇧🇷🇫🇷🇲🇽🇹🇷50-1000 friends",
                "image": "663470427f5db1714712642.jpg",
                "description": "Some Description 1",
                "in_stock": 21,
                "price": "3500.00000000"
            },
            {
                "id": 4,
                "name": "European Countries|0-100 | email/pass/facebookpass/username",
                "image": "66310ce8332581714490600.png",
                "description": "\u003Cbr /\u003E",
                "in_stock": 12,
                "price": "2300.00000000"
            }
        ]
    },
    {
        "id": 18,
        "name": "FACEBOOK DATING {ASIA COUNTRIES}",
        "products": [
            {
                "id": 13,
                "name": "Vietnam 🇻🇳 FB DATING | male&female. Activate Dating Profile",
                "image": "66346e80afbd41714712192.jpg",
                "description": "Some Description 2",
                "in_stock": 2,
                "price": "12500.00000000"
            }
        ]
    }
]
                    </pre>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Products -->
    <div class="container ">
        <div class="row">
            <div class="col-md-12">
                <div class="card api-details mb-0">
                    <h5 class="card-title text-white">GET SINGLE PRODUCT</h5>
                    <div class="card-body content">
                        <div class="row">
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">@lang('URL')</h6>
                                <p>{{ route('api.category.products') }}/:id</p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">HTTP METHOD</h6>
                                <p>
                                    GET
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">api_token</h6>
                                <p>Your Api Key (required)</p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">id</h6>
                                <p>product id (required)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="api-code mt-2 mb-5">
                    <p class="text-success">//Example response</p>
                    <pre class="text-white">
{
    "id": 17,
    "category_name": "EUROPE FACEBOOK",
    "products": [
        {
        "id": 15,
        "name": "European countries 🇨🇦🇩🇪🇧🇷🇫🇷🇲🇽🇹🇷50-1000 friends",
        "image": "663470427f5db1714712642.jpg",
        "description": "Some Description 1",
        "in_stock": 21,
        "price": "3500.00000000"
        },
        {
        "id": 4,
        "name": "European Countries|0-100 | email/pass/facebookpass/username",
        "image": "66310ce8332581714490600.png",
        "description": "Some Description 2",
        "in_stock": 12,
        "price": "2300.00000000"
        }
    ]
}
                    </pre>
                </div>

            </div>
        </div>
    </div>



    <!-- PRODUUCT DETAILS -->
    <div class="container ">
        <div class="row">
            <div class="col-md-12">
                <div class="card api-details mb-0">
                    <h5 class="card-title text-white">GET PRODUCT Details</h5>
                    <div class="card-body content">
                        <div class="row">
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">@lang('URL')</h6>
                                <p>{{ route('api.product.details') }}/:id</p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">HTTP METHOD</h6>
                                <p>
                                    GET
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">api_token</h6>
                                <p>Your Api Key (required)</p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">id</h6>
                                <p>for specific product id (required)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="api-code mt-2 mb-5">
                    <p class="text-success">//Example response</p>
                    <pre class="text-white">
{
    "product": {
        "id": 15,
        "product_name": "European countries 🇨🇦🇩🇪🇧🇷🇫🇷🇲🇽🇹🇷50-1000 friends"
    },
    "accounts": [
        {
        "id": 1430,
        "url": "https://facebook/12345678"
        },
        {
        "id": 1429,
        "url": "https://facebook/12345678"
        },
        {
        "id": 1428,
        "url": "https://facebook/12345678"
        },
        {
        "id": 1427,
        "url": "https://facebook/12345678"
        },
        {
        "id": 1426,
        "url": "https://facebook/12345678"
        }
    ]
}
                    </pre>
                </div>

            </div>
        </div>
    </div>

    <!--NEW ORDER-->
    <div class="container ">
        <div class="row">
            <div class="col-md-12">
                <div class="card api-details mb-0">
                    <h5 class="card-title text-white">PLACE ORDER</h5>
                    <div class="card-body content">
                        <div class="row">
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">@lang('URL')</h6>
                                <p>{{ route('api.new.order') }}?api_token={apiKey}</p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">HTTP METHOD</h6>
                                <p>
                                    POST
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">product_details_ids</h6>
                                <p>A comma separated string of account ids (required)</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="api-code mt-2 mb-5">
                    <p class="text-success">//Example response</p>
                    <pre class="text-white">
{
    "status": "success",
    "order": {
        "id": 1,
        "category_name": "Europe Facebook",
        "product_name": "European countries 🇨🇦🇩🇪🇧🇷🇫🇷🇲🇽🇹🇷50-1000 friends",
        "order_items": [
            {
                "id": 1430,
                "details": "Username:username | Password:username",
                "url": "https://facebook/12345678"
            },
            {
                "id": 1429,
                "details": "Username:username | Password:username",
                "url": "https://facebook/12345678"
            },
            {
                "id": 1428,
                "details": "Username:username | Password:username",
                "url": "https://facebook/12345678"
            },
            {
                "id": 1427,
                "details": "Username:username | Password:username",
                "url": "https://facebook/12345678"
            },
            {
                "id": 1426,
                "details": "Username:username | Password:username",
                "url": "https://facebook/12345678"
            }
        ]
    },
}
                    </pre>
                </div>
            </div>
        </div>
    </div>

    <div class="container ">
        <div class="row">
            <div class="col-md-12">
                <div class="card api-details mb-0">
                    <h5 class="card-title text-white">GET ORDER DETAILS</h5>
                    <div class="card-body content">
                        <div class="row">
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">@lang('URL')</h6>
                                <p>{{ route('api.new.order') }}</p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">HTTP METHOD</h6>
                                <p>
                                    GET
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">api_token</h6>
                                <p>Your Api Key (required)</p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">id</h6>
                                <p>for specific order id (required)</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="api-code mt-2 mb-5">
                    <p class="text-success">//Example response</p>
                    <pre class="text-white">
{
    "id": 74,
    "category_name": "Europe Facebook",
    "product_name": "European countries 🇨🇦🇩🇪🇧🇷🇫🇷🇲🇽🇹🇷50-1000 friends",
    "order_items": [
        {
            "id": 948,
            "details": "Username:username | Password:username",
            "url": ""
        },
        {
            "id": 949,
            "details": "Username:username | Password:username",
            "url": "https://facebook.com/12345678"
        }
    ]
}
                    </pre>
                </div>
            </div>
        </div>
    </div>    

    <!--USER BALANCE-->
    <div class="container ">
        <div class="row">
            <div class="col-md-12">
                <div class="card api-details mb-0">
                    <h5 class="card-title text-white">GET USER BALANCE</h5>
                    <div class="card-body content">
                        <div class="row">
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">@lang('URL')</h6>
                                <p>{{ route('api.balance') }}</p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">HTTP METHOD</h6>
                                <p>
                                    GET
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-lowercase">api_token</h6>
                                <p>Your Api Key (required)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="api-code mt-2 mb-5">
                    <p class="text-success">//Example response</p>
                    <pre class="text-white">
{
    "status": "success",
    "balance": "9000.00"
}
                    </pre>
                </div>

            </div>
        </div>
    </div>
@endsection
