    <!-- Sidebar -->
    <div id="sidebar">
      <!-- Logo -->
      <h1 id="logo"><a href="/">Journal</a></h1>

      <!-- Nav -->
      <nav id="nav">
        <ul>
          <?= $currentPage == 'entries' ? '<li class="current">' : '<li>' ?><a href="/"><i class="fa fa-book" aria-hidden="true"></i>&emsp;Entries</a></li>
          <?= $currentPage == 'write' ? '<li class="current">' : '<li>' ?><a href="/write"><i class="fa fa-pencil-alt" aria-hidden="true"></i>&emsp;Today</a></li>
        </ul>
      </nav>

      <!-- Search -->
      <!-- <section class="box search">
        <form method="post" action="#">
          <input type="text" class="text" name="search" placeholder="Search" />
        </form>
      </section> -->

      <!-- Text -->
      <!-- <section class="box text-style1">
        <div class="inner">
          <p>
            <strong>Aliquam:</strong> A nibh mus fusce adipiscing morbi
            pellentesque faucibus mi et nec Parturient
          </p>
        </div>
      </section> -->
      
      <!-- Calendar -->
      <?php echo view('templates/calendar', [
        'calDate' => $calDate,
      ]); ?>
      
      <!-- Copyright -->
      <!-- <ul id="copyright">
        <li>&copy; Untitled.</li>
      </ul>
    </div> -->