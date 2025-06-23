@extends('layouts.base')

@section('title', $title)

@section('content')
    <div class="page">
        <x-backend.sidebar />
        <x-backend.header />
        <x-backend.content :page-title="$pageTitle" :page-pretitle="$pagePretitle ?? null">

            <x-slot name="button">
                {{ $button ?? '' }}
            </x-slot>

            {{ $slot }}
        </x-backend.content>
    </div>
@endsection
