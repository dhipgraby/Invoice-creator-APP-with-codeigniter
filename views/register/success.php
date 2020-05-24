<div id="success_div" class="col-sm-8 trans-normal pt-5 fadeinright">
  <h1 class="mt-5 blue"><i class="far fa-check-circle"></i></h1>
  <h2 class="blue">
    Susbscripción activa!
    <br>
    <h3 class="light-c">Ya puede comenzar a usar Slapp invoice!</h3>
  </h2>
  <br>
  <button class="btn btn- purchase purchase-blue grow" onclick="go_to('main')"> Ir a logear <i class="fas fa-chevron-right"></i></button>
  <br>
  <pre>


</pre>
</div>
<script>
  $(document).ready(function() {
    setTimeout(function() {
      $('#success_div').removeClass('fadeinright');
    }, 1000);
  });
  var urlParams = new URLSearchParams(window.location.search);
  var sessionId = urlParams.get("session_id");
  if (empty(sessionId)) {
    go_to('register');
  }
  if (sessionId) {
    fetch("<?php echo base_url('subscription/stripe/checkout_session?sessionId=') ?>" + sessionId).then(function(result) {
      return result.json();
    }).then(function(session) {
      var sessionJSON = JSON.stringify(session, null, 2);
      //document.querySelector("pre").textContent = sessionJSON;
    }).catch(function(err) {
      console.log('Error when fetching Checkout session', err);
    });
  }

  function empty(str) {
    return (!str || 0 === str.length);
  }

  function go_to(url) {
    window.location.href = '<?php echo base_url() ?>' + url;
  }
</script>