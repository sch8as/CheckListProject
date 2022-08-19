@extends('layouts.app')

@section('content')
    <h1>Create</h1>
    @if (isset($message))
        <div class="alert alert-danger">
            {{ $message }}
        </div>
    @endif
    <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{ route('lists.store') }}">
        @include('check_list._form')
    </form>


@endsection

