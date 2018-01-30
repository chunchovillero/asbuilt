<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('adminlte::auth.login');
    }

    public function login(Request $request){


        $this->validate(request(),[
            'email'=>'email|required|string',
            'password'=>'required|string'
        ]);

        $pass=hash('sha256', $request->password);

        $credentials = ['user_email' => $request->email, 'user_password' => $pass];
        
        if (Auth::attempt($credentials)) {
             return  redirect('proyectos');
        }

        return back()
            ->withErrors(['email'=>'Estas credenciales no coinciden con nuestros registros'])
            ->withInput(request(['email']));

    }

    public function logout(Request $request) {
      Auth::logout();
    return redirect('/login');
}

}
