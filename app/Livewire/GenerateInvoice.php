<?php

namespace App\Livewire;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Blade;
use Livewire\Component;

class GenerateInvoice extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public Invoice $invoice;

    public function generateAction(): Action
    {
        return Action::make('generate')
            ->label('Facture')
            ->action(function () {
                $filename = 'facture_'.$this->invoice->subscription->subscriber->name.'_'.$this->invoice->starts_at->format('d_m_Y').'.pdf';

                return response()->streamDownload(function () {
                    echo Pdf::loadHtml(
                        Blade::render(
                            'layouts.pdf.invoice',
                            [
                                'invoice' => $this->invoice,
                                'planDescription' => filled($this->invoice->subscription->plan->description) ? RichContentRenderer::make($this->invoice->subscription->plan->description) : '',
                            ]
                        )
                    )->stream();
                }, $filename);
            });
    }

    public function render()
    {
        return view('livewire.generate-invoice');
    }
}
