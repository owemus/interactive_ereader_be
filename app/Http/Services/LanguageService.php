<?php

namespace App\Http\Services;

use Validator;
use App\Language as Language;
use App\Http\Services\ResponseService as ResponseService;

class LanguageService
{
	public $responseService;

	function __construct()
	{
		$this->responseService = new ResponseService();
	}

	// Gets all languages
	public function getAll()
	{
		// Get All Languages
		$languages = Language::get();

		// Passing data to response service
		return $this->responseService->returnMessage($languages, 'No Languages were Found.');
	}

	// Gets language by id
	public function find($id)
	{
		// Get language by id
		$language = Language::find($id);
		// Passing data to response service
		return $this->responseService->returnMessage($language, 'Language was not Found.');
	}

	// Inserts language
	public function insert($data)
	{
		// Validating data
		$validator = Validator::make($data, Language::createrules());

		// If there are no errors in data
		if(!$validator->fails())
		{
			// Create Language
			$language = Language::create($data);
			// Passing data to response service
			return $this->responseService->returnMessage($language, 'Language was not Inserted.');
		}
		else
		{
			// Data has errors
			// Passing errors to response service
			return $this->responseService->errorMessage($validator->errors()->all());
		}
	}

	// Updates language
	public function update($id, $data)
	{
		// Checking if language exists
		$language = Language::find($id);

		// If language exists
		if(!empty($language))
		{
			// Validating data
			$validator = Validator::make($data, Language::updaterules($id));

			// If there are no errors in data
			if(!$validator->fails())
			{
				// Update language
				$language->update($data);

				// Passing data to response service
				return $this->responseService->returnMessage($language, 'Language was not Updated.');
			}
			else
			{
				// Data has errors
				// Passing errors to response service
				return $this->responseService->errorMessage($validator->errors()->all());
			}
		}
		else
		{
			// Language not found
			// Returning error message
			return $this->responseService->errorMessage('Language was not Found.');
		}
	}

	// Deletes language
	public function delete($id)
	{
		// Checking if language exists
		$language = Language::find($id);

		// If language exists
		if(!empty($language))
		{
			// Delete language
			$language->delete();

			// Returning success message
			return $this->responseService->returnSuccess();
		}
		else
		{
			// Language not found
			// Returning error message
			return $this->responseService->errorMessage('Language was not Found.');
		}
	}
}