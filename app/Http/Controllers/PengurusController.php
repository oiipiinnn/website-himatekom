<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Member;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    public function index()
    {
        $divisions = Division::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('pengurus', compact('divisions'));
    }

    public function show(Division $division)
    {
        $members = $division->members()
            ->where('is_active', true)
            ->get();

        return view('pengurus.show', compact('division', 'members'));
    }
}
