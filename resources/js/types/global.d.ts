import type { PageProps } from '@inertiajs/core';

declare module '@inertiajs/core' {
    interface PageProps {
        name: string;
        [key: string]: unknown;
    }
}
