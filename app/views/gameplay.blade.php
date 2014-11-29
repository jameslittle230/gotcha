@extends('default')

@section('content')
	<section class="target">
		<span>Your target is:</span> {{{ $target_name }}}

		<!-- <a href="#help" class="panel__help" data-help="target">?</a> -->
	</section>

	<div class="row">

		<!-- <div class="column"> -->
			<section class="game-actions__panel">
				<p>Your code is:</p>
				<p class="panel__code">{{{ $your_code }}}</p>
				<p class="panel__info">Give this code to the person who tags you.</p>

				<!-- <a href="#help" class="panel__help" data-help="form">?</a> -->
			</section>
		<!-- </div> column -->

		<!-- <div class="column"> -->
			<section class="game-actions__panel">
				<p>{{{ $target_first }}}'s two letter code:</p>

				{{ Form::open(['route' => 'tag', 'class' => 'game-form']) }}
				{{ Form::text('code', '', ['maxlength' => '2']) }}
				{{ Form::submit('Submit &rarr;') }}
				{{ Form::close() }}

				<!-- <a href="#help" class="panel__help" data-help="form">?</a> -->
			</section>
		<!-- </div> column -->

	</div> <!-- row -->

	<p class="help"><a href="/rules">What's going on here? I'm still confused.</a></p>
@stop