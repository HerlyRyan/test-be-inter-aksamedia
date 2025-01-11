<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilais';

    protected $fillable = [
        'id_status', 'profile_tes_id', 'id_siswa', 'soal_bank_paket_id', 'nama', 'nisn', 'jk', 'skor', 'soal_benar', 'nama_pelajaran', 'pelajaran_id', 'materi_uji_id', 'sesi', 'id_pelaksanaan', 'nama_sekolah', 'total_sekolah', 'urutan'
    ];

    public static function getNilaiRT() {
        return DB::select("
            SELECT 
                nama, 
                nisn, 
                MAX(CASE WHEN nama_pelajaran = 'realistic' THEN skor ELSE 0 END) AS realistic, 
                MAX(CASE WHEN nama_pelajaran = 'investigative' THEN skor ELSE 0 END) AS investigative, 
                MAX(CASE WHEN nama_pelajaran = 'artistic' THEN skor ELSE 0 END) AS artistic, 
                MAX(CASE WHEN nama_pelajaran = 'social' THEN skor ELSE 0 END) AS social, 
                MAX(CASE WHEN nama_pelajaran = 'enterprising' THEN skor ELSE 0 END) AS enterprising, 
                MAX(CASE WHEN nama_pelajaran = 'conventional' THEN skor ELSE 0 END) AS conventional 
            FROM 
                nilais 
            GROUP BY 
                nama, nisn
        ");
    }

    public static function getNilaiST() {
        return DB::select("
            SELECT 
                nama,
                nisn,
                MAX(CASE WHEN pelajaran_id = 44 THEN skor * 41.67 ELSE 0 END) AS verbal,
                MAX(CASE WHEN pelajaran_id = 45 THEN skor * 29.67 ELSE 0 END) AS kuantitatif,
                MAX(CASE WHEN pelajaran_id = 46 THEN skor * 100 ELSE 0 END) AS penalaran,
                MAX(CASE WHEN pelajaran_id = 47 THEN skor * 23.81 ELSE 0 END) AS figural,                
                SUM(
                    CASE WHEN pelajaran_id = 44 THEN skor * 41.67
                        WHEN pelajaran_id = 45 THEN skor * 29.67
                        WHEN pelajaran_id = 46 THEN skor * 100
                        WHEN pelajaran_id = 47 THEN skor * 23.81
                    END
                ) AS total
            FROM 
                nilais
            WHERE 
                materi_uji_id = 4
            GROUP BY 
                nama, nisn
            ORDER BY 
                total DESC;
        ");
    }
}
