<?php

namespace App\Http\Services;

use Validator;
use App\Publisher as Publisher;
use App\Http\Services\ResponseService as ResponseService;

class PublisherService
{
	public $responseService;

	function __construct()
	{
		$this->responseService = new ResponseService();
	}

	// Gets all publishers
	public function getAll()
	{
		// Get All Publishers
		$publishers = Publisher::get();

		// Passing data to response service
		return $this->responseService->returnMessage($publishers, 'No Publishers were Found.');
	}

	// Gets publisher by id
	public function find($id)
	{
		// Get publisher by id
		$publisher = Publisher::find($id);
		// Passing data to response service
		return $this->responseService->returnMessage($publisher, 'Publisher was not Found.');
	}

	// Inserts publisher
	public function insert($data)
	{
		// Validating data
		$validator = Validator::make($data, Publisher::createrules());

		// If there are no errors in data
		if(!$validator->fails())
		{
			// Create Publisher
			$publisher = Publisher::create($data);
			// Passing data to response service
			return $this->responseService->returnMessage($publisher, 'Publisher was not Inserted.');
		}
		else
		{
			// Data has errors
			// Passing errors to response service
			return $this->responseService->errorMessage($validator->errors()->all());
		}
	}

	// Updates publisher
	public function update($id, $data)
	{
		// Checking if publisher exists
		$publisher = Publisher::find($id);

		// If publisher exists
		if(!empty($publisher))
		{
			// Validating data
			$validator = Validator::make($data, Publisher::updaterules($id));

			// If there are no errors in data
			if(!$validator->fails())
			{
				// Update publisher
				$publisher->update($data);

				// Passing data to response service
				return $this->responseService->returnMessage($publisher, 'Publisher was not Updated.');
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
			// Publisher not found
			// Returning error message
			return $this->responseService->errorMessage('Publisher was not Found.');
		}
	}

	// Deletes publisher
	public function delete($id)
	{
		// Checking if publisher exists
		$publisher = Publisher::find($id);

		// If publisher exists
		if(!empty($publisher))
		{
			// Delete publisher
			$publisher->delete();

			// Returning success message
			return $this->responseService->returnSuccess();
		}
		else
		{
			// Publisher not found
			// Returning error message
			return $this->responseService->errorMessage('Publisher was not Found.');
		}
	}
}