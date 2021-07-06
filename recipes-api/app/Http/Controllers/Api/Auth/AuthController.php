<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Repositories\Contracts\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private $auth;
    
    public function __construct(AuthRepositoryInterface $auth)
    {
        $this->auth = $auth;
    }

    public function postAuth (AuthRequest $request)
    {
        try {
            $data = $request->only(['email', 'password']);
            $result = $this->auth->authenticate($data);

            return response()->json(['data' => $result], 200);

        } catch (ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 401);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => 'Wrong credentials'], 401);
        }
    }
}
