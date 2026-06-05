@extends('layouts.app')

@push('head')
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "WebSite",
        "name": "Sgranar per Colli",
        "url": "https://sgranarpercolli.it/",
        "inLanguage": "it"
    }
    </script>

    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "SportsEvent",
        "name": "Sgranar per Colli 2026",
        "startDate": "2026-06-07T09:30:00+02:00",
        "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
        "eventStatus": "https://schema.org/EventScheduled",
        "url": "https://sgranarpercolli.it/",
        "image": "https://sgranarpercolli.it/images/2023/copertina_sito.jpg",
        "description": "Camminata non competitiva tra le colline della Valdinievole, con partenze scaglionate e programma eventi dal 5 al 7 giugno 2026.",
        "location": {
            "@@type": "Place",
            "name": "Parco Ox Centro Giovani",
            "address": {
                "@@type": "PostalAddress",
                "addressLocality": "Borgo a Buggiano",
                "addressRegion": "Toscana",
                "addressCountry": "IT"
            }
        },
        "organizer": {
            "@@type": "Organization",
            "name": "Sgranar per Colli",
            "url": "https://sgranarpercolli.it/"
        }
    }
    </script>
@endpush

@section('content')
    <div class="home-hero">
        <section class="hero-height center-text light-color center-items">
            <h3 class="primary-color">7 giugno 2026</h3>
            <h1 class="top-margin-large hero-title">SGRANAR PER COLLI</h1>
            <p class="top-margin-large hero-copy">La camminata più attesa della Valdinievole torna tra colline, borghi, sapori e tre giorni di festa.</p>
            <a href="/iscrizione" class="btn top-margin-xl mobile-fullwidth">Acquista biglietti</a>
        </section>

        <section>
            <div class="countdown" id="countdown" aria-label="Conto alla rovescia per Sgranar per Colli 2026">
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
                <h2>Una festa da camminare</h2>
                <p class="top-margin-large">
                    Sgranar per Colli porta il passo lento dentro la Valdinievole: percorsi a partenza scaglionata, soste di gusto, musica, market, laboratori e incontri nel verde di Borgo a Buggiano.
                </p>
                <p class="top-margin-large">
                    Dal 5 al 7 giugno il Parco Ox diventa il cuore del programma, con area food & beverage aperta nelle serate e la camminata in calendario domenica 7 giugno.
                </p>
            </div>
            <div class="card">
                <div class="hero-top">
                    <img src="/images/sgranar/asino-rosso.svg" alt="Asino rosso Sgranar per Colli" class="pellegrino" id="pellegrino">

                    <div class="titolo-box center-text" id="titoloBox">
                        <div class="numero iscritti-title">{{ $totalIscritti }}</div>
                        <div class="label iscritti-subtitle">iscritti</div>
                    </div>
                </div>
                <p class="iscritti-paragraph top-margin-large center-text">
                    Le colline rendono meglio quando si cammina insieme. Se non lo hai già fatto, <a class="main-text-color" href="/iscrizione">iscriviti</a>.
                </p>
            </div>
        </section>

        <section id="percorsi">
            <h2 class="center-text">Scegli la tua partenza</h2>
            <div class="grid-3 top-margin-xl">
                <div class="card route-card stack-mid">
                    <span class="route-badge route-rosa">09:30</span>
                    <h3>Partenza Rosa</h3>
                    <p>La prima onda della camminata, pensata per chi vuole partire presto e godersi il programma con calma.</p>
                    <a href="/iscrizione?percorso=Partenza%20Rosa" class="btn mobile-fullwidth">Iscriviti</a>
                </div>

                <div class="card route-card stack-mid">
                    <span class="route-badge route-bianca">10:15</span>
                    <h3>Partenza Bianca</h3>
                    <p>Una fascia centrale per vivere il percorso con ritmo disteso, soste e atmosfera di gruppo.</p>
                    <a href="/iscrizione?percorso=Partenza%20Bianca" class="btn mobile-fullwidth">Iscriviti</a>
                </div>

                <div class="card route-card stack-mid">
                    <span class="route-badge route-gialla">11:00</span>
                    <h3>Partenza Gialla</h3>
                    <p>L’ultima partenza della mattina, ideale per chi vuole arrivare nel pieno della giornata al Parco Ox.</p>
                    <a href="/iscrizione?percorso=Partenza%20Gialla" class="btn mobile-fullwidth">Iscriviti</a>
                </div>
            </div>
        </section>

        <section class="sgranar-band">
            <div>
                <h2>5-6-7 giugno 2026</h2>
                <p class="top-margin-large">
                    Tre giorni di appuntamenti: area relax, market, info point, libri, laboratori, degustazioni, land art e food & beverage nelle serate.
                </p>
            </div>
            <a href="/iscrizione" class="btn btn-2 top-margin-large mobile-fullwidth">Biglietti camminata</a>
        </section>

        <section id="programma">
            <h2 class="center-text">Programma eventi</h2>
            <div class="grid-3 top-margin-xl">
                <div class="card program-card">
                    <h3>5 giugno</h3>
                    <ul class="program-list">
                        <li><strong>17:00</strong> Apertura evento, market e area food.</li>
                        <li><strong>18:00</strong> Incontri e presentazioni.</li>
                        <li><strong>22:00</strong> Musica dal vivo e DJ set.</li>
                    </ul>
                </div>

                <div class="card program-card">
                    <h3>6 giugno</h3>
                    <ul class="program-list">
                        <li><strong>17:00</strong> Market, laboratori e programma culturale.</li>
                        <li><strong>18:30</strong> Rundagiata per Colli.</li>
                        <li><strong>22:00</strong> Concerti e DJ set.</li>
                    </ul>
                </div>

                <div class="card program-card">
                    <h3>7 giugno</h3>
                    <ul class="program-list">
                        <li><strong>08:30</strong> Bike per Colli.</li>
                        <li><strong>09:30 / 10:15 / 11:00</strong> Partenze Sgranar.</li>
                        <li><strong>13:00</strong> Festa, food e musica fino a sera.</li>
                    </ul>
                </div>
            </div>
        </section>

        <section>
            <div class="grid-2 top-margin-xl visual-section">
                <img src="/images/sgranar/copertina-sito.jpg" alt="Panorama collinare di Sgranar per Colli" loading="lazy" decoding="async">
                <div>
                    <h2>Valdinievole a passo lento</h2>
                    <p class="top-margin-large">Un progetto popolare, colorato e conviviale: si parte per camminare, si resta per incontrarsi.</p>
                    <a href="/iscrizione" class="btn top-margin-xl mobile-fullwidth">Partecipa</a>
                </div>
            </div>
        </section>

        <section class="faq-section">
            <h2>Domande frequenti</h2>

            <div class="faq-accordion top-margin-xl">
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span>Quando si svolge Sgranar per Colli 2026?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <p class="top-margin-large">La camminata si svolge domenica 7 giugno 2026, dentro un programma eventi attivo dal 5 al 7 giugno.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span>Quali partenze posso scegliere?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <p class="top-margin-large">Sono disponibili tre fasce: Partenza Rosa alle 09:30, Partenza Bianca alle 10:15 e Partenza Gialla alle 11:00.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span>Dove si trova il cuore dell’evento?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <p class="top-margin-large">Il programma fa riferimento al Parco Ox Centro Giovani, a Borgo a Buggiano in provincia di Pistoia.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span>Come acquisto i biglietti?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <p class="top-margin-large">Puoi acquistare il tuo biglietto online dalla pagina <a href="/iscrizione" class="hyperlink">Iscrizione</a>.</p>
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
