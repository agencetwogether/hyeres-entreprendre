<?php

namespace App\Http\Controllers;

use App\Models\ContactInvitation;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class ContactInvitationController extends Controller
{
    public function __invoke(int $invitationId)
    {
        $invitation = ContactInvitation::whereKey($invitationId)->firstOrFail();

        return view('create-member-form')
            ->with([
                'invitation' => $invitation,
                'seo' => new SEOData(
                    title: getFormMemberPublicSettingsSeo()['title'],
                    description: getFormMemberPublicSettingsSeo()['description'],
                    author: getFormMemberPublicSettingsSeo()['author'],
                    robots: getFormMemberPublicSettingsSeo()['robots'],
                ),
            ]);

    }
}
