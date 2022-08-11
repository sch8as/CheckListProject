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
                        <a class="btn btn-primary" href="{{ route('lists.show', ['list' => $checkList->id]) }}">Show</a>
                    </td>
                    <td class="fit" scope="row">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                ☰
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="{{ route('lists.edit', ['list' => $checkList->id]) }}">Edit</a></li>
                                <li>
                                    <form action="{{ route('lists.destroy', ['list' => $checkList->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item" title="Delete">Delete</button>
                                    </form>
                                </li>
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

    <td><a class="btn btn-primary" href="{{ route('lists.create') }}">New</a></td>

@endsection

@section('styles')
    <style>
        .fit{
            white-space: nowrap;
            width: 1%;
        }
    </style>
@endsection
