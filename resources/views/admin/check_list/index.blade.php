@extends('layouts.app')

@section('content')
    <form name="add-blog-post-form" id="add-blog-post-form" class="form-inline" method="get" action="{{ route('admin.lists.index', ['filter' => $filter]) }}" >
        <div class="row">
            <div class="col">
                <input type="text" id="filter" name="filter" class="form-control mb-3" value="{{$filter}}">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary mb-2">Filter</button>
            </div>
        </div>
    </form>

    @if(count($checkLists))
        <table class="table table-striped ">
            <thead>
                <tr>
                    <th scope="col">User</th>
                    <th scope="col"></th>
                    <th scope="col">List title</th>
                    <th scope="col">Element title</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($checkLists as $checkList)
                    <tr>
                        <td class="fit" scope="row">
                            <a class="btn btn-primary" href="{{ route('admin.users.show', ['user' => $checkList->user->id]) }}">{{$checkList->user->name}}</a>
                        </td>
                        <td class="fit" scope="row">
                            {{$checkList->user->email}}
                            @if($checkList->user->status == 0)
                                (Banned)
                            @endif
                        </td>

                        <td class="fit" scope="row">
                            {{$checkList->title}}
                        </td>

                        <td scope="row">
                            @foreach($checkList->checkElements as $element)
                                <p>{{$element->title}}</p>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <h4>Elements not founded</h4>
    @endif

@endsection

@section('styles')
    <style>
        .fit{
            white-space: nowrap;
            width: 1%;
        }
    </style>
@endsection
