<?php

class PagesController extends \BaseController {

	function __construct() {
		Parent::__construct();
	}

	public function about()
	{
		return View::make('about');
	}

	public function rules()
	{
		return View::make('rules');
	}

	public function download_db()
	{
		$file=app_path() . "/database/production.sqlite";
		return Response::download($file);
	}

	public function stats()
	{
		$num_students = Player::count();
		$num_students_tagged = Player::where('tagged', '!=', '0')->count();
		$percent_out = $num_students_tagged / $num_students * 100;

		$num_still_in = Player::where('tagged', '0')->count();

		$first_five_tags = Tag::orderBy('created_at', 'ASC')->limit(5)->get();
		$first_five = [];
		foreach ($first_five_tags as $tag) {
			$first_five[] = $tag->prey()->first();
		}

		$latest_five_tags = Tag::orderBy('created_at', 'DESC')->limit(5)->get();
		$latest_five = [];
		foreach ($latest_five_tags as $tag) {
			$latest_five[] = $tag->prey()->first();
		}

		$predators = [];

		foreach (Tag::all() as $tag) {
			$predators[] = $tag->predator;
		}

		$frequencies = array_count_values($predators);

		foreach ($frequencies as $player => $tags) {
			if (Player::find($player)->tagged == '1') {
				unset($frequencies[$player]);
			}
		}

		arsort($frequencies);

		while (count($frequencies) > 5) {
			array_pop($frequencies);
		}

		$total_seniors = Player::where('class', 1)->count();
		$seniors_still_in = Player::where('tagged', '0')->where('class', 1)->count();
		$senior_percent = round($seniors_still_in / $total_seniors * 100, 2);

		$total_juniors = Player::where('class', 2)->count();
		$juniors_still_in = Player::where('tagged', '0')->where('class', 2)->count();
		$junior_percent = round($juniors_still_in / $total_juniors * 100, 2);

		$total_soph = Player::where('class', 3)->count();
		$soph_still_in = Player::where('tagged', '0')->where('class', 3)->count();
		$soph_percent = round($soph_still_in / $total_soph * 100, 2);

		$total_frosh = Player::where('class', 4)->count();
		$frosh_still_in = Player::where('tagged', '0')->where('class', 4)->count();
		$frosh_percent = round($frosh_still_in / $total_frosh * 100, 2);

		$data = [
			'num_still_in' => $num_still_in,
			'percent_in' => 100-round($percent_out, 2),
			'first_five' => $first_five,
			'latest_five' => $latest_five,
			'frequencies' => $frequencies,
			'frosh_percent' => $frosh_percent,
			'soph_percent' => $soph_percent,
			'junior_percent' => $junior_percent,
			'senior_percent' => $senior_percent
		];
		return View::make('statistics', $data);
	}
}
