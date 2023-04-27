<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostModel;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    //
    public function index(Request $request): View{
        $datalist = PostModel::paginate(4);
        return view('home',compact('datalist'));
    }

    public function details($id){
        $data = PostModel::where('id','=',$id)->first(); 
        $datakomen = \DB::table('post')
        ->join('comment','comment.id_post','=','post.id')
        ->join('users','users.id','=','comment.id_user')
        ->select('users.name','users.id','comment.id as idkomen','comment.id_post','comment.comment','comment.id_user as idkomenuser')
        ->where('post.id','=',$id)
        ->get();
        return view('details',['data'=>$data,'komen'=>$datakomen]);
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

    public function regis_new(Request $request){
        $regis = new \App\Models\User();
        $regis->name = $request->name;
        $regis->password = Hash::make($request->password);
        $regis->email = $request->email;
        $regis->save();
        if($regis){
            return redirect('signin');
        }
    }

    public function keluar(){
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    
        return redirect('/');
    }
}
