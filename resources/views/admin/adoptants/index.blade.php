@extends('layouts.app')

@section('content')
    <div class="adoptants-container">
        <!-- Header Section -->
        <div class="adoptants-header-wrapper">
            <div class="adoptants-header">
                <div class="header-content">
                    <a href="{{ route('admin.dashboard') }}" class="btn-back" title="Volver al Panel">
                        <span class="back-icon">←</span>
                    </a>
                    <div>
                        <h1>👥 Adoptantes Registrados</h1>
                        <p class="subtitle">Listado de todas las personas registradas en el sistema</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Adoptants Table Card -->
        @if($adoptants->count() > 0)
            <div class="table-card">
                <div class="table-stats">
                    <span class="stat-badge">Total: <strong>{{ $adoptants->count() }}</strong>
                        adoptante{{ $adoptants->count() !== 1 ? 's' : '' }}</span>
                </div>
                <table class="adoptants-table">
                    <thead>
                        <tr>
                            <th class="col-document">DOCUMENTO</th>
                            <th class="col-name">NOMBRE</th>
                            <th class="col-email">EMAIL</th>
                            <th class="col-phone">TELÉFONO</th>
                            <th class="col-address">DIRECCIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($adoptants as $adoptant)
                            <tr class="adoptant-row">
                                <td class="col-document">
                                    <span class="document-badge">{{ $adoptant->Usu_documento }}</span>
                                </td>
                                <td class="col-name">
                                    <div class="user-cell">
                                        <div class="avatar">{{ substr($adoptant->name, 0, 1) }}</div>
                                        <span class="name">{{ $adoptant->name }}</span>
                                    </div>
                                </td>
                                <td class="col-email">
                                    <a href="mailto:{{ $adoptant->email }}" class="email-link">{{ $adoptant->email }}</a>
                                </td>
                                <td class="col-phone">
                                    <span class="phone-text">{{ $adoptant->Usu_telefono ?? '—' }}</span>
                                </td>
                                <td class="col-address">
                                    <span class="address-text">📍 {{ $adoptant->Usu_direccion ?? '—' }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">📋</div>
                <h3>No hay adoptantes registrados</h3>
                <p>Cuando las personas se registren en el sistema para adoptar, aparecerán aquí.</p>
            </div>
        @endif
    </div>

    <style>
        .adoptants-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Header Wrapper */
        .adoptants-header-wrapper {
            margin-bottom: 2rem;
        }

        /* Header Styles */
        .adoptants-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 0;
            flex: 1;
        }

        .header-content h1 {
            font-size: 2rem;
            color: #1a1a1a;
            margin: 0 0 0.5rem 0;
            font-weight: 700;
        }

        .subtitle {
            font-size: 0.95rem;
            color: #666;
            margin: 0;
        }

        /* Back Button */
        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: #f0f0f0;
            color: #333;
            text-decoration: none;
            border-radius: 50%;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-right: 1rem;
            font-size: 1.2rem;
            border: 2px solid #e0e0e0;
        }

        .btn-back:hover {
            background: #2196F3;
            color: white;
            border-color: #2196F3;
            transform: scale(1.1);
        }

        .back-icon {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Table Card */
        .table-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        /* Table Stats */
        .table-stats {
            padding: 1.2rem 1.5rem;
            background: linear-gradient(135deg, #f8fbf8 0%, #f0f8f0 100%);
            border-bottom: 1px solid #e0e0e0;
        }

        .stat-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #e8f5e9;
            color: #2e7d32;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .stat-badge strong {
            color: #1b5e20;
            font-size: 1.1rem;
        }

        /* Table Styles */
        .adoptants-table {
            width: 100%;
            border-collapse: collapse;
        }

        .adoptants-table thead {
            background: linear-gradient(135deg, #f8fbf8 0%, #f0f8f0 100%);
            border-bottom: 2px solid #e0e0e0;
        }

        .adoptants-table th {
            padding: 1.2rem 1.5rem;
            text-align: left;
            font-size: 0.85rem;
            font-weight: 700;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .col-document {
            width: 150px;
        }

        .col-name {
            width: 200px;
        }

        .col-email {
            width: 250px;
        }

        .col-phone {
            width: 140px;
        }

        .col-address {
            flex: 1;
            min-width: 200px;
        }

        .adoptant-row {
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s ease;
        }

        .adoptant-row:hover {
            background-color: #f9faf9;
        }

        .adoptants-table td {
            padding: 1.2rem 1.5rem;
            vertical-align: middle;
        }

        /* Document Badge */
        .document-badge {
            background: #e3f2fd;
            color: #1976d2;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* User Cell */
        .user-cell {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4CAF50, #81C784);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-cell .name {
            font-weight: 600;
            color: #1a1a1a;
        }

        /* Email Link */
        .email-link {
            color: #2196F3;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .email-link:hover {
            text-decoration: underline;
            color: #1976d2;
        }

        /* Phone Text */
        .phone-text {
            color: #666;
            font-size: 0.9rem;
        }

        /* Address Text */
        .address-text {
            color: #999;
            font-size: 0.9rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.3rem;
            color: #1a1a1a;
            margin: 0 0 0.5rem 0;
        }

        .empty-state p {
            color: #666;
            margin: 0;
            font-size: 0.95rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .col-address {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .adoptants-container {
                padding: 1rem;
            }

            .header-content {
                flex-direction: column;
                width: 100%;
            }

            .header-content h1 {
                font-size: 1.5rem;
            }

            .btn-back {
                margin-right: 0;
                margin-bottom: 1rem;
            }

            .adoptants-table thead {
                display: none;
            }

            .adoptant-row {
                display: grid;
                grid-template-columns: 1fr;
                gap: 1rem;
                padding: 1.5rem;
                border-bottom: 2px solid #f0f0f0;
            }

            .adoptants-table td {
                padding: 0.5rem 0;
                display: block;
                border: none;
            }

            .adoptants-table td:before {
                content: attr(data-label);
                font-weight: bold;
                color: #666;
                display: block;
                margin-bottom: 0.3rem;
            }

            .col-document:before {
                content: "DOCUMENTO";
            }

            .col-name:before {
                content: "NOMBRE";
            }

            .col-email:before {
                content: "EMAIL";
            }

            .col-phone:before {
                content: "TELÉFONO";
            }

            .col-address:before {
                content: "DIRECCIÓN";
                display: block;
            }

            .col-address {
                display: block;
            }
        }
    </style>
@endsection