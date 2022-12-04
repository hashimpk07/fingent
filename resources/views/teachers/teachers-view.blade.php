@extends('dashboard')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="card-header">
    <button type="button" class="btn btn-info" style="float: right"; onclick="window.location='{{ URL::route('teachers'); }}'" ><i class="fa fa-arrow-left"></i> Back </button>
</div>
<div class="card-body">
   <h5>  View Teacher Page</h5>
</div>


<form action="javascript:void(0)" id="teacherForm" name="teacherForm"  method="post">
    <div class="card-body">
        <div class="form-group">
            <label for="teacher"> Name <span style="color:#ff0000">*</span></label>
            <input type="text" name="teacher" class="form-control" id="teacher" placeholder="Enter Teacher" value="{{$teachers->name}}" readonly>
            <div class="error" id="teacherErr"></div>
        </div>
    </div>
    <!-- /.card-body -->
</form>            
@endsection