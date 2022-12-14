@extends('layouts.app')

@section('content')


    <table class="table table-striped ">
        <tbody>

            <tr>
                <td scope="col">Name</td>
                <td scope="col">{{$user->name}}</td>
            </tr>
            <tr>
                <td scope="col">Email</td>
                <td scope="col">{{$user->email}}</td>
            </tr>
        </tbody>
    </table>
    <br>

    @can('update-roles', App\Http\Controllers\Admin\UserController::class)
        <h4>Set roles</h4>
        <?php $roles = $user->getRoleNames(); ?>

        <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{ route('admin.users.update_roles', ['user' =>$user->id]) }}">
            @method('PATCH')
            @csrf
            <div class="mb-3 form-check form-switch">
              <input class="form-check-input" type="checkbox" id="list_reader" name="roles[]" value="list_reader" {{($roles->contains('list_reader'))?("checked"):("")}}>
              <label class="form-check-label" for="flexSwitchCheckDefault">Can read user's lists</label>
            </div>
            <div class="mb-3 form-check form-switch">
              <input class="form-check-input" type="checkbox" id="list_limiter" name="roles[]" value="list_limiter" {{($roles->contains('list_limiter'))?("checked"):("")}}>
              <label class="form-check-label" for="flexSwitchCheckChecked">Can limit user's lists</label>
            </div>
            <div class="mb-3 form-check form-switch">
              <input class="form-check-input" type="checkbox" id="moderator" name="roles[]" value="moderator" {{($roles->contains('moderator'))?("checked"):("")}}>
              <label class="form-check-label" for="flexSwitchCheckChecked2">Can ban users</label>
            </div>
            <div class="mb-3 form-check form-switch">
              <input class="form-check-input" type="checkbox" id="admin" name="roles[]" value="admin" {{($roles->contains('admin'))?("checked"):("")}}>
              <label class="form-check-label" for="flexSwitchCheckChecked3">Can control admins, moderators, etc.</label>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        <br>
    @endcan

    @can('update-status', App\Http\Controllers\Admin\UserController::class)
        <h4>Set status</h4>
        <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{route('admin.users.update_status', ['user' =>$user->id])}}">
            @method('PATCH')
            @csrf
            <div class="mb-3 form-check form-switch">
              <input class="form-check-input" type="checkbox" id="is_banned" name="is_banned" {{($user->status == App\Models\User::STATUS_BANNED)?("checked"):("")}}>
              <label class="form-check-label" for="flexSwitchCheckDefault">Is banned</label>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        <br>
    @endcan

    @can('update-list-limit', App\Http\Controllers\Admin\UserController::class)
        <h4>Set checklist limit</h4>
        <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{ route('admin.users.update_list_limit', ['user' =>$user->id]) }}">
            @method('PATCH')
            @csrf
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label" >Checklist limit</label>
                <input type="number" class="form-control" id="exampleInputPassword1" name="checklist_limit" value="{{$user->checklist_limit}}">
            </div>
            @if($user->can('have-unlimited-lists', App\Http\Controllers\CheckListController::class))
                <div class="alert alert-info" role="alert">
                    For administrative roles, the number of lists is not limited.
                </div>
            @endif
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        <br>
    @endcan

@endsection
