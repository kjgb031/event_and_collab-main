<div>
    <x-filament-actions::group :actions="[
        $this->showTicketAction,
        $this->giveFeedbackAction,
        $this->reserveAction,
        $this->uploadProofOfAttendance,
    ]" />
 
    <x-filament-actions::modals />
</div>
