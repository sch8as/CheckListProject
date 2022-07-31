@extends('layouts.app')

@section('content')
    <h1>Create</h1>
    @if (isset($note))
        <div class="alert alert-danger">
            {{ $note }}
        </div>
    @endif
    <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{url('lists/store')}}">
        @include('check_list._form')
    </form>
    {{--{!! Form::close() !!}--}}

@endsection

