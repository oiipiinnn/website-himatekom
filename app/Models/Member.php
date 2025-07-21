<?php
// app/Models/Member.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'position',
        'division_id',
        'position_level',
        'start_date',
        'end_date',
        'status',
        'is_active',
        'motivation',
        'notes'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Scopes
    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true)->where('status', 'active');
    }

    public function scopeInactive(Builder $query)
    {
        return $query->where('is_active', false)->orWhere('status', 'inactive');
    }

    public function scopeAlumni(Builder $query)
    {
        return $query->where('status', 'alumni');
    }

    public function scopeByDivision(Builder $query, $divisionId)
    {
        return $query->where('division_id', $divisionId);
    }

    public function scopeByBatch(Builder $query, $batch)
    {
        return $query->whereHas('student', function ($q) use ($batch) {
            $q->where('batch', $batch);
        });
    }

    public function scopeLeaders(Builder $query)
    {
        return $query->where('position_level', '<=', 2);
    }

    public function scopeSearch(Builder $query, $search)
    {
        return $query->whereHas('student', function ($q) use ($search) {
            $q->where('full_name', 'like', "%{$search}%")
                ->orWhere('nim', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->orWhere('position', 'like', "%{$search}%");
    }

    // Accessors (get data from student)
    public function getNameAttribute()
    {
        return $this->student?->full_name;
    }

    public function getNimAttribute()
    {
        return $this->student?->nim;
    }

    public function getEmailAttribute()
    {
        return $this->student?->email;
    }

    public function getPhoneAttribute()
    {
        return $this->student?->phone;
    }

    public function getBatchAttribute()
    {
        return $this->student?->batch;
    }

    public function getGenderAttribute()
    {
        return $this->student?->gender;
    }

    public function getPhotoUrlAttribute()
    {
        // Use work photo (with background) instead of casual photo
        return $this->student?->work_photo_url ?: asset('img/default-avatar.jpg');
    }

    public function getGenderLabelAttribute()
    {
        return match ($this->gender) {
            'male' => 'Laki-laki',
            'female' => 'Perempuan',
            default => '-',
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'active' => '<span class="badge badge-success">Aktif</span>',
            'inactive' => '<span class="badge badge-warning">Tidak Aktif</span>',
            'alumni' => '<span class="badge badge-info">Alumni</span>',
            default => '<span class="badge badge-secondary">Unknown</span>',
        };
    }

    public function getPositionLevelLabelAttribute()
    {
        return match ($this->position_level) {
            1 => 'Ketua/Pimpinan Tertinggi',
            2 => 'Wakil Ketua/Pimpinan',
            3 => 'Kepala Divisi/Bidang',
            4 => 'Anggota/Staff',
            default => 'Tidak Diketahui',
        };
    }

    public function getTenureAttribute()
    {
        if (!$this->start_date) return null;

        $endDate = $this->end_date ?? now();
        return $this->start_date->diffInMonths($endDate);
    }

    public function getFullPositionAttribute()
    {
        return $this->position . ' (' . $this->division->name . ')';
    }

    // Static methods
    public static function getStatuses()
    {
        return [
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            'alumni' => 'Alumni'
        ];
    }

    public static function getPositionLevels()
    {
        return [
            1 => 'Ketua/Pimpinan Tertinggi',
            2 => 'Wakil Ketua/Pimpinan',
            3 => 'Kepala Divisi/Bidang',
            4 => 'Anggota/Staff'
        ];
    }

    // Methods
    public function isLeader()
    {
        return $this->position_level <= 2;
    }

    public function isActive()
    {
        return $this->is_active && $this->status === 'active';
    }

    public function isAlumni()
    {
        return $this->status === 'alumni';
    }

    public function promotePosition($newPosition, $newLevel, $newDivisionId = null, $startDate = null)
    {
        $updateData = [
            'position' => $newPosition,
            'position_level' => $newLevel,
            'start_date' => $startDate ?? now(),
            'end_date' => null,
            'status' => 'active',
            'is_active' => true
        ];

        if ($newDivisionId) {
            $updateData['division_id'] = $newDivisionId;
        }

        $this->update($updateData);
        return $this;
    }

    public function deactivate($endDate = null, $reason = null)
    {
        $notes = $this->notes;
        if ($reason) {
            $notes .= "\n" . now()->format('Y-m-d') . ": " . $reason;
        }

        $this->update([
            'end_date' => $endDate ?? now(),
            'status' => 'inactive',
            'is_active' => false,
            'notes' => $notes
        ]);

        return $this;
    }

    public function makeAlumni($graduationDate = null)
    {
        $this->update([
            'status' => 'alumni',
            'end_date' => $graduationDate ?? now(),
            'is_active' => false
        ]);

        return $this;
    }

    public function reactivate($newStartDate = null)
    {
        $this->update([
            'status' => 'active',
            'is_active' => true,
            'start_date' => $newStartDate ?? now(),
            'end_date' => null
        ]);

        return $this;
    }
}
