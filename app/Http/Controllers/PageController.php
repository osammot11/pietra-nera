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
            'title' => 'Hiking della Pietra Nera 2027 | Biglietti, Percorsi e Iscrizioni',
            'description' => 'Hiking della Pietra Nera: camminata ludico motoria non competitiva sui sentieri di Uscio e Lumarzo, tra monti, mare, ardesia e turismo lento.',
            'canonical' => 'https://www.hikingdellapietranera.it/',
            'bodyClass' => 'home-page',
        ],
        'contattaci' => [
            'view' => 'pages.contattaci',
            'title' => 'Contatti | Hiking della Pietra Nera',
            'description' => 'Contatta lo staff dell\'Hiking della Pietra Nera per informazioni su iscrizioni, percorsi e organizzazione.',
            'canonical' => 'https://www.hikingdellapietranera.it/contattaci',
        ],
        'contatti' => [
            'view' => 'pages.contattaci',
            'title' => 'Contatti | Hiking della Pietra Nera',
            'description' => 'Contatta lo staff dell\'Hiking della Pietra Nera per informazioni su iscrizioni, percorsi e organizzazione.',
            'canonical' => 'https://www.hikingdellapietranera.it/contattaci',
        ],
        'cookie-policy' => [
            'view' => 'pages.cookie-policy',
            'title' => 'Cookie Policy | Hiking della Pietra Nera',
            'description' => 'Informativa sull\'uso dei cookie tecnici e di preferenza del sito Hiking della Pietra Nera.',
            'canonical' => 'https://www.hikingdellapietranera.it/cookie-policy',
        ],
        'partnership' => [
            'view' => 'pages.partnership',
            'title' => 'Partner | Hiking della Pietra Nera',
            'description' => 'Pagina partner dell\'Hiking della Pietra Nera.',
            'canonical' => 'https://www.hikingdellapietranera.it/partnership',
        ],
        'privacy-policy' => [
            'view' => 'pages.privacy-policy',
            'title' => 'Privacy Policy | Hiking della Pietra Nera',
            'description' => 'Informativa privacy per iscrizioni e contatti del sito Hiking della Pietra Nera.',
            'canonical' => 'https://www.hikingdellapietranera.it/privacy-policy',
        ],
        'regolamento' => [
            'view' => 'pages.regolamento',
            'title' => 'Regolamento | Hiking della Pietra Nera',
            'description' => 'Regolamento sintetico dell\'Hiking della Pietra Nera: partecipazione, biglietti, responsabilità, percorsi e indicazioni utili.',
            'canonical' => 'https://www.hikingdellapietranera.it/regolamento',
        ],
        'termini-condizioni' => [
            'view' => 'pages.regolamento',
            'title' => 'Regolamento | Hiking della Pietra Nera',
            'description' => 'Regolamento sintetico dell\'Hiking della Pietra Nera: partecipazione, biglietti, responsabilità, percorsi e indicazioni utili.',
            'canonical' => 'https://www.hikingdellapietranera.it/regolamento',
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
