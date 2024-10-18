@php
    $about = getContent('about.content', true);
    $aboutElement = getContent('about.element', orderById: true);
@endphp
<!--<section class="about-us py-120">
    <div class="container">
        <div class="row gy-4 align-items-center flex-wrap-reverse">
            <div class="col-lg-6 col-md-10 ">
                <div class="about-us__thumb">
                    <img src="{{ getImage('assets/images/frontend/about/' . @$about->data_values->image, '465x400') }}" alt="@lang('image')">
                </div>
            </div>
            <div class="col-lg-6 pe-xl-5">
                <div class="about-content">
                    <div class="section-heading style-left">
                        <span class="section-heading__subtitle">{{ __(@$about->data_values->heading) }}</span>
                        <h2 class="section-heading__title">{{ __(@$about->data_values->subheading) }}</h2>
                        <p class="section-heading__desc">
                            @php
                                echo @$about->data_values->description;
                            @endphp
                        </p>
                    </div>
                    <ul class="text-list">
                        @foreach ($aboutElement as $item)
                            <li class="text-list__item flex-wrap">
                                <span class="icon"> <i class="fas fa-check-circle"></i> </span>
                                <span class="text fs-15">{{ __(@$item->data_values->title) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>-->
<section class="about-us py-120">
    <div class="container">
        <div class="row gy-4 align-items-center flex-wrap-reverse">
            <div class="col-lg-6 pe-xl-5">
                <div class="about-content">
                    <div class="section-heading style-left">
                        <span class="section-heading__subtitle">About Us</span>
                        <h3 class="section-heading__title">Premium Social Media Service</h3>
                        <p class="section-heading__desc mb-4">Boost your online presence effortlessly and engage with your
                            audience while saving time.</p>
                        <div class="view-stacked shape-square position-left mobile-position-left icon-box">
                            <div class="icon-container">
                                <div class="icon-box-wrapper">
                                    <div class="icon-box-icon">
                                        <span class="icon">
                                            <i class="las la-globe"></i>
                                        </span>
                                    </div>
                                    <div class="icon-box-content">
                                        <h3 class="icon-box-title">
                                            <span>Different Countries</span>
                                        </h3>
                                        <p class="icon-box-description">
                                            Explore a multitude of accounts from various continents.
                                            Ranging From North America to Europe and beyond. 
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="view-stacked shape-square position-left mobile-position-left icon-box">
                            <div class="icon-container">
                                <div class="icon-box-wrapper">
                                    <div class="icon-box-icon">
                                        <span class="icon">
                                            <i class="las la-users"></i>
                                        </span>
                                    </div>
                                    <div class="icon-box-content">
                                        <h3 class="icon-box-title">
                                            <span>Targeted Audience</span>
                                        </h3>
                                        <p class="icon-box-description">
                                            Reach Your Ideal Followers with Precision: Engage the Audience That Matters Most!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="view-stacked shape-square position-left mobile-position-left icon-box">
                            <div class="icon-container">
                                <div class="icon-box-wrapper">
                                    <div class="icon-box-icon">
                                        <span class="icon">
                                            <i class="las la-fire"></i>
                                        </span>
                                    </div>
                                    <div class="icon-box-content">
                                        <h3 class="icon-box-title">
                                            <span>Boosted Followers</span>
                                        </h3>
                                        <p class="icon-box-description">
                                            Skyrocket Your Influence: Gain Authentic Followers and Amplify Your Impact! 
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-10 ">
                <div class="about-us__thumb">
                    <img src="{{ getImage('assets/images/frontend/about/' . @$about->data_values->image, '465x400') }}"
                        alt="@lang('image')">
                </div>
            </div>
        </div>
    </div>
</section>
<section class="steps py-120" style="background-color: #eeedf2;">
    <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="col-lg-5 pe-xl-5">
                <div class="steps-content">
                    <div class="section-heading style-left">
                        <h3 class="section-heading__title">Steps to Purchase Social Media Accounts on No1Logs</h3>
                        <p class="section-heading__desc mb-4">Our onboarding process is simplified into
                            three (3) simple steps, granting easy
                            access for users to purchase premium
                            social media accounts.
                        </p>
                        <div class="mt-2">
                            <button type="submit" class="btn btn--new-base btn--lg">Explore</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-12">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="step-card">
                            <div class="step-card-no">
                                <span>1</span>
                            </div>
                            <div>
                                <h6>Browse and Select an Account:</h6>
                                <p>
                                    Visit No1logs.com and explore our wide range of available social media accounts. Use filters to narrow down your search based on platform, niche, follower count, and engagement levels. Once you find an account that meets your needs, click on it to view detailed information and analytics.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="step-card">
                            <div class="step-card-no">
                                <span>2</span>
                            </div>
                            <div>
                                <h6>Review Account Details:</h6>
                                <p>
                                    After selecting an account, review the provided details carefully to ensure it matches your requirements. Each account listing includes comprehensive information on follower demographics, engagement rates, and account history. This step helps you make an informed decision about the purchase.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="step-card">
                            <div class="step-card-no">
                                <span>3</span>
                            </div>
                            <div>
                                <h6>Complete the Purchase and Transfer:</h6>
                                <p>
                                    Once you're satisfied with the account details, proceed to make the purchase through our secure payment gateway. After the payment is confirmed, our team will assist you in transferring ownership of the account securely and efficiently. Our customer support team is available to guide you through the entire process to ensure a smooth and successful transaction.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
