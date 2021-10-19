importScripts(
	'https://storage.googleapis.com/workbox-cdn/releases/6.3.0/workbox-sw.js'
);

workbox.precaching.precacheAndRoute([{"revision":"92b0837da49d63408436561de84ff601","url":"css/app.css"},{"revision":"9572574ebaaa2428b43ec7f1a117a02a","url":"index.php"},{"revision":"b5dee8dfca094424058fc9af9ca5987b","url":"js/app.js"},{"revision":"851240c821931f2db8df81384cf8f23f","url":"logo.png"},{"revision":"8d488693b942987b005cf9b80346c6a5","url":"workbox-176fe0b1.js"},{"revision":"fe70389af4b5dc39a15cbc8bbe64b3a2","url":"offline.html"}]);

workbox.routing.registerRoute(
	new RegExp('/.*\/task\/.*/,'),
	new workbox.strategies.StaleWhileRevalidate({
		cacheName: 'task',
		plugins: [
			new workbox.expiration.ExpirationPlugin({
				maxEntries: 1000
			}),
			new workbox.cacheableResponse.CacheableResponsePlugin({
				statuses: [200]
			})
		]
	})
);

const networkFirstHandler = new workbox.strategies.NetworkFirst({
	cacheName: 'dynamic',
	plugins: [
		new workbox.expiration.ExpirationPlugin({
			maxEntries: 500
		}),
		new workbox.cacheableResponse.CacheableResponsePlugin({
			statuses: [200]
		})
	]
});

const FALLBACK_URL = workbox.precaching.getCacheKeyForURL('/offline.html');
const matcher = ({ event }) => event.request.mode === 'navigate';
const handler = args =>
	networkFirstHandler
		.handle(args)
		.then(response => response || caches.match(FALLBACK_URL))
		.catch(() => caches.match(FALLBACK_URL));

workbox.routing.registerRoute(matcher, handler);

const showNotification = () => {
	self.registration.showNotification('Background sync success!', {
	  body: '🎉`🎉`🎉`'
	});
  };
  
const bgSyncPlugin = new workbox.backgroundSync.BackgroundSyncPlugin(
	'dashboardr-queue',
	{
		callbacks: {
		  queueDidReplay: showNotification
		  // other types of callbacks could go here
		},
		
	  });

const networkWithBackgroundSync = new workbox.strategies.NetworkOnly({
  plugins: [bgSyncPlugin],
});

workbox.routing.registerRoute(
	/\/task/,
  networkWithBackgroundSync,
  'POST'
);
// workbox.routing.registerRoute(
// 	/\/task\/{task}/,
// 	networkWithBackgroundSync
//   );
workbox.routing.registerRoute(
	/\/send/,
	networkWithBackgroundSync,
    'POST'
  );

