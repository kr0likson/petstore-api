<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PetApiController extends Controller
{
    private $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.petstore.base_uri');
    }

    public function index(Request $request)
    {
        try {
            $status = $request->query('status', 'available');
            $response = Http::get("{$this->baseUri}/pet/findByStatus", [
                'status' => $status
            ]);

            if ($response->successful()) {
                $pets = collect($response->json())
                ->sortBy('id');
                return view('pets.list', compact('pets'));
            }

            return response()->json(['error' => 'Failed to fetch pets.'], $response->status());

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|integer',
                'category' => 'required|string',
                'name' => 'required|string',
                'photoUrls' => 'required|array',
                'photoUrls.*' => 'required|string',
                'status' => 'required|string|in:available,pending,sold',
            ]);

            $data['category'] = ['name' => $data['category']];
    
            $response = Http::post("{$this->baseUri}/pet", $data);
    
            if ($response->successful()) {
                return response()->json($response->json(), 201);
            }
    
            return response()->json(['error' => 'Failed to add pet.'], $response->status());
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
    

    public function show($id)
    {
        try {
            $response = Http::get("{$this->baseUri}/pet/{$id}");

            if ($response->successful()) {
                return response()->json($response->json(), 200);
            }

            return response()->json(['error' => 'Failed to fetch pet.'], $response->status());

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'category' => 'required|string',
                'name' => 'required|string',
                'photoUrls' => 'required|array',
                'photoUrls.*' => 'required|string',
                'status' => 'required|string|in:available,pending,sold',
            ]);

            $data['category'] = ['name' => $data['category']];

            $response = Http::put("{$this->baseUri}/pet", array_merge($data, ['id' => $id]));

            if ($response->successful()) {
                return response()->json($response->json(), 200);
            }

            return response()->json(['error' => 'Failed to update pet.'], $response->status());

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $response = Http::delete("{$this->baseUri}/pet/{$id}");

            if ($response->successful()) {
                return response()->json(null, 204);
            }

            return response()->json(['error' => 'Failed to delete pet.'], $response->status());

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
