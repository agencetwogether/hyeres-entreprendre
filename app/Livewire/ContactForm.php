<?php

namespace App\Livewire;

use App\Mails\ContactForm as ContactFormEmail;
use App\Models\Contact;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Spatie\Honeypot\Http\Livewire\Concerns\HoneypotData;
use Spatie\Honeypot\Http\Livewire\Concerns\UsesSpamProtection;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class ContactForm extends Component implements HasSchemas
{
    use InteractsWithSchemas, UsesSpamProtection;

    public ?array $data = [];

    public HoneypotData $extraFields;

    public function mount(): void
    {
        $this->extraFields = new HoneypotData;
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns()
            ->components([
                TextInput::make('name')
                    ->label(__('app.pages.contact-page.label.name'))
                    ->placeholder(__('app.pages.contact-page.placeholder.name'))
                    ->required()
                    ->columnSpan(1),
                TextInput::make('firstname')
                    ->label(__('app.pages.contact-page.label.firstname'))
                    ->placeholder(__('app.pages.contact-page.placeholder.firstname'))
                    ->required()
                    ->columnSpan(1),
                TextInput::make('email')
                    ->label(__('app.pages.contact-page.label.email'))
                    ->placeholder(__('app.pages.contact-page.placeholder.email'))
                    ->email()
                    ->required()
                    ->columnSpan(1),
                PhoneInput::make('phone')
                    ->label(__('app.pages.contact-page.label.phone'))
                    ->placeholder(__('app.pages.contact-page.placeholder.phone'))
                    ->required()
                    ->columnSpan(1),
                Textarea::make('content')
                    ->label(__('app.pages.contact-page.label.message'))
                    ->placeholder(__('app.pages.contact-page.placeholder.message'))
                    ->extraInputAttributes(['class' => 'md:h-56'])
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('interested')
                    ->label(__('app.pages.contact-page.label.interested'))
                    ->onColor('success')
                    ->columnSpanFull(),
                Fieldset::make(__('app.pages.contact-page.label.company_information'))
                    ->hiddenJs(<<<'JS'
                        $get('interested') !== true
                    JS)
                    ->schema([
                        TextInput::make('company')
                            ->label(__('app.pages.contact-page.label.company'))
                            ->placeholder(__('app.pages.contact-page.placeholder.company'))
                            ->requiredIf('interested', true),
                        TextInput::make('activity')
                            ->label(__('app.pages.contact-page.label.activity'))
                            ->placeholder(__('app.pages.contact-page.placeholder.activity'))
                            ->requiredIf('interested', true),
                        Fieldset::make(__('app.pages.contact-page.label.address'))
                            ->schema([
                                TextInput::make('street')
                                    ->label(__('app.pages.contact-page.label.street'))
                                    ->placeholder(__('app.pages.contact-page.placeholder.street'))
                                    ->requiredIf('interested', true),
                                TextInput::make('street_ext')
                                    ->label(__('app.pages.contact-page.label.street_ext')),
                                TextInput::make('postal_code')
                                    ->label(__('app.pages.contact-page.label.postal_code'))
                                    ->placeholder(__('app.pages.contact-page.placeholder.postal_code'))
                                    ->rules('postal_code:FR')
                                    ->requiredIf('interested', true),
                                TextInput::make('city')
                                    ->label(__('app.pages.contact-page.label.city'))
                                    ->placeholder(__('app.pages.contact-page.placeholder.city'))
                                    ->requiredIf('interested', true),
                            ]),
                    ]),
                Toggle::make('rgpd')
                    ->label(__('app.pages.contact-page.label.rgpd'))
                    ->onColor('success')
                    ->accepted()
                    ->columnSpanFull(),
                Text::make(new HtmlString('<div class="form-policy richeditor-custom">'.getContactSettingsContent()['form']['text_legal'].'</div>'))
                    ->columnSpanFull()
                    ->visible(getContactSettingsContent()['form']['text_legal'] != null),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $this->protectAgainstSpam();

        $state = $this->form->getState();

        Contact::create($state);

        $this->form->fill();

        Mail::to(getClientEmail(), getClientName())
            ->send(new ContactFormEmail($state));

        session()->flash('successContactForm', __('app.general.success_contact_form'));
    }

    public function render(): View
    {
        return view('livewire.contact-form');
    }
}
