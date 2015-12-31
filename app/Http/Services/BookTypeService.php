<?php

namespace App\Http\Services;

use Validator;
use App\BookType as BookType;
use App\Http\Services\ResponseService as ResponseService;
use App\Http\Services\BookService as BookService;

class BookTypeService
{
	public $responseService;
	public $booksService;

	function __construct()
	{
		$this->responseService = new ResponseService();
		$this->booksService = new BookService();
	}

	// Gets all book types
	public function getAll()
	{
		// Get All Book Types
		$bookTypes = BookType::get();

		// Passing data to response service
		return $this->responseService->returnMessage($bookTypes, 'No Book Types were Found.');
	}

	// Gets book type by id
	public function find($id)
	{
		// Get book type by id
		$bookType = BookType::find($id);
		// Passing data to response service
		return $this->responseService->returnMessage($bookType, 'Book Type was not Found.');
	}

	// Inserts book type
	public function insert($data)
	{
		// Validating data
		$validator = Validator::make($data, BookType::createrules());

		// If there are no errors in data
		if(!$validator->fails())
		{
			// Create Book Type
			$bookType = BookType::create($data);
			// Passing data to response service
			return $this->responseService->returnMessage($bookType, 'Book Type was not Inserted.');
		}
		else
		{
			// Data has errors
			// Passing errors to response service
			return $this->responseService->errorMessage($validator->errors()->all());
		}
	}

	// Updates book type
	public function update($id, $data)
	{
		// Checking if book type exists
		$bookType = BookType::find($id);

		// If book type exists
		if(!empty($bookType))
		{
			// Validating data
			$validator = Validator::make($data, BookType::updaterules($id));

			// If there are no errors in data
			if(!$validator->fails())
			{
				// Update book type
				$bookType->update($data);

				// Passing data to response service
				return $this->responseService->returnMessage($bookType, 'Book Type was not Updated.');
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
			// Book Type not found
			// Returning error message
			return $this->responseService->errorMessage('Book Type was not Found.');
		}
	}

	// Deletes book type
	public function delete($id)
	{
		// Checking if book type exists
		$bookType = BookType::find($id);

		// If book type exists
		if(!empty($bookType))
		{
			// Finding related books
			$books = $this->booksService->getAllWithBookType($id);

			if (!empty($books['data']))
			{
				// Delete related books
				foreach ($books['data'] as $book)
				{
					$this->booksService->delete($book->id);
				}
			}

			// Delete book type
			$bookType->delete();

			// Returning success message
			return $this->responseService->returnSuccess();
		}
		else
		{
			// Book Type not found
			// Returning error message
			return $this->responseService->errorMessage('Book Type was not Found.');
		}
	}
}