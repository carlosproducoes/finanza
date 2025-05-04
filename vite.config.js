import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import { glob } from 'glob';

const cssFiles = glob.sync(path.resolve(__dirname, 'resources/css/**/*.css'));
const jsFiles = glob.sync(path.resolve(__dirname, 'resources/js/**/*.js'));

export default defineConfig({
    plugins: [
        laravel({
            input: [
                ...cssFiles,
                ...jsFiles
            ],
            refresh: true,
        }),
    ],
});
