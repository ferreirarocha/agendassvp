const CACHE = 'agenda-v1';

self.addEventListener('install', e => {
    e.waitUntil(
        caches.open(CACHE).then(cache => cache.addAll([
            '/offline.html',
            '/style.css',
            'https://ccej.mailsfera.com.br/img/logo.webp'
        ]))
    );
});

self.addEventListener('fetch', e => {
    // Só intercepta navegação (não assets)
    if (e.request.mode === 'navigate') {
        e.respondWith(
            fetch(e.request).catch(() => caches.match('/offline.html'))
        );
        return;
    }
    // Assets: tenta cache primeiro
    e.respondWith(
        caches.match(e.request).then(cached => cached || fetch(e.request))
    );
});