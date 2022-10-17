<?php

namespace App\Http\Controllers\Banner;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    //
    public function index()
    {
        $banner=Banner::all();
        return $this->sendResponse(message: 'Banner list generated successfully', result: [
            'banners' => BannerResource::collection($banner),
        ]);
    }

    public function store(Request $request)
    {
         // Validación de los datos de entrada
         // Crear un array asociativo de clave y valor
        $jail_data = $request -> validate([
            'fotografias' => ['required', 'string', 'min:3', 'max:100'],
            // https://laravel.com/docs/9.x/validation#rule-alpha-dash
           
        ]);


        // https://laravel.com/docs/9.x/eloquent#inserts
        Banner::create($jail_data);
        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(message: 'Banner stored successfully');
    }

    public function destroy(Banner $banner){
        $banner->delete();

        return response(null, 204);
    }
}
