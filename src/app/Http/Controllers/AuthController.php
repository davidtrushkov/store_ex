<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller {

    /**
     * Get the Login View.
     */
    public function getLogin() {
        return view('auth.login');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * Login in the user.
     */
    public function postLogin(Request $request)
    {
        // Validate the user fields.
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // If the sign in request is successful, then show message, and redirect user.
        if ($this->signIn($request)) {
            flash()->success('Success', 'Logged In successfully!');
            return redirect('/');
        }

        // Else, show error message, and redirect them back to login.php.
        flash()->error('Error', 'Could not login with those credentials!');
        return redirect('login');
    }


    /**
     * Attempt to sign in the user.
     *
     * @param  Request $request
     * @return boolean
     */
    protected function signIn(Request $request) {
        return Auth::attempt($this->getCredentials($request));
    }


    /**
     * Get the login credentials and requirements.
     *
     * @param  Request $request
     * @return array
     */
    protected function getCredentials(Request $request) {
        return [
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ];
    }

    /**
     * Logout user.
     */
    public function logout() {
        Auth::logout();
        return redirect('/');
    }


}
