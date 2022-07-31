@csrf
<div class="mb-3">
    <label for="exampleInputEmail1">Title</label>
    <input type="text" id="title" name="title" class="form-control" required="" value="{{isset($list)?($list->title):("")}}">
</div>
<div class="mb-3">
    <label for="exampleInputEmail1">Description</label>
    <textarea name="description" class="form-control" required="" >{{isset($list)?($list->description):("")}}</textarea>
</div>
<button type="submit" class="btn btn-primary">Save</button>