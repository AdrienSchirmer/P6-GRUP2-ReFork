# PROJECTE 6 — Farmàcia Soler

Plataforma web per a la **Farmàcia Soler** (Figueres): reserva de cites,
gestió de serveis i horaris, encàrrecs a domicili i mapa de farmàcies de
guàrdia.

## Equip

- **Adrien Schirmer** (Scrum Manager)
- **Brandon Reyes**
- **Fran Olivera**
- **Charfah Ilyass**

## Tecnologies

- **Backend**: Laravel 13 (PHP 8.3), Fortify (auth + 2FA), Inertia,
  Laravel Wayfinder, `lorisleiva/laravel-actions`,
  `barryvdh/laravel-dompdf`.
- **Frontend**: Vue 3 + TypeScript + Composition API, Tailwind CSS 4,
  reka-ui, lucide-vue-next, Leaflet (mapes), Swiper, vue-quill (WYSIWYG).
- **BD**: MySQL 8 (Laravel Sail / Docker).
- **Email**: SMTP (Dinahosting per defecte), Mailpit en local.
- **Verificació humana**: Cloudflare Turnstile.
- **Testos**: Pest 4 + Playwright (E2E).
- **CI/CD**: GitHub Actions, desplegament automàtic.

## Requisits

- Docker + Docker Compose (per Laravel Sail).
- Node 20+.
- Composer 2.

## Posada en marxa (local)

```bash
# 1. instal·lar dependències PHP i copiar .env
composer install
cp .env.example .env
php artisan key:generate

# 2. arrencar la pila amb Sail
./vendor/bin/sail up -d

# 3. migracions + storage
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail artisan storage:link

# 4. assets
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

Configuració del `.env` (essencial):

```env
APP_URL=http://localhost
DB_CONNECTION=mysql
DB_HOST=mysql
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password

MAIL_MAILER=smtp           # o 'log' en dev
TURNSTILE_SITE_KEY=...     # opcional en dev
TURNSTILE_SECRET_KEY=...
```

## Estructura del codi (mòdul Serveis / Cites)

| Capa | Fitxer |
|---|---|
| **FormRequest** (validació + autorització) | `app/Http/Requests/ServiceRequest.php`, `ServiceScheduleRequest.php`, `ServiceAppointmentRequest.php` |
| **Action** (lògica de negoci) | `app/Actions/Services/CreateServiceAction.php`, `UpdateServiceAction.php`, `CreateServiceScheduleAction.php`, `CreateAppointmentAction.php` |
| **Controller** (orquestració) | `app/Http/Controllers/Admin/AdminServiceController.php`, `Admin/ServiceScheduleController.php`, `ServiceController.php` |
| **Model + relacions** | `app/Models/Service.php`, `ServiceSchedule.php`, `ServiceAppointment.php` |
| **Vista (Inertia + Vue SFC)** | `resources/js/pages/admin/Services/*.vue`, `admin/ServiceSchedules/*.vue`, `PedirCita.vue` |
| **Components reutilitzables** | `resources/js/components/ServiceFormFields.vue`, `ServiceCard.vue` |
| **Testos** | `tests/Feature/Services/AdminServiceTest.php`, `ServiceScheduleTest.php`, `AppointmentTest.php` |

El patró és sempre el mateix:
**Route → FormRequest (validació) → Controller (thin) → Action (lògica) → Model**.

## Pipeline (CI/CD)

```bash
composer ci:check   # linting + format + types + testos (gate del deploy)
```

Veure `.github/workflows/Deploy.yml`. El deploy només s'executa si tot CI
és verd.

## Estil de codi i convencions

Veure [`CONTRIBUTING.md`](./CONTRIBUTING.md) per a tota la informació
sobre estil PHP/Vue, branques Git, política d'ús d'IA i checklist de PR.

## Llicència

Ús educatiu — Projecte 6 de l'institut Cendrassos.
