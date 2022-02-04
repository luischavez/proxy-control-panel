<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'type',
        'subtype',
        'target',
        'connect_timeout',
        'send_timeout',
        'read_timeout',
        'enable_x_headers',
    ];

    public function subdomain(): BelongsTo
    {
        return $this->belongsTo(Subdomain::class);
    }

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
