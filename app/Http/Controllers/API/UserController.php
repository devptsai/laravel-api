<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 

use Illuminate\Support\Facades\DB; 
use Validator;
class UserController extends Controller 
{
    public $successStatus = 200;/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            // $user = Auth::user(); 
            // $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            // $user = DB::table('users')->where('email', request('email'))->first();
            $user = User::where('email', request('email'))->first();
            $success['isvalid'] = true;
            $success['data'] = $user;
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            $success['isvalid'] = false;
            return response()->json(['error'=>'Unauthorised','success'=>$success], $this-> successStatus); 
        } 
        // $credentials = [
        //     'email' => request('email'),
        //     'password' => request('password')
        // ];

        // $user = DB::table('users')->where('email', request('email'))->first();
 
        // if (auth()->attempt($credentials)) {
        //     // $token = auth()->user()->createToken('MyApp')->accessToken;
        //     $token = $user->api_token;
        //     return response()->json(['token' => $token], 200);
        // } else {
        //     return response()->json(['error' => 'UnAuthorised'], 401);
        // }
    }
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
        if ($validator->fails()) { 
                    return response()->json(['error'=>$validator->errors()], 401);            
                }
        $input = $request->all(); 
                $input['password'] = bcrypt($input['password']); 
                // $user = User::create($input);
                $user = User::create([
                    'name' =>$input['name'],
                    'email' =>$input['email'],
                    'password' =>$input['password'],
                    'api_token' =>"abcde"
                ]); 
                
                $success['token'] =  $user->createToken('MyApp')-> accessToken; 
                $success['name'] =  $user->name;
                $success['email'] =  $user->email;
                $upd = User::find($user->id);
                $upd->api_token = $success['token'];
                $upd->save();

        return response()->json(['success'=>$success], $this-> successStatus); 
    }
/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $users= Auth::user(); 
        // $user = User::where('id',$users->id);
        return response()->json(['success' => $users], $this-> successStatus); 
        // return response()->json(['user' => auth()->user()], 200);
    } 

}