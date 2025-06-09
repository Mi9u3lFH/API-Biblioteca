<?php

namespace App\Models\library;

use App\Traits\GetCreatedBy;
use App\Traits\GetLastModifiedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LibraryBook extends Model
{
    use GetCreatedBy, GetLastModifiedBy;

    protected $table = 'library_books';
    protected $primaryKey = 'library_book_id';
    protected $guarded = ['library_book_id'];


    public function has_authors(): BelongsToMany
    {
        return $this->belongsToMany(LibraryAuthor::class, 'library_pivot_authors_books', 'library_book_id', 'library_author_id')->withTimestamps();
    }
}
