<?php

namespace App\Livewire;

use App\Enums\StatusContact;
use App\Filament\Resources\Members\Schemas\Components\MemberFields;
use App\Models\Contact;
use App\Models\ContactInvitation;
use App\Models\Member;
use App\Services\RichEditorService;
use Arr;
use Carbon\Carbon;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\View as ViewComponent;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Laravelcm\Subscriptions\Models\Plan;
use Livewire\Component;

class CreateFrontMember extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions, InteractsWithSchemas;

    public bool $sent = false;

    public ?array $data = [];

    public ContactInvitation $invitation;

    public function mount(ContactInvitation $invitation): void
    {
        $this->form->fill($this->transformData($invitation));
    }

    public function transformData(ContactInvitation $invitation): array
    {
        return [
            'firstname' => $invitation->contact->firstname,
            'name' => $invitation->contact->name,
            'phone' => $invitation->contact->phone,
            'email' => $invitation->contact->email,
            'company_name' => $invitation->contact->company,
            'company_activity' => $invitation->contact->activity,
            'company_street' => $invitation->contact->street,
            'company_ext_street' => $invitation->contact->street_ext,
            'company_postal_code' => $invitation->contact->postal_code,
            'company_city' => $invitation->contact->city,
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make(__('app.members.form.tabs.member'))
                        ->description(__('app.members.form.tabs.member_description'))
                        ->icon('phosphor-identification-badge')
                        ->schema([
                            ViewComponent::make('header-wizard'),
                            MemberFields::getAvatar(),
                            MemberFields::getFirstName(),
                            MemberFields::getName(),
                            MemberFields::getJob(),
                            MemberFields::getPhone(),
                            MemberFields::getEmail(),
                        ]),
                    Step::make(__('app.members.form.tabs.company'))
                        ->description(__('app.members.form.tabs.company_description'))
                        ->icon('phosphor-building-office')
                        ->schema([
                            MemberFields::getCompanyLogo(),
                            MemberFields::getCompanyName(),
                            MemberFields::getCompanyActivity(),
                            MemberFields::getCompanyDescription(),
                            MemberFields::getCompanyWebsite(),
                            MemberFields::getCompanyAddress(),
                        ]),
                    Step::make(__('app.members.form.tabs.socials'))
                        ->description(__('app.members.form.tabs.socials_description'))
                        ->icon('phosphor-share-network')
                        ->schema([
                            MemberFields::getSocials(),
                        ]),
                    Step::make(__('app.members.form.tabs.plans'))
                        ->description(__('app.members.form.tabs.plans_description'))
                        ->icon('phosphor-tag')
                        ->schema([
                            MemberFields::getPlans(hasDiscount: $this->invitation->contact->has_discount ?? false, discountRate: $this->invitation->contact->discount_rate ?? null, useLiveData: true),
                        ]),

                ])->submitAction(new HtmlString(Blade::render('<x-filament::button type="submit" size="sm">'.__('app.pages.front-register-member.submit').'</x-filament::button>'))),
            ])
            ->model(Member::class)
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $data = Arr::add($data, 'is_draft', true);

        $member = Member::create($data);

        $this->form->model($member)->saveRelationships();

        // Save plan chosen
        $plan = Plan::find($data['plan_id']);
        $subscription = $member->newPlanSubscription($plan->name, $plan, Carbon::now()->startOfYear());

        // check if a discount have to apply
        $hasDiscount = $this->invitation->contact->has_discount;
        if ($hasDiscount) {
            $subscription->update([
                'discount_rate' => $this->invitation->contact->discount_rate,
            ]);
        }

        // update contact
        $contact = Contact::where('id', $this->invitation->contact_id)->first();

        $contact->update([
            'status' => StatusContact::COMPLETED,
        ]);

        Notification::make()
            ->success()
            ->title(__('app.pages.front-register-member.notification_success'))
            ->seconds(5)
            ->send();

        // $this->form->fill();

        $this->sent = true;
        $this->invitation->delete();

    }

    public function renderIntroContent(): RichContentRenderer
    {
        return RichContentRenderer::make(getFormMemberPublicSettingsContent()['text'])
            ->textColors(app(RichEditorService::class)->getColors());
    }

    public function renderFormSubmittedContent(): RichContentRenderer
    {
        return RichContentRenderer::make(getFormMemberPublicSettingsContent()['thanks']['text'])
            ->textColors(app(RichEditorService::class)->getColors());
    }

    public function render(): View
    {
        return view('livewire.create-front-member');
    }
}
