@if(Auth::check())
	<h1>{{{ $name }}}</h1>
	<p>{{{ $user_tags }}} tag{{{ $user_tags == 1 ? '' : 's' }}} so far...</p>

	<!-- <h2>Time Elapsed since Last Capture</h2>
	<p>{{{ $time_elapsed }}}</p> -->

	<div class="strikes-section">
		<h2>Strikes</h2>
		<ul class="strikes">
			@for ($i=0; $i<$user_strikes; $i++)
				<li class="strike strike--yes"></li>
			@endfor

			@for ($i=0; $i< 3 - $user_strikes; $i++)
				<li class="strike strike--no"></li>
			@endfor
		</ul>
	</div>

	<div class="banned-section">
		<h2>Banned</h2>
		{{{ $banned > 0 ? 'You are banned for ' . $banned . ' more minutes.' : 'You are not currently banned.' }}}
	</div>
@else
	<h2>Please {{ link_to_route('login', 'log in') }} to see your statistics. </h2>
@endif()