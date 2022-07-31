@extends('layouts.app')

@section('content')
    <h1>Edit</h1>
    {{--{!! Form::open(['route' => 'lists_store']) !!}--}}
    <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{url('lists/update/' . $list->id)}}">
        @method('PATCH')
        @include('check_list._form')
    </form>
    {{--{!! Form::close() !!}--}}

@endsection
