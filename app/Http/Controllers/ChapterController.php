<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\ChapterService as ChapterService;

class ChapterController extends Controller
{
	public $chaptersService;

	function __construct()
	{
		$this->chaptersService = new BookService();
	}

	public function getAllChapters($book_id)
	{
		return $this->chaptersService->getAll($book_id);
	}

	public function getChapter($book_id, $chapter_id)
	{
		return $this->chaptersService->find($book_id, $chapter_id);
	}

	public function insertChapter(Request $request, $book_id)
	{
		return $this->chaptersService->insert($book_id, $request->input());
	}

	public function updateChapter(Request $request, $book_id, $chapter_id)
	{
		return $this->chaptersService->update($chapter_id, $request->input());
	}

	public function deleteChapter($book_id, $chapter_id)
	{
		return $this->chaptersService->delete($chapter_id);
	}
}