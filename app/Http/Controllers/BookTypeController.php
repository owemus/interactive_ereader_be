<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\BookTypeService as BookTypeService;

class BookTypeController extends Controller
{
	public $bookTypeService;

	function __construct()
	{
		$this->bookTypeService = new BookTypeService();
	}

	public function getAllBookTypes()
	{
		return $this->bookTypeService->getAll();
	}

	public function getBookType($id)
	{
		return $this->bookTypeService->find($id);
	}

	public function insertBookType(Request $request)
	{
		return $this->bookTypeService->insert($request->input());
	}

	public function updateBookType(Request $request, $id)
	{
		return $this->bookTypeService->update($id, $request->input());
	}

	public function deleteBookType($id)
	{
		return $this->bookTypeService->delete($id);
	}
}