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
    caches.keys().then(function(keyList) {
      console.log('Activating service worker...');
      self.clients.claim();
      keyList.forEach((key)=>{
        if (key !== cacheName) {
          caches.delete(key);
        }
      })
    })
    )
});


self.addEventListener('fetch', event=>{
  // Ignore any socket.io requests
  if (event.request.url.includes('socket.io')) {
    return;
  }
  // if (event.request.url.includes('api')) {
  //   event.respondWith(
  //     fetch(event.request).then(response=>{
  //       return response;
  //     }).catch(()=>{
  //       var data = {"errorCode":"OK","error":"OK","data":{"id":"1","username":"admin","isadmin":"1","sections":null}};
  //       var blob = new Blob([JSON.stringify(data)], {type : 'application/json'});
  //       var init = { "status" : 200 };
  //       return new Response(blob, init);
  //
  //     })
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
        })
        return response;
      })
    })
  )
})