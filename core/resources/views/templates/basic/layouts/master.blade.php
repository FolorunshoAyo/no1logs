@extends($activeTemplate . 'layouts.app')

@section('app')
    @include($activeTemplate . 'partials.header_auth')

    @include($activeTemplate . 'partials.breadcrumb')

    <div class="py-{{ request()->routeIs('user.home') ? '120' : '60' }}">
        <div class="container">
            @yield('content')
        </div>
    </div>

    @include($activeTemplate . 'partials.footer')
    
@endsection


@push('script-lib')
    <script src="{{ asset($activeTemplateTrue.'js/jquery.validate.js') }}"></script> 
@endpush

@push('script')
<script>
    (function($) {
        "use strict"; 

        $('form').on('submit', function () {
            if(!$(this).hasClass('exclude')){
                if ($(this).valid()) {
                    $(':submit', this).attr('disabled', 'disabled');
                }
            }
        });

    })(jQuery);
</script>
<script>
    "use strict";
    $('.copyBoard').on('click', function() {
        var copyText = document.getElementById("referralURL");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        /*For mobile devices*/
        document.execCommand("copy");
        alert("Copied: " + copyText.value);
    });
    $('.generateBtn').on('click', function() {
        var formData = { 
            '_token': "{{ csrf_token() }}",
        }

        $.ajax({
            url: "{{ route('user.generate.key') }}",
            type: 'POST',
            data: formData,
            success(data) {
                $("#referralURL").val(data)

                alert("KEY GENERATE: " + data);

            }
        });
    });
</script>
@endpush