<div id="logoutModal" class="form-modal-overlay" onclick="cerrarLogoutOutside(event)">
    <div class="form-modal-card" style="text-align: center; max-width: 400px; padding: 30px 20px;">
        <h3 style="color: #ef4444; margin-bottom: 10px; font-size: 1.5em; font-family: 'Pacifico', cursive;">Cerrar
            Sesión🔒</h3>
        <p style="color: #475569; margin-bottom: 25px; line-height: 1.5;">¿Estás seguro de que deseas salir de tu cuenta
            de Esperanza Animal BQ?</p>
        <div style="display: flex; gap: 15px; justify-content: center;">
            <button onclick="cerrarLogoutModal()"
                style="background: #e2e8f0; color: #475569; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; transition: background 0.3s;"
                onmouseover="this.style.backgroundColor='#cbd5e1'"
                onmouseout="this.style.backgroundColor='#e2e8f0'">Cancelar</button>
            <button onclick="ejecutarLogout()"
                style="background: #ef4444; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; transition: background 0.3s;"
                onmouseover="this.style.backgroundColor='#dc2626'" onmouseout="this.style.backgroundColor='#ef4444'">Sí,
                salir</button>
        </div>
    </div>
</div>

<style>
    .form-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 10000;
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
        position: relative;
        transform: translateY(-20px);
        transition: transform 0.3s ease;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .form-modal-overlay.active .form-modal-card {
        transform: translateY(0);
    }
</style>

<script>
    let formALoguear = null;

    function confirmarLogout(event, formId) {
        if (event) event.preventDefault();
        formALoguear = document.getElementById(formId);
        const modal = document.getElementById("logoutModal");
        if (modal) {
            modal.classList.add("active");
            document.body.style.overflow = "hidden";
        }
    }

    function cerrarLogoutModal() {
        const modal = document.getElementById("logoutModal");
        if (modal) {
            modal.classList.remove("active");
            document.body.style.overflow = "";
        }
        formALoguear = null;
    }

    function ejecutarLogout() {
        if (formALoguear) {
            formALoguear.submit();
        }
    }

    function cerrarLogoutOutside(event) {
        const modal = document.getElementById("logoutModal");
        if (event.target === modal) {
            cerrarLogoutModal();
        }
    }
</script>