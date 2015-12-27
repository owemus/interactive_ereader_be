<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\BookService as BookService;

class BookController extends Controller
{
	public $booksService;

	function __construct()
	{
		$this->booksService = new BookService();
	}

	public function getAllBooks()
	{
		return $this->booksService->getAll();
	}

	public function getBook($id)
	{
		return $this->booksService->find($id);
	}

	public function insertBook(Request $request)
	{
		return $this->booksService->insert($request->input());
	}

	public function updateBook(Request $request, $id)
	{
		return $this->booksService->update($id, $request->input());
	}

	public function deleteBook($id)
	{
		return $this->booksService->delete($id);
	}
}