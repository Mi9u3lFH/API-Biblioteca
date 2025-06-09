<?php

use App\Models\library\LibraryAuthor;
use App\Models\library\LibraryBook;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('library_pivot_authors_books', function (Blueprint $table) {
            $table->id('library_pivot_author_book_id');

            $library_author = new LibraryAuthor();
            $table->unsignedBigInteger($library_author->getKeyName());
            $table->foreign($library_author->getKeyName())->references($library_author->getKeyName())->on($library_author->getTable());

            $library_book = new LibraryBook();
            $table->unsignedBigInteger($library_book->getKeyName());
            $table->foreign($library_book->getKeyName())->references($library_book->getKeyName())->on($library_book->getTable());

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('library_pivot_authors_books');
    }
};
