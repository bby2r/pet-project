@extends('layouts.app')

@section('content')
    <input type="file" ref="uploadFile" hidden>
    <button class="btn btn-primary cursor-pointer" @click="$refs.uploadFile.click()">Upload file</button>

    <ol>
        @foreach($urls as $name => $base64)
            <li><a href="{{ route('show-file', $base64) }}">{{ $name }}</a></li>
        @endforeach
    </ol>
@endsection
