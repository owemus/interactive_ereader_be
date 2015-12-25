<?php

namespace App\Http\Services;

class ResponseService
{
	// Returns success
	public function returnSuccess()
	{
		$response = array();

		$response['success'] = true; // Setting success as true

		return $response;
	}

	// Returns error
	public function returnError()
	{
		$response = array();

		$response['success'] = false; // Setting success as false

		return $response;
	}

	// Returns success with data
	public function successMessage($data)
	{
		$response = array();

		$response['data'] = $data; // Setting data
		$response['success'] = true; // Setting success as true

		return $response;
	}

	// Returns error with message
	public function errorMessage($error)
	{
		$response = array();

		$response['error_message'] = $error; // Setting error message
		$response['success'] = false; // Setting success as false

		return $response;
	}

	// Returns success or error depending on data
	public function returnMessage($data, $error_message)
	{
		// If no data is present
		if(empty($data) || sizeof($data) == 0)
		{
			$response = array();

			$response['error_message'] = $error_message; // Setting error message
			$response['success'] = false; // Setting success as false

			return $response;
		}
		else
		{
			// Data is present

			$response = array();

			$response['data'] = $data; // Setting data
			$response['success'] = true; // Setting success as false

			return $response;
		}
	}
}