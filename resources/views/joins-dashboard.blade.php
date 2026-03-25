<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Opdracht 5 - SQL Joins met Laravel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="bg-shape bg-shape-one"></div>
    <div class="bg-shape bg-shape-two"></div>

    <header class="hero container">
        <p class="kicker">Inleveropdracht 5</p>
        <h1>SQL JOINS uitgelegd met een werkende Laravel app</h1>
        <p class="lead">
            Deze demo laat per join-type zien welke data je terugkrijgt. Zo zie je direct het verschil tussen
            <strong>INNER</strong>, <strong>LEFT</strong>, <strong>RIGHT</strong> en <strong>FULL OUTER</strong> joins.
        </p>
        <div class="hero-actions">
            <a class="btn primary" href="#join-sections">Bekijk joins</a>
            <a class="btn ghost" href="#sql-code">Bekijk SQL code</a>
        </div>
    </header>

    <main class="container">
        <section class="panel" id="brondata">
            <div class="panel-head">
                <h2>Brondata</h2>
                <p>Starttabellen waarmee de joins worden gemaakt.</p>
            </div>
            <div class="grid three">
                <article class="card">
                    <h3>Students</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nummer</th>
                                <th>Naam</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->student_number }}</td>
                                <td>{{ $student->name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </article>

                <article class="card">
                    <h3>Courses</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Code</th>
                                <th>Titel</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td>{{ $course->id }}</td>
                                <td>{{ $course->code }}</td>
                                <td>{{ $course->title }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </article>

                <article class="card">
                    <h3>Enrollments</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Vak</th>
                                <th>Cijfer</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($enrollments as $enrollment)
                            <tr>
                                <td>{{ $enrollment->student_id }}</td>
                                <td>{{ $enrollment->course_id }}</td>
                                <td>{{ $enrollment->grade ?? '-' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </article>
            </div>
        </section>

        <section class="panel" id="join-sections">
            <div class="panel-head">
                <h2>Join Resultaten</h2>
                <p>Gebruik het zoekveld om snel een join te filteren op titel of beschrijving.</p>
            </div>

            <div class="filter-bar">
                <label for="join-search">Filter joins:</label>
                <input id="join-search" type="search" placeholder="Bijvoorbeeld: left, full, students...">
            </div>

            <div class="grid two" id="join-cards">
                @foreach($joinSections as $section)
                    <article class="card join-card" data-search="{{ strtolower($section['title'].' '.$section['description']) }}">
                        <h3>{{ $section['title'] }}</h3>
                        <p>{{ $section['description'] }}</p>

                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                    @foreach($section['columns'] as $column)
                                        <th>{{ $column }}</th>
                                    @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($section['rows'] as $row)
                                    <tr>
                                        @foreach($row as $value)
                                            <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ count($section['columns']) }}">Geen resultaten</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="panel" id="sql-code">
            <div class="panel-head">
                <h2>SQL Voorbeelden</h2>
                <p>Deze queries kun je direct gebruiken in MySQL/SQLite met kleine aanpassingen.</p>
            </div>
            <div class="grid two">
                @foreach($sqlExamples as $label => $sql)
                    <article class="card">
                        <h3>{{ $label }}</h3>
                        <pre><code>{{ $sql }}</code></pre>
                    </article>
                @endforeach
            </div>
        </section>
    </main>

    <footer class="container footer">
        <p>Gemaakt met Laravel, PHP, Blade (HTML), CSS, JavaScript en SQL.</p>
    </footer>
</body>
</html>
