<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {           
        // Ambil parameter dari request
        $name = $request->input('name');
        $divisionId = $request->input('division_id');

        // Query data berdasarkan filter
        $query = Employees::query();

        $query->join('divisions', 'employees.division_id', '=', 'divisions.id');
        if ($name) {
            $query->where('employees.name', 'LIKE', "%{$name}%");
        }

        if ($divisionId) {
            $query->where('employees.division_id', $divisionId);
        }

        $employees = $query->select('employees.*', 'divisions.name as division_name', 'divisions.id as division_id')->latest()->paginate(5);
        
        $data = $employees->map(function ($employee) {
            return [
                'id' => $employee->id,
                'image' => $employee->image,
                'name' => $employee->name,
                'phone' => $employee->phone,
                'division' => [
                    'id' => $employee->division_id,
                    'name' => $employee->division_name,
                ],
                'position' => $employee->position,
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data',
            'data' => [
                'employees' => $data,
            ],            
            'pagination' => [
                'current_page' => $employees->currentPage(),
                'last_page' => $employees->lastPage(),
                'per_page' => $employees->perPage(),
                'total' => $employees->total(),
            ],
        ], 200);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image'     => 'required',
            'name'     => 'required',
            'phone'   => 'required',
            'division'   => 'required',
            'position'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }        

        //create post
        $employee = Employees::create([
            'image'     => $request->image,
            'name'     => $request->name,
            'phone'   => $request->phone,
            'division_id'   => $request->division,
            'position'   => $request->position,
        ]);

        //return response
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menambah data',
            'data' => $employee
        ], 200);
    }

    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image'     => 'required',
            'name'     => 'required',
            'phone'   => 'required',
            'division'   => 'required',
            'position'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $employee = Employees::find($id);

        $employee->update([
            'image'     => $request->image,
            'name'     => $request->name,
            'phone'   => $request->phone,
            'division_id'   => $request->division,
            'position'   => $request->position,
        ]);

        //return response
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah data',
            'data' => $employee
        ], 200);
    }

    public function destroy($id)
    {

        //find post by ID
        $employee = Employees::find($id);

        //delete post
        $employee->delete();

        //return response
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus data',            
        ], 200);
    }
}
