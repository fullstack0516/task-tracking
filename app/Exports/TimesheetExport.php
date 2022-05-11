<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TimesheetExport implements FromArray, WithHeadings
{
    protected $timeEntries;

    public function __construct(array $timeEntries)
    {
        $this->timeEntries = $timeEntries;
    }

    public function array(): array
    {
        return $this->timeEntries;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Hours',
            'Task',
            'Note',
        ];
    }
}
