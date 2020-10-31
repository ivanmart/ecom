<?php

namespace App\Http\Controllers;

use Backpack\PageManager\app\Models\Page;

/**
 * Page controller
 */
class PageController extends Controller
{

    /**
     * Index page method
     * @param  string $slug
     * @return View
     */
    public function index($slug)
    {
        $page = Page::findBySlugOrFail($slug);

        $this->data['title'] = $page->title;
        $this->data['page'] = $page->withFakes();

        return view('pages.'.$page->template, $this->data);
    }
}
