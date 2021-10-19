<!DOCTYPE html>
<html>
<head>
    <title> notification  </title>
    <!-- <h1>    Demo on Laravel Notif SENDIGN   </h1> -->
    <script src="https://js.pusher.com/4.1/pusher.min.js">  </script>
    <script>
        var pusher = new Pusher('<?php echo e(env("MIX_PUSHER_APP_KEY")); ?>', {
            cluster: '<?php echo e(env("PUSHER_APP_CLUSTER")); ?>',
            encrypted: true
        });

        var channel = pusher.subscribe('notify-channel');
        // var nitif =  document.getElementById('notif');
        channel.bind('App\\Events\\Notify', function(data){
            alert(data.message);
            // nitif.innerHtml = data.message;
        });
    </script>
</head>



<body>
<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
 <?php $__env->slot('header', null, []); ?> 
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <!-- <?php echo e(__('Dashboard')); ?> -->
        Demo on Laravel Notif SENDIGN
    </h2>
 <?php $__env->endSlot(); ?>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
            <div class="flex">
                <div class="flex-auto text-2xl mb-4">Notif Received</div>
            </div>
            <!-- <table class="w-full text-md rounded mb-4">
                <thead>
                <tr class="border-b">
                    <th class="text-left p-3 px-5">Notif</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-orange-100">
                        <td class="p-3 px-5">
                            <div id="notif"></div>
                        </td>
                        <td class="p-3 px-5">
                            
                        </td>
                    </tr>
                </tbody>
            </table> -->
            
        </div>
    </div>
</div>
 <?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
    </body>
    </html><?php /**PATH C:\sarase\second_project\todoApp\resources\views/notification.blade.php ENDPATH**/ ?>