@extends('dashboard')
@section('content')

<!-- /.card-header -->
<div class="card-header">
    <button type="button" class="btn btn-info" style="float: right"; onclick="window.location='{{ URL::route('teachers.add'); }}'" ><i class="fa fa-plus"></i> Add Teachers </button>
</div>
<div class="card-body">
    <h5> Teachers Table</h5>
    <?php
    if( 0  != $teachers->total() ){?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th style="width: 250px">Name</th>
                <th style="width: 30px">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $i = ($teachers->perPage() * ($teachers->currentPage() - 1)) + 1; ?>
            @foreach($teachers as $teacher)
            <tr>
                <td >{{ $i++ }}</td>
                <td > {{ $teacher->name }} </td>
                <td>
                    <a class="btn"  title="edit" href="{{ route('teachers.edit', ['id' => $teacher->id]) }}"  ><i class="fas fa-edit"></i></a>
                    <a class="btn" title="view" href="{{ route('teachers.show', ['id' => $teacher->id]) }}" ><i class="fas fa-eye"></i></a>
                    <a class="btn" title="delete" onclick="return confirm('Are you sure to detete plan {{ $teacher->name }} ?')"  href="{{ route('teachers.delete', ['id' => $teacher->id]) }}" ><i class="fas fa-times"></i></a>
                </td>
            </tr>
            @endforeach 
        </tbody>
    </table>
</div>
<?php } else{?> 
<img src="{{url('/images/norecordfound.png')}}" class="no-data-found" style="width: 100%;" />
    <?php } ?>
</div>
<!-- /.card-body -->
<div class="card-footer clearfix">
    <ul class="pagination pagination-sm m-0 float-right">
        {!! $teachers->links('pagination::bootstrap-4') !!}
    </ul>
</div>
@endsection