<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
            'logo'     => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'empresa_nombre' => 'nullable|string|max:255',
            'empresa_telefono' => 'nullable|string|max:20',
        ]);

        // Password
        if (empty($request->password)) {
            $request = Arr::except($request, array('password'));
        } else {
            $request->merge(['password' => Hash::make($request->password)]);
        }

        try {
            $data = collect($request->all())->except(['logo'])->toArray();

           
            if ($request->hasFile('logo')) {
                $file   = $request->file('logo');
                $mime   = $file->getMimeType();
                $base64 = base64_encode(file_get_contents($file->getRealPath()));
                $data['logo'] = 'data:' . $mime . ';base64,' . $base64;
            }

            $profile->update($data);

            return redirect()->route('profile.index')->with('success', 'Cambios guardados');
        } catch (Throwable $e) {
            Log::error('Error al actualizar perfil', ['error' => $e->getMessage()]);
            return redirect()->route('profile.index')->with('error', 'Ups, algo falló');
        }
    }

    public function destroy(string $id) {}
}
