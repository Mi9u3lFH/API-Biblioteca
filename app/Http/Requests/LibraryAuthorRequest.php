<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LibraryAuthorRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para crear o actualizar un autor.
     *
     * @return array<string, mixed>
     *
     * @bodyParam library_author_name string required Nombre del autor. Máximo 255 caracteres.
     * @bodyParam library_author_birthdate date required Fecha de nacimiento del autor (formato YYYY-MM-DD).
     * @bodyParam library_author_biography string nullable Biografía opcional del autor.
     * @bodyParam library_author_books array nullable Lista de IDs de libros relacionados con el autor.
     * @bodyParam library_author_books.* integer exists:library_books,library_book_id Cada ID debe existir en la tabla de libros.
     */
    public function rules(): array
    {
        return [
            'library_author_name' => ['required', 'string', 'max:255'],
            'library_author_birthdate' => ['required', 'date'],
            'library_author_biography' => ['nullable', 'string'],
            'library_author_books' => ['array', 'nullable'],
            'library_author_books.*' => ['exists:library_books,library_book_id'],
        ];
    }
}
