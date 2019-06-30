<?php

return [

	// Personalize your form cinch experience
	'project_name' => 'Form Cinch',

	// Forms will be prefaced with this path
	'form_route_prefix' => '/form',

	// Administrative views for new forms and results
	// should be prefixed with this path
	'form_admin_prefix' => '/form-cinch',

        // The redirect to be used after create a form
        'redirect_path' => '/form-cinch',

	//Simple access auth
	'use_simple_access' => true,

	//an array of user ids with ability to create new forms
	'simple_access_users' => [
		1,
	],

	//auth middleware - can be replaced with your own middleware
	'middleware_class' => 'Ngmedia\FormCinch\Middleware\FormCinchAdminMiddleware',

	//the group setup to handle the middleware requests
	'middleware_group' => 'form-cinch-admin',

	//the key for the middleware
	'middleware_key' => 'form-cinch-admin',

	/**
	 * 	Every form has a number of default fields. This affects all forms
	 *	Title and emails are base form fields and saving will fail if
	 *  they're not present. Only require slug when not using auto generated
	 *
	 *	'title' => 'required|max:255',
	 *	'slug' => 'required|unique:fc_forms',
	 *	'confirmation_message' => 'required',
	 *	'emails' => 'required',
	 *	'extends' => 'required
	 *  OPTIONAL
	 *
	 */

	'required_fields' => [
		'title' => 'required|max:255',
	],

	'recaptcha_validation' => [
		'g-recaptcha-response' => 'required|captcha'
	]
];
