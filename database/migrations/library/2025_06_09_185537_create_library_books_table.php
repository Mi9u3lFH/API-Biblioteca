<?php

use App\Models\User;
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
        Schema::create('library_books', function (Blueprint $table) {
            $table->id('library_book_id');
            $table->string('library_book_title');
            $table->text('library_book_description')->nullable();
            $table->smallInteger('library_book_published_year')->nullable();

            $user = new User();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references($user->getKeyName())->on($user->getTable());
            $table->unsignedBigInteger('last_modified_by');
            $table->foreign('last_modified_by')->references($user->getKeyName())->on($user->getTable());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('library_books');
    }
};
