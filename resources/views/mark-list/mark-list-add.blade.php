@extends('dashboard')
@section('content')

<div class="card-header">
    <button type="button" class="btn btn-info" style="float: right"; onclick="window.location='{{ URL::route('mark-list'); }}'" ><i class="fa fa-arrow-left"></i> Back </button>
</div>
<div class="card-body">
   <h5>  New Mark List Add Page</h5>
</div>
<div style="color: green;margin-left: 26px;display:none;" class="pop-outer">
    <div class="pop-inner">
        <h2 class="pop-heading">Mark List Added Successfully</h2>
    </div>
</div> 
<p id="markListsErr" style="color: red;margin-left: 26px;"></p>
<form action="javascript:void(0)" id="studentsAddForm" name="studentsAddForm"  method="post">
    <div class="card-body">

        <div class="form-group">
            <label for="studentName">  Name <span style="color:#ff0000">*</span></label>
            <select class="form-control" id="studentName" name="studentName"> 
                <option value="0">Select Students</option>
                @foreach ($students as $student)
                <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach                            
            </select>
            <div class="error" id="studentNameErr"></div>
        </div>

        <div class="form-group">
            <label for="maths">Mathematics <span style="color:#ff0000">*</span></label>
            <input type="text" name="maths" class="form-control" id="maths" placeholder="Enter Mathematics Mark" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"  >
            <div class="error" id="mathsErr"></div>
        </div>

        <div class="form-group">
            <label for="science"> Science <span style="color:#ff0000">*</span></label>
            <input type="text" name="science" class="form-control" id="science" placeholder="Enter Science Mark" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" >
            <div class="error" id="scienceErr"></div>
        </div>

        <div class="form-group">
            <label for="history"> History <span style="color:#ff0000">*</span></label>
            <input type="text" name="history" class="form-control" id="history" placeholder="Enter History Mark" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" >
            <div class="error" id="historyErr"></div>
        </div>

        <div class="form-group">
            <label for="terms"> Terms <span style="color:#ff0000">*</span></label>
            <select class="form-control" id="terms" name="terms"> 
                <option value="0">Select Terms</option>
                <option value="1"> 1st Term</option>
                <option value="2"> 2nd Term</option>
                <option value="3"> 3rd Term</option>
            </select>
            <div class="error" id="termsErr"></div>
        </div>

    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <button type="submit" class="mark-list-add btn btn-submit btn-primary" id="mark-list-add">Save</button>
    </div>
</form>
                                          
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script type="text/javascript">  
       $(document).on('click', '.mark-list-add', function (e) {
        
        
        $('#studentName').change(function(e) {
            var name = $(this,':selected').val();
            if( 0 != name ){
                $('#studentNameErr').hide();
            }else{
                $('#studentNameErr').show();
            }

        });

        $('#terms').change(function(e) {
            var termsName = $(this,':selected').val();
            if( 0 != termsName ){
                $('#termsErr').hide();
            }else{
                $('#termsErr').show();
            }

        });
        $('#maths').on('input', function() {
            $('#mathsErr').hide();
        });
        $('#science').on('input', function() {
            $('#scienceErr').hide();
        });
        $('#history').on('input', function() {
            $('#historyErr').hide();
        });
        var projectFlag  = 0;

        var science       = $("#science").val();
        var maths         = $("#maths").val();
        var history       = $("#history").val();
        var studentName   = $("#studentName option:selected").val();
        var terms         = $("#terms option:selected").val();

        if( 0 == studentName || "" == studentName ){
            $("#studentNameErr").html("Please Select student Name");
            projectFlag = 1;
        }

        if( science == "") {
            $('#scienceErr').show();
            $("#scienceErr").html("Please Enter Science Mark");
            projectFlag = 1;
        }else  if( science >= 100) {
            $('#scienceErr').show();
            $("#scienceErr").html("Inavlid Science Mark");
            projectFlag = 1;
        }

        if( maths == "") {
            $('#mathsErr').show();
            $("#mathsErr").html("Please Enter Mathematics Mark");
            projectFlag = 1;
        }else  if( maths >= 100) {
            $('#mathsErr').show();
            $("#mathsErr").html("Inavlid Mathematics Mark");
            projectFlag = 1;
        }

        if( history == "") {
            $('#historyErr').show();
            $("#historyErr").html("Please Enter HistoryErr Mark");
            projectFlag = 1;
        }else  if( history >= 100) {
            $('#historyErr').show();
            $("#historyErr").html("Inavlid History Mark");
            projectFlag = 1;
        }

        if( 0 == terms || "" == terms ){
            $("#termsErr").html("Please Select Terms ");
            projectFlag = 1;
        }

        if( 1 == projectFlag ){
            return false;
        }else{

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#markListsErr").text('');
            $.ajax({
                url:"{{ route('mark-list.create') }}",
                type: "POST",
                dataType: "json",
                data:{ 
                    science:science,
                    maths:maths,
                    history:history,
                    terms:terms,
                    studentName:studentName,
                },
                success:function(data){
                    if( data.status == 'success' ){
                        $(".pop-outer").fadeIn("slow");
                        setTimeout(function () {
                            window.location = '{{ route('mark-list') }}'
                        }, 2500);
                    }else{
                        $("#markListsErr").text(data.message);
                        $("#studentName").focus();
                    }
                    
                },
                error: function(response) {
                    
                }
            });
        }
    });
       

</script>

</script>
@endsection