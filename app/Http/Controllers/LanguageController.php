<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\LanguageService as LanguageService;

class LanguageController extends Controller
{
	public $languagesService;

	function __construct()
	{
		$this->languagesService = new LanguageService();
	}

	public function getAllLanguages()
	{
		return $this->languagesService->getAll();
	}

	public function getLanguage($id)
	{
		return $this->languagesService->find($id);
	}

	public function insertLanguage(Request $request)
	{
		return $this->languagesService->insert($request->input());
	}

	public function updateLanguage(Request $request, $id)
	{
		return $this->languagesService->update($id, $request->input());
	}

	public function deleteLanguage($id)
	{
		return $this->languagesService->delete($id);
	}
}