<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnrollmentRequest;
use App\Models\Student;
use App\Models\Program;
use App\Notifications\EnrollmentRequestApproved;
use App\Notifications\EnrollmentRequestRejected;
use App\Services\SmsService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminEnrollmentRequestController extends Controller
{
    public function index(Request $request): View|\Symfony\Component\HttpFoundation\StreamedResponse
    {
        $query = EnrollmentRequest::with('program');

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($programId = $request->integer('program_id')) {
            if ($programId > 0) {
                $query->where('program_id', $programId);
            }
        }

        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        if ($request->string('export')->toString() === 'csv') {
            $filename = 'enrollment_requests_'.now()->format('Ymd_His').'.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            ];
            return response()->stream(function () use ($query) {
                $out = fopen('php://output', 'w');
                fputcsv($out, ['ID','Submitted','Full Name','Email','Program','Status']);
                $query->orderByDesc('created_at')->chunk(500, function ($chunk) use ($out) {
                    foreach ($chunk as $req) {
                        fputcsv($out, [
                            $req->id,
                            optional($req->created_at)->toDateTimeString(),
                            $req->full_name,
                            $req->email,
                            optional($req->program)->name,
                            $req->status,
                        ]);
                    }
                });
                fclose($out);
            }, 200, $headers);
        }

        $requests = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $programs = Program::orderBy('name')->get();
        return view('admin.enrollment_requests.index', compact('requests','programs'));
    }

    public function show(EnrollmentRequest $enrollmentRequest): View
    {
        $enrollmentRequest->load('program');
        return view('admin.enrollment_requests.show', compact('enrollmentRequest'));
    }

    public function approve(EnrollmentRequest $enrollmentRequest, SmsService $sms): RedirectResponse
    {
        $enrollmentRequest->update(['status' => 'approved']);

        // Ensure a student record exists
        $user = User::firstOrCreate(
            ['email' => $enrollmentRequest->email],
            ['name' => $enrollmentRequest->full_name, 'password' => bcrypt(str()->random(12))]
        );

        $student = Student::firstOrCreate(
            ['user_id' => $user->id],
            [
                'student_number' => 'S'.now()->format('Y').$user->id,
                'first_name' => $enrollmentRequest->full_name,
                'last_name' => '',
                'contact_number' => $enrollmentRequest->contact_number,
                'address' => $enrollmentRequest->address,
                'program_id' => $enrollmentRequest->program_id,
                'status' => 'active',
            ]
        );

        // Auto-create initial term enrollments (optional): enroll in program's first semester courses
        // You can refine logic as needed
        $initialCourses = optional($enrollmentRequest->program)->courses()
            ?->where('year_level', 1)->where('semester', 1)->get() ?? collect();
        foreach ($initialCourses as $course) {
            \App\Models\Enrollment::firstOrCreate([
                'student_id' => $student->id,
                'course_id' => $course->id,
                'term' => '1st',
                'school_year' => $enrollmentRequest->school_year,
            ]);
        }

        // Notify student via email
        if ($enrollmentRequest->email) {
            $user->notify(new EnrollmentRequestApproved([
                'full_name' => $enrollmentRequest->full_name,
                'program_name' => optional($enrollmentRequest->program)->name,
            ]));
        }

        // SMS notify admins (or a configured number)
        $adminNumber = config('services.sms.admin_number');
        if ($adminNumber) {
            $sms->send($adminNumber, 'Enrollment approved: '.$enrollmentRequest->full_name.' - '.optional($enrollmentRequest->program)->name);
        }

        return back()->with('status', 'Enrollment request approved and student created/linked.');
    }

    public function reject(Request $request, EnrollmentRequest $enrollmentRequest, SmsService $sms): RedirectResponse
    {
        $data = $request->validate([
            'admin_note' => ['nullable','string','max:2000'],
        ]);
        $enrollmentRequest->update([
            'status' => 'rejected',
            'admin_note' => $data['admin_note'] ?? null,
        ]);

        // Email notify student
        if ($enrollmentRequest->email) {
            $user = User::firstOrNew(['email' => $enrollmentRequest->email]);
            $user->notify(new EnrollmentRequestRejected([
                'full_name' => $enrollmentRequest->full_name,
                'program_name' => optional($enrollmentRequest->program)->name,
            ]));
        }

        // SMS notify admins
        $adminNumber = config('services.sms.admin_number');
        if ($adminNumber) {
            $sms->send($adminNumber, 'Enrollment rejected: '.$enrollmentRequest->full_name.' - '.optional($enrollmentRequest->program)->name);
        }

        return back()->with('status', 'Enrollment request rejected.');
    }

    public function bulkAction(Request $request, SmsService $sms): RedirectResponse
    {
        $action = $request->input('action');
        $ids = $request->input('selected_requests', []);

        if (empty($ids)) {
            return back()->with('error', 'No requests selected.');
        }

        $requests = EnrollmentRequest::whereIn('id', $ids)->get();

        foreach ($requests as $enrollmentRequest) {
            if ($action === 'approve') {
                $this->approve($enrollmentRequest, $sms);
            } elseif ($action === 'reject') {
                $this->reject($enrollmentRequest, $sms);
            }
        }

        return back()->with('status', 'Bulk action completed successfully.');
    }
}


