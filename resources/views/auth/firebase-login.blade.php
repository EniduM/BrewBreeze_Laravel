@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center">
    <div class="w-full max-w-md p-8 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-center">Login with Firebase</h2>
        <div class="mb-4">
            <input type="text" id="phone" class="w-full border rounded px-3 py-2 mt-1" placeholder="+1234567890">
            <div id="recaptcha-container" class="my-2"></div>
            <button id="send-otp" class="w-full bg-blue-600 text-white py-2 rounded mt-2">Send OTP</button>
        </div>
        <div class="mb-4">
            <input type="text" id="otp" class="w-full border rounded px-3 py-2 mt-1" placeholder="Enter OTP">
            <button id="verify-otp" class="w-full bg-green-600 text-white py-2 rounded mt-2">Verify OTP</button>
        </div>
        <div class="mb-4 text-center">
            <button id="google-login" class="w-full bg-red-600 text-white py-2 rounded">Login with Google</button>
        </div>
    </div>
</div>

<!-- Firebase JS SDK -->
<script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js"></script>
<script>
  // Your Firebase config
  const firebaseConfig = {
    apiKey: "AIzaSyDKOqzoCjOulZn8fIwY5v_UrrxZ_XueGLs",
    authDomain: "brewbreeze-ee80c.firebaseapp.com",
    projectId: "brewbreeze-ee80c",
    storageBucket: "brewbreeze-ee80c.firebasestorage.app",
    messagingSenderId: "309600597975",
    appId: "1:309600597975:web:af0d2f2f5e59cb41f07d92"
  };
  firebase.initializeApp(firebaseConfig);

  // Phone OTP
  window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
    'size': 'normal',
    'callback': function(response) {}
  });

  document.getElementById('send-otp').onclick = function() {
    const phoneNumber = document.getElementById('phone').value;
    firebase.auth().signInWithPhoneNumber(phoneNumber, window.recaptchaVerifier)
      .then(confirmationResult => {
        window.confirmationResult = confirmationResult;
        alert('OTP sent!');
      })
      .catch(error => {
        alert(error.message);
      });
  };

  document.getElementById('verify-otp').onclick = function() {
    const code = document.getElementById('otp').value;
    window.confirmationResult.confirm(code)
      .then(result => {
        result.user.getIdToken().then(idToken => {
          // Send idToken to backend for login
          fetch('/firebase-login', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({idToken})
          }).then(res => res.json()).then(data => {
            if(data.success) window.location.href = '/';
            else alert('Login failed');
          });
        });
      })
      .catch(error => {
        alert(error.message);
      });
  };

  // Google Login
  document.getElementById('google-login').onclick = function() {
    const provider = new firebase.auth.GoogleAuthProvider();
    firebase.auth().signInWithPopup(provider)
      .then(result => {
        result.user.getIdToken().then(idToken => {
          fetch('/firebase-login', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({idToken})
          }).then(res => res.json()).then(data => {
            if(data.success) window.location.href = '/';
            else alert('Login failed');
          });
        });
      })
      .catch(error => {
        alert(error.message);
      });
  };
</script>
@endsection
