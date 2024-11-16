<div>
    <form wire:submit="create">
        {{ $this->form }}

        <button type="submit" class="my-6 btn btn-primary">
            Submit
        </button>
    </form>

    <x-filament-actions::modals />
</div>
