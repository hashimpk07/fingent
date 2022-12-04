@extends('dashboard')
@section('content')
<!-- /.card-header -->
<div class="card-header">
    <button type="button" class="btn btn-info" style="float: right"; onclick="window.location='{{ URL::route('students.add'); }}'" ><i class="fa fa-plus"></i> Add Students </button>
</div>
<div class="card-body">
    <h5> Students Table</h5>
    <?php
    if( 0  != $students->total() ){?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Reporting Teacher</th>
                <th style="width:166px">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $i = ($students->perPage() * ($students->currentPage() - 1)) + 1; ?>
            @foreach($students as $student)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->age }}</td>
                <td>{{ $student->gender }}</td>
                <td>{{ $student->teachers->name }}</td>
                <td>
                    <a class="btn"  title="edit" href="{{ route('students.edit', ['id' => $student->id]) }}"  ><i class="fas fa-edit"></i></a>
                    <a class="btn" title="delete" onclick="return confirm('Are you sure to detete plan {{ $student->name }} ?')"  href="{{ route('students.delete', ['id' => $student->id]) }}" ><i class="fas fa-times"></i></a>
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
        {!! $students->links('pagination::bootstrap-4') !!}
    </ul>
</div>
@endsection