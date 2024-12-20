@extends('layouts.app')

@section('title', 'Control de Finanzas Personales')

@section('content')

    {{-- Hero Section --}}
    @include('components.home.hero')

    {{-- Overview Section --}}
    @include('components.home.overview')

    {{-- Benefits Section --}}
    @include('components.home.benefits', [
        'benefits' => [
            [
                'title' => 'Gestión de Ingresos',
                'description' => 'Lleva un registro detallado de tus entradas de dinero. Visualiza tus fuentes de ingresos y toma
                                            decisiones más sabias.',
                'bgColor' => 'bg-blue-100',
                'textColor' => 'text-blue-900',
            ],
            [
                'title' => 'Control de Egresos',
                'description' =>
                    'Mantén un control preciso de tus gastos mensuales. ¡Descubre oportunidades para ahorrar!',
                'bgColor' => 'bg-teal-100',
                'textColor' => 'text-teal-900',
            ],
            [
                'title' => 'Alcance de Metas',
                'description' => 'Define tus metas financieras y hazlas realidad. Realiza un seguimiento detallado y ajusta tus
                                        estrategias',
                'bgColor' => 'bg-yellow-100',
                'textColor' => 'text-yellow-900',
            ],
        ],
    ])

    {{-- Progress Section --}}
    @include('components.home.progress')

    {{-- Testimonials Section --}}
    @include('components.home.testimonials', [
        'testimonials' => [
            [
                'text' => '"Gracias a esta herramienta, pude ordenar mis finanzas y ahorrar para
                                        mi futuro. ¡Totalmente recomendada!"',
                'author' => 'Juan Pérez',
            ],
            [
                'text' => '"Lo mejor es la visualización de mis gastos e ingresos, ¡ahora tengo
                                        control total!"',
                'author' => 'María González',
            ],
        ],
    ])

    {{-- Call to Action Section --}}
    @include('components.home.cta')

@endsection
