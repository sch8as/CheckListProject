 @extends('layouts.app')

 @section('content')

    <form name="add-blog-post-form" id="add-blog-post-form" class="form-inline" method="get" action="{{ route('users.index', ['filter' => $filter]) }}" >
        <div class="row">
            <div class="col">
                <input type="text" id="filter" name="filter" class="form-control mb-3" value="{{$filter}}">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary mb-2">Filter</button>
            </div>
        </div>
    </form>

    @if(count($users))
     <table class="table table-striped ">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Actions</th>
                <th scope="col"></th>
            </tr>
        </thead>
         <tbody>
             @foreach($users as $item)
                 <tr>
                     <td class="fit" scope="row">
                         {{$item->name}}
                     </td>

                     <td class="fit" scope="row">
                         {{$item->email}}
                     </td>



                     <td class="fit" scope="row">
                         <a class="btn btn-primary" href="{{ route('users.show', ['user' => $item->id]) }}">Show</a>
                     </td>

                     <td scope="row">
                        @foreach($item->getRoleNames() as $v)
                            <h4><span class="badge bg-dark">{{$v}}</span></h4>
                        @endforeach
                        @if($item->status == 0)
                            <h4><span class="badge bg-danger">Banned</span></h4>
                        @endif

                     </td>
                 </tr>
             @endforeach
         </tbody>
     </table>

     @else
        <h4>Users not founded</h4>
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
