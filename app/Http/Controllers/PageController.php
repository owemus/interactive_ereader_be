<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\PageService as PageService;

class PageController extends Controller
{
	public $pagesService;

	function __construct()
	{
		$this->pagesService = new PageService();
	}

	public function getAllPages($book_id, $chapter_id)
	{
		return $this->pagesService->getAll($book_id, $chapter_id);
	}

	public function getPage($book_id, $chapter_id, $page_id)
	{
		return $this->pagesService->find($book_id, $chapter_id, $page_id);
	}

	public function insertPage(Request $request, $book_id, $chapter_id)
	{
		return $this->pagesService->insert($chapter_id, $request->input());
	}

	public function updatePage(Request $request, $book_id, $chapter_id, $page_id)
	{
		return $this->pagesService->update($page_id, $request->input());
	}

	public function deletePage($book_id, $chapter_id, $page_id)
	{
		return $this->pagesService->delete($page_id);
	}
}