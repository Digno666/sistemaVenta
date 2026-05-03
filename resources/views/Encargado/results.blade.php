@extends('layouts.encargado-layout')

@section('title', 'Resultados de búsqueda - BODY FIT Encargado')

@section('content')
<div class="search-page">
    <div class="page-header">
        <h1 class="page-title">Resultados de búsqueda</h1>
        <p class="page-description">Mostrando resultados para: <strong>"{{ $query }}"</strong></p>
    </div>

    @if(count($results) > 0)
        <div class="results-grid">
            @foreach($results as $result)
            <a href="{{ $result['url'] }}" class="result-card">
                <div class="result-icon">
                    <i class="{{ $result['icon'] }}"></i>
                </div>
                <div class="result-info">
                    <div class="result-title">{{ $result['title'] }}</div>
                    <div class="result-subtitle">{{ $result['subtitle'] }}</div>
                </div>
            </a>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-search"></i>
            <p>No se encontraron resultados para "{{ $query }}"</p>
            <small>Intenta con otras palabras clave</small>
        </div>
    @endif
</div>

@push('styles')
<style>
    .search-page {
        max-width: 1000px;
        margin: 0 auto;
    }

    .page-header {
        margin-bottom: 32px;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1F2937;
        margin-bottom: 8px;
    }

    .page-description {
        color: #6B7280;
    }

    .results-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .result-card {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px;
        background: white;
        border-radius: 20px;
        border: 1px solid #E8ECEF;
        text-decoration: none;
        transition: all 0.2s;
    }

    .result-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        border-color: #E04545;
    }

    .result-icon {
        width: 50px;
        height: 50px;
        background: rgba(224, 69, 69, 0.1);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .result-icon i {
        font-size: 1.5rem;
        color: #E04545;
    }

    .result-info {
        flex: 1;
    }

    .result-title {
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 4px;
    }

    .result-subtitle {
        font-size: 0.75rem;
        color: #6B7280;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 24px;
        border: 1px solid #E8ECEF;
    }

    .empty-state i {
        font-size: 3rem;
        color: #9CA3AF;
        margin-bottom: 16px;
    }

    .empty-state p {
        color: #6B7280;
        margin-bottom: 8px;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.4rem;
        }
        .results-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
@endsection