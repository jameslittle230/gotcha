<?php

class Tag extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tags';

	protected $fillable = ['predator', 'prey'];

	public function predator()
	{
		return $this->belongsTo('Player', 'predator');
	}

	public function prey()
	{
		return $this->belongsTo('Player', 'prey');
	}

}
