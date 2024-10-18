@php
    $banner = getContent('banner.content', true);
    $bannerIcon = getContent('banner_icon.content', true);
@endphp
<!--<section class="banner-section">
    <div class="banner-section-bg-img">
        <img src="{{ asset($activeTemplateTrue . 'images/banner-bg.png') }}" alt="">
    </div>
    <div class="banner-ac-imgs animated"> 
        <span class="ac-img animated"><img src="{{ getImage('assets/images/frontend/banner_icon/' . @$bannerIcon->data_values->one, '35x35') }}" alt=""></span>
        <span class="ac-img animated"><img src="{{ getImage('assets/images/frontend/banner_icon/' . @$bannerIcon->data_values->two, '35x35') }}" alt=""></span>
        <span class="ac-img animated"><img src="{{ getImage('assets/images/frontend/banner_icon/' . @$bannerIcon->data_values->three, '35x35') }}" alt=""></span>
        <span class="ac-img animated"><img src="{{ getImage('assets/images/frontend/banner_icon/' . @$bannerIcon->data_values->four, '35x35') }}"" alt=""></span>
        <span class="ac-img animated"><img src="{{ getImage('assets/images/frontend/banner_icon/' . @$bannerIcon->data_values->five, '35x35') }}" alt=""></span>
        <span class="ac-img animated"><img src="{{ getImage('assets/images/frontend/banner_icon/' . @$bannerIcon->data_values->six, '35x35') }}" alt=""></span>
        <span class="ac-img animated"><img src="{{ getImage('assets/images/frontend/banner_icon/' . @$bannerIcon->data_values->seven, '35x35') }}" alt=""></span>
        <span class="ac-img animated"><img src="{{ getImage('assets/images/frontend/banner_icon/' . @$bannerIcon->data_values->eight, '35x35') }}" alt=""></span>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8"> 
                <div class="banner-content text-center">
                    <h1 class="banner-content__title">{{ __(@$banner->data_values->heading) }}</h1>
                    <p class="banner-content__desc">{{ __(@$banner->data_values->description) }}</p>
                    <ul class="banner-category-list">
                        @foreach($categories->take(7) as $category)
                            <li class="item">
                                <a href="{{ route('category.products', ['slug'=>slug($category->name), 'id'=>$category->id]) }}" class="link">{{ __($category->name) }}</a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="banner-content__buttons flex-center">    
                        <a href="{{ @$banner->data_values->first_button_url }}" class="btn btn--base">
                            {{ __(@$banner->data_values->first_button_name) }}
                        </a>
                        <a href="{{ @$banner->data_values->second_button_url }}"  class="btn btn-outline--base">
                            {{ __(@$banner->data_values->second_button_name) }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>-->
<section class="hero__area hero__height d-flex align-items-center" style="background-color: #eeedf2;">
    <div class="hero__shape">
        <img class="circle" src="{{ asset('assets/images/frontend/banner/hero-circle.png') }}" alt="circle">
        <img class="square" src="{{ asset('assets/images/frontend/banner/hero-square.png') }}" alt="circle">
    </div>
    <div class="container">
        <div class="row py-5 py-lg-0">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="hero__content">
                    <h2 class="hero__title">
                        Buy Premium
                        Social Media
                        Accounts
                        <span>with No1logs</span>
                    </h2>
                    <p>Unlock the Power of Established Social Media Presence with NO 1 Logs</p>
                    <div class="hero__search">
                        <form action="#" class="search-form">
                            <div class="hero__search-inner d-flex">
                                <div class="hero__search-input">
                                    <span><i class="las la-search"></i></span>
                                    <input type="text" placeholder="Search...">
                                </div>
                                <button type="submit" class="btn btn--new-base ml-20">Search</button>
                            </div>
                        </form>
                    </div>
                    <div class="banner-content__buttons mt-5">    
                        <a href="{{ @$banner->data_values->first_button_url }}" class="btn btn--new-base">
                            {{ __(@$banner->data_values->first_button_name) }}
                        </a>
                        <a href="{{ @$banner->data_values->second_button_url }}"  class="btn btn-outline--base">
                            {{ __(@$banner->data_values->second_button_name) }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 mt-5 mt-lg-0">
                <div class="hero__thumb-wrapper scene ml-70">
                    <div class="hero__thumb one">
                        <img class="layer" src="{{ asset('assets/images/frontend/banner/hero.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
