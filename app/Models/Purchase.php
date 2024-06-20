<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'tanggal_beli',
        'jenis_sampah',
        'berat',
        'harga',
        'total',
        'gambar_sampah',
        'gambar_nota',
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

    protected $table = 'purchases';

    // Pastikan atribut tanggal_beli dikenal sebagai tanggal
    protected $dates = ['tanggal_beli'];

    // Mutator untuk format tanggal_beli
    public function getTanggalBeliAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
