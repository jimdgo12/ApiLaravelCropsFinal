<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;



class AuthenticationSessionController extends Controller
{
    public function create()
    {

        return view('auth.Login');
    }


    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');

        $request->validate([
            'email' => 'required|string|email|max:255|min:8',
            'password' => 'required|string'
        ]);

        // dd($request);

        // try {
            $response = Http::post($url . '/login', [
                'email' => $request->email,
                'password' => $request->password,
                'name' => 'browser',
            ]);
            // dd($response);

            // Agregar dd para verificar si ingresa al bloque try
            // dd('Ingresó al bloque try');

            if ($response->successful()) {
                $data = $response->json();
                $request->session()->put('api_token', $data['token']);
                $request->session()->put('user_name', $data['name']);
                $request->session()->put('user_email', $data['email']);

                $request->session()->regenerate();
                // dd('Redirigiendo a welcomeAdmin');

                return redirect()->route('WelcomeAdmin');
            } else {
                $statusCode = $response->status();
                $errorResponse = $response->json();

                return redirect()->route('login');

                // dd($statusCode, $errorResponse); // Agregar dd para imprimir información de error
            }
        // } catch (\Exception $e) {
        //     return back()->withErrors([
        //         'message' => "Error al conectar con el servidor API: {$e->getMessage()}"
        //     ]);
        // }
    }



    public function destroy(Request $request)
    {
        $url = env('URL_SERVER_API');

        $response = Http::withHeaders(['Authorization' => 'Bearer ' . $request->session()->get('api_token')])->post($url . '/logout');

        if ($response->successful()) {
            $request->session()->forget('api_token');
            //Destruir el archivo de sesión
            $request->session()->invalidate();
            //Obtener un nuevo token
            $request->session()->regenerateToken();

            return redirect()->route('login');
        } else {
            back()->withErrors([
                'message' => 'Error al cerrar sesión'
            ]);
        }
    }
}
