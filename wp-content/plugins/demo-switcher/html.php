<?php

 $url =   $_REQUEST['url'] ;

?>

<div class="ds">
    <a href="#" class="ds-toggle"><i class="fa fa-cogs"></i></a>
    <div class="ds-panel">
        <div class="ds-heading">CUSTOMIZE</div>

        <div class="ds-setting">
            <div class="ds-label">Demo versions</div>
            <div class="ds-opt">
                <a class="ds-ver " title="Version 1"  href="http://kutethemes.ovicsoft.com/fashion/london-stars1/" data-style="background: url('<?php echo $url; ?>/images/demo-1.jpg') repeat; " ><img src="<?php echo $url; ?>/images/demo-1.jpg"></a>
                <a class="ds-ver " title="Version 2" href="http://kutethemes.ovicsoft.com/fashion/london-stars2/" data-style="background: url('<?php echo $url; ?>/images/demo-2.jpg') repeat; " ><img src="<?php echo $url; ?>/images/demo-2.jpg"></a>
                <a class="ds-ver " title="Version 3" href="http://kutethemes.ovicsoft.com/fashion/london-stars3/" data-style="background: url('<?php echo $url; ?>/images/demo-3.jpg') repeat; " ><img src="<?php echo $url; ?>/images/demo-3.jpg"></a>
                <a class="ds-ver " title="Version 4" href="http://kutethemes.ovicsoft.com/fashion/london-stars4/" data-style="background: url('<?php echo $url; ?>/images/demo-4.jpg') repeat; " ><img src="<?php echo $url; ?>/images/demo-4.jpg"></a>
                <a class="ds-ver " title="Version 5" href="http://kutethemes.ovicsoft.com/fashion/london-stars5/" data-style="background: url('<?php echo $url; ?>/images/demo-5.jpg') repeat; " ><img src="<?php echo $url; ?>/images/demo-5.jpg"></a>
            </div>
        </div>

        <div class="ds-setting">
            <div class="ds-label">Choose your Color</div>
            <div class="ds-opt">
                <a class="ds-chang-skin" href="#" data-bg="#000000" title="Default">Default</a>
                <a class="ds-chang-skin" href="<?php echo $url; ?>/skins/color-057000.css" data-bg="#057000" title="Green">Green</a>
                <a class="ds-chang-skin" href="<?php echo $url; ?>/skins/color-dd3333.css" data-bg="#dd3333" title="Pink">Red</a>
                <a class="ds-chang-skin" href="<?php echo $url; ?>/skins/color-22618e.css" data-bg="#22618e" title="Greyish-Blue">Greyish Blue</a>
                <a class="ds-chang-skin" href="<?php echo $url; ?>/skins/color-00a0b2.css" data-bg="#00a0b2" title="Blue">Blue</a>
                <a class="ds-chang-skin" href="<?php echo $url; ?>/skins/color-ab00b7.css" data-bg="#ab00b7" title="Yellow">Pink</a>
            </div>
        </div>

        <div class="ds-setting">
            <div class="ds-label">Choose site mod</div>
            <div class="ds-opt">
                <a class="ds-site-mod " href="#" data-mod="full-width" title="Full Width"><i class="fa fa-check-square-o"></i><i class="fa fa-square-o"></i> Full Width</a>
                <a class="ds-site-mod" href="#" data-mod="layout-boxed" title="Default"><i class="fa fa-check-square-o"></i><i class="fa fa-square-o"></i> Boxed Mod</a>
            </div>
        </div>

        <div class="ds-setting">
            <div class="ds-label">Background for Boxed</div>
            <div class="ds-opt">
                <a class="ds-site-bg active" href="#" data-style='background: url("<?php echo $url; ?>/bg/mainbg.jpg") no-repeat fixed center bottom / cover  #f1f2f3;' ><img src="<?php echo $url; ?>/bg/mainbg-sm.jpg"></a>
                <a class="ds-site-bg " href="#" data-style="background: url('<?php echo $url; ?>/images/patterns/criss-xcross.png') repeat; " ><img src="<?php echo $url; ?>/images/patterns/criss-xcross.png"></a>
                <a class="ds-site-bg " href="#" data-style="background: url('<?php echo $url; ?>/images/patterns/congruent_pentagon.png') repeat; " ><img src="<?php echo $url; ?>/images/patterns/congruent_pentagon.png"></a>
            </div>
        </div>

    </div>
</div>