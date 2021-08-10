<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\TransactionLogResource;

class AuthController extends Controller
{
    use ApiResponse;

    protected $UserService;

    /**
     * The String to generate a Valid API Token
     *
     * @var String $token_word
    */
    protected $token_word = 'Api Token Sanctum';

    /**
    * Inicar sesión
    * [Un usuario accede al sistema indicado correo y contraseña]
    * @group  Auth
    * @bodyParam email Correo
    * @bodyParam password Contraseña
    */
    public function login(AuthLoginRequest $request)
    {
        $data = $request->only(['email', 'password']);

        if (!Auth::attempt($data)) {
            return $this->errorResponse('Las credenciales no coinciden.', 401);
        }

        return $this->successResponse([
            'token' => auth()->user()->createToken($this->token_word)->plainTextToken,
            'user' => new UserResource(auth()->user()),
        ]);
    }


    /**
    * Consultar información personal
    * [Un usuario solicita información sobre su cuenta, como número de trasacciones y blance actual en saldo]
    * @group  Auth
    * @authenticated
    */
    public function me(Request $request)
    {
        $result = new UserProfileResource(auth()->user());
        return $this->successResponse($result);
    }

    
    /**
    * Listado de transacciones
    * [Un usuario solicita la lista de trasacciones que ha llevado a cabo]
    * @group  Auth
    * @authenticated
    */
    public function transactions(Request $request)
    {
        $result = TransactionLogResource::collection(auth()->user()->transactions);

        return $this->successResponse($result);
    }


    /**
    * Cerrar sesión
    * [Un usuario su cierra sesión actual]
    * @group  Auth
    * @authenticated
    */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return $this->successResponse('Sesión finalizada.');
    }
}
