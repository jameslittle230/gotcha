<?php

use Carbon\Carbon;

class BaseController extends Controller {

	protected $now;
	protected $banned_until;

	function __construct() {
		$this->now = new Carbon('now', 'America/New_York');

		if (Auth::check()) {
			$this->banned_until = new Carbon(Auth::user()->banned_until, 'America/New_York');
		}

		View::composer(['gameplay', 'rules', 'banned', 'about', 'statistics', 'bad_time', 'out'], function($view)
		{
			if (Auth::check()) {
				$view->with('name', Auth::user()->first . ' ' . Auth::user()->last);
				$view->with('user_tags', Auth::user()->tags()->count());
				$view->with('time_elapsed', '');
				$view->with('user_strikes', Auth::user()->strikes);
				$view->with('banned', $this->now->diffInMinutes($this->banned_until));
				$view->with('target_name', Auth::user()->target->first . '&nbsp;' . Auth::user()->target->last);
				$view->with('your_code', strtoupper(Auth::user()->tag_code));
			}
			$view->with('now', $this->now->toDayDateTimeString());
		});		
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	

}
