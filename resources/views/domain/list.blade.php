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

					<!-- Create Table of Domains -->
					@if (!empty($response))
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Domain Name</th>
								<th>Domain Rank</th>
							</tr>
						</thead>
						<tbody>
						@foreach ($response as $domain)
							<tr>
								<td>{{ $domain->domain }}</td>
								<td>{{ $domain->rank }}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
					@else
						<h2>No Records Found!</h2>
					@endif
					<br>
					<!-- Search Again Button -->
					<div>
						<div>
							<a href="/index" class="btn btn-default"><i class="fa fa-btn fa-search"></i>Search Again!</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection