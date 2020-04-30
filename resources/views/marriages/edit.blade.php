@extends('layouts.app')

@section('content')
    <h3>
        {{ __('marriages.edit_marriage') }}

        <small class="text-lg">[№{{ $marriage->id }}]</small>
        <a
            href="{{ route('marriages.destroy', ['marriage' => $marriage->id]) }}"
            onclick="event.preventDefault();document.getElementById('delete-marriage-form').submit();">
            <small class="text-lg text-red-500">[{{ __('marriages.delete') }}]</small>
        </a>
    </h3>

    <form
        id="delete-marriage-form" method="POST" style="display: none"
        action="{{ route('marriages.destroy', ['marriage' => $marriage->id]) }}">
        @method('DELETE')
        @csrf
    </form>

    @component('marriages.form', ['marriage' => $marriage, 'action' => 'edit']) @endcomponent
@endsection
