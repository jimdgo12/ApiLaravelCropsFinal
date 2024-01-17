<?php

namespace App\Http\Controllers\admin;

use App\Models\Crop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class AdminController extends Controller
{
    public function welcome()
    {
        $url = env('URL_SERVER_API');
        $response = Http::get($url . '/v1/crops');

        $crop = $response->json("data");
        return view('admin/WelcomeAdmin', ['crops' => $crop]);
    }
}
