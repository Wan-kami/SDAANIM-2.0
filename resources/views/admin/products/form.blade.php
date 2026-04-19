@extends('layouts.app')

@section('content')
<main class="products-form-main">
    <section class="admin-form professional-form">
        <div class="form-header">
            <h1>{{ isset($product) ? '✏️ Editar Producto' : '➕ Nuevo Producto' }}</h1>
        </div>

        <form action="{{ isset($product) ? route('admin.products.update', $product->prod_id) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($product))
            @method('PUT')
            @endif

            <!-- Row 1: Nombre y Categoría -->
            <div class="form-row">
                <div class="form-group">
                    <label for="prod_nombre">📝 Nombre del Producto</label>
                    <p class="field-description">Nombre descriptivo del producto</p>
                    <input type="text" id="prod_nombre" name="prod_nombre" value="{{ isset($product) ? $product->prod_nombre : old('prod_nombre') }}" placeholder="Ej: Alimento Premium para Perros" required>
                </div>

                <div class="form-group">
                    <label for="prod_categoria">🏷️ Categoría</label>
                    <p class="field-description">Selecciona la categoría del producto</p>
                    <select id="prod_categoria" name="prod_categoria" required>
                        <option value="">Seleccionar categoría</option>
                        <option value="Alimentos" {{ (isset($product) && $product->prod_categoria == 'Alimentos') ? 'selected' : '' }}>Alimentos</option>
                        <option value="Juguetes" {{ (isset($product) && $product->prod_categoria == 'Juguetes') ? 'selected' : '' }}>Juguetes</option>
                        <option value="Camas" {{ (isset($product) && $product->prod_categoria == 'Camas') ? 'selected' : '' }}>Camas</option>
                        <option value="Accesorios" {{ (isset($product) && $product->prod_categoria == 'Accesorios') ? 'selected' : '' }}>Accesorios</option>
                        <option value="Ropa" {{ (isset($product) && $product->prod_categoria == 'Ropa') ? 'selected' : '' }}>Ropa</option>
                    </select>
                </div>
            </div>

            <!-- Row 2: Precio y Cantidad -->
            <div class="form-row">
                <div class="form-group">
                    <label for="prod_precio">💰 Precio</label>
                    <p class="field-description">Precio del producto en moneda local</p>
                    <div class="input-with-icon">
                        <span class="currency-icon">$</span>
                        <input type="number" step="0.01" id="prod_precio" name="prod_precio" value="{{ isset($product) ? $product->prod_precio : old('prod_precio') }}" placeholder="0.00" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="prod_cantidad">📦 Cantidad</label>
                    <p class="field-description">Stock disponible</p>
                    <input type="number" id="prod_cantidad" name="prod_cantidad" value="{{ isset($product) ? $product->prod_cantidad : old('prod_cantidad') }}" placeholder="0" required>
                </div>
            </div>

            <!-- Row 3: Descripción -->
            <div class="form-row full-width">
                <div class="form-group">
                    <label for="prod_descripcion">📄 Descripción</label>
                    <p class="field-description">Detalle completo del producto</p>
                    <textarea id="prod_descripcion" name="prod_descripcion" rows="4" placeholder="Describe el producto, características principales...">{{ isset($product) ? $product->prod_descripcion : old('prod_descripcion') }}</textarea>
                </div>
            </div>

            <!-- Row 4: Imagen -->
            <div class="form-row full-width">
                <div class="form-group">
                    <label for="prod_imagen">🖼️ Imagen del Producto</label>
                    <p class="field-description">Sube una imagen para el producto</p>
                    <div class="file-input-wrapper">
                        <input type="file" id="prod_imagen" name="prod_imagen" accept="image/*">
                        <span class="file-input-label">Selecciona una imagen</span>
                    </div>

                    @if(isset($product) && $product->prod_imagen)
                    <div class="current-image">
                        <p><strong>Imagen actual:</strong></p>
                        <img src="{{ asset('img/' . $product->prod_imagen) }}" alt="{{ $product->prod_nombre }}" class="product-preview">
                    </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    {{ isset($product) ? '✓ Actualizar Producto' : '✓ Crear Producto' }}
                </button>
                <a href="{{ route('admin.products') }}" class="btn-cancel">← Cancelar</a>
            </div>

            <!-- Info Box -->
            <div class="info-box">
                <strong>💡 Consejo:</strong> Asegúrate de completar todos los campos requeridos y de incluir una imagen clara del producto para mejorar la experiencia de los usuarios.
            </div>
        </form>
    </section>
</main>

<style>
    .products-form-main {
        padding: 2rem;
        max-width: 900px;
        width: 100%;
        margin: 0 auto;
        display: flex;
        justify-content: center;
    }

    .admin-form {
        width: 100%;
    }

    /* Form Header */
    .form-header {
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 1rem;
    }

    .form-header h1 {
        font-size: 1.8rem;
        color: #1a1a1a;
        margin: 0;
        font-weight: 700;
    }

    /* Professional Form Styles */
    .professional-form {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid #eee;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .form-row.full-width {
        grid-template-columns: 1fr;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.3rem;
        font-size: 1rem;
    }

    .field-description {
        font-size: 0.85rem;
        color: #888;
        margin: 0.2rem 0 0.8rem 0;
        font-style: italic;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        padding: 0.9rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #4CAF50;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        background-color: #fafafa;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    /* Currency Input */
    .input-with-icon {
        position: relative;
        display: flex;
        align-items: center;
    }

    .currency-icon {
        position: absolute;
        left: 12px;
        color: #4CAF50;
        font-weight: bold;
        font-size: 1.1rem;
    }

    .input-with-icon input {
        padding-left: 2.5rem;
    }

    /* File Input */
    .file-input-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-input-wrapper input[type="file"] {
        display: none;
    }

    .file-input-wrapper::before {
        content: '';
        display: block;
        width: 100%;
        padding: 2rem;
        background: linear-gradient(135deg, #f5f5f5, #fafafa);
        border: 2px dashed #4CAF50;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .file-input-wrapper:hover::before {
        background: linear-gradient(135deg, #f0f0f0, #f5f5f5);
        border-color: #45a049;
    }

    .file-input-label {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: #4CAF50;
        font-weight: 600;
        pointer-events: none;
    }

    /* Current Image */
    .current-image {
        margin-top: 1.5rem;
        padding: 1rem;
        background: #f9f9f9;
        border-radius: 8px;
        border: 1px solid #eee;
    }

    .current-image p {
        margin: 0 0 1rem 0;
        color: #333;
    }

    .product-preview {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Action Buttons */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        margin-bottom: 1.5rem;
    }

    .btn-submit {
        flex: 1;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #4CAF50, #45a049);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #45a049, #3d8b40);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(76, 175, 80, 0.3);
    }

    .btn-cancel {
        padding: 1rem 2rem;
        background: #f0f0f0;
        color: #333;
        border: 2px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #e8e8e8;
        border-color: #ccc;
    }

    /* Info Box */
    .info-box {
        background: linear-gradient(135deg, #fff8e1, #fffde7);
        border-left: 4px solid #fbc02d;
        padding: 1rem;
        border-radius: 8px;
        color: #d9a506;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .products-form-main {
            padding: 1rem;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .form-header h1 {
            font-size: 1.3rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .product-preview {
            width: 100%;
            height: 300px;
        }
    }
</style>

@endsection
