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
            <?php echo e(__('Quota')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Quota</h2>
                    <p class="mt-1 text-sm text-gray-500">Gérer les quotas attribués aux clients.</p>
                </div>
                <div class="mt-4 sm:mt-0 w-full sm:w-auto">
                    <form id="quotaSearchForm" method="GET" action="<?php echo e(route('quotas.index')); ?>" class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <div class="relative w-full sm:w-72">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z" />
                                </svg>
                            </div>
                            <input id="quotaSearchInput" type="text" name="search" value="<?php echo e($search ?? request('search')); ?>" placeholder="Rechercher par client, username, téléphone" class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <?php if(($search ?? request('search')) !== null && trim((string)($search ?? request('search'))) !== ''): ?>
                                <a href="<?php echo e(route('quotas.index', array_filter(['date' => $date ?? request('date')]))); ?>" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" aria-label="Clear search">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="relative w-full sm:w-52">
                            <input id="quotaDateInput" type="date" name="date" value="<?php echo e($date ?? request('date')); ?>" class="block w-full py-2.5 px-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <button type="button" onclick="resetAndOpenQuotaModal()" class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Ajouter un quota
                        </button>
                    </form>
                </div>
            </div>

            <script>
                (function () {
                    const form = document.getElementById('quotaSearchForm');
                    const searchInput = document.getElementById('quotaSearchInput');
                    const dateInput = document.getElementById('quotaDateInput');
                    if (!form) return;

                    let t = null;
                    if (searchInput) {
                        searchInput.addEventListener('input', function () {
                            if (t) clearTimeout(t);
                            t = setTimeout(function () {
                                form.submit();
                            }, 400);
                        });
                    }
                    if (dateInput) {
                        dateInput.addEventListener('change', function () {
                            form.submit();
                        });
                    }
                })();
            </script>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Client Info</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Quota attribué</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date d'ajout</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__currentLoopData = $quotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50 transition-colors duration-150 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-lg">
                                                <?php echo e(substr($quota->client->name ?? 'C', 0, 1)); ?>

                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900"><?php echo e($quota->client->name ?? 'Unnamed Client'); ?></div>
                                                <div class="text-xs text-gray-500"><?php echo e($quota->client->phone ?? '-'); ?></div>
                                                <div class="text-xs text-gray-500 font-mono"><?php echo e($quota->client->username ?? '-'); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-sm font-semibold">
                                            +<?php echo e($quota->amount); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo e($quota->quota_date?->format('Y-m-d') ?? $quota->quota_date); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-3">
                                            <button type="button"
                                                    onclick='openQuotaModal(<?php echo e(json_encode(["id"=>$quota->id,"client_id"=>$quota->client_id,"client_name"=>$quota->client->name,"client_username"=>$quota->client->username,"amount"=>$quota->amount,"quota_date"=>(string)$quota->quota_date])); ?>)'
                                                    class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-1.5 rounded-md hover:bg-indigo-100 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                            <form action="<?php echo e(route('quotas.destroy', $quota)); ?>" method="POST" class="inline" onsubmit="return confirm('Confirmer la suppression de ce quota ?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 p-1.5 rounded-md hover:bg-red-100 transition-colors">
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

                <div class="md:hidden bg-gray-50 p-4 space-y-4">
                    <?php $__currentLoopData = $quotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 transition-shadow hover:shadow-md">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-lg mr-3">
                                        <?php echo e(substr($quota->client->name ?? 'C', 0, 1)); ?>

                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-lg leading-tight"><?php echo e($quota->client->name ?? 'Unnamed Client'); ?></h4>
                                        <p class="text-xs text-gray-500 mt-0.5"><?php echo e($quota->client->phone ?? '-'); ?></p>
                                        <p class="text-xs text-gray-500 font-mono mt-0.5"><?php echo e($quota->client->username ?? '-'); ?></p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-sm font-semibold">
                                    +<?php echo e($quota->amount); ?>

                                </span>
                            </div>

                            <div class="text-sm text-gray-600 mb-4">
                                <div class="flex justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-500">Date</span>
                                    <span class="font-medium"><?php echo e($quota->quota_date?->format('Y-m-d') ?? $quota->quota_date); ?></span>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                                <button type="button"
                                        onclick='openQuotaModal(<?php echo e(json_encode(["id"=>$quota->id,"client_id"=>$quota->client_id,"client_name"=>$quota->client->name,"client_username"=>$quota->client->username,"amount"=>$quota->amount,"quota_date"=>(string)$quota->quota_date])); ?>)'
                                        class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                    <svg class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </button>
                                <form action="<?php echo e(route('quotas.destroy', $quota)); ?>" method="POST" class="flex-1 inline-block" onsubmit="return confirm('Confirmer la suppression de ce quota ?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none">
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

                <div class="px-6 py-4 bg-white border-t border-gray-100">
                    <?php echo e($quotas->links()); ?>

                </div>
            </div>
        </div>
    </div>

    <div id="quotaModal" class="fixed z-20 inset-0 overflow-y-auto hidden" aria-labelledby="quota-modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-filter backdrop-blur-sm" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-gray-100">
                <form id="quotaForm" action="<?php echo e(route('quotas.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div id="quotaMethodField"></div>
                    <input type="hidden" name="quota_id" id="quota_id">
                    <input type="hidden" name="client_id" id="quota_client_id_hidden" disabled>
                    <input type="hidden" name="quota_date" id="quota_date_hidden" disabled>

                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-bold text-white flex items-center" id="quota-modal-title">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-10V6m0 12v2m9-8a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Ajouter un quota</span>
                            </h3>
                            <button type="button" onclick="closeQuotaModal()" class="text-blue-100 hover:text-white focus:outline-none transition-colors">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="px-6 py-6 bg-gray-50">
                        <div id="quota-modal-errors" class="hidden mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r shadow-sm">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Veuillez corriger les erreurs :</h3>
                                    <ul id="quota-modal-errors-list" class="mt-2 list-disc list-inside text-sm text-red-700">
                                        <?php if($errors->any()): ?>
                                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><?php echo e($error); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Client <span class="text-red-500">*</span></label>
                                <select name="client_id" id="quota_client_id" required class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-lg">
                                    <option value="">Sélectionner un client</option>
                                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($client->id); ?>"><?php echo e($client->name ?? 'Unnamed'); ?> (<?php echo e($client->username); ?>)</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Montant du quota <span class="text-red-500">*</span></label>
                                <input type="number" name="amount" id="quota_amount" required min="1" class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-lg" placeholder="ex: 50">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Date d'ajout</label>
                                <div id="quota_date_display" class="block w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-gray-600 sm:text-sm font-mono font-bold text-center">
                                    <?php echo e(now()->toDateString()); ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-100 px-6 py-4 flex flex-row-reverse border-t border-gray-200 rounded-b-xl">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-2.5 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-all transform hover:scale-105">
                            Enregistrer
                        </button>
                        <button type="button" onclick="closeQuotaModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-6 py-2.5 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function resetAndOpenQuotaModal() {
            const errors = document.getElementById('quota-modal-errors');
            const list = document.getElementById('quota-modal-errors-list');
            if (errors) errors.classList.add('hidden');
            if (list) list.innerHTML = '';
            openQuotaModal();
        }

        function openQuotaModal(data = null) {
            const modal = document.getElementById('quotaModal');
            const form = document.getElementById('quotaForm');
            const title = document.getElementById('quota-modal-title');
            const methodField = document.getElementById('quotaMethodField');

            const quotaId = document.getElementById('quota_id');
            const clientHidden = document.getElementById('quota_client_id_hidden');
            const dateHidden = document.getElementById('quota_date_hidden');
            const clientSelect = document.getElementById('quota_client_id');
            const amountInput = document.getElementById('quota_amount');
            const dateDisplay = document.getElementById('quota_date_display');

            if (data) {
                title.querySelector('span').innerText = 'Modifier un quota';
                form.action = `<?php echo e(url('quotas')); ?>/${data.id}`;
                methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                clientSelect.value = data.client_id;
                clientSelect.disabled = true;
                clientHidden.disabled = false;
                clientHidden.value = data.client_id;
                quotaId.value = data.id;
                amountInput.value = data.amount;
                dateDisplay.innerText = data.quota_date;
                dateHidden.disabled = false;
                dateHidden.value = data.quota_date;
            } else {
                title.querySelector('span').innerText = 'Ajouter un quota';
                form.action = "<?php echo e(route('quotas.store')); ?>";
                methodField.innerHTML = '';
                form.reset();
                clientSelect.disabled = false;
                clientHidden.disabled = true;
                quotaId.value = '';
                const today = new Date().toISOString().slice(0, 10);
                dateDisplay.innerText = today;
                dateHidden.disabled = false;
                dateHidden.value = today;
            }

            modal.classList.remove('hidden');
        }

        function closeQuotaModal() {
            document.getElementById('quotaModal').classList.add('hidden');
        }

        (function () {
            const clientSelect = document.getElementById('quota_client_id');
            const clientHidden = document.getElementById('quota_client_id_hidden');
            if (clientSelect && clientHidden) {
                clientSelect.addEventListener('change', function () {
                    if (!clientHidden.disabled) return;
                    clientHidden.value = clientSelect.value;
                });
            }
        })();

        <?php if($errors->any()): ?>
            document.addEventListener('DOMContentLoaded', function() {
                const errorsDiv = document.getElementById('quota-modal-errors');
                if (errorsDiv) {
                    errorsDiv.classList.remove('hidden');
                }

                <?php if(old('_method') == 'PUT' && old('quota_id')): ?>
                    openQuotaModal({
                        id: <?php echo json_encode(old('quota_id')); ?>,
                        client_id: <?php echo json_encode(old('client_id')); ?>,
                        amount: <?php echo json_encode(old('amount')); ?>,
                        quota_date: <?php echo json_encode(old('quota_date') ?? now()->toDateString()); ?>

                    });
                <?php else: ?>
                    openQuotaModal();
                    document.getElementById('quota_client_id').value = <?php echo json_encode(old('client_id')); ?>;
                    document.getElementById('quota_amount').value = <?php echo json_encode(old('amount')); ?>;
                    const dateValue = <?php echo json_encode(old('quota_date') ?? now()->toDateString()); ?>;
                    document.getElementById('quota_date_display').innerText = dateValue;
                    document.getElementById('quota_date_hidden').disabled = false;
                    document.getElementById('quota_date_hidden').value = dateValue;
                <?php endif; ?>
            });
        <?php endif; ?>
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>
<?php /**PATH D:\xampp\htdocs\invoice_reader\resources\views/quotas/index.blade.php ENDPATH**/ ?>