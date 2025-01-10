<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Divisions;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        $query = $request->input('name');
        $divisions = Divisions::where('name', 'like', '%' . $query . '%')->latest()->paginate(5);        
        
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data',
            'data' => [
                'divisions' => $divisions->items(),
            ],            
            'pagination' => [
                'current_page' => $divisions->currentPage(),
                'last_page' => $divisions->lastPage(),
                'per_page' => $divisions->perPage(),
                'total' => $divisions->total(),
            ],
        ]);
    }
}
