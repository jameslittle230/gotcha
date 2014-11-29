@extends('default')

@section('content')
	<section class="target">
		<span>Your target is:</span> {{{ $target_name }}}

		<!-- <a href="#help" class="panel__help" data-help="target">?</a> -->
	</section>

	<div class="row">
		<section class="game-actions__panel">
			<p>Your code is:</p>
			<p class="panel__code">{{{ $your_code }}}</p>
			<p class="panel__info">Give this code to the person who tags you.</p>

			<!-- <a href="#help" class="panel__help" data-help="form">?</a> -->
		</section>

		<section class="game-actions__panel">
			<h1>Hold your horses.</h1>
			<p>Gotcha isn't active at this time. Either school isn't in session, or Gotcha hasn't even started yet, or there's another circumstance that's preventing us from showing anything to you.</p>
		</section>
	</div>
@stop