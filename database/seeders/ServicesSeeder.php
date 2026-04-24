<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Seed the application's services.
     */
    public function run(): void
    {
        $now = now();

        Service::query()->upsert([
            [
                'name' => 'Dermoanalisi Facial',
                'description' => 'Estudi facial personalitzat per recomanar tractaments dermocosmètics.',
                'duration_minutes' => 30,
                'icon' => 'ScanFace',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Formulas Magistrals',
                'description' => 'Preparació i seguiment de fórmules magistrals adaptades a cada pacient.',
                'duration_minutes' => 30,
                'icon' => 'FlaskConical',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Dermoanalisi Capil·lar',
                'description' => 'Anàlisi de l\'estat del cuir cabellut i recomanació de rutina capil·lar.',
                'duration_minutes' => 30,
                'icon' => 'ScanFace',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Analítiques de sang',
                'description' => 'Proves ràpides de paràmetres sanguinis amb assessorament farmacèutic.',
                'duration_minutes' => 20,
                'icon' => 'Droplet',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Analítiques d\'Aigua',
                'description' => 'Anàlisi de qualitat de l\'aigua amb interpretació de resultats.',
                'duration_minutes' => 20,
                'icon' => 'Droplet',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Asesorament Nutricional',
                'description' => 'Orientació nutricional personalitzada segons objectius de salut.',
                'duration_minutes' => 45,
                'icon' => 'ShieldCheck',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'SPD',
                'description' => 'Sistema Personalitzat de Dosificació per millorar l\'adherència terapèutica.',
                'duration_minutes' => 30,
                'icon' => 'ShieldCheck',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Control de pressió arterial',
                'description' => 'Mesura de la pressió arterial i recomanacions bàsiques de seguiment.',
                'duration_minutes' => 15,
                'icon' => 'ShieldCheck',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['name'], ['description', 'duration_minutes', 'icon', 'updated_at']);
    }
}
