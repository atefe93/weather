<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    /**
     * Register New User
     * @method POST
     * @param Request $request
     */
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
           // 'c_password' => 'required|same:password',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $user = resolve(UserRepository::class)->create($request);

        $token = $user->createToken('myApp')->plainTextToken;


        return response()->json([
            'user' => $user,
            'token' => $token
        ], Response::HTTP_CREATED);
    }

    /**
     * login user
     * @method POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        //Validate Form Inputs

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $user = resolve(UserRepository::class)->user($request);

        if (!$user) {
            return response()->json('user not found', 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json('password is incorrect', 401);
        }

        $token = $user->createToken('myApp')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);



    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'logged out successfully'
        ], Response::HTTP_OK);

    }




}
