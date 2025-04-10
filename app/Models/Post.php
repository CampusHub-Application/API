<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'title',
        'deskripsi',
        'foto',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            do {
                $randomId = Str::random(12);
            } while (static::where('id', $randomId)->exists());

            $model->id = $model->id ?? $randomId;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}