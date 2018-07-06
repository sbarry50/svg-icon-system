<?php

namespace SB2Media\SVGIconSystem;
?>

<svg class="icon icon-<?php echo $this->icon->icon_id . ' ' . $this->config['class']; ?>"
    <?= $this->icon->config['aria']; ?>
    <?php if( $this->icon->config['width'] && $this->icon->config['height'] ) : ?>
        width="<?= $this->icon->config['width']; ?>" height="<?= $this->icon->config['height']; ?>"
    <?php endif; ?>
    viewBox="<?= $this->icon->config['viewbox_x'] . ' ' . $this->icon->config['viewbox_y'] . ' ' . $this->icon->config['viewbox_width'] . ' ' . $this->icon->config['viewbox_height']; ?>"
    <?php if( $this->icon->config['preserve_aspect_ratio'] ) : ?>
        preserveAspectRatio="<?= $this->icon->config['preserve_aspect_ratio'] ?>"
    <?php endif; ?>
    <?php if( $this->icon->config['style'] ) : ?>
        style="<?= $this->icon->config['style'] ?>"
    <?php endif; ?>
    role="img">
    <?php if( $this->icon->config['title'] ) : ?>
        <title id="title-<?= $this->icon->config['unique_id']; ?>"><?= esc_html( $this->icon->config['title'] ); ?></title>

        <?php if( $this->icon->config['desc'] ) : ?>
            <desc id="desc-<?= $this->icon->config['unique_id']; ?>"><?= esc_html( $this->icon->config['desc'] ); ?></desc>
        <?php endif; ?>
    <?php endif; ?>
    <?= $this->icon->config['content']; ?>
</svg>
