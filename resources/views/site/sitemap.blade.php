<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<?php echo '<?xml-stylesheet type="text/xsl" href="xml-sitemap.xsl"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	@if(!empty($otherpages))
	@php
	$last_change = \Carbon\Carbon::now();
	@endphp
	@foreach($otherpages as $otherpage)
		<url>
            <loc>{{ url('/'.$otherpage) }}</loc>
            <lastmod>{{ $last_change }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
	@endforeach
	@endif

    @if(!empty($pages))
    @foreach($pages as $page)
        <url>
            <loc>{{ url($page->cms_slug) }}</loc>
            <lastmod>{{ $page->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
    @endif

    @if(!empty($ads))
    @foreach($ads as $ad)
        <url>
            <loc>{{ url('details/'.$ad->slug) }}</loc>
            <lastmod>{{ $ad->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
    @endif
</urlset>