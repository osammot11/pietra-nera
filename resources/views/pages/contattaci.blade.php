@extends('layouts.app')

@section('content')
    <main>
        <section>
            <h1>Contatti</h1>
            <p class="top-margin-large">Per informazioni su iscrizioni, programma, partenze e aspetti organizzativi puoi scrivere allo staff di Sgranar per Colli.</p>
            <a href="mailto:info@sgranarpercolli.it" class="btn top-margin-xl mobile-fullwidth">Scrivici</a>
        </section>

        <section class="grid-2">
            <div class="card">
                <h2>Email</h2>
                <p class="top-margin-large"><a class="hyperlink" href="mailto:info@sgranarpercolli.it">info@sgranarpercolli.it</a></p>
            </div>
            <div class="card">
                <h2>Luogo evento</h2>
                <p class="top-margin-large">Parco Ox Centro Giovani, Borgo a Buggiano (PT).</p>
            </div>
        </section>
    </main>
@endsection
