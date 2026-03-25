<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class JoinDemoController extends Controller
{
    public function index()
    {
        if (!Schema::hasTable('students') || !Schema::hasTable('courses') || !Schema::hasTable('enrollments')) {
            return view('joins-dashboard', [
                'students' => collect(),
                'courses' => collect(),
                'enrollments' => collect(),
                'joinSections' => [],
                'sqlExamples' => [],
            ]);
        }

        $students = DB::table('students')->orderBy('id')->get();
        $courses = DB::table('courses')->orderBy('id')->get();
        $enrollments = DB::table('enrollments')->orderBy('id')->get();

        $innerJoin = DB::table('students as s')
            ->join('enrollments as e', 's.id', '=', 'e.student_id')
            ->join('courses as c', 'c.id', '=', 'e.course_id')
            ->select('s.name as student_name', 'c.title as course_title', 'e.grade')
            ->orderBy('s.name')
            ->get();

        $leftJoin = DB::table('students as s')
            ->leftJoin('enrollments as e', 's.id', '=', 'e.student_id')
            ->leftJoin('courses as c', 'c.id', '=', 'e.course_id')
            ->select('s.name as student_name', 'c.title as course_title', 'e.grade')
            ->orderBy('s.name')
            ->get();

        // SQLite heeft soms geen RIGHT JOIN nodig; dit is dezelfde set als RIGHT JOIN.
        $rightJoin = DB::table('courses as c')
            ->leftJoin('enrollments as e', 'c.id', '=', 'e.course_id')
            ->leftJoin('students as s', 's.id', '=', 'e.student_id')
            ->select('s.name as student_name', 'c.title as course_title', 'e.grade')
            ->orderBy('c.title')
            ->get();

        $fullOuterJoin = collect(DB::select("\n            SELECT s.name AS student_name, c.title AS course_title, e.grade\n            FROM students s\n            LEFT JOIN enrollments e ON s.id = e.student_id\n            LEFT JOIN courses c ON c.id = e.course_id\n            UNION\n            SELECT s.name AS student_name, c.title AS course_title, e.grade\n            FROM courses c\n            LEFT JOIN enrollments e ON c.id = e.course_id\n            LEFT JOIN students s ON s.id = e.student_id\n            ORDER BY student_name, course_title\n        "));

        $leftExclusive = DB::table('students as s')
            ->leftJoin('enrollments as e', 's.id', '=', 'e.student_id')
            ->select('s.name as student_name')
            ->whereNull('e.id')
            ->orderBy('s.name')
            ->get();

        $rightExclusive = DB::table('courses as c')
            ->leftJoin('enrollments as e', 'c.id', '=', 'e.course_id')
            ->select('c.title as course_title')
            ->whereNull('e.id')
            ->orderBy('c.title')
            ->get();

        $fullExclusive = $leftExclusive
            ->map(fn ($row) => ['student_name' => $row->student_name, 'course_title' => null])
            ->merge($rightExclusive->map(fn ($row) => ['student_name' => null, 'course_title' => $row->course_title]));

        $joinSections = [
            [
                'id' => 'inner',
                'title' => 'INNER JOIN',
                'description' => 'Alleen matches tussen studenten en vakken.',
                'columns' => ['Student', 'Vak', 'Cijfer'],
                'rows' => $this->formatRows($innerJoin, ['student_name', 'course_title', 'grade']),
            ],
            [
                'id' => 'left',
                'title' => 'LEFT JOIN',
                'description' => 'Alle studenten + eventuele match op vak.',
                'columns' => ['Student', 'Vak', 'Cijfer'],
                'rows' => $this->formatRows($leftJoin, ['student_name', 'course_title', 'grade']),
            ],
            [
                'id' => 'right',
                'title' => 'RIGHT JOIN (equivalent)',
                'description' => 'Alle vakken + eventuele match op student.',
                'columns' => ['Student', 'Vak', 'Cijfer'],
                'rows' => $this->formatRows($rightJoin, ['student_name', 'course_title', 'grade']),
            ],
            [
                'id' => 'full',
                'title' => 'FULL OUTER JOIN (gesimuleerd)',
                'description' => 'Alle studenten en alle vakken, met of zonder match.',
                'columns' => ['Student', 'Vak', 'Cijfer'],
                'rows' => $this->formatRows($fullOuterJoin, ['student_name', 'course_title', 'grade']),
            ],
            [
                'id' => 'left-exclusive',
                'title' => 'LEFT EXCLUSIVE JOIN',
                'description' => 'Studenten zonder inschrijving.',
                'columns' => ['Student'],
                'rows' => $this->formatRows($leftExclusive, ['student_name']),
            ],
            [
                'id' => 'right-exclusive',
                'title' => 'RIGHT EXCLUSIVE JOIN',
                'description' => 'Vakken zonder studenten.',
                'columns' => ['Vak'],
                'rows' => $this->formatRows($rightExclusive, ['course_title']),
            ],
            [
                'id' => 'full-exclusive',
                'title' => 'FULL EXCLUSIVE JOIN',
                'description' => 'Alle rijen zonder match aan beide kanten.',
                'columns' => ['Student', 'Vak'],
                'rows' => $this->formatRows($fullExclusive, ['student_name', 'course_title']),
            ],
        ];

        $sqlExamples = [
            'INNER JOIN' => "SELECT s.name, c.title, e.grade\nFROM students s\nINNER JOIN enrollments e ON s.id = e.student_id\nINNER JOIN courses c ON c.id = e.course_id;",
            'LEFT JOIN' => "SELECT s.name, c.title, e.grade\nFROM students s\nLEFT JOIN enrollments e ON s.id = e.student_id\nLEFT JOIN courses c ON c.id = e.course_id;",
            'RIGHT JOIN' => "SELECT s.name, c.title, e.grade\nFROM students s\nRIGHT JOIN enrollments e ON s.id = e.student_id\nRIGHT JOIN courses c ON c.id = e.course_id;",
            'FULL OUTER JOIN' => "SELECT s.name, c.title, e.grade\nFROM students s\nLEFT JOIN enrollments e ON s.id = e.student_id\nLEFT JOIN courses c ON c.id = e.course_id\nUNION\nSELECT s.name, c.title, e.grade\nFROM courses c\nLEFT JOIN enrollments e ON c.id = e.course_id\nLEFT JOIN students s ON s.id = e.student_id;",
        ];

        return view('joins-dashboard', [
            'students' => $students,
            'courses' => $courses,
            'enrollments' => $enrollments,
            'joinSections' => $joinSections,
            'sqlExamples' => $sqlExamples,
        ]);
    }

    private function formatRows(iterable $items, array $columns): Collection
    {
        return collect($items)->map(function ($item) use ($columns) {
            $row = [];

            foreach ($columns as $column) {
                $row[] = data_get($item, $column) ?? '-';
            }

            return $row;
        });
    }
}
