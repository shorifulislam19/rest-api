<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    public function show_user($id = null){
        if($id == ''){
            $users = User::get();
            return response()->json(['users' => $users],200);
        }
        else {
            $users = User::find($id);
            return response()->json(['users' => $users], 200);

    }
}

public function add_users(Request $request){
        if ($request->isMethod('post')) {
            $data = $request->all();
            // return $data;

            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ];

            $customeMessage = [
                'name.required' => 'name is required',
                'email.required' => 'email is required',
                'name.email' => 'Email must be a valid email ',
                'password.required' => 'password is required',
            ];

            $validator = Validator::make($data, $rules, $customeMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 402);
            }

            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();
            $message = 'user successfully added';
            return response()->json(['message' => $message], 201);
        }

}
//for multiple users

public function add_multiple_users(Request $request){
        if ($request->isMethod('post')) {
            $data = $request->all();
            // return $data;

            $rules = [
                'users.*.name' => 'required',
                'users.*.email' => 'required|email|unique:users',
                'users.*.password' => 'required',
            ];

            $customeMessage = [
                'users.*.name.required' => 'name is required',
                'users.*.email.required' => 'email is required',
                'users.*.name.email' => 'Email must be a valid email ',
                'users.*.password.required' => 'password is required',
            ];

            $validator = Validator::make($data, $rules, $customeMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 402);
            }

            foreach($data['users'] as $adduser){

                $user = new User();
                $user->name = $adduser['name'];
                $user->email = $adduser['email'];
                $user->password = bcrypt($adduser['password']);
                $user->save();
                $message = 'user successfully added';
                
            }
            return response()->json(['message' => $message], 201);
        }

}

    public function update_user_details(Request $request,$id)
    {
        if ($request->isMethod('PUT')) {
            $data = $request->all();
            // return $data;

            $rules = [
                'name' => 'required',
                'password' => 'required',
            ];

            $customeMessage = [
                'name.required' => 'name is required',
                'password.required' => 'password is required',
            ];

            $validator = Validator::make($data, $rules, $customeMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 402);
            }

            $user =  User::findOrFail($id);
            $user->name = $data['name'];
            $user->password = bcrypt($data['password']);
            $user->save();
            $message = 'user successfully Updated';
            return response()->json(['message' => $message], 202);
        }
    }

    public function update_single_records(Request $request, $id)
    {
        if ($request->isMethod('patch')) {
            $data = $request->all();
            // return $data;

            $rules = [
                'name' => 'required',
            ];

            $customeMessage = [
                'name.required' => 'name is required',
            ];

            $validator = Validator::make($data, $rules, $customeMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 402);
            }

            $user =  User::findOrFail($id);
            $user->name = $data['name'];
            $user->save();
            $message = 'user successfully Updated';
            return response()->json(['message' => $message], 202);
        }
    }

    public function delete_single_user($id=null){
        User::findOrFail($id)->delete();
        $message = 'user successfully deleted';
        return response()->json(['message' => $message], 200);

    }

    public function delete_single_user_with_json(Request $request){
        if ($request->isMethod('delete')) {
            $data = $request->all();
            User::where('id',$data['id'])->delete();
            $message = 'user successfully deleted';
            return response()->json(['message' => $message], 200);
        }
    }
    
    public function delete_multiple_user($ids){
        $ids = explode(',',$ids);
        User::whereIn('id',$ids)->delete();
        $message = 'user successfully deleted';
        return response()->json(['message' => $message], 200);
    }


    public function delete_multiple_user_with_json(Request $request)
    {
        $header = $request->header('authorization');
        if($header == ''){
            $message = ' authorization required';
            return response()->json(['message' => $message], 422);
        } else {
            if($header == 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6InRoaWsgYWNoZSIsImlhdCI6MTUxNjIzOTAyMn0.wTlLId3Ag8Y3UbBhbefGjDh3paknwzMK5nzl25-w-tE'){
                if ($request->isMethod('delete')) {
                    $data = $request->all();
                    User::whereIn('id', $data['ids'])->delete();
                    $message = 'user successfully deleted';
                    return response()->json(['message' => $message], 200);
                }
            }
            else {
                $message = ' authorization does not match';
                return response()->json(['message' => $message], 422);
            }
        }

    }
//  for register_user_using_passport

    public function register_user_using_passport(Request $request){
        if ($request->isMethod('post')) {
            $data = $request->all();
            // return $data;

            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ];

            $customeMessage = [
                'name.required' => 'name is required',
                'email.required' => 'email is required',
                'name.email' => 'Email must be a valid email ',
                'password.required' => 'password is required',
            ];

            $validator = Validator::make($data, $rules, $customeMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 402);
            }

            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();
            
            if(Auth::attempt(['email'=>$data['eamil'], 'passport' => $data['passport']])) {
                $user =User::where('email', $data['email'])->first();
                $access_token = $user->createToken($data['email'])->accessToken;
                User::where('email', $data['email'])->update(['access_token'=>$access_token]);


                $message = 'user successfully Registered';
                return response()->json(['message' => $message ,'access_token'=>$access_token], 201);
            } else {
                $message = 'OPS!! something went wrong';
                return response()->json(['message' => $message], 422);
            }

        }
    }

    public function login_user_using_passport(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // return $data;

            $rules = [
                'email' => 'required|email|exists:users',
                'password' => 'required',
            ];

            $customeMessage = [
                'email.required' => 'email is required',
                'name.email' => 'Email must be a valid email ',
                'name.exists' => 'Email does not exists ',
                'password.required' => 'password is required',
            ];

            $validator = Validator::make($data, $rules, $customeMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 402);
            }
            if (Auth::attempt(['email' => $data['eamil'], 'passport' => $data['passport']])) {
                $user = User::where('email', $data['email'])->first();
                $access_token = $user->createToken($data['email'])->accessToken;
                User::where('email', $data['email'])->update(['access_token' => $access_token]);


                $message = 'user successfully Login';
                return response()->json(['message' => $message, 'access_token' => $access_token], 201);
            } else {
                $message = 'Invalid Email or Password';
                return response()->json(['message' => $message], 422);
            }
        }
    }

}