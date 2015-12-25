<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\UserRoleService as UserRoleService;

class UserRoleController extends Controller
{
	public $userRoleService;

	function __construct()
	{
		$this->userRoleService = new UserRoleService();
	}

	public function getAllUserRoles()
	{
		return $this->userRoleService->getAll();
	}

	public function getUserRole($id)
	{
		return $this->userRoleService->find($id);
	}

	public function insertUserRole(Request $request)
	{
		return $this->userRoleService->insert($request->input());
	}

	public function updateUserRole(Request $request, $id)
	{
		return $this->userRoleService->update($id, $request->input());
	}

	public function deleteUserRole($id)
	{
		return $this->userRoleService->delete($id);
	}
}