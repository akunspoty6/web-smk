<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Major;
use App\Models\Facility;
use App\Models\News;
use App\Models\PpdbRegistration;

class PortalController extends Controller
{
    public function index()
    {
        $majors = Major::where('is_active', true)->get();
        $facilities = Facility::where('is_public', true)->get();
        $news = News::where('status', 'published')->orderBy('id', 'desc')->take(6)->get();
        $stats = [
            'total_students' => 840,
            'total_majors' => $majors->count(),
            'industry_partners' => 48,
            'certified_teachers' => 38,
            'ppdb_quota_remaining' => 216 - PpdbRegistration::where('status', 'accepted')->count(),
        ];

        return view('portal', compact('majors', 'facilities', 'news', 'stats'));
    }
}
