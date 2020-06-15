<!DOCTYPE html>
<html>
  <head>
    <title>Journal<?php if (!empty($subtitle)) echo ' - '.$subtitle ?></title>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, user-scalable=no"
    />
    <link rel="stylesheet" href="/assets/css/main.css" />

    <?php if (!empty($stylesheets) && is_array($stylesheets)) : ?>
        <?php foreach ($stylesheets as $stylesheet): ?>
            <link rel="stylesheet" href="<?= $stylesheet ?>"/>
        <?php endforeach; ?>
    <?php endif; ?>
  </head>