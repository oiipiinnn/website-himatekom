<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use Illuminate\Http\Request;

class AspirationController extends Controller
{
    public function index()
    {
        $aspirations = Aspiration::latest()->get();
        return view('admin.aspirations.index', compact('aspirations'));
    }

    public function show(Aspiration $aspiration)
    {
        return view('admin.aspirations.show', compact('aspiration'));
    }

    public function approve(Request $request, Aspiration $aspiration)
    {
        $aspiration->update([
            'status' => 'approved',
            'approved_at' => now(),
            'admin_notes' => $request->admin_notes
        ]);

        return redirect()->route('admin.aspirations.index')->with('success', 'Aspirasi berhasil disetujui!');
    }

    public function reject(Request $request, Aspiration $aspiration)
    {
        $aspiration->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes
        ]);

        return redirect()->route('admin.aspirations.index')->with('success', 'Aspirasi ditolak!');
    }

    public function destroy(Aspiration $aspiration)
    {
        $aspiration->delete();
        return redirect()->route('admin.aspirations.index')->with('success', 'Aspirasi berhasil dihapus!');
    }
}
