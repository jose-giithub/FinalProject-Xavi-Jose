import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/estilosCarruselImg.css',
                'resources/css/EstilosFormularioTalleres.css', 
                'resources/css/EstilosMiTaller.css',
                'resources/css/EstilosTalleres.css',
                'resources/css/EstilosWelcome.css',
                'resources/css/headerNav.css', 
                'resources/css/miSeccion.css',
                'resources/css/footer.css',
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                'resources/js/jsMiSeccion.js',
                'resources/js/jsMitaller.js',
                'resources/js/formCreateTaller.js',
                'resources/js/welcome.js',
            ],
            refresh: true,
        }),
    ],
});

             
               
          
              
        

