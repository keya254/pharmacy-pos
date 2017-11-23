var cacheName = 'offline_'+ new Date().getTime();
var urlsToCache = [
  '/',
  '/assets/js/wpos/core.js',
  '/service-worker.js',
  '/api/stock/get'
];
self.addEventListener('install', (event)=>{
  event.waitUntil(
    caches.open(cacheName).then(cache=>{
      self.skipWaiting();
      console.log('Service worker installed, adding cache items...', urlsToCache);
      return cache.addAll(urlsToCache);
    })
  )
});


self.addEventListener('activate', event=>{
  event.waitUntil(
    // console.log('Activating service worker...')
    self.clients.claim()
  )
});


self.addEventListener('fetch', event=>{
  event.respondWith(
    caches.match(event.request).then(response=>{
      if (response) {
        return response;
      }
      var fetchRequest = event.request;
      return fetch(fetchRequest, { credentials: 'include' }).then(response=>{
        if(!response || response.status !== 200 || response.type !== 'basic') {
          return response;
        }
        var responseToCache = response.clone();
        caches.open(cacheName).then(cache=>{
          cache.put(event.request, responseToCache);
        })
        return response;
      })
    })
  )
})