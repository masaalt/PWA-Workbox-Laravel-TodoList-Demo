importScripts(
	'https://storage.googleapis.com/workbox-cdn/releases/6.3.0/workbox-sw.js'
);

workbox.precaching.precacheAndRoute(self.__WB_MANIFEST);

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

