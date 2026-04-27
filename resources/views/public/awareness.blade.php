@extends('layouts.adopter.app')

@section('title', 'Concientización | Esperanza Animal BQ')

@section('content')
<link rel="stylesheet" href="{{ asset('css/shared/pages.css') }}">

<main class="quienes-somos">

    {{-- BANNER --}}
    <section class="banner-quienes" style="background: linear-gradient(135deg, #7c3aed 0%, #a855f7 60%, #c084fc 100%);">
        <h2 style="font-family:'Pacifico',cursive; font-size:2.4em;">🐾 Cuida a tu Mascota</h2>
        <p>Adoptar es el comienzo. Conoce los consejos esenciales para brindarle la mejor vida a tu nuevo amigo.</p>
    </section>

    {{-- CONSEJOS en grid --}}
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(260px,1fr)); gap:20px; margin-bottom:24px;">

        <div class="seccion" style="border-left-color:#ef4444; background:#fff5f5;">
            <h3 style="color:#dc2626;">🥩 Alimentación</h3>
            <p>Proporciona alimento balanceado y de calidad según la edad, tamaño y raza de tu mascota. Evita alimentos humanos como chocolate, cebolla o uva — son tóxicos para ellos. Mantén agua fresca disponible todo el día.</p>
            <ul style="padding-left:18px; color:#7f1d1d; margin-top:10px; line-height:1.8; font-size:0.92em;">
                <li>2-3 comidas al día para adultos</li>
                <li>3-4 comidas al día para cachorros</li>
                <li>Consulta al veterinario sobre porciones</li>
            </ul>
        </div>

        <div class="seccion" style="border-left-color:#2563eb; background:#eff6ff;">
            <h3 style="color:#1d4ed8;">💉 Vacunación & Salud</h3>
            <p>Las vacunas son fundamentales para proteger a tu mascota de enfermedades graves. Lleva un calendario de vacunación y desparasitación. Las visitas regulares al veterinario previenen problemas graves.</p>
            <ul style="padding-left:18px; color:#1e3a8a; margin-top:10px; line-height:1.8; font-size:0.92em;">
                <li>Vacuna antirrábica (anual)</li>
                <li>Desparasitación cada 3 meses</li>
                <li>Chequeo veterinario cada 6 meses</li>
            </ul>
        </div>

        <div class="seccion" style="border-left-color:#10b981; background:#ecfdf5;">
            <h3 style="color:#065f46;">🏃 Ejercicio & Juego</h3>
            <p>Las mascotas necesitan ejercicio diario para mantenerse sanas y felices. Los paseos fortalecen el vínculo entre tú y tu mascota, reducen el estrés y evitan comportamientos destructivos por aburrimiento.</p>
            <ul style="padding-left:18px; color:#064e3b; margin-top:10px; line-height:1.8; font-size:0.92em;">
                <li>30-60 min de ejercicio diario</li>
                <li>Juguetes interactivos en casa</li>
                <li>Socialización con otros animales</li>
            </ul>
        </div>

        <div class="seccion" style="border-left-color:#f59e0b; background:#fffbeb;">
            <h3 style="color:#92400e;">🛁 Higiene & Grooming</h3>
            <p>Mantener limpia a tu mascota es parte de su salud. El baño periódico, el cepillado del pelo y la limpieza de orejas y dientes previenen infecciones y mantienen a tu peludito cómodo y saludable.</p>
            <ul style="padding-left:18px; color:#78350f; margin-top:10px; line-height:1.8; font-size:0.92em;">
                <li>Baño cada 2-4 semanas</li>
                <li>Cepillado dental 2-3 veces/semana</li>
                <li>Revisión de orejas y garras mensual</li>
            </ul>
        </div>

        <div class="seccion" style="border-left-color:#ec4899; background:#fdf2f8;">
            <h3 style="color:#9d174d;">❤️ Amor & Bienestar Emocional</h3>
            <p>Las mascotas son seres sociales que necesitan afecto, atención y compañía. Dedica tiempo de calidad cada día. Evita dejarlos solos por períodos prolongados y respeta su espacio cuando lo necesiten.</p>
            <ul style="padding-left:18px; color:#831843; margin-top:10px; line-height:1.8; font-size:0.92em;">
                <li>Tiempo de calidad diario</li>
                <li>Espacio propio cómodo y seguro</li>
                <li>Refuerzo positivo siempre</li>
            </ul>
        </div>

        <div class="seccion" style="border-left-color:#8b5cf6; background:#f5f3ff;">
            <h3 style="color:#5b21b6;">📋 Esterilización</h3>
            <p>Esterilizar a tu mascota contribuye a controlar la sobrepoblación animal y tiene beneficios directos para su salud: reduce el riesgo de ciertos cánceres y comportamientos agresivos. ¡Es un acto de responsabilidad!</p>
            <ul style="padding-left:18px; color:#4c1d95; margin-top:10px; line-height:1.8; font-size:0.92em;">
                <li>Reduce riesgo de enfermedades</li>
                <li>Mejora el comportamiento</li>
                <li>Ayuda a controlar la sobrepoblación</li>
            </ul>
        </div>

    </div>

    {{-- FAQ --}}
    <section class="seccion" style="border-left-color:#7c3aed; background:#f5f3ff;">
        <h3 style="color:#5b21b6;">❓ Preguntas Frecuentes</h3>

        <div id="faqList" style="margin-top:12px;">

            <details style="border-radius:10px; border:1px solid #ddd6fe; margin-bottom:10px; overflow:hidden;">
                <summary style="padding:14px 18px; cursor:pointer; font-weight:700; color:#3730a3; background:#ede9fe; list-style:none; display:flex; justify-content:space-between;">
                    ¿Puedo adoptar si vivo en apartamento? <span>▾</span>
                </summary>
                <p style="padding:14px 18px; color:#4c1d95; margin:0; background:#fff; font-size:0.93em; line-height:1.7;">
                    ¡Sí! Lo más importante es el amor y la dedicación que brindes. Para perros de razas medianas o grandes recomendamos asegurar paseos diarios frecuentes. Tenemos muchos perros pequeños perfectos para apartamento.
                </p>
            </details>

            <details style="border-radius:10px; border:1px solid #ddd6fe; margin-bottom:10px; overflow:hidden;">
                <summary style="padding:14px 18px; cursor:pointer; font-weight:700; color:#3730a3; background:#ede9fe; list-style:none; display:flex; justify-content:space-between;">
                    ¿Cuánto cuesta adoptar? <span>▾</span>
                </summary>
                <p style="padding:14px 18px; color:#4c1d95; margin:0; background:#fff; font-size:0.93em; line-height:1.7;">
                    La adopción es gratuita. Sí pedimos que el animal cuente con sus vacunas al día y sea esterilizado si aún no lo está. Nuestro equipo te orientará en cada paso.
                </p>
            </details>

            <details style="border-radius:10px; border:1px solid #ddd6fe; margin-bottom:10px; overflow:hidden;">
                <summary style="padding:14px 18px; cursor:pointer; font-weight:700; color:#3730a3; background:#ede9fe; list-style:none; display:flex; justify-content:space-between;">
                    ¿Cuánto tiempo tarda el proceso de adopción? <span>▾</span>
                </summary>
                <p style="padding:14px 18px; color:#4c1d95; margin:0; background:#fff; font-size:0.93em; line-height:1.7;">
                    El proceso incluye el formulario de solicitud, una visita a tu hogar por parte de un voluntario y la revisión final. Puede tomar entre 1 y 3 semanas dependiendo de la disponibilidad y el caso.
                </p>
            </details>

            <details style="border-radius:10px; border:1px solid #ddd6fe; overflow:hidden;">
                <summary style="padding:14px 18px; cursor:pointer; font-weight:700; color:#3730a3; background:#ede9fe; list-style:none; display:flex; justify-content:space-between;">
                    ¿Qué pasa si no puedo seguir cuidando al animal? <span>▾</span>
                </summary>
                <p style="padding:14px 18px; color:#4c1d95; margin:0; background:#fff; font-size:0.93em; line-height:1.7;">
                    Por favor, comunícate con nosotros antes de tomar cualquier decisión. Estamos para ayudarte. El animal puede regresar a nuestro refugio y buscaremos una nueva familia amorosa para él.
                </p>
            </details>

        </div>
    </section>

</main>
@endsection
