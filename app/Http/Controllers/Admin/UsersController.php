<?php

namespace Vuetricks\Http\Controllers\Admin;

use Vuetricks\Http\Controllers\Controller;
use Vuetricks\Repositories\UserRepositoryInterface;

class UsersController extends Controller
{
    /**
     * User repository.
     *
     * @var \Vuetricks\Repositories\UserRepositoryInterface
     */
    protected $users;

    /**
     * Create a new UsersController instance.
     *
     * @param  \Vuetricks\Repositories\UserRepositoryInterface $users
     * @return void
     */
    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

    /**
     * Show the users index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->users->findAllPaginated();

        return view('admin.users.list', compact('users'));
    }
}
