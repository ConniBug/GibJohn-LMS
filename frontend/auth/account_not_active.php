<?php
  // Here we just build a basic html web page
  echo file_get_contents(__DIR__ . "./html/sign-in.css"); 
?>

<script>
window.setInterval('refresh()', 1000);

let count = 10;
function refresh() {
  if(count == 0) {
    window.location=window.location;
  }
  document.getElementById("counter").innerHTML = "Refreshing in " + count.toString() + " Seconds";
  count--;
}
</script>

<body class="text-center">
  <main class="login-form">
    <form action="/" method="POST">
      <!-- <h1 class="h2 mb-3 fw-normal">welcome banner here</h1> -->
      <h1 class="h6 mb-3 fw-normal">Your account is not currently active!</h1>
      <h1 class="h6 mb-3 fw-normal">STATUS: <?php echo $_SESSION["JSON-DAT"]->AccountStatus; ?></h1>
      <h1 class="h6 mb-3 fw-normal" id="counter">Refreshing in 10 Seconds</h1>

      <button onclick="return refresh();" 
              style="margin-top: 0px;margin-bottom: 5px;" 
              class="w-100 btn btn-lg btn-primary" 
              type="submit">Refresh
      </button>

      <p class="mt-5 mb-3 text-muted">&copy; GibJohn Tutoring 2022–2022</p>
    </form>
  </main>
</body>
