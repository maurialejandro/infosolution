<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\JwtAuth;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
    public function register(Request $request){
        $json = $request->input('json',null);
        $params = json_decode($json);
        
        $role = 'ADMIN';
        $name = (!is_null($json) && isset($params->name)) ? $params->name : null;
        $nickname = (!is_null($json) && isset($params->nickname)) ? $params->nickname : null;
        $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
        $password = (!is_null($json) && isset($params->password)) ? $params->password : null;
        if( !is_null( $email ) && !is_null( $nickname ) && !is_null( $name ) && !is_null( $password ) ){
            //modelo de usuario
            $user = new User();
            $user->id;
            $user->role =  $role;
            $user->name = $name;
            $user->nickname = $nickname;
            $user->email = $email;
            $pwd = hash( 'sha256', $password );
            $user->password = $pwd;
            
            //comprobate user duplicated
            $isset_user = array( User::where( 'email', '=', $email)->first());
            
             if( $isset_user == [null] ){
              
                //guardar usuario 
                $user->save();
                $data = array( 'status'=> 'success', 'code' => '200', 'message' => 'user registred' );
                   
            }else{
                //no guardar
                $data = array( 'status'=> 'error', 'code' => '400', 'message' => 'user duplicated' );
                 
            }
        }else{
            $data = array( 'status' => 'error', 'code' => '400', 'message' => 'user not created' );
        }
        return response()->json($data,200);
     
    }
    public function login(Request $request){
        
        $JwtAuth = new JwtAuth();
        $json = $request->input('json',null);
        $params = json_decode($json);
        
        $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
        $password = (!is_null($json) && isset($params->password)) ? $params->password : null;
        $getToken = (!is_null($json) && isset($params->getToken)) ? $params->getToken : null;
        
        $pwd = hash( 'sha256', $password );

        
        if(!is_null($email) && !is_null($password) && ($getToken == null || $getToken == 'false') ){

            $signup = $JwtAuth->signup($email,$pwd);
            return response()->json($signup,200); 
            
        }elseif(!is_null($getToken)){
            $signup = $JwtAuth->signup( $email ,$pwd, $getToken );
            
        }else{
            $signup= array(
                'status' => 'error', 'message' => 'Envia datos por post'
            );
        }

        return response()->json($signup,200); 
            

    }

}
