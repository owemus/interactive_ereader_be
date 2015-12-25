<?php

namespace App\Http\Services;

use Validator;
use App\User as User;
use App\Http\Services\ResponseService as ResponseService;

class UserService
{
	public $responseService;

	function __construct()
	{
		$this->responseService = new ResponseService();
	}

	// Gets all users
	public function getAll()
	{
		// Get All Users
		$users = User::get();

		// Passing data to response service
		return $this->responseService->returnMessage($users, 'No Users were Found.');
	}

	// Gets user by id
	public function find($id)
	{
		// Get user by id
		$user = User::find($id);
		// Passing data to response service
		return $this->responseService->returnMessage($user, 'User was not Found.');
	}

	// Inserts user
	public function insert($data)
	{
		// Validating data
		$validator = Validator::make($data, User::createrules());

		// If there are no errors in data
		if(!$validator->fails())
		{
			// Create User
			$user = User::create($data);
			// Passing data to response service
			return $this->responseService->returnMessage($user, 'User was not Inserted.');
		}
		else
		{
			// Data has errors
			// Passing errors to response service
			return $this->responseService->errorMessage($validator->errors()->all());
		}
	}

	// Updates user
	public function update($id, $data)
	{
		// Checking if user exists
		$user = User::find($id);

		// If user exists
		if(!empty($user))
		{
			// Validating data
			$validator = Validator::make($data, User::updaterules($id));

			// If there are no errors in data
			if(!$validator->fails())
			{
				// Update user
				$user->update($data);

				// Passing data to response service
				return $this->responseService->returnMessage($user, 'User was not Updated.');
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
			// User not found
			// Returning error message
			return $this->responseService->errorMessage('User was not Found.');
		}
	}

	// Deletes user
	public function delete($id)
	{
		// Checking if user exists
		$user = User::find($id);

		// If user exists
		if(!empty($user))
		{
			// Delete user
			$user->delete();

			// Returning success message
			return $this->responseService->returnSuccess();
		}
		else
		{
			// User not found
			// Returning error message
			return $this->responseService->errorMessage('User was not Found.');
		}
	}
}