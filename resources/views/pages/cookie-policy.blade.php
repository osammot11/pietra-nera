@extends('layouts.app')

@section('content')
    <main>
        <section>
            <h1>Cookie Policy</h1>
            <p class="top-margin-large">Il sito utilizza cookie tecnici necessari al funzionamento, alla sicurezza e alla gestione delle preferenze espresse dall’utente.</p>
        </section>

        <section class="grid-2">
            <div class="card">
                <h2>Cookie tecnici</h2>
                <p class="top-margin-large">Servono a mantenere attive le funzionalità essenziali del sito, come sessione, consenso cookie e protezioni del form.</p>
            </div>
            <div class="card">
                <h2>Gestione</h2>
                <p class="top-margin-large">Puoi modificare o cancellare i cookie dalle impostazioni del browser. Alcune funzioni potrebbero non essere disponibili senza cookie tecnici.</p>
            </div>
        </section>
    </main>
@endsection
