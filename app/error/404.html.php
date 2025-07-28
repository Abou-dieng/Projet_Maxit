<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-30px); }
            60% { transform: translateY(-15px); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: rotate(-15deg) scale(1); }
            50% { transform: rotate(-15deg) scale(1.05); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes balloon-float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-15px) rotate(2deg); }
            66% { transform: translateY(-10px) rotate(-2deg); }
        }
        
        .bounce-animation { animation: bounce 2s infinite; }
        .pulse-animation { animation: pulse 3s infinite; }
        .float-animation { animation: float 4s ease-in-out infinite; }
        .balloon-animation { animation: balloon-float 5s ease-in-out infinite; }
    </style>
</head>
<body class="bg-black min-h-screen flex items-center justify-center overflow-hidden relative">
    
    <!-- Sticker orange/noir -->
    <div class="absolute top-5 right-5 w-32 h-32 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center shadow-2xl pulse-animation">
        <div class="w-24 h-24 border-4 border-black rounded-full bg-black bg-opacity-20 flex items-center justify-center">
            <div class="text-black font-bold text-sm uppercase tracking-wider text-center leading-tight">
                ERROR<br>404
            </div>
        </div>
    </div>

    <!-- Ballons flottants -->
    <!-- Ballon 1 -->
    <div class="absolute top-20 left-10 balloon-animation" style="animation-delay: 0s;">
        <div class="w-12 h-16 bg-gradient-to-b from-orange-400 to-orange-500 rounded-full shadow-lg"></div>
        <div class="w-0.5 h-8 bg-orange-300 mx-auto"></div>
    </div>
    
    <!-- Ballon 2 -->
    <div class="absolute top-32 right-20 balloon-animation" style="animation-delay: 1s;">
        <div class="w-10 h-14 bg-gradient-to-b from-orange-500 to-orange-600 rounded-full shadow-lg"></div>
        <div class="w-0.5 h-6 bg-orange-300 mx-auto"></div>
    </div>
    
    <!-- Ballon 3 -->
    <div class="absolute top-60 left-32 balloon-animation" style="animation-delay: 2s;">
        <div class="w-14 h-18 bg-gradient-to-b from-orange-300 to-orange-400 rounded-full shadow-lg"></div>
        <div class="w-0.5 h-10 bg-orange-200 mx-auto"></div>
    </div>
    
    <!-- Ballon 4 -->
    <div class="absolute bottom-40 right-32 balloon-animation" style="animation-delay: 3s;">
        <div class="w-11 h-15 bg-gradient-to-b from-orange-600 to-orange-700 rounded-full shadow-lg"></div>
        <div class="w-0.5 h-7 bg-orange-400 mx-auto"></div>
    </div>
    
    <!-- Ballon 5 -->
    <div class="absolute bottom-20 left-20 balloon-animation" style="animation-delay: 4s;">
        <div class="w-13 h-17 bg-gradient-to-b from-orange-400 to-orange-500 rounded-full shadow-lg"></div>
        <div class="w-0.5 h-9 bg-orange-300 mx-auto"></div>
    </div>
    
    <!-- Ballon 6 -->
    <div class="absolute top-1/2 left-16 balloon-animation" style="animation-delay: 1.5s;">
        <div class="w-9 h-12 bg-gradient-to-b from-orange-500 to-orange-600 rounded-full shadow-lg"></div>
        <div class="w-0.5 h-5 bg-orange-300 mx-auto"></div>
    </div>
    
    <!-- Ballon 7 -->
    <div class="absolute top-1/3 right-16 balloon-animation" style="animation-delay: 2.5s;">
        <div class="w-12 h-16 bg-gradient-to-b from-orange-300 to-orange-400 rounded-full shadow-lg"></div>
        <div class="w-0.5 h-8 bg-orange-200 mx-auto"></div>
    </div>

    <!-- Contenu principal -->
    <div class="text-center text-orange-500 z-10 px-8">
        <h1 class="text-9xl font-bold mb-6 bounce-animation">
            404
        </h1>
        
        <p class="text-2xl mb-8 font-light text-orange-400">
            Cette page n'existe pas.
        </p>
        
        <button 
            onclick="history.back()" 
            class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-black font-bold py-4 px-8 rounded-full uppercase tracking-wide transition-all duration-300 transform hover:scale-105 hover:shadow-2xl shadow-lg border-2 border-orange-400"
        >
            Retour
        </button>
    </div>

    <!-- Particules flottantes orange -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-orange-400 rounded-full opacity-60 animate-ping"></div>
        <div class="absolute top-3/4 right-1/4 w-3 h-3 bg-orange-500 rounded-full opacity-50 animate-ping" style="animation-delay: 1.5s;"></div>
        <div class="absolute top-1/2 left-1/3 w-1 h-1 bg-orange-300 rounded-full opacity-70 animate-ping" style="animation-delay: 2.5s;"></div>
        <div class="absolute bottom-1/4 right-1/3 w-2 h-2 bg-orange-600 rounded-full opacity-40 animate-ping" style="animation-delay: 3.5s;"></div>
    </div>

    <!-- Effet de lueur orange -->
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-orange-500 rounded-full opacity-10 blur-3xl"></div>

</body>
</html>