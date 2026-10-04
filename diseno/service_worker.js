<?php 
use Franky\Filesystem\File;
$File = new File();
header("Content-type: text/javascript"); ?>
var cacheName = 'franky-v-'+ <?=str_replace(".","-",getCoreConfig('base/debug/cacheversion'))?>;
var filesToCache = [
    '/index.php'
];
<?php
if (!empty(getCoreConfig('base/theme/favicon')) && file_exists(PROJECT_DIR.getCoreConfig('base/theme/favicon'))){
?>
filesToCache.push('<?=getCoreConfig('base/theme/favicon')?>');
<?php
}
?>
<?php
if (!empty(getCoreConfig('base/theme/logo')) && file_exists(PROJECT_DIR.getCoreConfig('base/theme/logo'))){
?>
filesToCache.push('<?=getCoreConfig('base/theme/logo')?>');
<?php
}
?>
<?php
if (file_exists(PROJECT_DIR."/public/cache/css/".getCoreConfig('base/debug/cacheversion')."/bundle.css")){
?>
filesToCache.push('/public/cache/css/<?=getCoreConfig('base/debug/cacheversion')?>/bundle.css');
<?php
}
?>
<?php
if (file_exists(PROJECT_DIR."/public/cache/js/".getCoreConfig('base/debug/cacheversion')."/bundle.js")){
?>
filesToCache.push('/public/cache/js/<?=getCoreConfig('base/debug/cacheversion')?>/bundle.js');
<?php
}
?>




self.addEventListener('install', function(e) {
  console.log('[ServiceWorker] Install');
  e.waitUntil(
    caches.open(cacheName).then(function(cache) {
      console.log('[ServiceWorker] Caching app shell');
      return cache.addAll(filesToCache);
    })
  );
});

self.addEventListener('activate', function(e) {
    console.log('[ServiceWorker] Activate');
    var cacheWhitelist = [cacheName];

    e.waitUntil(
        caches.keys().then(function(keyList) {
            return Promise.all(keyList.map(function(cacheName) {
                if (cacheWhitelist.indexOf(cacheName) === -1) {
                    console.log('[ServiceWorker] Removing old cache', cacheName);
                    return caches.delete(cacheName);
                }
            }));
        })
    );
   return self.clients.claim();
});


self.addEventListener('fetch', function(e) {

  if (e.request.url.includes('accounts.google.com')) {
    return;
  }
  e.respondWith(
      caches.match(e.request).then(function(response) {
      return response || fetch(e.request);
      })
  );
  
});