@extends('layouts.adopter.app')

@section('title', 'Editar Historia | SDAANIM')

@section('content')
<div style="max-width: 800px; margin: 40px auto; padding: 20px;">
    <div class="premium-card" style="background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); padding: 30px;">
        <h2 style="color: #2d7d46; font-family: 'Pacifico', cursive; margin-bottom: 25px;">📖 Nuestra Historia</h2>
        <p style="color: #64748b; margin-bottom: 30px;">Como miembro de nuestra comunidad, puedes ayudar a redactar y actualizar nuestra misión y visión.</p>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('adopter.history.update') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: bold; color: #1e293b; margin-bottom: 8px;">Nuestra Misión</label>
                <textarea name="mision" rows="5" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #d1d5db; font-family: inherit;">{{ $about->mision ?? '' }}</textarea>
            </div>

            <div style="margin-bottom: 30px;">
                <label style="display: block; font-weight: bold; color: #1e293b; margin-bottom: 8px;">Nuestra Visión</label>
                <textarea name="vision" rows="5" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #d1d5db; font-family: inherit;">{{ $about->vision ?? '' }}</textarea>
            </div>

            <div style="display: flex; gap: 15px;">
                <button type="submit" class="premium-btn premium-btn-adopter" style="padding: 12px 30px; font-weight: bold;">
                    Actualizar Historia 🐾
                </button>
                <a href="{{ route('adopter.dashboard') }}" style="padding: 12px 30px; background: #f1f5f9; color: #475569; border-radius: 10px; text-decoration: none; font-weight: bold;">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
