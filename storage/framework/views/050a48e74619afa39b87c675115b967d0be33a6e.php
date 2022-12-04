
<?php $__env->startSection('content'); ?>

<div class="card-header">
    <button type="button" class="btn btn-info" style="float: right"; onclick="window.location='<?php echo e(URL::route('color')); ?>'" ><i class="fa fa-arrow-left"></i> Back </button>
</div>
<div class="card-body">
   <h5>  Details Colors Page</h5>
</div>
<form action="javascript:void(0)" id="colorForm" name="colorForm"  method="post">
    
    <div class="card-body">
        <div class="form-group">
            <label for="color"> Color <span style="color:#ff0000">*</span></label>
                <input type="text" name="color" class="form-control" id="color" placeholder="Enter Color" value="<?php echo e($color->name); ?>" readonly>
            <div class="error" id="colorErr"></div>
        </div>
    </div>
    <!-- /.card-body -->
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Project\TimesworldTechnology\resources\views/color/color-show.blade.php ENDPATH**/ ?>