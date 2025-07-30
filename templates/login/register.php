<?php
$errors = $_SESSION['flash_errors'] ?? [];
$formData = $_SESSION['flash_formData'] ?? [];
unset($_SESSION['flash_errors'], $_SESSION['flash_formData']);
$comptes = $_SESSION['comptesSecondaires'] ?? [];
$comptePrincipal = $_SESSION['comptePrincipal'] ?? null;
$transactions = $_SESSION['transactions'] ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inscription</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
  <div class="bg-black border-2 rounded-lg p-8 w-full max-w-4xl mx-auto shadow-lg shadow-orange-500 mt-10">
    <div class="text-center mb-8">
      <h2 class="text-4xl font-bold text-white mb-2">Inscription</h2>
      <div class="w-12 h-1 bg-orange-500 mx-auto rounded-full"></div>
    </div>

    <?php if (!empty($errors['global'])): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm mb-4">
        <div><?php echo htmlspecialchars($errors['global']); ?></div>
      </div>
    <?php endif; ?>
    
    <?php if (!empty($_SESSION['flash_success'])): ?>
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm mb-4">
        <?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
      </div>
    <?php endif; ?>

    <form action="/register" method="post" id="registerForm" autocomplete="off">
      <!-- NCI -->
      <div class="mb-6 relative">
        <label class="block text-lg font-semibold text-orange-500 mb-2">Numéro de Carte d'Identité (NCI)</label>
        <div class="relative">
          <input
            autocomplete="off"
            type="text"
            name="numerosCarteIdentite"
            id="numerosCarteIdentite"
            placeholder="Entrez votre NCI"
            class="w-full px-4 py-3 pr-12 rounded-lg border border-orange-400 focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition-all duration-200"
            value=""
          >
          <!-- Spinner -->
          <div role="status" class="absolute hidden right-3 top-1/2 -translate-y-1/2" id="spinner">
            <svg aria-hidden="true" class="w-6 h-6 text-gray-200 animate-spin dark:text-gray-600 fill-red-600" viewBox="0 0 100 101" xmlns="http://www.w3.org/2000/svg">
              <circle cx="50" cy="50" r="45" stroke="currentColor" stroke-width="10" fill="none" />
              <path fill="currentColor" d="M100 50a50 50 0 01-50 50V90a40 40 0 0040-40h10z"/>
            </svg>
            <span class="sr-only">Loading...</span>
          </div>
          <!-- Messages -->
          <div class="messages mt-2">
            <div class="success-message hidden text-green-600 bg-green-50 border border-green-200 rounded px-2 py-1"></div>
            <div class="error-message hidden text-red-600 bg-red-50 border border-red-200 rounded px-2 py-1"></div>
          </div>
        </div>
        <?php if (!empty($errors['numerosCarteIdentite'])): ?>
          <div class="text-sm text-red-600"><?php echo htmlspecialchars($errors['numerosCarteIdentite'][0]); ?></div>
        <?php endif; ?>
        <button type="button" id="verifierNciBtn" class="mt-4 w-full bg-orange-500 text-white py-2 rounded-lg font-semibold hover:bg-orange-600 transition-colors duration-200">Vérifier le NCI</button>
      </div>

      <!-- Champs Auto-Remplis -->
      <div id="autofillFields" style="display: none;">
        <div class="grid grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-white mb-2">Prénom</label>
            <input type="text" name="prenom" id="prenom" class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900" value="">
          </div>
          <div>
            <label class="block text-sm font-medium text-white mb-2">Nom</label>
            <input type="text" name="nom" id="nom" class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900" value="">
          </div>
          <div>
            <label class="block text-sm font-medium text-white mb-2">Date de naissance</label>
            <input type="date" name="date_naissance" id="date_naissance" class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900" value="">
          </div>
          <div>
            <label class="block text-sm font-medium text-white mb-2">Lieu de naissance</label>
            <input type="text" name="lieu_naissance" id="lieu_naissance" class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900" value="">
          </div>
          <div>
            <label class="block text-sm font-medium text-white mb-2">Téléphone</label>
            <input type="text" name="phone" id="phone" class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900" value="">
          </div>
          <div>
            <label class="block text-sm font-medium text-white mb-2">Mot de passe</label>
            <input type="password" name="password" id="password" class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900" value="">
          </div>
          <div>
            <label class="block text-sm font-medium text-white mb-2">Copie CNI</label>
            <input type="text" name="copie_cni" id="copie_cni" class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900" value="">
          </div>
          <div>
            <label class="block text-sm font-medium text-white mb-2">Adresse</label>
            <input type="text" name="adresse" id="adresse" class="w-full px-4 py-3 rounded-lg border border-white text-gray-900" value="">
          </div>
        </div>

        <!-- Submit -->
        <button type="submit" id="submitBtn" class="w-full bg-gray-800 text-white py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors duration-200 transform hover:scale-105 mt-8">
          <span id="submitText">Valider</span>
        </button>
      </div>
    </form>

    <!-- JS -->
    <script type="module" src="/assets/js/register.js"></script>
  </div>
</body>
</html>
