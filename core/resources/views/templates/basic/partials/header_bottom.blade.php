<header class="header" id="header">
    <div class="container">
        <!--<nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logo d-lg-none d-block" href="{{ route('home') }}">
                <img src="{{ getImage(getFilePath('logoIcon') . '/dark_logo.png') }}" alt="@lang('image')">
            </a>
            {{--
            <button type="submit" class="search-box-popup-btn d-none">
                <i class="las la-search"></i>
            </button> --}}

            <div class="search-box style-two w-100 d-lg-none d-block">
                <form action="" class="search-form">
                    <input type="text" class="form--control pill exclude" name="search" placeholder="Search..." id="mobile-search" @if (request()->routeIs('products') || request()->routeIs('category.products')) value="{{ request()->search }}" @endif>
                    <button type="submit" class="search-box__button">
                        <span class="icon"><i class="las la-search"></i></span>
                    </button>
                </form>
            </div>

            @if ($categories->count())
                <div class="category-nav">
                    <button class="category-nav__button">
                        <span class="icon me-1"><img src="{{ asset($activeTemplateTrue . 'images/icons/grid.png') }}" alt="@lang('image')"></span><span class="search-text">@lang(' Category')</span>
                        <span class="arrow"><i class="las la-angle-down"></i></span>
                    </button>
                    <ul class="dropdown--menu">
                        @foreach ($categories as $category)
                            <li class="dropdown--menu__item">
                                <a href="{{ route('category.products', ['slug' => slug($category->name), 'id' => $category->id]) }}" class="dropdown--menu__link">
                                    {{ strLimit($category->name, 18) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <button class="navbar-toggler header-button" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span id="hiddenNav"><i class="las la-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-menu ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('home') }}">@lang('Home')</a>
                    </li>

                    @php
                        $pages = App\Models\Page::where('tempname', $activeTemplate)
                            ->where('is_default', Status::NO)
                            ->get();
                    @endphp

                    @foreach ($pages as $k => $data)
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a>
                        </li>
                    @endforeach

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products') }}">@lang('Product')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog') }}">@lang('Blog')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">@lang('Contact')</a>
                    </li>
                    <li class="nav-item d-lg-none d-flex justify-content-between align-items-end">
                        <div class="accounts-buttons d-flex align-items-center">
                            @auth
                                <a href="{{ route('user.logout') }}" class="accounts-buttons__link">
                                    <span class="icon fs-14 me-1"><i class="fas fa-sign-out-alt"></i></span>@lang('Logout')
                                </a>
                            @else
                                <a href="{{ route('user.login') }}" class="accounts-buttons__link">
                                    <span class="icon fs-14 me-1"><i class="fas fa-sign-in-alt"></i></span> @lang('Login')
                                </a>
                            @endauth

                            @auth
                                <a href="{{ route('user.home') }}" class="btn btn--base btn--sm">
                                    <span class="icon fs-14 me-1"><i class="fas fa-home"></i></span> @lang('Dashboard')
                                </a>
                            @else
                                <a href="{{ route('user.register') }}" class="btn btn--base btn--sm">
                                    <span class="icon fs-14 me-1"><i class="fas fa-user-plus"></i></span> @lang('Register')
                                </a>
                            @endauth
                        </div>
                        @if ($general->multi_language)
                            @php
                                $language = App\Models\Language::all();
                            @endphp
                            <div class="language-box">
                                <select class="langSel form-control form-select">
                                    <option value="">@lang('Select One')</option>
                                    @foreach ($language as $item)
                                        <option value="{{ $item->code }}" @if (session('lang') == $item->code) selected @endif>{{ __($item->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </li>
                </ul>
            </div>
        </nav>-->
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logo d-block" href="{{ route('home') }}">
                <img src="{{ getImage(getFilePath('logoIcon') . '/dark_logo.png') }}" alt="@lang('image')">
            </a>

            <!-- <div class="search-box style-two w-100 d-lg-none d-block">
                <form action="" class="search-form">
                    <input type="text" class="form--control pill exclude" name="search" placeholder="Search..." id="mobile-search" @if (request()->routeIs('products') || request()->routeIs('category.products')) value="{{ request()->search }}" @endif>
                    <button type="submit" class="search-box__button">
                        <span class="icon"><i class="las la-search"></i></span>
                    </button>
                </form>
            </div> -->

            <div class="d-lg-none d-block d-flex align-items-center">
                <a href="#" type="button" class="search-box-popup-button">
                    <i class="las la-search"></i>
                </a>

                <button id="mobile-nav-button" class="navbar-toggler header-button" type="button">
                    <span id="hiddenNav"><i class="las la-bars"></i></span>
                </button>
            </div>

            <div class="d-lg-block d-none">
                <div class="navbar-links">
                    <ul class="navbar-nav nav-menu ms-auto align-items-lg-center">
                        @php
                            $pages = App\Models\Page::where('tempname', $activeTemplate)
                                ->where('is_default', Status::NO)
                                ->get();
                        @endphp

                        @foreach ($pages as $k => $data)
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a>
                            </li>
                        @endforeach
                        @if ($categories->count())
                            <li class="nav-item">
                                <div class="category-nav">
                                    <button class="category-nav__button">
                                    <!-- <span class="icon me-1"><img src="{{ asset($activeTemplateTrue . 'images/icons/grid.png') }}" alt="@lang('image')"></span>--><span class="search-text">@lang(' Category')</span>
                                        <span class="arrow"><i class="las la-angle-down"></i></span>
                                    </button>
                                    <ul class="dropdown--menu">
                                        @foreach ($categories as $category)
                                            <li class="dropdown--menu__item">
                                                <a href="{{ route('category.products', ['slug' => slug($category->name), 'id' => $category->id]) }}" class="dropdown--menu__link">
                                                    <!-- {{ strLimit($category->name, 18) }} -->
                                                    {{ $category->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('api.contact') }}">@lang('API')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products') }}">@lang('Product')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('blog') }}">@lang('Blog')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">@lang('Contact')</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="d-lg-block d-none">
                <div class="d-flex align-items-center justify-content-end">
                    <a href="#" type="button" class="search-box-popup-button">
                        <i class="las la-search"></i>
                    </a>
                    <div class="accounts-buttons d-flex align-items-center">
                        @auth
                            <a href="{{ route('user.logout') }}" class="accounts-buttons__link">
                                <span class="icon fs-14 me-1"><i class="fas fa-sign-out-alt"></i></span>@lang('Logout')
                            </a>
                        @else
                            <a href="{{ route('user.login') }}" class="accounts-buttons__link">
                                <span class="icon fs-14 me-1"><i class="fas fa-sign-in-alt"></i></span> @lang('Login')
                            </a>
                        @endauth

                        @auth
                            <a href="{{ route('user.home') }}" class="btn btn--new-base btn--sm">
                                <span class="icon fs-14 me-1"><i class="fas fa-home"></i></span> @lang('Dashboard')
                            </a>
                        @else
                            <a href="{{ route('user.register') }}" class="btn btn--new-base btn--sm">
                                <span class="icon fs-14 me-1"><i class="fas fa-user-plus"></i></span> @lang('Register')
                            </a>
                        @endauth
                    </div>
                    @if ($general->multi_language)
                        @php
                            $language = App\Models\Language::all();
                        @endphp
                        <div class="language-box">
                            <select class="langSel form-control form-select">
                                <option value="">@lang('Select One')</option>
                                @foreach ($language as $item)
                                    <option value="{{ $item->code }}" @if (session('lang') == $item->code) selected @endif>{{ __($item->code) }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
            </div>
        </nav>
        @if (request()->routeIs('product.details'))
            <style>
                .selected {
                    background-color: green !important; 
                    color: white; 
                }
            </style>
            <div class="fixed-card mt-3 py-2">
                <div class="card mb-3">
                    <div class="card-header">
                        Selected Products
                    </div>
                    <div class="card-body p-2"> <!-- Reduced padding -->
                        <div class="d-flex justify-content-between align-items-center mb-2"> <!-- Reduced margin -->
                            <div>Total Products:</div>
                            <div class="font-weight-bold"><span id="totalProductCount">0</span></div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>Total Price:</div>
                            <div class="font-weight-bold"><span id="totalPrice">0.00 NGN</span></div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end mb-0">
                    <div class="col-md-4 text-end">
                        <button class="btn btn--base btn--sm purchaseBtn">
                            <i class="las la-shopping-cart "></i> <span class="purchaseBtn-text">Purchase</span> 
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</header>
<div id="search" class="modal header-modal search-modal fade" role="dialog" aria-labelledby="search" aria-hidden="true">
	<div class="modal-dialog modal-dialog-slideout" role="document">
		<div class="modal-content full">
			<div class="modal-header" data-bs-dismiss="modal">
				Search <i class="la la-times-circle-o"></i>
			</div>
			<div class="modal-body">
				<form class="search-form" role="search" action="" class="row gx-0">
					<div class="col-12 p-0 align-self-center">
							<div class="p-0 pb-3">
								<h2 class="m-0">What are you looking for?</h2>
							</div>
							<div class="pb-03 form-group">
								<input type="text" name="search" id="mobile-search" @if (request()->routeIs('products') || request()->routeIs('category.products')) value="{{ request()->search }}" @endif class="form--control" placeholder="Enter Keywords">
							</div>
							<div class="p-0 form-group">
								<button type="submit" class="btn btn--new-base btn--lg">Search</button>
						    </div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div id="menu" class="modal header-modal menu-modal fade" role="dialog" aria-labelledby="search" aria-hidden="true">
	<div class="modal-dialog modal-dialog-slideout" role="document">
		<div class="modal-content full">
			<div class="modal-header" data-bs-dismiss="modal">
				Menu <i class="la la-times-circle-o"></i>
			</div>
            <div class="modal-body d-block">
                <div class="navbar-links">
                    <ul class="navbar-nav nav-menu ms-auto align-items-lg-center">
                        @php
                            $pages = App\Models\Page::where('tempname', $activeTemplate)
                                ->where('is_default', Status::NO)
                                ->get();
                        @endphp

                        @foreach ($pages as $k => $data)
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a>
                            </li>
                        @endforeach
                        @if ($categories->count())
                            <li class="nav-item">
                                <div class="category-nav">
                                    <button class="category-nav__button nav-link">
                                    <!-- <span class="icon me-1"><img src="{{ asset($activeTemplateTrue . 'images/icons/grid.png') }}" alt="@lang('image')"></span>--><span class="search-text">@lang(' Category')</span>
                                        <span class="arrow"><i class="las la-angle-down"></i></span>
                                    </button>
                                    <ul class="dropdown--menu">
                                        @foreach ($categories as $category)
                                            <li class="dropdown--menu__item">
                                                <a href="{{ route('category.products', ['slug' => slug($category->name), 'id' => $category->id]) }}" class="dropdown--menu__link">
                                                    <!--{{ strLimit($category->name, 18) }}-->
                                                    {{ $category->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products') }}">@lang('Product')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('blog') }}">@lang('Blog')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">@lang('Contact')</a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex align-items-center">
                    <div class="accounts-buttons d-flex align-items-center">
                        @auth
                            <a href="{{ route('user.logout') }}" class="accounts-buttons__link">
                                <span class="icon fs-14 me-1"><i class="fas fa-sign-out-alt"></i></span>@lang('Logout')
                            </a>
                        @else
                            <a href="{{ route('user.login') }}" class="accounts-buttons__link">
                                <span class="icon fs-14 me-1"><i class="fas fa-sign-in-alt"></i></span> @lang('Login')
                            </a>
                        @endauth

                        @auth
                            <a href="{{ route('user.home') }}" class="btn btn--new-base btn--sm">
                                <span class="icon fs-14 me-1"><i class="fas fa-home"></i></span> @lang('Dashboard')
                            </a>
                        @else
                            <a href="{{ route('user.register') }}" class="btn btn--new-base btn--sm">
                                <span class="icon fs-14 me-1"><i class="fas fa-user-plus"></i></span> @lang('Register')
                            </a>
                        @endauth
                    </div>
                    @if ($general->multi_language)
                        @php
                            $language = App\Models\Language::all();
                        @endphp
                        <div class="language-box">
                            <select class="langSel form-control form-select">
                                <option value="">@lang('Select One')</option>
                                @foreach ($language as $item)
                                    <option value="{{ $item->code }}" @if (session('lang') == $item->code) selected @endif>{{ __($item->code) }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
            </div>
		</div>
	</div>
</div>


@push('style')
    <style>
        @media screen and (max-width:992px) {
            .navbar {
                gap: 20px;
            }

            .navbar-brand {
                flex: 1 1 calc(77% - 40px);
            }

            .search-box {
                order: 4;
                width: auto !important;
                max-width: unset !important;
                flex: 1 1 50%;
            }

            /* .category-nav {
                width: 26%;
                order: 3;
                min-width: max-content;
                text-align: left;
            } */

            .category-nav{
               min-width: 100%;
                text-align: left;
                margin-left: 0;
            }   

            #menu .navbar-links .nav-item .nav-link{
                font-size: 1.5rem;
                font-weight: initial;
                width: 100%;
            }

            .dropdown--menu{
                display: none;
                position: static;
                height: auto;
                background-color: transparent;
                width: 100%;
                padding: 8px 0;
                box-shadow: none;
                border-radius: 0px;
                transform-origin: center top;
                transform: scaleY(0);
                transition: 0.2s ease-in-out;
                z-index: 9999;
            }

            .dropdown--menu.active{
                display: block;
            }
        }

        .search-box-popup-button{
            font-weight: 600;
            font-size: 20px;
            color: hsl(var(--heading-color)) !important;
            padding: 24px 0;
            position: relative;
            margin-right: 15px;
            cursor: pointer;
            font-size: 1.2rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out;
        }

        .search-box-popup-button:hover{
            color: hsl(var(--base)) !important;
        }

        .search-modal .modal-header i,
        .menu-modal .modal-header i{
            font-size: 24px;
            cursor: pointer;
        }

        .search-modal .search-form{
            flex: 1 0 0%;
        }

        .langSel{
            border-radius: 50px;
            padding: 4px 10px;
            width: 60px;
        }

        .accounts-buttons__link{
            color: hsl(var(--base)) !important;
        }

        .accounts-buttons a{
            position: relative;
            margin-right: 15px;
        }

        .accounts-buttons a:first-child{
            padding-right: 15px;
        }

        .accounts-buttons a:first-child::after {
            position: absolute;
            content: "";
            right: 0;
            top: 50%;
            -webkit-transform: translateY(-50%);
            -moz-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            width: 2px;
            height: 18px;
            background: #e7e6ef;
        }

        .navbar .search-box {
            max-width: 100%;
            position: relative;
            top: 100%;
            visibility: visible;
            opacity: 1;
            transition: all ease 250ms;
            z-index: 9;
            margin-top: 0;
        }

        @media screen and (max-width: 470px) {
            .navbar {
                gap: 15px;
                column-gap: 10px;
            }
        }

        @media screen and (max-width: 424px) {
            .dropdown--menu {
                width: 180px;
                left: 0;
                right: 0;
            }
        }

        @media screen and (max-width: 374px) {
            .navbar-brand {
                flex: 1 1 calc(77% - 0px);
            }

            .search-text {
                display: none;
            }

            .category-nav {
                width: 10%;
            }

            .category-nav__button .icon {
                margin-right: 0 !important;
            }

            .category-nav .arrow {
                display: none;
            }
        }
    </style>
@endpush
