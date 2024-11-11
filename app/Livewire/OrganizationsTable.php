<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Filament\Forms\Components;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Support\Facades\Hash;

class OrganizationsTable extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function myForm(): array
    {
        return [
            Components\FileUpload::make('avatar')
                ->avatar()
                ->required()
                ->image(),
            Components\TextInput::make('first_name')
                ->label('Organization Name')
                ->placeholder('Enter organization name')
                ->required(),
            Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->placeholder('Enter email')
                ->required(),
        ];
    }


    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->where('role', 'organization')
            )
            ->columns([
                Split::make([
                    ImageColumn::make('avatar')
                        ->circular()
                        ->grow(false),
                    TextColumn::make('name'),
                ])
            ])
            ->filters([])
            ->actions([
                EditAction::make()
                    ->form($this->myForm()),
            ])
            ->headerActions([
                CreateAction::make()
                    ->form([
                        Components\FileUpload::make('avatar')
                            ->avatar()
                            ->required()
                            ->image(),
                        Components\TextInput::make('first_name')
                            ->label('Organization Name')
                            ->placeholder('Enter organization name')
                            ->required(),
                        Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->placeholder('Enter email')
                            ->required(),
                        Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->confirmed()
                            ->placeholder('Enter password')
                            ->required(),
                        Components\TextInput::make('password_confirmation')
                            ->label('Confirm Password')
                            ->password()
                            ->placeholder('Confirm password')
                            ->required(),
                    ])
                    ->action(function ($data) {
                        User::create([
                            'avatar' => $data['avatar'],
                            'first_name' => $data['first_name'],
                            'last_name' => ' ',
                            'email' => $data['email'],
                            'password' => Hash::make($data['password']),
                            'role' => 'organization',
                        ]);

                        Notification::make()
                            ->title('Organization Created')
                            ->success()
                            ->body("{$data['first_name']} has been created.")
                            ->send();
                    })
            ])
            ->bulkActions([
                // ...
            ]);
    }



    public function render()
    {
        return view('livewire.organizations-table');
    }
}
