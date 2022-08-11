@extends('layouts.app')

@section('content')
    <div class="d-flex">
        <a class="btn btn-primary mb-2" href="{{route('lists.index')}}"> Back </a>
       <h2 style="margin-left: 20px">{{$checkList->title}}</h2>
    </div>

    @if(count($checkElements))
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">CheckBox</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($checkElements as $checkElement)
                    <tr>
                        <td scope="row">
                            <input class="form-check-input" type="checkbox" id="checked{{$checkElement->id}}" name="checked" {{ ($checkElement->checked) ? "checked" : ""; }}>
                            <label class="form-check-label" for="flexCheckDefault">
                                {{$checkElement->title}}
                            </label>
                        </td>
                        <td scope="row">
                            <a class="btn btn-primary" href="{{ route('elements.destroy', ['element' => $checkElement->id]) }}">Delete</a>
                        </td>
                        <script>
                            document.getElementById('checked{{$checkElement->id}}').addEventListener('change', (event) => {
                                fetch_submit({{$checkElement->id}}, event.currentTarget.checked);
                            })
                        </script>

                    </tr>
                @endforeach
            </tbody>
        </table>


    @else
        <h4>There has no elements</h4>
    @endif

    <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{route('elements.store')}}">
        @csrf
        <div class="row">
            <input type="hidden" id="text" name="check_list_id" class="form-control mb-3" value="{{$checkList->id}}" >
            <div class="col">
                <input type="text" id="title" name="title" class="form-control mb-3" >
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary mb-2">Add</button>
            </div>
        </div>
    </form>
    <script>
        function fetch_submit(id, checked)
        {
            (async() => {
                let response = await fetch('{{route('elements.update_checked')}}',{
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": '{{ csrf_token() }}'
                    },
                    credentials: "same-origin",
                    body: JSON.stringify({
                        id: id,
                        checked: (checked ? 1 : 0)
                    })
                });
                if (response.ok == false) { // если HTTP-статус в диапазоне 200-299
                    alert("Ошибка HTTP: " + response.status);
                    location.reload(); return false;
                }
            })();
        }
    </script>
@endsection

