<?php

namespace App\Http\Services;

use Validator;
use App\Book as Book;
use App\Http\Services\ResponseService as ResponseService;

class BookService
{
	public $responseService;
	public $chaptersService;

	function __construct()
	{
		$this->responseService = new ResponseService();
	}

	// Gets all books
	public function getAll()
	{
		// Get All Books
		$books = Book::get();

		// Passing data to response service
		return $this->responseService->returnMessage($books, 'No Books were Found.');
	}

	// Gets book by id
	public function find($id)
	{
		// Get book by id
		$book = Book::find($id);
		// Passing data to response service
		return $this->responseService->returnMessage($book, 'Book was not Found.');
	}

	// Inserts book
	public function insert($data)
	{
		// Validating data
		$validator = Validator::make($data, Book::createrules());

		// If there are no errors in data
		if(!$validator->fails())
		{
			// Create Book
			$book = Book::create($data);
			// Passing data to response service
			return $this->responseService->returnMessage($book, 'Book was not Inserted.');
		}
		else
		{
			// Data has errors
			// Passing errors to response service
			return $this->responseService->errorMessage($validator->errors()->all());
		}
	}

	// Updates book
	public function update($id, $data)
	{
		// Checking if book exists
		$book = Book::find($id);

		// If book exists
		if(!empty($book))
		{
			// Validating data
			$validator = Validator::make($data, Book::updaterules($id));

			// If there are no errors in data
			if(!$validator->fails())
			{
				// Update book
				$book->update($data);

				// Passing data to response service
				return $this->responseService->returnMessage($book, 'Book was not Updated.');
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
			// Book not found
			// Returning error message
			return $this->responseService->errorMessage('Book was not Found.');
		}
	}

	// Deletes book
	public function delete($id)
	{
		// Checking if book exists
		$book = Book::find($id);

		// If book exists
		if(!empty($book))
		{
			// Finding related chapters
			$chapters = $this->chaptersService->getAll($id);

			// Delete related chapters
			foreach ($chapters as $chapter)
			{
				$this->chaptersService->delete($chapter->id);
			}

			// Delete book
			$book->delete();

			// Returning success message
			return $this->responseService->returnSuccess();
		}
		else
		{
			// Book not found
			// Returning error message
			return $this->responseService->errorMessage('Book was not Found.');
		}
	}
}