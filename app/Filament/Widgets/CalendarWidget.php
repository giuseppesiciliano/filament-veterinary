<?php

namespace App\Filament\Widgets;
 
use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Filament\Forms;
use Filament\Forms\Form;
 
class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Task::class;
 
    public function fetchEvents(array $fetchInfo): array
    {
        return Task::where('start', '>=', $fetchInfo['start'])
            ->where('end', '<=', $fetchInfo['end'])
            ->get()
            ->map(function (Task $task) {
                return [
                    'id'    => $task->id,
                    'title' => $task->name,
                    'start' => $task->start,
                    'end'   => $task->end,
                ];
            })
            ->toArray();
    }
 
    public static function canView(): bool
    {
        return true;
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name'),
 
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\DateTimePicker::make('start'),
 
                    Forms\Components\DateTimePicker::make('end'),
                ]),
        ];
    }
}