<?php

namespace App\Http\Services;

use Validator;
use App\Page as Page;
use App\Http\Services\ResponseService as ResponseService;

class PageService
{
	public $responseService;

	function __construct()
	{
		$this->responseService = new ResponseService();
	}

	// Gets all pages
	public function getAll($book_id, $chapter_id)
	{
		// Get All Pages
		$pages = Page::where('chapter_id', $chapter_id)->get();

		// Passing data to response service
		return $this->responseService->returnMessage($pages, 'No Pages were Found.');
	}
	
	// Gets page by id
	public function find($book_id, $chapter_id, $page_id)
	{
		// Get page by id
		$page = Page::where('chapter_id', $chapter_id)->find($page_id);

		// Passing data to response service
		return $this->responseService->returnMessage($page, 'Page was not Found.');
	}

	// Inserts page
	public function insert($chapter_id, $data)
	{
		// Setting the chapter id
		$data['chapter_id'] = $chapter_id;

		// Validating data
		$validator = Validator::make($data, Page::createrules());

		// If there are no errors in data
		if(!$validator->fails())
		{
			// Create Page
			$page = Page::create($data);
			// Passing data to response service
			return $this->responseService->returnMessage($page, 'Page was not Inserted.');
		}
		else
		{
			// Data has errors
			// Passing errors to response service
			return $this->responseService->errorMessage($validator->errors()->all());
		}
	}

	// Bulk insert
	public function insertBulk($chapter_id, $data)
	{
		foreach ($data as $page)
		{
			$page['chapter_id'] = $chapter_id;
		}

		// Create Page
		$page = Page::create($data);
		
		// Passing data to response service
		return $this->responseService->returnMessage($page, 'Page was not Inserted.');
	}

	// Updates page
	public function update($id, $data)
	{
		// Checking if page exists
		$page = Page::find($id);

		// If page exists
		if(!empty($page))
		{
			// Validating data
			$validator = Validator::make($data, Page::updaterules($id));

			// If there are no errors in data
			if(!$validator->fails())
			{
				// Update page
				$page->update($data);

				// Passing data to response service
				return $this->responseService->returnMessage($page, 'Page was not Updated.');
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
			// Page not found
			// Returning error message
			return $this->responseService->errorMessage('Page was not Found.');
		}
	}

	// Deletes page
	public function delete($id)
	{
		// Checking if page exists
		$page = Page::find($id);

		// If page exists
		if(!empty($page))
		{
			// Delete page
			$page->delete();

			// Returning success message
			return $this->responseService->returnSuccess();
		}
		else
		{
			// Page not found
			// Returning error message
			return $this->responseService->errorMessage('Page was not Found.');
		}
	}

	// Deletes all pages by chapter
	public function deleteAllWithChapter($chapter_id)
	{
		// Get All Pages
		$pages = Page::where('chapter_id', $chapter_id)->delete();

		// Passing data to response service
		return $this->responseService->returnMessage($pages, 'No Pages were Found.');
	}
}