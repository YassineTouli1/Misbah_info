
<?php if($errors->any()): ?>
    <div class="bg-red-100 p-2 rounded text-red-800 text-sm">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\pc\Downloads\snack_app_rupture_stock\snack_app\resources\views/components/form-error.blade.php ENDPATH**/ ?>