<?php
$savedFields = !empty($fieldsorder) ? array_unique($fieldsorder) : [];
$allFields = $tablefield->pluck('field.name')->toArray();
$remainingFields = array_diff($allFields, $savedFields);
?>
<input type="hidden" name="emp_id" id="emp_id" value="<?php echo e($emp->id); ?>">
<ul id="sortableFields" class="list-group mb-3">
    <?php $__currentLoopData = $savedFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fieldName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li class="list-group-item d-flex align-items-center justify-content-between" data-key="<?php echo e($fieldName); ?>">
        <div class="d-flex align-items-center gap-2">
            <i class="ti ti-menu-2 text-muted drag-handle"></i>
            <input type="checkbox" class="field-checkbox" value="<?php echo e($fieldName); ?>" checked>
            <span><?php echo e($fieldName); ?></span>
        </div>
    </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php $__currentLoopData = $remainingFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fieldName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li class="list-group-item d-flex align-items-center justify-content-between" data-key="<?php echo e($fieldName); ?>">
        <div class="d-flex align-items-center gap-2">
            <i class="ti ti-menu-2 text-muted drag-handle"></i>
            <input type="checkbox" class="field-checkbox" value="<?php echo e($fieldName); ?>">
            <span><?php echo e($fieldName); ?></span>
        </div>
    </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/partials/serialize_lead.blade.php ENDPATH**/ ?>