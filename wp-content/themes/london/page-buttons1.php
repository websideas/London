<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

$sidebar = themedev_sidebar();

get_header(); ?>
    <div class="container">
        <?php
    	/**
    	 * @hooked 
    	 */
    	do_action( 'theme_before_main' ); ?>
        <div class="row">    
            <div id="main" class="<?php echo apply_filters('themedev_main_class', 'main-class', $sidebar['sidebar']); ?>">
                
                
                <div class="row">
                    <div class="col-md-6">
                        <form>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" id="exampleInputEmail1" class="form-control" placeholder="Enter email">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" id="exampleInputPassword1" class="form-control" placeholder="Password">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <input type="file" id="exampleInputFile">
                            <p class="help-block">Example block-level help text here.</p>
                          </div>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" > Check me out
                            </label>
                          </div>
                          <div class="form-group">
                            <textarea rows="3" class="form-control"></textarea>
                          </div>
                          <div class="form-group">
                          <select class="form-control">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                              <option>5</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <select multiple="" class="form-control">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                              <option>5</option>
                            </select>
                          </div>
                          <div class="form-group">
                          <label for="disabledTextInput">Disabled input</label>
                          <input type="text" class="form-control" disabled="" id="disabledTextInput"  placeholder="Disabled input">
                        </div>
                        <div class="form-group">
                          <label for="disabledSelect">Disabled select menu</label>
                          <select id="disabledSelect" class="form-control">
                            <option>Disabled select</option>
                          </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn">Submit</button>
                          </div>
                          <p><button type="submit" class="btn btn-default btn-xs">Submit</button> <a href="#" class="btn btn-default btn-xs">Submit</a></p>
                          <p><button type="submit" class="btn btn-default btn-sm">Submit</button> <a href="#" class="btn btn-default btn-sm">Submit</a></p>
                          <p><button type="submit" class="btn btn-default">Submit</button> <a href="#" class="btn btn-default">Submit</a></p>
                          <p><button type="submit" class="btn btn-default btn-lg">Submit</button> <a href="#" class="btn btn-default btn-lg">Submit</a></p>
                          <p>&nbsp;</p>
                          <p><button type="submit" class="btn btn-default btn-xs btn-round">Submit</button> <a href="#" class="btn btn-default">Submit</a></p>
                          <p><button type="submit" class="btn btn-default btn-sm btn-round">Submit</button> <a href="#" class="btn btn-default">Submit</a></p>
                          <p><button type="submit" class="btn btn-default btn-round">Submit</button> <a href="#" class="btn btn-default">Submit</a></p>
                          <p><button type="submit" class="btn btn-default btn-lg btn-round">Submit</button> <a href="#" class="btn btn-default">Submit</a></p>
                          <p>&nbsp;</p>
                          <p><button type="submit" class="btn btn-default btn-xs btn-circle">Submit</button> <a href="#" class="btn btn-default">Submit</a></p>
                          <p><button type="submit" class="btn btn-default btn-sm btn-circle">Submit</button> <a href="#" class="btn btn-default">Submit</a></p>
                          <p><button type="submit" class="btn btn-default btn-circle">Submit</button> <a href="#" class="btn btn-default">Submit</a></p>
                          <p><button type="submit" class="btn btn-default btn-lg btn-circle">Submit</button> <a href="#" class="btn btn-default">Submit</a></p>
                          <p>&nbsp;</p>
                          
                        </form>
                    </div>
                    <div class="col-md-6">
                        <?php echo do_shortcode('[contact-form-7 id="531" title="Contact form 1"]'); ?>
                    </div>
                </div>
                
                
                
            </div>
            <?php if($sidebar['sidebar'] != 'full'){ ?>
                <div class="<?php echo apply_filters('themedev_sidebar_class', 'sidebar', $sidebar['sidebar']); ?>">
                    <?php dynamic_sidebar($sidebar['sidebar_area']); ?>
                </div><!-- .sidebar -->
            <?php } ?>
        </div><!-- .row -->
        <?php
    	/**
    	 * @hooked 
    	 */
    	do_action( 'theme_after_main' ); ?>
    </div><!-- .container -->
<?php get_footer(); ?>