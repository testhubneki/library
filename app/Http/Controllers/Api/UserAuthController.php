<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Request;

use App\Models\User;
use App\Models\UserRole; 
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    private $role_user_id = 2;
    private $token = 'Te3&kdY23%b!f$';
    /** 
     * @paramIn($request data) type array, checking validation input
     * @paramOut() data for registerin user
     * inserting user and get token
     * inserting user role always
     **/ 

    public function register(RegisterRequest $request) 
    {
        $request->validated();
        try 
        {
            \DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            $id = $user->id;

            UserRole::create([
                'user_id' => $id,
                'role_id'=>$this->role_user_id
            ]);

            $token = $user->createToken($this->token)->accessToken;

            \DB::commit();
            
            return response()->json(['message'=>'Success','id'=>$id,'user'=>$user, 'token' => $token], 200);

        } catch (\Exception $e){
            \DB::rollBack();
            return response()->json(['error'=>'Error'], 409);
            //exception message use only on dev enviroment
            //return response()->json(['error'=>$e->getMessage()], 409);
        }
        
    }

     /** 
     * @paramIn($request data) type array, checking validation input
     * @paramOut() user data token
     **/ 
    public function login(LoginRequest $request) 
    {
        $data = $request->validated();
        if (auth()->attempt($data)) {

            $token = auth()->user()->createToken($this->token)->accessToken;
            $name = auth()->user()->name;
             return response()->json(['name'=>$name, 'token' => $token], 200);

        } else {

            return response()->json(['error' => 'Unauthorised. Bad credentials'], 401);
        }
    }


    /**
     * Logout
     */
    public function logout()
    {

        $user = Auth::user()->token();
        $user->revoke();

         return response()->json(['message' => 'Successfully logout'], 200);
    }

    
    
}
