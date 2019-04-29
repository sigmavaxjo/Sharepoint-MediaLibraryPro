<div id="<?php echo SML_NAME; ?>-settings">

    <h1><?php echo __('Settings', SML_NAME); ?></h1>

    <form name="<?php echo SML_NAME; ?>-form" class="<?php echo SML_NAME; ?>-form" method="post">

        <input type="hidden" name="<?php echo SML_NAME; ?>-action" value="<?php echo SML_NAME; ?>-settings">

        <?php wp_nonce_field(SML_NAME . '-settings'); ?>

        <div class="<?php echo SML_NAME; ?>-container">

            <div class="sml-item">

                <?php echo $this->input('text', SML_NAME . '-resource', __('Resource', SML_NAME)); ?>

            </div>

            <div class="sml-item">

                <?php echo $this->input('text', SML_NAME . '-clientId', __('Client ID', SML_NAME)); ?>

            </div>

            <div class="sml-item">

                <?php echo $this->input('password', SML_NAME . '-secret', __('Client secret', SML_NAME)); ?>

            </div>

        </div>

        <div class="sml-submit-item border-top">

            <?php echo $this->input('submit', SML_NAME . '-submit', __('Save Settings', SML_NAME)); ?>

        </div>

    </form>

</div>
