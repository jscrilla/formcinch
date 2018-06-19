<?php

if (!function_exists('formcinch_url')) {
    /**
     * Appends the configured formcinch prefix and returns
     * the URL using the standard Laravel helpers.
     *
     * @param $path
     *
     * @return string
     */
    function formcinch_url($path = null)
    {

        return url(config('formcinch.formcinch.form_admin_prefix'));
    }
}

if (!function_exists('formcinch_required')) {
    /**
     * Returns "required" if the array key exists on the
     * config for formcinch. Useful for placing the required
     * flag on inputs and printing the class into the label
     *
     * @param $input
     * @return string
     */
    function formcinch_required($input)
    {

        return (array_key_exists($input, config('formcinch.formcinch.required_fields'))) ? 'required' : '';
    }
}

if (!function_exists('form_field_required')) {
	/**
	 * Returns "required" if the array key exists on the
	 * required array of the individual form. This is different
	 * than the form config array above
	 *
	 * @param $input
	 * @return string
	 */
	function form_field_required($input, $form)
	{

		return (array_key_exists($input, $form->required_fields)) ? 'required' : '';
	}
}

if (!function_exists('formcinch_check')) {
	/**
	 * Returns "required" if the array key exists on the
	 * required array of the individual form. This is different
	 * than the form config array above
	 *
	 * @param $input
	 * @return string
	 */
	function formcinch_checked($form)
	{
		return ($form->recaptcha) ? 'checked' : '';
	}
}