# Contributing — Farmàcia Soler (P6)

Aquesta guia documenta l'estil de codificació, les eines de qualitat i el
flux de treball del projecte. **Llegir-la abans de fer cap PR.**

---

## 1. Estil de codificació (Coding style)

### PHP — Laravel Pint
Tot el codi PHP segueix la **convenció PSR-12** amb el preset `laravel` de
Laravel Pint. La configuració viu a [`pint.json`](./pint.json).

```bash
# arreglar tot el codi PHP
composer lint

# només comprovar (no modifica fitxers — usat per CI)
composer lint:check
```

Regles clau:
- 4 espais d'indentació, mai tabs.
- Una classe per fitxer, namespace `App\…`.
- Mètodes públics primer; tipus declarats (`public function foo(int $x): string`).
- Imports ordenats alfabèticament (Pint ho fa automàticament).

### Vue + TypeScript — ESLint + Prettier
El frontend usa **ESLint** (config a `eslint.config.js`) i **Prettier**
(config a `.prettierrc`).

```bash
# arreglar JS/TS/Vue
npm run lint
npm run format

# comprovar (CI)
npm run lint:check
npm run format:check
npm run types:check    # vue-tsc, comprova els tipus TS dels SFC
```

Regles clau dels components Vue:
- **Composition API amb `<script setup lang="ts">`** sempre.
- Props tipades amb `defineProps<Props>()`; events amb `defineEmits<…>()`.
- Mai estils en línia; usar utilitats Tailwind.
- Una sola arrel `<template>` per fitxer (.vue).
- Un component = una responsabilitat. Si un `.vue` passa de ~300 línies,
  extreure'n un subcomponent (veure `resources/js/components/ServiceCard.vue`
  i `ServiceFormFields.vue` com a referència).

### Convencions de nomenclatura
- Controllers: `StudlyCase` + sufix `Controller` (`AdminServiceController`).
- Models: `StudlyCase` singular (`Service`, `ServiceSchedule`).
- FormRequests: `StudlyCase` + sufix `Request` (`ServiceRequest`).
- Action classes: verb + entitat + `Action` (`CreateServiceAction`).
- Migracions: `YYYY_MM_DD_HHMMSS_verb_table_table.php`.
- Components Vue: `PascalCase.vue`.
- Pàgines Inertia: agrupades sota `resources/js/pages/<feature>/`.

---

## 2. Testos (Pest)

Tot els testos viuen a `tests/Feature/` i `tests/Unit/`. Convencions:

- Un fitxer per feature: `tests/Feature/Services/AdminServiceTest.php`.
- Cada test és una funció `test('…', function() { … })`.
- `uses(RefreshDatabase::class);` a dalt del fitxer si el test toca la BD.
- Tests d'autorització abans dels tests de funcionalitat.

```bash
# executar tots els testos
composer test

# només una carpeta
./vendor/bin/pest tests/Feature/Services
```

Cobertura esperada de cada CRUD admin:
- `permís` (no admin → 403 / redirect)
- `index` (200)
- `store` amb dades vàlides
- `store` amb dades invàlides (FormRequest rules)
- `update` correctament
- `destroy` elimina la fila

Cobertura de la API pública (PedirCita):
- `index` renderitza la pàgina
- creació amb dades vàlides
- regex de telèfon / nom / email
- data passada → error
- slot ja reservat → error
- endpoint AJAX `booked-times` → JSON
- endpoint AJAX `schedule` → JSON

---

## 3. Pipeline de qualitat (CI)

Tot PR passa pels passos definits a `composer ci:check`:

```bash
composer ci:check
# ↳ npm run lint:check     (ESLint)
# ↳ npm run format:check   (Prettier)
# ↳ npm run types:check    (vue-tsc)
# ↳ composer test          (Pint check + Pest)
```

Un PR no es pot fer merge si algun d'aquests passos falla.

---

## 4. Git flow

- Branca per defecte: `develop` (integració).
- Branca `main`: només producció, mergeada des de `develop` quan es vol fer
  un release.
- Feature branches: `feature/<scope>-<short-desc>` (p. ex.
  `feature/services-crud`).
- Bugfix: `fix/<scope>-<short-desc>`.
- Hotfix (sobre `main`): `hotfix/<short-desc>`.
- Commits: missatge curt en imperatiu (`Add ServiceRequest with regex`).
- **NO** fer commits directes a `develop` ni a `main`: sempre PR + review.

---

## 5. Validació (FormRequest + AJAX)

Tota petició que persisteix dades passa per un `App\Http\Requests\…Request`.
Mai validar manualment al controller amb `$request->validate(...)` si la
mateixa regla pot reaparèixer en un altre lloc.

Patró:
1. `FormRequest::authorize()` controla el permís (rol).
2. `FormRequest::rules()` defineix les regles (regex per telèfon, format
   per data, etc.).
3. `FormRequest::messages()` retorna missatges en català.
4. El controlador només crida una `Action` amb `$request->validated()`.

Exemple: veure `app/Http/Requests/ServiceRequest.php` i
`app/Actions/Services/CreateServiceAction.php`.

---

## 6. Política d'ús d'IA

L'IA (ChatGPT, Claude, Copilot) es pot fer servir per:
- entendre conceptes o resoldre dubtes tècnics,
- generar boilerplate o documentació inicial,
- proposar tests addicionals.

**No** es pot fer servir per generar codi sense entendre-ho. Tot codi
afegit ha de poder ser explicat oralment pel seu autor. Si una IA ha
ajudat de manera substancial en una part, mencioneu-ho al PR.

---

## 7. Llista de comprovació abans d'obrir un PR

- [ ] `composer lint` passa sense errors.
- [ ] `npm run lint:check && npm run format:check && npm run types:check` passa.
- [ ] `composer test` passa.
- [ ] He afegit testos per a la nova funcionalitat.
- [ ] Cap commit directe a `develop`/`main`.
- [ ] El nom de la branca és explicatiu.
- [ ] El títol del PR és curt i en imperatiu.
