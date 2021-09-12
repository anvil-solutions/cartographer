<?php require_once('./src/layout/header.php'); ?>
<main>
  <div class="card">
    <h2>Welcome to Cartographer</h2>
    <p>
      Cartographer is a web app for visualizing website sitemaps. Enter a web page url below to start.
    </p>
    <form id="form" method="POST" action="./check">
      <input id="input" aria-label="Web Page URL" name="url" type="text" required>
      <button type="submit" class="btn">Analyze</button>
    </form>
  </div>
  <div id="loading" class="card" style="display:none">
    Loading
  </div>
  <div id="result" class="card" style="display:none"></div>
  <div id="error" class="card" style="display:none">
    <h2>Action Failed</h2>
    <p>
      An unexpected error occured.
    </p>
  </div>
  <div class="card">
    <h2>About</h2>
    <p>
      Cartographer was created by Anvil Solutions
    </p>
    <nav>
      <ul>
        <li><a href="https://fonts.google.com/icons">Material Icons by Google</a></li>
        <li><a href="https://github.com/anvil-solutions/cartographer">GitHub</a></li>
        <li><a href="http://anvil-solutions.com/en/privacy">Privacy</a></li>
        <li><a href="http://anvil-solutions.com/en/imprint">Imprint</a></li>
    </nav>
  </div>
</main>
<script src="./js/main.js" async></script>
