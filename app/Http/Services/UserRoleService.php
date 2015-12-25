<?php

namespace App\Http\Services;

use Validator;
use App\UserRole as UserRole;
use App\Http\Services\ResponseService as ResponseService;

class UserRoleService
{
	public $responseService;

	function __construct()
	{
		$this->responseService = new ResponseService();
	}

	// Gets all userRoleRoles
	public function getAll()
	{
		// Get All UserRoleRoles
		$userRoleRoles = UserRole::get();

		// Passing data to response service
		return $this->responseService->returnMessage($userRoleRoles, 'No UserRoles were Found.');
	}

	// Gets userRole by id
	public function find($id)
	{
		// Get userRole by id
		$userRole = UserRole::find($id);
		// Passing data to response service
		return $this->responseService->returnMessage($userRole, 'UserRole was not Found.');
	}

	// Inserts userRole
	public function insert($data)
	{
		// Validating data
		$validator = Validator::make($data, UserRole::createrules());

		// If there are no errors in data
		if(!$validator->fails())
		{
			// Create UserRole
			$userRole = UserRole::create($data);
			// Passing data to response service
			return $this->responseService->returnMessage($userRole, 'UserRole was not Inserted.');
		}
		else
		{
			// Data has errors
			// Passing errors to response service
			return $this->responseService->errorMessage($validator->errors()->all());
		}
	}

	// Updates userRole
	public function update($id, $data)
	{
		// Checking if userRole exists
		$userRole = UserRole::find($id);

		// If userRole exists
		if(!empty($userRole))
		{
			// Validating data
			$validator = Validator::make($data, UserRole::updaterules($id));

			// If there are no errors in data
			if(!$validator->fails())
			{
				// Update userRole
				$userRole->update($data);

				// Passing data to response service
				return $this->responseService->returnMessage($userRole, 'UserRole was not Updated.');
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
			// UserRole not found
			// Returning error message
			return $this->responseService->errorMessage('UserRole was not Found.');
		}
	}

	// Deletes userRole
	public function delete($id)
	{
		// Checking if userRole exists
		$userRole = UserRole::find($id);

		// If userRole exists
		if(!empty($userRole))
		{
			// Delete userRole
			$userRole->delete();

			// Returning success message
			return $this->responseService->returnSuccess();
		}
		else
		{
			// UserRole not found
			// Returning error message
			return $this->responseService->errorMessage('UserRole was not Found.');
		}
	}
}