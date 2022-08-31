<?php
?>
<select name="tt_location">
    <option value="top" <?= selected(get_option('tt_location'), 'top') ?>><?= __('Over tekst') ?></option>
    <option value="right" <?= selected(get_option('tt_location'), 'right') ?>><?= __('Til højre for tekst') ?></option>
    <option value="bottom" <?= selected(get_option('tt_location'), 'bottom') ?>><?= __('Under tekst') ?></option>
    <option value="left" <?= selected(get_option('tt_location'), 'left') ?>><?= __('Til venstre for tekst') ?></option>
</select>