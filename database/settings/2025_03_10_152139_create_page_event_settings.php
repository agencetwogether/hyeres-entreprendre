<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('event_page_settings.general', [
            'event_per_page' => 2,
            'event_per_loading' => 2,
        ]);

        $this->migrator->add('event_page_settings.header', [
            'title' => 'Nos évènements',
            'description' => '',
            'banner' => null,
            'show_default_banner' => true,
        ]);

        $this->migrator->add('event_page_settings.content', []);

        $this->migrator->add('event_page_settings.seo', [
            'title' => null,
            'author' => null,
            'robots' => null,
            'description' => null,
        ]);
    }
};
