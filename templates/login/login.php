<?php
$formData = $_SESSION['flash_formData'] ?? [];
$errors = $_SESSION['flash_errors'] ?? [];
unset($_SESSION['flash_errors']);
?>
<div class="bg-black border-2 rounded-lg p-8 w-[120%]  shadow-lg shadow-orange-500/50 flex items-center justify-center min-h-auto">
    <div class="flex flex-col lg:flex-row items-center justify-center gap-8 w-full">
        <!-- Section gauche - Présentation -->
        <div class="flex-1 w-[110%] h-[60vh] text-white">
            <img class="w-[100%] h-[100%] rounded-lg" src="/uploads/images/image.png" alt="Photo">
        </div>
        <!-- Section droite - Formulaire de connexion -->
        <div class="flex-1 max-w-md w-full h-[60vh]">
            <div class="bg-black rounded-2xl  p-8 space-y-12">
                <div class="text-center">
                    <h2 class="text-5xl font-bold text-white mb-2">MAX <span class="text-orange-500">IT</span>SA</h2>
                    <div class="w-12 h-1 bg-orange-500 mx-auto rounded-full"></div>
                </div>
                <?php if (!empty($errors['global'])): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm mb-4">
                        <div><?php echo is_array($errors['global']) ? implode('<br>', array_map('htmlspecialchars', $errors['global'])) : htmlspecialchars($errors['global']); ?></div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($_SESSION['flash_success'])): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm mb-4">
                        <?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
                    </div>
                <?php endif; ?>
                <form action="/login" method="POST" class="space-y-4 ">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Entrez votre numéro
                        </label>
                        <input 
                            type="text" 
                            name="login"
                            placeholder="Entrez votre numéro"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition-all duration-200"
                            value="<?php echo htmlspecialchars(isset($formData['login']) && $formData['login'] !== null ? (string)$formData['login'] : ''); ?>"
                        >
                        <?php if (!empty($errors['login'])): ?>
                            <div class="text-sm text-red-600"><?php echo is_array($errors['login']) ? implode('<br>', array_map('htmlspecialchars', $errors['login'])) : htmlspecialchars($errors['login']); ?></div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Entrer votre mot de passe
                        </label>
                        <input 
                            type="password" 
                            name="password"
                            placeholder="Mot de passe"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition-all duration-200"
                            autocomplete="new-password"
                        >
                        <?php if (!empty($errors['password'])): ?>
                            <div class="text-sm text-red-600"><?php echo is_array($errors['password']) ? implode('<br>', array_map('htmlspecialchars', $errors['password'])) : htmlspecialchars($errors['password']); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="text-right">
                        <a href="forgot-password.php" class="text-sm text-orange-600 hover:text-orange-700 transition-colors">
                            Mot de passe oublié?
                        </a>
                    </div>
                    <button 
                        type="submit"
                        class="w-full bg-gray-800 text-white py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors duration-200 transform hover:scale-105"
                    >
                        Se connecter
                    </button>
                    <div class="text-center">
                        <span class="text-gray-500 text-sm">ou</span>
                    </div>
                    <a 
                        href="/login/register"
                        class="w-full block text-center bg-white border-2 border-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors duration-200"
                    >
                        Créer Compte
                    </a>
                </form>
            </div>
        </div>
    </div>

