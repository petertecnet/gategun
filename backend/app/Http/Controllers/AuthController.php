<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PersonalAccessToken;
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
    // Valide as credenciais
    $credentials = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    // Tente autenticar o usuário usando o guard 'api'
    if (!Auth::guard('api')->attempt($credentials)) {
        return response()->json([
            'message' => 'Senha inválida ou este email ainda não foi cadastrado.',
            'success' => false,
        ], 401);
    }

    // Autenticação bem-sucedida
    $user = Auth::guard('api')->user();
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
    $user = $request->user();

    // Revoga todos os tokens de acesso pessoal do usuário
    $user->tokens()->delete();

    return response()->json([
        'message' => 'Logged out successfully.',
        'success' => true,
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

   // Solicitação de verificação de autenticação
   public function checkAuth(Request $request)
   {
       $token = $request->bearerToken(); // Obtém o token do cabeçalho Authorization
   
       if ($token) {
           $user = PersonalAccessToken::where('token', $token)->first(); // Verifica se o token corresponde a um usuário
   
           if ($user) {
               return response()->json([
                   'message' => 'Autenticado.',
                   'success' => true,
               ], 200);
           }
       }
   
       return response()->json([
           'message' => 'Não autenticado.',
           'success' => false,
       ], 401);
   }
   
    
}
