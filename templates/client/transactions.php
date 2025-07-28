<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Sélecteur de compte -->
    <div class="flex flex-col md:flex-row items-center justify-between mb-8 gap-4">
        <div class="flex items-center gap-2">
            <label for="compteSelect" class="text-orange-500 font-semibold text-lg">Compte :</label>
            <form method="get" class="inline-block">
                <select name="compte_id" id="compteSelect" class="rounded-lg border-orange-500 focus:ring-orange-500 focus:border-orange-500 px-4 py-2 bg-black text-white font-semibold">
                    <?php if (!empty($comptePrincipal)): ?>
                        <option value="<?= $comptePrincipal['id'] ?>" <?= ($selectedCompteId ?? $comptePrincipal['id']) == $comptePrincipal['id'] ? 'selected' : '' ?>>Principal - <?= htmlspecialchars($comptePrincipal['numeros']) ?></option>
                    <?php endif; ?>
                    <?php foreach ($comptesSecondaires ?? [] as $compte): ?>
                        <option value="<?= $compte['id'] ?>" <?= ($selectedCompteId ?? '') == $compte['id'] ? 'selected' : '' ?>>Secondaire - <?= htmlspecialchars($compte['numeros']) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="ml-2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-semibold shadow">Changer</button>
            </form>
        </div>
        <div class="flex gap-2">
            <a href="/client/depot?compte_id=<?= urlencode($selectedCompteId ?? ($comptePrincipal['id'] ?? '')) ?>" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-semibold shadow flex items-center"><i class="fas fa-plus-circle mr-2"></i> Dépôt</a>
            <a href="/client/transfert?compte_id=<?= urlencode($selectedCompteId ?? ($comptePrincipal['id'] ?? '')) ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold shadow flex items-center"><i class="fas fa-paper-plane mr-2"></i> Transfert</a>
            <!-- Paiement Woyofal uniquement -->
            <button type="button" id="btnWoyofal" class="bg-white border border-green-500 text-green-600 px-4 py-2 rounded-lg font-semibold shadow flex items-center hover:bg-green-50">
                <img src="/assets/images/woyofal-logo.png" alt="Woyofal" class="w-6 h-6 mr-2"> Payer avec Woyofal
            </button>

<!-- Modal Paiement Woyofal -->
<div id="modalWoyofal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold text-green-600 mb-4 flex items-center"><img src="/assets/images/woyofal-logo.png" class="w-8 h-8 mr-2"> Paiement Woyofal</h2>
        <form id="formWoyofal" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Montant à payer</label>
                <input type="number" name="montant" id="montantWoyofal" min="100" step="100" required class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 shadow-sm px-4 py-2">
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" id="closeWoyofal" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold">Annuler</button>
                <button type="submit" class="px-6 py-2 rounded-lg bg-green-600 text-white font-semibold hover:bg-green-700 flex items-center" id="submitWoyofal">
                    <span id="textWoyofal">Payer</span>
                    <span id="spinnerWoyofal" class="ml-2 hidden"><svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg></span>
                </button>
            </div>
            <div id="resultWoyofal" class="mt-4 text-center"></div>
        </form>
    </div>
</div>

<script>
const btnWoyofal = document.getElementById('btnWoyofal');
const modalWoyofal = document.getElementById('modalWoyofal');
const closeWoyofal = document.getElementById('closeWoyofal');
const formWoyofal = document.getElementById('formWoyofal');
const spinnerWoyofal = document.getElementById('spinnerWoyofal');
const textWoyofal = document.getElementById('textWoyofal');
const resultWoyofal = document.getElementById('resultWoyofal');

btnWoyofal.onclick = () => {
    modalWoyofal.classList.remove('hidden');
    resultWoyofal.textContent = '';
    formWoyofal.reset();
};
closeWoyofal.onclick = () => {
    modalWoyofal.classList.add('hidden');
};
formWoyofal.onsubmit = async (e) => {
    e.preventDefault();
    spinnerWoyofal.classList.remove('hidden');
    textWoyofal.textContent = 'Paiement...';
    resultWoyofal.textContent = '';
    const montant = document.getElementById('montantWoyofal').value;
    // Remplace ici l'URL par celle de ton API Woyofal après déploiement
    const apiUrl = 'https://app-woyofal.onrender.com/api/paiement';
    try {
        const res = await fetch(apiUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                compte_id: "<?= htmlspecialchars($selectedCompteId ?? '') ?>",
                montant: montant
            })
        });
        const data = await res.json();
        if (res.ok && data.success) {
            resultWoyofal.textContent = 'Paiement réussi !';
            resultWoyofal.className = 'mt-4 text-green-600 font-bold';
            setTimeout(() => { location.reload(); }, 1500);
        } else {
            resultWoyofal.textContent = data.error || 'Échec du paiement.';
            resultWoyofal.className = 'mt-4 text-red-600 font-bold';
        }
    } catch (err) {
        resultWoyofal.textContent = 'Erreur de connexion au service Woyofal.';
        resultWoyofal.className = 'mt-4 text-red-600 font-bold';
    }
    spinnerWoyofal.classList.add('hidden');
    textWoyofal.textContent = 'Payer';
};
</script>
        </div>
    </div>
    </div>
    <!-- Historique des transactions -->
    <div class="flex justify-between items-center mb-8">
        <a href="/client/index" class="inline-flex items-center text-orange-600 hover:text-orange-500 font-medium transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Retour au tableau de bord
        </a>
        <h1 class="text-3xl font-bold text-white flex items-center">
            <i class="fas fa-exchange-alt text-orange-500 mr-3"></i>
            Historique des transactions
        </h1>
        <div class="w-24"></div>
    </div>

    <div class="bg-black border border-orange-500 rounded-xl shadow-orange-500/50 mb-8">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-orange-500">
                <thead class="bg-orange-500 text-black">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-black text-white">
                    <?php if (!empty($transactions)): ?>
                        <?php foreach ($transactions as $transaction): ?>
                            <tr class="border-b border-orange-500">
                                <td class="px-6 py-4 font-semibold">
                                    <?php echo htmlspecialchars($transaction['montant'] ?? $transaction->getMontant()); ?> FCFA
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo htmlspecialchars($transaction['typetransaction'] ?? $transaction->getTypeTransaction()); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-lg <?php echo ($transaction['status'] ?? $transaction->getStatus()) === 'Termine' ? 'bg-green-600' : 'bg-yellow-600'; ?> text-white">
                                        <?php echo htmlspecialchars($transaction['status'] ?? $transaction->getStatus()); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo htmlspecialchars($transaction['created_at'] ?? ($transaction['date'] ?? ($transaction->getCreatedAt() ? $transaction->getCreatedAt()->format('d/m/Y H:i') : ''))); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-orange-500">Aucune transaction trouvée.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="flex justify-between items-center mb-8">
        <a href="/client/index" class="inline-flex items-center text-orange-600 hover:text-orange-500 font-medium transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Retour au tableau de bord
        </a>
        <h1 class="text-3xl font-bold text-gray-900 flex items-center">
            <i class="fas fa-exchange-alt text-orange-500 mr-3"></i>
            Historique des transactions
        </h1>
        <div class="w-24"></div> <!-- Pour l'alignement -->
    </div>

    <!-- Filtres améliorés -->
    <div class="bg-black border-2 border-orange-500 rounded-xl shadow-orange-500/50 p-6 mb-8">
        <h2 class="text-lg font-semibold text-orange-500 mb-4 flex items-center">
            <i class="fas fa-filter text-orange-500 mr-2"></i>
            Filtres avancés
        </h2>
        <form method="get" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div>
                <label class="block text-sm font-medium text-orange-500 mb-1">Statut</label>
                <select name="status" class="w-full rounded-lg border-orange-500 focus:ring-orange-500 focus:border-orange-500 shadow-orange-500/50 bg-black text-white">
                    <option value="">Tous les statuts</option>
                    <?php foreach($statuts as $statut): ?>
                        <option value="<?= $statut ?>" <?= ($selectedStatus ?? '') === $statut ? 'selected' : '' ?>>
                            <?= ucfirst($statut) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-orange-500 mb-1">Type</label>
                <select name="type" class="w-full rounded-lg border-orange-500 focus:ring-orange-500 focus:border-orange-500 shadow-orange-500/50 bg-black text-white">
                    <option value="">Tous les types</option>
                    <?php foreach($types as $type): ?>
                        <option value="<?= $type ?>" <?= ($selectedType ?? '') === $type ? 'selected' : '' ?>>
                            <?= ucfirst($type) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-orange-500 mb-1">Recherche</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-orange-500"></i>
                    </div>
                    <input type="text" name="search" placeholder="" 
                           value="<?= htmlspecialchars($search ?? '') ?>" 
                           class="pl-10 w-full rounded-lg border-orange-500 focus:ring-orange-500 focus:border-orange-500 shadow-orange-500/50 bg-black text-white">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-orange-500 mb-1">Date début</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="far fa-calendar-alt text-orange-500"></i>
                    </div>
                    <input type="date" name="date_debut" value="<?= htmlspecialchars($dateDebut ?? '') ?>" 
                           class="pl-10 w-full rounded-lg border-orange-500 focus:ring-orange-500 focus:border-orange-500 shadow-orange-500/50 bg-black text-white">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-orange-500 mb-1">Date fin</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="far fa-calendar-alt text-orange-500"></i>
                    </div>
                    <input type="date" name="date_fin" value="<?= htmlspecialchars($dateFin ?? '') ?>" 
                           class="pl-10 w-full rounded-lg border-orange-500 focus:ring-orange-500 focus:border-orange-500 shadow-orange-500/50 bg-black text-white">
                </div>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg font-medium shadow-orange-500/50 transition flex items-center justify-center">
                    <i class="fas fa-filter mr-2"></i> Appliquer
                </button>
            </div>
        </form>
    </div>

    <!-- Tableau amélioré -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date/Heure</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($transactions)): ?>
                        <?php foreach ($transactions as $transaction): ?>
                            <tr class="hover:bg-orange-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= date('d/m/Y', strtotime($transaction['date'])) ?></div>
                                    <div class="text-sm text-gray-500"><?= date('H:i', strtotime($transaction['date'])) ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        <?php
                                        $status = strtolower($transaction['status']);
                                        if ($status === 'termine' || $status === 'terminer') echo 'bg-green-100 text-green-800';
                                        elseif ($status === 'annuler') echo 'bg-red-100 text-red-800';
                                        elseif ($status === 'en cours') echo 'bg-blue-100 text-blue-800';
                                        else echo 'bg-yellow-100 text-yellow-800';
                                        ?>">
                                        <?= htmlspecialchars($transaction['status']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <?php $icon = getTransactionIcon($transaction['typetransaction']); ?>
                                        <span class="text-sm font-medium text-gray-900">
                                            <?= htmlspecialchars($transaction['typetransaction']) ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold <?= $transaction['montant'] > 0 ? 'text-green-600' : 'text-red-600' ?>">
                                    <?= number_format($transaction['montant'], 0, ',', ' ') ?> CFA
                                </td>
                               
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i class="fas fa-exchange-alt text-4xl mb-3"></i>
                                    <h3 class="text-lg font-medium">Aucune transaction trouvée</h3>
                                    <p class="text-sm mt-1">Essayez de modifier vos filtres de recherche</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination améliorée -->
    <?php if (!empty($pagination) && $pagination['pages'] > 1): ?>
    <div class="flex items-center justify-between mt-8 px-4 py-3 bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Affichage de <span class="font-medium"><?= $pagination['start'] ?></span> à <span class="font-medium"><?= $pagination['end'] ?></span> sur <span class="font-medium"><?= $pagination['total'] ?></span> transactions
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <?php if ($pagination['page'] > 1): ?>
                        <a href="?<?= http_build_query(array_merge($_GET, ['page' => $pagination['page'] - 1])) ?>" 
                           class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Précédent</span>
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    <?php endif; ?>

                    <?php for ($i = max(1, $pagination['page'] - 2); $i <= min($pagination['pages'], $pagination['page'] + 2); $i++): ?>
                        <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"
                           class="<?= $i == $pagination['page'] ? 'z-10 bg-orange-50 border-orange-500 text-orange-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50' ?> relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($pagination['page'] < $pagination['pages']): ?>
                        <a href="?<?= http_build_query(array_merge($_GET, ['page' => $pagination['page'] + 1])) ?>" 
                           class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Suivant</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Fonction pour les icônes (à placer dans votre helper) -->
<?php 
function getTransactionIcon($type) {
    $icons = [
        'depot' => 'fas fa-money-bill-wave',
        'retrait' => 'fas fa-hand-holding-usd',
        'transfert' => 'fas fa-exchange-alt',
        'paiement' => 'fas fa-credit-card',
        'facture' => 'fas fa-file-invoice-dollar'
    ];
    return $icons[strtolower($type)] ?? 'fas fa-exchange-alt';
}
?>

<script>
function showDetails(transactionId) {
    // Implémentez la logique pour afficher les détails de la transaction
    console.log("Détails de la transaction:", transactionId);
    // Vous pourriez utiliser une modal ou une page séparée ici
}
</script>