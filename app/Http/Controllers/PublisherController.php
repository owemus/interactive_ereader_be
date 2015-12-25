<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\PublisherService as PublisherService;

class PublisherController extends Controller
{
	public $publishersService;

	function __construct()
	{
		$this->publishersService = new PublisherService();
	}

	public function getAllPublishers()
	{
		return $this->publishersService->getAll();
	}

	public function getPublisher($id)
	{
		return $this->publishersService->find($id);
	}

	public function insertPublisher(Request $request)
	{
		return $this->publishersService->insert($request->input());
	}

	public function updatePublisher(Request $request, $id)
	{
		return $this->publishersService->update($id, $request->input());
	}

	public function deletePublisher($id)
	{
		return $this->publishersService->delete($id);
	}
}