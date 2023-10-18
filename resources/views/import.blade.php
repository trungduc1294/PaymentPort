<form action="{{url('import-excel')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">
    <input type="submit" value="Import" name="submit">
</form>
