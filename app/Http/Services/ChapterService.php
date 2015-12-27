<?php

namespace App\Http\Services;

use Validator;
use App\Chapter as Chapter;
use App\Chapter as Chapter;
use App\Http\Services\ResponseService as ResponseService;

class ChapterService
{
	public $responseService;

	function __construct()
	{
		$this->responseService = new ResponseService();
	}

	// Gets all chapters
	public function getAll($book_id)
	{
		// Get All Chapters
		$chapters = Chapter::where('book_id', $book_id)->get();

		// Passing data to response service
		return $this->responseService->returnMessage($chapters, 'No Chapters were Found.');
	}

	// Gets chapter by id
	public function find($book_id, $chapter_id)
	{
		// Get chapter by id
		$chapter = Chapter::where('book_id', $book_id)->find($chapter_id);
		// Passing data to response service
		return $this->responseService->returnMessage($chapter, 'Chapter was not Found.');
	}

	// Inserts chapter
	public function insert($data)
	{
		// Validating data
		$validator = Validator::make($data, Chapter::createrules());

		// If there are no errors in data
		if(!$validator->fails())
		{
			// Create Chapter
			$chapter = Chapter::create($data);
			// Passing data to response service
			return $this->responseService->returnMessage($chapter, 'Chapter was not Inserted.');
		}
		else
		{
			// Data has errors
			// Passing errors to response service
			return $this->responseService->errorMessage($validator->errors()->all());
		}
	}

	// Updates chapter
	public function update($id, $data)
	{
		// Checking if chapter exists
		$chapter = Chapter::find($id);

		// If chapter exists
		if(!empty($chapter))
		{
			// Validating data
			$validator = Validator::make($data, Chapter::updaterules($id));

			// If there are no errors in data
			if(!$validator->fails())
			{
				// Update chapter
				$chapter->update($data);

				// Passing data to response service
				return $this->responseService->returnMessage($chapter, 'Chapter was not Updated.');
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
			// Chapter not found
			// Returning error message
			return $this->responseService->errorMessage('Chapter was not Found.');
		}
	}

	// Deletes chapter
	public function delete($id)
	{
		// Checking if chapter exists
		$chapter = Chapter::find($id);

		// If chapter exists
		if(!empty($chapter))
		{
			// Delete chapter
			$chapter->delete();

			// Returning success message
			return $this->responseService->returnSuccess();
		}
		else
		{
			// Chapter not found
			// Returning error message
			return $this->responseService->errorMessage('Chapter was not Found.');
		}
	}
}