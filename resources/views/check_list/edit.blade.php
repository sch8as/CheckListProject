@extends('layouts.app')

@section('content')
    <h1>Edit</h1>

    <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{ route('lists.update', ['list' => $checkList->id])  }}">
        @method('PATCH')
        @include('check_list._form')
    </form>


@endsection
