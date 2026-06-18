@extends('layouts.app')

@push('head')
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "WebSite",
        "name": "Hiking della Pietra Nera",
        "url": "https://www.hikingdellapietranera.it/",
        "inLanguage": "it"
    }
    </script>

    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "SportsEvent",
        "name": "Hiking della Pietra Nera 2027",
        "startDate": "2027-05-16T08:00:00+02:00",
        "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
        "eventStatus": "https://schema.org/EventScheduled",
        "url": "https://www.hikingdellapietranera.it/",
        "image": "{{ url('/images/hiking/logo.png') }}",
        "description": "Camminata ludico motoria non competitiva sui sentieri di Uscio e Lumarzo, tra boschi, cave d'ardesia, storia locale e turismo lento.",
        "location": {
            "@@type": "Place",
            "name": "Area feste di Calcinara",
            "address": {
                "@@type": "PostalAddress",
                "addressLocality": "Uscio",
                "addressRegion": "Liguria",
                "addressCountry": "IT"
            }
        },
        "organizer": {
            "@@type": "Organization",
            "name": "Hiking della Pietra Nera",
            "url": "https://www.hikingdellapietranera.it/"
        }
    }
    </script>
@endpush

@section('content')
    <div class="home-hero">
        <section class="hero-height center-text light-color center-items">
            <h3 class="primary-color">16 maggio 2027</h3>
            <h1 class="top-margin-large hero-title">HIKING DELLA PIETRA NERA</h1>
            <p class="top-margin-large hero-copy">Una camminata ludico motoria non competitiva dove i monti incontrano il mare, tra storia, ardesia e turismo lento.</p>
            <a href="/iscrizione" class="btn top-margin-xl mobile-fullwidth">Acquista biglietti</a>
        </section>

        <section>
            <div class="countdown" id="countdown" aria-label="Conto alla rovescia per Hiking della Pietra Nera 2027">
                <div class="time-box">
                    <h2 id="days">00</h2>
                    <small>Giorni</small>
                </div>
                <div class="time-box">
                    <h2 id="hours">00</h2>
                    <small>Ore</small>
                </div>
                <div class="time-box">
                    <h2 id="minutes">00</h2>
                    <small>Minuti</small>
                </div>
                <div class="time-box">
                    <h2 id="seconds">00</h2>
                    <small>Secondi</small>
                </div>
            </div>
        </section>
    </div>

    <main>
        <section class="grid-2 intro-section">
            <div>
                <h2>Sentieri tra monti e mare</h2>
                <p class="top-margin-large">
                    L'Hiking della Pietra Nera nasce da un gruppo di amici appassionati del proprio territorio per far conoscere luoghi dove i monti incontrano il mare e la biodiversità si rivela a ogni passo.
                </p>
                <p class="top-margin-large">
                    Dopo la giornata condivisa sui sentieri di Uscio e Lumarzo, la prossima edizione è già in cammino: appuntamento al 16 maggio 2027.
                </p>
            </div>
            <div class="card primary-bg">
                <div class="hero-top">

                    <div class="titolo-box center-text light-color" id="titoloBox">
                        <div class="numero iscritti-title">{{ $totalIscritti }}</div>
                        <div class="label iscritti-subtitle">iscritti</div>
                    </div>
                </div>
            </div>
        </section>

        <section id="percorsi">
            <h2 class="center-text">Scegli il tuo percorso</h2>
            <div class="grid-3 top-margin-xl">
                <div class="card route-card stack-mid">
                    <span class="route-badge route-rosa">08:30</span>
                    <h3>Percorso Famiglie</h3>
                    <p>Un anello da 9,5 km con 260 m di ascesa e discesa, tra Calcinara, Colle Caprile, Monte Rosso, cave d'ardesia e panchina gigante.</p>
                    <a href="/iscrizione?percorso=Percorso%20Famiglie" class="btn mobile-fullwidth">Iscriviti</a>
                </div>

                <div class="card route-card stack-mid">
                    <span class="route-badge route-bianca">08:00</span>
                    <h3>Percorso Amatori</h3>
                    <p>Circa 20 km con 480 m di ascesa e discesa, passando da Terrile, Uscio, Colonia Arnaldi, Pannesi, Monte Cornua e ritorno a Calcinara.</p>
                    <a href="/iscrizione?percorso=Percorso%20Amatori" class="btn mobile-fullwidth">Iscriviti</a>
                </div>

                <div class="card route-card stack-mid">
                    <span class="route-badge route-gialla">Kit</span>
                    <h3>Accoglienza</h3>
                    <p>Accreditamento con anticipo, pettorale numerato, carta credenziali, maglietta tecnica, sacchetto rifiuti e gadget legato al territorio.</p>
                    <a href="/regolamento" class="btn mobile-fullwidth">Regolamento</a>
                </div>
            </div>
        </section>

        <section class="sgranar-band">
            <div>
                <h2>16 maggio 2027</h2>
                <p class="top-margin-large">
                    La prossima edizione dell'Hiking della Pietra Nera riparte dai sentieri di Uscio e Lumarzo, con la stessa finalità: Sole, Salute, Vita.
                </p>
            </div>
            <a href="/iscrizione" class="btn btn-2 top-margin-large mobile-fullwidth">Biglietti hiking</a>
        </section>

        <section id="programma">
            <h2 class="center-text">Dati percorso</h2>
            <div class="grid-3 top-margin-xl">
                <div class="card program-card">
                    <h3>Partenze</h3>
                    <ul class="program-list">
                        <li><strong>08:00</strong> Percorso Amatori da Calcinara.</li>
                        <li><strong>08:30</strong> Percorso Famiglie da Calcinara.</li>
                        <li><strong>17:30</strong> Chiusura indicativa della manifestazione.</li>
                    </ul>
                </div>

                <div class="card program-card">
                    <h3>Territorio</h3>
                    <ul class="program-list">
                        <li><strong>Uscio</strong> Creuze, caruggi, Pieve Romanica e Museo dell'Orologio.</li>
                        <li><strong>Lumarzo</strong> Santuario di Nostra Signora del Bosco e frazione Pannesi.</li>
                        <li><strong>Ardesia</strong> Cave di Monterosso e sentieri storici colombiani.</li>
                    </ul>
                </div>

                <div class="card program-card">
                    <h3>Iscrizioni</h3>
                    <ul class="program-list">
                        <li><strong>Quota 2026</strong> Iscrizione base indicata a 22,00 euro.</li>
                        <li><strong>Famiglie</strong> Prezzi speciali per adulti con bambini.</li>
                        <li><strong>Info</strong> info@hikingdellapietranera.it</li>
                    </ul>
                </div>
            </div>
        </section>

        <section>
            <div class="grid-2 top-margin-xl visual-section">
                <img src="/images/hiking/sentiero.jpg" alt="Escursionisti sui sentieri dell'Hiking della Pietra Nera" loading="lazy" decoding="async">
                <div>
                    <h2>Sole, Salute, Vita</h2>
                    <p class="top-margin-large">Un progetto che non si esaurisce in una giornata di festa: il passato si preserva camminandolo, il futuro si costruisce facendolo conoscere.</p>
                    <a href="/iscrizione" class="btn top-margin-xl mobile-fullwidth">Partecipa</a>
                </div>
            </div>
        </section>

        <section class="faq-section">
            <h2>Domande frequenti</h2>

            <div class="faq-accordion top-margin-xl">
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span>Quando si svolge la prossima edizione?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <p class="top-margin-large">Il sito ufficiale indica che la prossima edizione dell'Hiking della Pietra Nera si svolgerà il 16 maggio 2027.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span>Quali percorsi posso scegliere?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <p class="top-margin-large">L'edizione 2026 prevedeva il Percorso Famiglie da 9,5 km alle 08:30 e il Percorso Amatori da circa 20 km alle 08:00.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span>Dove si trova il cuore dell'evento?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <p class="top-margin-large">Il punto di partenza e arrivo indicato per i percorsi è l'area feste di Calcinara, nel territorio di Uscio, in Liguria.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span>Come acquisto i biglietti?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <p class="top-margin-large">Puoi acquistare il tuo biglietto online dalla pagina <a href="/iscrizione" class="hyperlink">Iscrizione</a> e scegliere il percorso più adatto.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script src="/homepage-countdown.js?v=2.0"></script>
    <script>
        const pellegrino = document.getElementById('pellegrino');
        const titoloBox = document.getElementById('titoloBox');

        function syncPellegrinoHeight() {
            if (!pellegrino || !titoloBox) return;
            const h = titoloBox.getBoundingClientRect().height;
            pellegrino.style.height = `${h}px`;
        }

        syncPellegrinoHeight();

        const ro = new ResizeObserver(syncPellegrinoHeight);
        ro.observe(titoloBox);

        window.addEventListener('load', syncPellegrinoHeight);
        window.addEventListener('resize', syncPellegrinoHeight);
    </script>
    <script src="/accordion.js"></script>
@endpush
