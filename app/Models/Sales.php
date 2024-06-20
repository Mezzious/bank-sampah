<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tanggal_jual',
        'jenis_sampah',
        'gambar_sampah',
        'gambar_nota',
        'berat',
        'harga',
        'total'
    ];

        /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $timestamps = false;
    
    protected $table = 'saleses';

    // Jika tanggal_jual adalah atribut tanggal di model
    protected $dates = ['tanggal_jual'];

    // Mutator untuk format tanggal_jual
    public function getTanggalJualAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
