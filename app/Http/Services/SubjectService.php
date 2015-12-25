<?php

namespace App\Http\Services;

use Validator;
use App\Subject as Subject;
use App\Http\Services\ResponseService as ResponseService;

class SubjectService
{
	public $responseService;

	function __construct()
	{
		$this->responseService = new ResponseService();
	}

	// Gets all subjects
	public function getAll()
	{
		// Get All Subjects
		$subjects = Subject::get();

		// Passing data to response service
		return $this->responseService->returnMessage($subjects, 'No Subjects were Found.');
	}

	// Gets subject by id
	public function find($id)
	{
		// Get subject by id
		$subject = Subject::find($id);
		// Passing data to response service
		return $this->responseService->returnMessage($subject, 'Subject was not Found.');
	}

	// Inserts subject
	public function insert($data)
	{
		// Validating data
		$validator = Validator::make($data, Subject::createrules());

		// If there are no errors in data
		if(!$validator->fails())
		{
			// Create Subject
			$subject = Subject::create($data);
			// Passing data to response service
			return $this->responseService->returnMessage($subject, 'Subject was not Inserted.');
		}
		else
		{
			// Data has errors
			// Passing errors to response service
			return $this->responseService->errorMessage($validator->errors()->all());
		}
	}

	// Updates subject
	public function update($id, $data)
	{
		// Checking if subject exists
		$subject = Subject::find($id);

		// If subject exists
		if(!empty($subject))
		{
			// Validating data
			$validator = Validator::make($data, Subject::updaterules($id));

			// If there are no errors in data
			if(!$validator->fails())
			{
				// Update subject
				$subject->update($data);

				// Passing data to response service
				return $this->responseService->returnMessage($subject, 'Subject was not Updated.');
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
			// Subject not found
			// Returning error message
			return $this->responseService->errorMessage('Subject was not Found.');
		}
	}

	// Deletes subject
	public function delete($id)
	{
		// Checking if subject exists
		$subject = Subject::find($id);

		// If subject exists
		if(!empty($subject))
		{
			// Delete subject
			$subject->delete();

			// Returning success message
			return $this->responseService->returnSuccess();
		}
		else
		{
			// Subject not found
			// Returning error message
			return $this->responseService->errorMessage('Subject was not Found.');
		}
	}
}