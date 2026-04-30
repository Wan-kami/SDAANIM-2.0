<div id="dataPolicyModal" class="form-modal-overlay" onclick="cerrarModalPoliticaOutside(event)">
    <div class="form-modal-card">
        <button type="button" class="form-modal-close" onclick="cerrarModalPolitica()" title="Cerrar">?</button>
        <h2 style="color: #2e8b57; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Política de Tratamiento de
            Datos Personales</h2>

        <div
            style="max-height: 400px; overflow-y: auto; text-align: left; padding: 15px 5px; color: #475569; font-size: 0.9em; line-height: 1.6;">
            <p><strong>Aviso de Privacidad y Autorización - Ley Estatutaria 1581 de 2012 (Habeas Data)</strong></p>
            <p>De conformidad con lo establecido en la Ley Estatutaria 1581 de 2012 de Protección de Datos Personales y
                sus decretos reglamentarios, al aceptar esta polótica, usted autoriza de manera voluntaria, previa,
                explícita, informada e inequívoca a <strong>SDAANIM (Esperanza Animal BQ)</strong> para recolectar,
                almacenar, usar, circular y suprimir los datos personales aquí suministrados.</p>

            <h4 style="color: #1e293b; margin-top: 15px; margin-bottom: 5px;">1. Finalidad del Tratamiento</h4>
            <p>Los datos personales recolectados serán utilizados exclusivamente para:</p>
            <ul style="padding-left: 20px; margin-top: 5px;">
                <li>Gestionar los procesos de registro, adopción, postulación de voluntariado y postulación veterinaria.
                </li>
                <li>Establecer canales de comunicación (correo electrónico, teléfono, WhatsApp) respecto a actividades y
                    solicitudes en la plataforma.</li>
                <li>Mantener un registro histórico y estadístico interno de la fundación.</li>
            </ul>

            <h4 style="color: #1e293b; margin-top: 15px; margin-bottom: 5px;">2. Derechos del Titular</h4>
            <p>Como titular de la información, usted tiene derecho a:</p>
            <ul style="padding-left: 20px; margin-top: 5px;">
                <li>Conocer, actualizar y rectificar sus datos personales.</li>
                <li>Solicitar prueba de la autorización otorgada.</li>
                <li>Ser informado sobre el uso que se le ha dado a sus datos.</li>
                <li>Revocar la autorización y/o solicitar la supresión del dato cuando no se respeten los principios,
                    derechos y garantías legales.</li>
            </ul>

            <h4 style="color: #1e293b; margin-top: 15px; margin-bottom: 5px;">3. Seguridad y Confidencialidad</h4>
            <p>SDAANIM se compromete a mantener la confidencialidad de la información y a implementar las medidas
                técnicas y organizativas necesarias para evitar su adulteración, pérdida, consulta, uso o acceso no
                autorizado o fraudulento.</p>
        </div>

        <button type="button" class="btn" style="width: 100%; margin-top: 20px; background: #0ea5e9; font-weight: bold;"
            onclick="cerrarModalPolitica()">Entendido</button>
    </div>
</div>

<style>
    /* Asegurarnos de que las clases del modal base esten presentes por si no carga auth/modal.css */
    .form-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .form-modal-overlay.active {
        display: flex;
        opacity: 1;
    }

    .form-modal-card {
        background: white;
        padding: 30px;
        border-radius: 12px;
        width: 90%;
        max-width: 600px;
        position: relative;
        transform: translateY(-20px);
        transition: transform 0.3s ease;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .form-modal-overlay.active .form-modal-card {
        transform: translateY(0);
    }

    .form-modal-close {
        position: absolute;
        top: 15px;
        right: 15px;
        background: none;
        border: none;
        font-size: 1.5em;
        cursor: pointer;
        color: #94a3b8;
    }

    .form-modal-close:hover {
        color: #ef4444;
    }
</style>

<script>
    function abrirModalPolitica() {
        const modal = document.getElementById("dataPolicyModal");
        if (modal) {
            modal.classList.add("active");
            document.body.style.overflow = "hidden";
        }
    }

    function cerrarModalPolitica() {
        const modal = document.getElementById("dataPolicyModal");
        if (modal) {
            modal.classList.remove("active");
            document.body.style.overflow = "";
        }
    }

    function cerrarModalPoliticaOutside(event) {
        const modal = document.getElementById("dataPolicyModal");
        if (event.target === modal) {
            cerrarModalPolitica();
        }
    }
</script>