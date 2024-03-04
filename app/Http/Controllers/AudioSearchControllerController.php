<?php

namespace App\Http\Controllers;

use App\Models\AudioSearchController;
use App\Http\Requests\StoreAudioSearchControllerRequest;
use App\Http\Requests\UpdateAudioSearchControllerRequest;
use Illuminate\Http\Request;


class AudioSearchControllerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('data');
        $result = AudioSearchController::where('audioName', 'like', "%$search%")->get();
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAudioSearchControllerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AudioSearchController $audioSearchController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AudioSearchController $audioSearchController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAudioSearchControllerRequest $request, AudioSearchController $audioSearchController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AudioSearchController $audioSearchController)
    {
        //
    }
}
