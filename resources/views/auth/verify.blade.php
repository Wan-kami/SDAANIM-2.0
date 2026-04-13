@extends('layouts.app')

@section('content')
<div class="form-container" style="max-width: 450px; margin: 80px auto;">
    <h2>Verificar Código</h2>
    <p style="text-align: center; color: #555; margin-bottom: 20px;">
        Se ha enviado un código de verificación a tu correo electrónico.
    </p>
    
    @if($errors->any())
    <div style="background-color: #fde6e6; color: #7f1f1f; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('verify.code') }}">
        @csrf
        
        <label for="codigo">Código de Verificación:</label>
        <input type="number" name="codigo" id="codigo" required placeholder="Ingrese el código">
        
        <button type="submit" style="width: 100%;">Verificar</button>
    </form>
</div>
@endsection
