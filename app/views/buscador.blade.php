<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title></title>
  {{ HTML::style('assets/css/buscador.css') }}

<style>
  #search_input {
    border: 1px solid red;
  }
</style>
</head>
<body>

<header class="app transparent black" style="min-width: 623px;">
  <ul class="nav left">
    <li class="artsy on">
      <a href="/" class="mark">
      </a>
    </li>
    <li class="search blurred empty">
      <input type="text" id="search_input" autocorrect="off" class="ui-autocomplete-input" autocomplete="off" style="width: 729px;">
    </li>
  </ul>
  <ul class="nav right">
    
    <li class="browse">
      <a href="/browse">
        Browse
      </a>
    </li>
    <li class="filter">
      <a href="/filter/artworks">
        Filter
      </a>
    </li>
    <li class="posts">
      <a href="/posts">
        Posts
      </a>
    </li>
    <li class="favorites">
      <a href="/favorites">
        Favorites
      </a>
    </li>
    <li class="about">
      <a href="/about">
        About
      </a>
    </li>
    <li class="log_in">
      <a href="/log_in">
        Log In
      </a>
    </li>
    <li class="sign_up">
      <a href="/sign_up">
        Sign Up
      </a>
    </li>
    <li class="user name">
      <a href="#">
        <span class="not_mobile">
          Account
        </span>
        <div class="mobile profile_icon">
        </div>
      </a>
    </li>
  </ul>
</header>

</body>
</html>     