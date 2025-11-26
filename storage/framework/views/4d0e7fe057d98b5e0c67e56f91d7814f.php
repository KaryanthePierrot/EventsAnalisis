

<?php $__env->startSection('title', 'Editando: ' .  $event->title); ?>;

<?php $__env->startSection('content'); ?>

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Editando: <?php echo e($event->title); ?></h1>

    <form action="/events/update/<?php echo e($event->id); ?>" method="post" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <input type="hidden" name="id" value="<?php echo e($event->id); ?>">
        <div class="form-group">
            <label for="image">Imagem do Evento:</label>
            <input type="file" id="image" name="image" class="form-control-file <?php echo e($errors->has('image') ? 'is-invalid' : ''); ?>">
            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <img src="/img/events/<?php echo e($event->image); ?>" alt="<?php echo e($event->title); ?>" class="img-preview"></img>
        </div>
        <div class="form-group">
            <label for="title">Evento:</label>
            <input type="text" class="form-control <?php echo e($errors->has('title') ? 'is-invalid' : ''); ?>" id="title" name="title" placeholder="Nome do evento" value="<?php echo e(old('title', $event->title)); ?>">
            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
            <label for="date">Data do Evento:</label>
            <?php
                $eventDateValue = old('date', (isset($event->date) && is_object($event->date) ? $event->date->format('Y-m-d') : ($event->date ?? '')));
            ?>
            <input type="date" class="form-control <?php echo e($errors->has('date') ? 'is-invalid' : ''); ?>" id="date" name="date" value="<?php echo e($eventDateValue); ?>">
            <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
            <label for="title">Cidade:</label>
            <input type="text" class="form-control <?php echo e($errors->has('city') ? 'is-invalid' : ''); ?>" id="city" name="city" placeholder="Local do evento" value="<?php echo e(old('city', $event->city)); ?>">
            <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
            <label for="title">O evento é privado?:</label>
            <select name="private" id="private" class="form-control <?php echo e($errors->has('private') ? 'is-invalid' : ''); ?>">
                <option value="0" <?php echo e(old('private', (string)$event->private) === '0' ? 'selected' : ''); ?>>Não</option>
                <option value="1" <?php echo e(old('private', (string)$event->private) === '1' ? 'selected' : ''); ?>>Sim</option>
            </select>
            <?php $__errorArgs = ['private'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label for="title">Descrição:</label>
            <textarea name="description" id="description" class="form-control"> <?php echo e($event->description); ?></textarea>
        </div>

        <div class="form-group">
            <label for="title">Adicione itens de Infraestrutura</label>

            <?php
                $eventItems = $event->items ?? [];
            ?>

            <?php if(isset($availableItems) && is_array($availableItems)): ?>
                <?php $__currentLoopData = $availableItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="form-group">
                        <input type="checkbox" name="items[]" value="<?php echo e($item); ?>" <?php echo e(in_array($item, old('items', $eventItems)) ? 'checked' : ''); ?>> <?php echo e($item); ?>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Cadeiras" <?php echo e(in_array('Cadeiras', old('items', $eventItems)) ? 'checked' : ''); ?>> Cadeiras
                </div>

                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Open Bar" <?php echo e(in_array('Open Bar', old('items', $eventItems)) ? 'checked' : ''); ?>> Open bar
                </div>

                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Open Food" <?php echo e(in_array('Open Food', old('items', $eventItems)) ? 'checked' : ''); ?>> Open Foods
                </div>

                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Sorteios" <?php echo e(in_array('Sorteios', old('items', $eventItems)) ? 'checked' : ''); ?>> Sorteios
                </div>
            <?php endif; ?>

            <span>Adicione mais itens (separe por vírgula):</span>
            <div class="form-group">
                <input type="text" class="form-control <?php echo e($errors->has('new_items') ? 'is-invalid' : ''); ?>" id="new_items" name="new_items" placeholder="Ex: Som, Palco" value="<?php echo e(old('new_items')); ?>">
                <?php $__errorArgs = ['new_items'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

        </div>
        <input type="submit" class="btn btn-primary" value="Editar Evento">
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.main", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\weslaravel\resources\views/events/edit.blade.php ENDPATH**/ ?>