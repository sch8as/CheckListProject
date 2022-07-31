@extends('layouts.app')

@section('content')
    @if(count($checkLists))
    <table class="table table-striped ">

        <tbody>
            @foreach($checkLists as $checkList)
                <tr>
                    <td class="fit" scope="row">
                        {{$checkList->title}}
                    </td>

                    <td class="fit" scope="row">
                        <a class="btn btn-primary" href="{{ url('elements/'.$checkList->id) }}">Show</a>
                    </td>
                    <td class="fit" scope="row">
                        <div class="dropdown">
                          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            ☰
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="{{ url('/get/'.$checkList->id) }}">Show</a></li>
                            <li><a class="dropdown-item" href="{{ url('/lists/edit/'.$checkList->id) }}">Edit</a></li>
                            <li><a class="dropdown-item" href="{{ url('/lists/delete/'.$checkList->id) }}">Delete</a></li>
                          </ul>
                        </div>
                    </td>
                    <td scope="row">
                        {{$checkList->description}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{--{{$checkLists->links()}}--}}
    @else
        <h4>There has no lists</h4>
    @endif

    <td><a class="btn btn-primary" href="{{ route('lists_create') }}">New</a></td>

@endsection

@section('styles')
    <style>
        .fit{
            white-space: nowrap;
            width: 1%;
        }
    </style>
@endsection
