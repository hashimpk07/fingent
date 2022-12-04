@extends('dashboard')
@section('content')
<div class="card-header">
    <button type="button" class="btn btn-info" style="float: right"; onclick="window.location='{{ URL::route('teachers'); }}'" ><i class="fa fa-arrow-left"></i> Back </button>
</div>
<div class="card-body">
   <h5>  Edit Teacher Page</h5>
</div>

<div style="color: green;margin-left: 26px;display:none;" class="pop-outer">
    <div class="pop-inner">
        <h2 class="pop-heading">Teacher Updated Successfully</h2>
    </div>
</div> 

<form action="javascript:void(0)" id="teacherForm" name="teacherForm"  method="post">
    <div class="card-body">
        <div class="form-group">
            <input type="hidden" name="teacher_id" class="form-control" id="teacher_id"  value="{{$teachers->id}}" >
            <label for="teacher"> Name <span style="color:#ff0000">*</span></label>
            <input type="text" name="teacher" class="form-control" id="teacher" placeholder="Enter Teacher" value="{{$teachers->name}}" >
            <div class="error" id="teacherErr"></div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <button type="submit" class="teacherForm-edit btn btn-submit btn-primary" id="teacherForm-edit">Save</button>
    </div>
</form>
                                       
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script type="text/javascript">  
        $( function() {     
            $('#teacher').on('input', function() {
                $('#teacherErr').hide();
            });
        });

        $(document).on('click', '.teacherForm-edit', function (e) {
        
        $('#teacher').on('input', function() {
            $('#teacherErr').hide();
        });
       
        var flag  = 0;
        var teacher     = $("#teacher").val();
        var id          = $("#teacher_id").val();
    
        if(teacher == "") {
            $("#teacherErr").html("Please Enter Name");
            flag = 1;
        }
        
        if( 1 == flag ){
            return false;
        }else{
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:"{{ route('teachers.update') }}",
                type: "POST",
                dataType: "json",
                data:{ 
                    id :id,
                    teacher:teacher,
                },
                success:function(data){
                    if( data.status == 'success' ){
                        $(".pop-outer").fadeIn("slow");
                        setTimeout(function () {
                            window.location = '{{ route('teachers') }}'
                        }, 2500);
                    }else{
                        $("#teacherErr").html("Data Not Saved ! Please check Data");
                    }
                    
                },
                error: function(response) {
                    
                }
                 
            });
        }
    });
       

</script>
