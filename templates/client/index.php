<?php $errors = $errors ?? ''; ?>
<main class="flex-1 p-6 md:p-8 bg-black overflow-y-auto h-screen">
            <!-- Notification d'erreur -->
            <?php if ($errors): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
<main class="flex-1 p-6 md:p-8 bg-black overflow-y-auto min-h-screen">
                        <div class="mt-1 text-sm text-red-700">
                            <p><?= htmlspecialchars($errors) ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- En-tête -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2 flex items-center">
                    <span class="bg-gradient-to-r from-orange-500 to-orange-600 text-white p-2 rounded-lg mr-3">
                        <i class="fas fa-chart-line"></i>
                    </span>
                    Tableau de bord
                </h1>
                <p class="text-gray-600 text-lg">Bienvenue dans votre espace client, gérez vos finances en toute simplicité.</p>
            </div>

            <!-- Cartes statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                <!-- Carte Solde -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Solde total</p>
                                <h3 class="text-2xl font-bold text-gray-900">
                                    <?php if($comptePrincipal): ?>
                                        <?= number_format($comptePrincipal['solde'], 0, ',', ' ') ?> CFA
                                    <?php else: ?>
                                        0 CFA
                                    <?php endif; ?>
                                </h3>
                                <p class="mt-1 text-xs text-gray-500">Solde disponible</p>
                            </div>
                            <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-lg shadow-inner">
                                <i class="fas fa-wallet text-white text-2xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="#" class="text-xs font-medium text-orange-600 hover:text-orange-700 flex items-center">
                                Voir le détail <i class="fas fa-chevron-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Carte Compte principal -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Compte principal</p>
                                <h3 class="text-xl font-bold text-gray-900">
                                    <?php if($comptePrincipal): ?>
                                        <?= htmlspecialchars($comptePrincipal['numero']) ?>
                                    <?php else: ?>
                                        Non disponible
                                    <?php endif; ?>
                                </h3>
                                <p class="mt-1 text-xs text-gray-500">RIB: <?= $comptePrincipal ? htmlspecialchars($comptePrincipal['numeros']) : '---' ?></p>
                            </div>
                            <div class="w-16 h-16 flex items-center justify-center bg-white rounded-lg shadow-inner border border-gray-100">
                                <img src="/uploads/images/qrl.png" alt="QR Code" class="w-12 h-12 object-contain">
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-xs font-medium text-gray-500"><?= $comptePrincipal ? htmlspecialchars($comptePrincipal['typecompte']) : '---' ?></span>
                            <button class="text-xs font-medium text-orange-600 hover:text-orange-700 flex items-center">
                                <i class="fas fa-copy mr-1"></i> Copier
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Carte Nombre de comptes -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Nombre de comptes</p>
                                <h3 class="text-2xl font-bold text-gray-900">
                                    <?= count($comptesSecondaires) + ($comptePrincipal ? 1 : 0) ?>
                                </h3>
                                <div class="mt-1 flex items-center">
                                    <span class="text-xs font-medium bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                        <?= $comptePrincipal ? '1 principal' : '0 principal' ?>
                                    </span>
                                    <span class="ml-2 text-xs font-medium bg-purple-100 text-purple-800 px-2 py-1 rounded-full">
                                        <?= count($comptesSecondaires) ?> secondaireS 
                                    </span>
                                </div>
                            </div>
                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-lg shadow-inner">
                                <i class="fas fa-piggy-bank text-white text-2xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="/client/comptes" class="text-xs font-medium text-orange-600 hover:text-orange-700 flex items-center">
                                Gérer mes comptes <i class="fas fa-chevron-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Transactions récentes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                <!-- En-tête de section -->
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                            <span class="bg-gradient-to-r from-orange-500 to-orange-600 text-white p-2 rounded-lg mr-3">
                                <i class="fas fa-exchange-alt"></i>
                            </span>
                            Dernières transactions
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">Les 5 dernières opérations sur votre compte</p>
                    </div>
                    <a href="/client/transactions" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                        <i class="fas fa-history mr-2"></i> Voir tout
                    </a>
                </div>

                <!-- Tableau des transactions -->
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
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900"><?= date('d/m/Y', strtotime($transaction['date'])) ?></div>
                                            <div class="text-sm text-gray-500"><?= date('H:i', strtotime($transaction['date'])) ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php
                                            $statusClass = [
                                                'terminer' => 'bg-green-100 text-green-800',
                                                'annuler' => 'bg-red-100 text-red-800',
                                                'en cours' => 'bg-blue-100 text-blue-800',
                                                'default' => 'bg-yellow-100 text-yellow-800'
                                            ];
                                            $status = strtolower($transaction['status']);
                                            $class = $statusClass[$status] ?? $statusClass['default'];
                                            ?>
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?= $class ?>">
                                                <?= htmlspecialchars($transaction['status']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <?php
                                                $icons = [
                                                    'depot' ,
                                                    'retrait',
                                                    'transfert' ,
                                                    'paiement'
                                                ];
                                                $icon = $icons[strtolower($transaction['typetransaction'])] ?? '';
                                                ?>
                                                <i class="<?= $icon ?> mr-2"></i>
                                                <span class="text-sm font-medium text-gray-900">
                                                    <?= htmlspecialchars($transaction['typetransaction']) ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold <?= $transaction['montant'] > 0 ? 'text-green-600' : 'text-red-600' ?>">
                                            <?= ($transaction['montant'] > 0 ? '+' : '') . number_format($transaction['montant'], 0, ',', ' ') ?> CFA
                                        </td>
                                      
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <i class="fas fa-exchange-alt text-4xl mb-3"></i>
                                            <h3 class="text-lg font-medium">Aucune transaction récente</h3>
                                            <p class="text-sm mt-1">Vos transactions apparaîtront ici</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

           
        </main>
 