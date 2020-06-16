
<?php echo view('templates/header', 
    [
        'subtitle' => !empty($isDateEntry) && $isDateEntry == true ? Date('m/d/Y', strtotime($entries[0]['date'])) : null,
    ]); 
?>

<body class="is-preload">
<!-- Content -->
    <div id="content">
        <div class="inner" id="infinite-container">

            <?php if (!empty($entries) && is_array($entries)) : ?>
                <?php foreach ($entries as $entry): ?>
                    <!-- Post -->
                    <?= view('templates/entry', ['entry' => $entry]) ?>
                <?php endforeach; ?>
            <?php else : ?>
                <h3>No journal entries.</h3>
                <p>Write one for today!</p>
            <?php endif ?>

        </div>
    </div>

    <?php echo view('templates/sidebar', [
        'currentPage' => !empty($isDateEntry) && $isDateEntry ? 'entry' : 'entries',
        'calDate' => !empty($isDateEntry) ? $entries[0]['date'] : null,
    ]); ?>
</body>

<script>
    var currentPage = 1;
    var canRequestMore = true;
    var infiniteContainer = document.getElementById("infinite-container");

    function loadMore() {
        canRequestMore = false;
        fetch(`/?page=${++currentPage}`, { headers: {
            "X-Requested-With": "XMLHttpRequest"
        }})
        .then(response => response.text())
        .then(html => {
            infiniteContainer.innerHTML += html;
            canRequestMore = true;
        })
    }

    window.addEventListener('scroll', function() {
        var scrollTop = window.scrollY;
        var windowHeight = window.outerHeight
        var bodyHeight = document.body.clientHeight - windowHeight;

        var scrollPercentage = scrollTop / bodyHeight;

        if (scrollPercentage > 0.8 && canRequestMore) {
            loadMore();
        }
    });
</script>

<?php echo view('templates/footer'); ?>