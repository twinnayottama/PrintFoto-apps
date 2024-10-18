<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups'; // Menentukan nama tabel

    protected $primaryKey = 'id'; // Menentukan primary key

    public $timestamps = false; // Menonaktifkan created_at dan updated_at

    protected $fillable = [
        'id',
        'farmer_group',  // Nama kelompok
        'chairman',      // Nama ketua
        'address',       // Alamat
        'link_foto_1',   // Link foto pertama
        'link_foto_2',   // Link foto kedua
    ];
}
