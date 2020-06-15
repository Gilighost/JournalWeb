<?php echo view('templates/header', 
    [
        'stylesheets' => ['/assets/quill/quill.snow.css', '//cdn.quilljs.com/1.3.6/quill.bubble.css'],
        'subtitle' => 'Write'
    ]); 
?>

<body class="is-preload">
<!-- Content -->
    <div id="content">
        <?= \Config\Services::validation()->listErrors(); ?>
        <div class="inner">
            <article  class="box post write">
                <div class="info">
                    <span class="date">
                        <span class="month"><?= esc(Date('M', strtotime($entry['date']))); ?></span>
                        <span class="day"><?= esc(Date('j', strtotime($entry['date']))); ?></span>
                        <span class="year">, <?= esc(Date('Y', strtotime($entry['date']))); ?></span>
                    </span>
                </div>
                <form method="post">
                    <?= csrf_field() ?>
                    <h3>Short Description</h3>
                    <textarea class="description-input" name="description" placeholder="Today was..."><?php 
                        if (!empty($entry['description'])) echo esc($entry['description']);
                    ?></textarea><br /><br />
                    <h3>Journal Entry</h3>
                    <input name="body" type="hidden" />
                    <!-- Create the editor container -->
                    <div id="editor">
                    <?php if (!empty($entry['body'])) : ?>
                        <?= $entry['body'] ?>
                    <?php endif ?>
                    </div>
                    <br/>
                    <input type="submit" value="Done" />
                </form>
            </article>
        </div>
    </div>

    <?php echo view('templates/sidebar'); ?>
</body>

<script src="/assets/quill/quill.js"></script>
<script>
    var quill = new Quill('#editor', {
        placeholder: "Dear Journal...",
        theme: 'snow',
    });

    var form = document.querySelector('form');
    form.onsubmit = function(e) {
        // Populate hidden form on submit
        var entryBody = document.querySelector('input[name=body]');
        var quillTextHtml = quill.getLength() > 1 ? quill.root.innerHTML : null;
        entryBody.value = quillTextHtml;
    }
</script>

<?php echo view('templates/footer'); ?>