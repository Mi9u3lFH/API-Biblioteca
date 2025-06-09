<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LibraryAuthorRequest;
use App\Models\library\LibraryAuthor;

class LibraryAuthorController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(LibraryAuthor::class, 'author', ['except' => ['index', 'show']]);
    }

    /**
     * Devuelve todos los autores registrados junto a sus libros.
     *
     * Sin restricciones de usuario.
     *
     * @response 200 [
     *   {
     *     "library_author_id": 0,
     *     "library_author_name": "",
     *     "library_author_birthdate": "0000-00-00",
     *     "library_author_biography": "",
     *     "created_by": 0,
     *     "last_modified_by": 0,
     *     "created_at": "0000-00-00",
     *     "updated_at": "0000-00-00",
     *     "has_books": [
     *       {
     *         "library_book_id": 0,
     *         "library_book_title": ""
     *         "library_book_description": ""
     *         "library_book_published_year": 0000
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
        return LibraryAuthor::with('has_books')->get();
    }

    /**
     * Crea un autor con sus datos y lo asocia a uno o más libros.
     *
     * Solo permitido para usuarios registrados.
     *
     * @authenticated
     *
     * @bodyParam library_author_name string required Nombre del autor.
     * @bodyParam library_author_birthdate date required Fecha de nacimiento del autor.
     * @bodyParam library_author_biography string Biografía del autor.
     * @bodyParam library_author_books array Lista de IDs de libros relacionados.
     *
     * @response 201 {
     *   "library_author_id": 0,
     *   "library_author_name": "",
     *   "library_author_birthdate": "0000-00-00",
     *   "library_author_biography": "",
     *   "created_by": 0,
     *   "last_modified_by": 0,
     *   "created_at": "0000-00-00",
     *   "updated_at": "0000-00-00",
     *   "has_books": [
     *     {
     *       "library_book_id": 0,
     *       "library_book_title": ""
     *       "library_book_description": ""
     *       "library_book_published_year": 0000
     *       "created_by": 0,
     *       "last_modified_by": 0,
     *       "created_at": "0000-00-00",
     *       "updated_at": "0000-00-00",
     *     }
     *   ]
     * }
     */
    public function store(LibraryAuthorRequest $request)
    {
        $author = LibraryAuthor::create($request->validated());
        if ($request->has('library_author_books')) $author->has_books()->sync($request->library_author_books);

        return response()->json($author->load('has_books'), 201);
    }

    /**
     * Obtener detalle de un autor y sus libros.
     *
     * Sin restricción de usuarios.
     *
     * @urlParam author integer required ID del autor.
     *
     * @response 200 {
     *   "library_author_id": 0,
     *   "library_author_name": "",
     *   "library_author_birthdate": "0000-00-00",
     *   "library_author_biography": "",
     *   "created_by": 0,
     *   "last_modified_by": 0,
     *   "created_at": "0000-00-00",
     *   "updated_at": "0000-00-00",
     *   "has_books": [
     *     {
     *       "library_book_id": 0,
     *       "library_book_title": ""
     *       "library_book_description": ""
     *       "library_book_published_year": 0000
     *       "created_by": 0,
     *       "last_modified_by": 0,
     *       "created_at": "0000-00-00",
     *       "updated_at": "0000-00-00",
     *     }
     *   ]
     * }
     */
    public function show(LibraryAuthor $author)
    {
        return $author->load('has_books');
    }

    /**
     * Actualizar un autor.
     *
     * Solo permitido para usuarios registrados.
     *
     * @authenticated
     *
     * @urlParam author integer required ID del autor a actualizar.
     *
     * @bodyParam library_author_name string required Nombre del autor.
     * @bodyParam library_author_birthdate date required Fecha de nacimiento del autor.
     * @bodyParam library_author_biography string Biografía del autor.
     * @bodyParam library_author_books array Lista de IDs de libros relacionados.
     *
     * @response 201 {
     *   "library_author_id": 0,
     *   "library_author_name": "",
     *   "library_author_birthdate": "0000-00-00",
     *   "library_author_biography": "",
     *   "created_by": 0,
     *   "last_modified_by": 0,
     *   "created_at": "0000-00-00",
     *   "updated_at": "0000-00-00",
     *   "has_books": [
     *     {
     *       "library_book_id": 0,
     *       "library_book_title": ""
     *       "library_book_description": ""
     *       "library_book_published_year": 0000
     *       "created_by": 0,
     *       "last_modified_by": 0,
     *       "created_at": "0000-00-00",
     *       "updated_at": "0000-00-00",
     *     }
     *   ]
     * }
     */
    public function update(LibraryAuthorRequest $request, LibraryAuthor $author)
    {
        $author->update($request->validated());

        return response()->json($author->load('has_books'));
    }

    /**
     * Eliminar un autor y sus asociaciones con libros.
     *
     * Solo permitido para usuarios registrados.
     *
     * @authenticated
     *
     * @urlParam author integer required ID del autor a eliminar.
     *
     * @response 200 {
     *   "message": "Autor eliminado correctamente."
     * }
     */
    public function destroy(LibraryAuthor $author)
    {
        $author->has_books()->detach();
        $author->delete();

        return response()->json(['message' => 'Autor eliminado correctamente.']);
    }
}
