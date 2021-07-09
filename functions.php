<?php 

function init_template(){
  add_theme_support('post-thumbnails');
  add_theme_support('title-tag');

  register_nav_menus (array('top_menu' => 'Menú principal'));

}
add_action('after_setup_theme', 'init_template'); 

function assets(){
  wp_register_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css', '', '4.4.1', 'all');
  wp_register_style('montserrat','https://fonts.googleapis.com/css?family=Montserrat&display=swap',false,'','all');
 
  wp_enqueue_style('styles', get_stylesheet_uri(), array('bootstrap', 'montserrat'), '1.0', 'all');
  
  wp_register_script('popper','https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js','','1.16.0',true);
  wp_enqueue_script('bootstraps','https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array('jquery','pooper'),'4.4.1',true);

  wp_enqueue_script( 'custom', get_template_directory_uri().'/assets/js/custom.js', array('jquery'), '1.1', true);
  wp_localize_script( 'custom', 'bn', array('ajaxurl' => admin_url('admin-ajax.php')));
 
}

add_action('wp_enqueue_scripts', 'assets');

function sidebar(){
  register_sidebar(
    array(
      'name' => 'pie de página',
      'id' => 'footer',
      'description' => 'zona de widgets para pie de página',
      'before_title' => '<p>',
      'after_title' => '<p>',
      'before_widget' => '<div id="%1$s"  class="%2$s"',
      'after_widget' => '</div>'
    )
    );

}
add_action('widgets_init','sidebar');

function productos_type(){
  $labels = array(
    'name' => 'productos',
    'singular_name' => 'producto',
    'menu_name' => 'productos',
    
  );
  $args = array(
    'label' => 'productos',
    'description' => 'productos bnatural',
    'labels' => 'labels',
    'supports' => array('title','editor','thumbnail','revisions'),
    'public' =>  true,
    'show_in_menu' => true,
    'menu_position' => 5,
    'menu_icon' => 'dashicons-cart',
    'can_export' => true,
    'publicly_queryable' =>true,
    'rewrite' => true,
    'show_in_rest' => true,

);
  
 
register_post_type('producto',$args);

}
add_action('init','productos_type');?>


<?php 
add_action( 'init', 'RegisterTax');
function RegisterTax(){

  $args= array(
    'hierarchical'  => true,
     'labels'  => array(
       'name' => 'categorías de productos',
       'singular_name' => 'Categoría'
     ),
     'show_in_nav_menu' => true,
     'show_admin_column' => true,
     'rewrite' => array('slug' => 'categoria-productos'));
  register_taxonomy('categoria-productos', array('producto'),$args);
};


add_action( "wp_ajax_nopriv_filtroProductos","bnFiltroProductos");
add_action( "wp_ajax_filtroProductos","bnFiltroProductos" );
function bnFiltroProductos(){
  $args = array(
    'post_type' => 'producto',
    'posts_per_page' => -1,
    'order'     => 'ASC',
    'orderby' => 'title',
    'tax_query' => array(
        array(
            'taxonomy' => 'categoria-productos',
            'field' => 'slug',
            'terms' => $_POST['categoria']
        )
    )
);
$productos = new WP_Query($args);


if ($productos->have_posts()) 
$return = array();{
    while($productos->have_posts()){
        $productos->the_post();
        $return[] = array(
            'imagen' => get_the_post_thumbnail(get_the_ID(), 'large'),
            'link' => get_permalink(),
            'titulo' => get_the_title()
        );
    }
}

wp_send_json($return);
};



?>