<section class="Alert-Message">
	<style type="text/css">
		.close {
			float: right;
			display: inline-block;
			padding: 2px 5px;
			background: #ccc;
		}

		.close:hover {
			float: right;
			display: inline-block;
			padding: 2px 5px;
			background: #fff;
			color: rgba(0,0,0,0);
			cursor: pointer;
		}

	</style>

	@if ($errors->any())
	<div class="alert alert-danger" role="alert">
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>


	@endif

	@if (@isset($status))
	
	<div class="alert alert-success" role="alert">
		<strong>Success!</strong>  {{ $status['status'] }}
	</div>

	@endif

	@if (session('status'))
	<div class="alert alert-success" role="alert">
		<strong>Success!</strong>  {{ session('status') }}
	</div>
	@endif
	


</section>


