<?php

return [
    'general' => [
        'enum_role' => [
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            'member' => 'Membre',
        ],
        'enum_interval_period' => [
            'year' => 'An',
            'years' => 'Ans',
            'month' => 'Mois',
            'months' => 'Mois',
            'week' => 'Semaine',
            'weeks' => 'Semaines',
            'day' => 'Jour',
            'days' => 'Jours',
        ],
        'enum_status_contact' => [
            'created' => 'Prise de contact',
            'waiting' => 'En attente de la création de la fiche de membre',
            'received_payment' => 'Cotisation reçue',
            'completed' => 'Demande traitée',
        ],
        'enum_payment_method' => [
            'credit_card' => 'Carte bancaire',
            'bank_transfer' => 'Virement bancaire',
            'cash' => 'Espèces',
            'paypal' => 'Paypal',
            'other' => 'Autre',
            'nc' => 'Non communiqué', // =facture generee apres coup
        ],
        'enum_member_type' => [
            'member' => 'Adhérent',
            'partner' => 'Partenaire',
            'office' => 'Bureau',
            'members' => 'Adhérents',
            'partners' => 'Partenaires',
            'offices' => 'Bureau',
        ],
        'enum_office_role' => [
            'president' => 'Président',
            'vice_president' => 'Vice Président',
            'secretary' => 'Secrétaire',
            'assistant_secretary' => 'Secrétaire Adjoint',
            'treasurer' => 'Trésorier',
            'assistant_treasurer' => 'Trésorier Adjoint',
        ],
        'user_menu' => [
            'label_profile' => 'Mon compte',
        ],
        'navigation' => [
            'groups' => [
                'site' => 'Site',
                'support' => 'Support',
                'settings' => 'Paramètres',
                'administration' => 'Administration',
                'pages' => 'Réglages Pages',
            ],
        ],
        'copy_email' => 'Adresse email copiée',
        'success_contact_form' => 'Merci, votre demande a bien été transmise',
        'greeting' => 'Bonjour :firstname :name,',
        'characters' => 'caractères',
        'go_to_front' => 'Voir le site',
        'go_to_back' => 'Accès Membre',
        'seo' => [
            'form' => [
                'label' => [
                    'title' => 'Titre de la page',
                    'description' => 'Description de la page',
                    'robots' => 'Robots',
                    'author' => 'Auteur',
                    'options' => [
                        'noindex' => 'Interdire le référencement de la page',
                        'index' => 'Autoriser le référencement de la page',
                    ],
                ],
                'section' => [
                    'title' => 'Définir les balises SEO',
                    'description' => 'Gérer les contenus des balises pour le référencement',
                ],
            ],

        ],
        'header-settings' => [
            'form' => [
                'label' => [
                    'title' => 'Titre',
                    'description' => 'Sous-titre',
                    'banner' => 'Bannière',
                    'show_default_banner' => 'Afficher l\'image par défaut si aucune image est définie',
                ],
                'section' => [
                    'title' => 'En-tête',
                    'description' => '',
                ],
            ],

        ],
        'error_notification_invoice_not_found' => 'Impossible de trouver/génerer la facture',
        'invoice' => [
            'header' => [
                'number' => 'Numéro',
                'date' => 'Date',
                'generated_document' => 'Document généré',
            ],
            'billing' => [
                'label' => 'Facturer à',
            ],
            'table_details' => [
                'items' => 'Articles',
                'amount' => 'Montant',
                'subtotal' => 'Sous total',
                'total' => 'Total',
                'discount' => 'Remise :discount',
                'amount_paid' => 'Montant réglé le :date',
            ],
        ],
        'application_created' => 'Création',
        'share' => 'Partager :',
    ],

    'pages' => [
        'errors' => [
            'action' => [
                'return' => "Retour à l'accueil",
            ],
            '401' => [
                'title' => 'Accès refusé !',
                'description' => 'Autorisation requise',
                'message' => "Vous n'avez pas les droits requis pour accèder à cette page.",
            ],
            '403' => [
                'title' => 'Accès refusé !',
                'description' => 'Accès refusé',
                'message' => "Il est impossible d'accèder à cette page.",
            ],
            '404' => [
                'title' => 'Page introuvable !',
                'description' => "Une erreur s'est produite",
                'message' => "Malheureusement, cette page n'existe pas...",
            ],
            '419' => [
                'title' => 'Page expirée !',
                'description' => "Page expirée, vous n'êtes plus connecté",
                'message' => 'Vous devez vous reconnecter pour continuer.',
            ],
            '429' => [
                'title' => 'Trop de requêtes !',
                'description' => 'Trop de requêtes',
                'message' => 'Le serveur a reçu un trop grand nombre de requêtes pendant un laps de temps défini.',
            ],
            '500' => [
                'title' => 'Erreur interne du serveur !',
                'description' => 'Erreur interne du serveur',
                'message' => 'Le serveur a rencontré un problème.',
            ],
            '503' => [
                'title' => 'Service non-disponible !',
                'description' => 'Service non-disponible',
                'message' => 'Le serveur a rencontré un problème. Merci de renouveller votre demande ultérieurement.',
            ],
        ],
        'edit-permission' => [
            'title' => 'Attribuer des permissions à :name',
            'form' => [
                'placeholder' => [
                    'assigned_roles' => 'Rôles assignés',
                ],
                'section' => [
                    'title' => 'Gestion des permissions directes ainsi que des permissions issues des rôles assignés',
                    'description' => 'Attribuer des permissions spécifiques',
                ],
            ],
        ],
        'auth' => [
            'edit_profile' => [
                'title' => 'Modification de votre profil utilisateur',
                'form' => [
                    'label' => [
                        'avatar' => 'Photo de profil',
                        'name' => 'Nom',
                        'firstname' => 'Prénom',
                        'email' => 'Email',
                        'phone' => 'Téléphone',
                        'want_notify' => 'Recevoir les notifications par email ?',
                        'current_password' => 'Mot de passe actuel',
                        'new_password' => 'Nouveau mot de passe',
                        'confirmation_new_password' => 'Confirmation du nouveau mot de passe',
                        'logo' => 'Logo',
                        'name_firm' => 'Nom',
                    ],
                    'placeholder' => [
                        'want_notify_hint' => "En désactivant cette option, vous ne recevrez plus les notifications envoyées par email de l'application",
                    ],
                    'section' => [
                        'information_title' => 'Informations personnelles du compte utilisateur',
                        'information_description' => "Mettez à jour les informations de profil et l'adresse e-mail de votre compte",
                        'funeral_title' => "Informations de l'entreprise",
                        'funeral_description' => "Mettez à jour les informations de l'entreprise de Pompes Funèbres",
                        'password_title' => 'Mot de passe',
                        'password_description' => 'Mettez à jour le mot de passe de votre compte',
                    ],
                ],
                'notification' => [
                    'information_title' => 'Informations personnelles du compte utilisateur mises à jour',
                    'funeral_title' => "Informations de l'entreprise mises à jour",
                    'password_title' => 'Mot de passe mis à jour',
                ],
                'action' => [
                    'label' => [
                        'save' => 'Sauvegarder',
                    ],
                ],
            ],
            'change-password' => [
                'form' => [
                    'section' => [
                        'password_title' => 'Votre nouveau mot de passe',
                        'password_description' => 'Mettez à jour le mot de passe temporaire reçu par un nouveau',
                    ],
                ],
            ],
        ],
        'support' => [
            'title' => 'Contacter le Support Technique',
            'navigation_title' => "Besoin d'aide",
            'form' => [
                'label' => [
                    'subject' => 'Sujet',
                    'content' => 'Votre message',
                ],
                'placeholder' => [
                    'subject' => 'Sujet de votre demande',
                    'content' => 'Décrivez ici votre problème, question ou toute autre information',
                ],
                'section' => [
                    'title' => "Vous rencontrez un problème technique sur l'application ? Contactez-nous !",
                    'description' => "Ce formulaire est à votre disposition pour une demande d'assistance, de signalement, de problème (bug), ou pour toute autre demande",
                ],
            ],
            'notification' => [
                'success' => 'Merci, votre demande a bien été envoyée',
                'error' => "Un problème est survenu lors de l'envoi de l'email. Merci de renouveller votre demande",
            ],
            'action' => [
                'label' => [
                    'support' => 'Contacter le support',
                    'send' => 'Envoyer la demande',
                ],
            ],
        ],
        'communication' => [
            'title' => 'Envoyer un communiqué, une information globale',
            'navigation_title' => 'Communication interne',
            'form' => [
                'label' => [
                    'model' => 'Cible',
                    'recipients' => 'Destinataires',
                    'select_all' => 'Selectionner tout',
                    'subject' => 'Sujet',
                    'content' => 'Message',
                ],
                'section' => [
                    'title' => 'Une information, un communiqué',
                    'description' => "Ce formulaire permet d'envoyer une information/communiqué aux destinataires sélectionnés",
                ],
            ],
            'notification' => [
                'success' => 'Merci, l\'email a bien été envoyé',
                'error' => "Un problème est survenu lors de l'envoi de l'email. Merci de renouveller votre demande",
            ],
            'action' => [
                'label' => [
                    'support' => 'Contacter le support',
                    'send' => 'Envoyer',
                ],
            ],
        ],
        'manage-licence' => [
            'title' => 'Gestion de la licence',
            'navigation_title' => 'Licence',
            'form' => [
                'label' => [
                    'price' => 'Prix',
                    'next_price' => 'Prochain Prix',
                    'duration_subscribe_licence' => "Durée de l'abonnement",
                    'name' => 'Nom',
                    'description' => 'Description',
                    'start_subscribe_licence' => 'Début abonnement',
                    'end_subscribe_licence' => 'Fin abonnement',
                    'contact_name_invoice' => 'Nom pour la facturation',
                    'contact_email_invoice' => 'Email pour la facturation',
                    'days_before_licence' => "Jours avant l'envoi d'email de rappel",
                ],
                'placeholder' => [
                    'reminder' => 'Licence actuelle',
                    'from' => 'Du',
                    'to' => 'au',
                    'next_price' => 'A définir si augmentation prévue pour le prochain renouvellement, sinon laisser à 0',
                    'helper_days_before_licence' => "Définir la fréquence d'envoi d'email avant l'échéance de la licence en cours pour inviter le client à la renouveller",
                    'days_before_licence' => 'Nouvelle entrée',
                ],
                'tabs' => [
                    'resume' => 'Général',
                    'general' => 'Info. Générales',
                    'notification' => 'Notification',
                ],
            ],
        ],
        'manage-settings' => [
            'title' => 'Réglages',
            'navigation_title' => 'Réglages',
            'form' => [
                'label' => [
                    'fallback_avatar' => 'Photo de profil par défaut',
                    'fallback_logo' => 'Logo par défaut',
                    'display_date' => "Format de la date d'affichage",
                    'client_logo' => 'Logo',
                    'client_logo_dark' => 'Logo (mode sombre)',
                    'client_name' => 'Nom',
                    'client_phone' => 'Téléphone',
                    'client_website' => 'Site internet',
                    'client_email' => 'Email',
                    'client_street' => 'Rue',
                    'client_postal_code' => 'Code postal',
                    'client_city' => 'Ville',
                    'generator_name' => 'Nom',
                    'generator_website' => 'Site internet',
                    'generator_logo' => 'Logo',
                    'generator_logo_dark' => 'Logo (mode sombre)',
                    'generator_name_email' => "Nom (affiché pour l'email)",
                    'generator_email' => 'Adresse email',
                    'generator_phone' => 'Téléphone',
                    'generator_support_name' => "Nom du support (affiché pour l'email)",
                    'generator_support_email' => 'Adresse email du support',
                    'app_title_page' => 'Titre de la page',
                    'app_title_prefix_page' => 'Préfix de titre de page',
                    'app_salutations_internal' => 'Salutations (mode interne)',
                    'app_email_logo_internal' => 'Logo pour envoi interne',
                    'app_salutations_external' => 'Salutations (mode externe)',
                    'app_email_logo_external' => 'Logo pour envoi externe',
                    'app_dedicated' => 'Application dédiée',
                    'app_email_from' => "Adresse email d'envoi",
                    'app_email_name_from' => "Nom d'envoi (affiché pour l'email)",
                    'emails_client' => 'Emails des services',
                    'emails_client_function' => 'Fonction',
                    'emails_client_name' => "Nom d'envoi (affiché pour l'email)",
                    'emails_client_email' => 'Adresse email',
                    'emails_client_key' => 'Clef',
                    'membership_document' => 'Document d\'adhésion',
                    'membership_document_preview' => 'Aperçu du document d\'adhésion',
                    'membership_subject_for_email' => 'Objet',
                    'membership_content_for_email' => 'Contenu',
                    'repeater_socials_networks' => [
                        'name' => 'Réseau social',
                        'account' => 'Compte',
                        'account_helper' => 'Coller ici l\'adresse URL de votre compte',
                        'add' => 'Ajouter un réseau social',
                    ],
                ],
                'placeholder' => [

                ],
                'tabs' => [
                    'general' => 'Général',
                    'client' => 'Client',
                    'client_admin' => 'Vos informations',
                    'provider' => 'Prestataire',
                    'application' => 'Application',
                    'emails_client' => 'Emails Client',
                    'membership' => 'Adhésion',
                    'socials_networks' => 'Réseaux sociaux',
                ],
                'shout' => [
                    'so-important' => [
                        'title' => 'Important',
                        'content' => 'Définir ici les emails des différents services du client, et utiliser la clef pour utiliser l\'email correspondant dans les notifications',
                    ],
                ],
            ],
            'action' => [
                'label' => [
                    'add_new_email' => 'Ajouter un nouvel email',
                ],
            ],
        ],
        'manage-sections' => [
            'title' => 'Sections (page Accueil)',
            'navigation_title' => 'Sections',
            'form' => [
                'label' => [
                    'is_visible' => 'Visible',
                    'image_background' => 'Image de fond',
                    'title' => 'Titre',
                    'subtitle' => 'Sous-titre',
                    'content' => 'Contenu',
                    'slider' => 'Diaporama',
                    'repeater' => [
                        'links' => [
                            'title' => 'Liens',
                            'add_item' => 'Ajouter un lien',
                            'label' => 'Intitulé du lien',
                            'url' => 'Adresse du lien (URL)',
                            'style_label' => 'Style du bouton',
                            'style' => [
                                'primary' => 'Primaire',
                                'secondary' => 'Secondaire',
                                'outlined' => 'Contour',
                            ],
                        ],
                    ],

                ],
                'fieldset' => [
                    'link' => [
                        'title' => 'Lien',
                        'is_visible' => 'Visible',
                        'label' => 'Intitulé du lien',
                        'url' => 'Adresse du lien (URL)',

                    ],
                ],
                'placeholder' => [],
                'tabs' => [
                    'introduction' => 'Introduction',
                    'presentation' => 'Présentation',
                    'join' => 'Nous rejoindre',
                ],
                'action' => [
                    'save' => 'Sauvegarder',
                ],
            ],
            'notification' => [
                'introduction' => 'Paramètres de la section Introduction sauvegardés',
                'presentation' => 'Paramètres de la section Présentation sauvegardés',
                'join' => 'Paramètres de la section Nous rejoindre sauvegardés',
            ],
        ],
        'contact-page' => [
            'label' => [
                'name' => 'Nom',
                'firstname' => 'Prénom',
                'email' => 'Email',
                'phone' => 'Téléphone',
                'message' => 'Message',
                'interested' => 'Je suis intéressé(e) pour rejoindre l\'association',
                'company_information' => 'Informations sur votre entreprise',
                'company' => 'Société',
                'activity' => 'Secteur d\'activité',
                'address' => 'Adresse',
                'street' => 'Rue',
                'street_ext' => 'Complément',
                'postal_code' => 'Code postal',
                'city' => 'Ville',
                'rgpd' => "J'accepte d'être recontacté par téléphone ou email",
                'see_consent' => 'Voir le détail du consentement',
                'reduce_consent' => 'Réduire',
            ],
            'placeholder' => [
                'name' => 'Votre Nom',
                'firstname' => 'Votre Prénom',
                'email' => 'Votre Email',
                'phone' => 'Votre numéro de téléphone',
                'message' => 'Votre message',
                'company' => 'Votre entreprise',
                'activity' => 'Votre secteur d\'activité',
                'street' => 'Av. Gambetta',
                'postal_code' => '83400',
                'city' => 'Hyères',
            ],
            'submit' => 'Envoyer',
        ],
        'member-page' => [
            'label' => [
                'all' => 'Tous les membres',
                'activity' => 'Secteur d\'activité',
            ],
            'placeholder' => [
                'search' => 'Rechercher...',
            ],
            'reset_filter' => 'Réinitialiser les filtres',
            'load_more' => 'En voir plus',
            'text_no_result' => '<p>Aucun résultat, veuillez renouveler votre recherche ou effacer les filtres</p>',
            'activity' => 'Activité',
            'job' => 'Fonction/Poste',
            'address' => 'Adresse',
            'phone' => 'Téléphone',
            'presentation' => 'Présentation',
            'back_to_directory' => 'Retour a l\'annuaire',
            'website' => 'Site',
            'consult' => 'Consulter',
            'directory_title' => 'Annuaire des <span>Partenaires</span> et des <span>Adhérents</span>',
            'see_all_members' => 'Voir tous les membres',
            'our_members' => 'Nos Adhérents',
            'our_partners' => 'Nos Partenaires',
        ],
        'home-page-settings' => [
            'title' => 'Page Accueil',
            'navigation_title' => 'Page Accueil',
        ],
        'post-page-settings' => [
            'title' => 'Page Actualités',
            'navigation_title' => 'Page Actualités',
            'form' => [
                'tabs' => [
                    'general' => [
                        'title' => 'Général',
                        'post_per_page' => 'Nombre d\'actualités par page',
                        'post_per_loading' => 'Nombre d\'actualités à charger',
                        'section' => [
                            'parameters' => [
                                'title' => 'Paramètres',
                                'description' => '',
                            ],
                        ],

                    ],
                ],
            ],
        ],
        'event-page-settings' => [
            'title' => 'Page Evènements',
            'navigation_title' => 'Page Evènements',
            'form' => [
                'tabs' => [
                    'general' => [
                        'title' => 'Général',
                        'event_per_page' => 'Nombre d\'évènements par page',
                        'event_per_loading' => 'Nombre d\'évènements à charger',
                        'section' => [
                            'parameters' => [
                                'title' => 'Paramètres',
                                'description' => '',
                            ],
                        ],
                    ],
                ],

            ],
        ],
        'directory-page-settings' => [
            'title' => 'Page Annuaire',
            'navigation_title' => 'Page Annuaire',
            'form' => [
                'tabs' => [
                    'general' => [
                        'title' => 'Général',
                        'item_per_page' => 'Nombre de membres par page et à charger',
                        'show_filter_member_type' => 'Afficher le filtre : Type de membre (menu déroulant)',
                        'show_filter_search' => 'Afficher le filtre : Recherche (champ texte)',
                        'section' => [
                            'parameters' => [
                                'title' => 'Paramètres',
                                'description' => '',
                            ],
                        ],

                    ],
                ],
            ],
        ],
        'contact-page-settings' => [
            'title' => 'Page Contact',
            'navigation_title' => 'Page Contact',
            'form' => [
                'tabs' => [
                    'general' => [
                        'title' => 'Général',
                        'presentation_text' => 'Texte de présentation',
                        'image' => 'Image de présentation',
                        'show_postal_address' => 'Afficher l\'adresse postale',
                        'show_phone' => 'Afficher le téléphone',
                        'show_email' => 'Afficher l\'email',
                        'show_map' => 'Afficher la carte',
                        'text_legal_below_form' => 'Texte en dessous du formulaire',
                        'text_legal_below_form_hint' => 'Ce texte présente brièvement la gestion du traitement des données',
                        'section' => [
                            'content' => [
                                'title' => 'Contenu (avant le formulaire)',
                                'description' => '',
                            ],
                            'legal_form' => [
                                'title' => 'Textes du formulaire de contact',
                                'description' => '',
                            ],
                        ],
                    ],
                ],

            ],
        ],
        'form-member-public-page-settings' => [
            'title' => 'Page Création fiche membre (par invitation)',
            'navigation_title' => 'Page Création fiche membre',
            'form' => [
                'tabs' => [
                    'general' => [
                        'title' => 'Général',
                        'page_title' => 'Titre',
                        'text' => 'Texte',
                        'disclaimer' => 'Message important (affiché en début de formulaire)',
                        'section' => [
                            'content' => [
                                'title' => 'Contenu (avant le formulaire)',
                                'description' => '',
                            ],
                            'thank_you' => [
                                'title' => 'Textes de remerciement',
                                'description' => 'Affichés lors de la soumission du formulaire',
                            ],
                        ],
                    ],
                ],

            ],
        ],
        'legal-page-settings' => [
            'title' => 'Page Mentions légales',
            'navigation_title' => 'Page Mentions légales',
            'form' => [
                'tabs' => [
                    'general' => [
                        'title' => 'Général',
                        'content' => 'Contenu',
                        'section' => [
                            'content' => [
                                'title' => 'Contenu',
                                'description' => '',
                            ],
                        ],
                    ],
                ],

            ],
        ],
        'policy-page-settings' => [
            'title' => 'Page Politique de confidentialité',
            'navigation_title' => 'Page Politique de confidentialité',
            'form' => [
                'tabs' => [
                    'general' => [
                        'title' => 'Général',
                        'content' => 'Contenu',
                        'section' => [
                            'content' => [
                                'title' => 'Contenu',
                                'description' => '',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'my-company' => [
            'title' => 'Mon entreprise',
            'navigation_title' => 'Mon entreprise',

        ],
        'my-subscription' => [
            'title' => 'Mon adhésion',
            'navigation_title' => 'Mon adhésion',
            'past-subscription' => [
                'name' => 'Abonnement :name',
                'period' => 'Période couverte : du :from au :to',
                'amount' => 'Montant',
                'discount' => 'Réduction de ',
                'either' => 'soit',
                'payment_received' => 'Réglement par <strong>:payment</strong>, reçu le :date',
                'no-subscription' => ' Aucun abonnement précédent',
            ],
        ],
        'front-register-member' => [
            'submit' => 'Envoyer la demande',
            'notification_success' => 'La demande d\'inscription a bien été enregistrée',
            'back_button_label' => 'Retour au site de l\'association',
        ],
        'post' => [
            'our_posts' => 'Nos actualités',
            'see_all_posts' => 'Voir toutes les actualités',
            'published_on' => 'publié le :date',
            'show_more' => 'En voir plus',
        ],
        'event' => [
            'our_events' => 'Nos Evènements',
            'show_all' => 'Voir tous les évènements',
            'more_details' => 'Plus de détail',
            'show_more' => 'En voir plus',
        ],
        'contact' => [
            'call_us' => 'Appelez-Nous',
            'write_us' => 'Ecrivez-Nous',
            'come_in' => 'Adresse',
        ],
        'policy' => [
            'manage_cookies' => 'Gérer les cookies',
            'list_cookies' => 'Liste des cookies émis',
            'table' => [
                'cookie' => 'Cookie',
                'description' => 'Description',
                'duration' => 'Durée',
            ],
        ],
    ],

    'widgets' => [
        'check_licence' => [
            'valid' => [
                'description' => "Votre licence d'utilisation/maintenance de votre application est valide jusqu'au",
            ],
            'invalid' => [
                'description' => "Votre licence d'utilisation/maintenance de votre application n'est plus valide depuis le",
            ],
        ],
    ],

    'form' => [
        'phone_input' => [
            'countries' => [
                'fr' => 'France',
                'ad' => 'Andorre',
                'at' => 'Autriche',
                'be' => 'Belgique',
                'de' => 'Allemagne',
                'dk' => 'Danemark',
                'dz' => 'Algérie',
                'es' => 'Espagne',
                'fi' => 'Finlande',
                'gb' => 'Royaume-Uni',
                'gp' => 'Guadeloupe',
                'gr' => 'Grèce',
                'ie' => 'Irlande',
                'is' => 'Islande',
                'it' => 'Italie',
                'li' => 'Liechtenstein',
                'lt' => 'Lituanie',
                'lu' => 'Luxembourg',
                'ma' => 'Maroc',
                'mc' => 'Monaco',
                'mq' => 'Martinique',
                'nl' => 'Pays-Bas',
                'no' => 'Norvège',
                'pl' => 'Pologne',
                'pt' => 'Portugal',
                're' => 'Réunion',
                'ro' => 'Roumanie',
                'se' => 'Suède',
                'tn' => 'Tunisie',
                'ua' => 'Ukraine',
                'us' => 'Etats-Unis',
                'country_selected' => 'Pays sélectionné',
                'countries_list' => 'Liste des pays',
                'search_placeholder' => 'Recherche',
            ],
        ],
    ],

    'contacts' => [
        'singular' => 'Contact',
        'plural' => 'Contacts',
        'navigation_label' => 'Contacts',
        'navigation_badge' => 'Demande à traiter|Demandes à traiter',
        'page' => [
            'title_list' => 'Liste des contacts',
            'title_view' => 'Contact : :model',
        ],
        'table' => [
            'label' => [
                'status' => 'Statut',
                'name' => 'Nom',
                'firstname' => 'Prénom',
                'email' => 'Email',
                'phone' => 'Téléphone',
                'content' => 'Message',
                'created_at' => 'Date',
            ],
        ],
        'form' => [
            'label' => [
                'name' => 'Nom',
                'firstname' => 'Prénom',
                'email' => 'Email',
                'phone' => 'Téléphone',
                'content' => 'Message',
                'interested' => 'Intérêt pour rejoindre l\'association',
                'company' => 'Entreprise',
                'activity' => 'Secteur d\'activité',
                'address' => 'Adresse',
                'street' => 'Rue',
                'street_ext' => 'Complément',
                'postal_code' => 'Code postal',
                'city' => 'Ville',
                'created_at' => 'Date',
                'response_date' => 'Date d\'envoi',
                'response_subject' => 'Objet',
                'response_content' => 'Contenu',
            ],
            'placeholder' => [
            ],
            'section' => [
                'title' => 'Prise de contact du :date',
                'description' => 'Informations propres à la personne ayant utilisé le formulaire de contact',
                'title_response' => 'Réponse du :date',
                'description_response' => 'Rappel sur la réponse envoyée',
            ],
        ],
        'notification' => [
            'deleted' => 'Contact :model supprimé avec succès',
        ],
        'action' => [
            'modal' => [
                'delete_title' => 'Supprimer le contact :model',
            ],
        ],
        'global_search' => [
            'date' => 'Date de prise de contact',
        ],
    ],

    'users' => [
        'singular' => 'Utilisateur',
        'plural' => 'Utilisateurs',
        'page' => [
            'title_create' => "Création d'un nouvel utilisateur",
            'title_edit' => "Edition de l'utilisateur :model",
            'title_list' => 'Utilisateurs',
        ],
        'table' => [
            'empty_state' => [
                'description' => '',
            ],
            'label' => [
                'name' => 'Nom',
                'email' => 'Email',
                'role' => 'Rôle',
                'is_active' => 'Actif',
                'force_renew_password' => 'Renouvellement',
                'force_renew_password_abbr' => 'Doit renouveler le mot de passe lors de la prochaine connexion',

            ],
            'filter' => [
                'roles' => [
                    'role' => 'Rôle',
                    'indicate' => 'Rôle : ',
                ],
            ],
        ],
        'form' => [
            'label' => [
                'yes_send_email_after_create' => 'Oui',
                'yes_send_email_after_change_status' => 'Oui',
                'is_active' => 'Actif',
                'avatar' => 'Photo de profil',
                'name' => 'Nom',
                'firstname' => 'Prénom',
                'email' => 'Email',
                'phone' => 'Téléphone',
                'password' => 'Mot de passe',
                'logo' => 'Logo',
                'name_funeral' => 'Nom entreprise',
                'role' => 'Rôle',
            ],
            'placeholder' => [
                'role' => 'Sélectionner un rôle',
                'roles' => 'Sélectionner un/des rôle(s)',
            ],
            'section' => [
                'role_title' => 'Affecter un rôle utilisateur',
                'role_description' => "Attention, le rôle affecté ouvre/ferme des accès à l'application",
                'parameter_title' => "Paramètres de l'utilisateur",
                'parameter_description' => "Gérer les paramètres spécifiques de l'utilisateur",
                'information_title' => 'Informations du compte utilisateur',
                'information_description' => "Renseignez les informations de l'utilisateur",
                'funeral_title' => "Informations sur l'entreprise",
                'funeral_description' => "Renseignez les informations de l'entreprise de Pompes Funèbres",
            ],
        ],
        'actions' => [
            'add' => [
                'modal' => [
                    'heading' => 'Souhaitez-vous envoyer un email à l\'utilisateur ?',
                    'description' => 'En cochant Oui, un email sera envoyé à cet utilisateur contenant ses identifiants d\'accès à la plateforme.<br>Il devra changer son mot de passe temporaire à sa première connexion',
                ],
                'label' => [
                    'button' => 'Ajouter un utilisateur',
                    'submit' => 'Créer l\'utilisateur',
                ],
                'notification' => [
                    'success' => 'Utilisateur :name créé avec succès',
                ],
            ],
            'edit' => [
                'label' => [
                    'button' => 'Modifier',
                    'submit' => 'Enregistrer',
                ],
                'notification' => [
                    'success' => 'Utilisateur :name modifié avec succès',
                ],
            ],
            'delete' => [
                'modal' => [
                    'heading' => 'Supprimer l\'utilisateur :name',
                    'description' => 'Êtes-vous sûr de vouloir faire cela ?',
                ],
                'label' => [
                    'button' => 'Supprimer',
                ],
                'notification' => [
                    'success' => 'Utilisateur :name supprimé avec succès',
                ],
            ],
            'approval' => [
                'modal' => [
                    'approve' => [
                        'heading' => 'Approuver l\'utilisateur ?',
                        'description' => 'En cochant Oui, un email sera envoyé à cet utilisateur pour l\'informer du changement de statut de son compte.',
                    ],
                    'deapprove' => [
                        'heading' => 'Désactiver l\'utilisateur ?',
                        'description' => 'En cochant Oui, un email sera envoyé à cet utilisateur pour l\'informer du changement de statut de son compte.',
                    ],
                ],
                'label' => [
                    'approve' => [
                        'button' => 'Approuver',
                        'submit' => 'Approuver l\'utilisateur',
                    ],
                    'deapprove' => [
                        'button' => 'Désapprouver',
                        'submit' => 'Désactiver l\'utilisateur',
                    ],
                ],
                'notification' => [
                    'approve' => [
                        'success' => 'Utilisateur approuvé',
                        'fail' => "Erreur lors de l'enregistrement",
                    ],
                    'deapprove' => [
                        'success' => 'Utilisateur désactivé',
                        'fail' => "Erreur lors de l'enregistrement",
                    ],
                ],
            ],
            'renew-password' => [
                'notification' => [
                    'activated' => [
                        'success' => 'Activation du renouvellement de mot de passe à la prochaine connexion',
                        'fail' => 'Erreur lors de l\'enregistrement',
                    ],
                    'deactivated' => [
                        'success' => 'Désactivation du renouvellement de mot de passe',
                        'fail' => 'Erreur lors de l\'enregistrement',
                    ],
                ],
            ],
            'invite-user' => [
                'modal-content' => "<p>Vous pouvez inviter un utilisateur à s'enregistrer sur l'application afin qu'il puisse l'utiliser en indiquant son adresse email et son nom.</p><p>Ce dernier recevra un email avec un lien pour créer son compte, ou il pourra donc remplir ses informations personnelles.</p><p>Vous devez également lui attribuer dès à présent, un rôle.</p>",
                'label' => [
                    'button' => 'Inviter un utilisateur',
                    'submit' => 'Envoyer l\'invitation',
                ],
                'notification' => [
                    'success' => 'Invitation envoyée à l\'adresse :email',
                ],
            ],
            'give-permission' => [
                'label' => [
                    'button' => 'Attribuer des permissions',
                ],
            ],
        ],
        'global_search' => [
            'email' => 'Email',
        ],
    ],

    'categories' => [
        'singular' => 'Catégorie',
        'plural' => 'Catégories',
        'navigation' => 'Catégories',
        'page' => [
            'title_create' => 'Ajout d\'une nouvelle catégorie',
            'title_edit' => 'Edition de la catégorie :name',
            'title_view' => 'Catégorie :name',
            'title_list' => 'Liste des catégories',
        ],
        'table' => [
            'empty_state' => [
                'heading' => 'Aucune catégorie',
                'description' => 'Créer une catégorie pour commencer.',
            ],
            'label' => [
                'name' => 'Nom',
                'slug' => 'Slug',
                'description' => 'Description',
                'is_visible' => 'Publiée',
            ],
            'filter' => [
                'is_visible' => 'Publiée ?',
            ],
            'action' => [
                'create' => [
                    'label' => 'Ajouter une nouvelle catégorie',
                    'submit' => 'Enregistrer',
                    'notification_success' => 'La catégorie a bien été enregistrée',
                ],

                'edit' => [
                    'label' => 'Modifier',
                    'submit' => 'Enregistrer',
                    'notification_success' => 'La catégorie a bien été modifiée',
                ],

                'delete' => [
                    'label' => 'Supprimer',
                    'modal' => [
                        'heading' => 'Supprimer la catégorie :name',
                        'description' => 'Êtes-vous sûr de vouloir faire cela ?',
                        'notification_success' => 'La catégorie :name a bien été supprimée',
                    ],
                ],
            ],
        ],
        'form' => [
            'label' => [
                'name' => 'Nom',
                'slug' => 'Slug',
                'description' => 'Description',
                'is_visible' => 'Publiée',
            ],
            'section' => [
                'category' => [
                    'title' => 'Catégorie',
                    'description' => 'Renseigner les informations',
                ],

            ],
        ],
    ],

    'posts' => [
        'singular' => 'Actualité',
        'plural' => 'Actualités',
        'navigation' => 'Actualités',
        'page' => [
            'title_create' => 'Ajout d\'une nouvelle actualité',
            'title_edit' => 'Edition de l\'actualité :title',
            'title_view' => 'Actualité :title',
            'title_list' => 'Liste des actualités',
        ],
        'table' => [
            'empty_state' => [
                'heading' => 'Aucune actualité',
                'description' => 'Créer une actualité pour commencer.',
            ],
            'label' => [
                'featured_image' => 'Image',
                'title' => 'Titre',
                'slug' => 'Slug',
                'excerpt' => 'Résumé',
                'content' => 'Contenu',
                'published_at' => 'Date de Publication',
                'author' => 'Auteur',
                'category' => 'Catégorie',
            ],
            'action' => [
                'create' => [
                    'label' => 'Ajouter une nouvelle actualité',
                    'submit' => 'Enregistrer',
                    'notification_success' => 'L\'actualité a bien été enregistrée',
                ],
                'edit' => [
                    'label' => 'Modifier',
                    'submit' => 'Enregistrer',
                    'notification_success' => 'L\'actualité a bien été modifiée',
                ],
                'delete' => [
                    'label' => 'Supprimer',
                    'modal' => [
                        'heading' => 'Supprimer l\'actualité :title',
                        'description' => 'Êtes-vous sûr de vouloir faire cela ?',
                        'notification_success' => 'L\'actualité :title a bien été supprimée',
                    ],
                ],
            ],
        ],
        'form' => [
            'label' => [
                'featured_image' => 'Image à la une',
                'title' => 'Titre',
                'slug' => 'Slug',
                'excerpt' => 'Résumé',
                'content' => 'Contenu',
                'published_at' => 'Date de Publication',
                'author' => 'Auteur',
                'category' => 'Catégorie',
            ],
            'section' => [
                'post' => [
                    'title' => 'Actualité',
                    'description' => 'Renseigner les informations',
                ],

            ],
        ],
        'global_search' => [
            'category' => 'Catégorie',
        ],
    ],

    'events' => [
        'singular' => 'Evènement',
        'plural' => 'Evènements',
        'navigation' => 'Evènements',
        'page' => [
            'title_create' => 'Ajout d\'un nouvel évènement',
            'title_edit' => 'Edition de l\'évènement :title',
            'title_view' => 'Evènement :title',
            'title_list' => 'Liste des évènements',
        ],
        'table' => [
            'empty_state' => [
                'heading' => 'Aucun évènement',
                'description' => 'Créer un évènement pour commencer.',
            ],
            'label' => [
                'featured_image' => 'Image',
                'title' => 'Titre',
                'slug' => 'Slug',
                'excerpt' => 'Résumé',
                'content' => 'Contenu',
                'date_start' => 'Date de début',
                'date_end' => 'Date de fin',
                'location' => 'Lieu',
                'price' => 'Prix',
                'published_at' => 'Date de publication',
            ],
            'action' => [
                'create' => [
                    'label' => 'Ajouter un nouvel évènement',
                    'submit' => 'Enregistrer',
                    'notification_success' => 'L\'évènement a bien été enregistré',
                ],
                'edit' => [
                    'label' => 'Modifier',
                    'submit' => 'Enregistrer',
                    'notification_success' => 'L\'évènement a bien été modifié',
                ],
                'delete' => [
                    'label' => 'Supprimer',
                    'modal' => [
                        'heading' => 'Supprimer l\'évènement :title',
                        'description' => 'Êtes-vous sûr de vouloir faire cela ?',
                        'notification_success' => 'L\'évènement :title a bien été supprimé',
                    ],
                ],
            ],
        ],
        'form' => [
            'label' => [
                'featured_image' => 'Image à la une',
                'title' => 'Titre',
                'slug' => 'Slug',
                'excerpt' => 'Résumé',
                'content' => 'Contenu',
                'date_start' => 'Date début',
                'date_end' => 'Date fin',
                'location' => 'Lieu',
                'price' => 'Prix',
                'published_at' => 'Date de publication',
                'fieldset' => [
                    'external_link' => [
                        'label' => 'Lien externe',
                        'link_is_visible' => 'Visible',
                        'link_url' => 'Adresse du lien (URL)',
                        'link_label' => 'Intitulé du lien',
                    ],
                ],
            ],
            'helper' => [
                'erase_date_end' => 'Effacer la date de fin',
                'external_link' => 'Coller ici le lien Weezevent par exemple',
            ],
            'section' => [
                'event' => [
                    'title' => 'Evènement',
                    'description' => 'Renseigner les informations',
                ],

            ],
        ],
        'global_search' => [
            'date' => 'Date',
        ],
    ],

    'members' => [
        'singular' => 'Membre',
        'plural' => 'Membres',
        'navigation' => 'Membres',
        'page' => [
            'title_create' => 'Ajout d\'un nouveau membre',
            'title_edit' => 'Edition du membre :name',
            'title_view' => 'Membre :name',
            'title_list' => 'Liste des membres',
        ],
        'table' => [
            'empty_state' => [
                'heading' => 'Aucun membre',
                'description' => 'Créer un membre pour commencer.',
            ],
            'label' => [
                'avatar' => 'Image',
                'firstname' => 'Prénom',
                'fullname' => 'Responsable',
                'name' => 'Nom',
                'job' => 'Fonction/Poste',
                'phone' => 'Téléphone',
                'email' => 'Email',
                'company' => 'Entreprise',
                'company_name' => 'Nom entreprise',
                'company_logo' => 'Logo',
                'company_activity' => 'Activité',
                'company_description' => 'Description',
                'address' => 'Adresse',
                'company_street' => 'Rue',
                'company_ext_street' => 'Complément',
                'company_postal_code' => 'Code postal',
                'company_city' => 'Ville',
                'company_website' => 'Site internet',
                'socials' => 'Réseaux sociaux',
                'plan_payment_received_at' => 'Paiement reçu',
                'plan_starts_at' => 'Commence le',
                'plan_ends_at' => 'Se termine le',
                'plan_canceled_at' => 'Annulée le',
                'has_plan' => 'Adhésion active',
                'is_active' => 'Cotisation à jour',
                'is_published' => 'Visible sur le site',
            ],
            'tooltip' => [
                'plan_starts_at' => 'L\'adhésion commence ou a commencé le',
                'plan_ends_at' => 'L\'adhésion se termine ou s\'est terminée le',
                'plan_canceled_at' => 'L\'adhésion est annulée depuis le',
            ],
            'filter' => [
                'is_draft' => 'En attente d\'approbation',
                'has_no_payment' => 'En attente de paiement',
            ],
            'widget' => [
                'total_count' => 'Nombre de Membres',
                'draft' => 'En attente d\'approbation',
                'has_no_payment' => 'En attente de paiement',
            ],
            'action' => [
                'create' => [
                    'label' => 'Ajouter un nouveau membre',
                    'submit' => 'Enregistrer',
                    'notification_success' => 'Le membre a bien été créé',
                ],
                'edit' => [
                    'label' => 'Modifier',
                    'submit' => 'Enregistrer',
                    'notification_success' => 'Le membre a bien été modifié',
                ],
                'view' => [
                    'label' => 'Consulter',
                ],
                'delete' => [
                    'label' => 'Supprimer',
                    'modal' => [
                        'heading' => 'Supprimer le membre :name',
                        'description' => 'Êtes-vous sûr de vouloir faire cela ?',
                        'notification_success' => 'Le membre :name a bien été supprimé',
                    ],
                ],
            ],
            'legend' => [
                'heading' => 'Pour informations',
                'description' => 'Certaines lignes du tableau peuvent avoir une marque spécifique :',
                'should_approved' => 'Ce membre doit être approuvé, il a rempli sa fiche directement et les informations doivent être controlées avant qu\'elles ne soient publiées sur le site.',
                'should_paid' => 'Pour que son adhésion soit complètement effective, il est nécessaire de renseigner la date de réglement.',
            ],
        ],
        'form' => [
            'tabs' => [
                'member' => 'Membre',
                'member_description' => 'Informations du représentant de l\'entreprise/société',
                'company' => 'Entreprise/Société',
                'company_description' => 'Informations sur l\'entreprise/société',
                'socials' => 'Réseaux sociaux',
                'socials_description' => 'Vos réseaux sociaux',
                'member_type' => 'Type du membre',
                'member_type_description' => '-',
                'socials_description_approve' => 'Leurs réseaux sociaux',
                'plans' => 'Votre cotisation',
                'plans_back' => 'Adhésion',
                'plans_description' => 'Choix du type de cotisation',
                'plans_description_approve' => 'Adhésion choisie',
            ],
            'label' => [
                'avatar' => 'Photo',
                'firstname' => 'Prénom',
                'name' => 'Nom',
                'job' => 'Fonction/Poste',
                'phone' => 'Téléphone',
                'email' => 'Email',
                'member_type' => 'Type du membre',
                'office_role' => 'Role au sein du bureau de l\'association',
                'company_name' => 'Nom',
                'company_logo' => 'Logo',
                'company_activity' => 'Activité',
                'company_description' => 'Description',
                'address' => 'Adresse',
                'company_street' => 'Rue',
                'company_ext_street' => 'Complément',
                'company_postal_code' => 'Code postal',
                'company_city' => 'Ville',
                'company_website' => 'Site internet',
                'plan_type' => 'Type d\'adhésion',
                'plan_type_label' => ':name (:price :currency pour :period :interval)',
                'plan_type_label_discounted' => ':name (<span class="line-through">:price :currency pour :period :interval</span>)<br>Réduction de <span class="text-success-600">:discount_rate</span> soit :new_price :currency pour :period :interval',
                'plan_outdated' => 'Attention<br>Entre le moment de la demande à rejoindre l\'association et le traitement de celle-ci, la période d\'adhésion est dépassée (elle allait du :startDateOutdated au :endDateOutdated).<br>En poursuivant ci-dessous, la période d\'adhésion sera rétablie sur celle en cours, soit du :startDate au :endDate.<br><br><strong>Pour rappel, la souscription demandée était</strong><br>:planOutdated',
                'is_active' => 'Cotisation à jour',
                'is_published' => 'Visible sur le site',
                'send_notification' => 'Envoyer un email notifiant ce membre de la création de sa fiche sur le site ?',
                'user' => 'Utilisateur',
                'repeater' => [
                    'name' => 'Réseau social',
                    'account' => 'Compte',
                    'account_helper' => 'Coller ici l\'adresse URL de votre compte',
                    'add' => 'Ajouter un réseau social',
                ],
            ],
            'placeholder' => [
                'info_discount' => 'Permet de définir un taux de réduction sur la cotisation.',
            ],
            'section' => [
                'member' => [
                    'title' => 'Membre',
                    'description' => 'Renseigner les informations',
                ],
                'company' => [
                    'title' => 'Entreprise',
                    'description' => 'Renseigner les informations',
                ],
                'socials' => [
                    'title' => 'Réseaux sociaux',
                    'description' => 'Renseigner les informations',
                ],

            ],
        ],
        'infolist' => [
            'label' => [
                'avatar' => 'Image',
                'firstname' => 'Prénom',
                'name' => 'Nom',
                'job' => 'Fonction/Poste',
                'phone' => 'Téléphone',
                'email' => 'Email',
                'company_name' => 'Nom',
                'company_logo' => 'Logo',
                'company_activity' => 'Activité',
                'company_description' => 'Description',
                'address' => 'Adresse',
                'company_street' => 'Rue',
                'company_ext_street' => 'Complément',
                'company_postal_code' => 'Code postal',
                'company_city' => 'Ville',
                'company_website' => 'Site internet',
                'is_active' => 'Cotisation à jour',
                'is_published' => 'Visible sur le site',
                'account_created' => 'Compte utilisateur',
                'user' => 'Utilisateur',
                'repeater' => [
                    'name' => 'Réseau social',
                    'account' => 'Compte',
                    'account_helper' => 'Coller ici l\'adresse URL de votre compte',
                    'add' => 'Ajouter un réseau social',
                ],
                'plan_type' => 'Type de cotisation',
                'plan_price' => 'Montant',
                'plan_price_suffix' => ' (paiement reçu le :date)',
                'plan_price_suffix_wait' => ' (paiement en attente)',
                'plan_period' => 'Période',
                'is_active' => 'Cotisation à jour',
            ],
            'placeholder' => [
                'job' => 'Non défini',
                'company_website' => 'Non défini',
                'socials' => 'Aucun réseau social défini',
            ],
            'section' => [
                'member' => [
                    'title' => 'Responsable',
                    'description' => '',
                ],
                'company' => [
                    'title' => 'Informations',
                    'description' => '',
                ],
                'socials' => [
                    'title' => 'Réseaux sociaux',
                    'description' => '',
                ],
                'current_subscription' => [
                    'title_owner' => 'Informations sur mon adhésion actuelle',
                    'title' => 'Informations sur son adhésion actuelle',
                    'description_owner' => '',
                    'description' => '',
                ],
                'past_subscriptions' => [
                    'title' => 'Adhésions précédentes',
                    'description' => '',
                ],
            ],
        ],
        'global_search' => [
            'member' => 'Responsable',
        ],
    ],

    'plans' => [
        'singular' => 'Plan',
        'plural' => 'Plans',
        'navigation_label' => 'Plans',
        'page' => [
            'title_create' => 'Ajout d\'un nouveau plan',
            'title_edit' => 'Edition du plan :name',
            'title_list' => 'Liste des plans',
            'title_view' => 'Plan : :model',
        ],
        'table' => [
            'empty_state' => [
                'heading' => 'Aucun plan',
                'description' => 'Créer un plan pour commencer.',
            ],
            'label' => [
                'name' => 'Nom',
                'price' => 'Prix',
                'is_active' => 'Est actif?',
            ],
            'action' => [
                'create' => [
                    'label' => 'Ajouter un nouveau plan',
                    'submit' => 'Enregistrer',
                    'notification_success' => 'Le plan a bien été enregistré',
                ],
                'edit' => [
                    'label' => 'Modifier',
                    'submit' => 'Enregistrer',
                    'notification_success' => 'Le plan a bien été modifié',
                ],
                'delete' => [
                    'label' => 'Supprimer',
                    'modal' => [
                        'heading' => 'Supprimer le plan :name',
                        'description' => 'Êtes-vous sûr de vouloir faire cela ?',
                        'notification_success' => 'Le plan :name a bien été supprimé',
                    ],
                ],
            ],
        ],
        'form' => [
            'label' => [
                'name' => 'Nom',
                'description' => 'Description',
                'price' => 'Prix',
                'signup_fee' => "Frais d'inscription",
                'invoice_interval' => 'Intervalle de facturation',
                'invoice_period' => 'Période de facturation',
                'trial_interval' => "Intervalle d'essai",
                'trial_period' => "Période d'essai",
                'currency' => 'Devise',
                'is_active' => 'Est actif?',
                'day' => 'Jour',
                'month' => 'Mois',
                'year' => 'Année',
            ],
            'section' => [
                'title' => 'Plan',
                'description' => 'Informations concernant le plan',
            ],
        ],
        'notification' => [
            'deleted' => 'Plan <span class="font-bold italic">:model</span> supprimé avec succès',
        ],
        'action' => [
            'modal' => [
                'delete_title' => 'Supprimer le plan :model',
            ],
        ],
    ],

    'subscriptions' => [
        'singular' => 'Abonnement',
        'plural' => 'Abonnements',
        'navigation_label' => 'Abonnements',
        'page' => [
            'title_create' => 'Ajout d\'un nouvel abonnement',
            'title_edit' => 'Edition de l\'abonnement :name',
            'title_list' => 'Liste des abonnements',
            'title_view' => 'Abonnement : :model',
        ],
        'table' => [
            'empty_state' => [
                'heading' => 'Aucun abonnement',
                'description' => 'Créer un abonnement pour commencer.',
            ],
            'label' => [
                'active' => 'Actif',
                'subscriber' => 'Abonné',
                'plan' => 'Plan',
                'trial_ends_at' => "Fin de l'essai",
                'starts_at' => 'Commence le',
                'ends_at' => 'Se termine le',
                'canceled_at' => 'Annulé le',
            ],
            'filters' => [
                'date_range' => 'Plage de dates',
                'start_date' => 'Date de début',
                'end_date' => 'Date de fin',
                'canceled' => 'Annulé',
                'all' => 'Tous',
                'yes' => 'Oui',
                'no' => 'Non',
            ],
            'action' => [
                'create' => [
                    'label' => 'Ajouter un nouvel abonnement',
                    'submit' => 'Enregistrer',
                    'notification_success' => 'L\'abonnement a bien été enregistré',
                    'notification_warning' => 'L\'abonné n\'a pas été trouvé',
                ],
                'edit' => [
                    'label' => 'Modifier',
                    'submit' => 'Enregistrer',
                    'notification_success' => 'L\'abonnement a bien été modifié',
                    'notification_warning' => 'L\'abonné n\'a pas été trouvé',
                ],
                'delete' => [
                    'label' => 'Supprimer',
                    'modal' => [
                        'heading' => 'Supprimer l\'abonnement :name',
                        'description' => 'Êtes-vous sûr de vouloir faire cela ?',
                        'notification_success' => 'L\'abonnement :name a bien été supprimé',
                    ],
                ],
                'force_delete' => [
                    'label' => 'Supprimer définitivement',
                ],
                'restore' => [
                    'label' => 'Restaurer',
                ],
                'cancel' => [
                    'label' => 'Annuler',
                    'notification_success' => 'Votre(vos) abonnement(s) ont été annulés avec succès',
                ],
                'renew' => [
                    'label' => 'Renouveler',
                    'notification_success' => 'Abonnement renouvelé avec succès',
                ],
            ],
        ],
        'form' => [
            'label' => [
                'subscriber_type' => "Type d'abonné",
                'subscriber' => 'Abonné',
                'members' => 'Membres',
                //
                'plan' => 'Plan',
                'use_custom_dates' => 'Utiliser des dates personnalisées',
                //
                'trial_ends_at' => "Fin de l'essai",
                'starts_at' => 'Commence le',
                'ends_at' => 'Se termine le',
                'canceled_at' => 'Annulé le',
            ],
            'section' => [
                'subscriber' => [
                    'title' => 'Abonné',
                    'description' => 'Paramètres de l\'abonné',
                ],
                'plan' => [
                    'title' => 'Plan',
                    'description' => 'Paramètres du plan',
                ],
                'custom_dates' => [
                    'title' => 'Utiliser des dates personnalisées',
                    'description' => 'Paramètres des dates personnalisées',
                ],

            ],
        ],
        'notification' => [
            'deleted' => 'Abonnement <span class="font-bold italic">:model</span> supprimé avec succès',
        ],
        'action' => [
            'modal' => [
                'delete_title' => 'Supprimer l\'abonnement :model',
            ],
        ],
    ],

    'actions' => [
        'resend' => [
            'modal' => [
                'heading' => 'Renvoyer l\'email',
                'description' => 'Etes-vous sûr de vouloir renvoyer cet email ?',
            ],
            'label' => [
                'resend' => 'Renvoyer l\'email',
            ],
            'notification' => [
                'success' => 'L\'email a été renvoyé avec succès',
                'failed' => 'Impossible d\'envoyer l\'email, une erreur interne est survenue',
            ],
        ],
        'send_document' => [
            'modal' => [
                'heading' => 'Répondre à cette demande de contact',
                'description' => 'Vous pouvez répondre à cette demande et même inviter cette personne à créer sa fiche de membre',
            ],
            'label' => [
                'subject' => 'Objet du mail',
                'content' => 'Contenu',
                'send_link' => 'Ajouter un bouton (dans le contenu du mail) invitant :name à créer sa fiche de membre sur le formulaire prévu à cet effet ?',
                'fieldset_discount' => 'Appliquer une réduction sur la cotisation ?',
                'info_discount' => 'Permet de définir un taux de réduction sur la cotisation. Cette réduction sera visible lorsque l\'utilisateur complétera le formulaire de création de sa fiche de membre.',
                'has_discount' => 'Activer une réduction',
                'discount_rate' => 'Taux de réduction',
                'button' => 'Répondre',
                'submit' => 'Envoyer',
            ],
            'validation' => [
                'discount_rate' => 'Le champ :attribute est obligatoire quand le champ :other est coché.',
            ],
            'notification' => [
                'success' => 'Réponse envoyée avec succès',
                'failed' => 'Problème lors de l\'envoi de la réponse',
            ],
        ],
        'resend_invitation' => [
            'modal' => [
                'heading' => 'Renvoyer l\'email d\'invitation',
                'description' => 'Êtes-vous sûr de vouloir faire cela ?',
            ],
            'label' => [
                'button' => 'Renvoyer l\'email d\'invitation',
                'submit' => 'Confirmer',
            ],
            'notification' => [
                'success' => 'L\'invitation a bien été renvoyée',
                'failed' => 'Problème lors de l\'envoi du mail',
            ],
        ],
        'approve' => [
            'modal' => [
                'heading' => 'Approuver les informations saisies pour :member',
                'description' => 'Vérifier les informations saisies afin de poursuivre le processus d\'inscription du membre',
            ],
            'label' => [
                'button' => 'Approuver',
                'submit' => 'Approuver',
            ],
            'notification' => [
                'success' => 'La création du membre a été finalisée avec succès',
                'failed' => 'Problème lors de la création du membre',
            ],
        ],
        'deapprove' => [
            'modal' => [
                'heading' => 'Désapprouver cette demande',
                'description' => 'Êtes-vous sûr de vouloir faire cela ?',
            ],
            'label' => [
                'button' => 'Désapprouver',
                'submit' => 'Oui, supprimer cette demande',
            ],
            'notification' => [
                'success' => 'Cette demande a été supprimée avec succès',
                'failed' => 'Problème lors de la suppression de cette demande',
            ],
        ],
        'declare_payment_received' => [
            'modal' => [
                'heading' => 'Déclarer la réception du paiement de la cotisation',
                'description' => 'Enregistrer la date et le moyen de paiement de la cotisation en cours',
            ],
            'form' => [
                'payment_received_at' => 'Date',
                'payment_mode' => 'Mode de paiement',
            ],
            'label' => [
                'button' => 'Enregistrer le paiement',
                'submit' => 'Déclarer la réception du paiement',
            ],
            'notification' => [
                'success' => 'Le paiement est bien enregistré',
                'failed' => 'Problème lors de l\'enregistrement du paiement',
            ],
        ],
        'subscribe' => [
            'modal' => [
                'heading' => 'Souscrire une adhésion pour :member',
                'description' => 'Sélectionner le type d\'adhésion pour ce membre',
            ],
            'form' => [
                'plan' => 'Adhésion',
            ],
            'placeholder' => [
                'info_discount' => 'Permet de définir un taux de réduction sur la cotisation.',
            ],
            'label' => [
                'button' => 'Souscrire une adhésion',
                'submit' => 'Souscrire',
            ],
            'notification' => [
                'success' => 'La souscription de l\'adhésion :plan pour :member a été réalisée avec succès',
                'failed' => 'Problème lors de la souscription de l\'adhésion',
            ],
        ],
        'change_plan' => [
            'modal' => [
                'heading' => 'Changer l\'adhésion de :member',
                'description' => 'Si nécessaire, vous pouvez changer l\'adhésion en cours pour une autre',
            ],
            'form' => [
                'placeholder' => [
                    'no_plan' => 'Aucune adhésion',
                    'info_discount' => 'Permet de définir un taux de réduction sur la cotisation.',
                ],
                'section' => [
                    'current_plan' => [
                        'title' => 'Adhésion en cours',
                        'description' => 'Actuellement, :member est inscrit à cette adhésion',
                    ],
                    'available_plans' => [
                        'title' => 'Adhésions disponibles',
                        'description' => 'Vous pouvez inscrire :member à une adhésion ci-dessous',
                    ],
                ],
            ],
            'label' => [
                'button' => 'Changer l\'adhésion',
                'submit' => 'Confirmer le changement',
            ],
            'notification' => [
                'success' => 'Le changement de l\'adhésion pour :member a été réalisé avec succès',
                'failed' => 'Problème lors du changement de l\'adhésion',
            ],
        ],
        'renew' => [
            'modal' => [
                'heading' => 'Renouveler l\'adhésion :plan pour :member',
                'description' => 'Période en cours : :currentPeriod<br>Le renouvelement s\'effectura pour la période : :nextPeriod',
            ],
            'placeholder' => [
                'info_discount' => 'Permet de définir un taux de réduction sur la cotisation.',
            ],
            'label' => [
                'button' => 'Renouveler',
                'submit' => 'Renouveler',
            ],
            'notification' => [
                'success' => 'Le renouvelement de l\'adhésion :plan pour :member a été réalisée avec succès',
                'failed' => 'Problème lors du renouvelement de l\'adhésion',
            ],
        ],
        'renew_when_canceled-immediately' => [
            'modal' => [
                'heading' => 'Renouveler l\'adhésion :plan pour :member',
                'description' => 'Période en cours : :currentPeriod<br>Le renouvelement s\'effectura pour la période : :nextPeriod',
            ],
            'placeholder' => [
                'info_discount' => 'Permet de définir un taux de réduction sur la cotisation.',
            ],
            'label' => [
                'button' => 'Renouveler l\'adhésion arrêtée',
                'submit' => 'Renouveler',
            ],
            'notification' => [
                'success' => 'Le renouvelement de l\'adhésion :plan pour :member a été réalisé avec succès',
                'failed' => 'Problème lors du renouvelement de l\'adhésion',
            ],
        ],
        'renew_when_canceled' => [
            'modal' => [
                'heading' => 'Annuler l\'arrêt de l\'adhésion qui est prévu le :ends_at',
                'description' => 'Période en cours : :currentPeriod',
            ],
            'label' => [
                'button' => 'Annuler l\'arrêt de l\'adhésion',
                'submit' => 'Oui',
            ],
            'notification' => [
                'success' => 'L\'arrêt de l\'adhésion prévu le :ends_at est annulé',
                'failed' => 'Problème lors de l\enregistrement de l\'annulation de l\'arrêt de l\'adhésion',
            ],
        ],
        'cancel' => [
            'modal' => [
                'heading' => 'Arrêter l\'adhésion :plan pour :member',
                'description' => 'Êtes-vous sûr de vouloir faire cela ?',
            ],
            'form' => [
                'immediately' => 'Immédiatement ?',
                'immediately_helper' => 'L\'adhésion restera active jusqu\'à sa période de fin, sauf si vous cochez la case Immédiatement, dans ce cas, elle prendra fin immédiatement.',
            ],
            'label' => [
                'button' => 'Arrêter l\'adhésion',
                'submit' => 'Oui',
            ],
            'notification' => [
                'success' => 'L\'annulation de l\'adhésion :plan pour :member a été enregistrée avec succès',
                'failed' => 'Problème lors de l\'annulation de l\'adhésion',
            ],
        ],
        'create_user' => [
            'modal' => [
                'heading' => 'Création du compte utilisateur pour :member',
                'description' => 'Le membre pourra alors se connecter à l\'application pour gérer sa fiche personelle',
            ],
            'label' => [
                'button' => 'Créer le compte utilisateur',
                'submit' => 'Créer son accès',
            ],
            'notification' => [
                'success' => 'La création du compte utilisateur a été réalisée avec succès',
                'failed' => 'Problème lors de la création du compte utilisateur',
            ],
        ],
        'resend_credentials' => [
            'modal' => [
                'heading' => 'Renvoyer les identifiants du compte utilisateur de :member',
                'description' => 'Régénérer et renvoyer les identifiants de connexion pour que le membre puisse se connecter à son espace personnel.',
            ],
            'label' => [
                'button' => 'Renvoyer les identifiants de connexion',
                'submit' => 'Renvoyer',
            ],
            'notification' => [
                'success' => 'Les identifiants ont bien été renvoyés à :member',
                'failed' => 'Problème lors du renvoi des identifiants du compte utilisateur',
            ],
        ],
        'edit_socials' => [
            'modal' => [
                'heading' => 'Modifier mes réseaux sociaux',
                'description' => '',
            ],
            'label' => [
                'button' => 'Editer',
                'submit' => 'Enregistrer',
            ],
            'notification' => [
                'success' => 'La modification des réseaux sociaux a été réalisée avec succès',
                'failed' => 'Problème lors de la modification des réseaux sociaux',
            ],
        ],
        'edit_manager' => [
            'modal' => [
                'heading' => 'Modifier mes informations',
                'description' => '',
            ],
            'label' => [
                'button' => 'Editer',
                'submit' => 'Enregistrer',
            ],
            'notification' => [
                'success' => 'La modification des informations a été réalisée avec succès',
                'failed' => 'Problème lors de la modification des informations',
            ],
        ],
        'edit_company' => [
            'modal' => [
                'heading' => 'Modifier les informations de l\'entreprise',
                'description' => '',
            ],
            'label' => [
                'button' => 'Editer',
                'submit' => 'Enregistrer',
            ],
            'notification' => [
                'success' => 'La modification des informations de l\'entreprise a été réalisée avec succès',
                'failed' => 'Problème lors de la modification des informations de l\'entreprise',
            ],
        ],
    ],
];
