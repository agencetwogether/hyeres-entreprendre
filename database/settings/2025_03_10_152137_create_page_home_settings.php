<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('home_page_settings.general', []);

        $this->migrator->add('home_page_settings.header', []);

        $this->migrator->add('home_page_settings.content', []);

        $this->migrator->add('home_page_settings.seo', [
            'title' => null,
            'author' => null,
            'robots' => null,
            'description' => null,
        ]);
    }
};
