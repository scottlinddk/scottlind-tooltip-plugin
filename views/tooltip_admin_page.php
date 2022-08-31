<?php
?>
<div class="wrap">
    <h1><?= __('Tooltip Indstillinger') ?></h1>
    <form action="options.php" method="POST">
        <?php 
            settings_fields('tooltip-plugin');
            do_settings_sections('scottlind-tooltip-settings');
            submit_button();
        ?>
    </form>
</div>