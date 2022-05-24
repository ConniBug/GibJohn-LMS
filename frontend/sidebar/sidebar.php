   
  <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark rounded-5 shadow-lg" style="width: 20%;height: 100%; position: fixed;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none" style="margin-top: -4%;">
      <span class="fs-4">GibJohn Tutoring</span>
    </a>
    <hr style="margin-top: 3%;"></hr>
      <ul id="tabBarID" class="nav nav-pills flex-column mb-auto">
      </ul>
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
        <img id="PFP-THING" src="https://i.imgur.com/kz8725t.jpeg" alt="" width="32" height="32" class="rounded-circle me-2">
        <script>
          
        </script>
        <strong><?php echo $_SESSION["JSON-DAT"]->PrefferedFullName; ?></strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
        <li><a id="PAGE-SUPPORT-SUB" class="dropdown-item" href="/support">Help & Support</a></li>
        <li><a id="PAGE-SETTINGS-SUB" class="dropdown-item" href="/profile/<?php echo $_SESSION["JSON-DAT"]->UserID; ?>">Settings</a></li>
        <li><a id="PAGE-PROFILE-SUB" class="dropdown-item" href="/profile/<?php echo $_SESSION["JSON-DAT"]->UserID; ?>/public">Profile</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="/logout">Sign out</a></li>
      </ul>
    </div>
  </div>    
</body>
<script> 
function addNewTab(tabName, tabID, href, svgName) {
  var tabBar = document.getElementById("tabBarID");
  var li = document.createElement("li");
  li.setAttribute("class", "nav-item");

  var a = document.createElement("a");
  a.innerHTML = `<svg class="bi me-2" width="16" height="16"><use xlink:href="${svgName}"/></svg>`;

  a.setAttribute("id", tabID);
  a.setAttribute("href", href);
  a.setAttribute("class", "nav-link text-white");
  a.setAttribute("aria-current", "page");
  a.appendChild(document.createTextNode(tabName));

  li.appendChild(a);
  tabBar.appendChild(li);
}

addNewTab("Home", "PAGE-HOME-TAB", "/home", "#home");
addNewTab("Dashboard", "PAGE-DASHBOARD-TAB", "/dashboard", "#speedometer2");
addNewTab("Groups", "GROUP-TAB", "/groups", "#people-circle");

<?php 
if($_SESSION["JSON-DAT"]->UserRole == "Admin") {
  ?> addNewTab("Admin - Users", "PAGE-ADMIN-TAB", "/admin-users", "#speedometer2"); <?php
  ?> addNewTab("Admin - Groups", "PAGE-ADMIN-TAB", "/admin-groups", "#speedometer2"); <?php
}
?>
</script>
