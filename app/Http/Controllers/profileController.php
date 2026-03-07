<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class profileController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-perfil', ['only' => ['index']]);
        $this->middleware('permission:editar-perfil', ['only' => ['update']]);
    }

    public function index(): View
    {
        return view('profile.index');
    }

    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}

    public function update(Request $request, User $profile): RedirectResponse
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|unique:users,email,' . $profile->id,
            'password' => 'nullable',
            'logo'     => 'nullable|image|mimes:png|max:2048',
        ]);

        // Password
        if (empty($request->password)) {
            $request = Arr::except($request, array('password'));
        } else {
            $request->merge(['password' => Hash::make($request->password)]);
        }

        try {
            if ($request->hasFile('logo')) {
                if ($profile->logo && Storage::disk('public')->exists($profile->logo)) {
                    Storage::disk('public')->delete($profile->logo);
                }
                $path = $request->file('logo')->storeAs(
                    'logos',
                    'logo_user_' . $profile->id . '.png',
                    'public'
                );
                $profile->logo = $path;
            }

            $profile->update(
                collect($request->all())->except(['logo'])->toArray()
            );

            if ($request->hasFile('logo')) {
                $profile->save();
            }

            return redirect()->route('profile.index')->with('success', 'Cambios guardados');
        } catch (Throwable $e) {
            Log::error('Error al actualizar perfil', ['error' => $e->getMessage()]);
            return redirect()->route('profile.index')->with('error', 'Ups, algo falló');
        }
    }

    public function destroy(string $id) {}
}
