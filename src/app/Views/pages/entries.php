
<?php echo view('templates/header', 
    [
        'subtitle' => !empty($entries) && count($entries) == 1 ? Date('m/d/Y', strtotime($entries[0]['date'])) : null,
    ]); 
?>

<body class="is-preload">
<!-- Content -->
    <div id="content">
        <div class="inner">

        <?php if (!empty($entries) && is_array($entries)) : ?>

            <?php foreach ($entries as $entry): ?>

                <!-- Post -->
                <article class="box post post-excerpt">
                    <div class="info">
                        <span class="date">
                            <span class="month"><?= esc(Date('M', strtotime($entry['date']))); ?></span>
                            <span class="day"><?= esc(Date('j', strtotime($entry['date']))); ?></span>
                            <span class="year">, <?= esc(Date('Y', strtotime($entry['date']))); ?></span>
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

            <?php endforeach; ?>

            <?php else : ?>

            <h3>No journal entries.</h3>

            <p>Write one for today!</p>

            <?php endif ?>
        </div>
    </div>

    <?php echo view('templates/sidebar'); ?>
</body>

<?php echo view('templates/footer'); ?>