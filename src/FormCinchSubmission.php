<?php

namespace Ngmedia\FormCinch;

use Illuminate\Database\Eloquent\Model;

class FormCinchSubmission extends Model
{
    public $table = 'fc_form_submissions';

    public $fillable = ['results', 'fc_form_id'];

	public function setResultsAttribute($value)
	{
		$this->attributes['results'] = serialize($value);
	}

	public function getResultsAttribute($value)
	{
		return unserialize($value);
	}

	public function form()
	{
		return $this->belongsTo('Ngmedia\FormCinch\FormCinch', 'fc_form_id');
	}
}
