<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
use Illuminate\Http\Request;
use DataTables; 
use Illuminate\Support\Facades\Auth;
use App\Models\CommentModel;

class PostController extends Controller
{
    //
    public function index(){
        echo 1;
    }

    public function mypost(Request $request){
        return view('mypost');
    }

    public function savepost(Request $request){
       
        $fotonya = $request->file('foto')->getClientOriginalName();
        if($request->id == NULL || $request->id == ''){
            
            $destinationPath = 'uploads';
            $posting_foto = $request->file('foto');  

            if($posting_foto == NULL || !$posting_foto || $posting_foto == ''){
                $post = new \App\Models\PostModel();
                $post->title = $request->title;
                $post->content = $request->content; 
                $post->authors = Auth::user()->name;
                $post->pubdate = date('Y-m-d');
                $post->user_id = Auth::user()->id;
                $post->is_headline = $request->is_headline;  
                $post->save();
            }else{
                $post = new \App\Models\PostModel();
                $post->title = $request->title;
                $post->content = $request->content; 
                $post->authors = Auth::user()->name;
                $post->pubdate = date('Y-m-d');
                $post->is_headline = $request->is_headline;   
                $post->foto = $fotonya; 
                $post->user_id = Auth::user()->id;
                $posting_foto->move($destinationPath,$fotonya); 
                $post->save();
            }
         
 
        }else{
            $posting_foto = $request->file('foto'); 
            $destinationPath = 'uploads';
            
            if($posting_foto == NULL || !$posting_foto || $posting_foto == ''){
                \DB::table('post')->where('id',$request->id)->update([
                    'title' => $request->title,
                    'content' => $request->content,
                    'authors' => Auth::user()->name,
                    'user_id' => Auth::user()->id,
                    'pubdate' =>  date('Y-m-d'),
                    'is_headline' => $request->is_headline                  
                ]);
               
            }else{
                \DB::table('post')->where('id',$request->id)->update([
                    'title' => $request->title,
                    'content' => $request->content,
                    'authors' => Auth::user()->name,
                    'pubdate' =>  date('Y-m-d'),
                    'user_id' => Auth::user()->id,
                    'is_headline' => $request->is_headline,
                    'foto' => $fotonya
                ]);
                $posting_foto->move($destinationPath,$posting_foto->getClientOriginalName());
            }
            
        }
      
    }

    public function datalist(Request $request){ 
        if ($request->ajax()) {
            $data = \DB::table('post')->where('user_id','=',Auth::user()->id)->get();
            // $data = PostModel::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = ' <a href="javascript:void(0)" onclick="UbahData('.$row->id.');" class="edit btn btn-success btn-sm"> Edit</a> 
                    <a href="javascript:void(0)" onclick="DeleteData('.$row->id.');" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function get_data(Request $request){
        $id = $request->id;
        $post = PostModel::where('id',$id)->first();
        return $post;
    }

    public function destroy(Request $request){
        $id  = $request->id;
        $post = PostModel::findOrFail($id);
  
        //delete post
        $post->delete();

    }  

    public function comment(Request $request){
        $comment = new \App\Models\CommentModel();
        $comment->id_post = $request->id_post;
        $comment->id_user = $request->id_user;
        $comment->comment = $request->comment;
        $comment->save();

        if($comment){
            
            return redirect('details/'.$request->id_post);
        }
    }

    public function delete_comment($id){
        $data = CommentModel::findOrfail($id);
        $data->delete();
        return redirect()->back();
    }

    public function get_comment(Request $request){
        $id = $request->id;
        $post = \DB::table('comment')->where('id','=',$id)->first(); 
        return $post; 
    }

    public function update_comment(Request $request){
        $idcommentdata = $request->idcommentdata;
        $commentdata = $request->commentdata;
        \DB::table('comment')->where('id',$request->idcommentdata)->update([
            'comment' => $request->commentdata
            
        ]);
        return redirect()->back();
    }


    
}
