<div>
    <x-filament-actions::group :actions="[
        $this->showTicketAction,
        $this->giveFeedbackAction,
        $this->reserveAction,
    ]" />
 
    <x-filament-actions::modals />
</div>
