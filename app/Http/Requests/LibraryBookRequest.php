<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LibraryBookRequest extends FormRequest
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
     * Reglas de validación para crear o actualizar un libro.
     *
     * @return array<string, mixed>
     *
     * @bodyParam library_book_title string required Título del libro. Máximo 255 caracteres.
     * @bodyParam library_book_description string Descripción del libro. Opcional.
     * @bodyParam library_book_published_year integer Año de publicación, formato YYYY.
     * @bodyParam library_book_authors array nullable Lista de IDs de autores relacionados.
     * @bodyParam library_book_authors.* integer exists:library_authors,library_author_id Cada ID debe existir en la tabla de autores.
     */
    public function rules(): array
    {
        return [
            'library_book_title' => ['required', 'string', 'max:255'],
            'library_book_description' => ['nullable', 'string'],
            'library_book_published_year' => ['nullable', 'digits:4', 'integer'],
            'library_book_authors' => ['array', 'nullable'],
            'library_book_authors.*' => ['exists:library_authors,library_author_id'],
        ];
    }
}
