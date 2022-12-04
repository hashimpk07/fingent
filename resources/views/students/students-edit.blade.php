@extends('dashboard')
@section('content')

<div class="card-header">
    <button type="button" class="btn btn-info" style="float: right"; onclick="window.location='{{ URL::route('students'); }}'" ><i class="fa fa-arrow-left"></i> Back </button>
</div>
<div class="card-body">
   <h5>  Student Edit Page</h5>
</div>
<div style="color: green;margin-left: 26px;display:none;" class="pop-outer">
    <div class="pop-inner">
        <h2 class="pop-heading">Student Updated Successfully</h2>
    </div>
</div> 

<form action="javascript:void(0)" id="studentsForm" name="studentsForm-add"  method="post">
    <div class="card-body">
        <input type="hidden" name="studentId" id="studentId" value="{{$students->id}}">
        <div class="form-group">
            <label for="teachers"> Name <span style="color:#ff0000">*</span></label>
                <input type="text" name="studentName" class="form-control" id="studentName" placeholder="Enter Students Name" value="{{$students->name}}">
            <div class="error" id="studentNameErr"></div>
        </div>

        <div class="form-group">
            <label for="teachers"> Date Of Birth <span style="color:#ff0000">*</span></label>
            <input type="date" class="form-control datetimepicker-input"  id="dob" name="dob" placeholder="Enter Date Of Birth " value="{{$students->date_birth}}" />           
            <div class="error" id="dobErr"></div>
        </div>

        <div class="form-group">
            <label for="teachers"> Gender <span style="color:#ff0000">*</span></label>
                <input type="radio" value="1" value="1" <?php echo ($students->gender=='1')?'checked':'' ?>  name="gender" style="margin-left:11%"><span> Male </span>                        
                <input type="radio" value="2" <?php echo ($students->gender=='2')?'checked':'' ?> name="gender" style="margin-left:45%"><span> Female </span>          
                <div class="error" id="genderErr"></div>
        </div>

        <div class="form-group">
            <label for="teachersName"> Reporting Teachers  <span style="color:#ff0000">*</span></label>
            <select class="form-control" id="teacherName" name="teacherName"> 
                <option value="0">Select Teachers</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ ( $teacher->id == $students->teachers_id) ? 'selected' : '' }}> 
                    {{ $teacher->name }} 
                    </option>
                @endforeach                                     
            </select>      
            <div class="error" id="teacherNameErr"></div>
        </div>

    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <button type="submit" class="studentForm-edit btn btn-submit btn-primary" id="studentForm-edit">Save</button>
    </div>
</form>
                                          
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script type="text/javascript">  
        $( function() {
            $('#studentName').on('input', function() {
                $('#studentNameErr').hide();
            });

            $('input[type=radio][name=gender]').change(function() {
                $("#genderErr").hide();
            });
        });

        $(document).on('click', '.studentForm-edit', function (e) {
        
            $('#studentName').on('input', function() {
                $('#studentNameErr').hide();
            });
            $('#teacherName').change(function(e) {
                var teacherName = $(this,':selected').val();
                if( 0 != teacherName ){
                    $('#teacherNameErr').hide();
                }else{
                    $('#teacherNameErr').show();
                }

            });
            $('#dob').on('input', function() {
                $('#dobErr').hide();
            });

            var flag  = 0;
            var id            = $("#studentId").val();
            var name          = $("#studentName").val();
            var teacherName   = $("#teacherName option:selected").val();
            var dob           = $("#dob").val();
            var gender        = $('input[name="gender"]:checked').val(); 
        
            if(name == "") {
                $("#studentNameErr").html("Please Enter Student Name");
                flag = 1;
            }

            if( 0 == teacherName || "" == teacherName ){
                $("#teacherNameErr").html("Please Select Teacher Name");
                flag = 1;
            }

            if(dob == "") {
                $("#dobErr").html("Please Enter Date Of Birth");
                flag = 1;
            }

            if( 0 == gender ||  undefined == gender ) {
                $("#genderErr").html("Please Select Gender");
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
                    url:"{{ route('students.update') }}",
                    type: "POST",
                    dataType: "json",
                    data:{ 
                        id :id,
                        name:name,
                        teacherId:teacherName,
                        dob:dob,
                        gender:gender
                    },
                    success:function(data){
                        if( data.status == 'success' ){
                            $(".pop-outer").fadeIn("slow");
                            setTimeout(function () {
                                window.location = '{{ route('students') }}'
                            }, 2500);
                        }else{
                            $("#teacherNameErr").html("Data Not Saved ! Please check Data");
                        }
                    },
                    error: function(response) {
                    }
                });
            }
        });
</script>
@endsection