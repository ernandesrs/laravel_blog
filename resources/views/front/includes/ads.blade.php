<div class="d-flex justify-content-center w-100">
    @if ($adsType == 'block')
        {!! \App\Helpers\GoogleAdsense::blockads() !!}
    @elseif($adsType == 'horizontal')
        {!! \App\Helpers\GoogleAdsense::horizontalads() !!}
    @else
        {!! \App\Helpers\GoogleAdsense::inarticleads() !!}
    @endif
</div>
