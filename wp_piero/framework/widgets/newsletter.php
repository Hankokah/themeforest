<?php

/**
 * Newsletter widget version 2.0: it'll replace the old version left for compatibility.
 */
class NewsletterCustomWidget extends WP_Widget {

    function NewsletterCustomWidget() {
        parent::__construct(false, $name = 'NewsletterCustom', array('description' => 'Newsletter widget to add subscription forms on sidebars'), array('width' => '350px'));
    }

    static function get_widget_form_layout1() {
        $options_profile = get_option('newsletter_profile');
        $form = NewsletterSubscription::instance()->get_form_javascript();

        $form .= '<form action="' . plugins_url('newsletter/do/subscribe.php') . '" onsubmit="return newsletter_check(this)" method="post">';
        // Referrer
        $form .= '<input type="hidden" name="nr" value="widget"/>';

        if ($options_profile['name_status'] == 2)
            $form .= '<p><input class="newsletter-firstname" type="text" name="nn" value="' . $options_profile['name'] . '" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/></p>';

        if ($options_profile['surname_status'] == 2)
            $form .= '<p><input class="newsletter-lastname" type="text" name="ns" value="' . $options_profile['surname'] . '" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/></p>';

        $form .= '<input class="newsletter-email left" type="email" required name="ne" value="' . $options_profile['email'] . '" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/>';

        if (isset($options_profile['sex_status']) && $options_profile['sex_status'] == 2) {
            $form .= '<p><select name="nx" class="newsletter-sex">';
            $form .= '<option value="m">' . $options_profile['sex_male'] . '</option>';
            $form .= '<option value="f">' . $options_profile['sex_female'] . '</option>';
            $form .= '</select></p>';
        }

        // Extra profile fields
        for ($i = 1; $i <= NEWSLETTER_PROFILE_MAX; $i++) {
            if ($options_profile['profile_' . $i . '_status'] != 2)
                continue;
            if ($options_profile['profile_' . $i . '_type'] == 'text') {
                $form .= '<p><input class="newsletter-profile newsletter-profile-' . $i . '" type="text" name="np' . $i . '" value="' . $options_profile['profile_' . $i] . '" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/></p>';
            }
            if ($options_profile['profile_' . $i . '_type'] == 'select') {
                $form .= '<p>' . $options_profile['profile_' . $i] . '<br /><select class="newsletter-profile newsletter-profile-' . $i . '" name="np' . $i . '">';
                $opts = explode(',', $options_profile['profile_' . $i . '_options']);
                for ($t = 0; $t < count($opts); $t++) {
                    $form .= '<option>' . trim($opts[$t]) . '</option>';
                }
                $form .= '</select></p>';
            }
        }

        $lists = '';
        for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {
            if ($options_profile['list_' . $i . '_status'] != 2)
                continue;
            $lists .= '<input type="checkbox" name="nl[]" value="' . $i . '"';
            if ($options_profile['list_' . $i . '_checked'] == 1)
                $lists .= ' checked';
            $lists .= '/>&nbsp;' . $options_profile['list_' . $i] . '<br />';
        }
        if (!empty($lists))
            $form .= '<p>' . $lists . '</p>';


        $extra = apply_filters('newsletter_subscription_extra', array());
        foreach ($extra as &$x) {
            $form .= "<p>";
            if (!empty($x['label']))
                $form .= $x['label'] . "<br/>";
            $form .= $x['field'] . "</p>";
        }

        if ($options_profile['privacy_status'] == 1) {
            if (!empty($options_profile['privacy_url'])) {
                $form .= '<p><input type="checkbox" name="ny"/>&nbsp;<a target="_blank" href="' . $options_profile['privacy_url'] . '">' . $options_profile['privacy'] . '</a></p>';
            }
            else
                $form .= '<p><input type="checkbox" name="ny"/>&nbsp;' . $options_profile['privacy'] . '</p>';
        }

        if (strpos($options_profile['subscribe'], 'http://') !== false) {
            $form .= '<input class="newsletter-submit btn btn-primary-shop right" type="image" src="' . $options_profile['subscribe'] . '"/>';
        } else {
            $form .= '<input class="newsletter-submit btn btn-primary-shop right" type="submit" value="' . $options_profile['subscribe'] . '"/>';
        }

        $form .= '</form>';
        
        return $form;
    }
    static function get_widget_form_layout2() {
        $options_profile = get_option('newsletter_profile');
        $form = NewsletterSubscription::instance()->get_form_javascript();

        $form .= '<form action="' . plugins_url('newsletter/do/subscribe.php') . '" onsubmit="return newsletter_check(this)" method="post">';
        // Referrer
        $form .= '<input type="hidden" name="nr" value="widget"/>';

        if ($options_profile['name_status'] == 2)
            $form .= '<p class="line"><input class="newsletter-firstname" type="text" name="nn" value="' . $options_profile['name'] . '" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/></p>';

        if ($options_profile['surname_status'] == 2)
            $form .= '<p class="line"><input class="newsletter-lastname" type="text" name="ns" value="' . $options_profile['surname'] . '" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/></p>';

        $form .= '<p class="line"><input class="newsletter-email" type="email" required name="ne" value="' . $options_profile['email'] . '" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/></p>';

        if (isset($options_profile['sex_status']) && $options_profile['sex_status'] == 2) {
            $form .= '<p><select name="nx" class="newsletter-sex">';
            $form .= '<option value="m">' . $options_profile['sex_male'] . '</option>';
            $form .= '<option value="f">' . $options_profile['sex_female'] . '</option>';
            $form .= '</select></p>';
        }

        // Extra profile fields
        for ($i = 1; $i <= NEWSLETTER_PROFILE_MAX; $i++) {
            if ($options_profile['profile_' . $i . '_status'] != 2)
                continue;
            if ($options_profile['profile_' . $i . '_type'] == 'text') {
                $form .= '<p><input class="newsletter-profile newsletter-profile-' . $i . '" type="text" name="np' . $i . '" value="' . $options_profile['profile_' . $i] . '" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/></p>';
            }
            if ($options_profile['profile_' . $i . '_type'] == 'select') {
                $form .= '<p>' . $options_profile['profile_' . $i] . '<br /><select class="newsletter-profile newsletter-profile-' . $i . '" name="np' . $i . '">';
                $opts = explode(',', $options_profile['profile_' . $i . '_options']);
                for ($t = 0; $t < count($opts); $t++) {
                    $form .= '<option>' . trim($opts[$t]) . '</option>';
                }
                $form .= '</select></p>';
            }
        }

        $lists = '';
        for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {
            if ($options_profile['list_' . $i . '_status'] != 2)
                continue;
            $lists .= '<input type="checkbox" name="nl[]" value="' . $i . '"';
            if ($options_profile['list_' . $i . '_checked'] == 1)
                $lists .= ' checked';
            $lists .= '/>&nbsp;' . $options_profile['list_' . $i] . '<br />';
        }
        if (!empty($lists))
            $form .= '<p>' . $lists . '</p>';


        $extra = apply_filters('newsletter_subscription_extra', array());
        foreach ($extra as &$x) {
            $form .= "<p>";
            if (!empty($x['label']))
                $form .= $x['label'] . "<br/>";
            $form .= $x['field'] . "</p>";
        }

        if ($options_profile['privacy_status'] == 1) {
            if (!empty($options_profile['privacy_url'])) {
                $form .= '<p><input type="checkbox" name="ny"/>&nbsp;<a target="_blank" href="' . $options_profile['privacy_url'] . '">' . $options_profile['privacy'] . '</a></p>';
            }
            else
                $form .= '<p><input type="checkbox" name="ny"/>&nbsp;' . $options_profile['privacy'] . '</p>';
        }

        if (strpos($options_profile['subscribe'], 'http://') !== false) {
            $form .= '<p><input class="newsletter-submit-layout2 btn btn-default" type="image" src="' . $options_profile['subscribe'] . '"/></p>';
        } else {
            $form .= '<p><input class="newsletter-submit-layout2 btn btn-default" type="submit" value="' . $options_profile['subscribe'] . '"/></p>';
        }

        $form .= '</form>';
        
        return $form;
    }
    function widget($args, $instance) {
        global $newsletter;
        extract($args);
        switch ($instance['layout']) {
            case 'style2':
                echo $before_widget;

                // Filters are used for WPML
                if (!empty($instance['title'])) {
                    $title = apply_filters('widget_title', $instance['title'], $instance);
                    echo $before_title . $title . $after_title;
                }

                $buffer = apply_filters('widget_text', $instance['text'], $instance);
                $options = get_option('newsletter');
                $options_profile = get_option('newsletter_profile');
                if (stripos($instance['text'], '<form') === false) {

                    $form = NewsletterSubscription::instance()->get_form_javascript();

                    $form .= '<div class="custom-newsletter newsletter-layout2 newsletter-widget">';
                    $form .= NewsletterCustomWidget::get_widget_form_layout2();
                    $form .= '</div>';

                    // Canot user directly the replace, since the form is different on the widget...
                    if (strpos($buffer, '{subscription_form}') !== false)
                        $buffer = str_replace('{subscription_form}', $form, $buffer);
                    else {
                        if (strpos($buffer, '{subscription_form_') !== false) {
                            // TODO: Optimize with a method to replace only the custom forms
                            $buffer = $newsletter->replace($buffer);
                        } else {
                            $buffer .= $form;
                        }
                    }
                } else {
                    $buffer = str_ireplace('<form', '<form method="post" action="' . plugins_url('newsletter/do/subscribe.php') . '" onsubmit="return newsletter_check(this)"', $buffer);
                    $buffer = str_ireplace('</form>', '<input type="hidden" name="nr" value="widget"/></form>', $buffer);
                }

                // That replace all the remaining tags
                $buffer = $newsletter->replace($buffer);

                echo $buffer;
                echo $after_widget;
                break;
            
            default:
                echo $before_widget;

                // Filters are used for WPML
                if (!empty($instance['title'])) {
                    $title = apply_filters('widget_title', $instance['title'], $instance);
                    echo $before_title . $title . $after_title;
                }

                $buffer = apply_filters('widget_text', $instance['text'], $instance);
                $options = get_option('newsletter');
                $options_profile = get_option('newsletter_profile');
                if (stripos($instance['text'], '<form') === false) {

                    $form = NewsletterSubscription::instance()->get_form_javascript();

                    $form .= '<div class="custom-newsletter newsletter newsletter-widget">';
                    $form .= NewsletterCustomWidget::get_widget_form_layout1();
                    $form .= '</div>';

                    // Canot user directly the replace, since the form is different on the widget...
                    if (strpos($buffer, '{subscription_form}') !== false)
                        $buffer = str_replace('{subscription_form}', $form, $buffer);
                    else {
                        if (strpos($buffer, '{subscription_form_') !== false) {
                            // TODO: Optimize with a method to replace only the custom forms
                            $buffer = $newsletter->replace($buffer);
                        } else {
                            $buffer .= $form;
                        }
                    }
                } else {
                    $buffer = str_ireplace('<form', '<form method="post" action="' . plugins_url('newsletter/do/subscribe.php') . '" onsubmit="return newsletter_check(this)"', $buffer);
                    $buffer = str_ireplace('</form>', '<input type="hidden" name="nr" value="widget"/></form>', $buffer);
                }

                // That replace all the remaining tags
                $buffer = $newsletter->replace($buffer);

                echo $buffer;
                echo $after_widget;
                break;
        }
                
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = ($new_instance['title'])?strip_tags($new_instance['title']):'';
        $instance['layout'] = ($new_instance['layout'])?strip_tags($new_instance['layout']):'';
        $instance['text'] = ($new_instance['text'])?$new_instance['text']:'';
        return $instance;
    }

    function form($instance) {
        $instance['title'] = isset($instance['title'])?$instance['title']:'';
        $instance['layout'] = isset($instance['layout'])?$instance['layout']:'';
        $instance['text'] = isset($instance['text'])?$instance['text']:'';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                Title:
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
            </label>


            <label for="<?php echo $this->get_field_id('text'); ?>">
                Introduction:
                <textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_html($instance['text']); ?></textarea>
            </label>
            <label for="<?php echo $this->get_field_id('layout'); ?>">
                Layout:
                <select class="widefat" id="<?php echo $this->get_field_id('layout'); ?>" name="<?php echo $this->get_field_name('layout'); ?>">
                    <option value="style1" <?php echo (esc_attr($instance['layout'])=='style1')?'selected':''; ?>>Style 1</option>
                    <option value="style2" <?php echo (esc_attr($instance['layout'])=='style2')?'selected':''; ?>>Style 2</option>
                </select>
            </label>
        <p>Use the tag {subscription_form} to place the subscription form within your personal text.
        </p>
        <?php
    }

}
if(class_exists("Newsletter")){
    add_action('widgets_init', create_function('', 'return register_widget("NewsletterCustomWidget");'));
}

?>
