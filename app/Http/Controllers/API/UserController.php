<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Visitor;
use App\Models\Assistant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Exception;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try{
            $valid_arr = [
                "email" => "required|email",
                "password" => "required"
            ];
            $valid = Validator::make($request->all(), $valid_arr);
            if ($valid->fails()){
                return $this->sendError('Invalid Validation', $valid->errors(), 400);
            }

            Log::channel("daily")->info("UserController.login() email ".$request->email);
            $credentials = request(['email', 'password']);
            if(!Auth::attempt($credentials)){
                Log::channel("daily")->info("UserController.login() Invalid Credential");
                return $this->sendError('Invalid Credential', null, 400);
            }

            $user = User::where('email', $request->email)->first();
            if(!Hash::check($request->password, $user->password, [])){
                Log::channel("daily")->info("UserController.login() Invalid Credential");
                throw new \Exception('Invalid Credential');
            }
    
            //jika token berhasil makan
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            $data = [
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ];
            return $this->sendResponse($data, 'Authenticated');
        } catch(Exception $error){
            Log::channel("daily")->info("UserController.login() catch");
            Log::channel("daily")->info($error);
            return $this->sendError('Login Failed', [
                'message' => 'something when wrong',
                'error' => $error
            ]);
        }
    }
    public function login_get(Request $request)
    {
        return $this->sendError('Unauthorized', null, 401);
    }
    public function register(Request $request)
    {
        try{
            $valid_arr = [
                'email' => 'required|string|email|max:50|unique:users',
                'password' => 'required|min:6',
                'name' => 'required',
                'phone' => 'required|min:9|regex:/(0)[0-9]{9}/'
            ];
            $valid = Validator::make($request->all(), $valid_arr);
            if ($valid->fails()){
                return $this->sendError('Invalid Validation', $valid->errors(), 400);
            }
            $userdb = User::create([
                'email'=> $request->email,
                'password'=> hash::make($request->password),
                'name'=> $request->name,
                'phone'=> $request->name,
                'email_verified_at'=> date('Y-m-d'),
            ]); //insert data
            $user = User::where('email', $request->email)->first();
            $tokenResult = $user->createToken('authToken')->plainTextToken;
    
            $data = [
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ];
            return $this->sendResponse($data, 'Successfull Register');
        } catch(Exception $error){
            Log::channel("daily")->info("UserController.registration() catch");
            Log::channel("daily")->info($error);
            return $this->sendError('Registration Failed', [
                'message' => 'something when wrong',
                'error' => $error
            ]);
        }
    }
    public function show(User $user)
    {
        try{
            $user = Auth::user($user);
            return $this->sendResponse($user, 'Succesfull get user');
        } catch(Exception $error){
            return $this->sendError('Show Failed', [
                'message' => 'something when wrong',
                'error' => $error
            ]);
        }

    }
    public function update(Request $request, User $user)
    {
        try{
            $auth = Auth::user($user);
            $valid_arr = [
                'email' => 'required|string|email|max:50|unique:users,email,'.$auth['id'].',id',
                'name' => 'required',
                'phone' => 'required|min:9|regex:/(0)[0-9]{9}/',
                'company' => 'required',
                'division' => 'required',
                'photo' => 'mimes:jpg,jpeg,png'
            ];
            $valid = Validator::make($request->all(), $valid_arr);
            if ($valid->fails()){
                return $this->sendError('Invalid Validation', $valid->errors(), 400);
            }
            $userUpdate = User::find($auth['id']);
            if($userUpdate == null){
                return $this->sendError('Invalid Validation', ["id" => ["Profile not found"]], 400);
            }
            $update = [
	            "email" => $request->email,
	            "name" => $request->name,
	            "phone" => $request->phone,
	            "company" => $request->company,
	            "division" => $request->division,
            ];
            if($request->password != ""){
                $update['password'] = hash::make($request->password);
            }
	        if ($request->hasFile("photo")){
	            $photo = $request->file("photo");
	        	if($photo->getSize() > 100000)
                    return $this->sendError('Invalid Validation', ["photo" => ["Max file size 100 KB. Uploaded image size ".($photo->getSize() / 1000)." KB"]], 400);
	        	$filename = date("YmdHis").".".$photo->extension();
	            \Storage::putFileAs("public/images/document", $photo, $filename);
	            $filename = "storage/images/document/".$filename;
	        	$update["photo"] = $filename;
	        }
            $userUpdate->update($update);

            return $this->sendResponse($user, 'Successfull Update');
        } catch(Exception $error){
            Log::channel("daily")->info("UserController.update() catch");
            Log::channel("daily")->info($error);
            return $this->sendError('Update Failed', [
                'message' => 'something when wrong',
                'error' => $error
            ]);
        }
    }
    public function logout()
    {
        $user = User::find(Auth::user()->id);
        $user->tokens()->delete();
        return response()->noContent();
    }
}
