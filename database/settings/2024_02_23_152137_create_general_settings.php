<?php

use Illuminate\Support\Facades\File;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {

        File::ensureDirectoryExists(storage_path('app/public/default'));
        File::ensureDirectoryExists(storage_path('app/public/client'));
        File::ensureDirectoryExists(storage_path('app/public/generator'));
        File::ensureDirectoryExists(storage_path('app/public/document'));

        File::copy(resource_path('assets/favicon.png'), storage_path('app/public/favicon.png'));
        File::copy(resource_path('assets/cookie.svg'), storage_path('app/public/cookie.svg'));
        File::copy(resource_path('assets/default/background-member.png'), storage_path('app/public/default/background-member.png'));
        File::copy(resource_path('assets/footer-patern-dark.png'), storage_path('app/public/footer-patern-dark.png'));
        File::copy(resource_path('assets/footer-patern.png'), storage_path('app/public/footer-patern.png'));

        File::copy(resource_path('assets/default/default-logo.jpeg'), storage_path('app/public/default/default-logo.jpeg'));
        File::copy(resource_path('assets/default/default-user.jpg'), storage_path('app/public/default/default-user.jpg'));
        File::copy(resource_path('assets/client/logo.png'), storage_path('app/public/client/logo.png'));
        File::copy(resource_path('assets/client/logo_dark.png'), storage_path('app/public/client/logo_dark.png'));
        File::copy(resource_path('assets/generator/Twogether_LogoWeb.png'), storage_path('app/public/generator/Twogether_LogoWeb.png'));
        File::copy(resource_path('assets/document/01JE9TQQ2MF1K94ZMBS9K5AAT5.pdf'), storage_path('app/public/document/01JE9TQQ2MF1K94ZMBS9K5AAT5.pdf'));

        $this->migrator->add('general.display_date', 'd/m/Y');
        $this->migrator->add('general.fallback_avatar', 'default/default-user.jpg');
        $this->migrator->add('general.fallback_logo', 'default/default-logo.jpeg');
        $this->migrator->add('general.client_logo', 'client/logo.png');
        $this->migrator->add('general.client_logo_dark', 'client/logo_dark.png');
        $this->migrator->add('general.client_name', 'Hyères Entreprendre');
        $this->migrator->add('general.client_phone', '+33494763498');
        $this->migrator->add('general.client_website', 'https://hyeresentreprendre.fr');
        $this->migrator->add('general.client_email', 'he83400@gmail.com');
        $this->migrator->add('general.client_address', '758 chemin de la source');
        $this->migrator->add('general.client_city', 'Hyères');
        $this->migrator->add('general.client_postal_code', '83400');
        $this->migrator->add('general.generator_name', 'Agence Twogether');
        $this->migrator->add('general.generator_website', 'https://agencetwogether.fr');
        $this->migrator->add('general.generator_logo', 'generator/Twogether_LogoWeb.png');
        $this->migrator->add('general.generator_logo_dark', 'generator/Twogether_LogoWeb.png');
        $this->migrator->add('general.generator_name_email', 'Administrateur Hyères Entreprendre');
        $this->migrator->add('general.generator_email', 'contact@agencetwogether.fr');
        $this->migrator->add('general.generator_phone', '+33652460152');
        $this->migrator->add('general.generator_support_name', 'Support Agence Twogether');
        $this->migrator->add('general.generator_support_email', 'support@agencetwogether.fr');
        $this->migrator->add('general.app_title_page', 'Administration Hyères Entreprendre');
        $this->migrator->add('general.app_title_prefix_page', 'Application Hyères Entreprendre - ');
        $this->migrator->add('general.app_salutations_internal', "Bien cordialement, <br>Maxime, Administrateur de l'application");
        $this->migrator->add('general.app_salutations_external', 'Bien cordialement, <br>La secrétaire de Hyères Entreprendre');
        $this->migrator->add('general.app_dedicated', 'Application dédiée à Hyères Entreprendre');
        $this->migrator->add('general.app_email_logo_internal', 'client/logo.png');
        $this->migrator->add('general.app_email_logo_external', 'client/logo.png');
        $this->migrator->add('general.app_email_from', 'maxime@email.fr');
        $this->migrator->add('general.app_email_name_from', 'Max');
        $this->migrator->add('general.emails_client', []);
        $this->migrator->add('general.membership',
            [
                'content_for_email' => '<p>Merci pour votre demande decontact</p>',
                'subject_for_email' => 'Bienvenue',
                'document_for_email' => 'document/01JE9TQQ2MF1K94ZMBS9K5AAT5.pdf',
            ]);
        $this->migrator->add('general.socials_networks',
            [
                [
                    'name' => 'facebook',
                    'account' => 'https://www.facebook.com/profile.php?id=61551886042711',
                ],
            ]);
    }
};
