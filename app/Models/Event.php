<?php

namespace App\Models;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Notifications\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'date',
        'event_type',
        'start_time',
        'end_time',
        'location',
        'status',
        'cover_image',
        'thumbnail',
        'user_id',
        'event_mode',
        'capacity',
        'is_paid',
    ];

    protected $casts = [
        'date' => 'datetime',
        'is_paid' => 'boolean',
    ];

    public function isFull()
    {
        return $this->eventRegistrations->where('status', '!=', EventRegistration::STATUSES['rejected'])->count() >= $this->capacity;
    }

    public function userCanFeedback()
    {
        // ensure the event has ended
        if ($this->date->isFuture()) {
            return false;
        }

        // ensure the user has attended the event
        if (!$this->eventRegistrations->where('user_id', auth()->id())->where('status', EventRegistration::STATUSES['attended'])->count()) {
            return false;
        }

        // ensure the user has not given feedback
        if ($this->feedbacks->where('user_id', auth()->id())->count()) {
            return false;
        }

        // ensure proof of attendance has been submitted
        if (!$this->eventRegistrations->where('user_id', auth()->id())->where('status', EventRegistration::STATUSES['attended'])->first()->proof_of_attendance) {
            return false;
        }

        return true;
    }


    public function approve()
    {
        Notification::make()
            ->title('Event Approved')
            ->success()
            ->body("{$this->name} has been approved.")
            ->sendToDatabase($this->user)
            ->send();
        Notification::make()
            ->title('New Event!')
            ->success()
            ->body("{$this->name} a new event has popped up.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(route('student.event.show', $this->id), shouldOpenInNewTab: true),
                Action::make('undo')
                    ->color('gray'),
            ])
            ->sendToDatabase(User::where('role', 'student')->get())
            ->send();

        $this->update([
            'status' => 'approved',
        ]);
    }


    public function reject()
    {
        Notification::make()
            ->title('Event Rejected')
            ->danger()
            ->body("{$this->name} has been rejected.")
            ->sendToDatabase($this->user)
            ->send();

        $this->update([
            'status' => 'rejected',
        ]);
    }


    public function getEventButtonLabel()
    {
        return $this->is_paid ? 'Reserve' : 'Register';
    }

    public static function propose($data)
    {
        // make a data with pending status
        $data['status'] = 'pending';
        $data['user_id'] = auth()->id();
        // save the data
        $event = Event::create($data);
        // send notification to admin
        Notification::make()
            ->title('Event Proposed')
            ->info()
            ->body("{$event->name} has been proposed.")
            ->sendToDatabase(User::where('role', 'admin')->get())
            ->send();
    }

    public static function getForm(): array
    {
        return [
            Section::make([
                FileUpload::make('cover_image')
                    ->helperText('Image should be 16:9')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                    ])
                    ->required(),
                FileUpload::make('thumbnail')
                    ->helperText('Image should be 1:1')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '1:1',
                    ])
                    ->required(),
                TextInput::make('name')
                    ->required(),
                RichEditor::make('description')
                    ->columnSpanFull()
                    ->required(),
                DatePicker::make('date')
                    ->required(),
                TimePicker::make('start_time')
                    ->required()
                    ->live(),
                TimePicker::make('end_time')
                    ->validationMessages([
                        'after' => 'The event time must be at least 1 hour long',
                    ])
                    ->after(fn(Get $get) => \Carbon\Carbon::parse($get('start_time'))->addHour())
                    ->required()
                    ->required(),
                Select::make('event_type')
                    ->options([
                        'seminar' => 'Seminar',
                        'workshop' => 'Workshop',
                        'competition' => 'Competition',
                        'concert' => 'Concert',
                        'conference' => 'Conference',
                        'other' => 'Other',
                    ])
                    ->required(),
                TextInput::make('capacity')
                    ->numeric()
                    ->minValue(1)
                    ->required(),
                Select::make('event_mode')
                    ->options([
                        'online' => 'Online',
                        'Onsite' => 'Onsite',
                    ])
                    ->required(),
                TextInput::make('location')
                    ->required(),
                Checkbox::make('is_paid')
                    ->columnSpanFull(),
            ])->columns(2),
        ];
    }

    public function isOver()
    {
        return $this->date->isPast();
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eventRegistrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
