<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

use Illuminate\Validation\ValidationException;
class AuthController extends Controller
{
    // ...
    private function hasSequentialNumbers($password)
{
    $numbers = '0123456789';

    for ($i = 0; $i < strlen($numbers) - 2; $i++) {
        $sequence = substr($numbers, $i, 3);
        if (strpos($password, $sequence) !== false) {
            return true;
        }
    }

    return false;
}



public function register(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    // Verificar se o e-mail já está registrado
                    $user = User::where('email', $value)->first();
                    if ($user) {
                        throw ValidationException::withMessages([
                            'email' => 'Este e-mail já está registrado.',
                        ]);
                    }
                },
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                function ($attribute, $value, $fail) {
                    // Verificar se a senha contém números sequenciais
                    if ($this->hasSequentialNumbers($value)) {
                        $fail('A senha não pode conter números sequenciais, deve conter uma letra maiúscula e um caractere especial.');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Usuário registrado com sucesso',
        ], 201);
    } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Erro ao registrar usuário',
            'errors' => $e->errors(),
        ], 422);
    } catch (QueryException $e) {
        return response()->json([
            'message' => 'Erro ao registrar usuário: ' . $e->getMessage(),
        ], 422);
    }
}
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    if (!Auth::attempt($credentials)) {
        return response()->json([
            'message' => 'Login failed. Invalid credentials.',
            'success' => false,
        ], 401);
    }

    $user = $request->user();
    $token = $user->createToken('authToken')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
        'message' => 'Login successful.',
        'success' => true,
    ], 200);
}


public function logout(Request $request)
{
    $userId = Auth::id();

    // Realizar o logout do usuário com base no $userId

    return response()->json([
        'message' => 'Logged out successfully',
    ], 200);
}

    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
