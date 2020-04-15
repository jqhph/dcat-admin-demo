@extends(\DcatPage\view_name('app'))

@section('content')
<nav id="slide-menu" class="slide-menu" role="navigation">

	<div class="brand">
		<a href="{{ \DcatPage\url('/') }}">
			Dcat Page
		</a>
	</div>

	<ul class="slide-main-nav">
		<li><a href="{{ \DcatPage\url('/') }}">Home</a></li>

		@include(\DcatPage\view_name('partials.main-nav'))
	</ul>

	<div class="slide-docs-nav">
		<h2>Documentation</h2>

		<ul class="slide-docs-version">
			<li>
				<h2>Version</h2>

				<ul>
					<li>
						@if (isset($currentVersion))
							@include(\DcatPage\view_name('partials.switcher'))
						@endif
					</li>
				</ul>
			</li>
		</ul>

		{!! $index !!}
	</div>

</nav>

<div class="docs-wrapper container">

	<section class="sidebar">
		{{--<script async type="text/javascript" src="//cdn.carbonads.com/carbon.js?serve=CKYILK3E&placement=laravelcom" id="_carbonads_js"></script>--}}
		<small><a href="#" id="doc-expand" style="font-size: 11px; color: #B8B8B8;">EXPAND ALL</a></small>
		{!! $index !!}
	</section>

	<article>
		{!! $content !!}

		<div id="comment-container" style="margin-top: 90px"></div>
	</article>

</div>
@endsection
