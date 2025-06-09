<?php

namespace App\Models\library;

use App\Traits\GetCreatedBy;
use App\Traits\GetLastModifiedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LibraryAuthor extends Model
{
    use GetCreatedBy, GetLastModifiedBy;

    protected $table = 'library_authors';
    protected $primaryKey = 'library_author_id';
    protected $guarded = ['library_book_id'];


    public function has_books(): BelongsToMany
    {
        return $this->belongsToMany(LibraryBook::class, 'library_pivot_authors_books', 'library_author_id', 'library_book_id')->withTimestamps();
    }
}
