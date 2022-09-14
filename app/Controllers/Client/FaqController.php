<?php

namespace App\Controllers\Client;

use App\Models\FaqModel;
use App\Controllers\BaseController;

class FaqController extends BaseController
{

	public function __construct()
	{
		$this->FaqModel = new FaqModel();
	}

	public function index()
	{
		// $faqRequest = $this->FaqModel->GetFaqLatest();
		// $faq = $faqRequest;

		$data = [
			'title' => "Home Page",
			// 'faq' => $faq,
		];
        // dd($data);
		return view('pages/navigation/faq', $data);
	}
}