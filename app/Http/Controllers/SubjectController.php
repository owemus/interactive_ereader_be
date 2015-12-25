<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\SubjectService as SubjectService;

class SubjectController extends Controller
{
	public $subjectsService;

	function __construct()
	{
		$this->subjectsService = new SubjectService();
	}

	public function getAllSubjects()
	{
		return $this->subjectsService->getAll();
	}

	public function getSubject($id)
	{
		return $this->subjectsService->find($id);
	}

	public function insertSubject(Request $request)
	{
		return $this->subjectsService->insert($request->input());
	}

	public function updateSubject(Request $request, $id)
	{
		return $this->subjectsService->update($id, $request->input());
	}

	public function deleteSubject($id)
	{
		return $this->subjectsService->delete($id);
	}
}