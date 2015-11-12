@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="col-sm-offset-2 col-sm-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					Domain Search Panel
				</div>

				<div class="panel-body">
					<!-- Display Validation Errors -->
					@include('common.errors')

					<!-- Domain Search Form -->
					<form action="/domain/search" method="POST" class="form-horizontal">
						{{ csrf_field() }}

						<!-- Search Box -->
						<div class="form-group">
							<label for="domains" class="col-sm-3 control-label">Domains</label>

							<div class="col-sm-6">
								<textarea name="domains" rows="10" class="form-control"></textarea>
							</div>
						</div>

						<!-- Search Button -->
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-6">
								<button type="submit" class="btn btn-default">
									<i class="fa fa-btn fa-search"></i>Search
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection