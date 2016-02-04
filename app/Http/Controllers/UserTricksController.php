<?php

namespace Vuetricks\Http\Controllers;

use Illuminate\Http\Request;
use Vuetricks\Http\Controllers\Controller;
use Vuetricks\Repositories\TrickRepositoryInterface;
use Vuetricks\Repositories\TagRepositoryInterface;
use Vuetricks\Repositories\CategoryRepositoryInterface;

class UserTricksController extends Controller
{
	/**
     * Trick repository.
     *
     * @var \Vuetricks\Repositories\TrickRepositoryInterface
     */
    protected $tricks;

    /**
     * Tag repository.
     *
     * @var \Vuetricks\Repositories\TagRepositoryInterface
     */
    protected $tags;

    /**
     * Category repository.
     *
     * @var \Vuetricks\Repositories\CategoryRepositoryInterface
     */
    protected $categories;

    /**
     * Create a new UserTricksController instance.
     *
     * @param  \Vuetricks\Repositories\TrickRepositoryInterface  $tricks
     * @param  \Vuetricks\Repositories\TagRepositoryInterface  $tags
     * @param  \Vuetricks\Repositories\CategoryRepositoryInterface  $categories
     * @return void
     */
    public function __construct(
        TrickRepositoryInterface $tricks,
        TagRepositoryInterface $tags,
        CategoryRepositoryInterface $categories) {

        $this->middleware('auth');
        // $this->beforeFilter('trick.owner', [
        //     'only' => ['edit', 'update', 'destroy']
        // ]);

        $this->tricks      = $tricks;
        $this->tags       = $tags;
        $this->categories = $categories;
    }

    /**
     * Show the user's tricks page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tricks = $this->tricks->findAllForUser($request->user(), 12);
        return view('user.tricks.index', compact('tricks'));
    }

    /**
     * Show the create new trick page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tagList      = $this->tags->listAll();
        $categoryList = $this->categories->listAll();

        return view('user.tricks.create', compact('tagList','categoryList'));
    }

    /**
     * Handle the creation of a new trick.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
    	$this->validate($request, [
	        'title'         => 'required|min:4|unique:tricks,title',
	        'description'   => 'required|min:10',
	        'code'          => 'required'
	    ]);
        
        $trick = $this->tricks->createForUser($request->user(), $request->all());

        return redirect()->route('user.tricks.index');
    }
}
