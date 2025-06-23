@extends('layouts.base')

@section('title', $title)

@section('content')
    <div class="page">
        <x-frontend.header />
        <x-frontend.content :page-title="$pageTitle" :page-pretitle="$pagePretitle ?? null">

            <x-slot name="button">
                {{ $button ?? '' }}
            </x-slot>

            {{ $slot }}
        </x-frontend.content>
    </div>
@endsection
