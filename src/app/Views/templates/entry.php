 <!-- Post -->
 <article class="box post post-excerpt">
    <div class="info">
        <span class="date">
            <span class="month"><?= esc(Date('M', strtotime($entry['date']))); ?></span>
            <span class="day"><?= esc(Date('j', strtotime($entry['date']))); ?></span>
            <span class="year">,&ensp;</span><span><?= esc(Date('Y', strtotime($entry['date']))); ?></span>
        </span>
    </div>
    <?php if (!empty($entry['description'])) : ?>
        <header>
            <p><?= esc($entry['description']); ?></p>
        </header>
    <?php endif ?>
    <?php if (!empty($entry['body'])) : ?>
        <div class="entry-body">
            <?= $entry['body'] ?>
        </div>
        <br />
    <?php endif ?>
</article>