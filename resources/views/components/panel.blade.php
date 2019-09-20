<div class="card card-defaut mb-4">
	@if(isset($title))<h4 class="card-header">{{ $title }}</h4>@endif
	<div class="card-body">
		{{ $slot }}
	</div>
</div>