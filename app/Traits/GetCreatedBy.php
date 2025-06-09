<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait GetCreatedBy
{
    protected static function bootGetCreatedBy()
    {
        if (auth()->check()) {
            static::creating(function ($model) {
                $model->created_by = auth()->user()->id;
            });
        }
    }

    public function has_created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
