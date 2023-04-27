<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostModel;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index(Request $request): View{
        $datalist = PostModel::paginate(4);
        return view('home',compact('datalist'));
    }

    public function details($id){
        $data = PostModel::findOrfail($id)->first();
        return view('details',['data'=>$data]);
    }

    public function signin(){
        return view('signin');
    }

    public function authentication(Request $request){

        
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
       
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('home');
        };

        return back()->withErrors([
            'email' => 'Credential anda tidak dapat dikenali,silahkan coba lagi',
        ])->onlyInput('email');
    }

    public function keluar(){
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    
        return redirect('/');
    }
}
