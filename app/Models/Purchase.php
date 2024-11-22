<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Purchase extends Model
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
        'tanggal_beli',
        'jenis_sampah',
        'berat',
        'harga',
        'total',
        'gambar_ttd',
        'gambar_sampah',
        'status_konfirmasi',
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

        static::creating(function ($purchase) {
            // Generate custom ID untuk user dengan panjang tertentu
            $latestUser = DB::table('purchases')->orderBy('id', 'desc')->first();

            if ($latestUser) {
                $lastId = $latestUser->id;
                $number = (int)substr($lastId, 3) + 1; // Ambil angka terakhir
                $purchase->id = 'PUC' . str_pad($number, 3, '0', STR_PAD_LEFT); // Format dengan panjang 6 karakter
            } else {
                $purchase->id = 'PUC001'; // ID pertama
            }

            // Validasi panjang ID
            if (strlen($purchase->id) !== 6) {
                throw new \Exception('ID harus memiliki panjang tepat 6 karakter.');
            }
        });
    }

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
