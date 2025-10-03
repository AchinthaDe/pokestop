import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    safelist: [
        // Admin panel custom classes (static, not referenced in markup by Tailwind utilities)
        'admin-root','admin-sidebar','admin-main','admin-text','admin-heading','admin-title',
        'admin-badge','admin-badge.success','admin-badge.warn','admin-badge.danger','admin-badge.info',
        'admin-table','admin-panel','admin-action-bar','admin-input','admin-select','admin-textarea',
        'admin-btn','admin-btn-sm','admin-muted','admin-grid-2','status-paid','status-delivered',
        'status-pending','status-processing','status-shipped','status-cancelled'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
