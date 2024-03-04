<?php

namespace App\Http\Controllers;

use App\Models\ImageSearch;
use App\Http\Requests\StoreImageSearchRequest;
use App\Http\Requests\UpdateImageSearchRequest;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ImageSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $img_name = $request->input('img');
        $data = ImageSearch::where('imgName', 'like', "%$img_name%")->get();

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $search_word = $request->input('data');

        $client = new Client();
        $response = $client->request('POST', 'https://api.getimg.ai/v1/essential/text-to-image', [
            'body' => json_encode([
                'style' => 'photorealism',
                'prompt' => $search_word,
                'output_format' => 'jpeg'
            ]),
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer key-3cfN1H0pbWAXpTRexnq70oNjZlXGgZyf4uT55iIgrC8xdcWYwwaGO0Hgn2zfUk15kciA5E9Cwx0wsSzamOLbeaMuTqWoFkM0',
                'content-type' => 'application/json',
            ],
        ]);
        return $response->getBody();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageSearchRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ImageSearch $imageSearch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImageSearch $imageSearch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImageSearchRequest $request, ImageSearch $imageSearch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ImageSearch $imageSearch)
    {
        //
    }
}
