@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="col-sm-offset-2 col-sm-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					Domain Creation Panel
				</div>

				<div class="panel-body">
					<!-- Display Validation Errors -->
					@include('common.errors')

					@if (Auth::user()->group_id == 2)
					<!-- New Domain Creation Form -->
					<form action="/domain/create" method="POST" class="form-horizontal">
						{{ csrf_field() }}

						<!-- Domain -->
						<div class="form-group">
							<label for="domain" class="col-sm-3 control-label">Domain</label>

							<div class="col-sm-6">
								<input type="text" name="domain" class="form-control">
							</div>
						</div>

						<!-- Rank -->
						<div class="form-group">
							<label for="rank" class="col-sm-3 control-label">Rank</label>

							<div class="col-sm-6">
								<input type="text" name="rank" class="form-control">
							</div>
						</div>

						<div class="col-sm-offset-3 col-sm-6">
							<h5>Note: Rank value must be above 500.</h5>
						</div>

						<!-- Create Record Button -->
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-6">
								<button type="submit" class="btn btn-default">
									<i class="fa fa-btn fa-upload"></i>Create Record
								</button>
							</div>
						</div>
					</form>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection