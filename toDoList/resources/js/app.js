require('./bootstrap');
import { openDB, deleteDB, wrap, unwrap } from 'idb';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

function createIndexedDB() {
  const dbPromise = openDB('dashboardr', 1, {
    upgrade(db) {
      db.createObjectStore('events', {keyPath: 'id', autoIncrement: true});
    },
  });
  return dbPromise;
}
  // create indexedDB database
// var request1 = indexedDB.open("dashboardr", 1);
// request1.onsuccess = function(event) {
//   var db = request1.result;
//   var transaction = db.transaction(['events'], 'readonly');
//   var objectStore = transaction.objectStore('events');

//   var countRequest = objectStore.count();
//   if (countRequest > 1){
//     var DBDeleteRequest = window.indexedDB.deleteDatabase("dashboardr");
//   }
// }
var dbPromise
// if(navigator.onLine){
  dbPromise = createIndexedDB();
// }

function saveEventDataLocally(events) {
  if (!('indexedDB' in window)) {return null;}
  return dbPromise.then(db => {
    const tx = db.transaction('events', 'readwrite');
    const store = tx.objectStore('events');
    
    return Promise.all(events.map(event => {
      store.put({event});
      
      }))
    .catch(() => {
      tx.abort();
      throw Error('Events were not added to the store');
    });
  });
}

function getServerData() {
  return fetch('/getdata').then(response => {
    if (!response.ok) {
      throw Error(response.statusText);
    }
    return response.json();
  });
}

function updateUI(events) {

}

loadContentNetworkFirst();
function loadContentNetworkFirst() {
  getServerData()
  .then(dataFromNetwork => {
    updateUI(dataFromNetwork);
    saveEventDataLocally(dataFromNetwork)
    .then(() => {
      setLastUpdated(new Date());
      messageDataSaved();
    }).catch(err => {
      messageSaveError();
      console.warn(err);
    });
  }).catch(err => {
    console.log('Network requests have failed, this is expected if offline');
    getLocalEventData()
    .then(offlineData => {
      if (!offlineData.length) {
        messageNoData();
      } else {
        messageOffline();
        updateUI(offlineData); 
      }
    });
  });
}
function messageSaveError(err) {
  // alert user that data couldn't be saved offline
  // alert("error:"+err);
}

function messageDataSaved() {
  // alert user that data has been saved for offline
  const lastUpdated = getLastUpdated();
  // if (lastUpdated) {dataSavedMessage.textContent += ' on ' + lastUpdated;}
  // if (lastUpdated) {alert("updated on: "+lastUpdated)}

  // dataSavedMessage.style.display = 'block';
}
function getLastUpdated() {
  return localStorage.getItem('lastUpdated');
}

function setLastUpdated(date) {
  localStorage.setItem('lastUpdated', date);
}

function addAndPostEvent() {
  // ...
  // TODO - save event data locally
  saveEventDataLocally([data]);
  // ...
}

function getLocalEventData() {
  if (!('indexedDB' in window)) {return null;}
  return dbPromise.then(db => {
    const tx = db.transaction('events', 'readonly');
    const store = tx.objectStore('events');
    return store.getAll();
  });
}

function messageOffline() {
  // alert user that data may not be current
  const lastUpdated = getLastUpdated();
  if (lastUpdated) {
    // alert(' Last fetched server data: ' + lastUpdated) ;
  }
  // offlineMessage.style.display = 'block';
}

function messageNoData() {
  // alert user that there is no data available
  // alert(' No data! ') ;
}