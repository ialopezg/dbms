<?php defined('CORE_PATH') || exit('No direct script access allowed'); ?>

<div style="border: 1px solid #dd4814; padding-left: 20px; margin: 10px auto auto; width: 90%;">
    <h4>A PHP error was encountered</h4>

    <p><strong>Severity</strong>: <?= $severity ?></p>
    <p><strong>Message</strong>: <?= $message ?></p>
    <p><strong>File</strong>: <?= $file ?></p>
    <p><strong>Line</strong>: <?= $line ?></p>

    <?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === true): ?>
        <p>Backtrace:</p>
        <?php foreach (debug_backtrace() as $error): ?>
            <?php if (isset($error['file']) && strpos($error['file'], realpath(CORE_PATH)) !== 0): ?>
            <p style="margin-left: 10px;">
                <strong>File</strong>: <?= $error['file'] ?><br>
                <strong>Line</strong>: <?= $error['line'] ?><br>
                <strong>Function</strong>: <?= $error['function'] ?>
            </p>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
