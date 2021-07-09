<?php get_header(); ?>


<main class="container my-3">
<?php if(have_posts(  )){
        while(have_posts(  )){
            the_post( );
        }
    }
?>

    <h1 class='my-5'>
         <?php the_title( )?>
    </h1>
   

    <div class='row'>

        <div class='col-6'>
            <?php the_post_thumbnail('Thumbnail');?>
        </div>

        <div class='col-6'>
            <?php the_content( ); ?>
            
        </div>
        
    </div>

    <?php get_template_part('template-parts/post','navigation');?>  

    
<?php 
    $ID_producto_actual = get_the_ID(); 
    $args = array(
    'post_type'          => 'producto',
    'posts_per_page'     => 6,
    'order'              => 'ASC',
    'orderby'            => 'title'
    );
   
    $productos = new WP_Query($args);
?>

<?php if($productos->have_posts()){?>
     <div class="row justify-content-center productos-relacionados">
     <div class= "col-12">
        <h3 class="my-3 text-center">Productos relacionados</h3>
     </div>
    <?php  while($productos->have_posts( )){?>
        <?php $productos->the_post(); ?>
        <?php if(get_the_ID() != $ID_producto_actual) { ?>     
           
            <div class="col-2 my-3 text-center">
                <?php the_post_thumbnail('thumbnail');?>
                <h4>
                    <a href="<?php the_permalink();?>">
                    <?php the_title();?>
                    </a>
                </h4>
            </div>
        <?php };?>
   <?php };?>
    
  </div>  
   <?php };?>  
</main>


<?php get_footer();?>