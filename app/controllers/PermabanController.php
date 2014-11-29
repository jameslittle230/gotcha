<?php

use Carbon\Carbon;

class PermabanController extends \BaseController {

	function __construct() {
		Parent::__construct();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
		if ('true' !== Session::get('permaban_allowed')) {
			return Redirect::route('permaban_login');
		}

		// Session::forget('permaban_allowed');
		echo "<h1>Gotcha Teachers' Administration Section</h1>";
		echo "<h2>Students Banned Right Now</h2>";
		echo "<strong>Banned for a short period of time:</strong><ul>";

		$temp_banned = Player::where('banned_until', '!=', '')->get();
		foreach ($temp_banned as $player) {
			echo "<li>" . $player->first . " " . $player->last . "</li>";
		}

		echo "</ul><strong>Permanently banned:</strong><ul>";

		$temp_banned = Player::where('permaban', '!=', '0')->get();
		foreach ($temp_banned as $player) {
			echo "<li>" . $player->first . " " . $player->last . "</li>";
		}

		echo "</ul><h2>Ban a Student</h2>";

		echo Form::open(['route' => 'permaban_go']);
		echo "<p>Choose a student: ";

		$students = [0 => '...'];

		$not_banned = Player::where('permaban', '0')->orderBy('last')->get();
		foreach ($not_banned as $player) {
			$students[$player->id] = $player->first . " " . $player->last . " (Class " . $player->class .")";
		}

		echo Form::select('player', $students);
		echo "</p><p>";
		echo Form::submit('Ban this player');
		echo Form::close();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		echo "<h1>Gotcha Teachers' Administration Section</h1>";
		echo "<p>Please enter the passcode.</p>";
		echo Form::open(['route' => 'permaban_login']);
		echo "<p>Passcode: ";
		echo Form::password('passcode');
		echo "</p><p>";
		echo Form::submit('Submit');
		echo "</p>";
		echo Form::close();
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$passcode = md5(Input::get('passcode'));
		if ($passcode == '06bd5045b6fe2d3c5cb3a5b9f0d3e034') {
			Session::put('permaban_allowed', 'true');
			return Redirect::route('permaban');
		}

		return Redirect::route('permaban_login');
	}

	public function go()
	{
		$player = Player::find(Input::get('player'));
		$player->permaban = '1';
		$player->save();
		return Redirect::route('permaban');
	}


}
