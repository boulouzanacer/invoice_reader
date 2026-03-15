<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Clients')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Clients</h2>
                    <p class="mt-1 text-sm text-gray-500">Manage your API clients, quotas, and credentials.</p>
                </div>
                <div class="mt-4 sm:mt-0 w-full sm:w-auto">
                    <form id="clientSearchForm" method="GET" action="<?php echo e(route('clients.index')); ?>" class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <div class="relative w-full sm:w-80">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z" />
                                </svg>
                            </div>
                            <input id="clientSearchInput" type="text" name="search" value="<?php echo e($search ?? request('search')); ?>" placeholder="Search by name, username, phone" class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <?php if(($search ?? request('search')) !== null && trim((string)($search ?? request('search'))) !== ''): ?>
                                <a href="<?php echo e(route('clients.index')); ?>" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" aria-label="Clear search">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                        <button type="button" onclick="resetAndOpenModal()" class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add New Client
                        </button>
                    </form>
                </div>
            </div>

            <script>
                (function () {
                    const form = document.getElementById('clientSearchForm');
                    const input = document.getElementById('clientSearchInput');
                    if (!form || !input) return;

                    let t = null;
                    input.addEventListener('input', function () {
                        if (t) clearTimeout(t);
                        t = setTimeout(function () {
                            form.submit();
                        }, 400);
                    });
                })();
            </script>

            <!-- Notifications -->
            <?php if(session('success')): ?>
                <div class="mb-6 rounded-lg bg-green-50 p-4 border-l-4 border-green-400 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800"><?php echo e(session('success')); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="mb-6 rounded-lg bg-red-50 p-4 border-l-4 border-red-400 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800"><?php echo e(session('error')); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Client Info</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Credentials</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Contact</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Quota Usage</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-150 group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-lg">
                                            <?php echo e(substr($client->name ?? 'C', 0, 1)); ?>

                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?php echo e($client->name ?? 'Unnamed Client'); ?></div>
                                            <div class="text-xs text-gray-500 font-mono"><?php echo e($client->username); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="space-y-2">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs text-gray-500 w-20">Username</span>
                                            <code class="text-xs font-mono bg-gray-100 px-2 py-1 rounded text-gray-700 truncate max-w-[140px]"><?php echo e($client->username); ?></code>
                                            <div x-data="{ copied: false }">
                                                <button
                                                    @click="navigator.clipboard.writeText('<?php echo e($client->username); ?>'); copied = true; setTimeout(() => copied = false, 1200)"
                                                    class="text-gray-400 hover:text-blue-600 transition-colors focus:outline-none"
                                                    title="Copy Username"
                                                >
                                                    <template x-if="!copied">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                        </svg>
                                                    </template>
                                                    <template x-if="copied">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </template>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs text-gray-500 w-20">Password</span>
                                            <code class="text-xs font-mono bg-gray-100 px-2 py-1 rounded text-gray-700 truncate max-w-[140px]"><?php echo e($client->password); ?></code>
                                            <div x-data="{ copied: false }">
                                                <button
                                                    @click="navigator.clipboard.writeText('<?php echo e($client->password); ?>'); copied = true; setTimeout(() => copied = false, 1200)"
                                                    class="text-gray-400 hover:text-blue-600 transition-colors focus:outline-none"
                                                    title="Copy Password"
                                                >
                                                    <template x-if="!copied">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                        </svg>
                                                    </template>
                                                    <template x-if="copied">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </template>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <svg class="flex-shrink-0 h-4 w-4 text-gray-400 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <?php echo e($client->phone ?? '-'); ?>

                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <div class="flex items-center justify-between text-xs mb-1">
                                            <span class="font-medium <?php echo e($client->remaining_keywords < 10 ? 'text-red-600' : 'text-gray-900'); ?>"><?php echo e($client->remaining_keywords); ?></span>
                                            <span class="text-gray-400">/ <?php echo e($client->keyword_count); ?></span>
                                        </div>
                                        <div class="w-24 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                            <?php
                                                $percentage = $client->keyword_count > 0 ? ($client->remaining_keywords / $client->keyword_count) * 100 : 0;
                                                $color = $percentage < 20 ? 'bg-red-500' : ($percentage < 50 ? 'bg-yellow-500' : 'bg-green-500');
                                            ?>
                                            <div class="h-full <?php echo e($color); ?> rounded-full" style="width: <?php echo e(min(100, $percentage)); ?>%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="<?php echo e(route('clients.toggle', $client)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 <?php echo e($client->is_enabled ? 'bg-green-500' : 'bg-gray-200'); ?>">
                                            <span class="sr-only">Use setting</span>
                                            <span aria-hidden="true" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200 <?php echo e($client->is_enabled ? 'translate-x-5' : 'translate-x-0'); ?>"></span>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-3">
                                        <button onclick="editClient(<?php echo e($client->id); ?>)" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-1.5 rounded-md hover:bg-indigo-100 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                        <form action="<?php echo e(route('clients.destroy', $client)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 p-1.5 rounded-md hover:bg-red-100 transition-colors" onclick="return confirm('Are you sure?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden bg-gray-50 p-4 space-y-4">
                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 transition-shadow hover:shadow-md <?php echo e(!$client->is_enabled ? 'opacity-75' : ''); ?>">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-lg mr-3">
                                    <?php echo e(substr($client->name ?? 'C', 0, 1)); ?>

                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg leading-tight"><?php echo e($client->name ?? 'Unnamed Client'); ?></h4>
                                    <p class="text-xs text-gray-500 font-mono mt-0.5"><?php echo e($client->username); ?></p>
                                </div>
                            </div>
                            <form action="<?php echo e(route('clients.toggle', $client)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 <?php echo e($client->is_enabled ? 'bg-green-500' : 'bg-gray-200'); ?>">
                                    <span class="sr-only">Use setting</span>
                                    <span aria-hidden="true" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200 <?php echo e($client->is_enabled ? 'translate-x-5' : 'translate-x-0'); ?>"></span>
                                </button>
                            </form>
                        </div>
                        
                        <div class="space-y-3 text-sm text-gray-600 mb-5">
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-500 flex items-center">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    Phone
                                </span>
                                <span class="font-medium"><?php echo e($client->phone ?? '-'); ?></span>
                            </div>
                            
                            <div class="py-2 border-b border-gray-100">
                                <div class="flex justify-between mb-1">
                                    <span class="text-gray-500 flex items-center">
                                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        Quota
                                    </span>
                                    <span class="font-medium text-gray-900"><?php echo e($client->remaining_keywords); ?> / <?php echo e($client->keyword_count); ?></span>
                                </div>
                                <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden mt-2">
                                    <?php
                                        $percentage = $client->keyword_count > 0 ? ($client->remaining_keywords / $client->keyword_count) * 100 : 0;
                                        $color = $percentage < 20 ? 'bg-red-500' : ($percentage < 50 ? 'bg-yellow-500' : 'bg-green-500');
                                    ?>
                                    <div class="h-full <?php echo e($color); ?> rounded-full" style="width: <?php echo e(min(100, $percentage)); ?>%"></div>
                                </div>
                            </div>

                            <div class="py-2">
                                <span class="text-gray-500 block mb-2 text-xs uppercase tracking-wider">Credentials</span>
                                <div class="space-y-2">
                                    <div class="flex items-center space-x-2 bg-gray-50 p-2 rounded-lg border border-gray-100">
                                        <span class="text-xs text-gray-500 w-16">User</span>
                                        <code class="text-xs flex-1 truncate font-mono text-gray-700 select-all"><?php echo e($client->username); ?></code>
                                        <div x-data="{ copied: false }">
                                            <button
                                                @click="navigator.clipboard.writeText('<?php echo e($client->username); ?>'); copied = true; setTimeout(() => copied = false, 1200)"
                                                class="p-1.5 bg-white border border-gray-200 rounded-md text-gray-500 hover:text-blue-600 shadow-sm focus:outline-none"
                                            >
                                                <template x-if="!copied">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                    </svg>
                                                </template>
                                                <template x-if="copied">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </template>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2 bg-gray-50 p-2 rounded-lg border border-gray-100">
                                        <span class="text-xs text-gray-500 w-16">Pass</span>
                                        <code class="text-xs flex-1 truncate font-mono text-gray-700 select-all"><?php echo e($client->password); ?></code>
                                        <div x-data="{ copied: false }">
                                            <button
                                                @click="navigator.clipboard.writeText('<?php echo e($client->password); ?>'); copied = true; setTimeout(() => copied = false, 1200)"
                                                class="p-1.5 bg-white border border-gray-200 rounded-md text-gray-500 hover:text-blue-600 shadow-sm focus:outline-none"
                                            >
                                                <template x-if="!copied">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                    </svg>
                                                </template>
                                                <template x-if="copied">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </template>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                            <button onclick="editClient(<?php echo e($client->id); ?>)" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                <svg class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </button>
                            <form action="<?php echo e(route('clients.destroy', $client)); ?>" method="POST" class="flex-1 inline-block">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none" onclick="return confirm('Are you sure?')">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Client Modal -->
    <div id="clientModal" class="fixed z-20 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-filter backdrop-blur-sm" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-100">
                <form id="clientForm" action="<?php echo e(route('clients.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" id="client_id">
                    <div id="methodField"></div>
                    
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-bold text-white flex items-center" id="modal-title">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span>Add Client</span>
                            </h3>
                            <button type="button" onclick="closeModal()" class="text-blue-100 hover:text-white focus:outline-none transition-colors">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="px-6 py-6 bg-gray-50">
                        <!-- Notifications -->
                        <div id="modal-errors" class="hidden mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r shadow-sm">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                                    <ul id="modal-errors-list" class="mt-2 list-disc list-inside text-sm text-red-700">
                                        <?php if($errors->any()): ?>
                                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><?php echo e($error); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Username <span class="text-red-500">*</span></label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm-9 9a9 9 0 1118 0H6z" />
                                            </svg>
                                        </div>
                                        <input type="text" name="username" id="client_username" required class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-lg transition-all" placeholder="client_username">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                        <input type="text" name="password" id="client_password" required class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-lg transition-all" placeholder="client_password">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500" id="client_password_help">Minimum 6 characters</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Client Name</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <input type="text" name="name" id="client_name" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-lg transition-all" placeholder="Company or Person Name">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Phone Number</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </div>
                                        <input type="text" name="phone" id="client_phone" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-lg transition-all" placeholder="0612345678">
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Address</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <textarea name="address" id="client_address" rows="4" class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-lg transition-all" placeholder="Full address..."></textarea>
                                    </div>
                                </div>

                                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                    <label class="block text-sm font-semibold text-blue-800 mb-2">Access Control</label>
                                    
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label class="block text-xs font-medium text-blue-600 uppercase tracking-wider mb-1">Total Quota</label>
                                            <div id="total_quota_create_section">
                                                <input type="number" name="keyword_count" id="client_keyword_count" required min="0" class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-blue-200 rounded-md transition-all">
                                            </div>
                                            <div id="total_quota_edit_section" class="hidden">
                                                <div id="client_keyword_count_display" class="block w-full px-3 py-2 bg-white border border-gray-200 rounded-md text-gray-600 sm:text-sm font-mono font-bold text-center">
                                                    0
                                                </div>
                                                <input type="hidden" name="keyword_count" id="client_keyword_count_hidden" disabled>
                                            </div>
                                        </div>
                                        <div id="remaining_quota_section" class="hidden">
                                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Remaining</label>
                                            <div id="client_remaining_keywords_display" class="block w-full px-3 py-2 bg-white border border-gray-200 rounded-md text-gray-600 sm:text-sm font-mono font-bold text-center">
                                                0
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between bg-white p-3 rounded border border-blue-100">
                                        <span class="text-sm font-medium text-gray-700">Account Status</span>
                                        <label for="client_is_enabled" class="flex items-center cursor-pointer">
                                            <div class="relative">
                                                <input type="checkbox" name="is_enabled" id="client_is_enabled" class="sr-only">
                                                <div class="w-10 h-6 bg-gray-200 rounded-full shadow-inner transition-colors duration-200 ease-in-out toggle-bg"></div>
                                                <div class="dot absolute w-4 h-4 bg-white rounded-full shadow inset-y-1 left-1 transition-transform duration-200 ease-in-out"></div>
                                            </div>
                                            <span class="ml-2 text-sm text-gray-600 font-medium label-text">Enabled</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-100 px-6 py-4 flex flex-row-reverse border-t border-gray-200 rounded-b-xl">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-2.5 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-all transform hover:scale-105">
                            Save Client
                        </button>
                        <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-6 py-2.5 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Custom Toggle Switch */
        input:checked ~ .toggle-bg {
            background-color: #3b82f6;
        }
        input:checked ~ .dot {
            transform: translateX(100%);
        }
        input:checked ~ .label-text {
            color: #2563eb;
        }
    </style>

    <script>
        function resetAndOpenModal() {
            const errorsDiv = document.getElementById('modal-errors');
            if (errorsDiv) {
                errorsDiv.classList.add('hidden');
            }
            openModal();
        }

        function openModal(data = null) {
            const modal = document.getElementById('clientModal');
            const form = document.getElementById('clientForm');
            const title = document.getElementById('modal-title');
            const methodField = document.getElementById('methodField');
            const errorsDiv = document.getElementById('modal-errors');
            const errorsList = document.getElementById('modal-errors-list');

            // IMPORTANT: Only hide errors if this is a USER CLICK event (not page load)
            // We can detect this by checking if the event is trusted, but simpler is:
            // Since this function is called inline onclick="openModal()", we can just hide it here.
            // HOWEVER, we must NOT hide it if it was unhidden by the DOMContentLoaded event above.
            // But DOMContentLoaded runs AFTER the script is parsed, but BEFORE user interaction.
            // Wait, this function is called by the blade template logic too!
            
            // Fix: We only want to hide errors if the user MANUALLY opens the modal.
            // The blade template logic calls openModal() directly.
            // We can check if 'data' is passed or not, but the blade logic calls openModal() without data for create.
            
            // BETTER FIX: Don't hide errors inside openModal().
            // Hide errors ONLY when close is clicked OR when user manually clicks "Add Client".
            // So we remove the hiding logic from here and move it to the button onclick.
            
            if (data) {
                title.innerText = 'Edit Client';
                form.action = `<?php echo e(url('clients')); ?>/${data.id}`;
                methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                document.getElementById('client_id').value = data.id;
                document.getElementById('client_username').value = data.username;
                document.getElementById('client_password').value = '';
                document.getElementById('client_password').required = false;
                document.getElementById('client_password_help').innerText = 'Leave blank to keep current password';
                document.getElementById('client_name').value = data.name || '';
                document.getElementById('client_address').value = data.address || '';
                document.getElementById('client_phone').value = data.phone || '';
                document.getElementById('client_keyword_count_display').innerText = data.keyword_count;
                document.getElementById('client_keyword_count_hidden').value = data.keyword_count;
                document.getElementById('client_keyword_count_hidden').disabled = false;
                document.getElementById('client_keyword_count').disabled = true;
                document.getElementById('client_keyword_count').required = false;
                document.getElementById('total_quota_create_section').classList.add('hidden');
                document.getElementById('total_quota_edit_section').classList.remove('hidden');
                document.getElementById('client_remaining_keywords_display').innerText = data.remaining_keywords;
                document.getElementById('remaining_quota_section').classList.remove('hidden');
                document.getElementById('client_is_enabled').checked = data.is_enabled;
            } else {
                title.innerText = 'Add Client';
                form.action = "<?php echo e(route('clients.store')); ?>";
                methodField.innerHTML = '';
                form.reset();
                document.getElementById('client_password').required = true;
                document.getElementById('client_password_help').innerText = 'Minimum 6 characters';
                document.getElementById('client_keyword_count_hidden').disabled = true;
                document.getElementById('client_keyword_count').disabled = false;
                document.getElementById('client_keyword_count').required = true;
                document.getElementById('total_quota_create_section').classList.remove('hidden');
                document.getElementById('total_quota_edit_section').classList.add('hidden');
                document.getElementById('remaining_quota_section').classList.add('hidden');
            }
            modal.classList.remove('hidden');
        }

        // Re-open modal if there are validation errors
        <?php if($errors->any()): ?>
            document.addEventListener('DOMContentLoaded', function() {
                // Ensure error div is visible
                const errorsDiv = document.getElementById('modal-errors');
                if (errorsDiv) {
                    errorsDiv.classList.remove('hidden');
                    // Force removal of inline style if any (just in case)
                    errorsDiv.style.display = 'block';
                }
                
                <?php if(old('_method') == 'PUT'): ?>
                    openModal({
                        id: <?php echo json_encode(old('id')); ?>,
                        username: <?php echo json_encode(old('username')); ?>,
                        password: <?php echo json_encode(old('password')); ?>,
                        name: <?php echo json_encode(old('name')); ?>,
                        address: <?php echo json_encode(old('address')); ?>,
                        phone: <?php echo json_encode(old('phone')); ?>,
                        keyword_count: <?php echo json_encode(old('keyword_count')); ?>,
                        remaining_keywords: <?php echo json_encode(old('remaining_keywords') ?? 0); ?>,
                        is_enabled: <?php echo e(old('is_enabled') ? 'true' : 'false'); ?>

                    });
                <?php else: ?>
                    // Open modal for CREATE action and pre-fill old values
                    openModal();
                    // Manually fill fields since openModal() resets them for new entries
                    document.getElementById('client_username').value = <?php echo json_encode(old('username')); ?>;
                    document.getElementById('client_password').value = <?php echo json_encode(old('password')); ?>;
                    document.getElementById('client_name').value = <?php echo json_encode(old('name')); ?>;
                    document.getElementById('client_address').value = <?php echo json_encode(old('address')); ?>;
                    document.getElementById('client_phone').value = <?php echo json_encode(old('phone')); ?>;
                    document.getElementById('client_keyword_count').value = <?php echo json_encode(old('keyword_count')); ?>;
                    document.getElementById('client_is_enabled').checked = <?php echo e(old('is_enabled') ? 'true' : 'true'); ?>; // Default true for new
                <?php endif; ?>
            });
        <?php endif; ?>

        function closeModal() {
            document.getElementById('clientModal').classList.add('hidden');
        }

        function editClient(id) {
            // Hide errors when manually clicking edit
            const errorsDiv = document.getElementById('modal-errors');
            if (errorsDiv) {
                errorsDiv.classList.add('hidden');
            }

            fetch(`<?php echo e(url('clients')); ?>/${id}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                openModal(data);
            })
            .catch(error => {
                console.error('Error fetching client:', error);
                alert('Error loading client data. Please try again.');
            });
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>
<?php /**PATH D:\xampp\htdocs\invoice_reader\resources\views/clients/index.blade.php ENDPATH**/ ?>