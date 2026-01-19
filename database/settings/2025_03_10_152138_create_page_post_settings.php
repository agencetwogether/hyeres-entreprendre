<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('post_page_settings.general', [
            'post_per_page' => 2,
            'post_per_loading' => 2,
        ]);

        $this->migrator->add('post_page_settings.header', [
            'title' => 'Nos actualités',
            'description' => 'Description',
            'banner' => null,
            'show_default_banner' => true,
        ]);

        $this->migrator->add('post_page_settings.content', []);

        $this->migrator->add('post_page_settings.seo', [
            'title' => null,
            'author' => null,
            'robots' => null,
            'description' => null,
        ]);
    }
};
