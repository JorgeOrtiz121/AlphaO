<?php

namespace App\Http\Controllers\Emotions;

use App\Http\Controllers\Controller;
use App\Http\Resources\IraResource;
use App\Models\Ira;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class IraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ira=Ira::all();
        return $this->sendResponse(message: 'Emotions list generated successfully', result: [
            'iras' => IraResource::collection($ira),
        ]);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $ira= $request ->validate([
            'video' => ['file','mimes:mp4'],
        ]);
        $file = $ira['video'];
        $uploadedFileUrl = Cloudinary::uploadVideo($file->getRealPath(),['folder'=>'emotions','resource_type'=>'video','chunk_size'=>6000000]);
        $url = $uploadedFileUrl->getSecurePath();
         Ira::create(
            [
                "Tema"=>$request->Tema,
                "descripcion"=>$request->descripcion,
                "video"=>$url
            ]
         );
         return $this->sendResponse('Emotion created succesfully',204);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ira $ira)
    {
        //
        return $this->sendResponse(message: 'Emotion details', result: [
            'iras' => new IraResource($ira)
        ]);
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Ira $emotion)
    {
        //
        $ira= $request -> validate([
            'video' => ['required','file','mimes:mp4','max:6000000'],
        ]);
        $file = $ira['video'];
        $uploadedFileUrl = Cloudinary::uploadVideo($file->getRealPath(),['folder'=>'emotions']);
        $url = $uploadedFileUrl->getSecurePath();

         $emotion->update([
            "Tema"=>$request->Tema,
            "descripcion"=>$request->descripcion,
            "video"=>$url
         ]);
         return $this->sendResponse('Emotion update succesfully',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ira $ira)
    {
        //
        $ira->delete();
        return $this->sendResponse("Emotion delete succesfully", 200);
    }
}
