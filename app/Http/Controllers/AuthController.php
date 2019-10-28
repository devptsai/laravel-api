<?php

namespace App\Http\Controllers;


use App\ModelAuth;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
// use App\Helpers\HttpRequestHelper as HttpRequest;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('login');
        if(!Session::get('login')){
            return redirect('login')->with('alert','Kamu harus login dulu');
        }
        else{
           
            return view('dash');
        }
        
    }

    public function login(){
        return view('login');
    }

    public function logout(){
        Session::flush();
        return redirect('login')->with('alert','Kamu sudah logout');
    }
    
    public function cek_auth(Request $request)
    {
        $email = $request->email;
        $pass = $request->password;

        $email = $request->email;
        $password = $request->password;

        $data = ModelAuth::where('email',$email)->first();
        if($data){ //apakah email tersebut ada atau tidak
            if(Hash::check($password,$data->password)){
                Session::put('name',$data->name);
                Session::put('email',$data->email);
                Session::put('login',TRUE);
                Session::put('api_token',$data->api_token);
                return redirect('/');
            }
            else{
                return redirect('login')->with('alert','Password atau Email, Salah !');
            }
        }
        else{
            return redirect('login')->with('alert','Password atau Email, Salah!');
        }
        // $client = new Client();
        // // $response = HttpRequest::Post("http://127.0.0.1:8000/api/login",[
        // //         'form_params' => [
        // //             'email' => $email,
        // //             'password' => $pass
        // //         ]
        // //     ]);

        // // $res = $client->request('POST', 'http://127.0.0.1:8000/api/login',[
        // //     'form_params' => [
        // //         'email' => $email,
        // //         'password' => $pass
        // //     ]
        // // ]);

        // // $response = $client->request('GET', 'http://127.0.0.1:8000/api/siswa');

        // // if ($response->getStatusCode() == 200) { // 200 OK
        // //     $response_data = $res->getBody()->getContents();
        // // }
    
        // // dd($response_data);
         
        // $request = $client->get('http://dev.simkug.com/web/server/testAPI/siswa.php');

        // $response = $request->getBody()->getContents();
        // dd($response);

    }

    public function register(Request $request){
        return view('register');
    }

    public function registerPost(Request $request){
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|min:4|email|unique:users',
            'password' => 'required',
            'confirmation' => 'required|same:password',
        ]);

        $data =  new ModelUser();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->save();
        return redirect('login')->with('alert-success','Kamu berhasil Register');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
