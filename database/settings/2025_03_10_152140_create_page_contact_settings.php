<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('contact_page_settings.general', []);

        $this->migrator->add('contact_page_settings.header', [
            'title' => 'Contact',
            'description' => '',
            'banner' => null,
            'show_default_banner' => true,
        ]);

        $this->migrator->add('contact_page_settings.content', [
            'presentation' => [
                'text' => 'Texte de présentation',
                'image' => null,
            ],
            'show_postal_address' => true,
            'show_phone' => true,
            'show_email' => true,
            'show_map' => false,
        ]);

        $this->migrator->add('contact_page_settings.seo', [
            'title' => null,
            'author' => null,
            'robots' => null,
            'description' => null,
        ]);
    }
};
