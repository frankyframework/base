<?php 
use Franky\Filesystem\File;
$File = new File();
header("Content-type: text/javascript"); ?>
var cacheName = 'mylines-v-2-1';
var filesToCache = [
    '/index.php'
];

<?php
$files = $File->getFiles(PROJECT_DIR."/public/cache/css/");
foreach($files as $file):
        if(substr($file,-4) =='.css' && file_exists(PROJECT_DIR."/public/cache/css/".$file)):
?>
filesToCache.push('/public/cache/css/<?php echo $file; ?>');
<?php endif;
 endforeach; ?>

<?php
$files = $File->getFiles(PROJECT_DIR."/public/cache/js/");
foreach($files as $file):
        if(substr($file,-3) =='.js' && file_exists(PROJECT_DIR."/public/cache/js/".$file)):
?>
filesToCache.push('/public/cache/js/<?php echo $file; ?>');
<?php endif;
 endforeach; ?>





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


    e.respondWith(
        caches.match(e.request).then(function(response) {
        return response || fetch(e.request);
        })
    );
    
});
