<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
if (!function_exists('woof_draw_checkbox_childs'))
{

    function woof_draw_checkbox_childs($tax_slug, $childs, $show_count, $show_count_dynamic, $hide_dynamic_empty_pos)
    {
        $current_request = array();
        if (isset($_REQUEST[$tax_slug]))
        {
            $current_request = $_REQUEST[$tax_slug];
            $current_request = explode(',', $current_request);
        }
        ?>
        <ul class="woof_childs_list">
            <?php foreach ($childs as $term) : $inique_id = uniqid(); ?>
                <?php
                $count_string = "";
                if ($show_count)
                {
                    if ($show_count_dynamic)
                    {
                        $count = WOOF::dynamic_count($term, 'checkbox');
                    } else
                    {
                        $count = $term['count'];
                    }
                    $count_string = '(' . $count . ')';
                }
                //+++
                if ($hide_dynamic_empty_pos AND $count == 0)
                {
                    continue;
                }

                $thumb =  woof_get_tax_thumb( $term['term_id'], $tax_slug );
                ?>
                <li>
                    <div class="iw">
                        <label for="<?php echo 'woof_' . $inique_id ?>">
                            <?php echo $thumb; ?>
                            <input type="checkbox" id="<?php echo 'woof_' . $inique_id ?>" class="woof_checkbox_term" data-tax="<?php echo $tax_slug ?>" name="<?php echo $term['slug'] ?>" value="<?php echo $term['term_id'] ?>" <?php  checked(in_array($term['slug'], $current_request)) ?> />
                            &nbsp;<?php echo $term['name'] ?> <?php echo $count_string ?>
                        </label>
                    </div>
                    <?php
                    if (!empty($term['childs']))
                    {
                        woof_draw_checkbox_childs($tax_slug, $term['childs'], $show_count, $show_count_dynamic, $hide_dynamic_empty_pos);
                    }
                    ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
    }

}
?>
<ul class="woof_list woof_list_checkbox">
    <?php
    $woof_tax_values = array();
    $current_request = array();
    if (isset($_REQUEST[$tax_slug]))
    {
        $current_request = $_REQUEST[$tax_slug];
        $current_request = explode(',', $current_request);
    }
    ?>
    <?php foreach ($terms as $term) : $inique_id = uniqid(); ?>
        <?php
        $count_string = "";
        if ($show_count)
        {
            if ($show_count_dynamic)
            {
                $count = self::dynamic_count($term, 'checkbox');
            } else
            {
                $count = $term['count'];
            }
            $count_string = '(' . $count . ')';
        }
        //+++
        if ($hide_dynamic_empty_pos AND $count == 0)
        {
            continue;
        }

        $thumb =  woof_get_tax_thumb( $term['term_id'], $tax_slug );
        // $swatch_term = new WC_Swatch_Term( 'swatches_id', $term->term_id, $taxonomy_lookup_name, $selected_value == $term->slug, $size );
        ?>
        <li>
            <div class="iw">
                <label for="<?php echo 'woof_' . $inique_id ?>">
                    <?php echo $thumb; ?>
                    <input type="checkbox" id="<?php echo 'woof_' . $inique_id ?>" class="woof_checkbox_term" data-tax="<?php echo $tax_slug ?>" name="<?php echo $term['slug'] ?>" value="<?php echo $term['term_id'] ?>" <?php checked(in_array($term['slug'], $current_request)) ?> />
                    &nbsp;<?php echo $term['name'] ?> <?php echo $count_string ?>
                </label>
            </div>
            <?php
            if (!empty($term['childs']))
            {
                woof_draw_checkbox_childs($tax_slug, $term['childs'], $show_count, $show_count_dynamic, $hide_dynamic_empty_pos);
            }
            ?>
        </li>
    <?php endforeach; ?>
</ul>
