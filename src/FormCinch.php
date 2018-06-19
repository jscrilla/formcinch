<?php

namespace Ngmedia\FormCinch;

use Illuminate\Database\Eloquent\Model;

class FormCinch extends Model {

	public $fillable = [
		'user_id',
		'title',
		'slug',
		'fields',
		'required_fields',
		'confirmation_message',
		'after_submit',
		'extends',
        'recaptcha'
	];

	public $table = 'fc_forms';

    /**
     * Mutators and Accessors
     */
	public function setFieldsAttribute($value)
	{
		$this->attributes['fields'] = serialize($value);
	}

	public function getFieldsAttribute($value)
	{
		return unserialize($value);
	}

    public function setRequiredFieldsAttribute($value)
    {
        $this->attributes['required_fields'] = serialize($value);
    }

    public function getRequiredFieldsAttribute($value)
    {
        return unserialize($value);
    }

	public function setAfterSubmitAttribute($value)
	{
		$this->attributes['after_submit'] = serialize($value);
	}

	public function getAfterSubmitAttribute($value)
	{
		return unserialize($value);
	}

	public function getEmailsAttribute($value)
	{
		return explode(',', $value);
	}

    /** end mutators and accessors */


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function submissions()
	{
		return $this->hasMany('Ngmedia\FormCinch\FormCinchSubmission', 'fc_form_id');
	}

	/**
	 * False attribute that returns the path to the results
	 * @return string
	 */
	public function getPathAttribute()
	{
		return env('APP_URL') . '/' . config('formcinch.formcinch.form_admin_prefix') . '/' . $this->slug . '/results';
	}

	/**
	 * Helper function to return the comma
	 * separated list rather than array
	 * @return string
	 */
	public function printEmails()
	{
		$string = '';
		$i = 1;
		foreach($this->emails as $email){
			if($i == count($this->emails)){
				return $string .= $email;
			}
			$string .= $email .',';
			$i++;
		}
		return $string;
	}


}