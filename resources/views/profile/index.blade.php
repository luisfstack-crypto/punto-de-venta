@extends('layouts.app')

@section('title','Perfil')

@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')

<div class="container-fluid">
    <h1 class="mt-4 mb-4 text-center">Configurar perfil</h1>

    <div class="card">
        <div class="card-header">
            <p class="lead fw-bold">Configure y personalize su perfil</p>
        </div>
        <form action="{{ route('profile.update', ['profile' => auth()->user()]) }}"
              method="POST"
              enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="card-body">
                <div class="row g-4">

                    <!---Name--->
                    <div class="col-12">
                        <x-forms.input id='name'
                            required='true'
                            labelText='Nombre de usuario'
                            :defaultValue='auth()->user()->name' />
                    </div>

                    <!----Email--->
                    <div class="col-12">
                        <x-forms.input id='email'
                            required='true'
                            type='email'
                            labelText='Correo electrónico'
                            :defaultValue='auth()->user()->email' />
                    </div>

                    <!----Password--->
                    <div class="col-12">
                        <x-forms.input id='password'
                            type='password'
                            labelText='Nueva contraseña' />
                    </div>

                    <!----Logo--->
                    <div class="col-12">
                        <label class="form-label">Logo personal (PNG)</label>
                        <div class="d-flex align-items-center gap-3 flex-wrap">

                            {{-- Preview logo actual --}}
                            @if(auth()->user()->logo)
                                <img src="{{ Storage::url(auth()->user()->logo) }}"
                                     alt="Logo actual"
                                     height="48"
                                     style="border-radius:6px; border:1px solid var(--pv-border); padding:4px; background:var(--pv-card-header);">
                            @else
                                <div style="width:48px;height:48px;border-radius:6px;border:1px dashed var(--pv-border);display:flex;align-items:center;justify-content:center;color:var(--pv-text-muted);">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif

                            <div>
                                <input type="file"
                                       name="logo"
                                       id="logoInput"
                                       accept=".png"
                                       class="form-control"
                                       style="max-width:300px;"
                                       onchange="previewLogo(this)">
                                <small class="text-muted d-block mt-1">Solo PNG · Máx. 2 MB</small>
                            </div>
                        </div>

                        @error('logo')
                            <div class="text-danger mt-1" style="font-size:0.82rem;">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <div class="col text-center">
                    @can('editar-perfil')
                    <input class="btn btn-success" type="submit" value="Guardar cambios">
                    @endcan
                </div>
            </div>

        </form>
    </div>

</div>
@endsection

@push('js')
<script>
function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Buscar preview existente o crear uno nuevo
            let preview = document.getElementById('logo-preview');
            if (!preview) {
                preview = document.createElement('img');
                preview.id = 'logo-preview';
                preview.height = 48;
                preview.style.cssText = 'border-radius:6px;border:1px solid var(--pv-border);padding:4px;background:var(--pv-card-header);';
                input.closest('.d-flex').prepend(preview);
                // Ocultar el placeholder si existe
                const placeholder = input.closest('.d-flex').querySelector('div[style*="dashed"]');
                if (placeholder) placeholder.style.display = 'none';
            }
            preview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush