<?php
  // Here we just build a basic html web page
  echo file_get_contents(__DIR__ . "./html/sign-in.css"); 
?>

<script>
function actionThingLogin() {
    document.getElementById("action").value = "login";
    return true;
}  
function actionThingRegister() {
    document.getElementById("action").value = "register";
    return true;
}  
</script>

<body class="text-center">
  <main class="login-form">
    <form action="/" method="POST">
      <!-- <h1 class="h2 mb-3 fw-normal">welcome banner here</h1> -->
      <h1 class="h6 mb-3 fw-normal">Please login below!!</h1>

      <div class="form-floating">
        <input name="email" type="email" placeholder="user@example.com" class="form-control" id="email">
        <label for="email">Email Address</label>
      </div>
      <div class="form-floating">
        <input name="password" type="password" placeholder="example" class="form-control" id="password">
        <label for="password">Password</label>
      </div>
      <input name="action" style="visibility: hidden;" type="text" value="N/A" id="action">
      <input name="REQUEST-ID" style="visibility: hidden;" type="text" value="N/A" id="REQUEST-ID">

      <button onclick="return actionThingLogin();" 
              style="margin-top: 0px;margin-bottom: 5px;" 
              class="w-100 btn btn-lg btn-primary" 
              type="submit">Sign in
      </button>
      <button onclick="return actionThingRegister();" 
              class="w-100 btn btn-lg btn-primary" 
              type="submit">Register
      </button>

      <p class="mt-5 mb-3 text-muted">&copy; GibJhon Tutoring 2022–2022</p>
    </form>
  </main>
</body>

<script>
document.getElementById("REQUEST-ID").value = Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 5);;
</script>
