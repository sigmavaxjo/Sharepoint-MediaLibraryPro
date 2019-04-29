<div id="<?php echo SML_NAME; ?>--library">

    <h1><?php echo __('Media library', SML_NAME); ?><small><?php echo $this->list; ?></small></h1>

    <div class="<?php echo SML_NAME; ?>--library-container">

        <?php

        foreach ($this->data as $item) {
            echo '<div class="' . SML_NAME . '--library-item">';
            echo '<div class="' . SML_NAME . '--item-header"><h4>' . $item->title . '</h4></div>';

            echo '<div class="' . SML_NAME . '--item-content">';

            foreach ($item->attachments as $attachment) {
                echo '<div class="' . SML_NAME . '--attachment">';
                echo '<a href="' . $this->url . $attachment->ServerRelativePath->DecodedUrl . '" target="_blank">';
                echo '<div class="' . SML_NAME . '--attachment-file">' . $this->displayAttachment($attachment) . '</div>';
                echo '<div class="' . SML_NAME . '--attachment-title"><p>' . $this->truncate($attachment->FileName) . '</p></div>';
                echo '</a>';
                echo '</div>';
            }

            echo '</div></div>';
        }

        ?>

    </div>

</div>
