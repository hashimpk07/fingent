
<?php $__env->startSection('content'); ?>
<!-- /.card-header -->
<div class="card-header">
    <button type="button" class="btn btn-info" style="float: right"; onclick="window.location='<?php echo e(URL::route('students.add')); ?>'" ><i class="fa fa-plus"></i> Add Students </button>
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
            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($i++); ?></td>
                <td><?php echo e($student->name); ?></td>
                <td><?php echo e($student->age); ?></td>
                <td><?php echo e($student->gender); ?></td>
                <td><?php echo e($student->teachers->name); ?></td>
                <td>
                    <a class="btn"  title="edit" href="<?php echo e(route('students.edit', ['id' => $student->id])); ?>"  ><i class="fas fa-edit"></i></a>
                    <a class="btn" title="delete" onclick="return confirm('Are you sure to detete plan <?php echo e($student->name); ?> ?')"  href="<?php echo e(route('students.delete', ['id' => $student->id])); ?>" ><i class="fas fa-times"></i></a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
        </tbody>
    </table>
</div>
<?php } else{?> 
<img src="<?php echo e(url('/images/norecordfound.png')); ?>" class="no-data-found" style="width: 100%;" />
    <?php } ?>
</div>
<!-- /.card-body -->
<div class="card-footer clearfix">
    <ul class="pagination pagination-sm m-0 float-right">
        <?php echo $students->links('pagination::bootstrap-4'); ?>

    </ul>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Project\Fingent\resources\views/students/students-list.blade.php ENDPATH**/ ?>