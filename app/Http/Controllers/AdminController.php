<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Major;
use App\Models\Facility;
use App\Models\News;
use App\Models\PpdbRegistration;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $registrations = PpdbRegistration::with(['major', 'alternativeMajor'])->orderBy('id', 'desc')->get();
        $majors = Major::withCount('ppdbRegistrations')->get();
        $news = News::with('author')->orderBy('id', 'desc')->get();
        $facilities = Facility::all();

        $stats = [
            'total_registrations' => $registrations->count(),
            'pending_count' => $registrations->where('status', 'pending')->count(),
            'verified_count' => $registrations->where('status', 'verified')->count(),
            'accepted_count' => $registrations->where('status', 'accepted')->count(),
            'total_majors' => $majors->count(),
            'total_quota' => $majors->sum('quota'),
        ];

        return view('admin.dashboard', compact('user', 'registrations', 'majors', 'news', 'facilities', 'stats'));
    }

    public function updatePpdbStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,verified,accepted,rejected',
            'notes' => 'nullable|string',
        ]);

        $reg = PpdbRegistration::findOrFail($id);
        $reg->status = $request->input('status');
        if ($request->filled('notes')) {
            $reg->verification_notes = $request->input('notes');
        }
        $reg->verified_by = Auth::id();
        $reg->verified_at = now();
        $reg->save();

        return redirect()->back()->with('success', "Status pendaftaran {$reg->full_name} ({$reg->registration_code}) berhasil diperbarui menjadi: " . strtoupper($reg->status));
    }

    public function updateMajorQuota(Request $request, $id)
    {
        $request->validate([
            'quota' => 'required|integer|min:0',
        ]);

        $major = Major::findOrFail($id);
        $major->quota = $request->input('quota');
        $major->save();

        return redirect()->back()->with('success', "Kuota jurusan {$major->name} berhasil diubah menjadi {$major->quota} siswa.");
    }
}
