<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>

<?php
if (!function_exists('woof_draw_radio_childs'))
{

    function woof_draw_radio_childs($tax_slug, $childs, $show_count, $show_count_dynamic, $hide_dynamic_empty_pos)
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
                        $count = WOOF::dynamic_count($term, 'radio');
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
                            <input type="radio" id="<?php echo 'woof_' . $inique_id ?>" class="woof_radio_term" data-slug="<?php echo $term['slug'] ?>" name="<?php echo $tax_slug ?>" value="<?php echo $term['term_id'] ?>" <?php echo checked(in_array($term['slug'], $current_request)) ?> />
                            &nbsp;<?php echo $term['name'] ?> <?php echo $count_string ?>
                        </label>
                        <a href="#" data-name="<?php echo $tax_slug ?>" class="woof_radio_term_reset"><i class="fa fa-times"></i></a>
                    </div>
                    <?php
                    if (!empty($term['childs']))
                    {
                        woof_draw_radio_childs($tax_slug, $term['childs'], $show_count, $show_count_dynamic, $hide_dynamic_empty_pos);
                    }
                    ?>
                </li>
        <?php endforeach; ?>
        </ul>
        <?php
    }

}
?>
<ul class="woof_list woof_list_radio">
    <?php
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
                $count = self::dynamic_count($term, 'radio');
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
                    <input type="radio" id="<?php echo 'woof_' . $inique_id ?>" class="woof_radio_term" data-slug="<?php echo $term['slug'] ?>" name="<?php echo $tax_slug ?>" value="<?php echo $term['term_id'] ?>" <?php echo checked(in_array($term['slug'], $current_request)) ?> />
                    &nbsp;<?php echo $term['name'] ?> <?php echo $count_string ?>
                </label>
                <a href="#" data-name="<?php echo $tax_slug ?>" class="woof_radio_term_reset"><i class="fa fa-times"></i></a>
            </div>
            <?php
            if (!empty($term['childs']))
            {
                woof_draw_radio_childs($tax_slug, $term['childs'], $show_count, $show_count_dynamic, $hide_dynamic_empty_pos);
            }
            ?>
        </li>
<?php endforeach; ?>
</ul>
