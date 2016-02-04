<div class="row js-trick-container">
	@if($tricks->count())
		@foreach($tricks as $trick)
			@include('partials.tricks._card',compact('trick'))
		@endforeach
	@else
		<div class="col-lg-12">
			<div class="alert alert-danger">
				There are no tricks to show.				
			</div>
		</div>
	@endif
</div>
@if($tricks->count())
	<div class="row">
	    <div class="col-md-12 text-center">
	    	@if(isset($appends))
	        	{!! $tricks->appends($appends)->links() !!}
	        @else
				{!! $tricks->links() !!}
	        @endif
	    </div>
	</div>
@endif

@section('scripts')
	@if(count($tricks))
		<script src="{{ asset('js/vendor/masonry.pkgd.min.js') }}"></script>
		<script type="text/javascript">
			$(function() {
			    $container = $(".js-trick-container");
			    $container.masonry({
			        gutter: 0,
			        itemSelector: ".trick-card",
			        columnWidth: ".trick-card"
			    });
			    $(".js-goto-trick a").click(function(e) {
			        e.stopPropagation()
			    });
			    $(".js-goto-trick").click(function(e) {
			        e.preventDefault();
			        var base = "{{ route('tricks.show') }}";
			        var slug = $(this).data("slug");
			        window.location = base + "/" + slug;
			    })
			});
		</script>
	@endif
@stop
