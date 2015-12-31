<?php

namespace App\Http\Services;

use Validator;
use App\Book as Book;
use App\Http\Services\ResponseService as ResponseService;
use App\Http\Services\ChapterService as ChapterService;

class BookService
{
	public $responseService;
	public $chaptersService;

	function __construct()
	{
		$this->responseService = new ResponseService();
		$this->chaptersService = new ChapterService();
	}

	// Gets all books
	public function getAll()
	{
		// Get All Books
		$books = Book::get();

		// Passing data to response service
		return $this->responseService->returnMessage($books, 'No Books were Found.');
	}

	// Gets all books
	public function getAllWithLanguage($language_id)
	{
		// Get All Books
		$books = Book::where('language_id', $language_id)->get();

		// Passing data to response service
		return $this->responseService->returnMessage($books, 'No Books were Found.');
	}

	// Gets all books
	public function getAllWithSubject($subject_id)
	{
		// Get All Books
		$books = Book::where('subject_id', $subject_id)->get();

		// Passing data to response service
		return $this->responseService->returnMessage($books, 'No Books were Found.');
	}

	// Gets all books
	public function getAllWithPublisher($publisher_id)
	{
		// Get All Books
		$books = Book::where('publisher_id', $publisher_id)->get();

		// Passing data to response service
		return $this->responseService->returnMessage($books, 'No Books were Found.');
	}

	// Gets all books
	public function deleteAllWithBookType($book_type_id)
	{
		// Get All Books
		$books = Book::where('book_type_id', $book_type_id)->delete();

		// Passing data to response service
		return $this->responseService->returnMessage($books, 'No Books were Found.');
	}

	// Gets book by id
	public function find($id)
	{
		// Get book by id
		$book = Book::with('chapters.pages')->find($id);
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

			// Checking if there are any chapters
			if(isset($data['chapters']) && sizeof($data['chapters']) > 0)
			{
				// Looping through chapters
				foreach ($data['chapters'] as $chapter)
				{
					// Creating the chapter
					$this->chaptersService->insert($book->id, $chapter);
				}
			}

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

				// Checking if there are any chapters
				if(isset($data['chapters']) && sizeof($data['chapters']) > 0)
				{
					// Looping through chapters
					foreach ($data['chapters'] as $chapter)
					{
						if(isset($chapter['id']))
						{
							// Getting the chapter
							$findchapter = $this->chaptersService->find($book->id, $chapter['id']);
							// Checking if chapter exists
							if($findchapter['success'])
							{
								// Updating the chapter
								$this->chaptersService->update($book->id, $chapter['id'], $chapter);
							}
						}
						else
						{
							// Creating the workflow part
							$this->chaptersService->insert($book->id, $chapter);
						}
					}
				}

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

			if(!empty($chapters['data']))
			{
				// Delete related chapters
				foreach ($chapters['data'] as $chapter)
				{
					$this->chaptersService->delete($chapter->id);
				}
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