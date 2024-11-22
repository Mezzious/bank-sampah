<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sales extends Model
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
        'tanggal_jual',
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

        static::creating(function ($sales) {
            // Generate custom ID untuk user dengan panjang tertentu
            $latestUser = DB::table('saleses')->orderBy('id', 'desc')->first();

            if ($latestUser) {
                $lastId = $latestUser->id;
                $number = (int)substr($lastId, 3) + 1; // Ambil angka terakhir
                $sales->id = 'SAL' . str_pad($number, 3, '0', STR_PAD_LEFT); // Format dengan panjang 6 karakter
            } else {
                $sales->id = 'SAL001'; // ID pertama
            }

            // Validasi panjang ID
            if (strlen($sales->id) !== 6) {
                throw new \Exception('ID harus memiliki panjang tepat 6 karakter.');
            }
        });
    }

    public $timestamps = false;
    
    protected $table = 'saleses';

    // Jika tanggal_jual adalah atribut tanggal di model
    protected $dates = ['tanggal_jual'];

    // Mutator untuk format tanggal_jual
    public function getTanggalJualAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
