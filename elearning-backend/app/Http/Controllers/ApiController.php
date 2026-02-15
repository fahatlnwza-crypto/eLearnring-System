<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Display a listing of all resources.
     */
    public function index()
    {
        return response()->json([
            'message' => 'List of resources',
            'data' => []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return response()->json([
            'message' => 'Resource created successfully',
            'data' => $request->all()
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json([
            'message' => "Resource {$id} found",
            'data' => ['id' => $id]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        return response()->json([
            'message' => "Resource {$id} updated successfully",
            'data' => $request->all()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return response()->json([
            'message' => "Resource {$id} deleted successfully"
        ]);
    }
}
