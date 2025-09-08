<?php
// app/Models/Student.php
namespace App\Models;

use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Student extends Model
{
    use HasFactory, HasImages;

    protected $fillable = [
        'full_name',
        'nim',
        'email',
        'phone',
        'batch',
        'work_photo',
        'casual_photo',
        'validation_document',
        'skills',
        'hobbies',
        'career_goal',
        'instagram',
        'linkedin',
        'tiktok',
        'github',
        'portfolio_url',
        'bio',
        'description',
        'life_motto',
        'current_job',
        'hometown',
        'birth_date',
        'gender',
        'status',
        'rejection_reason',
        'approved_at',
        'approved_by',
        'is_active',
        'show_in_public'
    ];

    protected $casts = [
        'skills' => 'array',
        'hobbies' => 'array',
        'birth_date' => 'date',
        'approved_at' => 'datetime',
        'is_active' => 'boolean',
        'show_in_public' => 'boolean',
    ];

    /**
     * Image fields that should be auto-deleted
     */
    protected $imageFields = ['work_photo', 'casual_photo', 'validation_document'];

    // Relationships
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function member()
    {
        return $this->hasOne(Member::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublic($query)
    {
        return $query->where('show_in_public', true);
    }

    public function scopeByBatch($query, $batch)
    {
        return $query->where('batch', $batch);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('full_name', 'like', "%{$search}%")
              ->orWhere('nim', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('batch', 'like', "%{$search}%");
        });
    }

    public function scopeAvailableForMember(Builder $query)
    {
        return $query->approved()->active()->whereDoesntHave('member');
    }

    public function scopeAlreadyMember(Builder $query)
    {
        return $query->whereHas('member');
    }

    // Accessor for photo URLs
    public function getCasualPhotoUrlAttribute()
    {
        return $this->getImageUrl('casual_photo', asset('images/default-avatar.png'));
    }

    public function getWorkPhotoUrlAttribute()
    {
        return $this->getImageUrl('work_photo');
    }

    public function getValidationDocumentUrlAttribute()
    {
        return $this->getImageUrl('validation_document');
    }

    // Gender label
    public function getGenderLabelAttribute()
    {
        return match($this->gender) {
            'male' => 'Laki-laki',
            'female' => 'Perempuan',
            default => '-'
        };
    }

    // Age calculation
    public function getAgeAttribute()
    {
        if (!$this->birth_date) {
            return null;
        }
        return $this->birth_date->diffInYears(Carbon::now());
    }

    // Status badge
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => '<span class="badge badge-warning">Pending</span>',
            'approved' => '<span class="badge badge-success">Approved</span>',
            'rejected' => '<span class="badge badge-danger">Rejected</span>',
            default => '<span class="badge badge-secondary">Unknown</span>'
        };
    }

    // Member-related accessors
    public function getIsMemberAttribute()
    {
        return !is_null($this->member);
    }

    public function getMemberPositionAttribute()
    {
        return $this->member ? $this->member->position : null;
    }

    public function getMemberDivisionAttribute()
    {
        return $this->member ? $this->member->division->name : null;
    }

    public function getMemberStatusAttribute()
    {
        return $this->member ? $this->member->status : null;
    }

    // Status methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    // Member-related methods
    public function canBecomeMember()
    {
        return $this->isApproved() && $this->is_active && !$this->is_member;
    }

    public function createMember($position, $divisionId, $positionLevel, $additionalData = [])
    {
        if (!$this->canBecomeMember()) {
            throw new \Exception('Student cannot become a member at this time');
        }

        $memberData = array_merge([
            'student_id' => $this->id,
            'name' => $this->full_name,
            'nim' => $this->nim,
            'email' => $this->email,
            'phone' => $this->phone,
            'batch' => $this->batch,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'hometown' => $this->hometown,
            'bio' => $this->bio,
            'skills' => $this->skills,
            'hobbies' => $this->hobbies,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'github' => $this->github,
            'personal_website' => $this->portfolio_url,
            'position' => $position,
            'division_id' => $divisionId,
            'position_level' => $positionLevel,
            'major' => 'Teknik Komputer',
            'faculty' => 'Fakultas Teknologi Informasi',
            'status' => 'active',
            'is_active' => true,
            'start_date' => now()
        ], $additionalData);

        return Member::create($memberData);
    }

    public function getMemberHistory()
    {
        // Return current member relationship
        // In future, this could be expanded to include historical data
        return $this->member;
    }

    // Action methods
    public function approve($userId = null)
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $userId,
            'rejection_reason' => null
        ]);
    }

    public function reject($reason, $userId = null)
    {
        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'approved_at' => null,
            'approved_by' => $userId
        ]);
    }

    // Static methods
    public static function getStatuses()
    {
        return [
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected'
        ];
    }

    public static function getBatches()
    {
        return self::distinct('batch')
                   ->orderBy('batch', 'desc')
                   ->pluck('batch')
                   ->toArray();
    }

    public static function getSkillsList()
    {
        return self::approved()
                   ->active()
                   ->whereNotNull('skills')
                   ->where('skills', '!=', '[]')
                   ->get()
                   ->pluck('skills')
                   ->flatten()
                   ->unique()
                   ->sort()
                   ->values()
                   ->toArray();
    }

    public static function getAvailableForMemberCount()
    {
        return self::availableForMember()->count();
    }

    public static function getAlreadyMemberCount()
    {
        return self::alreadyMember()->count();
    }

    // Boot method for model events
    protected static function boot()
    {
        parent::boot();

        // When student is approved, they become eligible for member
        static::updating(function ($student) {
            // Log status changes
            if ($student->isDirty('status')) {
                \Log::info('Student status changed', [
                    'student_id' => $student->id,
                    'old_status' => $student->getOriginal('status'),
                    'new_status' => $student->status,
                    'student_name' => $student->full_name
                ]);
            }
        });

        // When student is deleted, handle member relationship
        static::deleting(function ($student) {
            if ($student->member) {
                // Optionally delete the member or just nullify the relationship
                // For now, we'll just log it
                \Log::warning('Deleting student who is a member', [
                    'student_id' => $student->id,
                    'student_name' => $student->full_name,
                    'member_position' => $student->member->position,
                    'member_division' => $student->member->division->name
                ]);
            }
        });
    }
}
