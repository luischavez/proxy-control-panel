<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    protected static function booted()
    {
        static::created(function ($model) {
            ChangeLog::create([
                'user'          => auth()->user()?->name ?? 'System',
                'loggeable_id'   => $model->id,
                'loggeable_type' => class_basename($model),
                'action'        => 'created',
                'diff'          => json_encode($model->toArray()),
            ]);
        });

        static::updating(function ($model) {
            $original = $model->getOriginal();
            $changed = $model->getDirty();

            $diff = [];

            foreach ($changed as $key => $value) {
                $diff[$key] = [
                    'original'  => $original[$key],
                    'changed'   => $value,
                ];
            }

            unset($diff['created_at']);
            unset($diff['updated_at']);

            ChangeLog::create([
                'user'          => auth()->user()?->name ?? 'System',
                'loggeable_id'   => $model->id,
                'loggeable_type' => class_basename($model),
                'action'        => 'updated',
                'diff'          => json_encode($diff),
            ]);
        });

        static::deleted(function ($model) {
            ChangeLog::create([
                'user'          => auth()->user()?->name ?? 'System',
                'loggeable_id'   => $model->id,
                'loggeable_type' => class_basename($model),
                'action'        => 'deleted',
                'diff'          => json_encode($model->getOriginal()),
            ]);
        });
    }
}
