<?php

namespace App\Http\Services;

use Validator;
use App\Chapter as Chapter;
use App\Http\Services\ResponseService as ResponseService;
use App\Http\Services\PageService as PageService;

class ChapterService
{
	public $responseService;
	public $pagesService;

	function __construct()
	{
		$this->responseService = new ResponseService();
		$this->pagesService = new PageService();
	}

	// Gets all chapters
	public function getAll($book_id)
	{
		// Get All Chapters
		$chapters = Chapter::with('pages')->where('book_id', $book_id)->get();

		// Passing data to response service
		return $this->responseService->returnMessage($chapters, 'No Chapters were Found.');
	}

	// Gets chapter by id
	public function find($book_id, $chapter_id)
	{
		// Get chapter by id
		$chapter = Chapter::with('pages')->where('book_id', $book_id)->find($chapter_id);
		// Passing data to response service
		return $this->responseService->returnMessage($chapter, 'Chapter was not Found.');
	}

	// Inserts chapter
	public function insert($book_id, $data)
	{
		// Setting the book id
		$data['book_id'] = $book_id;

		// Validating data
		$validator = Validator::make($data, Chapter::createrules());

		// If there are no errors in data
		if(!$validator->fails())
		{
			// Create Chapter
			$chapter = Chapter::create($data);

			// Checking if there are any pages
			if(isset($data['pages']) && sizeof($data['pages']) > 0)
			{
				// Looping through pages
				foreach ($data['pages'] as $page)
				{
					// Creating the page
					$this->pagesService->insert($chapter->id, $page);
				}
			}

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
	public function update($book_id, $id, $data)
	{
		// Checking if chapter exists
		$chapter = Chapter::where('book_id', $book_id)->where('id', $id)->first();;

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

				// Checking if there are any pages
				if(isset($data['pages']) && sizeof($data['pages']) > 0)
				{
					// Looping through pages
					foreach ($data['pages'] as $page)
					{
						if(isset($page['id']))
						{
							// Getting the page
							$findpage = $this->pagesService->find($chapter->id, $page['id']);
							// Checking if page exists
							if($findpage['success'])
							{
								// Updating the page
								$this->pagesService->update($chapter->id, $page['id'], $page);
							}
						}
						else
						{
							// Creating the workflow part
							$this->pagesService->insert($chapter->id, $page);
						}
					}
				}

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
			// Finding related pages
			$pages = $this->pagesService->deleteAllWithChapter($id);

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

	// Deletes chapter
	public function deleteAllWithBookID($id)
	{
		// Checking if chapter exists
		$chapters = Chapter::where('book_id', $id)->get();

		// If chapters exists
		if(sizeof($chapters) > 0)
		{
			// Delete related chapters
			foreach ($chapters as $chapter)
			{
				// Finding related pages
				$pages = $this->pagesService->deleteAllWithChapter($id);
			}

			Chapter::where('book_id', $id)->delete();

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