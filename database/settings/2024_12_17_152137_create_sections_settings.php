<?php

use Illuminate\Support\Facades\File;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        File::ensureDirectoryExists(storage_path('app/public/intro'));
        File::ensureDirectoryExists(storage_path('app/public/slider-presentation'));

        File::copy(resource_path('assets/intro/intro.webp'), storage_path('app/public/intro/intro.webp'));
        File::copy(resource_path('assets/slider-presentation/presentation-1.jpg'), storage_path('app/public/slider-presentation/presentation-1.jpg'));
        File::copy(resource_path('assets/slider-presentation/presentation-2.jpg'), storage_path('app/public/slider-presentation/presentation-2.jpg'));
        File::copy(resource_path('assets/slider-presentation/presentation-3.jpg'), storage_path('app/public/slider-presentation/presentation-3.jpg'));

        $this->migrator->add('sections.introduction',
            [
                'link' => [
                    'url' => config('app.url'),
                    'label' => "Découvrir l'association",
                    'is_visible' => true,
                ],
                'image' => 'intro/intro.jpg',
                'title' => '<h2>Hyères <br><span style="color: #f0aa0b;">Entreprendre</span></h2>',
                'content' => '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using</p>',
                'subtitle' => 'Association',
                'is_visible' => true,

            ]);
        $this->migrator->add('sections.presentation',
            [
                'title' => "L'association Hyères Entreprendre",
                'slider' => [
                    'slider-presentation/presentation-1.jpg',
                    'slider-presentation/presentation-2.jpg',
                    'slider-presentation/presentation-3.jpg',
                ],
                'content' => "<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet</p>",
                'subtitle' => 'Sous titre',
                'is_visible' => true,

            ]);
        $this->migrator->add('sections.join',
            [
                'links' => [
                    [
                        'url' => config('app.url').'/contact',
                        'label' => 'Contacter nous',
                        'style' => 'primary',
                    ],
                    [
                        'url' => config('app.url').'/annuaire',
                        'label' => 'Voir nos adhérents',
                        'style' => 'secondary',
                    ],
                ],
                'title' => 'Rejoignez-nous, devenez partenaire ou adhérent',
                'content' => "<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet</p>",
                'is_visible' => false,
            ]);
    }
};
