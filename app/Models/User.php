<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'is_admin',
        'name',
        'email',
        'encrypted',
        'password',
        'photo'
    ];

    protected $hidden = [
        'encrypted',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'encrypted' => 'hashed',
        ];
    }

    protected static function Boot()
    {
        parent::Boot();

        static::creating(function ($model) {

            do {
                $randomId = Str::random(8);
            } while (static::where('id', $randomId)->exists());
            $model->id = $model->id ?? $randomId;

        });
    }

    public function getAuthPassword()
    {
        return $this->encrypted;
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }
}