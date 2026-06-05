@if (!request()->cookie('site_cookie_consent'))
    <div id="cookieBanner" class="cookie-banner" aria-live="polite" aria-label="Banner consenso cookie">
        <div class="cookie-banner__content">
            <div class="cookie-banner__text">
                <h5>Questo sito usa i cookie</h5>
                <p class="top-margin-mid">
                    Utilizziamo cookie tecnici necessari al funzionamento del sito e, solo con il tuo consenso,
                    eventuali cookie statistici o di marketing. Puoi accettare, rifiutare oppure personalizzare le preferenze.
                    Leggi la nostra
                    <a href="/cookie-policy" class="hyperlink">Cookie Policy</a>,
                    <a href="/privacy-policy" class="hyperlink">Privacy Policy</a>
                    e i
                    <a href="/termini-condizioni" class="hyperlink">Termini e Condizioni</a>.
                </p>
            </div>

            <div class="cookie-banner__actions">
                <button type="button" class="btn cookie-btn" id="acceptAllCookies">Accetta</button>
                <button type="button" class="cookie-btn-secondary" id="rejectAllCookies">Rifiuta</button>
                <button type="button" class="cookie-btn-secondary" id="openCookieSettings">Personalizza</button>
            </div>
        </div>
    </div>

    <div id="cookieModal" class="cookie-modal" aria-hidden="true">
        <div class="cookie-modal__overlay" id="cookieModalOverlay"></div>

        <div class="cookie-modal__box" role="dialog" aria-modal="true" aria-labelledby="cookieModalTitle">
            <div class="cookie-modal__header">
                <h4 id="cookieModalTitle">Preferenze cookie</h4>
                <button type="button" class="cookie-modal__close" id="closeCookieSettings" aria-label="Chiudi">&times;</button>
            </div>

            <div class="cookie-modal__body">
                <p>Puoi scegliere quali categorie di cookie autorizzare. I cookie tecnici sono sempre attivi perché necessari al corretto funzionamento del sito.</p>

                <div class="cookie-option top-margin-large">
                    <div>
                        <h6>Cookie tecnici</h6>
                        <p class="top-margin-small">Sempre attivi. Servono al funzionamento del sito.</p>
                    </div>
                    <label class="cookie-switch cookie-switch--disabled">
                        <input type="checkbox" checked disabled>
                        <span class="cookie-slider"></span>
                    </label>
                </div>

                <div class="cookie-option top-margin-large">
                    <div>
                        <h6>Cookie statistici</h6>
                        <p class="top-margin-small">Ci aiutano a capire come viene usato il sito.</p>
                    </div>
                    <label class="cookie-switch">
                        <input type="checkbox" id="analyticsCookies">
                        <span class="cookie-slider"></span>
                    </label>
                </div>

                <div class="cookie-option top-margin-large">
                    <div>
                        <h6>Cookie marketing</h6>
                        <p class="top-margin-small">Utilizzati per tracciamento, advertising o remarketing.</p>
                    </div>
                    <label class="cookie-switch">
                        <input type="checkbox" id="marketingCookies">
                        <span class="cookie-slider"></span>
                    </label>
                </div>
            </div>

            <div class="cookie-modal__footer">
                <button type="button" class="cookie-btn-secondary" id="saveCustomCookies">Salva preferenze</button>
                <button type="button" class="btn cookie-btn" id="acceptAllFromModal">Accetta tutto</button>
            </div>
        </div>
    </div>
@endif

<script>
(function () {
    const consentCookieName = 'site_cookie_consent';
    const consentDurationDays = 180;

    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + date.toUTCString() + '; path=/; SameSite=Lax';
    }

    function getCookie(name) {
        const nameEQ = name + '=';
        const ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            const c = ca[i].trim();
            if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length));
        }
        return null;
    }

    function hideBannerAndModal() {
        const banner = document.getElementById('cookieBanner');
        const modal = document.getElementById('cookieModal');

        if (banner) banner.remove();
        if (modal) modal.remove();
    }

    function saveConsent(preferences) {
        setCookie(consentCookieName, JSON.stringify(preferences), consentDurationDays);
        window.cookieConsent = preferences;
        hideBannerAndModal();
    }

    function openModal() {
        const modal = document.getElementById('cookieModal');
        if (!modal) return;
        modal.classList.add('is-active');
        modal.setAttribute('aria-hidden', 'false');
    }

    function closeModal() {
        const modal = document.getElementById('cookieModal');
        if (!modal) return;
        modal.classList.remove('is-active');
        modal.setAttribute('aria-hidden', 'true');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const existingConsent = getCookie(consentCookieName);

        if (existingConsent) {
            try {
                window.cookieConsent = JSON.parse(existingConsent);
            } catch (e) {}
        } else {
            setTimeout(() => {
                const banner = document.getElementById('cookieBanner');
                if (banner) banner.classList.add('is-visible');
            }, 1000);
        }

        const acceptAllBtn = document.getElementById('acceptAllCookies');
        const rejectAllBtn = document.getElementById('rejectAllCookies');
        const openSettingsBtn = document.getElementById('openCookieSettings');
        const closeSettingsBtn = document.getElementById('closeCookieSettings');
        const saveCustomBtn = document.getElementById('saveCustomCookies');
        const acceptAllFromModalBtn = document.getElementById('acceptAllFromModal');
        const overlay = document.getElementById('cookieModalOverlay');
        const analyticsCheckbox = document.getElementById('analyticsCookies');
        const marketingCheckbox = document.getElementById('marketingCookies');

        if (acceptAllBtn) {
            acceptAllBtn.addEventListener('click', function () {
                saveConsent({ necessary: true, analytics: true, marketing: true });
            });
        }

        if (rejectAllBtn) {
            rejectAllBtn.addEventListener('click', function () {
                saveConsent({ necessary: true, analytics: false, marketing: false });
            });
        }

        if (openSettingsBtn) openSettingsBtn.addEventListener('click', openModal);
        if (closeSettingsBtn) closeSettingsBtn.addEventListener('click', closeModal);
        if (overlay) overlay.addEventListener('click', closeModal);

        if (saveCustomBtn) {
            saveCustomBtn.addEventListener('click', function () {
                saveConsent({
                    necessary: true,
                    analytics: analyticsCheckbox ? analyticsCheckbox.checked : false,
                    marketing: marketingCheckbox ? marketingCheckbox.checked : false
                });
            });
        }

        if (acceptAllFromModalBtn) {
            acceptAllFromModalBtn.addEventListener('click', function () {
                saveConsent({ necessary: true, analytics: true, marketing: true });
            });
        }
    });
})();
</script>
