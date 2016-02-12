<?php

namespace Vuetricks\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Auth\AuthManager;
use Laravel\Socialite\Contracts\Factory as SocialiteManager;
use Vuetricks\Http\Controllers\Controller;
use Vuetricks\Repositories\UserRepositoryInterface;

class AuthController extends Controller
{
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/user/tricks';

    /**
     * Auth manager instance to manage the authetication.
     *
     * @var \Illuminate\Auth\AuthManager
     */
    protected $auth;

    /**
     * Data access and persistance layer for the user entity.
     *
     * @var \Vuetricks\Repositories\UserRepositoryInterface
     */
    protected $users;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(AuthManager $auth, UserRepositoryInterface $users)
    {
        $this->middleware('guest', ['except' => 'getLogout']);

        $this->auth = $auth;
        $this->users = $users;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validate($request, [
            'username'  => 'required|min:4|alpha_num|unique:users,username',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $this->auth->login($this->users->create($request->all()));

        return redirect($this->redirectPath());
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required', 
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if ($this->auth->attempt($credentials, $request->has('remember'))) {
            return redirect()->intended($this->redirectPath());
        }

        return redirect()->back()
            ->withInput($request->only('username', 'remember'))
            ->withErrors(['username' => 'These credentials do not match our records.']);      
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        $this->auth->logout();
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath')) {
            return $this->redirectPath;
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(SocialiteManager $socialite)
    {
        return $socialite->driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(SocialiteManager $socialite)
    {
        try 
        {
            $user = $socialite->driver('github')->user();

            $authenticatedUser = $this->users->findOrCreateUserFromProviderData($user);
            $this->auth->login($authenticatedUser, true);

            return redirect()->route('pages.home');
        } 
        catch (Exception $e) 
        {
            return redirect()->route('auth.github');
        }
    }
}
