<div class="table-responsive">
    <table class="table table-hover table-bordered table-striped" id="datalistTable">
        <thead>
            <tr class="bg-light">                                                      
                
                <?php
                    $columns = !empty($fieldsorder) ? array_unique($fieldsorder) : $tablefield->pluck('field.name')->toArray();
                ?>

                <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e($col); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                        
            </tr>
        </thead>

        <tbody>
            <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rowSet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $groupId = $rowSet['form_group_id'];
                    $leadRows    = collect($rowSet['lead'])->keyBy('field_name');
                    $meetingRows = collect($rowSet['meeting'])->keyBy('label');
                    $platform    = strtolower(optional($meetingRows->firstWhere('label', 'Platform'))->value ?? '');
                ?>

                <tr>                                                          
                    
                    <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $leadRec    = $leadRows[$col] ?? null;
                            $meetingRec = $meetingRows[$col] ?? null;
                        ?>

                        <td>
                            
                            <?php if($leadRec): ?>
                                <?php if($leadRec->field_name === 'Site Name'): ?>
                                    <a href="javascript:void(0)" class="text-primary viewLeadBtn" data-group="<?php echo e($groupId); ?>">
                                        <?php echo e($leadRec->field_value); ?>

                                    </a>
                                <?php elseif($leadRec->field_name === 'Lead Type'): ?>
                                    <?php
                                        $type = strtolower($leadRec->field_value);
                                        $badgeClass = $type === 'private' ? 'bg-warning text-dark' : ($type === 'global' ? 'bg-success' : 'bg-secondary');
                                    ?>
                                    <span class="badge <?php echo e($badgeClass); ?>"><?php echo e(ucfirst($leadRec->field_value)); ?></span>
                                <?php elseif(Str::endsWith($leadRec->field_value, ['jpg','jpeg','png','gif','webp'])): ?>
                                    <img src="<?php echo e(asset($leadRec->field_value)); ?>" width="50">
                                <?php elseif(Str::endsWith($leadRec->field_value, 'pdf')): ?>
                                    <a href="<?php echo e(asset($leadRec->field_value)); ?>" target="_blank" class="btn btn-sm btn-danger">View PDF</a>
                                <?php else: ?>
                                    <?php echo e($leadRec->field_value ?? '-'); ?>

                                <?php endif; ?>

                            
                            <?php elseif($meetingRec): ?>
                                <?php if($meetingRec->label === 'Meeting Status'): ?>
                                    <span class="badge bg-warning"><?php echo e(ucfirst($meetingRec->value)); ?></span>
                                <?php elseif(in_array($meetingRec->label, ['Next Meeting Date','Platform'])): ?>
                                    <?php
                                        $date = $meetingRec->value ?? null;
                                    ?>
                                    
                                    <?php if(!empty($date) && $date != 'NULL'): ?>
                                        <?php echo e(\Carbon\Carbon::parse($date)->format('d-M-y (D)')); ?>

                                    <?php else: ?>
                                        -
                                    <?php endif; ?>                                                
                                    <br>
                                    <span class="badge bg-info"><?php echo e($rowSet['meeting_count']); ?></span>
                                    <?php if($platform === 'desktop'): ?>
                                        <i class="fa fa-desktop text-success" title="Desktop"></i>
                                    <?php elseif($platform === 'mobile'): ?>
                                        <i class="fa fa-mobile-alt text-success" title="Mobile"></i>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php echo e($meetingRec->value ?? '-'); ?>

                                <?php endif; ?>

                            
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                                                                                    
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>    <?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/partials/lead_list.blade.php ENDPATH**/ ?>