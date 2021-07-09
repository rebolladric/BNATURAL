<?php get_header(); ?>

<main class="container my-5">
    <?php  
        if(have_posts(  )){
            while(have_posts(  )){
                the_post();
            }
        };  
    ?>
    <h1 class="my-3">
        <?php  ?></h1>
    <?php the_content() ?>
 
   <!-- Aquí comenzamos la grilla de productos -->        

   <div class="lista-productos my-5">
            <h2 class="text-center">PRODUCTOS</h2>
            <!--Aqui ponemos un row para construir el filtro de productos-->
            <div class="row">
            <div class="col-12">
            <select class="form-control"   
             name="categoria-productos" 
             id="categorias-productos">
            <option value="">Todas las categorias</option>
            <?php $terms = get_terms('categoria-productos',['hide_empty' => true]) ?>
            <?php foreach ($terms as $term): ?>
                <option value="<?php echo $term->slug?>">
                    <?php echo $term->name ?>
                </option>
            <?php endforeach; ?> 
        </select>          
        
        </div>
        </div>

    
    
        
  
    <div class='row' id='resultado-productos'>
        <?php
        $args= array(
            'posts_per_page' => '3',
            'post_type' => 'producto',
            'order' => 'ASC',
            'order_by' => 'title',
        );

        $productos = new WP_Query($args);

        if($productos->have_posts());{
            while($productos->have_posts()){
                $productos->the_post();
                ?>

            <div class= 'col-4'>
                <figure>
                <?php the_post_thumbnail('large');?>
                </figure>
                <h4 class="my-3 text-center">
                <a href="<?php the_permalink();?>"><?php the_title();?></a>
                </h4>
                
            
            </div>
          
         <?php   } 
            } 
        ?>   
   
    </div>
    </div>
  
    
    
</main>


<?php get_footer();?>