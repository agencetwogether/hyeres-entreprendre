<?php

namespace App\Filament\Resources\Contacts\Actions;

use App\Enums\DiscountRate;
use App\Enums\StatusContact;
use App\Mails\SendDocument as SendDocumentMail;
use App\Models\ContactInvitation;
use Filament\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;

class SendDocument extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'sendDocument';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->successNotificationTitle(__('app.actions.send_document.notification.success'));

        $this->failureNotificationTitle(__('app.actions.send_document.notification.failed'));

        $this->label(__('app.actions.send_document.label.button'));

        $this->color('warning');

        $this->icon('phosphor-paper-plane-tilt');

        $this->fillForm(fn (Model $record): array => [
            'subject_email' => getMembership()['subject_for_email'],
            'content_email' => getMembership()['content_for_email'],
            'send_link' => $record->interested,
            'has_discount' => false,
        ]);

        $this->schema([
            TextInput::make('subject_email')
                ->label(__('app.actions.send_document.label.subject'))
                ->columnSpanFull(),
            RichEditor::make('content_email')
                ->label(__('app.actions.send_document.label.content'))
                ->customHeight()
                ->columnSpanFull(),
            Text::make(fn (Model $record): HtmlString => new HtmlString(__('notification.front-contact.optional-end-text', ['interested' => $record->interested ? __('Yes') : __('No')])))
                ->color('neutral'),
            Radio::make('send_link')
                ->label(fn (Model $record): string => __('app.actions.send_document.label.send_link', ['name' => $record->firstname.' '.$record->name]))
                ->boolean()
                ->live(),
            Fieldset::make(__('app.actions.send_document.label.fieldset_discount'))
                ->visible(fn (Get $get): ?bool => $get('send_link'))
                ->schema([
                    Text::make(__('app.actions.send_document.label.info_discount'))
                        ->color('neutral')
                        ->columnSpanFull(),
                    Radio::make('has_discount')
                        ->label(__('app.actions.send_document.label.has_discount'))
                        ->hiddenLabel()
                        ->boolean()
                        ->inline()
                        ->live(),
                    Select::make('discount_rate')
                        ->label(__('app.actions.send_document.label.discount_rate'))
                        ->native(false)
                        ->selectablePlaceholder(false)
                        ->options(DiscountRate::class)
                        ->requiredIfAccepted('has_discount')
                        ->validationMessages([
                            'required_if_accepted' => __('app.actions.send_document.validation.discount_rate'),
                        ])
                        ->visible(fn (Get $get): bool => $get('has_discount')),
                ]),
            /*
            PdfViewerField::make('pdf')
                ->hiddenLabel()
                ->fileUrl(Storage::url(getMembership()['document_for_email']))
                ->dehydrated(false),*/
        ]);

        $this->action(function (array $data, Model $record): void {

            $invitation = ContactInvitation::create([
                'contact_id' => $record->id,
                'email' => $record->email,
            ]);

            Mail::to($record->email, $record->firstname.' '.$record->name)
                ->send(new SendDocumentMail($data, $record, $invitation));

            $newData = [
                'response_sent' => true,
                'response_date' => now(),
                'response_subject' => $data['subject_email'],
                'response_content' => $data['content_email'],
                'has_discount' => array_key_exists('has_discount', $data) ? $data['has_discount'] : false,
                'discount_rate' => array_key_exists('discount_rate', $data) ? $data['discount_rate'] : null,
                'status' => $data['send_link'] ? StatusContact::WAITING : StatusContact::COMPLETED,
            ];

            if (! $data['send_link']) {
                $invitation->delete();
            }

            $result = $record->update($newData);

            if (! $result) {
                $this->failure();

                return;
            }
            $this->success();
        });

        $this->modalHeading(fn (Model $record): string => __('app.actions.send_document.modal.heading'));

        $this->modalDescription(__('app.actions.send_document.modal.description'));

        $this->modalSubmitActionLabel(__('app.actions.send_document.label.submit'));

        $this->modalSubmitAction(fn (Action $action): Action => $action->color('primary'));

        $this->slideOver();

        $this->modalAutofocus(false);

        $this->visible(fn (Model $record) => $record->status == StatusContact::CREATED);
    }
}
