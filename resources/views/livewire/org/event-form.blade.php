<div class="p-6 bg-white rounded-lg shadow-md">
    <form wire:submit="update">
        {{ $this->form }}
        
        <button type="submit" class="mt-6 btn btn-primary">
            Submit
        </button>
    </form>
    
    <x-filament-actions::modals />
</div>