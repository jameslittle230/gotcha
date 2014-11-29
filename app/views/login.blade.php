@extends('default')

@section('outside')
	<section class="suspended__panel">
		<h1>Gotcha Login</h1>
		<p>Please use your MyMilton username and password.</p>
		{{ Form::open(['route' => 'login']) }}
		<p>Username: {{ Form::text('username') }}</p>
		<p>Password: {{ Form::password('password') }}</p>
		<p>{{ Form::submit('Log In &rarr;') }}</p>
	</section>
@stop