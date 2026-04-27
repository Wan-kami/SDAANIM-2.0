<?php

namespace App\Http\Controllers;

use App\Models\AdoptionRequest;
use App\Models\AdoptionReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Save a review from the adopter after decision.
     */
    public function store(Request $request, $soli_id)
    {
        $request->validate([
            'rev_estrellas' => 'required|integer|min:1|max:5',
            'rev_comentario' => 'nullable|string|max:500',
        ]);

        $solicitud = AdoptionRequest::where('Soli_id', $soli_id)
            ->where('Usu_documento', Auth::user()->Usu_documento)
            ->whereIn('Soli_estado', ['Aceptada', 'Rechazada', 'Aprobada', 'No Apta'])
            ->firstOrFail();

        // Only one review per solicitud
        $existente = AdoptionReview::where('soli_id', $soli_id)->first();
        if ($existente) {
            return back()->with('success', 'Ya dejaste una reseña para esta solicitud. ¡Gracias!');
        }

        AdoptionReview::create([
            'soli_id'        => $soli_id,
            'Usu_documento'  => Auth::user()->Usu_documento,
            'rev_estrellas'  => $request->rev_estrellas,
            'rev_comentario' => $request->rev_comentario,
        ]);

        return back()->with('success', '¡Gracias por tu reseña! Tu opinión nos ayuda a mejorar 🐾');
    }

    /**
     * Public listing of reviews (for social/public page).
     */
    public function publicIndex()
    {
        $reviews = AdoptionReview::with(['user', 'solicitud.animal'])
            ->latest()
            ->take(12)
            ->get();

        return view('public.social', compact('reviews'));
    }
}
