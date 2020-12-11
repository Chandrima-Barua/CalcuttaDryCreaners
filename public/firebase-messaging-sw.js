importScripts('https://www.gstatic.com/firebasejs/6.3.4/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/6.3.4/firebase-messaging.js');
// Initialize Firebase
var config = {
    apiKey: "AIzaSyBpFxSa4BJKOaexvHM8I-VuU5DhlrzfhYo",
    authDomain: "cdcleaners-669c5.firebaseapp.com",
    databaseURL: "https://cdcleaners-669c5.firebaseio.com",
    projectId: "cdcleaners-669c5",
    storageBucket: "cdcleaners-669c5.appspot.com",
    messagingSenderId: "679581830144",
    appId: "1:679581830144:web:a6c9d316af46a51605dce5",
    measurementId: "G-1XSDHJ822T"
};


firebase.initializeApp(config);

const messaging = firebase.messaging();