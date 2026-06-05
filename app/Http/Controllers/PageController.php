<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Throwable;

class PageController extends Controller
{
    private const PAGES = [
        '' => [
            'view' => 'pages.home',
            'title' => 'Sgranar per Colli 2026 | Biglietti, Programma e Iscrizioni',
            'description' => 'Sito ufficiale Sgranar per Colli 2026: camminata in Valdinievole, programma 5-6-7 giugno, partenze e iscrizioni online.',
            'canonical' => 'https://sgranarpercolli.it/',
            'bodyClass' => 'home-page',
        ],
        'contattaci' => [
            'view' => 'pages.contattaci',
            'title' => 'Contatti | Sgranar per Colli 2026',
            'description' => 'Contatta lo staff di Sgranar per Colli per informazioni su iscrizioni, programma, partenze e organizzazione.',
            'canonical' => 'https://sgranarpercolli.it/contattaci',
        ],
        'contatti' => [
            'view' => 'pages.contattaci',
            'title' => 'Contatti | Sgranar per Colli 2026',
            'description' => 'Contatta lo staff di Sgranar per Colli per informazioni su iscrizioni, programma, partenze e organizzazione.',
            'canonical' => 'https://sgranarpercolli.it/contattaci',
        ],
        'cookie-policy' => [
            'view' => 'pages.cookie-policy',
            'title' => 'Cookie Policy | Sgranar per Colli',
            'description' => 'Informativa sull\'uso dei cookie tecnici e di preferenza del sito Sgranar per Colli.',
            'canonical' => 'https://sgranarpercolli.it/cookie-policy',
        ],
        'partnership' => [
            'view' => 'pages.partnership',
            'title' => 'Partner | Sgranar per Colli 2026',
            'description' => 'Pagina partner di Sgranar per Colli 2026.',
            'canonical' => 'https://sgranarpercolli.it/partnership',
        ],
        'privacy-policy' => [
            'view' => 'pages.privacy-policy',
            'title' => 'Privacy Policy | Sgranar per Colli',
            'description' => 'Informativa privacy per iscrizioni e contatti del sito Sgranar per Colli.',
            'canonical' => 'https://sgranarpercolli.it/privacy-policy',
        ],
        'regolamento' => [
            'view' => 'pages.regolamento',
            'title' => 'Regolamento | Sgranar per Colli 2026',
            'description' => 'Regolamento sintetico di Sgranar per Colli 2026: partecipazione, biglietti, responsabilità, percorso e indicazioni utili.',
            'canonical' => 'https://sgranarpercolli.it/regolamento',
        ],
        'termini-condizioni' => [
            'view' => 'pages.regolamento',
            'title' => 'Regolamento | Sgranar per Colli 2026',
            'description' => 'Regolamento sintetico di Sgranar per Colli 2026: partecipazione, biglietti, responsabilità, percorso e indicazioni utili.',
            'canonical' => 'https://sgranarpercolli.it/regolamento',
        ],
    ];

    private const HOME_ALIASES = [
        'come-arrivare',
        'gallery',
        'orario',
        'percorsi',
        'ricettivita',
        'styleguide',
    ];

    public function show(?string $slug = ''): Response
    {
        $slug = trim((string) $slug, '/');
        $slug = Str::replaceEnd('.php', '', $slug);

        if (in_array($slug, self::HOME_ALIASES, true)) {
            $slug = '';
        }

        abort_unless(array_key_exists($slug, self::PAGES), 404);

        $page = self::PAGES[$slug];
        $data = [
            'title' => $page['title'],
            'description' => $page['description'],
            'canonical' => $page['canonical'],
            'bodyClass' => $page['bodyClass'] ?? '',
        ];

        if ($page['view'] === 'pages.home') {
            try {
                $data['totalIscritti'] = Ticket::whereNotNull('unique_ticket_code')->count();
            } catch (Throwable $e) {
                $data['totalIscritti'] = 0;
            }
        }

        return response()->view($page['view'], $data);
    }
}
