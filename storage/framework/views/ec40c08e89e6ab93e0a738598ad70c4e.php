

<?php $__env->startSection('title', 'Produto'); ?>

<?php $__env->startSection('content'); ?>
<?php if($id != null): ?>

<p>Exibindo o id <?php echo e($id); ?></p>
<?php endif; ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.main", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\weslaravel\resources\views/produto.blade.php ENDPATH**/ ?>