<?php

namespace Ngmedia\FormCinch\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ngmedia\FormCinch\FormCinch;
use Ngmedia\FormCinch\FormCinchSubmission;
use Ngmedia\FormCinch\Mail\FormCinchSubmissionReceived;
use Illuminate\Support\Facades\Mail;

class FormCinchSubmissionController extends Controller
{
	/**
	 * Validate the submission and then store
	 * @param $slug
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store($slug)
	{
		$form = FormCinch::where('slug', $slug)->first();

        request()->validate(
            $this->getValidationRules($form)
        );

		$submission =  FormCinchSubmission::create([
			'fc_form_id' => $form->id,
			'results' => request()->except('_token', 'g-recaptcha-response')
		]);

		$this->sendMailIfChecked($form, $submission);

		return $this->afterSubmit($form);
	}

	protected function sendMailIfChecked($form, $submission)
	{
		if($form->emails){
			$emails = explode(',', $form->emails);

			foreach($emails as $email){
				Mail::to($form->emails)->send(new FormCinchSubmissionReceived($submission));
			}
		}

		return false;
	}

	/**
	 * Sends the user to the desired destination based on the form
	 * they are submitting. Possible to redirect to page or
	 * to send them back to the form.
	 * @param $form
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function afterSubmit($form)
	{
		if(is_array($form->after_submit)){
			return redirect()->to($form->after_submit['redirect'])->with('message', $form->confirmation_message)->with('alert-class', 'alert-success');
		}

		return redirect()->to('/form/'.$form->slug)->with('message', $form->confirmation_message)->with('alert-class', 'alert-success');
	}

	/**
	 * Returns the required validation rules
	 * if the form uses captcha, the config
	 * file will be queried for the necessary
	 * captcha validation rules
	 * @param $form
	 *
	 * @return array
	 */
	protected function getValidationRules($form)
    {
    	$required = [];
        $requiredFields = $form->required_fields;

        foreach($requiredFields as $key => $field){
        	$required[$key] = 'required';
        }

        if($form->recaptcha){
	        $required = array_merge($required, config('formcinch.formcinch.recaptcha_validation'));
        }

        return $required;
    }
}
