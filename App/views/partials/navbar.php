<?php 
  use Framework\Session;
?>
    
    
    <!-- Header -->
    <header class="header">
      <div class="header-right">
        <div class="logo">
          <a href="/">
            <i class="bx bxl-spring-boot"></i>
            <p>Udemy</p>
          </a>
        </div>

        <ul class="navbar">
          <li>
            <a href="/">Home</a>
          </li>
          <li>
            <a href="/blog">Blog</a>
          </li>
          <li>
            <a href="/about">About</a>
          </li>
        </ul>
      </div>

      <ul class="header-user">
        <?php if(Session::has('user')) : ?>
          <li class="welcome">
            Welcome <?= Session::get('user')['name'] ?>
          </li>
          <li>
            <form action="/auth/logout" method="POST">
              <button type="submit" class="logout">Logout</button>
            </form>
          </li>
          <li>
            <a href="/blog/create" class="createBtn">Create a new post</a>
          </li>
        <?php else : ?>
          <li>
          <a href="/auth/login">Login</a>
        </li>
        <li>
          <a href="/auth/register">Register</a>
        </li>
        <?php endif ; ?>
    
    
      </ul>
    </header>