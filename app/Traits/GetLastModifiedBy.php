<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait GetLastModifiedBy
{
    public function has_last_modified_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_modified_by', 'id');
    }

    protected static function bootGetLastModifiedBy()
    {
        if (auth()->check()) {
            static::saving(function ($model) {
                $model->last_modified_by = auth()->user()->id;
            });
        }
    }
}
