<?php

use App\Enums\IntervalPeriod;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('licence.name', "Licence annuelle d'utilisation de la plateforme");
        $this->migrator->add('licence.description', "<p>Maintenance de l'application mensuelle</p><ul><li>Frais et Maintenance du serveur d'hébergement</li><li>Mises à jour de sécurité</li></ul>");
        $this->migrator->add('licence.price', 600);
        $this->migrator->add('licence.next_price', 0);
        $this->migrator->add('licence.invoice_period', 1);
        $this->migrator->add('licence.invoice_interval', IntervalPeriod::YEAR);
        $this->migrator->add('licence.invoice_contact_name', 'Nom contact pour facturation');
        $this->migrator->add('licence.invoice_contact_email', 'client@facture.fr');
        $this->migrator->add('licence.starts_at', now());
        $this->migrator->add('licence.ends_at', now()->addYear());
        $this->migrator->add('licence.days_before', ['7', '15', '30']);
    }
};
