<?php

use Keboola\Csv;

class TestingController extends \BaseController {

	public function create()
	{
		/*
		First, we want to delete the previous database data so we're not writing over stuff.
		 */
		$this->deletePreviousDbData();

		/*
		Load the data from Gotcha.csv and put it into Eloquent objects.
		 */
		$letter_combinations = $this->makeLetterCombinations();
		$data = new Csv\CsvFile(storage_path() . '/Gotcha.csv');
		$tag_code_index = 0; // increments through random letters
		foreach($data as $row) {
			$player = new Player([
				'first' => $row[1],
				'last' => $row[0],
				'username' => strtolower($row[4]),
				'email' => $row[5],
				'class' => $row[3],
				'boarder|day' => $row[6],
				'house' => $row[7],
				'tag_code' => $letter_combinations[$tag_code_index],
			]);
			$player->save();
			$tag_code_index++;
		}

		/*
		The rest of the function is dedicated to creating the tag sequence.
		 */
		$player_ids = range(1, Player::count());
		shuffle($player_ids);
		// $player_ids is now a shuffled list of numbers, one for each player in the database.

		$player_map = [];

		/*
		Find each player and set their target to the previous one in the list.
		 */
		for ($i=0; $i < count($player_ids); $i++) {
			$player = Player::find($player_ids[$i]);
			
			/*
			Loop around for first player in randomized list
			 */
			if (!isset($player_ids[$i - 1])) {
				$player->target_id = $player_ids[count($player_ids) - 1];
				continue;
			}
			$player->target_id = $player_ids[$i - 1];
			$player->save();
		}
		
		
		/*
		Redirect home
		 */
		
		Flash::success('Data created.');
		return Redirect::to('/');
	}
	
	public function seeAll() {
		echo "<h2>People Still In</h2>";
		$players = Player::where('tagged', '0')->get();
		echo "
		<table>
			<tr>
				<th>ID</th>
				<th>First</th>
				<th>Last</th>
				<th>Tag Code</th>
				<th>Target ID</th>
			</tr>
		";
		foreach($players as $player) {
			if(Input::has('form')) {
				echo "<tr>";
					echo Form::model($player, ['route' => ['player.update', $player->id]]);
					
					echo "<td>$player->id</td>";
					echo "<td>" . Form::text('first') . "</td>";
					echo "<td>" . Form::text('last') . "</td>";
					echo "<td>$player->tag_code</td>";
					echo "<td>" . Form::text('target_id') . "</td>";
					echo '<input type="hidden" name="_token" value="' . csrf_token() . '">';
					echo "<td>" . Form::submit('Save') . "</td>";

					echo Form::close();
				echo '</tr>';
			} else {
				echo "<tr>";
					echo "<td>$player->id</td>";
					echo "<td>$player->first</td>";
					echo "<td>$player->last</td>";
					echo "<td>$player->tag_code</td>";
					echo "<td>$player->target_id</td>";
				echo '</tr>';
			}
			
		}

		echo '</table><hr><h2>People Who Are Out</h2>';

		$players = Player::where('tagged', '1')->get();
		foreach($players as $player) {
			echo $player->id . ': '. $player->first . ' ' . $player->last . ' — Tag Code: ' . $player->tag_code . '<br>';
		}
	}
	
	public function updateUser($id) {
		$player = Player::find($id);
		$player->first = Input::get('first');
		$player->last = Input::get('last');
		$player->target_id = Input::get('target_id');
		$player->save();
		return Redirect::back();
	}

	public function makeLetterCombinations()
	{
		$letters = range('a', 'z');
		$numbers = range(0, 9);
		$characters = array_merge($letters, $numbers);
		$letter_combinations = [];
		for ($i=0; $i < count($characters); $i++) { 
			for ($j=0; $j < count($letters); $j++) { 
				$letter_combinations[] = $characters[$i] . $letters[$j];
			}
		}

		shuffle($letter_combinations);

		return $letter_combinations;
	}

	public function deletePreviousDbData()
	{
		foreach (Player::all() as $player) {
			$player->delete();
		}

		foreach (Tag::all() as $tag) {
			$tag->delete();
		}

		DB::delete('delete from sqlite_sequence where name=\'players\'');
		DB::delete('delete from sqlite_sequence where name=\'tags\'');
	}
}
