<?php
?>

<div class="flex min-h-screen bg-black">
  <!-- Sidebar -->
  <aside class="w-64 bg-black border-r-2 border-orange-500 flex flex-col py-8 px-4 shadow-orange-500/50 fixed top-0 left-0 h-full z-40">
    <div class="mb-10 flex items-center gap-2">
      <span class="bg-orange-500 p-2 rounded-md text-white font-bold text-lg">MAX</span>
      <span class="text-white font-bold text-xl">ITSA</span>
    </div>
    <nav class="flex-1 flex flex-col gap-4">
      <a href="/client/index" class="flex items-center gap-2 px-4 py-2 rounded-lg text-white hover:bg-orange-500 transition-colors">
        <i class="fas fa-home"></i> Tableau de bord
      </a>
      <a href="/client/transactions" class="flex items-center gap-2 px-4 py-2 rounded-lg text-white hover:bg-orange-500 transition-colors">
        <i class="fas fa-list"></i> Transactions
      </a>
      <a href="/client/comptes" class="flex items-center gap-2 px-4 py-2 rounded-lg text-white hover:bg-orange-500 transition-colors">
        <i class="fas fa-wallet"></i> Comptes
      </a>
      <button id="btnWoyofal" class="flex items-center gap-2 px-4 py-2 rounded-lg text-white bg-orange-500 hover:bg-orange-600 transition-colors mt-4 font-bold">
        <i class="fas fa-bolt"></i> Paiement Woyofal
      </button>
      <a href="/logout" class="flex items-center gap-2 px-4 py-2 rounded-lg text-white hover:bg-red-600 transition-colors mt-auto">
        <i class="fas fa-sign-out-alt"></i> Déconnexion
      </a>
    </nav>
  </aside>

  <main class="flex-1 p-6 md:p-8 bg-black overflow-y-auto ml-64" style="max-height: calc(100vh - 80px);">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
        Historique des transactions
      </h1>
      <p class="text-gray-400 text-lg">Consultez toutes vos opérations récentes.</p>
    </div>

    <!-- Filtres avancés -->
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
      </form>
    </div>

    <!-- Tableau des transactions -->
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
                <td colspan="4" class="px-6 py-12 text-center">
                  <div class="flex flex-col items-center justify-center text-gray-400">
                    <i class="fas fa-info-circle text-orange-500 text-4xl mb-3"></i>
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
        'retrait' => 'fas fa-hand-holding-usd',
        'transfert' => 'fas fa-exchange-alt',
        'paiement' => 'fas fa-credit-card',
        'facture' => 'fas fa-file-invoice-dollar'
    ];
    return $icons[strtolower($type)] ?? 'fas fa-exchange-alt';
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
            ...existing code...
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

    <!-- Pagination -->
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

    <!-- Modal Paiement Woyofal -->
    <div id="modalWoyofal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden">
      <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
        <form id="formWoyofal">
          <h2 class="text-2xl font-bold mb-4 text-black">Paiement Woyofal</h2>
          <div class="mb-4">
            <label for="montantWoyofal" class="block text-sm font-medium text-black mb-2">Montant</label>
            <input type="number" id="montantWoyofal" name="montant" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
          </div>
          <div class="flex items-center gap-2 mb-4">
            <span id="spinnerWoyofal" class="hidden w-5 h-5 border-2 border-orange-500 border-t-transparent rounded-full animate-spin"></span>
            <span id="textWoyofal">Payer</span>
          </div>
          <div id="resultWoyofal" class="mt-2 text-sm"></div>
          <div class="flex justify-end mt-6">
            <button type="button" id="closeWoyofal" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700">Fermer</button>
            <button type="submit" class="ml-2 px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600">Valider</button>
          </div>
        </form>
      </div>
    </div>
    <script type="module" src="/assets/js/paiementWoyofal.js"></script>
  </main>
</div>