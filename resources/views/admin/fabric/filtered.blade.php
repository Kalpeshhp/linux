<!-- Grid -->
<?php if(count($fabrics)): ?>
<div class="row">
    <?php $__currentLoopData = $fabrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fabric): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <script>
        localStorage.setItem('AppKey', JSON.stringify(<?php echo json_encode($_SESSION); ?>));
    </script>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-img-actions">
                        <a href="<?php echo e(isset($fabric->bestfit_image)?$fabric->bestfit_image:asset('/images/No-Image.png')); ?>" data-popup="lightbox">
                            <img src="<?php echo e(isset($fabric->thumbnail_image)?$fabric->thumbnail_image:asset('/images/No-Image.png')); ?>" class="card-img" width="96" alt="">
                            <span class="card-img-actions-overlay card-img">
                                <i class="icon-plus3 icon-2x"></i>
                            </span>
                        </a>
                    </div>
                </div>

                <div class="card-body bg-light text-center">
                    <div class="mb-2">
                        <h6 class="font-weight-semibold mb-0">
                            <a href="#" class="text-default"> <?php echo e(!empty($fabric->vendorFabrics->fabric_name)?$fabric->vendorFabrics->fabric_name:$fabric->fabric_name); ?> </a>
                        </h6>

                        <a href="#" class="text-muted"> <?php echo e($fabric->product_type); ?> fabric</a>
                    </div>
                    <div class="add-to-store">
                    <?php if($fabric['vendorFabrics'] ==null): ?>
                    <?php if(isset($fabric['vendorFabrics']) && $fabric['vendorFabrics']['fabric_id'] && $fabric['vendorFabrics']['is_active'] == 1): ?>
                            <label for="<?php echo e($fabric->tailori_fabric_code); ?>" class="btn bg-success-400 <?php echo e($fabric->tailori_fabric_code); ?>"><i class="icon-checkmark2"></i></label>
                            
                            <input type="checkbox" onchange="handleRemove(this);" id="<?php echo e($fabric->fabric_id); ?>" class="remove_fabric"  name="remove_fabric" data-remove-fabric-id="<?php echo e($fabric->tailori_fabric_code); ?>" value="<?php echo e($fabric->tailori_fabric_code); ?>">

                            <label  title='Remove Fabric From Store' for="<?php echo e($fabric->fabric_id); ?>"  data-fabric-sku="<?php echo e($fabric->tailori_fabric_code); ?>" data-fabric-status="in_store" data-fabric-id="<?php echo e($fabric->fabric_id); ?>" class="remove-fabric btn bg-grey-400 <?php echo e($fabric->tailori_fabric_code); ?>"><i class="icon-cross"></i></label>
                        
                        <?php else: ?>
                           <!-- <input type="checkbox" onchange="DeleteFromVendorPanel1(this);" id="<?php echo e($fabric->fabric_id); ?>" class="remove_fabric"  name="remove_fabric" data-remove-fabric-id="<?php echo e($fabric->tailori_fabric_code); ?>" value="<?php echo e($fabric->tailori_fabric_code); ?>">
                            <label for="<?php echo e($fabric->fabric_id); ?>"  data-fabric-sku="<?php echo e($fabric->tailori_fabric_code); ?>" data-fabric-status="in_store" data-fabric-id="<?php echo e($fabric->fabric_id); ?>" class="remove-fabric btn bg-grey-400 <?php echo e($fabric->tailori_fabric_code); ?>"><i class="icon-cross"></i></label> -->
                      <input type="checkbox" onchange="handleChange(this);" class="move_fabric" name="fabric" id="<?php echo e($fabric->tailori_fabric_code); ?>" value="<?php echo e($fabric->tailori_fabric_code); ?>">
                            <label for="<?php echo e($fabric->tailori_fabric_code); ?>" class="btn bg-blue-400 <?php echo e($fabric->tailori_fabric_code); ?>"><i class="icon-cart-add" title='Move Fabric To Store'></i></label>
                        <?php endif; ?>
                            <label class="btn bg-warning" data-fabric-id="<?php echo e($fabric->fabric_id); ?>" data-toggle="modal" data-target="#modal_form_vertical" onclick="getFabric(this)" title='Update Fabric Info'><i class="icon-pen6"></i></label>
                            <?php else: ?>
                            <?php if(isset($fabric['vendorFabrics']) && $fabric['vendorFabrics']['fabric_id'] && $fabric['vendorFabrics']['is_active'] == 1): ?>
                            <label for="<?php echo e($fabric->tailori_fabric_code); ?>" class="btn bg-success-400 <?php echo e($fabric->tailori_fabric_code); ?>"><i class="icon-checkmark2"></i></label>
                            
                            <input type="checkbox" onchange="handleRemove(this);" id="<?php echo e($fabric->fabric_id); ?>" class="remove_fabric"  name="remove_fabric" data-remove-fabric-id="<?php echo e($fabric->tailori_fabric_code); ?>" value="<?php echo e($fabric->tailori_fabric_code); ?>">

                            <label title='Remove Fabric From Store' for="<?php echo e($fabric->fabric_id); ?>"  data-fabric-sku="<?php echo e($fabric->tailori_fabric_code); ?>" data-fabric-status="in_store" data-fabric-id="<?php echo e($fabric->fabric_id); ?>" class="remove-fabric btn bg-grey-400 <?php echo e($fabric->tailori_fabric_code); ?>"><i class="icon-cross"></i></label>
                        
                        <?php else: ?>
                            <?php if($fabric['brand']!=='TEXTRONIC'): ?>
                            <input type="checkbox" onchange="DeleteFromVendorPanel1(this);" id="<?php echo e($fabric->fabric_id); ?>" class="remove_fabric"  name="remove_fabric" data-remove-fabric-id="<?php echo e($fabric->tailori_fabric_code); ?>" value="<?php echo e($fabric->tailori_fabric_code); ?>">

                            <label style="background-color: #62ab1b;" title='Delete Fabric From Vendor Panel' for="<?php echo e($fabric->fabric_id); ?>"  data-fabric-sku="<?php echo e($fabric->tailori_fabric_code); ?>" data-fabric-status="in_store" data-fabric-id="<?php echo e($fabric->fabric_id); ?>" class="remove-fabric btn bg-grey-400 <?php echo e($fabric->tailori_fabric_code); ?>"><i class="icon-cross"></i></label>
                        <!-- <label class="btn bg-warning" data-fabric-id="<?php echo e($fabric->fabric_id); ?>" onclick="DeleteFromVendorPanel('<?php echo e($fabric->tailori_fabric_code); ?>')"><i class="icon-cross"></i></label> -->
                            <?php endif; ?>
                        <input type="checkbox" onchange="handleChange(this);" class="move_fabric" name="fabric" id="<?php echo e($fabric->tailori_fabric_code); ?>" value="<?php echo e($fabric->tailori_fabric_code); ?>">
                            <label for="<?php echo e($fabric->tailori_fabric_code); ?>" class="btn bg-blue-400 <?php echo e($fabric->tailori_fabric_code); ?>"><i class="icon-cart-add" title='Move Fabric To Store'></i></label>
                        <?php endif; ?>
                            <label class="btn bg-warning" data-fabric-id="<?php echo e($fabric->fabric_id); ?>" data-toggle="modal" data-target="#modal_form_vertical" onclick="getFabric(this)" title='Update Fabric Info'><i class="icon-pen6"></i></label>


                            <?php endif; ?>
                   
                        </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<!-- /grid -->
<script>
    localStorage.setItem('AppKey', JSON.stringify(<?php echo json_encode($_SESSION); ?>));
</script>

<!-- Pagination -->
<div class="d-flex justify-content-center pt-3 mb-3">
    <ul class="pagination shadow-1">
        <?php echo e($fabrics->links()); ?>

    </ul>
</div>
<!-- /pagination -->
<?php else: ?>
<div class="col-xl-6 col-sm-12">
    No records found!
</div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\tailori\resources\views/admin/fabric/filtered.blade.php ENDPATH**/ ?>