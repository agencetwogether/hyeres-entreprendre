<?php

return [
    'reset-password' => [
        'subject' => 'Notification de réinitialisation du mot de passe',
        'greeting' => 'Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.',
        'content' => 'Ce lien de réinitialisation du mot de passe expirera dans :count minutes.',
        'optionalEndText' => "Si vous n'avez pas demandé de réinitialisation de mot de passe, vous pouvez ignorer ce message.",
        'btnLabel' => 'Réinitialisation du mot de passe',
    ],

    'new-support' => [
        'subject' => 'Nouvelle demande de support',
        'greeting' => 'Bonjour :name,',
        'content' => ":askerName a besoin d'aide.<br><br><strong>Sujet de la demande : </strong>:subject<br><strong>Message : </strong>:message",
    ],

    'confirm-support' => [
        'subject' => "Votre demande d'assistance a bien été transmise",
        'greeting' => 'Bonjour :name,',
        'content' => "Merci pour votre message.<br>L'administrateur de l'application de la :nameClient vous répondra dans les plus brefs délais.<br><br>Pour rappel, voici votre demande :<br><br><strong>Sujet : </strong>:subject<br><strong>Message : </strong>:message",
    ],

    'member-invitation' => [
        'subject' => "Votre invitation à rejoindre l'application de l'association :organization",
        'greeting' => "Vous êtes invité à rejoindre l'outil de l'association :organization",
        'content' => 'Pour finaliser votre invitation, cliquer sur le bouton ci-dessous pour créer votre compte',
        'optional-end-text' => "<p>Votre identifiant est votre adresse email, soit <br><em><strong>:email</strong></em></p><p>Votre mot de passe temporaire est<br><em><strong>:password</strong></em></p><p>Par mesure de sécurité, nous vous invitons à changer ce mot de passe dès votre première connexion.</p><br><p>Si vous ne vous attendiez pas à recevoir une invitation à rejoindre l'application de la :organization, vous pouvez ignorer cet e-mail.</p>",
        'btnLabel' => 'Finaliser mon inscription',
    ],

    'licence-is-about-to-expire' => [
        'subject' => 'La licence de votre application :organization expire dans :day jours',
        'greeting' => 'Bonjour :name,',
        'content' => "<p>Je vous informe que la <strong>licence de votre application :organization se termine le :ends_at</strong></p><p>Il est important que votre licence soit à jour pour continuer à bénéficier des nouvelles mises à jour de l'application et faire appel à notre support si vous rencontrez un problème.</p><p>Le renouvellement de votre licence vous donnera accès à la plateforme, aux prochaines mises à jour incluant la correction de bugs et les nouvelles fonctionnalités pour continuer et optimiser votre utilisation de l'application pendant la durée de <em>:duration</em> supplémentaire.</p><p>Passé ce délai, vous ne pourrez plus accèder à l'application, ni bénéficier des prochaines mises à jour et du support.</p><br><br>:price<br><p>Rapprochez-vous au plus vite de l'administrateur de l'application pour effectuer votre renouvellement, en répondant directement à cet email.</p><p><small>Pour rappel, votre licence actuelle couvre la période du :starts_at au :ends_at</small></p>",
        'new-price' => "<p>Le tarif pour votre prochain renouvellement évolue.</p><p>Suite aux augmentations du prestaire d'hébergement de l'application, je suis contraint de faire évoluer votre tarif.<br>Ce dernier est fixé à :next_price€ pour :duration.</p>",
        'price' => '<p>Le tarif de renouvellement pour :duration est de :price€.</p>',
    ],

    'new-user' => [
        'subject' => "Création de votre compte utilisateur pour l'application de l\'association :organization",
        'greeting' => 'Bonjour :name,',
        'content' => "<p>Votre compte pour l'application de l\'association :organization a été créé par un administrateur.</p><p>Votre identifiant est votre adresse email, soit <br><em><strong>:email</strong></em></p><p>Votre mot de passe est<br><em><strong>:password</strong></em></p><p>Par mesure de sécurité, nous vous invitons à changer ce mot de passe dès votre première connexion.</p>",
        'btnLabel' => 'Je me connecte',
    ],

    'change-is-active-status-user' => [
        'activate' => [
            'subject' => 'Votre compte a été activé',
            'greeting' => 'Bonjour :name,',
            'content' => "<p>Votre compte pour l'application de l\'association :organization a été validé/activé</p>",
            'btnLabel' => 'Je me connecte',
        ],
        'deactivate' => [
            'subject' => 'Votre compte a été désactivé',
            'greeting' => 'Bonjour :name,',
            'content' => "<p>Votre compte pour l'application de l\'association :organization a été désactivé</p><p>Par conséquent, vous ne pouvez plus vous connecter à l'application</p><p>Pour toute question suite à cette action, nous sommes à votre disposition</p>",
        ],

    ],

    'front-contact' => [
        'subject' => 'Demande de contact par formulaire du site :organization',
        'greeting' => 'Bonjour, :asker a rempli le formulaire de contact du site',
        'content' => '<p>Ci-dessous, son message</p><p>:content</p><p><em><strong>Informations</strong></em></p><p>Nom : :fullname</p><p>Email : :email</p><p>Téléphone : :phone</p>',
        'optional-end-text' => '<p>Souhaite rejoindre l\'association : :interested</p>',
        'btnLabel' => 'Voir les détails',
    ],

    'response-to-contact' => [
        'btnLabel' => 'Soumettre ma candidature',
    ],

    'confirm-member-created' => [
        'subject' => 'Votre inscription est approuvée',
        'greeting' => 'Bonjour,',
        'content' => '<p>Le secrétariat de l\'association :organization a approuvé votre demande d\'inscription.</p><p>Pour finaliser votre inscription, merci de procéder au réglement de votre adhésion.</p><h3>Votre adhésion</h3><p>Formule : :plan</p><p>Période : :period</p><p>Montant : :amount</p><p> Vous trouverez ci-joint le RIB de l\'association si vous souhaitez régler par virement bancaire.</p>',
    ],

    'confirm-member-created-backend' => [
        'subject' => 'Votre fiche de membre est créée',
        'greeting' => 'Bonjour,',
        'content' => '<p>Le secrétariat de l\'association :organization a créé votre fiche de membre.</p><p>Pour finaliser votre inscription, merci de procéder au réglement de votre adhésion.</p><h3>Votre adhésion</h3><p>Formule : :plan</p><p>Période : :period</p><p>Montant : :amount</p><p> Vous trouverez ci-joint le RIB de l\'association si vous souhaitez régler par virement bancaire.</p>',
    ],

    'confirm-member-deleted' => [
        'subject' => 'Votre demande n\'a malheureusement pas pu être validée',
        'greeting' => 'Bonjour,',
        'content' => '<p>Nous vous remercions pour l\'interêt que vous avez porté à notre association.</p><p>Malheureusement, nous avons le regret de vous informer que nous ne pourrons y donner une suite favorable.</p>',
    ],

    'renew-subscription-canceled-immediately' => [
        'subject' => 'Votre adhésion est renouvelée',
        'greeting' => 'Bonjour,',
        'content' => '<p>Le secrétariat de l\'association :organization a renouvelé votre adhésion.</p><p>Pour finaliser ce renouvellement, merci de procéder au réglement de celle-ci.</p><h3>Votre adhésion</h3><p>Formule : :plan</p><p>Période : :period</p><p>Montant : :amount</p><p> Vous trouverez ci-joint le RIB de l\'association si vous souhaitez régler par virement bancaire.</p>',
    ],

    'renew-subscription' => [
        'subject' => 'Votre adhésion est renouvelée',
        'greeting' => 'Bonjour,',
        'content' => '<p>Le secrétariat de l\'association :organization a renouvelé votre adhésion.</p><p>Pour finaliser ce renouvellement, merci de procéder au réglement de celle-ci.</p><h3>Votre adhésion</h3><p>Formule : :plan</p><p>Période : :period</p><p>Montant : :amount</p><p> Vous trouverez ci-joint le RIB de l\'association si vous souhaitez régler par virement bancaire.</p>',
    ],

    'subscription-is-about-to-expire' => [
        'subject' => 'Votre adhésion à l\'association :organization expire dans :day jours',
        'greeting' => 'Bonjour :name,',
        'content' => "<p>Nous espérons que vous êtes pleinement satisfait de votre adhésion <strong>:plan</strong>.</p><p>Veuillez noter que votre adhésion annuelle se termine dans <strong>:delta jours</strong>.</p><p>Pour continuer à profiter de vos avantages au sein de notre association, nous vous invitons à vous rapprocher du secrétariat afin de la renouveler.</p><p>Si vous ne souhaitez pas renouveler votre adhésion, aucun problème, vous restez membre jusqu'à la fin de celle-ci.</p><p>Vous avez des questions ? Nous nous tenons à votre disposition. N'hésitez pas à nous contacter.</p>",
        'optional-end-text' => '<p><small>Pour rappel, votre adhésion actuelle couvre la période du <strong>:starts_at</strong> au <strong>:ends_at</strong></small></p>',
        'btnLabel' => 'Accèder à mon espace',
    ],

    'payment-received' => [
        'subject' => 'Votre reçu de paiement pour votre adhésion',
        'greeting' => 'Bonjour :firstname :name,',
        'content' => '<p>Le secrétariat de l\'association :organization a enregistré le réglement de votre adhésion.</p><p> Vous trouverez ci-joint votre reçu.</p>',
    ],

    'change-plan' => [
        'subject' => 'Votre adhésion évolue',
        'greeting' => 'Bonjour :firstname :name,',
        'content' => '<p>Le secrétariat de l\'association :organization a changé votre adhésion.</p><h3>Votre précédente adhésion</h3><p>Formule : :oldPlan</p><p>Période : :oldPeriod</p><p>Montant : :oldAmount</p><h3>Votre nouvelle adhésion</h3><p>Formule : :newPlan</p><p>Période : :newPeriod</p><p>Montant : :newAmount</p><p> Vous trouverez ci-joint le RIB de l\'association si vous souhaitez régler par virement bancaire.</p><p>Pour toute question suite à ce changement, nous sommes à votre disposition.</p>',
    ],

    'send-invoice' => [
        'subject' => 'Votre reçu de paiement pour votre adhésion',
        'greeting' => 'Bonjour :firstname :name,',
        'content' => '<p> Vous trouverez ci-joint votre reçu.</p>',
        'success' => 'Facture envoyée avec succès',
    ],
];
