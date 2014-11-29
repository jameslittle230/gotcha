<?php

use Carbon\Carbon;

class GameController extends \BaseController {

	public $game_times;

	function __construct() {
		Parent::__construct();

		$this->game_times = [
			// Start Time
			Carbon::parse('2014-11-10 10:15:00', 'America/New_York'),

			// Veteran's Day begins at noon
			[
				Carbon::parse('2014-11-11 8:00:00', 'America/New_York'),
				Carbon::parse('2014-11-11 12:00:00', 'America/New_York')
			],

			[ // Every Other Weekday
				Carbon::parse('8:30:00', 'America/New_York'),
				Carbon::parse('17:45:00', 'America/New_York')
			],

			// End Time
			Carbon::parse('2014-11-14 17:45:00', 'America/New_York'),
		];
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		/**
		 * First, we do a whole bunch of checks to see if we're operating during the proper time.
		 * One thing we don't want is people registering tags that don't happen at within the
		 * time limits.
		 */
		
		/*
		Are we out of bounds of the start and end times?
		 */
		if ($this->now < $this->game_times[0] || $this->now > $this->game_times[count($this->game_times) - 1]) {
			return View::make('bad_time');
		}

		/*
		Are we out of bounds of the normal weekday times?
		 */
		if ($this->now < ($this->game_times[count($this->game_times)-2][0])) {
			return View::make('bad_time');
		}

		if ($this->now > ($this->game_times[count($this->game_times)-2][1])) {
			return View::make('bad_time');
		}

		/*
		Are we within any no-go times?
		 */
		for ($i=1; $i < count($this->game_times) - 2; $i++) { 
			if (($this->now > $this->game_times[$i][0]) &&
				($this->now < $this->game_times[$i][1])) {
				return View::make('bad_time');
			}
		}
		
		/*
		Is it the weekend?
		 */
		if ($this->now->isWeekend()) {
		 	return View::make('bad_time');
		}

		/******************************/
		
		/*
		If not...
		 */
		
		if (Auth::user()->permaban != '0') {
			return View::make('permabanned');
		}

		if (Auth::user()->tagged != '0') {
			return View::make('out');
		}

		/*
		We check to see if the user is the only one left, at which point he won
		 */
		if (Auth::id() == Auth::user()->target_id) {
			die('You won Gotcha!<br>I don\'t really expect anyone to get here, so here\'s your prize:<br><a href="https://www.youtube.com/watch?v=ZZ5LpwO-An4">Click me!</a>');
		}

		/*
		Next we check to see if the user's "banned until" value is blank. If not...
		 */
		if (Auth::user()->banned_until != '') {
			/*
			If the banned until time hasn't happened yet, we lock the user out
			 */
			if (new Carbon(Auth::user()->banned_until, 'America/New_York') > $this->now) {
				return View::make('banned');
			}

			/*
			If the banned until time was in the past, we reset it.
			 */
			if (new Carbon(Auth::user()->banned_until, 'America/New_York') < $this->now) {
				$me = Auth::user();
				$me->strikes = 0;
				$me->banned_until = '';
				$me->save();
			}
		}

		/*
		At this point, there should be no reason that the user isn't allowed to tag people.
		 */
		return View::make('gameplay', [
			'your_code' => strtoupper(Auth::user()->tag_code),
			'target_name' => Auth::user()->target->first . '&nbsp;' . Auth::user()->target->last,
			'target_first' => Auth::user()->target->first
		]);
	}


	public function tag()
	{
		/*
		If the input was empty, we assume the user screwed up.
		 */
		if(Input::get('code') == '') {
			Flash::warning('Please enter a two letter code.');
			return Redirect::to('/');
		}

		/*
		If the input was the correct tag code...
		 */
		if (strtolower(Input::get('code')) == Auth::user()->target->tag_code) {
			/*
			Set the target as tagged
			 */
			$target = Auth::user()->target;
			$target->tagged = 1;
			$target->save();

			/*
			Register the tag for analytics purposes
			 */
			$tag = new Tag([
				'predator' => Auth::id(),
				'prey' => Auth::user()->target->id
			]);

			$tag->save();

			/*
			Update my target, reset my strikes
			 */
			$me = Auth::user();
			$me->target_id = $target->target_id;
			$me->strikes = 0;
			$me->banned_until = '';
			$me->save();

			Flash::success('You have tagged ' . $target->first . '.');

		/*
		If the user entered the wrong two character code...
		 */
		} else {
			$me = Auth::user();
			$strikes = $me->strikes;

			/*
			Add on another strike, but make sure it doesn't go over 3
			 */
			$strikes++;
			if ($strikes > 3) {
				$strikes = 3;
			}
			$me->strikes = $strikes;
			$me->save();

			/*
			If this is your third strike, you are now banned. Sucks to suck.
			 */
			if ($strikes == 3) {
				$banned_time = new Carbon('+30 minutes', 'America/New_York');
				$me->banned_until = $banned_time->toDateTimeString();
				$me->save();
				return Redirect::to('/');
			}

			/*
			Tell the user they screwed up and let them try again.
			 */
			Flash::error('That code is incorrect. 
				You now have ' . $strikes . ' strike' . ($strikes == 1 ? '' : 's') . '. At three strikes you will be banned for 30 minutes.');
		}

		return Redirect::to('/');
	}

}
