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
use Laravel\Sanctum\NewAccessToken;
use Illuminate\Http\Response;



class AuthController extends Controller
{


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
        'email' => 'required|string|email|max:255|unique:users',
        'password' => [
            'required',
            'string',
            'min:8',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
        ],
    ], [
        'name.required' => 'O campo nome é obrigatório.',
        'email.required' => 'O campo e-mail é obrigatório.',
        'email.email' => 'O e-mail informado é inválido.',
        'email.unique' => 'Este e-mail já está registrado.',
        'password.required' => 'O campo senha é obrigatório.',
        'password' => 'A senha deve conter  8 caracteres (um caractere especial, uma letra maiúscula e um número)',
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
        'message' => 'Erro ao registrar usuário: ' . $e->getMessage(),
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
    try {
        // Valide as credenciais
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $credentials = $request->only('email', 'password');

        // Tente autenticar o usuário usando o guard 'web'
        if (!Auth::guard('web')->attempt($credentials)) {
            return response()->json([
                'message' => 'Senha inválida ou este email ainda não foi cadastrado.',
                'success' => false,
            ], 401);
        }

        // Autenticação bem-sucedida
        $user = Auth::guard('web')->user();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Login successful.',
            'success' => true,
        ], 200);
    } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Erro ao validar as credenciais',
            'errors' => $e->errors(),
        ], 422);
    }
}



public function logout(Request $request)
{
    $token = $request->bearerToken();

    if ($token) {
        $tokenParts = explode('|', $token);

        if (count($tokenParts) === 2) {
            $realToken = $tokenParts[1];

            $accessToken = PersonalAccessToken::whereToken(hash('sha256', $realToken))->first();


            if ($accessToken && $accessToken->tokenable_type === User::class) {
                $accessToken->delete();

                return response()->json(['message' => 'Logout efetuado com sucesso'], Response::HTTP_OK);

            }
        }
    }

    return response()->json(['message' => 'Não foi possível efetuar o logout'], Response::HTTP_UNAUTHORIZED);
}




    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        $token = $user->createToken('authToken')->plainTextToken;

        $tokenParts = explode('|', $token);
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
       $token = $request->bearerToken();
   
       if ($token) {
           $tokenParts = explode('|', $token);
   
           if (count($tokenParts) === 2) {
               $realToken = $tokenParts[1];
   
               $user = PersonalAccessToken::where('token', hash('sha256', $realToken))->first();
   
               if ($user && $user->tokenable_type === User::class) {
                   return response()->json([
                       'message' => 'Autenticado.',
                       'success' => true,
                   ], 200);
               }
           }
       }
   
       return response()->json([
           'message' => 'Não autenticado.',
           'success' => false,
       ], 401);
   }
   
   
   
   
   
    
}
