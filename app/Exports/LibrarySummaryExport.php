<?php

namespace App\Exports;

use App\Models\Library\LibraryAuthor;
use App\Models\Library\LibraryBook;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class LibrarySummaryExport implements FromArray, WithHeadings, WithEvents, ShouldAutoSize
{
    public function headings(): array
    {
        return ['Resumen de Biblioteca'];
    }

    public function array(): array
    {
        $authors = LibraryAuthor::with('has_books')->get();
        $books = LibraryBook::all();

        $rows = [
            ['', ''], // Espaciado por legibilidad
            ['Total de autores', $authors->count()],
            ['Total de libros', $books->count()],
            ['',''], // Espaciado por legibilidad
            ['Autor', 'Libros asociados'],
        ];

        foreach ($authors as $author) {
            $books_by_author = $author->has_books->pluck('library_book_title')->join(', ');
            $rows[] = [$author->library_author_name, $books_by_author ?: 'Sin libros asociados'];
        }

        return $rows;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Fusionar celdas A1:B1 para el título
                $event->sheet->mergeCells('A1:B1');
            },
        ];
    }
}
