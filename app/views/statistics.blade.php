@extends('default')

@section('content')
	<section class="target">
		{{{ $num_still_in }}}<span> people are still in. <small>({{{ $percent_in }}}%)</small></span>
	</section>

	<section class="game-actions__panel">
		<h1>Leaderboards:</h1>
		<ul>
			@foreach($frequencies as $player => $tags)
				<li>{{{ Player::find($player)->first }}}  {{{ Player::find($player)->last }}}: {{{ $tags }}} tags.</li>
			@endforeach
		</ul>
	</section>

	<div class="row">
		<section class="game-actions__panel">
			<h1>First Five Victims:</h1>
			<ul>
				@foreach($first_five as $victim)
					<li>{{{$victim->first}}} {{{$victim->last}}}</li>
				@endforeach
			</ul>
		</section>

		<section class="game-actions__panel">
			<h1>Latest Five Victims:</h1>
			<ul>
				@foreach($latest_five as $victim)
					<li>{{{$victim->first}}} {{{$victim->last}}}</li>
				@endforeach
			</ul>
		</section>
	</div>

	<div class="row row--4">
		<section class="game-actions__panel panel--stats">
			<h1>Seniors:</h1>
			<p class="data">{{{ $senior_percent }}}%</p>
			<p>Still in</p>
		</section>

		<section class="game-actions__panel panel--stats">
			<h1>Juniors:</h1>
			<p class="data">{{{ $junior_percent }}}%</p>
			<p>Still in</p>
		</section>

		<section class="game-actions__panel panel--stats">
			<h1>Sophomores:</h1>
			<p class="data">{{{ $soph_percent }}}%</p>
			<p>Still in</p>
		</section>

		<section class="game-actions__panel panel--stats">
			<h1>Freshmen:</h1>
			<p class="data">{{{ $frosh_percent }}}%</p>
			<p>Still in</p>
		</section>
	</div>
@stop