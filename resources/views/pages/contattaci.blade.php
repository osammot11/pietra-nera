@extends('layouts.app')

@section('content')
    <main>
        <section>
            <h1>Contatti</h1>
            <p class="top-margin-large">Per informazioni su iscrizioni, percorsi e aspetti organizzativi puoi scrivere allo staff dell'Hiking della Pietra Nera.</p>
            <a href="mailto:info@hikingdellapietranera.it" class="btn top-margin-xl mobile-fullwidth">Scrivici</a>
        </section>

        <section class="grid-2">
            <div class="card">
                <h2>Email</h2>
                <p class="top-margin-large"><a class="hyperlink" href="mailto:info@hikingdellapietranera.it">info@hikingdellapietranera.it</a></p>
            </div>
            <div class="card">
                <h2>Luogo evento</h2>
                <p class="top-margin-large">Area feste di Calcinara, Uscio (GE).</p>
            </div>
        </section>
    </main>
@endsection
