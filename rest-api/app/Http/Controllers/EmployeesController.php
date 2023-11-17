<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeesController extends Controller
{
    // Membuat method index
    public function index()
    {
        // Mendapatkan semua data pegawai
        $employees = Employees::all();

        //Jika data kosong maka kirim status code 204
        if ($employees->isEmpty()) {
            $data = [
                'message' => 'kosong',
            ];
            return response()->json($data, 204);
        }

        $data = [
            'message' => 'Get All Employees',
            'data' => $employees
        ];

        // Mengirim data JSON dan code 200
        return response()->json($data, 200);
    }

    // Membuat method store 
    public function store(Request $request)
    {
        // Membuat validasi data
        $validatedData = $request->validate([
            "name" => "required",
            "gender" => ["required", Rule::in(['laki-laki', 'perempuan'])],
            "phone" => "required",
            "address" => "required",
            "email" => "required|email",
            "status" => ["required", Rule::in(['active', 'inactive'])],
            "hired_on" => "required|date_format:d/m/Y"
        ]);

        $employees = Employees::create($validatedData);

        $data = [
            'message' => 'Employees is created succesfully',
            'data' => $employees,
        ];

        // Mengembalikan data JSON dan code 201
        return response()->json($data, 201);
    }

    // Membuat method untuk mendapatkan detail pegawai
    public function show($id)
    {
        // Cari ID pegawai yang ingin didapatkan
        $employees = Employees::find($id);

        if ($employees) {
            $data = [
                'message' => 'Get Detail Employees',
                'data' => $employees
            ];

            //Mengambil data JSON dan kode 200
            return response()->json($data, 200);

        } else {
            $data = [
                'message' => 'Employees not found'
            ];

            //Mengembalikan data JSON dan kode 400
            return response()->json($data, 404);
        }
    }

    // Membuat method update
    public function update(Request $request, $id)
    {
        $employees = Employees::find($id);

        if ($employees) {
            $input = [
                'name' => $request->name ?? $employees->name,
                'gender' => $request->gender ?? $employees->gender,
                'phone' => $request->phone ?? $employees->phone,
                'address' => $request->address ?? $employees->address,
                'email' => $request->email ?? $employees->email,
                'status' => $request->status ?? $employees->status,
                'hired_on' => $request->hired_on ?? $employees->hired_on
            ];

            //Melakukan update input
            $employees->update($input);

            $data = [
                'message' => 'Employees is updated successfully',
                'data' => $employees,
            ];

            //Mengembalikan data JSON dan kode 200
            return response()->json($data, 200);

        } else {
            $data = [
                'message' => 'Employees not found'
            ];

            //Mengembalikan data JSON dan kode 404
            return response()->json($data, 404);
        }
    }

    // Membuat method delete untuk menghapus pegawai dengan ID
    public function destroy($id)
    {
        $employees = Employees::find($id);
        if ($employees) {
            $employees->delete();

            $data = [
                'message' => 'Employees has been deleted successfully',
            ];

            // Mengembalikan data JSON dan kode 200
            return response()->json($data, 200);
        }
        else {
            $data = [
                'message' => 'Employees not found',
            ];

            // Mengembalikan data JSON dan kode 404
            return response()->json($data, 404);
        }
    }

    // Membuat method untuk mencari data pegawai berdasarkan nama
    public function search($name)
    {
        // Menjalankan perintah search untuk mencari nama 
        $employees = Employees::where('name', 'like', "%$name%")->get();

        if ($employees) {
            $data = [
                'message' => 'Search Employees by Name',
                'data' => $employees,
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Employees not found',
            ];

            return response()->json($data, 404);
        }
    }

    //Membuat method untuk mendapatkan data pegawai yang active
    public function active()
    {
        // Perintah untuk mencari data active menggunakan elloquent where dan get
        $ActiveEmployees = Employees::where('status', 'active')->get();

        $data = [
            'message' => 'Get Active Employees',
            'data' => $ActiveEmployees,
        ];

        // Mengirim data JSON dan code 200
        return response()->json($data, 200);
    }

    //Membuat method untuk mencari data pegawai yang inactive
    public function inactive()
    {
        // Perintah untuk mencari data inactive menggunakan elloquent where dan get
        $InactiveEmployees = Employees::where('status', 'inactive')->get();

        $data = [
            'message' => 'Get inactive resource',
            'data' => $InactiveEmployees,
        ];

        // Mengirim data JSON dan code 200
        return response()->json($data, 200);
    }

    // Membuat method terminated 
    public function terminated()
    {
        // Perintah untuk mencari nama data terminated
        $employees = Employees::where('status', 'dihentikan')->get();

        if ($employees) {
            $data = [
                'message' => 'Get Terminated Employees',
                'data' => $employees
            ];
            // mengirim data JSON dan kode 200
            return response()->json($data, 200);

        } else {
            $data = [
                'message' => 'Employees not found',
                'data' => $employees
            ];

            // mengirim data JSON dan kode 404
            return response()->json($data, 404);
        }
    }
}
