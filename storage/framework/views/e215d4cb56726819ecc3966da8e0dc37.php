

<?php $__env->startSection('title', 'Produtos'); ?>

<?php $__env->startSection('content'); ?>

<h1>Produtos</h1>

<?php if($busca != ''): ?>
<p>O user buscou por <?php echo e($busca); ?></p>

<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.main", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\weslaravel\resources\views/produtos.blade.php ENDPATH**/ ?>