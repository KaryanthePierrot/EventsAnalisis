

<?php $__env->startSection('title', $event->title); ?>

<?php $__env->startSection('content'); ?>


<div class="col-md-10 offset-md-1">
    <div class="row">
        <div id="image-container" class="col-md-6">
            <img src="/img/events/<?php echo e($event->image); ?>" alt="<?php echo e($event->title); ?>" class="img-fluid">
        </div>

        <div id="info-container" class="col-md-6">
            <h1><?php echo e($event->title); ?></h1>
            <p class="event-city"><ion-icon name="location-outline"> </ion-icon> <?php echo e($event->city); ?></p>

            <p class="events-participants"><ion-icon name="people-outline"></ion-icon><?php echo e(count($event->users)); ?> participantes</p>
            <p class="event-owner"> <ion-icon name="star-outline"></ion-icon> <?php echo e($eventOwner['name']); ?></p>

            <?php if(!$hasuserjoined): ?>
            <form action="/events/join/<?php echo e($event->id); ?>" method="post">
                <?php echo csrf_field(); ?>
                <a href="/events/join/<?php echo e($event->id); ?>" class="btn btn-primary" id="event-submit" onclick="event.preventDefault(); this.closest('form').submit();">Confirmar Presença</a>
            </form>
            <?php else: ?>
                <p class="already-joined-msg">Você já está participando desse Evento</p>
            <?php endif; ?>



            <h3>O evento conta com:</h3>

            <?php if($event->items == null ): ?>
            <li style="list-style: none;">Atualmente nenhum item</li>

            <?php elseif($event->items && count($event->items) !== 0 ): ?>
            <ul id="items-list">
                <?php $__currentLoopData = $event->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><ion-icon name="play-outline"></ion-icon> <span><?php echo e($item); ?></span></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

            <?php endif; ?>
        </div>
        <div class="col-md-12" id="description-container">
            <h3>Sobre o evento</h3>
            <p class="event-description"><?php echo e($event->description); ?></p>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.main", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\weslaravel\resources\views/events/show.blade.php ENDPATH**/ ?>