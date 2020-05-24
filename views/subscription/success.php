<h1>
    Susbscripción activa! 
    <br>
    <h2>Ya tienes acceso a tu cuenta de Slapp Invoice!</h2>
</h1>
<br>
<button class="btn btn- bg-blue grow" onclick="go_to('dashboard')"> Volver al dashboard</button>



<script>
      var urlParams = new URLSearchParams(window.location.search);
      var sessionId = urlParams.get("session_id");
      if (sessionId) {
        fetch("<?php echo base_url('subscription/update/checkout_session?sessionId=') ?>" + sessionId).then(function(result){
          return result.json()
        }).then(function(session){
          var sessionJSON = JSON.stringify(session, null, 2);
         
        }).catch(function(err){
          console.log('Error when fetching Checkout session', err);
        });
      }
    </script>