@extends('admin.layouts.app')
@section('panel')
<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="las la-sign-in mr-1"></i> Login to Website API
                    </h4>
                </div>
                <form action="{{ $formAction }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Domain</label>
                            <input type="text" class="form-control" placeholder="e.g. https://no1logs.com/" name="domain" />
                        </div>
                        <div class="form-group">
                            <label>API Type</label>
                            <select name="type" class="form-control">
                                <option value="no1logs">No1Logs API</option>
                                <option value="CMSNT">SHOPCLONE5 & SHOPCLONE6 CMSNT</option>
                            </select>
                        </div>
                        <div class="row mt-4 d-none configForm" id="no1logs">
                            <div class="col-md-12">
                                <h6 class="mb-2">No1logs API Config</h6>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>API Token/Key</label>
                                    <input type="text" class="form-control" placeholder="Enter the token in the API section of your No1logs dashboard" name="token"/>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 d-none configForm" id="CMSNT">
                            <div class="col-md-12">
                                <h6 class="mb-2">SHOPCLONE5 & SHOPCLONE6 CMSNT API Config</h6>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Login Username </label>
                                    <input type="text" class="form-control" placeholder="Enter your login name" name="username" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Password')</label>
                                    <input type="text" class="form-control" placeholder="Enter your login password" name="password" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div><!-- card end -->
        </div>


    </div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";

            var type = 'no1logs';
            apiType(type);

            $('select[name=type]').on('change', function() {
                var type = $(this).val();
                apiType(type);
            });

            function apiType(type){
                $('input[name=domain]').attr("placeholder", `e.g. ${type === "no1logs"? "https://no1logs.com" : "https://accsmailer99.com/"}`)
                $('.configForm').addClass('d-none');
                $(`#${type}`).removeClass('d-none'); 
            }

        })(jQuery);

    </script>
@endpush
