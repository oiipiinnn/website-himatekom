<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AspirationController extends Controller
{
    public function index()
    {
        $aspirations = Aspiration::approved()
            ->latest('approved_at')
            ->paginate(10);

        return view('aspirations.index', compact('aspirations'));
    }

    public function create()
    {
        return view('aspirations.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nim' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Aspiration::create($request->all());

        return redirect()->back()->with('success', 'Aspirasi Anda telah dikirim dan sedang menunggu persetujuan admin.');
    }
}
