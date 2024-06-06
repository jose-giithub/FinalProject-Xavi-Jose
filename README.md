Pasos para pasar de producción a local.

1 - Cambiar lo que esté comentado de Local, lo des comentamos y comentamos lo de producción.
2 - Buscamos el archivo "AppServiceProvider.php" y comentamos la parte que dice:
        \URL::forceScheme('https');
        \Illuminate\Support\Facades\URL::forceScheme('https');

3 - Hacemos los siguientes comandos en orden:
Remove-Item -Recurse -Force .\node_modules
Remove-Item .\package-lock.json
npm install
