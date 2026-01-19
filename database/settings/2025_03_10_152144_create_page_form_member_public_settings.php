<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('form_member_public_page_settings.general', []);

        $this->migrator->add('form_member_public_page_settings.header', []);

        $this->migrator->add('form_member_public_page_settings.content', [
            'title' => 'Formulaire d\'inscription',
            'text' => 'Merci de remplir ce formulaire pour rejoindre l\'association. Vous serez prévenus lors de la validation de ce dernier par notre équipe.',
            'disclaimer' => 'Certains champs sont pré-remplis suite à votre demande de contact',
            'thanks' => [
                'title' => 'Merci,',
                'text' => 'Votre inscription va maintenant être examinée.',
            ],
        ]);

        $this->migrator->add('form_member_public_page_settings.seo', [
            'title' => 'Hyères Entreprendre - Création de votre fiche de membre',
            'author' => 'Hyères Entreprendre',
            'robots' => 'noindex, nofollow',
            'description' => 'Renseignez vos informations pour créer votre profil de membre, nous examinerons ensuite votre demande',
        ]);
    }
};
