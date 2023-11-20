import './bootstrap';

import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createTheme, ThemeProvider } from '@mui/material/styles';
const defaultTheme = createTheme();

const appName = import.meta.env.VITE_APP_NAME || 'Bion';


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.jsx`, import.meta.glob('./Pages/**/*.jsx')),
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(    <ThemeProvider theme={defaultTheme}>
            <App {...props} />
        </ThemeProvider>);
    },
    progress: {
        color: '#4B5563',
    },
});
