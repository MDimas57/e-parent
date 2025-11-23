<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Database\Eloquent\Builder;

class AttendanceExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $startDate;
    protected $endDate;
    protected $classId;

    // Menerima data filter dari Form
    public function __construct($startDate, $endDate, $classId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->classId = $classId;
    }

    // 1. Query Data dari Database
    public function query()
    {
        $query = Attendance::query()
            ->with(['student', 'student.schoolClass']) // Load relasi
            ->whereDate('date', '>=', $this->startDate)
            ->whereDate('date', '<=', $this->endDate);

        // Jika ada filter kelas, tambahkan logic ini
        if ($this->classId) {
            $query->whereHas('student', function (Builder $q) {
                $q->where('school_class_id', $this->classId);
            });
        }

        return $query->orderBy('date')->orderBy('time');
    }

    // 2. Mengatur Data per Baris
    public function map($attendance): array
    {
        return [
            $attendance->date,
            $attendance->time,
            $attendance->student->nisn ?? '-',
            $attendance->student->name ?? '-',
            $attendance->student->schoolClass->name ?? '-',
            $attendance->status,
        ];
    }

    // 3. Judul Kolom (Header) di Excel
    public function headings(): array
    {
        return [
            'Tanggal',
            'Jam Absen',
            'NISN',
            'Nama Siswa',
            'Kelas',
            'Status Kehadiran',
        ];
    }
}