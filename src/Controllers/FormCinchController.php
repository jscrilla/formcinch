<?php

namespace Ngmedia\FormCinch\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ngmedia\FormCinch\FormCinch;
use Ngmedia\FormCinch\FormCinchSubmission;
use Ngmedia\FormCinch\Library\Slug;

class FormCinchController extends Controller
{
	use Slug;

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {
    	$form = FormCinch::where('slug', $slug)->first();

    	return view('formcinch::show', compact('form'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
	public function store(Request $request)
	{
		$request->validate(
			config('formcinch.formcinch.required_fields')
		);

		$form = new FormCinch();
		$submittedFields = $request->except('slug', '_token', 'title', 'emails', 'extends', 'recaptcha', 'redirect_to', 'after_submit');

		$form->user_id = 1;
		$form->title = $request->title;
		$form->slug = $this->generateSlug($request);
		$form->confirmation_message = $this->generateConfirmationMessage($request);
		$form->emails = $request->emails;
		$form->extends = $request->extends;
		$form->after_submit = $this->generateAfterSubmit($request);
		$form->fields = $this->parseIntoFields($submittedFields);
		$form->required_fields = $this->parseRequiredFields($submittedFields);
		$form->recaptcha = ($request->recaptcha) ? 1 : 0;

		$form->save();

		return redirect()->to(config('formcinch.formcinch.redirect_path'));
	}

	public function edit($id)
	{
		$form = FormCinch::find($id);

		return view('formcinch::admin.edit', compact('form'));
	}

	public function update($id)
	{
		$form = FormCinch::find($id);

		$submittedFields = request()->except('slug', '_token', 'title', 'emails', 'extends', 'recaptcha', 'redirect_to', 'after_submit', '_method');

		$form->user_id = 1;
		$form->title = request()->title;
		$form->slug = $this->generateSlug(request());
		$form->confirmation_message = $this->generateConfirmationMessage(request());
		$form->emails = request()->emails;
		$form->extends = request()->extends;
		$form->after_submit = $this->generateAfterSubmit(request());
		$form->fields = $this->parseIntoFields($submittedFields);
		$form->required_fields = $this->parseRequiredFields($submittedFields);
		$form->recaptcha = (request()->recaptcha) ? 1 : 0;

		$form->save();

		return redirect()->to(config('formcinch.formcinch.redirect_path'));
	}

	/**
     * The default function to be used
     * when the form has been submitted
	 * @param $request
	 *
	 * @return string
	 */
	protected function generateAfterSubmit($request)
	{
		if($request->after_submit === 'redirect'){
			$request->after_submit = ['redirect' => $request->redirect_to];
		}

		return ($request->after_submit) ? $request->after_submit : 'back';
	}

    /**
     * @param $request
     * @return string
     */
	protected function generateConfirmationMessage($request)
	{
		return ($request->confirmation_message) ? $request->confirmation_message : 'We received your submission. Thank you!';
	}

    /**
     * @param $request
     * @return null|string|string[]
     */
	protected function generateSlug($request)
	{
		return ($request->slug) ? $request->slug : $this->make($request->title, 'fc_forms', 'slug');
	}

    /**
     * @param $submittedFields
     * @return array
     */
	protected function parseIntoFields($submittedFields)
	{
		$fields = [];

		$submittedFields = $this->removeRequiredFields($submittedFields);

		foreach($submittedFields as $key => $v){
			if(is_array($v)) {
				$name = explode( '_', $key );
				$name = $this->getName($name);

				$fields[ $name ] = ['select', array_filter($v)];
			}

			$f = explode('_', $key);

			if($f[1] != 'select'){
				$fields[strtolower($f[0])] = $f[1];
			}
		}

		return $fields;
	}

    /**
     * @param $submittedFields
     * @return mixed
     */
	protected function removeRequiredFields($submittedFields)
    {
        foreach($submittedFields as $key => $value){
            if(strpos($key, '_required') !== false){
                unset($submittedFields[$key]);
            }
        }

        return $submittedFields;
    }

    /**
     * @param $submittedFields
     * @return array
     */
    protected function parseRequiredFields($submittedFields)
    {
        $required = [];

        foreach($submittedFields as $key => $v){
            $f = explode('_', $key);

            if($f[1] === 'required'){
                $required[strtolower($f[0])] = true;
            }
        }

        return $required;
    }

    /**
     * @param array $name
     * @return string
     */
	protected function getName(array $name)
	{
		return ($name[1] === 'select') ? strtolower( $name[0] ) : $name[0] . ' ' . $name[1];
	}
}
