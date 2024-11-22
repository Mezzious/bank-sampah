<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Trash extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';    // Tentukan primary key
    public $incrementing = false;    // Nonaktifkan auto increment
    protected $keyType = 'string';   // Gunakan string untuk tipe key

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'jenis_sampah',
        'satuan',
        'harga',
        'gambar',
        'deskripsi',
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($trash) {
            // Generate custom ID untuk user dengan panjang tertentu
            $latestUser = DB::table('trashes')->orderBy('id', 'desc')->first();

            if ($latestUser) {
                $lastId = $latestUser->id;
                $number = (int)substr($lastId, 3) + 1; // Ambil angka terakhir
                $trash->id = 'TRS' . str_pad($number, 3, '0', STR_PAD_LEFT); // Format dengan panjang 6 karakter
            } else {
                $trash->id = 'TRS001'; // ID pertama
            }

            // Validasi panjang ID
            if (strlen($trash->id) !== 6) {
                throw new \Exception('ID harus memiliki panjang tepat 6 karakter.');
            }
        });
    }

    public $timestamps = false;
    
    protected $table = 'trashes';

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
