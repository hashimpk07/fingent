@extends('dashboard')
@section('content')
<!-- /.card-header -->
<div class="card-header">
    <button type="button" class="btn btn-info" style="float: right"; onclick="window.location='{{ URL::route('mark-list.add'); }}'" ><i class="fa fa-plus"></i> Add Mark List </button>
</div>
<div class="card-body">
    <h5> Students Mark List Table</h5>
    <?php
    if( 0  != $markLists->total() ){?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Name</th>
                <th>Maths</th>
                <th>Science</th>
                <th>History</th>
                <th>Term</th>
                <th>Total Marks</th>
                <th>Created On</th>
                <th style="width:166px">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $i = ($markLists->perPage() * ($markLists->currentPage() - 1)) + 1; ?>
            @foreach($markLists as $markList)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $markList->students->name }}</td>
                <td>{{ $markList->maths }}</td>
                <td>{{ $markList->science }}</td>
                <td>{{ $markList->history }}</td>
                <td>{{ $markList->terms }}</td>
                <td>{{ $markList->total_marks }}</td>
                <td>{{ $markList->created }}</td>
                <td>
                    <a class="btn"  title="edit" href="{{ route('mark-list.edit', ['id' => $markList->id]) }}"  ><i class="fas fa-edit"></i></a>
                    <a class="btn" title="delete" onclick="return confirm('Are you sure to detete this mark list ?')"  href="{{ route('mark-list.delete', ['id' => $markList->id]) }}" ><i class="fas fa-times"></i></a>
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
        {!! $markLists->links('pagination::bootstrap-4') !!}
    </ul>
</div>
@endsection