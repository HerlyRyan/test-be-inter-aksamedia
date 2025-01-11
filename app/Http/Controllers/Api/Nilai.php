<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Nilai as ModelsNilai;
use Illuminate\Http\Request;

class Nilai extends Controller
{
    public function nilaiRT(Request $request)
    {           
        $nilais = collect(ModelsNilai::getNilaiRT());

        $data = $nilais->map(function($nilai) {
            return [
                'nama' => $nilai->nama,
                'nilaiRT' => [
                    'artistic' => $nilai->artistic,
                    'conventional' => $nilai->conventional,
                    'enterprising' => $nilai->enterprising,
                    'investigative' => $nilai->investigative,
                    'realistic' => $nilai->realistic,
                    'social' => $nilai->social,
                ],
                'nisn' => $nilai->nisn
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data',
            'data' => $data    
        ], 200);
    }

    public function nilaiST(Request $request)
    {           
        $nilais = collect(ModelsNilai::getNilaiST());

        $data = $nilais->map(function($nilai) {
            return [
                'listNilai' => [
                    'figural' => $nilai->figural,                    
                    'kuantitatif' => $nilai->kuantitatif,                    
                    'penalaran' => $nilai->penalaran,                    
                    'verbal' => $nilai->verbal,                    
                ],
                'nama' => $nilai->nama,
                'nisn' => $nilai->nisn,
                'total' => $nilai->total
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data',
            'data' => $data           
        ], 200);
    }
}
