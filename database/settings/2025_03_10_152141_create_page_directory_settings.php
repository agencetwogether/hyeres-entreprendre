<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('directory_page_settings.general', [
            'item_per_page' => 2,
            'item_per_loading' => 2,
        ]);

        $this->migrator->add('directory_page_settings.header', [
            'title' => 'Nos partenaires et adhérents',
            'description' => '',
            'banner' => null,
            'show_default_banner' => true,
        ]);

        $this->migrator->add('directory_page_settings.content', []);

        $this->migrator->add('directory_page_settings.seo', [
            'title' => null,
            'author' => null,
            'robots' => null,
            'description' => null,
        ]);
    }
};
