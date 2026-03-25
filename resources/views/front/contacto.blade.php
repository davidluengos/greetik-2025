@extends('front.layouts.app')

@section('title', $page->meta_title ?: 'Greetik | ' . $page->title)

@section('content')
    @php
        $x = $page->extra ?? [];
        $phones = $x['phones'] ?? [];
        if (!is_array($phones)) {
            $phones = [];
        }
    @endphp

    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-4">
                    <h1>{{ $page->title }}</h1>
                </div>
                <div class="col-lg-8 col-sm-8">
                    <ol class="breadcrumb pull-right">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="active">{{ $page->title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-5 address">
                @if (!empty($x['address_title']) || !empty($x['address']))
                    <section class="contact-infos">
                        @if (!empty($x['address_title']))
                            <h4 class="title custom-font text-black">{{ $x['address_title'] }}</h4>
                        @endif
                        @if (!empty($x['address']))
                            <address>{!! nl2br(e($x['address'])) !!}</address>
                        @endif
                    </section>
                @endif
                @if (!empty($x['hours_title']) || !empty($x['hours']))
                    <section class="contact-infos">
                        @if (!empty($x['hours_title']))
                            <h4 class="title custom-font text-black">{{ $x['hours_title'] }}</h4>
                        @endif
                        @if (!empty($x['hours']))
                            <p>{!! nl2br(e($x['hours'])) !!}</p>
                        @endif
                    </section>
                @endif
                @if (!empty($x['phones_title']) || $phones !== [])
                    <section class="contact-infos">
                        @if (!empty($x['phones_title']))
                            <h4>{{ $x['phones_title'] }}</h4>
                        @endif
                        @foreach ($phones as $phone)
                            <p><i class="fa fa-phone"></i> {{ $phone }}</p>
                        @endforeach
                    </section>
                @endif
            </div>
            <div class="col-lg-7 col-sm-7 address">
                @if (!empty($page->body))
                    <div class="contact-intro mar-b-30">
                        {!! $page->body !!}
                    </div>
                @endif
                <div class="contact-form">
                    @include('front.partials.dynamic-product-form', ['formModel' => $formModel, 'idPrefix' => 'contacto'])
                </div>
            </div>
        </div>
    </div>

    @if (!empty($x['map_embed']))
        <div class="contact-map mar-t-30">
            {!! $x['map_embed'] !!}
        </div>
    @endif
@endsection
