<?php
/**
 * Created by PhpStorm.
 * User: joshh
 * Date: 10/11/2017
 * Time: 11:33
 */
echo '  
  <ul id="dropdown1" class="dropdown-content">
  <li><form action="connect.php" method="post" id="signInForm">
    <div class="input-field">
        <input type="text" name="username" placeholder="username">
    </div>
    <div class="input-field">
        <input type="password" name="password" placeholder="password">
    </div>
    <button class="btn waves-effect waves-light" type="submit" name="submit" onclick="connect.php">Login
        <i class="material-icons right">send</i>
    </button>
</form>
    <a href="registerForm.php"><b>Click here to register</b></a>
    </li>
</ul>
  <nav>
    <div class="nav-wrapper">
      <a href="index.php" class="brand-logo">Logo</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="climbers.php">All Climbers</a></li>
        <li><a href="climbs.php">Climbs</a></li>
        <li><a href = "registerForm.php">Register an account</a></li>
        <li><a class="dropdown-button" data-activates="dropdown1">Login<i class="material-icons right">arrow_drop_down</i></a></li>
      </ul>
    </div>
  </nav>';
?>
<style>
    .dropdown-content li{
        cursor:default;
    }
</style>