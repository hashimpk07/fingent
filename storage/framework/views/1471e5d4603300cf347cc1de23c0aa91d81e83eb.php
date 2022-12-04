
<?php $__env->startSection('content'); ?>

<div class="card-header">
    <button type="button" class="btn btn-info" style="float: right"; onclick="window.location='<?php echo e(URL::route('teachers')); ?>'" ><i class="fa fa-arrow-left"></i> Back </button>
</div>
<div class="card-body">
   <h5>  New Teachers Add Page</h5>
</div>
<div style="color: green;margin-left: 26px;display:none;" class="pop-outer">
    <div class="pop-inner">
        <h2 class="pop-heading">Teacher Added Successfully</h2>
    </div>
</div> 

<form action="javascript:void(0)" id="teachersForm" name="teachersForm-add"  method="post">
    <div class="card-body">
        <div class="form-group">
            <label for="teachers">  Name <span style="color:#ff0000">*</span></label>
                <input type="text" name="teacher" class="form-control" id="teacher" placeholder="Enter Teachers Name ">
            <div class="error" id="teacherErr"></div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <button type="submit" class="teachersForm-add btn btn-submit btn-primary" id="teachersForm-add">Save</button>
    </div>
</form>
                                          
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script type="text/javascript">  
        $( function() {     
            $('#teacher').on('input', function() {
                $('#teacherErr').hide();
            });
        });

        $(document).on('click', '.teachersForm-add', function (e) {
        
        $('#teacher').on('input', function() {
            $('#teacherErr').hide();
        });
       
        var flag         = 0;
        var teacher      = $("#teacher").val();
    
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
                url:"<?php echo e(route('teachers.create')); ?>",
                type: "POST",
                dataType: "json",
                data:{ 
                    teacher:teacher,
                },
                success:function(data){
                    if( data.status == 'success' ){
                        $(".pop-outer").fadeIn("slow");
                        setTimeout(function () {
                            window.location = '<?php echo e(route('teachers')); ?>'
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Project\Fingent\resources\views/teachers/teachers-add.blade.php ENDPATH**/ ?>