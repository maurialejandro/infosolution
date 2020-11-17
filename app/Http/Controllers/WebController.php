<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\JwtAuth;
use App\Models\Web;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class WebController extends Controller
{
    public function index(Request $request){
        $hash = $request->header('Authorization',null);
        $JwtAuth = new JwtAuth;
        $checkToken = $JwtAuth->checktoken($hash); 
        if($checkToken){
            return 'Autenticado';    
        }else{
            return 'no autenticado';
        }
    }
    public function store(Request $request){
        $hash = $request->header('Authorization',null);
        $JwtAuth = new JwtAuth;
        $checkToken = $JwtAuth->checktoken($hash); 
       
        if($checkToken){
            $json = $request->input('json',null);
            $user = $JwtAuth->checkToken($hash,true);
            return response($request);
                $validator = Validator::make($request->all(), [
                    //'image' => 'required|mimes:jpeg,png,jpg,doc,docx,pdf,mp4,mov,ogg,qt',
                    'title' => 'required',
                    'description' => 'required',
                    'price' => 'required|numeric',
                ]);
                    
                if ($validator->fails()) {
                    return response()->json($validator->errors(),400);
                }

                //guardar new Web 
                $web = new Web();
                $web->user_id = $user->sub;
                $web->title = $request->input('title');
                $web->description = $request->input('description');
                $web->price = $request->input('price');
                //$path = $request->image->store('webs');
                //$web->img = $path;
                $web->save();
   
                $data = array(
                    'message' => 'success',
                    'code' => 200
                 );    
                
            }else{
                $data = array(
                    'message' => 'login incorrecto',
                    'code' => 404
                 );    
                
        }
        return response()->json($data);
    }
}
