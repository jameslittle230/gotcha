<?php

class SessionController extends \BaseController {

	public function create()
	{
		if (md5(Input::get('security')) == 'e3cc9b8f2037c7da330a31b529f6effc') {
			$player = Player::find(Input::get('id'));
			Auth::login($player);
			return Redirect::to('/');
		}
		return View::make('login', ['hide_sidebar' => true]);
	}

	public function store()
	{
		$username = Input::get('username');
		$password = Input::get('password');

		$myMiltonUsername = $username;

		if ($username == 'mglattstein16') {
			$username = 'mglattstein';
		}

		if ($username == 'jsim15') {
			$username = 'jsim14';
		}

		if ($username == 'MFearey16') {
			$username = 'MFeary16';
		}

		if ($username == 'AFrongillo16') {
			$username = 'AFongillo16';
		}

		if ($username == 'MAdedamola18') {
			$username = 'MAdedamola17';
		}
		

		$url = 'https://my.milton.edu/Student/studentActivities/';
		$data = array('UserLogin_required' => '', 'UserPassword_required' => '', 'UserLogin' => $myMiltonUsername, 'UserPassword' => $password);

		// use key 'http' even if you send the request to https://...
		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data),
			),
		);
		$context  = stream_context_create($options);
		$server_output = file_get_contents($url, false, $context);

		if (strpos($server_output, '<img src="https://my.milton.edu/Student/images/top2_01.gif">')) {
		// if ($password == 'password') {
			$logged_in_user = Player::where('username', strtolower($username))->firstOrFail();
			Auth::login($logged_in_user);
			return Redirect::route('game');
		} else {
			Flash::error('Incorrect username/password.');
			return Redirect::route('login');
		}

		echo '<pre>';
		print_r(e($server_output));
		echo '</pre>';
	}

	public function delete()
	{
		Auth::logout();
		return Redirect::to('/');
	}
}