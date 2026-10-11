<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PpdbRegistration;
use App\Models\Major;

class PpdbController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'major_id' => 'required|exists:majors,id',
            'alternative_major_id' => 'nullable|exists:majors,id',
            'nisn' => 'required|string|size:10|unique:ppdb_registrations,nisn',
            'nik' => 'required|string|min:16|max:16',
            'full_name' => 'required|string|max:150',
            'gender' => 'required|in:L,P',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'religion' => 'required|string|max:30',
            'previous_school' => 'required|string|max:150',
            'student_phone' => 'required|string|max:20',
            'parent_phone' => 'required|string|max:20',
            'address' => 'required|string',
            'report_card_score' => 'required|numeric|min:0|max:100',
        ]);

        $code = 'PPDB-' . date('Ymd') . '-' . str_pad(rand(100, 9999), 4, '0', STR_PAD_LEFT);
        $validated['registration_code'] = $code;
        $validated['status'] = 'pending';

        $reg = PpdbRegistration::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran PPDB Berhasil!',
                'data' => $reg
            ]);
        }

        return redirect()->back()->with('success', "Pendaftaran Berhasil! Nomor Registrasi Anda: {$code}");
    }

    public function checkStatus(Request $request)
    {
        $query = $request->input('keyword');
        if (!$query) {
            return response()->json(['success' => false, 'message' => 'Nomor pendaftaran atau NISN wajib diisi']);
        }

        $reg = PpdbRegistration::with(['major', 'alternativeMajor'])
            ->where('registration_code', $query)
            ->orWhere('nisn', $query)
            ->first();

        if (!$reg) {
            return response()->json(['success' => false, 'message' => 'Data pendaftaran tidak ditemukan. Pastikan NISN atau Kode Registrasi benar.']);
        }

        return response()->json(['success' => true, 'data' => $reg]);
    }
}
