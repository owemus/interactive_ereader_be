<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\UserService as UserService;

class UserController extends Controller
{
	public $userService;

	function __construct()
	{
		$this->userService = new UserService();
	}

	public function getAllUsers()
	{
		return $this->userService->getAll();
	}

	public function getUser($id)
	{
		return $this->userService->find($id);
	}

	public function insertUser(Request $request)
	{
		return $this->userService->insert($request->input());
	}

	public function updateUser(Request $request, $id)
	{
		return $this->userService->update($id, $request->input());
	}

	public function deleteUser($id)
	{
		return $this->userService->delete($id);
	}
}