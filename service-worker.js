var cacheName = 'offline_'+ new Date().toISOString();
var urlsToCache = [
  '/',
  '/assets/js/wpos/core.js',
  '/service-worker.js'
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
    caches.keys().then(function(keyList) {
      console.log('Activating service worker...');
      self.clients.claim()
      return Promise.all(keyList.map(function(key) {
        if (cacheWhitelist.indexOf(key) === -1) {
          return caches.delete(key);
        }
      }));
    })
    )
});


self.addEventListener('fetch', event=>{
  // if (event.request.url.includes('hello')) {
  //   event.respondWith(
  //     return new Response({"errorCode":"OK","error":"OK","data":{"id":"1","username":"admin","isadmin":"1","sections":null}}, {headers: { 'Content-Type': 'text/html' }})
  //   );
  // }
  event.respondWith(
    caches.match(event.request).then(response=>{
      if (response) {
        return response;
      }
      var fetchRequest = event.request;
      return fetch(fetchRequest).then(response=>{
        if(!response || response.status !== 200 || response.type !== 'basic') {
          return response;
        }
        var responseToCache = response.clone();
        caches.open(cacheName).then(cache=>{
          cache.put(event.request, responseToCache);
        });
        return response;
      })
    })
  )
});