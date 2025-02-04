<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Interfaces\UserInterface;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    use ApiResponseTrait;

    protected $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        $result = $this->userRepository->register($data);

        return $this->successResponse($result, 'Registration successful', 201);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->only(['email', 'password']);
        $result = $this->userRepository->login($data);

        return $this->successResponse($result, 'Login successful');
    }

    public function logout(Request $request)
    {
        $this->userRepository->logout($request->user());
        return $this->successResponse([], 'Logged out successfully');
    }
}
