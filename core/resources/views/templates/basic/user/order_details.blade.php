@extends($activeTemplate.'layouts.master')

@section('content')
<div class="row align-items-end mb-4">
    <div class="col-xl-8 col-md-9">
        <div class="account-info mb-2">
            <span class="fw-bold">@lang('Category:')</span> {{ @$orderItems->first()->product->category->name }}
        </div>                            
        <div  class="account-info">
            <span class="fw-bold">@lang('Product:')</span> {{ @$orderItems->first()->product->name }}
        </div> 
    </div>
    <div class="col-xl-4 col-md-3">
        <div class="account-info-btn text-end">
            <a href="{{ route('user.orders') }}" class="btn btn--base">@lang('Back')</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table--responsive--md custom--table">
                <thead>
                    <tr>
                        <th>@lang('SL')</th>
                        <th>@lang('Account')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orderItems as $item)
                        <tr>
                            <td>
                                <span>{{ $loop->iteration }}</span>
                            </td>
                            <td>
                                <span>@php echo nl2br(@$item->productDetail->details) @endphp</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ paginateLinks($orderItems) }}
    </div>
</div>
<div class="container mt-5">
    <h5 class="mt-4 mb-4">Watch Our Videos</h5>
    <div class="row g-4">
        <div class="col-md-6 mb-4">
            <div class="video-wrapper">
                <iframe width="100%"
                    src="https://www.youtube.com/embed/R41_SXiMs8Q?si=6GOID4gr5zVcA1vo" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
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
        </div>
    </div>
</div>
@endsection