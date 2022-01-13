<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends  BaseController
{

    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

//        if($validator->fails()){
//            return $this->sendError('Validation Error.', $validator->errors());
//        }
//
//        $input = $request->all();
//        $input['password'] = bcrypt($input['password']);
//        $user = User::create($input);
//        $success['token'] =  $user->createToken('MyApp')->accessToken;
//        $success['name'] =  $user->name;
//
//        return $this->sendResponse($success, 'User register successfully.');
//
//        $validator =  Validator::make($request->all(),[
//           'name'=>'required',
//           'email'=>'required|email',
//           'phone'=>'required',
//           'password'=>'required|min:8',
//        ]);

        if ($validator->fails()){
            return response()->json(['status'=>'fail','validation_error'=>$validator->errors()]);
        }
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        if ($user){
            return response()->json(['status'=>'success','message'=>'User Registration successfully completed','data'=>$user]);
        }
        return response()->json(['status'=>'fail','message'=>'User Registration fail']);
    }

    public function login(Request $request){

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['name'] =  $user;
//            $success =  $user;

            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }

//        $validator = Validator::make($request->all(),[
//           'email' => 'required|email',
//           'password' => 'required|main:8',
//        ]);
//        if ($validator->fails()){
//            return response()->json(['status'=>'fail','validation_error'=>$validator->errors()]);
//        }
//        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
//            $user = Auth::user();
//            $token = $user->createToken('usertoken')->accessToken;
//            return response()->json(['status'=>'success','login'=>true,'token'=>$token,'data'=>$user]);
//        }else{
//            return response()->json(['status'=>'fail','message'=>'Whoops! email or Password invalid']);
//        }

    }

    public function userDetails(){
        $user = Auth::user();
//        $user = User::all();
        if ($user){
            return response()->json(['status'=>'success','data'=>$user]);
        }else{
            return response()->json(['status'=>'fail','message'=>'user not found']);
        }

    }

    public function userShow($id){
        $user = User::find(Auth::id());
//        $user = User::find($id);
        if ($user){
            return response()->json(['status'=>'success','data'=>$user]);
        }else{
            return response()->json(['status'=>'fail','message'=>'user not found']);
        }
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
