<!--top value bar-->
<div class="container">
    <div class="row mt-5">
        <div class="col-lg-6">
            @if (last(request()->segments()) == 'live')
            <h3 id="status_title">Live Advert</h3>
            @elseif (last(request()->segments()) == 'expired')
            <h3 id="status_title">Expired Advert</h3>
            @elseif (last(request()->segments()) == 'draft')
            <h3 id="status_title">Draft Advert</h3>
            @else
            <h3 id="status_title">All Advert</h3>
            @endif
        </div>

        <div class="col-lg-6 text-right-status">
            <div class="all-status">
                <a class="all-view status-bx" href="{{ URL::to('my-ads/') }}">
                    <strong>All: </strong><span>{{ $totalCount }}</span>
                </a>
                <a class="all-live status-bx" href="{{ URL::to('my-ads/live') }}">
                    <i class="fas fa-circle active-ad" aria-hidden="true"></i> <strong>Live: </strong><span>{{ $countLiveAds }}</span>
                </a>
                <a class="all-view status-bx" href="{{ URL::to('my-ads/expired') }}">
                    <i class="fas fa-circle expired-ad" aria-hidden="true"></i> <strong>Expired: </strong><span>{{ $countExpiredAds }}</span>
                </a>
                <a class="all-view status-bx" href="{{ URL::to('my-ads/draft') }}">
                    <i class="fas fa-circle draft-ad" aria-hidden="true"></i> <strong>Draft: </strong><span>{{ $countDraftAds }}</span>
                </a>
            </div> 
        </div>
    </div>
</div>
<!--top value bar end-->