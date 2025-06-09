<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LibraryBookRequest;
use App\Models\library\LibraryBook;

class LibraryBookController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(LibraryBook::class, 'book', ['except' => ['index', 'show']]);
    }

    /**
     * Devuelve todos los libros registrados junto a sus autores.
     *
     * Sin restricciones de usuario.
     *
     * @response 200 [
     *   {
     *     "library_book_id": 0,
     *     "library_book_title": "",
     *     "library_book_description": "",
     *     "library_book_published_year": 0000,
     *     "created_by": 0,
     *     "last_modified_by": 0,
     *     "created_at": "0000-00-00",
     *     "updated_at": "0000-00-00",
     *     "has_authors": [
     *       {
     *         "library_author_id": 0,
     *         "library_author_name": ""
     *         "library_author_birthdate": "0000-00-00",
     *         "library_author_biography": "",
     *         "created_by": 0,
     *         "last_modified_by": 0,
     *         "created_at": "0000-00-00",
     *         "updated_at": "0000-00-00",
     *       }
     *     ]
     *   }
     * ]
     */
    public function index()
    {
        return LibraryBook::with('has_authors')->get();
    }

    /**
     * Crea un libro con sus datos y lo asocia a uno o más autores.
     *
     * Solo permitido para usuarios registrados.
     *
     * @authenticated
     *
     * @bodyParam library_book_title string required Título del libro.
     * @bodyParam library_book_description string Descripción del libro.
     * @bodyParam library_book_published_year integer Año de publicación.
     * @bodyParam library_book_authors array Lista de IDs de autores relacionados.
     *
     * @response 201 {
     *   "library_book_id": 0,
     *   "library_book_title": "",
     *   "library_book_description": "",
     *   "library_book_published_year": 0000,
     *   "created_by": 0,
     *   "last_modified_by": 0,
     *   "created_at": "0000-00-00",
     *   "updated_at": "0000-00-00",
     *   "has_authors": [
     *     {
     *       "library_author_id": 0,
     *       "library_author_name": ""
     *       "library_author_birthdate": "0000-00-00",
     *       "library_author_biography": "",
     *       "created_by": 0,
     *       "last_modified_by": 0,
     *       "created_at": "0000-00-00",
     *       "updated_at": "0000-00-00",
     *     }
     *   ]
     * }
     */
    public function store(LibraryBookRequest $request)
    {
        $book = LibraryBook::create($request->validated());
        if ($request->has('library_book_authors')) $book->has_authors()->sync($request->library_book_authors);

        return response()->json($book->load('has_authors'), 201);
    }

    /**
     * Obtener detalle de un libro y sus autores.
     *
     * Sin restricción de usuarios.
     *
     * @urlParam id integer required ID del libro.
     *
     * @response 200 {
     *   "library_book_id": 0,
     *   "library_book_title": "",
     *   "library_book_description": "",
     *   "library_book_published_year": 0000,
     *   "created_by": 0,
     *   "last_modified_by": 0,
     *   "created_at": "0000-00-00",
     *   "updated_at": "0000-00-00",
     *   "has_authors": [
     *     {
     *       "library_author_id": 0,
     *       "library_author_name": ""
     *       "library_author_birthdate": "0000-00-00",
     *       "library_author_biography": "",
     *       "created_by": 0,
     *       "last_modified_by": 0,
     *       "created_at": "0000-00-00",
     *       "updated_at": "0000-00-00",
     *     }
     *   ]
     * }
     */
    public function show(LibraryBook $book)
    {
        return $book->load('has_authors');
    }

    /**
     * Actualizar un libro.
     *
     * Solo permitido para usuarios registrados.
     *
     * @authenticated
     *
     * @urlParam id integer required ID del libro a actualizar.
     *
     * @bodyParam library_book_title string required Título del libro.
     * @bodyParam library_book_description string Descripción del libro.
     * @bodyParam library_book_published_year integer Año de publicación.
     * @bodyParam library_book_authors array Lista de IDs de autores relacionados.
     *
     * @response 200 {
     *   "library_book_id": 0,
     *   "library_book_title": "",
     *   "library_book_description": "",
     *   "library_book_published_year": 0000,
     *   "created_by": 0,
     *   "last_modified_by": 0,
     *   "created_at": "0000-00-00",
     *   "updated_at": "0000-00-00",
     *   "has_authors": [
     *     {
     *       "library_author_id": 0,
     *       "library_author_name": ""
     *       "library_author_birthdate": "0000-00-00",
     *       "library_author_biography": "",
     *       "created_by": 0,
     *       "last_modified_by": 0,
     *       "created_at": "0000-00-00",
     *       "updated_at": "0000-00-00",
     *     }
     *   ]
     * }
     */
    public function update(LibraryBookRequest $request, LibraryBook $book)
    {
        $book->update($request->validated());
        if ($request->has('library_book_authors')) $book->has_authors()->sync($request->library_book_authors);

        return response()->json($book->load('has_authors'));
    }

    /**
     * Eliminar un libro y sus asociaciones de autores.
     *
     * Solo permitido para usuarios registrados.
     *
     * @authenticated
     *
     * @urlParam id integer required ID del libro a eliminar.
     *
     * @response 200 {
     *   "message": "Libro eliminado correctamente."
     * }
     */
    public function destroy(LibraryBook $book)
    {
        $book->has_authors()->detach();
        $book->delete();

        return response()->json(['message' => 'Libro eliminado correctamente.']);
    }
}
