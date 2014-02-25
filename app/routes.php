<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('home');
});

Route::get('/about', function()
{
	return View::make('about');
});

Route::get('/contact', function()
{
	return View::make('contact');
});

Route::post('contact', function(){
	$data = Input::all();
	$rule = array(
		'subject' => 'required',
		'message' => 'required'
	);

	$validator = Validator::make($data, $rule);

	if($validator->fails()){
		return Redirect::to('contact')->withErrors($validator)->withInput();
	}

	$emailcontent = array(
		'subject' => $data['subject'],
		'emailmessage' => $data['message']
	);

	Mail::send('emails.contactemail', $emailcontent, function($message)
	{
		$message->to('lifengtest@gmail.com')
			->subject('Contact via Our Contact Form');
	});

	return 'Your message has been sent';
});
