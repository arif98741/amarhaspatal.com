<?php if (!defined('FW')) {
    die('Forbidden');
}
if (isset($_GET['directory_type'])) : ?>
    <ol class="tg-breadcrumb">
        <li class="first-item">
            <a href="<?= site_url() ?>">Homepage</a>
        </li>
        <?php if (esc_html($_GET['directory_type']) == 121): ?>
            <li class="active">Diagonostics</li>
        <?php elseif (esc_html($_GET['directory_type']) == 122) : ?>
            <li class="active">Blood Donor</li>
        <?php elseif (esc_html($_GET['directory_type']) == 123) : ?>
            <li class="active">Ambulance</li>
        <?php elseif (esc_html($_GET['directory_type']) == 126) : ?>
            <li class="active">Hospitals</li>
        <?php elseif (esc_html($_GET['directory_type']) == 127) : ?>
            <li class="active">Doctor</li>

        <?php endif; ?>


    </ol>

<?php elseif (!empty($items)) : ?>
    <ol class="tg-breadcrumb">
        <?php for ($i = 0; $i < count($items); $i++) : ?>
            <?php if ($i == (count($items) - 1)) : ?>
                <li class="active"><?php echo esc_attr($items[$i]['name']); ?></li>
            <?php elseif ($i == 0) : ?>
                <li class="first-item">
                <?php if (isset($items[$i]['url'])) : ?>
                    <a href="<?php echo esc_url($items[$i]['url']); ?>"><?php echo esc_attr($items[$i]['name']); ?></a></li>
                <?php else : echo esc_attr($items[$i]['name']); endif ?>
            <?php
            else : ?>
            <li class="<?php echo($i - 1) ?>-item">
                <?php if (isset($items[$i]['url'])) : ?>
                    <a href="<?php echo esc_url($items[$i]['url']); ?>"><?php echo esc_attr($items[$i]['name']); ?></a></li>
                <?php else : echo esc_attr($items[$i]['name']); endif ?>
            <?php endif ?>
        <?php endfor ?>
    </ol>
<?php endif ?>